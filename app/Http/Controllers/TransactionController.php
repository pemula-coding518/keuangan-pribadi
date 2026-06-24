<?php

namespace App\Http\Controllers;

// Import Model
use App\Models\Transaction;
use App\Models\Category;

// Import Request
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;


class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Menampilkan Data
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Keyword pencarian
        $search = $request->search;

        /*
        |--------------------------------------------------------------------------
        | Data transaksi
        |--------------------------------------------------------------------------
        */

       $transactions = Transaction::query()
    ->with([
        'category:id,name'
    ])
    ->when($search, function ($query) use ($search) {
        $query->where('title', 'like', '%' . $search . '%');
    })
    ->latest()
    ->paginate(5);

        /*
        |--------------------------------------------------------------------------
        | Total Keseluruhan
        |--------------------------------------------------------------------------
        */

        $totalIncome = Transaction::where('type', 'pemasukan')
            ->sum('amount');

        $totalExpense = Transaction::where('type', 'pengeluaran')
            ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Mingguan
        |--------------------------------------------------------------------------
        */

        $weeklyIncome = Transaction::where('type', 'pemasukan')
            ->whereBetween('transaction_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->sum('amount');

        $weeklyExpense = Transaction::where('type', 'pengeluaran')
            ->whereBetween('transaction_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Bulanan
        |--------------------------------------------------------------------------
        */

        $monthlyIncome = Transaction::where('type', 'pemasukan')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $monthlyExpense = Transaction::where('type', 'pengeluaran')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Ringkasan Tahunan
        |--------------------------------------------------------------------------
        */

        $yearlyIncome = Transaction::where('type', 'pemasukan')
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $yearlyExpense = Transaction::where('type', 'pengeluaran')
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

            $chartData = DB::table('transactions')
    ->selectRaw("
        MONTH(transaction_date) as month_number,
        DATE_FORMAT(transaction_date, '%b') as month,
        SUM(CASE WHEN type = 'pemasukan' THEN amount ELSE 0 END) as pemasukan,
        SUM(CASE WHEN type = 'pengeluaran' THEN amount ELSE 0 END) as pengeluaran
    ")
    ->groupByRaw("
        MONTH(transaction_date),
        DATE_FORMAT(transaction_date, '%b')
    ")
    ->orderBy('month_number')
    ->get();

    $expenseByCategory = DB::table('transactions')
    ->join(
        'categories',
        'transactions.category_id',
        '=',
        'categories.id'
    )
    ->where('transactions.type', 'pengeluaran')
    ->selectRaw('
        categories.name as category,
        SUM(transactions.amount) as total
    ')
    ->groupBy('categories.name')
    ->orderByDesc('total')
    ->get();

        return view('transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'balance',
            'weeklyIncome',
            'weeklyExpense',
            'monthlyIncome',
            'monthlyExpense',
            'yearlyIncome',
            'yearlyExpense',
            'chartData',
            'expenseByCategory',
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Export CSV
    |--------------------------------------------------------------------------
    | Catatan perbaikan:
    | - "Tanggal" sekarang pakai transaction_date (bukan created_at)
    | - "Jenis" sekarang pakai $transaction->type (bukan $transaction->category->type)
    | - category->name dibuat null-safe untuk jaga-jaga data lama tanpa kategori
    | - Tambah kolom "Deskripsi" supaya bisa roundtrip penuh dengan import
    */

    public function export()
{
    $fileName = 'transaksi.csv';

    $transactions = Transaction::with('category')->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$fileName",
    ];

    $callback = function () use ($transactions) {

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Tanggal',
            'Judul',
            'Kategori',
            'Jenis',
            'Jumlah',
            'Deskripsi',
        ]);

        foreach ($transactions as $transaction) {

            fputcsv($file, [
                $transaction->transaction_date,
                $transaction->title,
                $transaction->category->name ?? '-',
                $transaction->type,
                $transaction->amount,
                $transaction->description,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    /*
    |--------------------------------------------------------------------------
    | Import CSV
    |--------------------------------------------------------------------------
    | Menerima file CSV (format header fleksibel, lihat mapCsvHeaders()),
    | lalu membuat banyak transaksi sekaligus. Kategori yang belum ada bisa
    | dibuat otomatis lewat checkbox di form (auto_create_category).
    */

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'csv_file.required' => 'Pilih file CSV terlebih dahulu.',
            'csv_file.mimes'    => 'File harus berformat CSV.',
            'csv_file.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $autoCreateCategory = $request->boolean('auto_create_category');

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');

        if ($handle === false) {
            return back()->with('error', 'File tidak bisa dibaca.');
        }

        $headerRow = fgetcsv($handle);

        if (!$headerRow) {
            fclose($handle);
            return back()->with('error', 'File CSV kosong atau format tidak valid.');
        }

        $headerMap = $this->mapCsvHeaders($headerRow);

        $required = ['title', 'type', 'category', 'amount', 'transaction_date'];
        $missing  = array_diff($required, array_keys($headerMap));

        if (!empty($missing)) {
            fclose($handle);
            return back()->with(
                'error',
                'Kolom CSV tidak lengkap. Pastikan ada kolom: Tanggal, Judul, Kategori, Jenis, Jumlah.'
            );
        }

        $imported = 0;
        $skipped  = [];
        $rowNum   = 1; // baris 1 = header

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;

                if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                    continue; // lewati baris kosong
                }

                $data = [];
                foreach ($headerMap as $field => $index) {
                    $data[$field] = $row[$index] ?? null;
                }

                $title        = trim((string) ($data['title'] ?? ''));
                $typeRaw      = strtolower(trim((string) ($data['type'] ?? '')));
                $amountRaw    = trim((string) ($data['amount'] ?? ''));
                $dateRaw      = trim((string) ($data['transaction_date'] ?? ''));
                $categoryName = trim((string) ($data['category'] ?? ''));
                $description  = trim((string) ($data['description'] ?? ''));

                // Transaction->type pakai Indonesia, tapi export lama sempat
                // menulis nilai Category->type (Inggris) di kolom ini — jadi
                // dua-duanya diterima di sini.
                $type = match (true) {
                    in_array($typeRaw, ['pemasukan', 'income', 'masuk']) => 'pemasukan',
                    in_array($typeRaw, ['pengeluaran', 'expense', 'keluar']) => 'pengeluaran',
                    default => null,
                };

                if ($title === '' || $type === null || $amountRaw === '' || $dateRaw === '' || $categoryName === '') {
                    $skipped[] = "Baris {$rowNum}: data wajib tidak lengkap (judul/jenis/kategori/jumlah/tanggal).";
                    continue;
                }

                $amount = (float) preg_replace('/[^0-9.\-]/', '', str_replace(',', '', $amountRaw));

                if ($amount <= 0) {
                    $skipped[] = "Baris {$rowNum}: jumlah tidak valid ({$amountRaw}).";
                    continue;
                }

                try {
                    $date = \Carbon\Carbon::parse($dateRaw)->format('Y-m-d');
                } catch (\Exception $e) {
                    $skipped[] = "Baris {$rowNum}: tanggal tidak valid ({$dateRaw}).";
                    continue;
                }

                // Transaction->type Indonesia, Category->type Inggris — dikonversi di sini.
                $categoryType = $type === 'pemasukan' ? 'income' : 'expense';

                $category = Category::whereRaw('LOWER(name) = ?', [strtolower($categoryName)])->first();

                if (!$category) {
                    if ($autoCreateCategory) {
                        $category = Category::create([
                            'name' => $categoryName,
                            'type' => $categoryType,
                        ]);
                    } else {
                        $skipped[] = "Baris {$rowNum}: kategori '{$categoryName}' tidak ditemukan.";
                        continue;
                    }
                }

                Transaction::create([
                    'title'            => $title,
                    'type'             => $type,
                    'category_id'      => $category->id,
                    'amount'           => $amount,
                    'transaction_date' => $date,
                    'description'      => $description ?: null,
                ]);

                $imported++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }

        fclose($handle);

        return back()
            ->with('success', "Berhasil mengimpor {$imported} transaksi.")
            ->with('import_skipped', $skipped);
    }

    /*
    |--------------------------------------------------------------------------
    | Template CSV untuk import
    |--------------------------------------------------------------------------
    */

    public function importTemplate()
    {
        $headers = ['Tanggal', 'Judul', 'Kategori', 'Jenis', 'Jumlah', 'Deskripsi'];
        $sample  = ['2026-06-01', 'Gaji Bulanan', 'Gaji', 'Pemasukan', '5000000', 'Gaji bulan Juni'];

        $callback = function () use ($headers, $sample) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fputcsv($handle, $sample);
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-import-transaksi.csv"',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper: memetakan header CSV (fleksibel ID/EN) ke nama field internal
    |--------------------------------------------------------------------------
    */

    private function mapCsvHeaders(array $headerRow): array
    {
        $synonyms = [
            'title'            => ['judul', 'title', 'nama'],
            'type'             => ['jenis', 'type', 'tipe'],
            'category'         => ['kategori', 'category'],
            'amount'           => ['jumlah', 'amount', 'nominal'],
            'transaction_date' => ['tanggal', 'date', 'tanggal transaksi'],
            'description'      => ['deskripsi', 'description', 'catatan'],
        ];

        $map = [];

        foreach ($headerRow as $index => $rawHeader) {
            $clean = strtolower(trim($rawHeader));

            foreach ($synonyms as $field => $aliases) {
                if (in_array($clean, $aliases, true)) {
                    $map[$field] = $index;
                    break;
                }
            }
        }

        return $map;
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Laporan
    |--------------------------------------------------------------------------
    */

    public function report($period)
    {
        switch ($period) {

            case 'weekly':

                $transactions = Transaction::with('category')
                    ->whereBetween('transaction_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])
                    ->latest()
                    ->get();

                $title = 'Laporan Mingguan';

                break;

            case 'monthly':

                $transactions = Transaction::with('category')
                    ->whereMonth('transaction_date', now()->month)
                    ->whereYear('transaction_date', now()->year)
                    ->latest()
                    ->get();

                $title = 'Laporan Bulanan';

                break;

            case 'yearly':

                $transactions = Transaction::with('category')
                    ->whereYear('transaction_date', now()->year)
                    ->latest()
                    ->get();

                $title = 'Laporan Tahunan';

                break;

            default:

                abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik Laporan
        |--------------------------------------------------------------------------
        */

        $income = $transactions
            ->where('type', 'pemasukan')
            ->sum('amount');

        $expense = $transactions
            ->where('type', 'pengeluaran')
            ->sum('amount');

        $balance = $income - $expense;

        return view('transactions.report', compact(
            'transactions',
            'title',
            'income',
            'expense',
            'balance'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Data
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::all();

        return view(
            'transactions.create',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Data
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required',
            'type'             => 'required',
            'category_id'      => 'required',
            'amount'           => 'required|numeric',
            'transaction_date' => 'required',
        ]);

        Transaction::create([
            'title'            => $request->title,
            'type'             => $request->type,
            'category_id' => $request->category_id,
            'amount'           => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description'      => $request->description,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Edit
    |--------------------------------------------------------------------------
    */

    public function edit(Transaction $transaction)
    {
        $transaction->load('category');

        $categories = Category::all();

        return view('transactions.edit', [
            'transaction' => $transaction,
            'categories' => $categories
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Data
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'title'            => 'required',
            'type'             => 'required',
            'category_id'      => 'required',
            'amount'           => 'required|numeric',
            'transaction_date' => 'required',
        ]);

        $transaction->update([
            'title'            => $request->title,
            'type'             => $request->type,
            'category_id' => $request->category_id,
            'amount'           => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description'      => $request->description,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Data
    |--------------------------------------------------------------------------
    */

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Data berhasil dihapus');
    }



}
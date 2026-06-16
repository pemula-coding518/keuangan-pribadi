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
            'Jumlah'
        ]);

        foreach ($transactions as $transaction) {

            fputcsv($file, [
                $transaction->created_at,
                $transaction->title,
                $transaction->category->name,
                $transaction->category->type,
                $transaction->amount,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
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
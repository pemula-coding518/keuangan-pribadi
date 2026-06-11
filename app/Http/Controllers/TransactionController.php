<?php

namespace App\Http\Controllers;

// Import model
use App\Models\Transaction;
use App\Models\Category;

// Import request
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Menampilkan Data
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Mengambil keyword search
        $search = $request->search;

        /*
        |--------------------------------------------------------------------------
        | Query transaksi
        |--------------------------------------------------------------------------
        */

        $transactions = Transaction::with('category')

            // Jika ada pencarian
            ->when($search, function ($query) use ($search) {

                // Cari berdasarkan title
                $query->where('title', 'like', "%{$search}%");
            })

            // Urut terbaru
            ->latest()


            // Pagination
            ->paginate(5);

        /*
        |--------------------------------------------------------------------------
        | Menghitung total pemasukan
        |--------------------------------------------------------------------------
        */

        $totalIncome = Transaction::whereHas('category', function ($query) {

            $query->where('type', 'income');

        })->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Menghitung total pengeluaran
        |--------------------------------------------------------------------------
        */

        $totalExpense = Transaction::whereHas('category', function ($query) {

            $query->where('type', 'expense');

        })->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | Menghitung saldo
        |--------------------------------------------------------------------------
        */

        $balance = $totalIncome - $totalExpense;
        /*
|--------------------------------------------------------------------------
| RINGKASAN MINGGUAN
|--------------------------------------------------------------------------
*/

        $weeklyIncome = Transaction::where('type', 'pemasukan')
            ->whereBetween(
                'transaction_date',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]
            )
            ->sum('amount');

        $weeklyExpense = Transaction::where('type', 'pengeluaran')
            ->whereBetween(
                'transaction_date',
                [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]
            )
            ->sum('amount');

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN BULANAN
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
        | RINGKASAN TAHUNAN
        |--------------------------------------------------------------------------
        */

        $yearlyIncome = Transaction::where('type', 'pemasukan')
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $yearlyExpense = Transaction::where('type', 'pengeluaran')
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        // Kirim data ke view
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
            'yearlyExpense'
        ));
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
        ->whereBetween(
            'transaction_date',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )
        ->latest()
        ->get();

    $title = 'Laporan Mingguan';

    break;

            case 'monthly':

                $transactions = Transaction::with('category')
                    ->whereMonth(
                        'transaction_date',
                        now()->month
                    )
                    ->whereYear(
                        'transaction_date',
                        now()->year
                    )
                    ->latest()
                    ->get();

                $title = 'Laporan Bulanan';

                break;

            case 'yearly':

                $transactions = Transaction::with('category')
                    ->whereYear(
                        'transaction_date',
                        now()->year
                    )
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

        return view(
            'transactions.report',
            compact(
                'transactions',
                'title',
                'income',
                'expense',
                'balance'
            )
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Form tambah data
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
        // Validasi input
        $request->validate([

            'title' => 'required',

            'type' => 'required',

            'category_id' => 'required',

            'amount' => 'required|numeric',

            'transaction_date' => 'required',

        ]);

        // Simpan data transaksi
        Transaction::create([

            'title' => $request->title,

            'type' => $request->type,

            'category_id' => $request->category_id,

            'amount' => $request->amount,

            'transaction_date' => $request->transaction_date,

            'description' => $request->description,

        ]);

        // Redirect kembali
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
        // Ambil semua kategori
        $categories = Category::all();

        // Kirim data transaksi + kategori ke halaman edit
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

    // Mengupdate data transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([

            'title' => 'required',

            'type' => 'required',

            'category_id' => 'required',

            'amount' => 'required|numeric',

            'transaction_date' => 'required',

        ]);

        $transaction->update([

            'title' => $request->title,

            'type' => $request->type,

            'category_id' => $request->category_id,

            'amount' => $request->amount,

            'transaction_date' => $request->transaction_date,

            'description' => $request->description,

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
        // Hapus transaksi
        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
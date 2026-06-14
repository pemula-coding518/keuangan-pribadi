<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pemasukan
        $income = Transaction::where('type', 'income')
            ->sum('amount');

        // Total pengeluaran
        $expense = Transaction::where('type', 'expense')
            ->sum('amount');

        // Saldo
        $balance = $income - $expense;

        // Jumlah transaksi
        $transactionCount = Transaction::count();

        // Transaksi terbaru
        $latestTransactions = Transaction::latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'income',
            'expense',
            'balance',
            'transactionCount',
            'latestTransactions'
        ));
    }
}
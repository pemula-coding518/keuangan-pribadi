<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index()
{
    $categories = Category::withCount('transactions')
        ->withSum('transactions', 'amount')
        ->get();

    $totalTransactions = $categories->sum('transactions_count');

    $topExpense = $categories
        ->where('type', 'expense')
        ->sortByDesc('transactions_sum_amount')
        ->first();

    $topIncome = $categories
        ->where('type', 'income')
        ->sortByDesc('transactions_sum_amount')
        ->first();

    return view(
        'categories.index',
        compact(
            'categories',
            'totalTransactions',
            'topExpense',
            'topIncome'
        )
    );
}

public function show(Category $category)
{
    $transactions = $category->transactions()
        ->latest()
        ->paginate(10);

    $totalAmount = $category->transactions()
        ->sum('amount');

    $totalTransactions = $category->transactions()
        ->count();

    return view(
        'categories.show',
        compact(
            'category',
            'transactions',
            'totalAmount',
            'totalTransactions'
        )
    );
}

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
    
}
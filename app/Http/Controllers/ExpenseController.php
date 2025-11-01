<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ledger;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('ledger')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $ledgers = Ledger::all();
        return view('expenses.create', compact('ledgers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ledger_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense recorded!');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $ledgers = Ledger::all();
        return view('expenses.edit', compact('expense', 'ledgers'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'ledger_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Account;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function index()
    {
        $ledgers = Ledger::with('account')->paginate(10);
        return view('ledgers.index', compact('ledgers'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('ledgers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required',
            'entry_date' => 'required|date',
            'description' => 'nullable|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);

        Ledger::create($validated);

        return redirect()->route('ledgers.index')->with('success', 'Ledger entry created!');
    }

    public function show(Ledger $ledger)
    {
        return view('ledgers.show', compact('ledger'));
    }

    public function edit(Ledger $ledger)
    {
        $accounts = Account::all();
        return view('ledgers.edit', compact('ledger', 'accounts'));
    }

    public function update(Request $request, Ledger $ledger)
    {
        $validated = $request->validate([
            'account_id' => 'required',
            'entry_date' => 'required|date',
            'description' => 'nullable|string',
            'debit' => 'nullable|numeric',
            'credit' => 'nullable|numeric',
        ]);

        $ledger->update($validated);

        return redirect()->route('ledgers.index')->with('success', 'Ledger updated!');
    }

    public function destroy(Ledger $ledger)
    {
        $ledger->delete();
        return redirect()->route('ledgers.index')->with('success', 'Ledger deleted!');
    }
}

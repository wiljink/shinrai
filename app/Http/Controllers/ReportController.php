<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Collection;
use App\Models\Commission;
use App\Models\Expense;
use App\Models\Incentive;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss()
    {
        $totalSales = Sale::sum('amount');
        $totalCollections = Collection::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalCollections - $totalExpenses;

        return view('reports.profit_loss', compact('totalSales', 'totalCollections', 'totalExpenses', 'netProfit'));
    }

    public function salesReport()
    {
        $sales = Sale::with(['property', 'agent'])->get();
        return view('reports.sales', compact('sales'));
    }

    public function receivableReport()
    {
        $sales = Sale::with('collections')->get();
        return view('reports.receivables', compact('sales'));
    }

    public function commissionReport()
    {
        $commissions = Commission::with(['sale', 'agent'])->get();
        return view('reports.commissions', compact('commissions'));
    }

    public function expenseReport()
    {
        $expenses = Expense::all();
        return view('reports.expenses', compact('expenses'));
    }

    public function incentiveReport()
    {
        $incentives = Incentive::with('agent')->get();
        return view('reports.incentives', compact('incentives'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Sale;
use App\Models\Collection;
use App\Models\User;
use App\Models\Commission;
use App\Models\Incentive;
use App\Models\Account;
use App\Models\Ledger;
use App\Models\Expense;

class DashboardController extends Controller
{
    // Admin Dashboard
    public function admin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $totalRegistrations = User::whereIn('role', ['sales_manager', 'sales_agent'])->count();
        $totalBuyers = User::where('role', 'buyer')->count();
        $totalProperties = Property::count();
        $totalSales = Sale::count();
        $totalCollections = Collection::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalIncentives = Incentive::sum('amount');

        return view('dashboard.admin', compact(
            'totalRegistrations',
            'totalBuyers',
            'totalProperties',
            'totalSales',
            'totalCollections',
            'totalExpenses',
            'totalIncentives'
        ));
    }

    // Sales Manager Dashboard
    public function salesManager()
    {
        if (!auth()->check() || auth()->user()->role !== 'sales_manager') {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();

        // Example stats for testing
        $totalSales = Sale::where('manager_id', $user->id)->count(); // assumes you have manager_id in sales
        $totalCollections = Collection::where('manager_id', $user->id)->sum('amount');
        $totalProperties = Property::where('manager_id', $user->id)->count();

        return view('dashboards.sales_manager', compact(
            'totalSales',
            'totalCollections',
            'totalProperties'
        ));
    }

    // Sales Agent Dashboard
    public function salesAgent()
    {
        if (!auth()->check() || auth()->user()->role !== 'sales_agent') {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();

        $assignedSales = Sale::where('agent_id', $user->id)->count();
        $assignedProperties = Property::where('agent_id', $user->id)->count();
        $assignedCollections = Collection::where('agent_id', $user->id)->sum('amount');
        $assignedIncentives = Incentive::where('agent_id', $user->id)->sum('amount');

        return view('dashboards.sales_agent', compact(
            'assignedSales',
            'assignedProperties',
            'assignedCollections',
            'assignedIncentives'
        ));
    }
}

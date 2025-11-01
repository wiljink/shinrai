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

        $totalAgents = User::where('role', 'agent')->count();
        $totalProperties = Property::count();
        $totalSales = Sale::count();
        $totalCollections = Collection::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalIncentives = Incentive::sum('amount'); // 👈 add this line

        return view('dashboard.admin', compact(
            'totalAgents',
            'totalProperties',
            'totalSales',
            'totalCollections',
            'totalExpenses',
            'totalIncentives' // 👈 and include it here
        ));
    }

    public function agent()
    {
        if (!auth()->check() || auth()->user()->role !== 'agent') {
            abort(403, 'Unauthorized.');
        }

        $user = auth()->user();

        $myProperties = Property::where('agent_id', $user->id)->count();
        $mySales = Sale::where('agent_id', $user->id)->count();
        $myCollections = Collection::where('agent_id', $user->id)->sum('amount');
        $myCommissions = Commission::where('agent_id', $user->id)->sum('amount');
        $myIncentives = Incentive::where('agent_id', $user->id)->sum('amount');

        return view('dashboard.agent', compact(
            'myProperties',
            'mySales',
            'myCollections',
            'myCommissions',
            'myIncentives'
        ));
    }
}

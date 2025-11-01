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
        // Only admin can access
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Combine agents + brokers
        $totalRegistrations = User::whereIn('role', ['agent', 'broker'])->count();

        // Count buyers separately
        $totalBuyers = User::where('role', 'buyer')->count();

        // Other stats
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

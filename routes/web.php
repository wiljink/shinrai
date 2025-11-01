<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AgentController;

// ================================
// Public / Landing Page
// ================================
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('agent.dashboard');
    }
    return view('welcome'); // 👈 Show the new welcome.blade.php
})->name('welcome');


// ================================
// Guest Routes (Unauthenticated Users)
// ================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    // Registration (Fixed ✅)
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});


// ================================
// Logout (accessible to authenticated users)
// ================================
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// ================================
// Protected Routes (Authenticated Users Only)
// ================================
Route::middleware(['auth'])->group(function () {

    // Branches
    Route::resource('branches', BranchController::class);

    // Properties
    Route::resource('properties', PropertyController::class);

    // Projects
    Route::resource('projects', ProjectController::class);

    // Sales
    Route::resource('sales', SaleController::class);

    // Collections
    Route::resource('collections', CollectionController::class);

    // Commissions
    Route::resource('commissions', CommissionController::class);

    // Incentives
    Route::resource('incentives', IncentiveController::class);

    // Accounts & Ledgers
    Route::resource('accounts', AccountController::class);
    Route::resource('ledgers', LedgerController::class);

    // Expenses
    Route::resource('expenses', ExpenseController::class);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profitLoss');
    Route::get('reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('reports/receivables', [ReportController::class, 'receivableReport'])->name('reports.receivables');
    Route::get('reports/commissions', [ReportController::class, 'commissionReport'])->name('reports.commissions');
    Route::get('reports/expenses', [ReportController::class, 'expenseReport'])->name('reports.expenses');
    Route::get('reports/incentives', [ReportController::class, 'incentivesReport'])->name('reports.incentives');

    // Dashboards
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');

    // ✅ Admin: View all agents for approval

    Route::get('/admin/agents', [AgentController::class, 'index'])->name('admin.agents.index');
    // ✅ Admin: View all agents
    Route::get('/admin/agents', [AgentController::class, 'index'])->name('admin.agents.index');

    // ✅ Admin: Approve a specific agent
    Route::post('/admin/agents/{id}/approve', [AgentController::class, 'approve'])->name('agents.approve');
    Route::post('/admin/agents/{id}/reject', [AgentController::class, 'reject'])->name('agents.reject');
    // Fallback for undefined routes
    Route::fallback(function () {
        return redirect()->route('login');
    });
});


// ✅ Always include this at the bottom
require __DIR__ . '/auth.php';

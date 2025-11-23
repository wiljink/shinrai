<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PropertyController,
    SaleController,
    CollectionController,
    CommissionController,
    IncentiveController,
    LedgerController,
    ExpenseController,
    ProjectController,
    BranchController,
    ReportController,
    DashboardController,
    UserController
};
use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    RegisteredUserController
};

/*
|--------------------------------------------------------------------------
| Public Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'sales_manager' => redirect()->route('sales_manager.dashboard'),
            'sales_agent' => redirect()->route('sales_agent.dashboard'),
            default => redirect()->route('login')
        };
    }
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Resources
    Route::resource('properties', PropertyController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('collections', CollectionController::class);
    Route::resource('commissions', CommissionController::class);
    Route::resource('incentives', IncentiveController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('users', UserController::class);

    // Ledgers
    Route::get('ledgers', [LedgerController::class, 'index'])->name('ledgers.index');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('profit-loss', [ReportController::class, 'profitLoss'])->name('profitLoss');
        Route::get('sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('receivables', [ReportController::class, 'receivables'])->name('receivables');
        Route::get('commissions', [ReportController::class, 'commissions'])->name('commissions');
        Route::get('expenses', [ReportController::class, 'expenses'])->name('expenses');
        Route::get('incentives', [ReportController::class, 'incentives'])->name('incentives');
    });
});

/*
|--------------------------------------------------------------------------
| Sales Manager Routes
|--------------------------------------------------------------------------
*/
Route::prefix('sales-manager')->name('sales_manager.')->middleware(['auth', 'role:sales_manager'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'salesManager'])->name('dashboard');

    Route::resource('properties', PropertyController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('collections', CollectionController::class);
    Route::resource('commissions', CommissionController::class);
    Route::resource('incentives', IncentiveController::class);
});

/*
|--------------------------------------------------------------------------
| Sales Agent Routes
|--------------------------------------------------------------------------
*/
Route::prefix('sales-agent')->name('sales_agent.')->middleware(['auth', 'role:sales_agent'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'salesAgent'])->name('dashboard');

    Route::resource('properties', PropertyController::class)->only(['index', 'show']);
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
    Route::resource('collections', CollectionController::class)->only(['index', 'show']);
    Route::resource('commissions', CommissionController::class)->only(['index', 'show']);
    Route::resource('incentives', IncentiveController::class)->only(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => redirect()->route('login'));

require __DIR__ . '/auth.php';

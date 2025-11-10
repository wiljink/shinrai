<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    PropertyController,
    SaleController,
    CollectionController,
    CommissionController,
    IncentiveController,
    AccountController,
    BranchController,
    LedgerController,
    ProjectController,
    ExpenseController,
    ReportController,
    DashboardController,
    AgentController,
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
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('agent.dashboard');
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
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

        // ✅ Commissions (Admin Only)
        Route::resource('commissions', CommissionController::class);
    });


/*
|--------------------------------------------------------------------------
| Agent Only Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:agent'])->group(function () {

    Route::get('/agent/dashboard', [DashboardController::class, 'agent'])->name('agent.dashboard');

});

/*
|--------------------------------------------------------------------------
| Shared Resources (Admin + Agent)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::resources([
        'properties' => PropertyController::class,
        'sales' => SaleController::class,
        'collections' => CollectionController::class,
        'commissions' => CommissionController::class,
        'incentives' => IncentiveController::class,
        'ledgers' => LedgerController::class,
        'expenses' => ExpenseController::class,
        'projects' => ProjectController::class,
        'branches' => BranchController::class,
        'accounts' => AccountController::class,
    ]);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profitLoss');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/receivables', [ReportController::class, 'receivableReport'])->name('receivables');
        Route::get('/commissions', [ReportController::class, 'commissionReport'])->name('commissions');
        Route::get('/expenses', [ReportController::class, 'expenseReport'])->name('expenses');
        Route::get('/incentives', [ReportController::class, 'incentivesReport'])->name('incentives');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(fn () => redirect()->route('login'));

require __DIR__ . '/auth.php';

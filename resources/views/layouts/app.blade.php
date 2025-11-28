<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinrai Real Estate System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <style>
        body { min-height: 100vh; display: flex; }
        .sidebar { width: 250px; background-color: #343a40; color: white; flex-shrink: 0; transition: all 0.3s; }
        .sidebar a { color: #ddd; text-decoration: none; display: block; padding: 12px 20px; }
        .sidebar a:hover, .sidebar a.active { background-color: #495057; color: #fff; }
        .sidebar.collapsed { margin-left: -250px; }
        .content { flex-grow: 1; padding: 20px; transition: margin-left 0.3s; }
        .toggle-btn { position: fixed; top: 15px; left: 15px; z-index: 1000; border: none; background: #343a40; color: white; padding: 8px 12px; border-radius: 4px; }
        .topbar-buttons { display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="p-3 border-bottom text-white fw-bold text-center">Shinrai</h4>

    @php
        $role = auth()->user()->role ?? null;
    @endphp

    {{-- ADMIN MENU --}}
    @if($role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.properties.index') }}"><i class="bi bi-building"></i> Properties</a>
        <a href="{{ route('admin.sales.index') }}"><i class="bi bi-cart-check"></i> Sales</a>
        <a href="{{ route('admin.collections.index') }}"><i class="bi bi-cash-stack"></i> Collections</a>
        <a href="{{ route('admin.commissions.index') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
        <a href="{{ route('admin.incentives.index') }}"><i class="bi bi-gift"></i> Incentives</a>
        <a href="{{ route('admin.ledgers.index') }}"><i class="bi bi-journal-text"></i> Ledgers</a>
        <a href="{{ route('admin.expenses.index') }}"><i class="bi bi-receipt"></i> Expenses</a>
        <a href="{{ route('admin.projects.index') }}"><i class="bi bi-diagram-3"></i> Projects</a>
        <a href="{{ route('admin.branches.index') }}"><i class="bi bi-diagram-2"></i> Branches</a>

        {{-- Reports --}}
        <div class="border-top mt-3">
            <h6 class="p-3 text-white">Reports</h6>
            <a href="{{ route('reports.profitLoss') }}"><i class="bi bi-graph-down-arrow"></i> Profit & Loss</a>
            <a href="{{ route('reports.sales') }}"><i class="bi bi-bar-chart"></i> Sales Report</a>
            <a href="{{ route('reports.receivables') }}"><i class="bi bi-wallet2"></i> Receivables</a>
            <a href="{{ route('reports.commissions') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
            <a href="{{ route('reports.expenses') }}"><i class="bi bi-receipt-cutoff"></i> Expenses</a>
            <a href="{{ route('reports.incentives') }}"><i class="bi bi-award"></i> Incentives</a>
        </div>

        {{-- Settings --}}
        <div class="border-top mt-3">
            <h6 class="p-3 text-white">Settings</h6>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'bg-primary text-white' : '' }}">
                <i class="bi bi-people"></i> Manage Accounts
            </a>
        </div>
    @endif

    {{-- SALES MANAGER MENU --}}
    @if($role === 'sales_manager')
        <a href="{{ route('sales_manager.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('sales_manager.properties.index') }}"><i class="bi bi-building"></i> Properties</a>
        <a href="{{ route('sales_manager.sales.index') }}"><i class="bi bi-cart-check"></i> Sales</a>
        <a href="{{ route('sales_manager.collections.index') }}"><i class="bi bi-cash-stack"></i> Collections</a>
        <a href="{{ route('sales_manager.commissions.index') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
        <a href="{{ route('sales_manager.incentives.index') }}"><i class="bi bi-gift"></i> Incentives</a>
        <a href="{{ route('sales_manager.users.index') }}"><i class="fa-solid fa-users"></i> Applicants</a>
    @endif

    {{-- SALES AGENT MENU --}}
    @if($role === 'sales_agent')
        <a href="{{ route('sales_agent.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('sales_agent.properties.index') }}"><i class="bi bi-building"></i> Properties</a>
        <a href="{{ route('sales_agent.sales.index') }}"><i class="bi bi-cart-check"></i> Sales</a>
        <a href="{{ route('sales_agent.collections.index') }}"><i class="bi bi-cash-stack"></i> Collections</a>
        <a href="{{ route('sales_agent.commissions.index') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
        <a href="{{ route('sales_agent.incentives.index') }}"><i class="bi bi-gift"></i> Incentives</a>
    @endif
</div>

<!-- Main Content -->
<div class="content">
    <div class="topbar-buttons">
        <a href="{{ route($role . '.dashboard') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-house-door"></i> Dashboard
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <button class="toggle-btn mb-3" id="toggle-btn"><i class="bi bi-list"></i></button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById("toggle-btn");
    const sidebar = document.getElementById("sidebar");
    toggleBtn.addEventListener("click", () => sidebar.classList.toggle("collapsed"));
</script>

</body>
</html>

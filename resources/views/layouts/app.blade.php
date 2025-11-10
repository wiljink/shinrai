<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shinrai Real Estate System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
            transition: all 0.3s;
        }
        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .sidebar.collapsed {
            margin-left: -250px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            border: none;
            background: #343a40;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
        }
        .topbar-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="p-3 border-bottom text-white fw-bold text-center">Shinrai</h4>

    @php
        $role = auth()->user()->role ?? null;
    @endphp

    {{-- ================= ADMIN MENU ================= --}}
    @if($role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="fw-bold {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('properties.index') }}"><i class="bi bi-building"></i> Properties</a>
        <a href="{{ route('sales.index') }}"><i class="bi bi-cart-check"></i> Sales</a>
        <a href="{{ route('collections.index') }}"><i class="bi bi-cash-stack"></i> Collections</a>
        <a href="{{ route('commissions.index') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
        <a href="{{ route('incentives.index') }}"><i class="bi bi-gift"></i> Incentives</a>
        <a href="{{ route('ledgers.index') }}"><i class="bi bi-journal-text"></i> Ledgers</a>
        <a href="{{ route('expenses.index') }}"><i class="bi bi-receipt"></i> Expenses</a>
        <a href="{{ route('projects.index') }}"><i class="bi bi-diagram-3"></i> Projects</a>
        <a href="{{ route('branches.index') }}"><i class="bi bi-diagram-2"></i> Branches</a>

        <!-- Reports Section -->
        <div class="border-top mt-3">
            <h6 class="p-3 text-white">Reports</h6>
            <a href="{{ route('reports.profitLoss') }}"><i class="bi bi-graph-down-arrow"></i> Profit & Loss</a>
            <a href="{{ route('reports.sales') }}"><i class="bi bi-bar-chart"></i> Sales Report</a>
            <a href="{{ route('reports.receivables') }}"><i class="bi bi-wallet2"></i> Receivables</a>
            <a href="{{ route('reports.commissions') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
            <a href="{{ route('reports.expenses') }}"><i class="bi bi-receipt-cutoff"></i> Expenses</a>
            <a href="{{ route('reports.incentives') }}"><i class="bi bi-award"></i> Incentives</a>
        </div>

     <!-- Settings Section -->
<div class="border-top mt-3">
    <h6 class="p-3 text-white">Settings</h6>

    <!-- Manage Accounts -->
    <a href="{{ route('admin.users.index') }}"
       class="d-block px-3 py-2 {{ request()->routeIs('admin.users.index') ? 'bg-primary text-white' : 'text-white' }}">
        <i class="bi bi-people"></i> Manage Accounts
    </a>

    <a href="{{ route('admin.commissions.index') }}"
   class="d-block px-3 py-2 {{ request()->routeIs('admin.commissions.*') ? 'bg-primary text-white' : 'text-white' }}">
    <i class="bi bi-cash-stack"></i> Manage Commissions
</a>

</div>

    @endif

    {{-- ================= AGENT MENU ================= --}}
    @if($role === 'agent')
        <a href="{{ route('agent.dashboard') }}" class="fw-bold {{ request()->routeIs('agent.dashboard') ? 'bg-primary text-white' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('properties.index') }}"><i class="bi bi-building"></i> Properties</a>
        <a href="{{ route('sales.index') }}"><i class="bi bi-cart-check"></i> Sales</a>
        <a href="{{ route('collections.index') }}"><i class="bi bi-cash-stack"></i> Collections</a>
        <a href="{{ route('commissions.index') }}"><i class="bi bi-cash-coin"></i> Commissions</a>
        <a href="{{ route('incentives.index') }}"><i class="bi bi-gift"></i> Incentives</a>
    @endif
</div>

<!-- Main Content -->
<div class="content" id="content">
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

    toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("collapsed");
    });
</script>
</body>
</html>

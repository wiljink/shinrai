@extends('layouts.app')

@section('content')
    <div class="container mt-4">



        <h2 class="mb-4 fw-bold">
            {{ ucfirst(auth()->user()->role) }} Dashboard
            <small class="text-muted" style="font-size: 1rem;">
                (Role: {{ ucfirst(auth()->user()->role) }})
            </small>
        </h2>

        <!-- Stats Row -->
        <div class="row g-4">
            <!-- Total Registrations (Agents + Brokers) -->
            <div class="col-md-2 col-sm-6">
                <a href="{{ route('admin.agents.index') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 text-center h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-person-plus fs-2 text-primary mb-2"></i>
                            <h6 class="text-muted">Total Registrations</h6>
                            <h3 class="fw-bold">{{ $totalRegistrations }}</h3>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Buyers -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-people fs-2 text-warning mb-2"></i>
                        <h6 class="text-muted">Total Buyers</h6>
                        <h3 class="fw-bold">{{ $totalBuyers }}</h3>
                    </div>
                </div>
            </div>

            <!-- Properties -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-building fs-2 text-success mb-2"></i>
                        <h6 class="text-muted">Properties</h6>
                        <h3 class="fw-bold">{{ $totalProperties ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Sales -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-cart-check fs-2 text-warning mb-2"></i>
                        <h6 class="text-muted">Sales</h6>
                        <h3 class="fw-bold">{{ $totalSales ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- Collections -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-cash-stack fs-2 text-info mb-2"></i>
                        <h6 class="text-muted">Collections</h6>
                        <h3 class="fw-bold">₱{{ number_format($totalCollections ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Expenses -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-receipt fs-2 text-danger mb-2"></i>
                        <h6 class="text-muted">Expenses</h6>
                        <h3 class="fw-bold">₱{{ number_format($totalExpenses ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Incentives -->
            <div class="col-md-2 col-sm-6">
                <div class="card shadow-sm border-0 text-center h-100 hover-card">
                    <div class="card-body">
                        <i class="bi bi-gift fs-2 text-secondary mb-2"></i>
                        <h6 class="text-muted">Incentives</h6>
                        <h3 class="fw-bold">₱{{ number_format($totalIncentives ?? 0, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports Section -->
        <h4 class="mt-5 mb-3 fw-semibold">Reports</h4>

        <div class="row g-4 text-center">
            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.profitLoss') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-graph-down-arrow fs-2 text-danger mb-2"></i>
                            <h6 class="fw-bold">Profit & Loss</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.sales') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-bar-chart fs-2 text-primary mb-2"></i>
                            <h6 class="fw-bold">Sales Report</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.receivables') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-wallet2 fs-2 text-success mb-2"></i>
                            <h6 class="fw-bold">Receivables</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.commissions') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-cash-coin fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold">Commissions</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.expenses') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-receipt-cutoff fs-2 text-danger mb-2"></i>
                            <h6 class="fw-bold">Expenses</h6>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-2 col-sm-6">
                <a href="{{ route('reports.incentives') }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm border-0 h-100 hover-card">
                        <div class="card-body">
                            <i class="bi bi-award fs-2 text-secondary mb-2"></i>
                            <h6 class="fw-bold">Incentives</h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


@endsection

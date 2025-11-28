@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Agent Dashboard</h2>

        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h5>Total Buyers</h5>
                    <h3 class="text-primary">{{ $totalBuyers }}</h3>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h5>Total Properties</h5>
                    <h3 class="text-success">{{ $totalProperties }}</h3>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h5>Total Sales</h5>
                    <h3 class="text-info">{{ $totalSales }}</h3>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h5>Total Collections</h5>
                    <h3 class="text-warning">{{ number_format($totalCollections, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0 text-center p-3">
                    <h5>Total Incentives</h5>
                    <h3 class="text-danger">{{ number_format($totalIncentives, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

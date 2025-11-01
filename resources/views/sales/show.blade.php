@extends('layouts.app')

@section('content')
    <h1>Sale Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Property:</strong> {{ $sale->property->name ?? 'N/A' }}</p>
            <p><strong>Agent:</strong> {{ $sale->agent->name ?? 'N/A' }}</p>
            <p><strong>Buyer:</strong> {{ $sale->buyer }}</p>
            <p><strong>Total Amount:</strong> {{ number_format($sale->total_amount, 2) }}</p>
            <p><strong>Sale Date:</strong> {{ $sale->sale_date }}</p>
        </div>
    </div>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection

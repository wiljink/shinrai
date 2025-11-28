@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Manager Dashboard</h1>
    <p>Total Sales: {{ $totalSales }}</p>
    <p>Total Collections: {{ $totalCollections }}</p>

    <h3>Quick Links</h3>
    <ul>
        <li><a href="{{ route('sales_manager.sales.index') }}">Manage Sales</a></li>
        <li><a href="{{ route('sales_manager.collections.index') }}">Manage Collections</a></li>
        <li><a href="{{ route('sales_manager.properties.index') }}">Manage Properties</a></li>
    </ul>
</div>
@endsection

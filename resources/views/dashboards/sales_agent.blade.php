@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Agent Dashboard</h1>
    <p>Assigned Sales: {{ $assignedSales }}</p>
    <p>Assigned Properties: {{ $assignedProperties }}</p>

    <h3>Quick Links</h3>
    <ul>
        <li><a href="{{ route('sales_agent.sales.index') }}">View Sales</a></li>
        <li><a href="{{ route('sales_agent.properties.index') }}">View Properties</a></li>
    </ul>
</div>
@endsection

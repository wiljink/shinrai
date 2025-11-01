@extends('layouts.app')

@section('content')
    <h1>Sales</h1>
    <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add Sale</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Property</th>
            <th>Agent</th>
            <th>Buyer</th>
            <th>Total Amount</th>
            <th>Sale Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->property->name ?? 'N/A' }}</td>
                <td>{{ $sale->agent->name ?? 'N/A' }}</td>
                <td>{{ $sale->buyer }}</td>
                <td>{{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ $sale->sale_date }}</td>
                <td>
                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this sale?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $sales->links() }}
@endsection

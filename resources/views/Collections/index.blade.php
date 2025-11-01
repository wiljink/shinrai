@extends('layouts.app')
@section('content')
    <h1>Collections</h1>
    <a href="{{ route('collections.create') }}" class="btn btn-primary mb-3">Add Collection</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Sale</th><th>Amount</th><th>Date</th><th>Payment</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($collections as $collection)
            <tr>
                <td>{{ $collection->id }}</td>
                <td>{{ $collection->sale->buyer ?? 'N/A' }}</td>
                <td>{{ number_format($collection->amount,2) }}</td>
                <td>{{ $collection->date }}</td>
                <td>{{ $collection->payment_method }}</td>
                <td>
                    <a href="{{ route('collections.show',$collection) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('collections.edit',$collection) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('collections.destroy',$collection) }}" class="d-inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this collection?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $collections->links() }}
@endsection

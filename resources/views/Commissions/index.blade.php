@extends('layouts.app')
@section('content')
    <h1>Commissions</h1>
    <a href="{{ route('commissions.create') }}" class="btn btn-primary mb-3">Add Commission</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Agent</th><th>Sale</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        @foreach($commissions as $commission)
            <tr>
                <td>{{ $commission->id }}</td>
                <td>{{ $commission->agent->name ?? 'N/A' }}</td>
                <td>{{ $commission->sale->id ?? 'N/A' }}</td>
                <td>{{ number_format($commission->amount,2) }}</td>
                <td>{{ $commission->status }}</td>
                <td>
                    <a href="{{ route('commissions.show',$commission) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('commissions.edit',$commission) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('commissions.destroy',$commission) }}" class="d-inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this commission?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $commissions->links() }}
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ledgers</h1>
        <a href="{{ route('ledgers.create') }}" class="btn btn-primary mb-3">Add Ledger Entry</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Account</th>
                <th>Date</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ledgers as $ledger)
                <tr>
                    <td>{{ $ledger->account->name }}</td>
                    <td>{{ $ledger->transaction_date }}</td>
                    <td>{{ $ledger->type }}</td>
                    <td>{{ $ledger->amount }}</td>
                    <td>{{ $ledger->description }}</td>
                    <td>
                        <a href="{{ route('ledgers.edit', $ledger->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('ledgers.destroy', $ledger->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete ledger entry?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $ledgers->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Incentives</h1>
        <a href="{{ route('incentives.create') }}" class="btn btn-primary mb-3">Add Incentive</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Agent</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($incentives as $inc)
                <tr>
                    <td>{{ $inc->user->name }}</td>
                    <td>{{ $inc->amount }}</td>
                    <td>{{ $inc->type }}</td>
                    <td>{{ $inc->status }}</td>
                    <td>{{ $inc->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('incentives.edit', $inc->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('incentives.destroy', $inc->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete incentive?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $incentives->links() }}
    </div>
@endsection

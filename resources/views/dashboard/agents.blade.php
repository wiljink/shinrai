@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Manage Agents</h2>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($agents as $agent)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $agent->first_name }} {{ $agent->last_name }}</td>
                    <td>{{ $agent->email }}</td>
                    <td>
                        @if ($agent->is_approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if (!$agent->is_approved)
                            <form action="{{ route('agents.approve', $agent->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                        @else
                            <form action="{{ route('agents.reject', $agent->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No agents found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<h2 class="mb-3">Manage Users</h2>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Add User</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Role</th><th>Branch</th><th>Status</th><th>Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $roles[$user->role] ?? ucfirst(str_replace('_', ' ', $user->role)) }}</td>
            <td>{{ $user->branch->name ?? 'N/A' }}</td>

            <td>
                @if($user->is_approved)
                    <span class="badge bg-success">Approved</span>
                @else
                    <span class="badge bg-secondary">Pending</span>
                @endif
            </td>

            <td>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>

                @if(!$user->is_approved)
                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-success">Approve</button>
                    </form>
                @else
                    <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-secondary">Deactivate</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


@endsection

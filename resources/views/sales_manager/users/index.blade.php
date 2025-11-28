@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="fw-bold mb-3">My Applicants</h3>
    <p class="text-muted">These are the agents you have encoded. Admin approval is required.</p>

    <a href="{{ route('sales_manager.users.create') }}" class="btn btn-primary mb-3">
        + New Applicant
    </a>

    <div class="card p-3">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Branch</th>
                    <th>Status</th>
                    @if(auth()->user()->role === 'admin')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->last_name }}, {{ $user->first_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                    <td>{{ $user->branch->name ?? 'N/A' }}</td>

                    <td>
                        @if($user->is_approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>

                    @if(auth()->user()->role === 'admin')
                    <td>
                        @if(!$user->is_approved)
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-danger btn-sm">Deactivate</button>
                            </form>
                        @endif
                    </td>
                    @endif

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No applicants found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>

</div>
@endsection

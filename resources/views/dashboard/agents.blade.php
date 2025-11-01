@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Agent Management</h4>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <div class="card-body">
                {{-- ✅ Success or Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- ✅ Agent Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Status</th>
                            <th width="220">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($agents as $agent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agent->first_name }} {{ $agent->last_name }}</td>
                                <td>{{ $agent->email }}</td>
                                <td>{{ $agent->branch->name ?? '—' }}</td>

                                {{-- ✅ Status based on is_approved --}}
                                <td>
                                    @if($agent->is_approved == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($agent->is_approved == 0)
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($agent->is_approved == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>

                                {{-- ✅ Action Buttons --}}
                                <td>
                                    @if($agent->is_approved == 0)
                                        <form action="{{ route('agents.approve', $agent->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('agents.reject', $agent->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </button>
                                        </form>
                                    @elseif($agent->is_approved == 1)
                                        <span class="text-success fw-bold">Approved</span>
                                    @elseif($agent->is_approved == 2)
                                        <span class="text-danger fw-bold">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No agents found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        {{-- ✅ Flash Message for approve/reject --}}
        @if(session('status'))
            @php
                // Determine alert color based on message content
                $alertClass = str_contains(strtolower(session('status')), 'approved') ? 'success' :
                              (str_contains(strtolower(session('status')), 'rejected') ? 'danger' : 'info');
            @endphp
            <div id="statusAlert" class="alert alert-{{ $alertClass }} alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <script>
                setTimeout(() => {
                    const alert = document.getElementById('statusAlert');
                    if (alert) {
                        const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                        bsAlert.close();
                    }
                }, 5000);
            </script>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Agent & Broker Management</h4>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <div class="card-body">

                {{-- Users Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Role</th>
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

                                {{-- Role Badge --}}
                                <td>
                                    @php
                                        $roleColors = [
                                            'buyer' => 'secondary',
                                            'agent' => 'info text-dark',
                                            'broker' => 'primary text-white',
                                            'admin' => 'dark text-white'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $roleColors[$agent->role] ?? 'info' }}">
                                    {{ ucfirst($agent->role ?? 'Agent') }}
                                </span>
                                </td>

                                {{-- Status --}}
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

                                {{-- Action Buttons --}}
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        @if($agent->is_approved == 0)
                                            {{-- Approve --}}
                                            <form action="{{ route('agents.approve', $agent->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>

                                            {{-- Reject --}}
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
                                    @else
                                        <span class="text-muted">No actions available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No agents or brokers found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Hover effect styling --}}
    <style>
        .hover-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 12px;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }
        h6.text-muted {
            font-size: 0.9rem;
        }
    </style>
@endsection

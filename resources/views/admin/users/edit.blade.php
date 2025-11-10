@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" value="{{ $user->first_name }}" name="first_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" value="{{ $user->last_name }}" name="last_name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" value="{{ $user->email }}" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>User Role</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ strtoupper($role) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Branch</label>
            <select name="branch_id" class="form-control">
                <option value="">None</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection

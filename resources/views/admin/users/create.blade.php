@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add User</h2>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        @if ($errors->any())
        <div style="color:red; margin-bottom: 10px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

      <div class="mb-3">
    <label>User Role</label>
    <select name="role" class="form-control">
        @foreach($roles as $value => $label)
            <option value="{{ $value }}" {{ old('role', $user->role ?? '') == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label>Branch (Optional)</label>
            <select name="branch_id" class="form-control">
                <option value="">None</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Birthday (Optional)</label>
            <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
        </div>

        <div class="mb-3">
            <label>Gender (Optional)</label>
            <select name="gender" class="form-control">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

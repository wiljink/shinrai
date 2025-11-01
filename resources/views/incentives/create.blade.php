@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Incentive</h1>
        <form action="{{ route('incentives.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Agent</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select Agent</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Type</label>
                <input type="text" name="type" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <button class="btn btn-success">Save</button>
        </form>
    </div>
@endsection

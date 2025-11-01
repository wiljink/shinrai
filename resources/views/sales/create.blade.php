@extends('layouts.app')

@section('content')
    <h1>Add Sale</h1>
    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Property</label>
            <select name="property_id" class="form-control">
                @foreach($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Agent</label>
            <select name="agent_id" class="form-control">
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Buyer</label><input type="text" name="buyer" class="form-control" required></div>
        <div class="mb-3"><label>Total Amount</label><input type="number" step="0.01" name="total_amount" class="form-control" required></div>
        <div class="mb-3"><label>Sale Date</label><input type="date" name="sale_date" class="form-control" required></div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

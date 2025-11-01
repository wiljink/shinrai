@extends('layouts.app')

@section('content')
    <h1>Edit Sale</h1>
    <form action="{{ route('sales.update', $sale) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Property</label>
            <select name="property_id" class="form-control">
                @foreach($properties as $property)
                    <option value="{{ $property->id }}" @if($sale->property_id == $property->id) selected @endif>{{ $property->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Agent</label>
            <select name="agent_id" class="form-control">
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" @if($sale->agent_id == $agent->id) selected @endif>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Buyer</label><input type="text" name="buyer" value="{{ $sale->buyer }}" class="form-control"></div>
        <div class="mb-3"><label>Total Amount</label><input type="number" step="0.01" name="total_amount" value="{{ $sale->total_amount }}" class="form-control"></div>
        <div class="mb-3"><label>Sale Date</label><input type="date" name="sale_date" value="{{ $sale->sale_date }}" class="form-control"></div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

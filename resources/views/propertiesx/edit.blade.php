@extends('layouts.app')

@section('content')
    <h1>Edit Property</h1>
    <form action="{{ route('properties.update', $property) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control">
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @if($property->project_id == $project->id) selected @endif>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Agent</label>
            <select name="agent_id" class="form-control">
                @foreach($agents as $agent)
                    <option value="{{ $agent->id }}" @if($property->agent_id == $agent->id) selected @endif>{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3"><label>Name</label><input type="text" name="name" value="{{ $property->name }}" class="form-control" required></div>
        <div class="mb-3"><label>Location</label><input type="text" name="location" value="{{ $property->location }}" class="form-control" required></div>
        <div class="mb-3"><label>Price</label><input type="number" step="0.01" name="price" value="{{ $property->price }}" class="form-control" required></div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available" @if($property->status == 'available') selected @endif>Available</option>
                <option value="sold" @if($property->status == 'sold') selected @endif>Sold</option>
                <option value="reserved" @if($property->status == 'reserved') selected @endif>Reserved</option>
            </select>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

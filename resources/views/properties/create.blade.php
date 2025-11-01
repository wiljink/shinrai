@extends('layouts.app')

@section('content')
    <h1>Add Property</h1>
    <form action="{{ route('properties.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Project</label>
            <select name="project_id" class="form-control">
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
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
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Location</label><input type="text" name="location" class="form-control" required></div>
        <div class="mb-3"><label>Price</label><input type="number" step="0.01" name="price" class="form-control" required></div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="available">Available</option>
                <option value="sold">Sold</option>
                <option value="reserved">Reserved</option>
            </select>
        </div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

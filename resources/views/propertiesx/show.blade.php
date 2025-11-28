@extends('layouts.app')

@section('content')
    <h1>Property Details</h1>
    <div class="card">
        <div class="card-body">
            <h3>{{ $property->name }}</h3>
            <p><strong>Project:</strong> {{ $property->project->name ?? 'N/A' }}</p>
            <p><strong>Agent:</strong> {{ $property->agent->name ?? 'N/A' }}</p>
            <p><strong>Location:</strong> {{ $property->location }}</p>
            <p><strong>Price:</strong> {{ number_format($property->price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($property->status) }}</p>
        </div>
    </div>
    <a href="{{ route('properties.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection

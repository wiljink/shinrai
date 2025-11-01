@extends('layouts.app')

@section('content')
    <h1 class="mb-3">Properties</h1>
    <a href="{{ route('properties.create') }}" class="btn btn-primary mb-3">Add Property</a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Project</th>
            <th>Agent</th>
            <th>Name</th>
            <th>Location</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($properties as $property)
            <tr>
                <td>{{ $property->id }}</td>
                <td>{{ $property->project->name ?? 'N/A' }}</td>
                <td>{{ $property->agent->name ?? 'N/A' }}</td>
                <td>{{ $property->name }}</td>
                <td>{{ $property->location }}</td>
                <td>{{ number_format($property->price, 2) }}</td>
                <td>{{ $property->status }}</td>
                <td>
                    <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('properties.destroy', $property) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this property?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $properties->links() }}
@endsection

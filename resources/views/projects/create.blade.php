@extends('layouts.app')
@section('content')
    <h1>Add Project</h1>
    <form action="{{ route('projects.store') }}" method="POST">@csrf
        <div class="mb-3"><label>Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Location</label><input type="text" name="location" class="form-control" required></div>
        <button class="btn btn-success">Save</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
@extends('layouts.app')
@section('content')
    <h1>Edit Project</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST">@csrf @method('PUT')
        <div class="mb-3"><label>Name</label><input type="text" name="name" value="{{ $project->name }}" class="form-control" required></div>
        <div class="mb-3"><label>Location</label><input type="text" name="location" value="{{ $project->location }}" class="form-control" required></div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection

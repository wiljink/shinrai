@extends('layouts.app')
@section('content')
    <h1>Project Details</h1>
    <p><strong>Name:</strong> {{ $project->name }}</p>
    <p><strong>Location:</strong> {{ $project->location }}</p>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
@endsection

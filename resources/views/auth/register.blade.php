@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="container mx-auto px-4">
            <div class="flex justify-center">
                <!-- Card Container -->
                <div class="w-full max-w-md bg-white border border-gray-200 shadow-xl rounded-2xl p-8">

                    <!-- Header -->
                    <div class="text-center mb-6">
                        <h2 class="text-3xl font-extrabold text-gray-800">Create an Account</h2>
                        <p class="text-gray-500 mt-2 text-sm">Please fill in the form to continue</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-5 text-center">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-gray-700 text-sm font-medium mb-1 text-center">Full Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-700 text-sm font-medium mb-1 text-center">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-gray-700 text-sm font-medium mb-1 text-center">Password</label>
                            <input id="password" type="password" name="password" required
                                   class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-1 text-center">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-gray-700 text-sm font-medium mb-1 text-center">Role</label>
                            <select id="role" name="role" required
                                    class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="">-- Select Role --</option>
                                <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                                @if(auth()->check() && auth()->user()->role === 'admin')
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                @endif
                            </select>
                            @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Branch -->
                        <div>
                            <label for="branch_id" class="block text-gray-700 text-sm font-medium mb-1 text-center">Branch (Optional)</label>
                            <select id="branch_id" name="branch_id"
                                    class="w-3/4 max-w-sm mx-auto border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="">-- Select Branch --</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-3/4 max-w-sm bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 ease-in-out">
                                Register
                            </button>
                        </div>

                        <!-- Login Redirect -->
                        <p class="text-sm text-center text-gray-600 mt-4">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Add Admin User')
@section('header', 'Add Admin User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
            ← Back to Admin Users
        </a>
    </div>

    <div class="bg-white border rounded-xl p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full rounded-lg border-gray-300 @error('name') border-red-500 @enderror" 
                       required autofocus>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full rounded-lg border-gray-300 @error('email') border-red-500 @enderror" 
                       required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password" 
                       class="w-full rounded-lg border-gray-300 @error('password') border-red-500 @enderror" 
                       required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" 
                       class="w-full rounded-lg border-gray-300" 
                       required>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm text-gray-700 border rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800">
                    Create Admin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
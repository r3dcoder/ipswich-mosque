@extends('layouts.dashboard')

@section('title', 'Change Password')
@section('header', 'Change Password')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-1">
            ← Back to Admin Users
        </a>
    </div>

    <div class="bg-white border rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Change Password for {{ $user->name }}</h3>
        
        <form action="{{ route('admin.users.password.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" name="password" 
                       class="w-full rounded-lg border-gray-300 @error('password') border-red-500 @enderror" 
                       required autofocus>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" 
                       class="w-full rounded-lg border-gray-300" 
                       required>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm text-gray-700 border rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white text-sm rounded-lg hover:bg-gray-800">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
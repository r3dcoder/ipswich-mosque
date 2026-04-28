@extends('layouts.dashboard')

@section('title', 'Admin Users')
@section('header', 'Admin Users')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h2 class="text-lg font-semibold">Admin Users</h2>
        <p class="text-sm text-gray-600">Manage admin panel access.</p>
    </div>

    <a href="{{ route('admin.users.create') }}"
       class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
        + Add Admin
    </a>
</div>

@if (session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-800 border border-red-200">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white border rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-b">
            <tr class="whitespace-nowrap">
                <th class="text-left px-3 py-3">Name</th>
                <th class="text-left px-3 py-3">Email</th>
                <th class="text-left px-3 py-3">Created</th>
                <th class="text-right px-3 py-3">Actions</th>
            </tr>
            </thead>

            <tbody class="divide-y">
            @forelse($users as $user)
                <tr class="whitespace-nowrap">
                    <td class="px-3 py-3 font-medium">{{ $user->name }}</td>
                    <td class="px-3 py-3 text-gray-600">{{ $user->email }}</td>
                    <td class="px-3 py-3 text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-3 py-3 text-right space-x-2">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Edit
                        </a>
                        <a href="{{ route('admin.users.password', $user) }}"
                           class="inline-flex px-3 py-1.5 rounded-lg border text-sm hover:bg-gray-50">
                            Password
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              class="inline" onsubmit="return confirm('Delete this admin user?')">
                            @csrf
                            @method('DELETE')
                            <button class="inline-flex px-3 py-1.5 rounded-lg border border-red-200 text-red-700 hover:bg-red-50 text-sm">
                                Delete
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-600">No admin users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
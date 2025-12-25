@extends('layouts.dashboard')

@section('title', 'Edit Jummah Schedule')
@section('header', 'Edit Jummah Schedule')

@section('content')
<div class="bg-white border rounded-xl p-6">
    <form action="{{ route('admin.jummah.update', $schedule) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="p-3 rounded-lg bg-red-50 text-red-700 border border-red-200">
                Please fix the errors below.
            </div>
        @endif

        @include('admin.jummah._form', ['schedule' => $schedule])

        <div class="flex gap-2 pt-2">
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">
                Update
            </button>
            <a href="{{ route('admin.jummah.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

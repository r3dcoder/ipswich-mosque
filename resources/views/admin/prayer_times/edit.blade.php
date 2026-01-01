@extends('layouts.dashboard')

@section('title', 'Edit Prayer Row')
@section('header', 'Edit Prayer Row')

@section('content')
<div class="max-w-5xl bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.prayer-times.update', $prayer) }}">
        @csrf
        @method('PUT')

        @include('admin.prayer_times._form', ['prayer' => $prayer])

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.prayer-times.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Update</button>
        </div>
    </form>
</div>
@endsection

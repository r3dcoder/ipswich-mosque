@extends('layouts.dashboard')

@section('title', 'Add Prayer Row')
@section('header', 'Add Prayer Row')

@section('content')
<div class="max-w-5xl bg-white border rounded-xl p-6">
    <form method="POST" action="{{ route('admin.prayer-times.store') }}">
        @csrf
        @php($prayer = new \App\Models\PrayerTime())
        @include('admin.prayer_times._form', ['prayer' => $prayer])

        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.prayer-times.index') }}" class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-50">Cancel</a>
            <button class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm hover:bg-gray-800">Create</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.dashboard')

@section('title', 'Add Emergency Contact')
@section('header', 'Add Emergency Contact')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.emergency-contacts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to contacts</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Add Emergency Contact</h1>
        <p class="text-sm text-gray-500 mt-1">Add a committee member who can be contacted in an emergency.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.emergency-contacts.store') }}" method="POST">
            @csrf
            @include('admin.emergency-contacts._form', ['contact' => null, 'submitLabel' => 'Create Contact'])
        </form>
    </div>
</div>
@endsection
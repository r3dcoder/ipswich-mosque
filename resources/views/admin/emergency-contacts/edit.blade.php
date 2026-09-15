@extends('layouts.dashboard')

@section('title', 'Edit Emergency Contact')
@section('header', 'Edit Emergency Contact')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('admin.emergency-contacts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to contacts</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Emergency Contact</h1>
        <p class="text-sm text-gray-500 mt-1">Update this committee member's contact details.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.emergency-contacts.update', $emergencyContact->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.emergency-contacts._form', ['contact' => $emergencyContact, 'submitLabel' => 'Update Contact'])
        </form>
    </div>
</div>
@endsection
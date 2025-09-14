@extends('main-layout')

@section('title', 'Donation Success')

@section('header')
    @include('partials.header')
@endsection


@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg text-center my-10">
        <h2 class="text-2xl font-bold mb-4">Donation Successful!</h2>

        @if($donationAmount)
            <p class="mb-2">Donation Amount: <strong>£{{ $donationAmount }}</strong></p>
        @endif

        @if($donorName)
            <p class="mb-4">Donor: <strong>{{ $donorName }}</strong></p>
        @endif

        <p class="mb-4">Your donation has been processed successfully. JazakAllahu Khair!</p>
        <a href="{{ url('/') }}" class="inline-block bg-green-700 text-white px-6 py-3 rounded hover:bg-green-800">Back to
            Home</a>
    </div>
@endsection

@section('footer')
    @include('partials.footer')

@endsection
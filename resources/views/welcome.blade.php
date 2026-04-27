@extends('main-layout')

@section('title', 'Ipswich Mosque')

@section('header')
    @include('partials.header')
@endsection

@section('content')
    <x-carousel page="home" interval="5000" />
    @include('partials.welcome-section')
    <x-courses-section page="home" />
    @include('partials.daily-hadis')
    @include('partials.donation-hom-page-section')
    @include('partials.events')
    @include('partials.map-section')
@endsection

@section('footer')
    @include('partials.footer')
@endsection
@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)

@section('content')
@include('partials.header')
<div class="max-w-6xl mx-auto px-4 py-10">
    @foreach($page->blocks as $block)
        @includeIf('blocks.'.$block->type, ['data' => $block->data, 'page' => $page])
    @endforeach
</div>
@include('partials.footer')

@endsection

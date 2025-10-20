{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.error')

@section('title', '404 Not Found')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-6xl font-bold mb-4">404</h1>
    <h2 class="text-2xl mb-6">Page Not Found</h2>
    <p class="mb-6">Sorry, the page you are looking for could not be found.</p>
    <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Go Home</a>
</div>
@endsection

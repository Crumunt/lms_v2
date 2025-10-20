{{-- resources/views/errors/429.blade.php --}}
@extends('layouts.error')

@section('title', '429 Too Many Requests')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-6xl font-bold mb-4">429</h1>
    <h2 class="text-2xl mb-6">Too Many Requests</h2>
    <p class="mb-6">You have made too many requests. Please try again later.</p>
    <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Go Home</a>
</div>
@endsection

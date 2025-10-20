{{-- resources/views/errors/419.blade.php --}}
@extends('layouts.error')

@section('title', '419 Page Expired')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-6xl font-bold mb-4">419</h1>
    <h2 class="text-2xl mb-6">Page Expired</h2>
    <p class="mb-6">Sorry, your session has expired. Please refresh and try again.</p>
    <a href="{{ url()->current() }}" class="text-blue-600 hover:underline">Refresh</a>
</div>
@endsection

{{-- resources/views/errors/500.blade.php --}}
@extends('layouts.error')

@section('title', '500 Server Error')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-6xl font-bold mb-4">500</h1>
    <h2 class="text-2xl mb-6">Server Error</h2>
    <p class="mb-6">Whoops, something went wrong on our servers.</p>
    <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Go Home</a>
</div>
@endsection

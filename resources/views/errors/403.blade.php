{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.error')

@section('title', '403 Forbidden')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <h1 class="text-6xl font-bold mb-4">403</h1>
    <h2 class="text-2xl mb-6">Forbidden - Access Denied</h2>
    <p class="mb-6">Sorry, you do not have permission to access this page.</p>
    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">Go Back</a>
</div>
@endsection

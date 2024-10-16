<!doctype html>
@php
    $dir = GetDirection();
    $ml = $dir == 'RTL' ? 'mr-' : 'ml-';
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
     @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        @else
        <script src="https://cdn.tailwindcss.com"></script>
     @endif
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
<div id="app">
    @include('partial.sidebar')
    <div class="sm:{{ $ml }}64">
        <main class="p-5 bg-gray-200 dark:bg-gray-800 rounded m-5">
            @yield('content')
        </main>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
</html>

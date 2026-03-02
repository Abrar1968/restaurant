<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sanjung Delights — Premier Halal Corporate Catering')</title>
    <meta name="description" content="@yield('meta_description', 'Sanjung Delights — Premier Halal Corporate Catering in KL & Klang Valley')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-[#0D0D0D] text-gray-300 font-sans antialiased" x-data="{ sidebarOpen: false }">

    {{-- Top Header Bar --}}
    @include('components.front.header')

    {{-- Sidebar Navigation --}}
    @include('components.front.sidebar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.front.footer')

    @stack('scripts')
</body>
</html>

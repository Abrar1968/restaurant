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
<body class="bg-green-deep text-gray-200 font-sans antialiased" x-data="{ sidebarOpen: false }">

    {{-- Mobile Header Bar (visible only on mobile) --}}
    @include('components.front.header')

    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/60 z-40 lg:hidden" style="display: none;"></div>

    {{-- Three-Column Layout --}}
    <div class="site-layout">
        {{-- Left Sidebar --}}
        @include('components.front.sidebar')

        {{-- Main Content Area --}}
        <div class="site-main">
            @yield('content')
        </div>
    </div>

    {{-- Footer (mobile only, stacked below) --}}
    @include('components.front.footer')

    @stack('scripts')
</body>
</html>

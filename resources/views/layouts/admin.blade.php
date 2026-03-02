<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Sanjung Delights</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0D0D0D] text-gray-300 font-sans antialiased" x-data="{ adminSidebarOpen: true }">
    <div class="flex min-h-screen">
        {{-- Admin Sidebar --}}
        @include('components.admin.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col" :class="adminSidebarOpen ? 'ml-64' : 'ml-0'" style="transition: margin-left 0.3s;">
            {{-- Top Bar --}}
            @include('components.admin.header')

            {{-- Page Content --}}
            <main class="flex-1 p-6 md:p-8 pt-20">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-900/30 border border-green-500/30 text-green-400 rounded-lg p-4 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 bg-red-900/30 border border-red-500/30 text-red-400 rounded-lg p-4 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

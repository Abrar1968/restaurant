<header class="fixed top-0 left-0 right-0 z-50 h-[72px] md:h-[72px] flex items-center justify-between px-6 md:px-8"
        style="background: rgba(0,0,0,0.80); backdrop-filter: blur(8px);">
    {{-- Hamburger Menu Button --}}
    <button @click="sidebarOpen = !sidebarOpen" class="relative z-50 w-8 h-8 flex flex-col items-center justify-center gap-1.5 group">
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? 'rotate-45 translate-y-2' : ''"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? 'opacity-0' : ''"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? '-rotate-45 -translate-y-2' : ''"></span>
    </button>

    {{-- Centered Logo --}}
    <a href="{{ route('home') }}" class="absolute left-1/2 -translate-x-1/2">
        <img src="{{ asset('images/logo-white.png') }}" alt="Sanjung Delights" class="h-10 md:h-12">
    </a>

    {{-- Phone (desktop only) --}}
    <div class="hidden md:flex items-center gap-2 text-sm text-gray-400">
        <svg class="w-4 h-4 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
        <span>{{ $settings['phone_1'] ?? '+603-7960 5366' }}</span>
    </div>
</header>

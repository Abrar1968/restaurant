{{-- Mobile-only top bar (hidden on desktop where sidebar is always visible) --}}
<header class="fixed top-0 left-0 right-0 z-30 h-16 flex items-center justify-between px-4 lg:hidden"
        style="background: rgba(15,36,24,0.95); backdrop-filter: blur(8px);">
    {{-- Hamburger Menu Button --}}
    <button @click="sidebarOpen = !sidebarOpen" class="relative z-50 w-8 h-8 flex flex-col items-center justify-center gap-1.5">
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? 'rotate-45 translate-y-2' : ''"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? 'opacity-0' : ''"></span>
        <span class="block w-6 h-0.5 bg-white transition-all duration-300"
              :class="sidebarOpen ? '-rotate-45 -translate-y-2' : ''"></span>
    </button>

    {{-- Centered Logo --}}
    <a href="{{ route('home') }}" class="absolute left-1/2 -translate-x-1/2">
        <span class="text-gold font-serif text-lg italic">Sanjung Delights</span>
    </a>

    {{-- Phone --}}
    <a href="tel:{{ $settings['phone_1'] ?? '+60379605366' }}" class="flex items-center gap-1.5 text-xs text-white/60">
        <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
    </a>
</header>

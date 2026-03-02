{{-- Overlay --}}
<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/60 z-40"
     style="display: none;"></div>

{{-- Sidebar Panel --}}
<aside x-show="sidebarOpen"
       x-transition:enter="transition-transform duration-300 ease-out"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition-transform duration-300 ease-in"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="fixed top-0 left-0 h-full w-full md:w-[320px] z-50 overflow-y-auto"
       style="display: none;">

    {{-- Video Background --}}
    <div class="absolute inset-0 overflow-hidden">
        <video autoplay muted loop playsinline class="w-full h-full object-cover">
            <source src="{{ asset('videos/sidebar-bg.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/65"></div>
    </div>

    {{-- Sidebar Content --}}
    <div class="relative z-10 p-8 pt-20">
        {{-- Logo --}}
        <div class="mb-10">
            <img src="{{ asset('images/logo-white.png') }}" alt="Sanjung Delights" class="h-14">
        </div>

        {{-- Navigation Links --}}
        <nav>
            <ul class="space-y-1">
                @php
                    $navLinks = [
                        ['route' => 'home', 'label' => 'Home'],
                        ['route' => 'about', 'label' => 'About Us'],
                        ['route' => 'menu', 'label' => 'Our Menu'],
                        ['route' => 'gallery', 'label' => 'Gallery'],
                        ['route' => 'track-record', 'label' => 'Track Record'],
                        ['route' => 'certifications', 'label' => 'Certifications'],
                        ['route' => 'clients', 'label' => 'Our Clients'],
                        ['route' => 'contact', 'label' => 'Contact'],
                    ];
                @endphp
                @foreach($navLinks as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="block py-3 px-4 text-sm uppercase tracking-widest font-medium border-l-4 transition-all duration-200
                                  {{ request()->routeIs($link['route']) ? 'border-[#C9A84C] text-[#C9A84C] pl-6' : 'border-transparent text-white/80 hover:border-[#C9A84C] hover:text-[#C9A84C] hover:pl-6' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <hr class="border-white/10 my-8">

        {{-- Contact Info --}}
        <div class="space-y-4 text-sm">
            <h4 class="text-[#C9A84C] uppercase tracking-widest text-xs font-semibold mb-4">Contact Us</h4>
            <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-[#C9A84C] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <div class="text-gray-300">
                    <p>{{ $settings['phone_1'] ?? '+603-7960 5366' }}</p>
                    <p>{{ $settings['phone_2'] ?? '+603-7960 5367' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-[#C9A84C] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div class="text-gray-300">
                    <p>{{ $settings['email_1'] ?? 'sales@sanjungwaja.com' }}</p>
                    <p>{{ $settings['email_2'] ?? 'info@sanjungwaja.com' }}</p>
                </div>
            </div>
        </div>

        {{-- WhatsApp Button --}}
        <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '60179605366' }}"
           target="_blank"
           class="mt-6 flex items-center justify-center gap-2 w-full py-3 px-6 bg-[#25D366] text-white text-sm font-semibold rounded-full hover:scale-105 transition-transform duration-200">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.12.553 4.113 1.519 5.848L.058 23.306a.5.5 0 00.636.636l5.458-1.461A11.948 11.948 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.94 0-3.786-.546-5.382-1.564l-.386-.234-3.996 1.07 1.07-3.996-.234-.386A9.953 9.953 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
            WhatsApp Us
        </a>

        <hr class="border-white/10 my-8">

        {{-- Business Hours --}}
        <div class="text-sm">
            <h4 class="text-[#C9A84C] uppercase tracking-widest text-xs font-semibold mb-3">Office Business Hours</h4>
            <p class="text-gray-400">{{ $settings['business_hours'] ?? 'MON-FRI 9:00AM - 6:00PM | SAT 9:00AM - 1:00PM' }}</p>
        </div>
    </div>
</aside>

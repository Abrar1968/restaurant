{{-- Sidebar — Always visible on desktop, slide-in on mobile --}}
<aside class="site-sidebar bg-green-deep gold-frame"
       :class="{ 'open': sidebarOpen }">

    {{-- Close button (mobile only) --}}
    <button @click="sidebarOpen = false"
            class="absolute top-4 right-4 text-white/60 hover:text-gold z-10 lg:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Sidebar Content --}}
    <div class="flex flex-col h-full px-6 py-8">
        {{-- Logo --}}
        <div class="text-center mb-10 pt-4">
            <a href="{{ route('home') }}" class="inline-block">
                <img src="{{ asset('images/logo-white.png') }}" alt="Sanjung Delights" class="h-16 mx-auto"
                     onerror="this.onerror=null; this.parentNode.innerHTML='<span class=\'text-gold font-serif text-xl italic\'>Sanjung Delights</span>';">
            </a>
        </div>

        {{-- Gold Separator --}}
        <div class="w-12 h-px bg-gold/40 mx-auto mb-8"></div>

        {{-- Navigation Links --}}
        <nav class="flex-1">
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
                           class="block py-2.5 px-3 text-[13px] uppercase tracking-[0.2em] font-medium transition-all duration-200 text-center
                                  {{ request()->routeIs($link['route'] . '*') ? 'text-gold border-b border-gold/60' : 'text-white/70 hover:text-gold' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        {{-- Bottom Section --}}
        <div class="mt-auto pt-6">
            {{-- Gold Separator --}}
            <div class="w-12 h-px bg-gold/40 mx-auto mb-6"></div>

            {{-- Contact Info --}}
            <div class="text-center space-y-2 text-xs text-white/50">
                <p>{{ $settings['phone_1'] ?? '+603-7960 5366' }}</p>
                <p>{{ $settings['email_1'] ?? 'sales@sanjungwaja.com' }}</p>
            </div>

            {{-- WhatsApp --}}
            <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '60179605366' }}"
               target="_blank"
               class="mt-4 flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-whatsapp/90 hover:bg-whatsapp text-white text-xs font-semibold rounded transition-colors duration-200">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.12.553 4.113 1.519 5.848L.058 23.306a.5.5 0 00.636.636l5.458-1.461A11.948 11.948 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.94 0-3.786-.546-5.382-1.564l-.386-.234-3.996 1.07 1.07-3.996-.234-.386A9.953 9.953 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</aside>

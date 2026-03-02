@extends('layouts.front')
@section('title', 'Sanjung Delights — Premier Halal Corporate Catering')
@section('meta_description', $settings['meta_description'] ?? 'Sanjung Delights — Premier Halal Corporate Catering in KL & Klang Valley. Fantastic food, business class service.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? $settings['hero_headline'] ?? 'Halal Corporate Catering in KL & Klang Valley',
        'subheadline' => $hero?->subheadline ?? $settings['hero_subtext'] ?? 'Fantastic Food, Business Class Service',
        'eyebrow' => 'Premier Halal Corporate Catering',
        'ctaText' => $hero?->cta_text ?? 'About Sanjung Delights',
        'ctaUrl' => $hero?->cta_url ?? route('about'),
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay">

        {{-- Packages Section --}}
        @if($packages->count())
        <div class="p-8 lg:p-10">
            <h2 class="text-gold font-serif italic text-xl mb-1">Seasonal & Festive Menus</h2>
            <div class="w-10 h-px bg-gold/40 mb-6"></div>

            <div class="space-y-4">
                @foreach($packages->take(3) as $package)
                    <a href="{{ route('menu.package', $package->slug) }}"
                       class="group relative block overflow-hidden rounded-lg h-44 shimmer-effect">
                        @if($package->cover_image_url)
                            <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-green-mid"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white text-lg font-serif italic group-hover:text-gold transition-colors duration-300">{{ $package->name }}</h3>
                            @if($package->tagline)
                                <p class="text-white/60 text-xs mt-0.5">{{ $package->tagline }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- About Section --}}
        <div class="p-8 lg:p-10 border-t border-white/10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">About Us</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Sanjung Delights</h2>
            <p class="text-gold/80 italic text-xs mt-1">Premier Halal Corporate Catering Since 2010</p>
            <div class="w-10 h-px bg-gold/40 my-4"></div>
            <p class="text-white/70 text-sm leading-relaxed">
                {{ $settings['about_text'] ?? 'Sanjung Delights is the catering arm of Sanjung Waja Resources, established in 2010, serving the finest halal corporate catering in KL and the Klang Valley.' }}
            </p>
            <a href="{{ route('about') }}" class="inline-block mt-4 border border-white/40 text-white hover:bg-white hover:text-green-deep px-6 py-2 uppercase tracking-[0.2em] text-[10px] font-medium transition-all duration-300">
                More About Us
            </a>
        </div>

        {{-- Cuisine Categories --}}
        @if($cuisines->count())
        <div class="p-8 lg:p-10 border-t border-white/10">
            <h3 class="text-gold font-serif italic text-lg mb-4">Our Cuisine Categories</h3>
            <div class="grid grid-cols-2 gap-3">
                @foreach($cuisines->take(4) as $cuisine)
                    <a href="{{ route('menu.show', $cuisine->slug) }}"
                       class="group relative block overflow-hidden rounded h-28">
                        @if($cuisine->image_url)
                            <img src="{{ $cuisine->image_url }}" alt="{{ $cuisine->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-green-mid"></div>
                        @endif
                        <div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors duration-300"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-white text-xs font-serif italic uppercase tracking-wider group-hover:text-gold transition-colors">{{ $cuisine->name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Client Logos --}}
        @if($clients->count())
        <div class="p-8 lg:p-10 border-t border-white/10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Trusted By</span>
            <div class="grid grid-cols-3 gap-3 mt-4">
                @foreach($clients->take(6) as $client)
                    @if($client->logo_url)
                        <div class="bg-white/10 rounded p-3 flex items-center justify-center h-16">
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="max-h-10 max-w-full object-contain opacity-60 hover:opacity-100 transition-opacity">
                        </div>
                    @endif
                @endforeach
            </div>
            <a href="{{ route('clients') }}" class="text-gold text-xs font-medium hover:underline mt-3 inline-block">View All Clients →</a>
        </div>
        @endif

        {{-- Footer in panel --}}
        <div class="p-6 border-t border-white/10 text-center">
            <p class="text-white/30 text-[10px]">{{ $settings['copyright_text'] ?? '© 2026 Sanjung Delights. All Rights Reserved.' }}</p>
        </div>
    </div>

@endsection

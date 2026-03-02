@extends('layouts.front')
@section('title', 'Our Menu — Sanjung Delights')
@section('meta_description', 'Explore our curated halal menus — Malay, Western, Indian & fusion cuisines for corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Menus Authentic Flavors',
        'subheadline' => $hero?->subheadline ?? 'Discover our diverse range of halal cuisines for every occasion',
        'eyebrow' => 'Halal Corporate Catering',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay">

        {{-- Special Packages --}}
        @if($packages->count())
        <div class="p-8 lg:p-10">
            <h2 class="text-gold font-serif italic text-xl mb-1">Seasonal & Festive Menus</h2>
            <div class="w-10 h-px bg-gold/40 mb-6"></div>

            <div class="space-y-4">
                @foreach($packages->take(3) as $package)
                    <a href="{{ route('menu.package', $package->slug) }}"
                       class="group relative block overflow-hidden rounded-lg h-40 shimmer-effect">
                        @if($package->cover_image_url)
                            <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-green-mid"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <span class="text-gold text-[10px] uppercase tracking-widest">Package</span>
                            <h3 class="text-white text-base font-serif italic group-hover:text-gold transition-colors duration-300">{{ $package->name }}</h3>
                            @if($package->tagline)
                                <p class="text-white/50 text-xs mt-0.5">{{ $package->tagline }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Cuisine Categories --}}
        @if($cuisines->count())
        <div class="p-8 lg:p-10 border-t border-white/10">
            <h3 class="text-gold font-serif italic text-lg mb-4">Our Cuisine Categories</h3>
            <div class="w-10 h-px bg-gold/40 mb-6"></div>

            <div class="space-y-3">
                @foreach($cuisines as $cuisine)
                    <a href="{{ route('menu.show', $cuisine->slug) }}"
                       class="group flex items-center gap-4 p-3 rounded-lg border border-white/5 hover:border-gold/30 transition-all duration-300">
                        @if($cuisine->image_url)
                            <div class="w-16 h-16 rounded overflow-hidden flex-shrink-0">
                                <img src="{{ $cuisine->image_url }}" alt="{{ $cuisine->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                        @endif
                        <div>
                            <h4 class="text-white text-sm font-serif italic group-hover:text-gold transition-colors">{{ $cuisine->name }}</h4>
                            <span class="text-gold/60 text-[10px] uppercase tracking-widest">Halal Compliant</span>
                            @if($cuisine->description)
                                <p class="text-white/50 text-xs mt-0.5 line-clamp-1">{{ $cuisine->description }}</p>
                            @endif
                        </div>
                        <svg class="w-4 h-4 text-gold/40 ml-auto flex-shrink-0 group-hover:text-gold transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="p-8 lg:p-10 border-t border-white/10 marble-bg text-center">
            <h3 class="text-green-dark font-serif italic text-lg mb-2">Need Something Custom?</h3>
            <p class="text-green-dark/70 text-sm mb-4">We specialize in creating custom menus tailored to your event.</p>
            <a href="{{ route('contact') }}" class="inline-block border border-green-dark/40 text-green-dark hover:bg-green-dark hover:text-white px-6 py-2 uppercase tracking-[0.2em] text-[10px] font-medium transition-all duration-300">
                Get In Touch
            </a>
        </div>
    </div>

@endsection

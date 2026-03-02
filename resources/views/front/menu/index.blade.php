@extends('layouts.front')
@section('title', 'Our Menu — Sanjung Delights')
@section('meta_description', 'Explore our curated halal menus — Malay, Western, Indian & fusion cuisines for corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Curated Menus',
        'subheadline' => $hero?->subheadline ?? 'Discover our diverse range of halal cuisines for every occasion',
        'eyebrow' => 'Halal Corporate Catering',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Cuisine Category Grid --}}
    @if($cuisines->count())
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Browse by Cuisine</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Our Cuisines</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Each cuisine is carefully crafted with authentic flavors while maintaining strict halal compliance.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($cuisines as $i => $cuisine)
                    <a href="{{ route('menu.show', $cuisine->slug) }}"
                       class="group relative block overflow-hidden rounded-lg shadow-2xl h-[420px] shimmer-effect"
                       data-animate="animate-fade-in-up" data-delay="{{ $i * 0.15 }}s" style="opacity:0;">
                        @if($cuisine->image_url)
                            <img src="{{ $cuisine->image_url }}" alt="{{ $cuisine->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-[#111111]"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <span class="text-[#C9A84C] text-xs uppercase tracking-widest font-medium">Halal Compliant</span>
                            <h3 class="text-white text-3xl font-bold mt-2 font-serif group-hover:text-[#C9A84C] transition-colors duration-300">{{ $cuisine->name }}</h3>
                            @if($cuisine->description)
                                <p class="text-gray-300 mt-2 line-clamp-2">{{ $cuisine->description }}</p>
                            @endif
                            <div class="mt-4 inline-flex items-center gap-2 text-[#C9A84C] text-sm font-medium opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                View Menu
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Special Packages Section --}}
    @if($packages->count())
    <section class="py-20 md:py-28 bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Value Deals</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Special Packages</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Curated packages designed for corporate events, conferences, and special occasions.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($packages as $i => $package)
                    <a href="{{ route('menu.package', $package->slug) }}"
                       class="group relative block overflow-hidden rounded-lg shadow-2xl h-[350px] shimmer-effect"
                       data-animate="animate-fade-in-up" data-delay="{{ $i * 0.1 }}s" style="opacity:0;">
                        @if($package->cover_image_url)
                            <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-[#111111]"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-[#C9A84C] text-xs uppercase tracking-widest font-medium">Package</span>
                            <h3 class="text-white text-2xl font-bold mt-1 font-serif group-hover:text-[#C9A84C] transition-colors duration-300">{{ $package->name }}</h3>
                            @if($package->tagline)
                                <p class="text-gray-300 mt-1 text-sm">{{ $package->tagline }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA Section --}}
    <section class="py-20 bg-[#0D0D0D]">
        <div class="max-w-3xl mx-auto px-6 text-center" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
            <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Need Something Custom?</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 font-serif">Let Us Craft Your Perfect Menu</h2>
            <p class="text-gray-400 mt-4">Can't find what you're looking for? We specialize in creating custom menus tailored to your event's requirements and preferences.</p>
            <a href="{{ route('contact') }}" class="inline-block mt-8 border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                Get In Touch
            </a>
        </div>
    </section>

@endsection

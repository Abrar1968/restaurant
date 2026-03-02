@extends('layouts.front')
@section('title', 'Sanjung Delights — Premier Halal Corporate Catering')
@section('meta_description', $settings['meta_description'] ?? 'Sanjung Delights — Premier Halal Corporate Catering in KL & Klang Valley. Fantastic food, business class service.')
@section('content')

    {{-- Section 1: Hero --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? $settings['hero_headline'] ?? 'Halal Corporate Catering in KL & Klang Valley',
        'subheadline' => $hero?->subheadline ?? $settings['hero_subtext'] ?? 'Fantastic Food, Business Class Service',
        'eyebrow' => 'Premier Halal Corporate Catering',
        'ctaText' => $hero?->cta_text ?? 'Explore Our Menu',
        'ctaUrl' => $hero?->cta_url ?? route('menu'),
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Section 2: Second Hero / Feature Banner with Parallax --}}
    <section class="min-h-[70vh] relative flex items-center justify-center parallax-bg" style="background-image: url('{{ asset('images/feature-bg.jpg') }}');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 text-center max-w-3xl mx-auto px-6">
            <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-sm font-medium" data-animate="animate-fade-in" data-delay="0s" style="opacity:0;">Sanjung Delights</span>
            <h2 class="text-3xl md:text-5xl font-bold text-white mt-4 font-serif" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">Fantastic Food Business Class Service</h2>
            <p class="text-gray-300 mt-4 max-w-xl mx-auto" data-animate="animate-fade-in-up" data-delay="0.4s" style="opacity:0;">We deliver exceptional catering experiences for corporate events, conferences, and special occasions across KL & Klang Valley.</p>
            <div class="mt-8" data-animate="animate-fade-in-up" data-delay="0.6s" style="opacity:0;">
                <a href="{{ route('contact') }}" class="inline-block border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                    Get In Touch
                </a>
            </div>
        </div>
    </section>

    {{-- Section 3: Promotional Package Carousel --}}
    @if($packages->count())
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-12" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Special Offers</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Our Packages</h2>
            </div>

            <div x-data="{ current: 0, total: {{ $packages->count() }} }" class="relative">
                <div class="overflow-hidden rounded-lg">
                    <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 100) + '%)'">
                        @foreach($packages as $package)
                            <div class="w-full flex-shrink-0 px-2">
                                <a href="{{ route('menu.package', $package->slug) }}" class="group relative block overflow-hidden rounded-lg shadow-xl h-[400px] shimmer-effect">
                                    @if($package->cover_image_url)
                                        <img src="{{ $package->cover_image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full bg-[#111111]"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-6">
                                        <h3 class="text-white text-2xl font-bold font-serif">{{ $package->name }}</h3>
                                        @if($package->tagline)
                                            <p class="text-gray-300 mt-1">{{ $package->tagline }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Carousel Controls --}}
                <button @click="current = (current - 1 + total) % total"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-[#C9A84C] text-white rounded-full flex items-center justify-center transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="current = (current + 1) % total"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/50 hover:bg-[#C9A84C] text-white rounded-full flex items-center justify-center transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>

                {{-- Dots --}}
                <div class="flex justify-center gap-2 mt-6">
                    @foreach($packages as $i => $p)
                        <button @click="current = {{ $i }}"
                                :class="current === {{ $i }} ? 'bg-[#C9A84C]' : 'bg-white/20'"
                                class="w-2.5 h-2.5 rounded-full transition-colors duration-200"></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Section 4: Menu Teaser Card --}}
    <section class="py-20 md:py-28 bg-[#0A0A0A]">
        <div class="max-w-5xl mx-auto px-6 md:px-12">
            <a href="{{ route('menu') }}" class="group relative block overflow-hidden rounded-lg shadow-2xl h-[350px]" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <div class="w-full h-full bg-[#111111] bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('{{ asset('images/menu-teaser.jpg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <span class="text-[#C9A84C] text-xs uppercase tracking-[0.3em] font-medium">Explore Our</span>
                    <h2 class="text-white text-3xl md:text-4xl font-bold mt-1 font-serif group-hover:text-[#C9A84C] transition-colors duration-300">Curated Menus</h2>
                </div>
            </a>
        </div>
    </section>

    {{-- Section 5: About Section (Two-Column) --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            {{-- Left Column --}}
            <div data-animate="animate-slide-in-left" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">About Us</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Sanjung Delights</h2>
                <p class="text-[#C9A84C] italic mt-2">Premier Halal Corporate Catering Since 2010</p>
                <div class="text-gray-400 leading-relaxed mt-6 space-y-4">
                    <p>{{ $settings['about_text'] ?? 'Sanjung Delights is the catering arm of Sanjung Waja Resources, established in 2010, serving the finest halal corporate catering in KL and the Klang Valley.' }}</p>
                </div>
                <a href="{{ route('about') }}" class="inline-block mt-8 border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                    More About Us
                </a>
            </div>

            {{-- Right Column --}}
            <div data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                <h3 class="text-xl font-bold text-white font-serif">The Sanjung Standard in Corporate Catering</h3>
                <div class="text-gray-400 leading-relaxed mt-4 space-y-4">
                    <p>We pride ourselves on delivering exceptional dining experiences that combine culinary excellence with professional service. Every dish is prepared with the freshest ingredients and certified halal.</p>
                    <p>From intimate boardroom lunches to large-scale corporate events, our team ensures every detail meets the highest standards.</p>
                </div>
                <div class="border border-[#C9A84C]/40 bg-[#C9A84C]/5 rounded-lg p-6 mt-6">
                    <h4 class="text-[#C9A84C] font-bold text-lg font-serif">Our Commitment to Halal Integrity</h4>
                    <p class="text-gray-400 mt-2 text-sm">All our food preparation strictly adheres to JAKIM halal certification standards. Our kitchen and supply chain are fully halal-certified.</p>
                    <a href="{{ route('certifications') }}" class="text-[#C9A84C] text-sm font-medium mt-3 inline-block hover:underline">View Certificate →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Section 6: Cuisine Category Cards --}}
    @if($cuisines->count())
    <section class="py-20 md:py-28 bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-12" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">What We Offer</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Our Cuisines</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($cuisines as $i => $cuisine)
                    <a href="{{ route('menu.show', $cuisine->slug) }}"
                       class="group relative block overflow-hidden rounded-lg shadow-2xl h-[380px]"
                       data-animate="animate-fade-in-up" data-delay="{{ $i * 0.15 }}s" style="opacity:0;">
                        @if($cuisine->image_url)
                            <img src="{{ $cuisine->image_url }}" alt="{{ $cuisine->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-[#111111]"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <span class="text-[#C9A84C] text-xs uppercase tracking-widest font-medium">Halal Compliant</span>
                            <h3 class="text-white text-2xl font-bold mt-1 font-serif group-hover:text-[#C9A84C] transition-colors duration-300">{{ $cuisine->name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Section 7: Client Logo Marquee --}}
    @if($clients->count())
    <section class="overflow-hidden py-12 bg-[#0A0A0A]">
        <div class="text-center mb-8">
            <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Trusted By</span>
        </div>
        <div class="flex animate-marquee whitespace-nowrap" style="width: 200%;">
            @foreach($clients as $client)
                @if($client->logo_url)
                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="h-12 mx-10 object-contain grayscale hover:grayscale-0 transition-all duration-300 opacity-60 hover:opacity-100">
                @endif
            @endforeach
            {{-- Duplicate for seamless loop --}}
            @foreach($clients as $client)
                @if($client->logo_url)
                    <img src="{{ $client->logo_url }}" alt="{{ $client->name }}" class="h-12 mx-10 object-contain grayscale hover:grayscale-0 transition-all duration-300 opacity-60 hover:opacity-100">
                @endif
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('clients') }}" class="text-[#C9A84C] text-sm font-medium hover:underline">View All Clients →</a>
        </div>
    </section>
    @endif

@endsection

@extends('layouts.front')
@section('title', 'Our Clients — Sanjung Delights')
@section('meta_description', 'Trusted by leading corporations and organizations across KL & Klang Valley for premium halal corporate catering.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Clients',
        'subheadline' => $hero?->subheadline ?? 'Trusted by leading corporations across Malaysia',
        'eyebrow' => 'Partnerships',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Client Logo Grid --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Trusted Partnerships</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Companies We've Served</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Over the years, we have had the privilege of catering for some of Malaysia's most prestigious organizations and corporations.</p>
            </div>

            @if($clients->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach($clients as $i => $client)
                    <div class="group bg-[#111111] border border-white/5 rounded-lg p-6 flex items-center justify-center h-32 hover:border-[#C9A84C]/40 hover:bg-[#1A1A1A] transition-all duration-300"
                         data-animate="animate-fade-in-up" data-delay="{{ ($i % 10) * 0.05 }}s" style="opacity:0;">
                        @if($client->logo_url)
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
                                 class="max-h-16 max-w-full object-contain grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                                 title="{{ $client->name }}">
                        @else
                            <span class="text-gray-600 text-sm font-medium text-center">{{ $client->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            @else
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">Client list coming soon.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-16 bg-[#0A0A0A]">
        <div class="max-w-3xl mx-auto px-6 text-center" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
            <h2 class="text-3xl md:text-4xl font-bold text-white font-serif">Ready to Join Our Client List?</h2>
            <p class="text-gray-400 mt-4">Experience the Sanjung Delights difference. Let us cater your next corporate event with premium halal cuisine and business-class service.</p>
            <a href="{{ route('contact') }}" class="inline-block mt-8 border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                Contact Us Today
            </a>
        </div>
    </section>

@endsection

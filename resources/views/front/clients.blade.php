@extends('layouts.front')
@section('title', 'Our Clients — Sanjung Delights')
@section('meta_description', 'Trusted by leading corporations and organizations across KL & Klang Valley for premium halal corporate catering.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Clients',
        'subheadline' => $hero?->subheadline ?? 'Trusted by leading corporations across Malaysia',
        'eyebrow' => 'Partnerships',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay">
        <div class="p-8 lg:p-10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Trusted Partnerships</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Companies We've Served</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>
            <p class="text-white/50 text-xs leading-relaxed mb-8">Over the years, we have had the privilege of catering for some of Malaysia's most prestigious organizations.</p>

            @if($clients->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($clients as $client)
                    <div class="group bg-white/5 border border-white/5 p-5 flex items-center justify-center h-24 hover:border-gold/30 hover:bg-white/10 transition-all duration-300">
                        @if($client->logo_url)
                            <img src="{{ $client->logo_url }}" alt="{{ $client->name }}"
                                 class="max-h-12 max-w-full object-contain grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                                 title="{{ $client->name }}">
                        @else
                            <span class="text-white/40 text-[10px] font-medium text-center uppercase tracking-wider">{{ $client->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            @else
                <div class="text-center py-10">
                    <p class="text-white/50 text-sm">Client list coming soon.</p>
                </div>
            @endif
        </div>

        {{-- CTA --}}
        <div class="px-8 lg:px-10 pb-8">
            <div class="marble-bg p-6 text-center">
                <h3 class="text-green-deep text-sm font-serif italic font-semibold">Join Our Client List</h3>
                <p class="text-green-deep/60 text-xs mt-2">Experience the Sanjung Delights difference for your next corporate event.</p>
                <a href="{{ route('contact') }}" class="inline-block mt-4 bg-green-deep text-gold px-6 py-2 uppercase tracking-[0.2em] text-[10px] font-medium hover:bg-green-dark transition-all duration-300">
                    Contact Us Today
                </a>
            </div>
        </div>

        {{-- Footer in Panel --}}
        <div class="p-8 lg:p-10 border-t border-white/10 text-center">
            <p class="text-white/30 text-[10px] uppercase tracking-[0.2em]">&copy; {{ date('Y') }} Sanjung Delights. All rights reserved.</p>
        </div>
    </div>

@endsection

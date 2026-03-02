@extends('layouts.front')
@section('title', 'Certifications — Sanjung Delights')
@section('meta_description', 'Our halal certifications and quality standards — JAKIM certified halal corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Certifications',
        'subheadline' => $hero?->subheadline ?? 'Committed to the highest halal and quality standards',
        'eyebrow' => 'Quality Assurance',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay"
         x-data="{ lightbox: false, lightboxImage: '', lightboxName: '' }">

        {{-- Section Header --}}
        <div class="p-8 lg:p-10 pb-4">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Verified Standards</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Official Certifications</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>
            <p class="text-white/50 text-xs leading-relaxed">Our commitment to halal integrity is backed by recognized certification bodies.</p>
        </div>

        {{-- Certifications List --}}
        <div class="px-8 lg:px-10 pb-8 space-y-4">
            @if($certifications->count())
                @foreach($certifications as $cert)
                    <div class="bg-white/5 border border-white/5 hover:border-gold/30 transition-all duration-300 group overflow-hidden">
                        <div class="flex">
                            {{-- Certificate Image --}}
                            <div class="w-28 flex-shrink-0 bg-white/90 flex items-center justify-center p-3">
                                @if($cert->certificate_image_url)
                                    <img src="{{ $cert->certificate_image_url }}" alt="{{ $cert->name }}"
                                         class="max-w-full max-h-20 object-contain cursor-pointer"
                                         @click="lightbox = true; lightboxImage = '{{ $cert->certificate_image_url }}'; lightboxName = '{{ e($cert->name) }}'">
                                @else
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 p-4">
                                <h3 class="text-white text-sm font-serif italic group-hover:text-gold transition-colors">{{ $cert->name }}</h3>
                                @if($cert->issuing_body)
                                    <p class="text-gold text-[10px] font-medium mt-0.5">{{ $cert->issuing_body }}</p>
                                @endif
                                @if($cert->description)
                                    <p class="text-white/40 text-xs mt-1.5 leading-relaxed line-clamp-2">{{ Str::limit($cert->description, 100) }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-white/30 text-[10px]">
                                        @if($cert->valid_from && $cert->valid_until)
                                            {{ $cert->valid_from->format('M Y') }} — {{ $cert->valid_until->format('M Y') }}
                                        @elseif($cert->valid_until)
                                            Valid until: {{ $cert->valid_until->format('M Y') }}
                                        @endif
                                    </span>
                                    @if($cert->certificate_image_url)
                                        <button @click="lightbox = true; lightboxImage = '{{ $cert->certificate_image_url }}'; lightboxName = '{{ e($cert->name) }}'"
                                                class="text-gold text-[10px] font-medium hover:underline">
                                            View Full &rarr;
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-10">
                    <p class="text-white/50 text-sm">Certification details coming soon.</p>
                </div>
            @endif
        </div>

        {{-- Halal Promise --}}
        <div class="px-8 lg:px-10 pb-8">
            <div class="marble-bg p-6 text-center">
                <h3 class="text-green-deep text-sm font-serif italic font-semibold">Our Halal Promise</h3>
                <p class="text-green-deep/70 text-xs mt-2 leading-relaxed">{{ $settings['halal_promise'] ?? 'Every ingredient, every process, and every dish we serve is fully JAKIM halal-certified.' }}</p>
                <a href="{{ route('contact') }}" class="inline-block mt-4 bg-green-deep text-gold px-6 py-2 uppercase tracking-[0.2em] text-[10px] font-medium hover:bg-green-dark transition-all duration-300">
                    Learn More
                </a>
            </div>
        </div>

        {{-- Footer in Panel --}}
        <div class="p-8 lg:p-10 border-t border-white/10 text-center">
            <p class="text-white/30 text-[10px] uppercase tracking-[0.2em]">&copy; {{ date('Y') }} Sanjung Delights. All rights reserved.</p>
        </div>

        {{-- Lightbox --}}
        <div x-show="lightbox"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click.self="lightbox = false"
             @keydown.escape.window="lightbox = false"
             class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-6"
             style="display: none;">
            <button @click="lightbox = false" class="absolute top-6 right-6 text-white hover:text-gold transition-colors duration-200 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="max-w-4xl w-full bg-white rounded-lg p-8">
                <img :src="lightboxImage" :alt="lightboxName" class="w-full max-h-[75vh] object-contain">
                <p class="text-gray-800 text-center mt-4 font-bold text-lg" x-text="lightboxName"></p>
            </div>
        </div>
    </div>

@endsection

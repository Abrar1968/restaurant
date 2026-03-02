@extends('layouts.front')
@section('title', 'Certifications — Sanjung Delights')
@section('meta_description', 'Our halal certifications and quality standards — JAKIM certified halal corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Certifications',
        'subheadline' => $hero?->subheadline ?? 'Committed to the highest halal and quality standards',
        'eyebrow' => 'Quality Assurance',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Certifications Grid --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]"
             x-data="{ lightbox: false, lightboxImage: '', lightboxName: '' }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Verified Standards</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Halal & Quality Certifications</h2>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Our commitment to halal integrity is backed by recognized certification bodies. Every aspect of our operations meets the strictest standards.</p>
            </div>

            @if($certifications->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($certifications as $i => $cert)
                    <div class="group rounded-lg overflow-hidden border border-white/5 hover:border-[#C9A84C]/40 transition-all duration-300 hover:shadow-lg hover:shadow-[#C9A84C]/5"
                         data-animate="animate-fade-in-up" data-delay="{{ $i * 0.1 }}s" style="opacity:0;">

                        {{-- White Top — Certificate Image --}}
                        <div class="bg-white p-8 flex items-center justify-center h-64 relative overflow-hidden">
                            @if($cert->certificate_image_url)
                                <img src="{{ $cert->certificate_image_url }}" alt="{{ $cert->name }}"
                                     class="max-w-full max-h-full object-contain transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Dark Bottom Strip — Details --}}
                        <div class="bg-[#111111] p-6">
                            <h3 class="text-white font-bold text-lg font-serif group-hover:text-[#C9A84C] transition-colors duration-300">{{ $cert->name }}</h3>
                            @if($cert->issuing_body)
                                <p class="text-[#C9A84C] text-sm font-medium mt-1">{{ $cert->issuing_body }}</p>
                            @endif
                            @if($cert->description)
                                <p class="text-gray-400 text-sm mt-3 leading-relaxed">{{ Str::limit($cert->description, 100) }}</p>
                            @endif
                            <div class="flex items-center justify-between mt-4">
                                <div class="text-gray-500 text-xs">
                                    @if($cert->valid_from && $cert->valid_until)
                                        Valid: {{ $cert->valid_from->format('M Y') }} — {{ $cert->valid_until->format('M Y') }}
                                    @elseif($cert->valid_until)
                                        Valid until: {{ $cert->valid_until->format('M Y') }}
                                    @endif
                                </div>
                                @if($cert->certificate_image_url)
                                    <button @click="lightbox = true; lightboxImage = '{{ $cert->certificate_image_url }}'; lightboxName = '{{ e($cert->name) }}'"
                                            class="text-[#C9A84C] text-sm font-medium hover:underline">
                                        View Full →
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">Certification details coming soon.</p>
                </div>
            @endif
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
            <button @click="lightbox = false" class="absolute top-6 right-6 text-white hover:text-[#C9A84C] transition-colors duration-200 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="max-w-4xl w-full bg-white rounded-lg p-8">
                <img :src="lightboxImage" :alt="lightboxName" class="w-full max-h-[75vh] object-contain">
                <p class="text-gray-800 text-center mt-4 font-bold text-lg" x-text="lightboxName"></p>
            </div>
        </div>
    </section>

    {{-- Halal Commitment CTA --}}
    <section class="py-16 bg-[#0A0A0A]">
        <div class="max-w-3xl mx-auto px-6 text-center" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
            <div class="border border-[#C9A84C]/30 bg-[#C9A84C]/5 rounded-lg p-10">
                <h3 class="text-[#C9A84C] text-2xl font-bold font-serif">Our Halal Promise</h3>
                <p class="text-gray-400 mt-4 leading-relaxed">{{ $settings['halal_promise'] ?? 'Every ingredient, every process, and every dish we serve is fully JAKIM halal-certified. Our commitment to halal integrity is absolute and uncompromising.' }}</p>
                <a href="{{ route('contact') }}" class="inline-block mt-6 border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                    Learn More
                </a>
            </div>
        </div>
    </section>

@endsection

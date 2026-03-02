@extends('layouts.front')
@section('title', 'Gallery — Sanjung Delights')
@section('meta_description', 'Browse our gallery of halal corporate catering events, dishes, and behind-the-scenes moments.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Gallery',
        'subheadline' => $hero?->subheadline ?? 'A visual showcase of our culinary creations and catered events',
        'eyebrow' => 'Visual Portfolio',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Gallery Section --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]"
             x-data="{ activeFilter: 'all', lightbox: false, lightboxImage: '', lightboxCaption: '' }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            {{-- Section Header --}}
            <div class="text-center mb-12" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Our Work</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Photo Gallery</h2>
            </div>

            {{-- Filter Buttons --}}
            @if($categories->count())
            <div class="flex flex-wrap justify-center gap-3 mb-12" data-animate="animate-fade-in-up" data-delay="0.1s" style="opacity:0;">
                <button @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-[#C9A84C] text-black border-[#C9A84C]' : 'bg-transparent text-[#C9A84C] border-[#C9A84C]/40 hover:border-[#C9A84C]'"
                        class="px-6 py-2 border rounded-sm uppercase tracking-widest text-xs font-semibold transition-all duration-300">
                    All
                </button>
                @foreach($categories as $category)
                    <button @click="activeFilter = '{{ $category->slug }}'"
                            :class="activeFilter === '{{ $category->slug }}' ? 'bg-[#C9A84C] text-black border-[#C9A84C]' : 'bg-transparent text-[#C9A84C] border-[#C9A84C]/40 hover:border-[#C9A84C]'"
                            class="px-6 py-2 border rounded-sm uppercase tracking-widest text-xs font-semibold transition-all duration-300">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            @endif

            {{-- Filterable Image Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $i => $image)
                    <div x-show="activeFilter === 'all' || activeFilter === '{{ $image->category?->slug }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="group relative overflow-hidden rounded-lg cursor-pointer aspect-square"
                         @click="lightbox = true; lightboxImage = '{{ $image->image_url }}'; lightboxCaption = '{{ e($image->caption ?? '') }}'"
                         data-animate="animate-fade-in-up" data-delay="{{ ($i % 8) * 0.05 }}s" style="opacity:0;">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $image->caption ?? 'Gallery image' }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                            {{-- Magnify Icon --}}
                            <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                        @if($image->caption)
                            <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-xs">{{ $image->caption }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            @if($images->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">Gallery images coming soon.</p>
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
            <div class="max-w-5xl w-full">
                <img :src="lightboxImage" :alt="lightboxCaption" class="w-full max-h-[80vh] object-contain rounded-lg">
                <p class="text-white text-center mt-4 text-sm" x-text="lightboxCaption" x-show="lightboxCaption"></p>
            </div>
        </div>
    </section>

@endsection

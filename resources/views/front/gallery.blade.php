@extends('layouts.front')
@section('title', 'Gallery — Sanjung Delights')
@section('meta_description', 'Browse our gallery of halal corporate catering events, dishes, and behind-the-scenes moments.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Gallery',
        'subheadline' => $hero?->subheadline ?? 'A visual showcase of our culinary creations and catered events',
        'eyebrow' => 'Visual Portfolio',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay"
         x-data="{ activeFilter: 'all', lightbox: false, lightboxImage: '', lightboxCaption: '' }">

        {{-- Section Header --}}
        <div class="p-8 lg:p-10 pb-4">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Our Work</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Photo Gallery</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>

            {{-- Filter Buttons --}}
            @if($categories->count())
            <div class="flex flex-wrap gap-2 mb-2">
                <button @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-gold text-green-deep border-gold' : 'bg-transparent text-gold border-gold/30 hover:border-gold'"
                        class="px-4 py-1.5 border text-[10px] uppercase tracking-widest font-medium transition-all duration-300">
                    All
                </button>
                @foreach($categories as $category)
                    <button @click="activeFilter = '{{ $category->slug }}'"
                            :class="activeFilter === '{{ $category->slug }}' ? 'bg-gold text-green-deep border-gold' : 'bg-transparent text-gold border-gold/30 hover:border-gold'"
                            class="px-4 py-1.5 border text-[10px] uppercase tracking-widest font-medium transition-all duration-300">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Image Grid --}}
        <div class="px-8 lg:px-10 pb-8">
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($images as $i => $image)
                    <div x-show="activeFilter === 'all' || activeFilter === '{{ $image->category?->slug }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="group relative overflow-hidden cursor-pointer aspect-square border border-white/5 hover:border-gold/30 transition-all duration-300"
                         @click="lightbox = true; lightboxImage = '{{ $image->image_url }}'; lightboxCaption = '{{ e($image->caption ?? '') }}'">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $image->caption ?? 'Gallery image' }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                        @if($image->caption)
                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-[10px]">{{ $image->caption }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($images->isEmpty())
                <div class="text-center py-10">
                    <p class="text-white/50 text-sm">Gallery images coming soon.</p>
                </div>
            @endif
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
            <div class="max-w-5xl w-full">
                <img :src="lightboxImage" :alt="lightboxCaption" class="w-full max-h-[80vh] object-contain rounded-lg">
                <p class="text-white text-center mt-4 text-sm" x-text="lightboxCaption" x-show="lightboxCaption"></p>
            </div>
        </div>
    </div>

@endsection

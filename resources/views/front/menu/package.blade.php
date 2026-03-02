@extends('layouts.front')
@section('title', $package->name . ' — Sanjung Delights')
@section('meta_description', 'Explore our ' . $package->name . ' package — premium halal catering for corporate events in KL & Klang Valley.')
@section('content')

    {{-- Hero with Package Cover Image --}}
    @include('components.front.hero', [
        'headline' => $package->name,
        'subheadline' => $package->tagline ?? 'A curated package for your special occasion',
        'eyebrow' => 'Special Package',
        'ctaText' => 'Enquire Now',
        'ctaUrl' => route('contact'),
        'backgroundImage' => $package->cover_image_url,
    ])

    {{-- Package Details --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- Left: Description & Inclusions (3 cols) --}}
                <div class="lg:col-span-3" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                    <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Package Details</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 font-serif">{{ $package->name }}</h2>

                    @if($package->description)
                        <div class="text-gray-400 leading-relaxed mt-6 space-y-4">
                            {!! nl2br(e($package->description)) !!}
                        </div>
                    @endif

                    {{-- Package Inclusions --}}
                    @if($package->items->count())
                    <div class="mt-10">
                        <h3 class="text-white text-xl font-bold font-serif mb-6">What's Included</h3>
                        <div class="space-y-4">
                            @foreach($package->items as $item)
                                <div class="bg-[#111111] rounded-lg p-5 border border-white/5 hover:border-[#C9A84C]/30 transition-all duration-300">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h4 class="text-white font-bold">{{ $item->name }}</h4>
                                            @if($item->description)
                                                <p class="text-gray-400 text-sm mt-1">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                        @if($item->price)
                                            <div class="text-right flex-shrink-0">
                                                <span class="text-[#C9A84C] font-bold text-lg">RM{{ number_format($item->price, 2) }}</span>
                                                @if($item->price_label)
                                                    <p class="text-gray-500 text-xs mt-0.5">{{ $item->price_label }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Right: Pricing Sidebar (2 cols) --}}
                <div class="lg:col-span-2" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                    <div class="bg-[#111111] border border-[#C9A84C]/20 rounded-lg p-8 sticky top-24">
                        <h3 class="text-[#C9A84C] text-xs uppercase tracking-widest font-medium">Pricing</h3>
                        <div class="mt-6">
                            @if($package->items->count())
                                <table class="w-full">
                                    <tbody class="divide-y divide-white/5">
                                        @foreach($package->items->where('price', '>', 0) as $item)
                                            <tr>
                                                <td class="py-3 text-gray-300 text-sm">{{ $item->name }}</td>
                                                <td class="py-3 text-[#C9A84C] font-bold text-right">RM{{ number_format($item->price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($package->items->where('price', '>', 0)->count() > 1)
                                <div class="border-t border-[#C9A84C]/30 mt-2 pt-4 flex justify-between items-center">
                                    <span class="text-white font-bold">Starting From</span>
                                    <span class="text-[#C9A84C] font-bold text-xl">RM{{ number_format($package->items->where('price', '>', 0)->min('price'), 2) }}</span>
                                </div>
                                @endif
                            @else
                                <p class="text-gray-400 text-sm">Contact us for pricing details.</p>
                            @endif
                        </div>

                        <p class="text-gray-500 text-xs mt-4">{{ $settings['sst_notice'] ?? 'All prices are subject to 8% SST.' }}</p>

                        <a href="{{ route('contact') }}" class="block mt-6 text-center border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-6 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                            Enquire Now
                        </a>

                        <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '60179605366' }}?text={{ urlencode('Hi, I\'m interested in the ' . $package->name . ' package.') }}"
                           target="_blank"
                           class="block mt-3 text-center bg-[#25D366] text-white px-6 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold hover:opacity-90 transition-opacity duration-200">
                            WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery of Package Dishes --}}
    @if($package->images->count())
    <section class="py-20 md:py-28 bg-[#0A0A0A]"
             x-data="{ lightbox: false, lightboxImage: '', lightboxCaption: '' }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-12" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Visual Showcase</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Package Gallery</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($package->images as $i => $image)
                    <div class="group relative overflow-hidden rounded-lg cursor-pointer aspect-square"
                         @click="lightbox = true; lightboxImage = '{{ $image->image_url }}'; lightboxCaption = '{{ e($image->caption ?? $package->name) }}'"
                         data-animate="animate-fade-in-up" data-delay="{{ $i * 0.05 }}s" style="opacity:0;">
                        <img src="{{ $image->image_url }}" alt="{{ $image->caption ?? $package->name }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
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
            <button @click="lightbox = false" class="absolute top-6 right-6 text-white hover:text-[#C9A84C] transition-colors duration-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="max-w-4xl w-full">
                <img :src="lightboxImage" :alt="lightboxCaption" class="w-full max-h-[80vh] object-contain rounded-lg">
                <p class="text-white text-center mt-4 text-sm" x-text="lightboxCaption"></p>
            </div>
        </div>
    </section>
    @endif

    {{-- Back to Menu --}}
    <section class="py-12 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
            <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 text-[#C9A84C] text-sm font-medium hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to All Menus
            </a>
        </div>
    </section>

@endsection

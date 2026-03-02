@extends('layouts.front')
@section('title', $menu->name . ' Menu — Sanjung Delights')
@section('meta_description', 'Explore our ' . $menu->name . ' menu — authentic halal dishes for corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Hero with Cuisine Name --}}
    @include('components.front.hero', [
        'headline' => $menu->name,
        'subheadline' => $menu->description ?? 'Authentic halal dishes crafted with premium ingredients',
        'eyebrow' => 'Our Menu',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $menu->image_url,
    ])

    {{-- Category Tabs & Menu Items --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]"
             x-data="{ activeTab: '{{ $menu->categories->first()?->id ?? 'all' }}' }">
        <div class="max-w-7xl mx-auto px-6 md:px-12">

            {{-- Section Header --}}
            <div class="text-center mb-12" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">{{ $menu->name }}</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Menu Selection</h2>
            </div>

            {{-- Category Tab Buttons --}}
            @if($menu->categories->count() > 1)
            <div class="flex flex-wrap justify-center gap-3 mb-12" data-animate="animate-fade-in-up" data-delay="0.1s" style="opacity:0;">
                <button @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-[#C9A84C] text-black border-[#C9A84C]' : 'bg-transparent text-[#C9A84C] border-[#C9A84C]/40 hover:border-[#C9A84C]'"
                        class="px-6 py-2 border rounded-sm uppercase tracking-widest text-xs font-semibold transition-all duration-300">
                    All
                </button>
                @foreach($menu->categories as $category)
                    <button @click="activeTab = '{{ $category->id }}'"
                            :class="activeTab === '{{ $category->id }}' ? 'bg-[#C9A84C] text-black border-[#C9A84C]' : 'bg-transparent text-[#C9A84C] border-[#C9A84C]/40 hover:border-[#C9A84C]'"
                            class="px-6 py-2 border rounded-sm uppercase tracking-widest text-xs font-semibold transition-all duration-300">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            @endif

            {{-- Menu Items Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($menu->categories as $category)
                    @foreach($category->items->where('is_available', true) as $item)
                        <div x-show="activeTab === 'all' || activeTab === '{{ $category->id }}'"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="bg-[#111111] rounded-lg overflow-hidden border border-white/5 hover:border-[#C9A84C]/30 transition-all duration-300 group flex">

                            {{-- Food Photo --}}
                            @if($item->image_url)
                                <div class="w-32 md:w-40 flex-shrink-0 overflow-hidden">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                            @endif

                            {{-- Item Details --}}
                            <div class="flex-1 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-white font-bold text-lg group-hover:text-[#C9A84C] transition-colors duration-300">{{ $item->name }}</h3>
                                        @if($item->description)
                                            <p class="text-gray-400 text-sm mt-1 line-clamp-2">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        @if($item->price)
                                            <span class="text-[#C9A84C] font-bold text-lg">RM{{ number_format($item->price, 2) }}</span>
                                        @endif
                                        @if($item->price_note)
                                            <p class="text-gray-500 text-xs mt-0.5">{{ $item->price_note }}</p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Tags --}}
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @if($item->is_halal)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#C9A84C]/10 text-[#C9A84C] text-xs rounded-sm font-medium">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Halal
                                        </span>
                                    @endif
                                    @if($item->tags)
                                        @foreach($item->tags as $tag)
                                            <span class="px-2 py-0.5 bg-white/5 text-gray-400 text-xs rounded-sm">{{ $tag }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>

            {{-- Empty State --}}
            @if($menu->categories->isEmpty() || $menu->items->where('is_available', true)->isEmpty())
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">Menu items coming soon. Please contact us for the latest menu.</p>
                    <a href="{{ route('contact') }}" class="inline-block mt-6 border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                        Contact Us
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Back to Menu Link --}}
    <section class="py-12 bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto px-6 md:px-12 text-center">
            <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 text-[#C9A84C] text-sm font-medium hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to All Menus
            </a>
        </div>
    </section>

@endsection

@extends('layouts.front')
@section('title', $menu->name . ' Menu — Sanjung Delights')
@section('meta_description', 'Explore our ' . $menu->name . ' menu — authentic halal dishes for corporate catering in KL & Klang Valley.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $menu->name,
        'subheadline' => $menu->description ?? 'Authentic halal dishes crafted with premium ingredients',
        'eyebrow' => 'Our Menu',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $menu->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay"
         x-data="{ activeTab: '{{ $menu->categories->first()?->id ?? 'all' }}' }">

        {{-- Section Header --}}
        <div class="p-8 lg:p-10 pb-4">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">{{ $menu->name }}</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Menu Selection</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>

            {{-- Category Tab Buttons --}}
            @if($menu->categories->count() > 1)
            <div class="flex flex-wrap gap-2 mb-2">
                <button @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-gold text-green-deep border-gold' : 'bg-transparent text-gold border-gold/30 hover:border-gold'"
                        class="px-4 py-1.5 border text-[10px] uppercase tracking-widest font-medium transition-all duration-300">
                    All
                </button>
                @foreach($menu->categories as $category)
                    <button @click="activeTab = '{{ $category->id }}'"
                            :class="activeTab === '{{ $category->id }}' ? 'bg-gold text-green-deep border-gold' : 'bg-transparent text-gold border-gold/30 hover:border-gold'"
                            class="px-4 py-1.5 border text-[10px] uppercase tracking-widest font-medium transition-all duration-300">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Menu Items --}}
        <div class="px-8 lg:px-10 pb-8 space-y-3">
            @foreach($menu->categories as $category)
                @foreach($category->items->where('is_available', true) as $item)
                    <div x-show="activeTab === 'all' || activeTab === '{{ $category->id }}'"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white/5 rounded-lg overflow-hidden border border-white/5 hover:border-gold/30 transition-all duration-300 group flex">

                        @if($item->image_url)
                            <div class="w-24 flex-shrink-0 overflow-hidden">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </div>
                        @endif

                        <div class="flex-1 p-4">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h3 class="text-white text-sm font-serif italic group-hover:text-gold transition-colors">{{ $item->name }}</h3>
                                    @if($item->description)
                                        <p class="text-white/50 text-xs mt-0.5 line-clamp-1">{{ $item->description }}</p>
                                    @endif
                                </div>
                                @if($item->price)
                                    <span class="text-gold font-serif italic text-sm flex-shrink-0">RM{{ number_format($item->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="flex flex-wrap gap-1.5 mt-2">
                                @if($item->is_halal)
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-gold/10 text-gold text-[10px] font-medium">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Halal
                                    </span>
                                @endif
                                @if($item->tags)
                                    @foreach($item->tags as $tag)
                                        <span class="px-1.5 py-0.5 bg-white/5 text-white/40 text-[10px]">{{ $tag }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @if($menu->categories->isEmpty() || $menu->items->where('is_available', true)->isEmpty())
                <div class="text-center py-10">
                    <p class="text-white/50 text-sm">Menu items coming soon.</p>
                    <a href="{{ route('contact') }}" class="inline-block mt-4 border border-gold/40 text-gold px-6 py-2 uppercase tracking-[0.2em] text-[10px] font-medium hover:bg-gold hover:text-green-deep transition-all duration-300">
                        Contact Us
                    </a>
                </div>
            @endif
        </div>

        {{-- Back to Menu --}}
        <div class="p-8 lg:p-10 border-t border-white/10 text-center">
            <a href="{{ route('menu') }}" class="inline-flex items-center gap-2 text-gold text-xs font-medium hover:underline">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to All Menus
            </a>
        </div>
    </div>

@endsection

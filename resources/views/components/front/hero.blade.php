@props([
    'headline' => '',
    'subheadline' => '',
    'eyebrow' => '',
    'ctaText' => '',
    'ctaUrl' => '#',
    'backgroundImage' => null,
    'fullHeight' => true,
])

<section class="{{ $fullHeight ? 'min-h-screen' : 'min-h-[70vh]' }} relative flex items-center justify-center overflow-hidden">
    {{-- Background Image with Ken Burns --}}
    @if($backgroundImage)
        <div class="absolute inset-0">
            <img src="{{ $backgroundImage }}" alt="" class="w-full h-full object-cover animate-ken-burns">
        </div>
    @endif
    <div class="absolute inset-0 bg-black/50"></div>

    {{-- Content --}}
    <div class="relative z-10 text-center max-w-4xl mx-auto px-6">
        @if($eyebrow)
            <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-sm font-medium" data-animate="animate-fade-in" data-delay="0s" style="opacity:0;">
                {{ $eyebrow }}
            </span>
        @endif

        @if($headline)
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mt-4 font-serif" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                {{ $headline }}
            </h1>
        @endif

        @if($subheadline)
            <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto mt-4" data-animate="animate-fade-in-up" data-delay="0.4s" style="opacity:0;">
                {{ $subheadline }}
            </p>
        @endif

        @if($ctaText)
            <div class="mt-8" data-animate="animate-fade-in-up" data-delay="0.6s" style="opacity:0;">
                <a href="{{ $ctaUrl }}"
                   class="inline-block border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                    {{ $ctaText }}
                </a>
            </div>
        @endif

    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

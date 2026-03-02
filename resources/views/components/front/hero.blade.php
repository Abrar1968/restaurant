@props([
    'headline' => '',
    'subheadline' => '',
    'eyebrow' => '',
    'ctaText' => '',
    'ctaUrl' => '#',
    'backgroundImage' => null,
    'fullHeight' => true,
])

{{-- Center hero column — background image with italic gold headings --}}
<div class="site-hero-col">
    {{-- Background Image with Ken Burns --}}
    @if($backgroundImage)
        <div class="absolute inset-0">
            <img src="{{ $backgroundImage }}" alt="" class="w-full h-full object-cover animate-ken-burns">
        </div>
    @endif
    <div class="absolute inset-0 bg-black/55"></div>

    {{-- Content centered in hero column --}}
    <div class="relative z-10 flex flex-col items-center justify-center h-full px-8 text-center">
        @if($eyebrow)
            <span class="text-gold uppercase tracking-[0.3em] text-xs font-medium" data-animate="animate-fade-in" data-delay="0s" style="opacity:0;">
                {{ $eyebrow }}
            </span>
        @endif

        @if($headline)
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-serif italic text-gold leading-tight mt-4" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                {{ $headline }}
            </h1>
        @endif

        @if($subheadline)
            <p class="text-white/80 text-sm md:text-base max-w-md mx-auto mt-4 italic font-light" data-animate="animate-fade-in-up" data-delay="0.4s" style="opacity:0;">
                {{ $subheadline }}
            </p>
        @endif

        @if($ctaText)
            <div class="mt-8" data-animate="animate-fade-in-up" data-delay="0.6s" style="opacity:0;">
                <a href="{{ $ctaUrl }}"
                   class="inline-block border border-white/60 text-white hover:bg-white hover:text-green-deep px-8 py-3 uppercase tracking-[0.2em] text-xs font-medium transition-all duration-300">
                    {{ $ctaText }}
                </a>
            </div>
        @endif
    </div>
</div>

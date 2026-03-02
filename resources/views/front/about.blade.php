@extends('layouts.front')
@section('title', 'About Us — Sanjung Delights')
@section('meta_description', 'Learn about Sanjung Delights — Premier Halal Corporate Catering in KL & Klang Valley since 2010.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'About Sanjung Delights',
        'subheadline' => $hero?->subheadline ?? 'The story behind KL\'s premier halal corporate catering',
        'eyebrow' => 'Our Story',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay">

        {{-- Professional Description --}}
        <div class="p-8 lg:p-10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Who We Are</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Professional Halal-Compliant Corporate Catering</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>

            {{-- Featured Image --}}
            <div class="relative rounded-lg overflow-hidden mb-6 h-48">
                <img src="{{ asset('images/about-story.jpg') }}" alt="Sanjung Delights"
                     class="w-full h-full object-cover" onerror="this.style.display='none'">
                <div class="absolute inset-0 bg-gradient-to-t from-green-dark/40 to-transparent"></div>
            </div>

            <div class="text-white/70 text-sm leading-relaxed space-y-3">
                <p>{{ $settings['about_story_1'] ?? 'Sanjung Delights is the catering arm of Sanjung Waja Resources Sdn Bhd, established in 2010. What began as a small family venture has grown into one of KL\'s most trusted halal corporate catering services.' }}</p>
                <p>{{ $settings['about_story_2'] ?? 'With over a decade of experience, we have catered for Fortune 500 companies, government agencies, and prestigious corporate events across the Klang Valley.' }}</p>
            </div>
        </div>

        {{-- Our Story Section with marble texture --}}
        <div class="p-8 lg:p-10 border-t border-white/10 marble-bg">
            <h3 class="text-green-dark font-serif italic text-lg mb-3">Our Story</h3>
            <div class="w-10 h-px bg-gold mb-4"></div>
            <p class="text-green-dark/80 text-sm leading-relaxed">
                {{ $settings['about_story_3'] ?? 'Our commitment to halal integrity, culinary excellence, and business-class service sets us apart in the industry. From humble beginnings to serving thousands of corporate events, our journey has been driven by passion and dedication.' }}
            </p>
        </div>

        {{-- Mission / Vision / Values --}}
        <div class="p-8 lg:p-10 border-t border-white/10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">What Drives Us</span>
            <h2 class="text-white text-xl font-serif italic mt-2 mb-4">Mission, Vision & Values</h2>

            <div class="space-y-4">
                {{-- Mission --}}
                <div class="border border-white/10 rounded-lg p-5">
                    <h3 class="text-gold font-serif italic text-base">Our Mission</h3>
                    <p class="text-white/60 text-sm mt-2 leading-relaxed">{{ $settings['mission_text'] ?? 'To deliver exceptional halal catering that exceeds expectations through culinary innovation, impeccable service, and unwavering commitment to quality.' }}</p>
                </div>

                {{-- Vision --}}
                <div class="border border-white/10 rounded-lg p-5">
                    <h3 class="text-gold font-serif italic text-base">Our Vision</h3>
                    <p class="text-white/60 text-sm mt-2 leading-relaxed">{{ $settings['vision_text'] ?? 'To be Malaysia\'s most sought-after halal corporate catering brand, recognized for premium quality, innovative menus, and world-class service.' }}</p>
                </div>

                {{-- Values --}}
                <div class="border border-white/10 rounded-lg p-5">
                    <h3 class="text-gold font-serif italic text-base">Our Values</h3>
                    <p class="text-white/60 text-sm mt-2 leading-relaxed">{{ $settings['values_text'] ?? 'Halal integrity, culinary creativity, customer-centricity, reliability, and continuous improvement in everything we do.' }}</p>
                </div>
            </div>
        </div>

        {{-- Team Section --}}
        @if(isset($team) && $team->count())
        <div class="p-8 lg:p-10 border-t border-white/10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">The People Behind the Food</span>
            <h2 class="text-white text-xl font-serif italic mt-2 mb-6">Meet Our Team</h2>

            <div class="grid grid-cols-2 gap-4">
                @foreach($team as $member)
                    <div class="text-center">
                        <div class="w-20 h-20 mx-auto rounded-full overflow-hidden border border-gold/30">
                            @if($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-green-mid flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-white text-sm font-serif italic mt-2">{{ $member->name }}</h3>
                        <p class="text-gold text-[10px] uppercase tracking-wider">{{ $member->role }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Stats Counter --}}
        <div class="p-8 lg:p-10 border-t border-white/10"
             x-data="{ years: 0, events: 0, clients: 0, dishes: 0,
                 countUp(target, key, dur = 2000) { let s = 0; const step = target / (dur / 16); const t = setInterval(() => { s += step; if (s >= target) { this[key] = target; clearInterval(t); } else { this[key] = Math.floor(s); } }, 16); }
             }"
             x-intersect.once="countUp({{ $settings['stats_years'] ?? 15 }}, 'years'); countUp({{ $settings['stats_events'] ?? 2000 }}, 'events'); countUp({{ $settings['stats_clients'] ?? 500 }}, 'clients'); countUp({{ $settings['stats_dishes'] ?? 100000 }}, 'dishes');">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <div class="text-gold text-2xl font-serif italic" x-text="years.toLocaleString() + '+'">0+</div>
                    <p class="text-white/40 text-[10px] uppercase tracking-widest mt-1">Years Experience</p>
                </div>
                <div>
                    <div class="text-gold text-2xl font-serif italic" x-text="events.toLocaleString() + '+'">0+</div>
                    <p class="text-white/40 text-[10px] uppercase tracking-widest mt-1">Events Catered</p>
                </div>
                <div>
                    <div class="text-gold text-2xl font-serif italic" x-text="clients.toLocaleString() + '+'">0+</div>
                    <p class="text-white/40 text-[10px] uppercase tracking-widest mt-1">Happy Clients</p>
                </div>
                <div>
                    <div class="text-gold text-2xl font-serif italic" x-text="dishes.toLocaleString() + '+'">0+</div>
                    <p class="text-white/40 text-[10px] uppercase tracking-widest mt-1">Dishes Served</p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="p-8 lg:p-10 border-t border-white/10 text-center">
            <a href="{{ route('contact') }}" class="inline-block border border-white/40 text-white hover:bg-white hover:text-green-deep px-6 py-2.5 uppercase tracking-[0.2em] text-[10px] font-medium transition-all duration-300">
                Contact Us
            </a>
            <a href="{{ route('certifications') }}" class="text-gold text-xs font-medium hover:underline mt-3 block">View Certifications →</a>
        </div>
    </div>

@endsection

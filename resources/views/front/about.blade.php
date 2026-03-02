@extends('layouts.front')
@section('title', 'About Us — Sanjung Delights')
@section('meta_description', 'Learn about Sanjung Delights — Premier Halal Corporate Catering in KL & Klang Valley since 2010.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'About Sanjung Delights',
        'subheadline' => $hero?->subheadline ?? 'The story behind KL\'s premier halal corporate catering',
        'eyebrow' => 'Our Story',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Company Story (Two-Column) --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">
            {{-- Left: Photo Frame --}}
            <div class="relative" data-animate="animate-slide-in-left" data-delay="0s" style="opacity:0;">
                <div class="relative rounded-lg overflow-hidden shadow-2xl">
                    <img src="{{ asset('images/about-story.jpg') }}" alt="Sanjung Delights Team" class="w-full h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                {{-- Decorative gold border accent --}}
                <div class="absolute -bottom-4 -right-4 w-full h-full border-2 border-[#C9A84C]/30 rounded-lg -z-10"></div>
            </div>

            {{-- Right: Story Text --}}
            <div data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Who We Are</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Our Journey</h2>
                <div class="text-gray-400 leading-relaxed mt-6 space-y-4">
                    <p>{{ $settings['about_story_1'] ?? 'Sanjung Delights is the catering arm of Sanjung Waja Resources Sdn Bhd, established in 2010. What began as a small family venture has grown into one of KL\'s most trusted halal corporate catering services.' }}</p>
                    <p>{{ $settings['about_story_2'] ?? 'With over a decade of experience, we have catered for Fortune 500 companies, government agencies, and prestigious corporate events across the Klang Valley.' }}</p>
                    <p>{{ $settings['about_story_3'] ?? 'Our commitment to halal integrity, culinary excellence, and business-class service sets us apart in the industry.' }}</p>
                </div>
                <div class="flex items-center gap-4 mt-8">
                    <a href="{{ route('contact') }}" class="inline-block border-2 border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-8 py-3 rounded-sm tracking-widest uppercase text-sm font-semibold transition-all duration-300">
                        Contact Us
                    </a>
                    <a href="{{ route('certifications') }}" class="text-[#C9A84C] text-sm font-medium hover:underline">View Certifications →</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission / Vision / Values Cards --}}
    <section class="py-20 md:py-28 bg-[#0A0A0A]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">What Drives Us</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Mission, Vision & Values</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Mission --}}
                <div class="bg-[#111111] border border-white/5 rounded-lg p-8 hover:border-[#C9A84C]/40 transition-all duration-300 group" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                    <div class="w-14 h-14 rounded-full bg-[#C9A84C]/10 flex items-center justify-center mb-6 group-hover:bg-[#C9A84C]/20 transition-colors duration-300">
                        <svg class="w-7 h-7 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-bold font-serif">Our Mission</h3>
                    <p class="text-gray-400 mt-4 leading-relaxed">{{ $settings['mission_text'] ?? 'To deliver exceptional halal catering that exceeds expectations through culinary innovation, impeccable service, and unwavering commitment to quality.' }}</p>
                </div>

                {{-- Vision --}}
                <div class="bg-[#111111] border border-white/5 rounded-lg p-8 hover:border-[#C9A84C]/40 transition-all duration-300 group" data-animate="animate-fade-in-up" data-delay="0.15s" style="opacity:0;">
                    <div class="w-14 h-14 rounded-full bg-[#C9A84C]/10 flex items-center justify-center mb-6 group-hover:bg-[#C9A84C]/20 transition-colors duration-300">
                        <svg class="w-7 h-7 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-bold font-serif">Our Vision</h3>
                    <p class="text-gray-400 mt-4 leading-relaxed">{{ $settings['vision_text'] ?? 'To be Malaysia\'s most sought-after halal corporate catering brand, recognized for premium quality, innovative menus, and world-class service.' }}</p>
                </div>

                {{-- Values --}}
                <div class="bg-[#111111] border border-white/5 rounded-lg p-8 hover:border-[#C9A84C]/40 transition-all duration-300 group" data-animate="animate-fade-in-up" data-delay="0.3s" style="opacity:0;">
                    <div class="w-14 h-14 rounded-full bg-[#C9A84C]/10 flex items-center justify-center mb-6 group-hover:bg-[#C9A84C]/20 transition-colors duration-300">
                        <svg class="w-7 h-7 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-bold font-serif">Our Values</h3>
                    <p class="text-gray-400 mt-4 leading-relaxed">{{ $settings['values_text'] ?? 'Halal integrity, culinary creativity, customer-centricity, reliability, and continuous improvement in everything we do.' }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Team Section --}}
    @if(isset($team) && $team->count())
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="text-center mb-14" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">The People Behind the Food</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Meet Our Team</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($team as $i => $member)
                    <div class="group text-center" data-animate="animate-fade-in-up" data-delay="{{ $i * 0.1 }}s" style="opacity:0;">
                        <div class="relative w-48 h-48 mx-auto rounded-full overflow-hidden border-2 border-transparent group-hover:border-[#C9A84C] transition-all duration-300 shadow-lg">
                            @if($member->photo_url)
                                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-[#1A1A1A] flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-white text-lg font-bold mt-5 font-serif">{{ $member->name }}</h3>
                        <p class="text-[#C9A84C] text-sm font-medium mt-1">{{ $member->role }}</p>
                        @if($member->bio)
                            <p class="text-gray-400 text-sm mt-3 max-w-xs mx-auto leading-relaxed">{{ Str::limit($member->bio, 120) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Stats Counter Section --}}
    <section class="py-16 bg-[#0A0A0A] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8"
                 x-data="{
                     years: 0,
                     events: 0,
                     clients: 0,
                     dishes: 0,
                     started: false,
                     countUp(target, key, duration = 2000) {
                         let start = 0;
                         const step = target / (duration / 16);
                         const timer = setInterval(() => {
                             start += step;
                             if (start >= target) {
                                 this[key] = target;
                                 clearInterval(timer);
                             } else {
                                 this[key] = Math.floor(start);
                             }
                         }, 16);
                     }
                 }"
                 x-intersect.once="
                     countUp({{ $settings['stats_years'] ?? 15 }}, 'years');
                     countUp({{ $settings['stats_events'] ?? 2000 }}, 'events');
                     countUp({{ $settings['stats_clients'] ?? 500 }}, 'clients');
                     countUp({{ $settings['stats_dishes'] ?? 100000 }}, 'dishes');
                 ">
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-4xl md:text-5xl font-bold font-serif" x-text="years.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Years Experience</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.1s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-4xl md:text-5xl font-bold font-serif" x-text="events.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Events Catered</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-4xl md:text-5xl font-bold font-serif" x-text="clients.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Happy Clients</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.3s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-4xl md:text-5xl font-bold font-serif" x-text="dishes.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Dishes Served</p>
                </div>
            </div>
        </div>
    </section>

@endsection

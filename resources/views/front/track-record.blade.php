@extends('layouts.front')
@section('title', 'Track Record — Sanjung Delights')
@section('meta_description', 'Our proven track record of delivering premium halal catering for corporate events and prestigious clients across KL & Klang Valley.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Track Record',
        'subheadline' => $hero?->subheadline ?? 'Over a decade of exceptional halal catering for prestigious events',
        'eyebrow' => 'Proven Excellence',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Timeline Section --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-5xl mx-auto px-6 md:px-12">
            <div class="text-center mb-16" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Milestones</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white mt-3 font-serif">Events & Achievements</h2>
            </div>

            @if($records->count())
            <div class="relative">
                {{-- Vertical Timeline Line --}}
                <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-px bg-[#C9A84C]/20 hidden md:block"></div>
                {{-- Mobile Timeline Line --}}
                <div class="absolute left-6 top-0 bottom-0 w-px bg-[#C9A84C]/20 md:hidden"></div>

                <div class="space-y-12 md:space-y-16">
                    @php $currentYear = null; @endphp
                    @foreach($records as $i => $record)
                        {{-- Year Badge --}}
                        @if($record->year !== $currentYear)
                            @php $currentYear = $record->year; @endphp
                            <div class="relative flex justify-center" data-animate="animate-fade-in" data-delay="0s" style="opacity:0;">
                                <div class="bg-[#C9A84C] text-black font-bold text-sm px-6 py-2 rounded-full z-10 shadow-lg shadow-[#C9A84C]/20">
                                    {{ $record->year }}
                                </div>
                            </div>
                        @endif

                        {{-- Event Card — Alternating Left/Right --}}
                        <div class="relative flex items-start {{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} flex-row"
                             data-animate="{{ $i % 2 === 0 ? 'animate-slide-in-left' : 'animate-slide-in-right' }}" data-delay="0.1s" style="opacity:0;">

                            {{-- Mobile: Dot on line --}}
                            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-[#C9A84C] border-2 border-[#0D0D0D] z-10 mt-6"></div>

                            {{-- Spacer for mobile --}}
                            <div class="w-12 flex-shrink-0 md:hidden"></div>

                            {{-- Card --}}
                            <div class="md:w-[calc(50%-2rem)] w-full {{ $i % 2 === 0 ? 'md:pr-8' : 'md:pl-8' }}">
                                <div class="bg-[#111111] rounded-lg overflow-hidden border border-white/5 hover:border-[#C9A84C]/30 transition-all duration-300 group">
                                    @if($record->image_url)
                                        <div class="h-48 overflow-hidden">
                                            <img src="{{ $record->image_url }}" alt="{{ $record->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        </div>
                                    @endif
                                    <div class="p-6">
                                        <h3 class="text-white text-lg font-bold font-serif group-hover:text-[#C9A84C] transition-colors duration-300">{{ $record->title }}</h3>
                                        @if($record->client_name)
                                            <p class="text-[#C9A84C] text-sm font-medium mt-1">{{ $record->client_name }}</p>
                                        @endif
                                        @if($record->description)
                                            <p class="text-gray-400 text-sm mt-3 leading-relaxed">{{ $record->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Hidden spacer for desktop alignment --}}
                            <div class="hidden md:block md:w-[calc(50%-2rem)]"></div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">Track record entries coming soon.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Stats Strip --}}
    <section class="py-16 bg-[#0A0A0A] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 md:px-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8"
                 x-data="{
                     years: 0,
                     events: 0,
                     guests: 0,
                     clients: 0,
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
                     countUp({{ $settings['stats_guests'] ?? 500000 }}, 'guests');
                     countUp({{ $settings['stats_clients'] ?? 500 }}, 'clients');
                 ">
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-3xl md:text-5xl font-bold font-serif" x-text="years.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Years Experience</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.1s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-3xl md:text-5xl font-bold font-serif" x-text="events.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Events Catered</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-3xl md:text-5xl font-bold font-serif" x-text="guests.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Guests Served</p>
                </div>
                <div class="text-center" data-animate="animate-fade-in-up" data-delay="0.3s" style="opacity:0;">
                    <div class="text-[#C9A84C] text-3xl md:text-5xl font-bold font-serif" x-text="clients.toLocaleString() + '+'">0+</div>
                    <p class="text-gray-400 text-sm uppercase tracking-widest mt-2">Happy Clients</p>
                </div>
            </div>
        </div>
    </section>

@endsection

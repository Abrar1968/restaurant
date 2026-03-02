@extends('layouts.front')
@section('title', 'Track Record — Sanjung Delights')
@section('meta_description', 'Our proven track record of delivering premium halal catering for corporate events and prestigious clients across KL & Klang Valley.')
@section('content')

    {{-- Center Hero Column --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Our Track Record',
        'subheadline' => $hero?->subheadline ?? 'Over a decade of exceptional halal catering for prestigious events',
        'eyebrow' => 'Proven Excellence',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
    ])

    {{-- Right Content Panel --}}
    <div class="site-panel-col bg-green-dark marble-overlay"
         x-data="{
             years: 0, events: 0, guests: 0, clients: 0,
             countUp(target, key, duration = 2000) {
                 let start = 0;
                 const step = target / (duration / 16);
                 const timer = setInterval(() => {
                     start += step;
                     if (start >= target) { this[key] = target; clearInterval(timer); }
                     else { this[key] = Math.floor(start); }
                 }, 16);
             }
         }"
         x-intersect.once="
             countUp({{ $settings['stats_years'] ?? 15 }}, 'years');
             countUp({{ $settings['stats_events'] ?? 2000 }}, 'events');
             countUp({{ $settings['stats_guests'] ?? 500000 }}, 'guests');
             countUp({{ $settings['stats_clients'] ?? 500 }}, 'clients');
         ">

        {{-- Stats Grid --}}
        <div class="p-8 lg:p-10">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">By The Numbers</span>
            <h2 class="text-white text-xl font-serif italic mt-2">Our Legacy &amp; Growth</h2>
            <div class="w-10 h-px bg-gold/40 my-4"></div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white/5 border border-white/10 p-5 text-center">
                    <div class="text-gold text-2xl font-serif italic" x-text="years.toLocaleString() + '+'">0+</div>
                    <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-2">Years Experience</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-5 text-center">
                    <div class="text-gold text-2xl font-serif italic" x-text="events.toLocaleString() + '+'">0+</div>
                    <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-2">Events Catered</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-5 text-center">
                    <div class="text-gold text-2xl font-serif italic" x-text="guests.toLocaleString() + '+'">0+</div>
                    <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-2">Guests Served</p>
                </div>
                <div class="bg-white/5 border border-white/10 p-5 text-center">
                    <div class="text-gold text-2xl font-serif italic" x-text="clients.toLocaleString() + '+'">0+</div>
                    <p class="text-white/50 text-[10px] uppercase tracking-[0.2em] mt-2">Happy Clients</p>
                </div>
            </div>
        </div>

        {{-- Journey / Timeline --}}
        <div class="px-8 lg:px-10 pb-8">
            <span class="text-gold uppercase tracking-[0.25em] text-[10px] font-medium">Milestones</span>
            <h3 class="text-white text-lg font-serif italic mt-2 mb-6">Our Journey</h3>

            @if($records->count())
            <div class="relative">
                {{-- Vertical Line --}}
                <div class="absolute left-3 top-0 bottom-0 w-px bg-gold/20"></div>

                <div class="space-y-6">
                    @php $currentYear = null; @endphp
                    @foreach($records as $record)
                        {{-- Year Badge --}}
                        @if($record->year !== $currentYear)
                            @php $currentYear = $record->year; @endphp
                            <div class="relative flex items-center">
                                <div class="w-7 h-7 rounded-full bg-gold text-green-deep text-[10px] font-bold flex items-center justify-center z-10">
                                    {{ substr($record->year, -2) }}
                                </div>
                                <span class="ml-3 text-gold text-sm font-serif italic">{{ $record->year }}</span>
                            </div>
                        @endif

                        {{-- Event Card --}}
                        <div class="relative pl-10">
                            {{-- Dot --}}
                            <div class="absolute left-[9px] top-2 w-2 h-2 rounded-full bg-gold/50"></div>

                            <div class="bg-white/5 border border-white/5 hover:border-gold/30 transition-all duration-300 group overflow-hidden">
                                @if($record->image_url)
                                    <div class="h-32 overflow-hidden">
                                        <img src="{{ $record->image_url }}" alt="{{ $record->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h4 class="text-white text-sm font-serif italic group-hover:text-gold transition-colors">{{ $record->title }}</h4>
                                    @if($record->client_name)
                                        <p class="text-gold text-[10px] font-medium mt-0.5">{{ $record->client_name }}</p>
                                    @endif
                                    @if($record->description)
                                        <p class="text-white/40 text-xs mt-2 leading-relaxed line-clamp-2">{{ $record->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="text-center py-10">
                    <p class="text-white/50 text-sm">Track record entries coming soon.</p>
                </div>
            @endif
        </div>

        {{-- Footer in Panel --}}
        <div class="p-8 lg:p-10 border-t border-white/10 text-center">
            <p class="text-white/30 text-[10px] uppercase tracking-[0.2em]">&copy; {{ date('Y') }} Sanjung Delights. All rights reserved.</p>
        </div>
    </div>

@endsection

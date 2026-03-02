@extends('layouts.front')
@section('title', 'Contact Us — Sanjung Delights')
@section('meta_description', 'Get in touch with Sanjung Delights for halal corporate catering inquiries in KL & Klang Valley.')
@section('content')

    {{-- Hero Section --}}
    @include('components.front.hero', [
        'headline' => $hero?->headline ?? 'Contact Us',
        'subheadline' => $hero?->subheadline ?? 'Let us bring exceptional halal catering to your next event',
        'eyebrow' => 'Get In Touch',
        'ctaText' => '',
        'ctaUrl' => '#',
        'backgroundImage' => $hero?->image_url,
        'fullHeight' => false,
    ])

    {{-- Contact Section: Two-Column --}}
    <section class="py-20 md:py-28 bg-[#0D0D0D]">
        <div class="max-w-7xl mx-auto px-6 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-14">

            {{-- Left Column: Contact Info --}}
            <div data-animate="animate-slide-in-left" data-delay="0s" style="opacity:0;">
                <span class="text-[#C9A84C] uppercase tracking-[0.3em] text-xs font-medium">Reach Out</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mt-3 font-serif">We'd Love to Hear From You</h2>
                <p class="text-gray-400 mt-4 leading-relaxed">Whether you have a question about our menus, need a custom quote, or want to discuss your upcoming event, our team is ready to help.</p>

                {{-- Contact Info Blocks --}}
                <div class="space-y-6 mt-10">
                    {{-- Address --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#C9A84C]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider">Address</h4>
                            <p class="text-gray-400 mt-1 text-sm leading-relaxed">{{ $settings['address'] ?? 'No. 7, Jalan PJS 11/15, Bandar Sunway, 46150 Petaling Jaya, Selangor, Malaysia' }}</p>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#C9A84C]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider">Phone</h4>
                            <p class="text-gray-400 mt-1 text-sm">{{ $settings['phone_1'] ?? '+603-7960 5366' }}</p>
                            @if(!empty($settings['phone_2']))
                                <p class="text-gray-400 text-sm">{{ $settings['phone_2'] }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#C9A84C]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider">Email</h4>
                            <p class="text-gray-400 mt-1 text-sm">{{ $settings['email_1'] ?? 'sales@sanjungwaja.com' }}</p>
                            @if(!empty($settings['email_2']))
                                <p class="text-gray-400 text-sm">{{ $settings['email_2'] }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Operating Hours --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-[#C9A84C]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-sm uppercase tracking-wider">Operating Hours</h4>
                            <p class="text-gray-400 mt-1 text-sm">{{ $settings['operating_hours'] ?? 'Mon – Fri: 9:00 AM – 6:00 PM' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Google Maps Embed --}}
                <div class="mt-10 rounded-lg overflow-hidden shadow-lg border border-white/5">
                    <iframe src="{{ $settings['google_maps_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.8!2d101.6!3d3.07!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0!2zM8KwMDQnMTIuMCJOIDEwMcKwMzYnMDAuMCJF!5e0!3m2!1sen!2smy!4v1' }}"
                            width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="filter brightness-75"></iframe>
                </div>

                {{-- WhatsApp CTA --}}
                <a href="https://wa.me/{{ $settings['whatsapp_number'] ?? '60179605366' }}"
                   target="_blank"
                   class="mt-8 flex items-center justify-center gap-3 w-full py-4 px-6 bg-[#25D366] text-white font-semibold rounded-lg hover:opacity-90 transition-opacity duration-200 shadow-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.12.553 4.113 1.519 5.848L.058 23.306a.5.5 0 00.636.636l5.458-1.461A11.948 11.948 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.94 0-3.786-.546-5.382-1.564l-.386-.234-3.996 1.07 1.07-3.996-.234-.386A9.953 9.953 0 012 12C2 6.486 6.486 2 12 2s10 4.486 10 10-4.486 10-10 10z"/></svg>
                    Chat with Us on WhatsApp
                </a>
            </div>

            {{-- Right Column: Inquiry Form --}}
            <div data-animate="animate-fade-in-up" data-delay="0.2s" style="opacity:0;">
                <div class="bg-[#111111] border border-white/5 rounded-lg p-8">
                    <h3 class="text-white text-xl font-bold font-serif mb-6">Send Us an Enquiry</h3>

                    {{-- Success Flash Message --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-900/30 border border-green-500/30 rounded-lg text-green-400 text-sm" x-data="{ show: true }" x-show="show" x-transition>
                            <div class="flex items-center justify-between">
                                <p>{{ session('success') }}</p>
                                <button @click="show = false" class="text-green-400 hover:text-green-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-gray-400 text-sm font-medium mb-1.5">Full Name <span class="text-red-400">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200"
                                   placeholder="Your full name">
                            @error('name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Company --}}
                        <div>
                            <label for="company" class="block text-gray-400 text-sm font-medium mb-1.5">Company</label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}"
                                   class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200"
                                   placeholder="Your company name">
                            @error('company')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-gray-400 text-sm font-medium mb-1.5">Email Address <span class="text-red-400">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200"
                                   placeholder="your@email.com">
                            @error('email')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="phone" class="block text-gray-400 text-sm font-medium mb-1.5">Phone Number <span class="text-red-400">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                                   class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200"
                                   placeholder="+60 12-345 6789">
                            @error('phone')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Event Type --}}
                        <div>
                            <label for="event_type" class="block text-gray-400 text-sm font-medium mb-1.5">Event Type <span class="text-red-400">*</span></label>
                            <select id="event_type" name="event_type" required
                                    class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200">
                                <option value="" class="text-gray-600">Select event type</option>
                                <option value="corporate_lunch" {{ old('event_type') === 'corporate_lunch' ? 'selected' : '' }}>Corporate Lunch</option>
                                <option value="corporate_dinner" {{ old('event_type') === 'corporate_dinner' ? 'selected' : '' }}>Corporate Dinner</option>
                                <option value="conference" {{ old('event_type') === 'conference' ? 'selected' : '' }}>Conference / Seminar</option>
                                <option value="product_launch" {{ old('event_type') === 'product_launch' ? 'selected' : '' }}>Product Launch</option>
                                <option value="gala_dinner" {{ old('event_type') === 'gala_dinner' ? 'selected' : '' }}>Gala Dinner</option>
                                <option value="wedding" {{ old('event_type') === 'wedding' ? 'selected' : '' }}>Wedding Reception</option>
                                <option value="private_event" {{ old('event_type') === 'private_event' ? 'selected' : '' }}>Private Event</option>
                                <option value="other" {{ old('event_type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('event_type')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Expected Guests & Event Date (side by side) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="expected_guests" class="block text-gray-400 text-sm font-medium mb-1.5">Expected Guests</label>
                                <input type="number" id="expected_guests" name="expected_guests" value="{{ old('expected_guests') }}" min="1"
                                       class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200"
                                       placeholder="e.g. 100">
                                @error('expected_guests')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="event_date" class="block text-gray-400 text-sm font-medium mb-1.5">Event Date</label>
                                <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                                       class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200">
                                @error('event_date')
                                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label for="message" class="block text-gray-400 text-sm font-medium mb-1.5">Message <span class="text-red-400">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full bg-[#1A1A1A] border border-white/10 rounded-lg px-4 py-3 text-white text-sm placeholder-gray-600 focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none transition-colors duration-200 resize-none"
                                      placeholder="Tell us about your event and catering needs...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                                class="w-full bg-[#C9A84C] text-black font-bold py-3.5 px-8 rounded-sm uppercase tracking-widest text-sm hover:bg-[#B8973B] transition-colors duration-300">
                            Send Enquiry
                        </button>
                        <p class="text-gray-600 text-xs text-center mt-2">We'll get back to you within 24 hours.</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

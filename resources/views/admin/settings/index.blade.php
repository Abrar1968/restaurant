@extends('layouts.admin')
@section('title', 'Settings')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div>
        <h1 class="text-2xl font-bold text-white">Settings</h1>
        <p class="text-gray-400 mt-1">Manage your website configuration</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabbed Settings --}}
    <div x-data="{ tab: 'general' }">
        {{-- Tab Navigation --}}
        <div class="flex border-b border-white/10 mb-6">
            <button @click="tab = 'general'"
                    :class="tab === 'general' ? 'border-[#C9A84C] text-[#C9A84C]' : 'border-transparent text-gray-400 hover:text-white'"
                    class="px-6 py-3 text-sm font-medium border-b-2 transition -mb-px">
                General
            </button>
            <button @click="tab = 'contact'"
                    :class="tab === 'contact' ? 'border-[#C9A84C] text-[#C9A84C]' : 'border-transparent text-gray-400 hover:text-white'"
                    class="px-6 py-3 text-sm font-medium border-b-2 transition -mb-px">
                Contact
            </button>
            <button @click="tab = 'social'"
                    :class="tab === 'social' ? 'border-[#C9A84C] text-[#C9A84C]' : 'border-transparent text-gray-400 hover:text-white'"
                    class="px-6 py-3 text-sm font-medium border-b-2 transition -mb-px">
                Social Media
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            {{-- General Tab --}}
            <div x-show="tab === 'general'" x-transition class="space-y-6">
                <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-white border-b border-white/10 pb-3">General Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Site Name --}}
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-300 mb-1.5">Site Name</label>
                            <input type="text" name="settings[site_name]" id="site_name"
                                   value="{{ $settings['site_name'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="Sanjung Delights">
                        </div>

                        {{-- Tagline --}}
                        <div>
                            <label for="tagline" class="block text-sm font-medium text-gray-300 mb-1.5">Tagline</label>
                            <input type="text" name="settings[tagline]" id="tagline"
                                   value="{{ $settings['tagline'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="Premium Halal Catering">
                        </div>
                    </div>

                    {{-- About Text --}}
                    <div>
                        <label for="about_text" class="block text-sm font-medium text-gray-300 mb-1.5">About Text</label>
                        <textarea name="settings[about_text]" id="about_text" rows="4"
                                  class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                  placeholder="Brief description about the company...">{{ $settings['about_text'] ?? '' }}</textarea>
                    </div>

                    {{-- Hero Headline --}}
                    <div>
                        <label for="hero_headline" class="block text-sm font-medium text-gray-300 mb-1.5">Hero Headline</label>
                        <input type="text" name="settings[hero_headline]" id="hero_headline"
                               value="{{ $settings['hero_headline'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="Main headline for the hero section">
                    </div>

                    {{-- Hero Subtext --}}
                    <div>
                        <label for="hero_subtext" class="block text-sm font-medium text-gray-300 mb-1.5">Hero Subtext</label>
                        <textarea name="settings[hero_subtext]" id="hero_subtext" rows="2"
                                  class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                  placeholder="Supporting text below the headline...">{{ $settings['hero_subtext'] ?? '' }}</textarea>
                    </div>

                    {{-- Meta Description --}}
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-300 mb-1.5">Meta Description</label>
                        <textarea name="settings[meta_description]" id="meta_description" rows="2"
                                  class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                  placeholder="SEO meta description...">{{ $settings['meta_description'] ?? '' }}</textarea>
                    </div>

                    {{-- Meta Keywords --}}
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-300 mb-1.5">Meta Keywords</label>
                        <input type="text" name="settings[meta_keywords]" id="meta_keywords"
                               value="{{ $settings['meta_keywords'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="catering, halal, corporate, KL">
                    </div>
                </div>
            </div>

            {{-- Contact Tab --}}
            <div x-show="tab === 'contact'" x-transition class="space-y-6">
                <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-white border-b border-white/10 pb-3">Contact Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Contact Email --}}
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Email</label>
                            <input type="email" name="settings[contact_email]" id="contact_email"
                                   value="{{ $settings['contact_email'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="info@sanjungdelights.com">
                        </div>

                        {{-- Contact Phone --}}
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Phone</label>
                            <input type="text" name="settings[contact_phone]" id="contact_phone"
                                   value="{{ $settings['contact_phone'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="+60 12-345 6789">
                        </div>

                        {{-- Contact Phone 2 --}}
                        <div>
                            <label for="contact_phone_2" class="block text-sm font-medium text-gray-300 mb-1.5">Contact Phone 2</label>
                            <input type="text" name="settings[contact_phone_2]" id="contact_phone_2"
                                   value="{{ $settings['contact_phone_2'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="+60 12-345 6790">
                        </div>

                        {{-- WhatsApp Number --}}
                        <div>
                            <label for="whatsapp_number" class="block text-sm font-medium text-gray-300 mb-1.5">WhatsApp Number</label>
                            <input type="text" name="settings[whatsapp_number]" id="whatsapp_number"
                                   value="{{ $settings['whatsapp_number'] ?? '' }}"
                                   class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                   placeholder="60123456789">
                        </div>
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-300 mb-1.5">Address</label>
                        <textarea name="settings[address]" id="address" rows="3"
                                  class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                  placeholder="Full business address...">{{ $settings['address'] ?? '' }}</textarea>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div>
                        <label for="google_maps_embed" class="block text-sm font-medium text-gray-300 mb-1.5">Google Maps Embed URL</label>
                        <input type="text" name="settings[google_maps_embed]" id="google_maps_embed"
                               value="{{ $settings['google_maps_embed'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="https://www.google.com/maps/embed?...">
                    </div>

                    {{-- Business Hours --}}
                    <div>
                        <label for="business_hours" class="block text-sm font-medium text-gray-300 mb-1.5">Business Hours</label>
                        <textarea name="settings[business_hours]" id="business_hours" rows="3"
                                  class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                                  placeholder="Mon - Fri: 9:00 AM - 6:00 PM&#10;Sat: 9:00 AM - 1:00 PM">{{ $settings['business_hours'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Social Media Tab --}}
            <div x-show="tab === 'social'" x-transition class="space-y-6">
                <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
                    <h3 class="text-lg font-semibold text-white border-b border-white/10 pb-3">Social Media Links</h3>

                    {{-- Facebook --}}
                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-300 mb-1.5">Facebook URL</label>
                        <input type="url" name="settings[facebook_url]" id="facebook_url"
                               value="{{ $settings['facebook_url'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="https://facebook.com/sanjungdelights">
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-300 mb-1.5">Instagram URL</label>
                        <input type="url" name="settings[instagram_url]" id="instagram_url"
                               value="{{ $settings['instagram_url'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="https://instagram.com/sanjungdelights">
                    </div>

                    {{-- TikTok --}}
                    <div>
                        <label for="tiktok_url" class="block text-sm font-medium text-gray-300 mb-1.5">TikTok URL</label>
                        <input type="url" name="settings[tiktok_url]" id="tiktok_url"
                               value="{{ $settings['tiktok_url'] ?? '' }}"
                               class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                               placeholder="https://tiktok.com/@sanjungdelights">
                    </div>
                </div>
            </div>

            {{-- Save Button --}}
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

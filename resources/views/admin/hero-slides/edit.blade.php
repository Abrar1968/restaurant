@extends('layouts.admin')
@section('title', 'Edit Hero Slide')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Hero Slide</h1>
            <p class="text-gray-400 mt-1">Update hero banner slide details</p>
        </div>
    </div>

    {{-- Error Display --}}
    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.hero-slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Page --}}
                <div>
                    <label for="page" class="block text-sm font-medium text-gray-300 mb-1.5">Page</label>
                    <select name="page" id="page"
                            class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full">
                        <option value="">Select a page</option>
                        <option value="home" @selected(old('page', $slide->page) === 'home')>Home</option>
                        <option value="about" @selected(old('page', $slide->page) === 'about')>About</option>
                        <option value="menu" @selected(old('page', $slide->page) === 'menu')>Menu</option>
                        <option value="gallery" @selected(old('page', $slide->page) === 'gallery')>Gallery</option>
                        <option value="track-record" @selected(old('page', $slide->page) === 'track-record')>Track Record</option>
                        <option value="certifications" @selected(old('page', $slide->page) === 'certifications')>Certifications</option>
                        <option value="contact" @selected(old('page', $slide->page) === 'contact')>Contact</option>
                        <option value="clients" @selected(old('page', $slide->page) === 'clients')>Clients</option>
                    </select>
                    @error('page')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $slide->sort_order) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="0">
                    @error('sort_order')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Headline --}}
            <div>
                <label for="headline" class="block text-sm font-medium text-gray-300 mb-1.5">Headline</label>
                <input type="text" name="headline" id="headline"
                       value="{{ old('headline', $slide->headline) }}"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                       placeholder="Enter the hero headline">
                @error('headline')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Subheadline --}}
            <div>
                <label for="subheadline" class="block text-sm font-medium text-gray-300 mb-1.5">Subheadline</label>
                <input type="text" name="subheadline" id="subheadline"
                       value="{{ old('subheadline', $slide->subheadline) }}"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                       placeholder="Supporting text below the headline">
                @error('subheadline')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- CTA Text --}}
                <div>
                    <label for="cta_text" class="block text-sm font-medium text-gray-300 mb-1.5">CTA Button Text</label>
                    <input type="text" name="cta_text" id="cta_text"
                           value="{{ old('cta_text', $slide->cta_text) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="e.g. Explore Menu">
                    @error('cta_text')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CTA URL --}}
                <div>
                    <label for="cta_url" class="block text-sm font-medium text-gray-300 mb-1.5">CTA Button URL</label>
                    <input type="text" name="cta_url" id="cta_url"
                           value="{{ old('cta_url', $slide->cta_url) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="/menu or https://...">
                    @error('cta_url')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Current Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Current Image</label>
                @if($slide->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->headline }}"
                             class="max-w-md h-48 object-cover rounded-lg border border-white/10">
                    </div>
                @else
                    <div class="mb-3 w-full max-w-md h-48 bg-[#1A1A1A] rounded-lg border border-white/10 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">No image uploaded</p>
                    </div>
                @endif
            </div>

            {{-- New Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-300 mb-1.5">Replace Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#C9A84C]/10 file:text-[#C9A84C] hover:file:bg-[#C9A84C]/20">
                <p class="text-gray-500 text-xs mt-1">Leave empty to keep the current image. Recommended: 1920x1080px, JPEG or PNG. Max 5MB.</p>
                @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Active Checkbox --}}
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       class="rounded border-white/20 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]"
                       @checked(old('is_active', $slide->is_active))>
                <label for="is_active" class="text-sm font-medium text-gray-300">Active</label>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('admin.hero-slides.index') }}"
               class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">
                Cancel
            </a>
            <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2 rounded transition">
                Update Slide
            </button>
        </div>
    </form>
</div>

@endsection

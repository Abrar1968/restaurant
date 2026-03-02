@extends('layouts.admin')
@section('title', 'Edit Menu Category')
@section('content')

<div class="space-y-8" x-data="{ name: '{{ old('name', $menu->name) }}', slug: '{{ old('slug', $menu->slug) }}', imagePreview: null }" x-effect="slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.menus.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Menu Category</h1>
            <p class="text-gray-400 mt-1">Update details for <strong class="text-white">{{ $menu->name }}</strong></p>
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

    {{-- Form --}}
    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input type="text" name="name" id="name"
                           x-model="name"
                           value="{{ old('name', $menu->name) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="e.g. Malay Cuisine">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-300 mb-1.5">Slug</label>
                    <input type="text" name="slug" id="slug"
                           x-model="slug"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="auto-generated-from-name">
                    @error('slug')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tagline --}}
            <div>
                <label for="tagline" class="block text-sm font-medium text-gray-300 mb-1.5">Tagline</label>
                <input type="text" name="tagline" id="tagline"
                       value="{{ old('tagline', $menu->tagline ?? '') }}"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                       placeholder="Short tagline for this menu">
                @error('tagline')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                          placeholder="Describe this menu category">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Current Image</label>
                @if($menu->cover_image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $menu->cover_image_path) }}" alt="{{ $menu->name }}"
                             class="max-w-md h-48 object-cover rounded-lg border border-white/10">
                    </div>
                @else
                    <div class="mb-3 w-full max-w-md h-48 bg-[#1A1A1A] rounded-lg border border-white/10 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">No image uploaded</p>
                    </div>
                @endif
            </div>

            {{-- Replace Image --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-300 mb-1.5">Replace Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       @change="if ($event.target.files[0]) { imagePreview = URL.createObjectURL($event.target.files[0]) }"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#C9A84C]/10 file:text-[#C9A84C] hover:file:bg-[#C9A84C]/20">
                <p class="text-gray-500 text-xs mt-1">Leave empty to keep the current image. Recommended: 1920x1080px, JPEG or PNG. Max 5MB.</p>
                @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
                {{-- New Image Preview --}}
                <div x-show="imagePreview" x-cloak class="mt-3">
                    <img :src="imagePreview" alt="Preview" class="max-w-md h-48 object-cover rounded-lg border border-white/10">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $menu->sort_order) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="0">
                    @error('sort_order')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Checkbox --}}
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $menu->is_active) ? 'checked' : '' }}
                               class="rounded border-white/20 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]">
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.menus.index') }}" class="text-gray-400 hover:text-white text-sm transition">Cancel</a>
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Update Menu
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

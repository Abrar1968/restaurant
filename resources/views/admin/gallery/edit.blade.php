@extends('layouts.admin')
@section('title', 'Edit Gallery Image')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.gallery.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Gallery Image</h1>
            <p class="text-gray-400 mt-1">Update gallery image details</p>
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
    <form action="{{ route('admin.gallery.update', $image) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300 mb-1.5">Title</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $image->title) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="Image title">
                    @error('title')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-300 mb-1.5">Category</label>
                    <select name="category_id" id="category_id"
                            class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full">
                        <option value="">No Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $image->gallery_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Alt Text --}}
            <div>
                <label for="alt_text" class="block text-sm font-medium text-gray-300 mb-1.5">Alt Text</label>
                <input type="text" name="alt_text" id="alt_text"
                       value="{{ old('alt_text', $image->alt_text) }}"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                       placeholder="Descriptive text for accessibility">
                @error('alt_text')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Current Image</label>
                @if($image->image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text }}"
                             class="max-w-xs h-48 object-cover rounded-lg border border-white/10">
                    </div>
                @else
                    <div class="mb-3 w-full max-w-xs h-48 bg-[#1A1A1A] rounded-lg border border-white/10 flex items-center justify-center">
                        <p class="text-gray-500 text-sm">No image uploaded</p>
                    </div>
                @endif
            </div>

            {{-- Replace Image --}}
            <div x-data="{ preview: null }">
                <label for="image" class="block text-sm font-medium text-gray-300 mb-1.5">Replace Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       @change="if ($event.target.files[0]) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL($event.target.files[0]); }"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#C9A84C]/10 file:text-[#C9A84C] hover:file:bg-[#C9A84C]/20">
                <p class="text-gray-500 text-xs mt-1">Leave empty to keep the current image. Recommended: JPEG or PNG. Max 5MB.</p>
                @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror

                {{-- New Image Preview --}}
                <div x-show="preview" x-cloak class="mt-3">
                    <img :src="preview" alt="Preview" class="max-w-xs h-48 object-cover rounded-lg border border-white/10">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $image->sort_order) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="0">
                    @error('sort_order')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Checkbox --}}
                <div class="flex items-center pt-7">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-white/20 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]"
                               {{ old('is_active', $image->is_active) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Update Image
                </button>
                <a href="{{ route('admin.gallery.index') }}" class="text-gray-400 hover:text-white transition text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection

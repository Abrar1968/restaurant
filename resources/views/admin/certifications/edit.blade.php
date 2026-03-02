@extends('layouts.admin')
@section('title', 'Edit Certification')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.certifications.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Certification</h1>
            <p class="text-gray-400 mt-1">Update certification details</p>
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
    <form action="{{ route('admin.certifications.update', $certification) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $certification->name) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="Certification name">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Issuer --}}
                <div>
                    <label for="issuer" class="block text-sm font-medium text-gray-300 mb-1.5">Issuer</label>
                    <input type="text" name="issuer" id="issuer"
                           value="{{ old('issuer', $certification->issuing_body) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="Issuing body or organization">
                    @error('issuer')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full resize-y"
                          placeholder="Brief description of the certification">{{ old('description', $certification->description) }}</textarea>
                @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Current Image</label>
                @if($certification->certificate_image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $certification->certificate_image_path) }}" alt="{{ $certification->name }}"
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
                {{-- Valid From --}}
                <div>
                    <label for="valid_from" class="block text-sm font-medium text-gray-300 mb-1.5">Valid From</label>
                    <input type="date" name="valid_from" id="valid_from"
                           value="{{ old('valid_from', $certification->valid_from?->format('Y-m-d')) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full [color-scheme:dark]">
                    @error('valid_from')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Valid Until --}}
                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-300 mb-1.5">Valid Until</label>
                    <input type="date" name="valid_until" id="valid_until"
                           value="{{ old('valid_until', $certification->valid_until?->format('Y-m-d')) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full [color-scheme:dark]">
                    @error('valid_until')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $certification->sort_order) }}"
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
                               {{ old('is_active', $certification->is_active) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Update Certification
                </button>
                <a href="{{ route('admin.certifications.index') }}" class="text-gray-400 hover:text-white transition text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection

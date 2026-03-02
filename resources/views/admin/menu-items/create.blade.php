@extends('layouts.admin')
@section('title', 'Add Menu Item')
@section('content')

<div class="space-y-8" x-data="{ imagePreview: null }">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.menus.items.index', $menu) }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Add Menu Item</h1>
            <p class="text-gray-400 mt-1">Create a new item for your menu</p>
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
    <form action="{{ route('admin.menus.items.store', $menu) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name') }}"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                       placeholder="e.g. Nasi Lemak Special">
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Menu --}}
                <div>
                    <label for="menu_id" class="block text-sm font-medium text-gray-300 mb-1.5">Menu</label>
                    <select name="menu_id" id="menu_id"
                            class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full">
                        <option value="">Select a menu</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" @selected(old('menu_id') == $menu->id)>{{ $menu->name }}</option>
                        @endforeach
                    </select>
                    @error('menu_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="menu_category_id" class="block text-sm font-medium text-gray-300 mb-1.5">Category</label>
                    <select name="menu_category_id" id="menu_category_id"
                            class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('menu_category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('menu_category_id')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                          placeholder="Brief description of this menu item">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-1.5">Price (RM)</label>
                    <input type="number" name="price" id="price" step="0.01" min="0"
                           value="{{ old('price') }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="0.00">
                    @error('price')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dietary Tags --}}
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-300 mb-1.5">Dietary Tags</label>
                    <input type="text" name="tags" id="tags"
                           value="{{ old('tags') }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="e.g. spicy, vegetarian (comma-separated)">
                    @error('tags')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-300 mb-1.5">Item Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                       @change="if ($event.target.files[0]) { imagePreview = URL.createObjectURL($event.target.files[0]) }"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#C9A84C]/10 file:text-[#C9A84C] hover:file:bg-[#C9A84C]/20">
                <p class="text-gray-500 text-xs mt-1">Recommended: 800x600px, JPEG or PNG. Max 5MB.</p>
                @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
                {{-- Image Preview --}}
                <div x-show="imagePreview" x-cloak class="mt-3">
                    <img :src="imagePreview" alt="Preview" class="max-w-xs h-40 object-cover rounded-lg border border-white/10">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="0">
                    @error('sort_order')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Active Checkbox --}}
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1"
                               {{ old('is_available', true) ? 'checked' : '' }}
                               class="rounded border-white/20 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]">
                        <span class="text-sm text-gray-300">Available</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t border-white/10">
                <a href="{{ route('admin.menus.items.index', $menu) }}" class="text-gray-400 hover:text-white text-sm transition">Cancel</a>
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Save Item
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

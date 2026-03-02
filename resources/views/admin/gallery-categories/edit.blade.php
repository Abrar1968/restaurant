@extends('layouts.admin')
@section('title', 'Edit Gallery Category')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.gallery-categories.index') }}" class="text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Edit Gallery Category</h1>
            <p class="text-gray-400 mt-1">Update category details</p>
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
    <form action="{{ route('admin.gallery-categories.update', $category) }}" method="POST" x-data="{
        name: '{{ old('name', $category->name) }}',
        slug: '{{ old('slug', $category->slug) }}',
        autoSlug: false,
        generateSlug(name) {
            if (this.autoSlug) {
                this.slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        }
    }">
        @csrf
        @method('PUT')

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input type="text" name="name" id="name"
                           x-model="name"
                           @input="generateSlug(name)"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="Category name">
                    @error('name')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-300 mb-1.5">Slug</label>
                    <input type="text" name="slug" id="slug"
                           x-model="slug"
                           @input="autoSlug = false"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="category-slug">
                    @error('slug')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order"
                           value="{{ old('sort_order', $category->sort_order) }}"
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
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                <button type="submit" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-6 py-2.5 rounded transition">
                    Update Category
                </button>
                <a href="{{ route('admin.gallery-categories.index') }}" class="text-gray-400 hover:text-white transition text-sm">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection

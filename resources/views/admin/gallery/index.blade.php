@extends('layouts.admin')
@section('title', 'Gallery')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gallery</h1>
            <p class="text-gray-400 mt-1">Manage gallery images</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Image
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Category Filter --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-4">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-sm text-gray-400">Filter by category:</span>
            <a href="{{ route('admin.gallery.index') }}"
               class="px-3 py-1.5 rounded text-sm transition {{ !request('category') ? 'bg-[#C9A84C] text-black font-semibold' : 'bg-[#1A1A1A] text-gray-300 hover:bg-white/10' }}">
                All
            </a>
            @foreach($categories as $category)
                <a href="{{ route('admin.gallery.index', ['category' => $category->id]) }}"
                   class="px-3 py-1.5 rounded text-sm transition {{ request('category') == $category->id ? 'bg-[#C9A84C] text-black font-semibold' : 'bg-[#1A1A1A] text-gray-300 hover:bg-white/10' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Image Grid --}}
    @if($images->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($images as $image)
                <div class="relative group rounded-lg overflow-hidden aspect-square">
                    @if($image->image_path)
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $image->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#1A1A1A] flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    {{-- Hover Overlay --}}
                    <div class="absolute inset-0 bg-black/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                        <p class="text-white font-semibold text-sm truncate">{{ $image->title ?? 'Untitled' }}</p>
                        @if($image->category)
                            <p class="text-[#C9A84C] text-xs mt-0.5">{{ $image->category->name }}</p>
                        @endif

                        {{-- Status Badge --}}
                        <div class="mt-2">
                            @if($image->is_active)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2 py-0.5 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2 py-0.5 rounded-full">Inactive</span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 mt-3">
                            <a href="{{ route('admin.gallery.edit', $image) }}"
                               class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this image?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $images->withQueryString()->links() }}
        </div>
    @else
        <div class="bg-[#111] border border-white/10 rounded-lg p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-gray-500 text-sm">No gallery images found.</p>
            <a href="{{ route('admin.gallery.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Add your first image →</a>
        </div>
    @endif
</div>

@endsection

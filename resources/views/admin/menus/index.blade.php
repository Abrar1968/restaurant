@extends('layouts.admin')
@section('title', 'Menu Categories')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Menu Categories</h1>
            <p class="text-gray-400 mt-1">Manage your menu categories and cuisine types</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add New Menu
        </a>
    </div>

    {{-- Menu Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($menus as $menu)
            <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden" x-data="{ confirmDelete: false }">
                {{-- Image --}}
                <div class="h-48 w-full overflow-hidden">
                    @if($menu->cover_image_path)
                        <img src="{{ asset('storage/' . $menu->cover_image_path) }}" alt="{{ $menu->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#1A1A1A] flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Card Body --}}
                <div class="p-6 space-y-3">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $menu->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $menu->slug }}</p>
                        </div>
                        @if($menu->is_active)
                            <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="bg-[#1A1A1A] text-gray-300 text-xs font-medium px-2.5 py-1 rounded">
                            {{ $menu->items_count }} {{ Str::plural('item', $menu->items_count) }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 pt-2 border-t border-white/10">
                        <a href="{{ route('admin.menus.edit', $menu) }}"
                           class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                            Edit
                        </a>
                        <button @click="confirmDelete = true"
                                class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                            Delete
                        </button>
                    </div>
                </div>

                {{-- Delete Confirmation Modal --}}
                <div x-show="confirmDelete" x-cloak
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
                     @click.self="confirmDelete = false">
                    <div class="bg-[#111] border border-white/10 rounded-lg p-6 max-w-sm w-full mx-4 space-y-4"
                         @click.away="confirmDelete = false">
                        <h3 class="text-lg font-semibold text-white">Confirm Delete</h3>
                        <p class="text-gray-400 text-sm">Are you sure you want to delete <strong class="text-white">{{ $menu->name }}</strong>? This action cannot be undone.</p>
                        <div class="flex items-center justify-end gap-3">
                            <button @click="confirmDelete = false"
                                    class="px-4 py-2 text-gray-400 hover:text-white text-sm transition">
                                Cancel
                            </button>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-4 py-2 rounded text-sm font-semibold transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-[#111] border border-white/10 rounded-lg p-12 text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-gray-500 text-sm">No menu categories found.</p>
                    <a href="{{ route('admin.menus.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Create your first menu →</a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection

@extends('layouts.admin')
@section('title', 'Gallery Categories')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gallery Categories</h1>
            <p class="text-gray-400 mt-1">Manage gallery image categories</p>
        </div>
        <a href="{{ route('admin.gallery-categories.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Category
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Categories Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Name</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Slug</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Images</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Active</th>
                    <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($categories as $category)
                    <tr class="hover:bg-white/5 transition">
                        {{-- Name --}}
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-medium">{{ $category->name }}</p>
                        </td>

                        {{-- Slug --}}
                        <td class="px-6 py-4">
                            <span class="bg-[#1A1A1A] text-gray-300 text-xs font-mono px-2.5 py-1 rounded">{{ $category->slug }}</span>
                        </td>

                        {{-- Image Count --}}
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $category->images_count ?? 0 }}
                        </td>

                        {{-- Active Badge --}}
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.gallery-categories.edit', $category) }}"
                                   class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.gallery-categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this category? Images in this category will become uncategorized.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                <p class="text-sm">No categories found.</p>
                                <a href="{{ route('admin.gallery-categories.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Create your first category →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

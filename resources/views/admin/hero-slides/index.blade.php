@extends('layouts.admin')
@section('title', 'Hero Slides')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Hero Slides</h1>
            <p class="text-gray-400 mt-1">Manage hero banner slides across all pages</p>
        </div>
        <a href="{{ route('admin.hero-slides.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Slide
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Slides Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Image</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Page</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Headline</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Active</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Sort Order</th>
                    <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($slides as $slide)
                    <tr class="hover:bg-white/5 transition">
                        {{-- Image Thumbnail --}}
                        <td class="px-6 py-4">
                            @if($slide->image)
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->headline }}"
                                     class="w-20 h-12 object-cover rounded border border-white/10">
                            @else
                                <div class="w-20 h-12 bg-[#1A1A1A] rounded border border-white/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>

                        {{-- Page --}}
                        <td class="px-6 py-4">
                            <span class="bg-[#1A1A1A] text-gray-300 text-xs font-medium px-2.5 py-1 rounded capitalize">{{ $slide->page }}</span>
                        </td>

                        {{-- Headline --}}
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-medium">{{ Str::limit($slide->headline, 50) }}</p>
                            @if($slide->subheadline)
                                <p class="text-gray-500 text-xs mt-0.5">{{ Str::limit($slide->subheadline, 60) }}</p>
                            @endif
                        </td>

                        {{-- Active Badge --}}
                        <td class="px-6 py-4">
                            @if($slide->is_active)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                            @endif
                        </td>

                        {{-- Sort Order --}}
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $slide->sort_order }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.hero-slides.edit', $slide) }}"
                                   class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this slide?')">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm">No hero slides found.</p>
                                <a href="{{ route('admin.hero-slides.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Create your first slide →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

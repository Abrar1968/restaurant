@extends('layouts.admin')
@section('title', 'Menu Items')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Menu Items</h1>
            <p class="text-gray-400 mt-1">Manage individual menu items across all categories</p>
        </div>
        <a href="{{ route('admin.menu-items.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add New Item
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-4">
        <div class="flex items-center gap-4">
            <label class="text-sm font-medium text-gray-400">Filter by Menu:</label>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.menu-items.index') }}"
                   class="px-3 py-1.5 rounded text-sm transition {{ !request('menu') ? 'bg-[#C9A84C] text-black font-semibold' : 'bg-[#1A1A1A] text-gray-300 hover:text-white' }}">
                    All
                </a>
                @foreach($menus as $menu)
                    <a href="{{ route('admin.menu-items.index', ['menu' => $menu->id]) }}"
                       class="px-3 py-1.5 rounded text-sm transition {{ request('menu') == $menu->id ? 'bg-[#C9A84C] text-black font-semibold' : 'bg-[#1A1A1A] text-gray-300 hover:text-white' }}">
                        {{ $menu->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Image</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Name</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Category</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Menu</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Price</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($items as $item)
                    <tr class="hover:bg-white/5 transition">
                        {{-- Image Thumbnail --}}
                        <td class="px-6 py-4">
                            @if($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                                     class="w-[50px] h-[50px] object-cover rounded border border-white/10">
                            @else
                                <div class="w-[50px] h-[50px] bg-[#1A1A1A] rounded border border-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>

                        {{-- Name --}}
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-medium">{{ $item->name }}</p>
                        </td>

                        {{-- Category --}}
                        <td class="px-6 py-4">
                            <span class="text-gray-300 text-sm">{{ $item->category?->name ?? '—' }}</span>
                        </td>

                        {{-- Menu --}}
                        <td class="px-6 py-4">
                            <span class="bg-[#1A1A1A] text-gray-300 text-xs font-medium px-2.5 py-1 rounded">{{ $item->menu?->name ?? '—' }}</span>
                        </td>

                        {{-- Price --}}
                        <td class="px-6 py-4">
                            <span class="text-[#C9A84C] text-sm font-medium">RM {{ number_format($item->price, 2) }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($item->is_available)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.menu-items.edit', $item) }}"
                                   class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this item?')">
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
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-sm">No menu items found.</p>
                                <a href="{{ route('admin.menu-items.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Add your first item →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($items->hasPages())
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @endif
</div>

@endsection

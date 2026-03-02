@extends('layouts.admin')
@section('title', 'Packages')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Packages</h1>
            <p class="text-gray-400 mt-1">Manage catering packages and pricing</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Package
        </a>
    </div>

    {{-- Packages Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Image</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Name</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Tagline</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Price From</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Status</th>
                    <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($packages as $package)
                    <tr class="hover:bg-white/5 transition">
                        {{-- Cover Image --}}
                        <td class="px-6 py-4">
                            @if($package->cover_image_path)
                                <img src="{{ asset('storage/' . $package->cover_image_path) }}" alt="{{ $package->name }}"
                                     class="w-20 h-12 object-cover rounded border border-white/10">
                            @else
                                <div class="w-20 h-12 bg-[#1A1A1A] rounded border border-white/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </td>

                        {{-- Name --}}
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-medium">{{ $package->name }}</p>
                            <p class="text-gray-500 text-xs mt-0.5">{{ $package->slug }}</p>
                        </td>

                        {{-- Tagline --}}
                        <td class="px-6 py-4">
                            <span class="text-gray-300 text-sm">{{ Str::limit($package->tagline, 40) }}</span>
                        </td>

                        {{-- Price From --}}
                        <td class="px-6 py-4">
                            @if($package->price_from)
                                <span class="text-[#C9A84C] text-sm font-medium">RM {{ number_format($package->price_from, 2) }}</span>
                            @else
                                <span class="text-gray-500 text-sm">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4">
                            @if($package->is_active)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.packages.edit', $package) }}"
                                   class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this package?')">
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
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                <p class="text-sm">No packages found.</p>
                                <a href="{{ route('admin.packages.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Create your first package →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@extends('layouts.admin')
@section('title', 'Certifications')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Certifications</h1>
            <p class="text-gray-400 mt-1">Manage certifications and accreditations</p>
        </div>
        <a href="{{ route('admin.certifications.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Certification
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Certifications Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Image</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Name</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Issuer</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Valid From</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Valid Until</th>
                    <th class="text-left text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Active</th>
                    <th class="text-right text-xs font-medium text-gray-400 uppercase tracking-wider px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($certifications as $certification)
                    <tr class="hover:bg-white/5 transition">
                        {{-- Image Thumbnail --}}
                        <td class="px-6 py-4">
                            @if($certification->certificate_image_path)
                                <img src="{{ asset('storage/' . $certification->certificate_image_path) }}" alt="{{ $certification->name }}"
                                     class="w-[60px] h-[60px] object-cover rounded border border-white/10">
                            @else
                                <div class="w-[60px] h-[60px] bg-[#1A1A1A] rounded border border-white/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                            @endif
                        </td>

                        {{-- Name --}}
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-medium">{{ $certification->name }}</p>
                        </td>

                        {{-- Issuer --}}
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $certification->issuing_body ?? '—' }}
                        </td>

                        {{-- Valid From --}}
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $certification->valid_from ? $certification->valid_from->format('d M Y') : '—' }}
                        </td>

                        {{-- Valid Until --}}
                        <td class="px-6 py-4 text-gray-300 text-sm">
                            {{ $certification->valid_until ? $certification->valid_until->format('d M Y') : '—' }}
                        </td>

                        {{-- Active Badge --}}
                        <td class="px-6 py-4">
                            @if($certification->is_active)
                                <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                            @else
                                <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.certifications.edit', $certification) }}"
                                   class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.certifications.destroy', $certification) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this certification?')">
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
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                <p class="text-sm">No certifications found.</p>
                                <a href="{{ route('admin.certifications.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Add your first certification →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

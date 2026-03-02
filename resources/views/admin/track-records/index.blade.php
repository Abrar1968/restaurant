@extends('layouts.admin')

@section('title', 'Track Records')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Track Records</h1>
        <a href="{{ route('admin.track-records.create') }}"
           class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Record
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-[#1A1A1A]">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Year</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Event Type</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Active</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($records as $record)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-6 py-4">
                            <span class="text-2xl font-bold text-[#C9A84C]">{{ $record->year }}</span>
                        </td>
                        <td class="px-6 py-4 text-white font-medium">{{ $record->title }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $record->client_name }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-white/10 text-gray-300 px-2.5 py-1 rounded text-xs font-medium">
                                {{ $record->event_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($record->is_active)
                                <span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded text-xs font-medium">Active</span>
                            @else
                                <span class="bg-red-500/20 text-red-400 px-2.5 py-1 rounded text-xs font-medium">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.track-records.edit', $record) }}"
                                   class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-3 py-1.5 rounded text-sm transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.track-records.destroy', $record) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            No track records found. <a href="{{ route('admin.track-records.create') }}" class="text-[#C9A84C] hover:underline">Add one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($records, 'links'))
        <div class="mt-4">
            {{ $records->links() }}
        </div>
    @endif
</div>
@endsection

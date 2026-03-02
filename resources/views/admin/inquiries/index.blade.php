@extends('layouts.admin')

@section('title', 'Contact Inquiries')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Contact Inquiries</h1>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Status Filter Tabs --}}
    <div x-data="{ current: '{{ request('status', 'all') }}' }" class="flex items-center gap-1 bg-[#111] border border-white/10 rounded-lg p-1 w-fit">
        <a href="{{ route('admin.inquiries.index') }}"
           @click="current = 'all'"
           :class="current === 'all' ? 'bg-[#C9A84C] text-black' : 'text-gray-400 hover:text-white'"
           class="px-4 py-2 rounded text-sm font-medium transition">
            All
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'new']) }}"
           @click="current = 'new'"
           :class="current === 'new' ? 'bg-[#C9A84C] text-black' : 'text-gray-400 hover:text-white'"
           class="px-4 py-2 rounded text-sm font-medium transition">
            New
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'read']) }}"
           @click="current = 'read'"
           :class="current === 'read' ? 'bg-[#C9A84C] text-black' : 'text-gray-400 hover:text-white'"
           class="px-4 py-2 rounded text-sm font-medium transition">
            Read
        </a>
        <a href="{{ route('admin.inquiries.index', ['status' => 'replied']) }}"
           @click="current = 'replied'"
           :class="current === 'replied' ? 'bg-[#C9A84C] text-black' : 'text-gray-400 hover:text-white'"
           class="px-4 py-2 rounded text-sm font-medium transition">
            Replied
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-[#111] border border-white/10 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#1A1A1A]">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Company</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Event Type</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Event Date</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($inquiries as $inquiry)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-white font-medium">{{ $inquiry->name }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $inquiry->company ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $inquiry->email }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $inquiry->event_type ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-300">
                                {{ $inquiry->event_date ? \Carbon\Carbon::parse($inquiry->event_date)->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @switch($inquiry->status)
                                    @case('new')
                                        <span class="bg-[#C9A84C]/20 text-[#C9A84C] px-2.5 py-1 rounded text-xs font-medium">New</span>
                                        @break
                                    @case('read')
                                        <span class="bg-white/10 text-gray-400 px-2.5 py-1 rounded text-xs font-medium">Read</span>
                                        @break
                                    @case('replied')
                                        <span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded text-xs font-medium">Replied</span>
                                        @break
                                    @default
                                        <span class="bg-white/10 text-gray-400 px-2.5 py-1 rounded text-xs font-medium">{{ ucfirst($inquiry->status) }}</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $inquiry->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.inquiries.show', $inquiry) }}"
                                       class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-3 py-1.5 rounded text-sm transition">
                                        View
                                    </a>
                                    <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
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
                            <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                                No inquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($inquiries->hasPages())
        <div class="mt-4">
            {{ $inquiries->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

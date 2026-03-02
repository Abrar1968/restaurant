@extends('layouts.admin')

@section('title', 'Inquiry from ' . $inquiry->name)

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.inquiries.index') }}" class="text-gray-400 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">Inquiry from {{ $inquiry->name }}</h1>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Info Card --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Contact Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <div>
                <dt class="text-sm text-gray-400">Name</dt>
                <dd class="text-white mt-1">{{ $inquiry->name }}</dd>
            </div>

            {{-- Company --}}
            <div>
                <dt class="text-sm text-gray-400">Company</dt>
                <dd class="text-white mt-1">{{ $inquiry->company ?? '-' }}</dd>
            </div>

            {{-- Email --}}
            <div>
                <dt class="text-sm text-gray-400">Email</dt>
                <dd class="mt-1">
                    <a href="mailto:{{ $inquiry->email }}" class="text-[#C9A84C] hover:underline">{{ $inquiry->email }}</a>
                </dd>
            </div>

            {{-- Phone --}}
            <div>
                <dt class="text-sm text-gray-400">Phone</dt>
                <dd class="text-white mt-1">{{ $inquiry->phone ?? '-' }}</dd>
            </div>

            {{-- Event Type --}}
            <div>
                <dt class="text-sm text-gray-400">Event Type</dt>
                <dd class="text-white mt-1">{{ $inquiry->event_type ?? '-' }}</dd>
            </div>

            {{-- Expected Guests --}}
            <div>
                <dt class="text-sm text-gray-400">Expected Guests</dt>
                <dd class="text-white mt-1">{{ $inquiry->expected_guests ?? '-' }}</dd>
            </div>

            {{-- Event Date --}}
            <div>
                <dt class="text-sm text-gray-400">Event Date</dt>
                <dd class="text-white mt-1">
                    {{ $inquiry->event_date ? \Carbon\Carbon::parse($inquiry->event_date)->format('d M Y') : '-' }}
                </dd>
            </div>

            {{-- Status --}}
            <div>
                <dt class="text-sm text-gray-400">Status</dt>
                <dd class="mt-1">
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
                </dd>
            </div>

            {{-- Submitted At --}}
            <div class="md:col-span-2">
                <dt class="text-sm text-gray-400">Submitted At</dt>
                <dd class="text-white mt-1">{{ $inquiry->created_at->format('d M Y, h:i A') }} ({{ $inquiry->created_at->diffForHumans() }})</dd>
            </div>
        </div>
    </div>

    {{-- Message Card --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Message</h2>
        <div class="bg-[#1A1A1A] rounded-lg p-4 text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $inquiry->message ?? 'No message provided.' }}</div>
    </div>

    {{-- Action Buttons --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Actions</h2>
        <div class="flex flex-wrap items-center gap-3">
            {{-- Mark as Read --}}
            @if($inquiry->status === 'new')
                <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="read">
                    <button type="submit"
                            class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
                        Mark as Read
                    </button>
                </form>
            @endif

            {{-- Mark as Replied --}}
            @if($inquiry->status !== 'replied')
                <form action="{{ route('admin.inquiries.update', $inquiry) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="replied">
                    <button type="submit"
                            class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-4 py-2 rounded transition">
                        Mark as Replied
                    </button>
                </form>
            @endif

            {{-- Reply via Email --}}
            <a href="mailto:{{ $inquiry->email }}"
               class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-4 py-2 rounded transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Reply via Email
            </a>

            {{-- Delete --}}
            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-4 py-2 rounded transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

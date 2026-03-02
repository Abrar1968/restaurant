@extends('layouts.admin')
@section('title', 'Clients')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Clients</h1>
            <p class="text-gray-400 mt-1">Manage client logos and information</p>
        </div>
        <a href="{{ route('admin.clients.create') }}" class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
            + Add Client
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Client Grid --}}
    @if($clients->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($clients as $client)
                <div class="bg-[#111] border border-white/10 rounded-lg p-6 flex flex-col items-center text-center">
                    {{-- Logo --}}
                    <div class="w-full h-20 flex items-center justify-center mb-4">
                        @if($client->logo_path)
                            <img src="{{ asset('storage/' . $client->logo_path) }}" alt="{{ $client->name }}"
                                 class="max-h-20 max-w-full object-contain">
                        @else
                            <div class="w-20 h-20 bg-[#1A1A1A] rounded-lg border border-white/10 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        @endif
                    </div>

                    {{-- Name --}}
                    <h3 class="text-white text-sm font-medium mb-3">{{ $client->name }}</h3>

                    {{-- Badges --}}
                    <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
                        @if($client->show_in_marquee)
                            <span class="bg-[#C9A84C]/10 text-[#C9A84C] text-xs font-medium px-2.5 py-1 rounded-full">Marquee</span>
                        @endif
                        @if($client->is_active)
                            <span class="bg-green-500/10 text-green-400 text-xs font-medium px-2.5 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-red-500/10 text-red-400 text-xs font-medium px-2.5 py-1 rounded-full">Inactive</span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 mt-auto">
                        <a href="{{ route('admin.clients.edit', $client) }}"
                           class="bg-[#C9A84C]/10 text-[#C9A84C] hover:bg-[#C9A84C]/20 px-3 py-1.5 rounded text-sm transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this client?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-[#111] border border-white/10 rounded-lg p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p class="text-gray-500 text-sm">No clients found.</p>
            <a href="{{ route('admin.clients.create') }}" class="text-[#C9A84C] text-sm hover:underline mt-1 inline-block">Add your first client →</a>
        </div>
    @endif
</div>

@endsection

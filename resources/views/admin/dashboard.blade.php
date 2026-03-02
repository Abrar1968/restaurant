@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="space-y-8">
    {{-- Page Header --}}
    <div>
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="text-gray-400 mt-1">Welcome back to Sanjung Delights Admin</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Menu Categories --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Menu Categories</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['menus'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.menus.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">Manage →</a>
        </div>

        {{-- Packages --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Packages</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['packages'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.packages.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">Manage →</a>
        </div>

        {{-- Gallery Images --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Gallery Images</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['gallery_images'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">Manage →</a>
        </div>

        {{-- Clients --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Active Clients</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['clients'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.clients.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">Manage →</a>
        </div>

        {{-- Certifications --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Certifications</p>
                    <p class="text-3xl font-bold text-white mt-1">{{ $stats['certifications'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.certifications.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">Manage →</a>
        </div>

        {{-- Contact Inquiries --}}
        <div class="bg-[#111] border border-white/10 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Contact Inquiries</p>
                    <div class="flex items-center gap-3 mt-1">
                        <p class="text-3xl font-bold text-white">{{ $stats['inquiries'] ?? 0 }}</p>
                        @if(($stats['pending_inquiries'] ?? 0) > 0)
                            <span class="bg-[#C9A84C] text-black text-xs font-bold px-2 py-0.5 rounded-full">{{ $stats['pending_inquiries'] }} new</span>
                        @endif
                    </div>
                </div>
                <div class="w-12 h-12 bg-[#C9A84C]/10 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="text-[#C9A84C] text-sm mt-3 inline-block hover:underline">View All →</a>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="bg-[#111] border border-white/10 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-white mb-4">Quick Actions</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.hero-slides.create') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">+ Add Hero Slide</a>
            <a href="{{ route('admin.menus.create') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">+ Add Menu</a>
            <a href="{{ route('admin.packages.create') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">+ Add Package</a>
            <a href="{{ route('admin.gallery.create') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">+ Add Gallery Image</a>
            <a href="{{ route('admin.clients.create') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">+ Add Client</a>
            <a href="{{ route('admin.settings') }}" class="bg-[#1A1A1A] hover:bg-[#222] border border-white/10 text-gray-300 hover:text-white px-4 py-2 rounded transition text-sm">⚙ Settings</a>
        </div>
    </div>
</div>

@endsection

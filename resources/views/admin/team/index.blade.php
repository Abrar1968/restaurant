@extends('layouts.admin')

@section('title', 'Team Members')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-white">Team Members</h1>
        <a href="{{ route('admin.team.create') }}"
           class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Member
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Team Grid --}}
    @if($members->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($members as $member)
                <div class="bg-[#111] border border-white/10 rounded-lg p-6 text-center">
                    {{-- Photo --}}
                    <div class="flex justify-center mb-4">
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}"
                                 class="w-20 h-20 rounded-full object-cover border-2 border-white/10"
                                 alt="{{ $member->name }}">
                        @else
                            <div class="w-20 h-20 rounded-full bg-[#1A1A1A] border-2 border-white/10 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <h3 class="text-white font-semibold text-lg">{{ $member->name }}</h3>
                    <p class="text-gray-400 text-sm mt-1">{{ $member->position }}</p>

                    {{-- Status --}}
                    <div class="mt-3">
                        @if($member->is_active)
                            <span class="bg-green-500/20 text-green-400 px-2.5 py-1 rounded text-xs font-medium">Active</span>
                        @else
                            <span class="bg-red-500/20 text-red-400 px-2.5 py-1 rounded text-xs font-medium">Inactive</span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-center gap-2 mt-4 pt-4 border-t border-white/10">
                        <a href="{{ route('admin.team.edit', $member) }}"
                           class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-3 py-1.5 rounded text-sm transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.team.destroy', $member) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this team member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-3 py-1.5 rounded text-sm transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-[#111] border border-white/10 rounded-lg p-12 text-center">
            <p class="text-gray-400">No team members found. <a href="{{ route('admin.team.create') }}" class="text-[#C9A84C] hover:underline">Add one</a>.</p>
        </div>
    @endif
</div>
@endsection

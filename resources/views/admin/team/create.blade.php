@extends('layouts.admin')

@section('title', 'Add Team Member')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.team.index') }}" class="text-gray-400 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-white">Add Team Member</h1>
        </div>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-[#111] border border-white/10 rounded-lg p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-1.5">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="Full name">
                </div>

                {{-- Position --}}
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-300 mb-1.5">Position</label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}" required
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                           placeholder="e.g., Head Chef, Event Manager">
                </div>

                {{-- Sort Order --}}
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full">
                </div>

                {{-- Active --}}
                <div class="flex items-center pt-7">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-white/20 bg-[#1A1A1A] text-[#C9A84C] focus:ring-[#C9A84C]">
                        <span class="text-sm font-medium text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="block text-sm font-medium text-gray-300 mb-1.5">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                          class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full"
                          placeholder="Brief biography...">{{ old('bio') }}</textarea>
            </div>

            {{-- Photo Upload --}}
            <div x-data="{ preview: null }">
                <label for="photo" class="block text-sm font-medium text-gray-300 mb-1.5">Photo</label>
                <input type="file" name="photo" id="photo" accept="image/*"
                       @change="if ($event.target.files[0]) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL($event.target.files[0]); }"
                       class="bg-[#1A1A1A] border border-white/10 rounded px-4 py-2.5 text-white focus:border-[#C9A84C] focus:ring-1 focus:ring-[#C9A84C] outline-none w-full file:mr-4 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-[#C9A84C]/20 file:text-[#C9A84C] hover:file:bg-[#C9A84C]/30">
                <template x-if="preview">
                    <div class="mt-3 flex justify-center">
                        <img :src="preview" class="w-24 h-24 rounded-full object-cover border-2 border-white/10" alt="Preview">
                    </div>
                </template>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3 mt-6">
            <a href="{{ route('admin.team.index') }}"
               class="border border-[#C9A84C] text-[#C9A84C] hover:bg-[#C9A84C] hover:text-black px-4 py-2 rounded transition">
                Cancel
            </a>
            <button type="submit"
                    class="bg-[#C9A84C] hover:bg-[#b8993f] text-black font-semibold px-4 py-2 rounded transition">
                Create Member
            </button>
        </div>
    </form>
</div>
@endsection

@props([
    'name' => 'image',
    'existing' => null,
    'label' => 'Upload Image',
])

<div x-data="{ preview: '{{ $existing ?? '' }}' }">
    <label class="text-gray-300 text-sm font-medium block mb-2">{{ $label }}</label>

    {{-- Preview --}}
    <div x-show="preview" class="mb-3">
        <img :src="preview" class="h-32 w-auto rounded-lg object-cover border border-white/10">
    </div>

    {{-- Upload --}}
    <label class="cursor-pointer flex items-center gap-3 bg-[#1A1A1A] border border-dashed border-white/20 hover:border-[#C9A84C]/50 rounded-lg p-4 transition-colors">
        <svg class="w-5 h-5 text-[#C9A84C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
        <span class="text-gray-400 text-sm">Click to upload image</span>
        <input type="file" name="{{ $name }}" accept="image/*" class="hidden"
               @change="preview = URL.createObjectURL($event.target.files[0])">
    </label>

    @error($name)
        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

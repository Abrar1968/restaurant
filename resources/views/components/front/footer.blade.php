{{-- Footer — shown below content on mobile, hidden on desktop (content takes full viewport) --}}
<footer class="bg-green-deep border-t border-gold/20 lg:hidden">
    <div class="px-6 py-4 flex flex-col items-center gap-2">
        <p class="text-white/40 text-xs text-center">
            {{ $settings['sst_notice'] ?? 'All prices are subject to 8% SST.' }}
        </p>
        <p class="text-white/40 text-xs text-center">
            {{ $settings['copyright_text'] ?? '© 2026 Sanjung Delights. All Rights Reserved.' }}
        </p>
    </div>
</footer>

<footer class="bg-[#111111] border-t border-[#C9A84C]/30">
    <div class="max-w-7xl mx-auto px-6 md:px-12 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-gray-400 text-sm text-center md:text-left">
            {{ $settings['sst_notice'] ?? 'All prices are subject to 8% SST.' }}
        </p>
        <p class="text-gray-400 text-sm text-center md:text-right">
            {{ $settings['copyright_text'] ?? '© 2026 Sanjung Delights. All Rights Reserved.' }}
        </p>
    </div>
</footer>

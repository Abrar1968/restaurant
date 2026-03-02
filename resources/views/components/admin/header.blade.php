<header class="fixed top-0 right-0 z-20 h-16 flex items-center justify-between px-6 bg-[#0D0D0D] border-b border-white/5"
        :style="adminSidebarOpen ? 'left: 16rem' : 'left: 0'" style="transition: left 0.3s;">
    <button @click="adminSidebarOpen = !adminSidebarOpen" class="text-gray-400 hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-400">{{ auth()->user()?->name ?? 'Admin' }}</span>
    </div>
</header>

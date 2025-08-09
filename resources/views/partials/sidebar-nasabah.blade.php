{{-- Sidebar Nasabah Partial --}}
<aside 
    class="fixed top-0 left-0 z-40 flex flex-col py-6 overflow-hidden shadow-2xl group sidebar-gradient text-white"
    :class="sidebarOpen ? 'w-[250px]' : 'w-16'"
    style="transition: width 0.3s ease; height: 100vh; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);"
>
    <div class="relative flex flex-col h-full w-full px-4">
        
        {{-- Logo Section with Toggle Button --}}
        <div class="flex items-center justify-center mb-8 mt-14" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
            <div class="flex items-center justify-center gap-2" :class="sidebarOpen ? 'flex-1' : ''">
                <img x-show="sidebarOpen" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                <img x-show="!sidebarOpen" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Kecil">
                {{-- Toggle Button --}}
                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="p-1 rounded-full bg-white/20 hover:bg-white/30 transition-colors duration-200 text-white"
                    :class="sidebarOpen ? 'rotate-180' : ''"
                    style="transition: transform 0.3s ease;"
                >
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
            </div>
        </div>
        
        {{-- Navigation Menu --}}
        <nav class="flex flex-col gap-2 w-full flex-1 overflow-y-auto">
            <a 
                href="{{ route('nasabahdashboard') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'dashboard' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
            >
                <i class="fas fa-home text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
            </a>

            <a 
                href="{{ route('sampahnasabah') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'sampah' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-recycle text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Sampah Saya</span>
            </a>

            <a 
                href="{{ route('riwayattransaksinasabah') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'riwayat' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-history text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Riwayat Transaksi</span>
            </a>

            <a 
                href="{{ route('poin-nasabah') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'poin' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-star text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Poin & Reward</span>
            </a>

            <a 
                href="{{ route('nasabahkomunitas') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'komunitas' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-users text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Komunitas</span>
            </a>

            <a 
                href="{{ route('toko') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'marketplace' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-shopping-cart text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Toko</span>
            </a>

            <a 
                href="{{ route('chat') }}" 
                class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200"
                :class="active === 'chat' ? 'bg-white/20 shadow-sm' : 'hover:bg-white/10 hover:shadow-sm'"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-comments text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Chat</span>
            </a>
        </nav>

        {{-- Bottom Section --}}
        <div class="mt-auto pt-4 border-t border-white/20">
            <a 
                href="{{ route('profile') }}" 
                class="flex items-center p-3 rounded-lg hover:bg-white/10 hover:shadow-sm text-white transition-all duration-200 w-full whitespace-nowrap"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-user text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Profil</span>
            </a>

            <a 
                href="{{ route('settings') }}" 
                class="flex items-center p-3 rounded-lg hover:bg-white/10 hover:shadow-sm text-white transition-all duration-200 w-full whitespace-nowrap"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-cog text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Pengaturan</span>
            </a>

            <a 
                href="{{ route('logout') }}" 
                class="flex items-center p-3 rounded-lg hover:bg-white/10 hover:shadow-sm text-white transition-all duration-200 w-full whitespace-nowrap"
                :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
            >
                <i class="fas fa-sign-out-alt text-lg"></i>
                <span x-show="sidebarOpen" class="text-sm font-medium">Logout</span>
            </a>
        </div>
    </div>
</aside>

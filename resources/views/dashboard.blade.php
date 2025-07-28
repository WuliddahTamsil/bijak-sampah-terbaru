@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Dashboard</span>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-12 h-full w-20 bg-gradient-to-b from-teal-800 to-teal-600 flex flex-col items-center py-6 text-black z-40">
        <div class="mb-8">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-leaf text-white text-sm"></i>
            </div>
        </div>
        <nav class="flex flex-col gap-6 text-xl">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-home"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chart-pie"></i></a>
            <a href="/bank-sampah" class="hover:text-teal-200 transition-colors"><i class="fas fa-balance-scale"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-users"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-list"></i></a>
            <a href="/komunitas" class="hover:text-teal-200 transition-colors"><i class="fas fa-comments"></i></a>
            <a href="/chat" class="hover:text-teal-200 transition-colors"><i class="fas fa-envelope"></i></a>
            <a href="/feedback" class="hover:text-teal-200 transition-colors"><i class="fas fa-info-circle"></i></a>
            <a href="/berita" class="hover:text-teal-200 transition-colors"><i class="fas fa-newspaper"></i></a>
            <a href="/keuangan" class="hover:text-teal-200 transition-colors"><i class="fas fa-wallet"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900">Dashboard</h1>
                <div class="flex items-center gap-6">
                    <a href="/notifikasi" class="relative">
                        <i class="far fa-bell text-2xl text-gray-600"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">2</span>
                    </a>
                    <button><i class="fas fa-search text-2xl text-gray-600"></i></button>
                    <div class="flex items-center gap-2">
                        <a href="/profil" class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600"></i>
                        </a>
                        <i class="fas fa-chevron-down text-gray-600"></i>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left: Hero Section -->
                <div class="space-y-8">
                    <div>
                        <h2 class="text-5xl lg:text-6xl font-black text-gray-900 leading-tight">
                            Dukung <span class="text-teal-500">UMKM</span>,<br>
                            Kurangi <span class="text-teal-500">Sampah</span>,<br>
                            Rawat <span class="text-teal-500">Bumi</span>
                        </h2>
                        <p class="text-gray-600 text-lg mt-6 leading-relaxed">
                            Inovasi ramah lingkungan kini hadir lewat produk UMKM kreatif.
                        </p>
                    </div>

                    <div class="flex gap-4">
                        <a href="#" class="bg-green-400 hover:bg-green-500 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-colors">
                            Selengkapnya
                        </a>
                        <a href="#" class="bg-teal-700 hover:bg-teal-800 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition-colors">
                            Bank Sampah
                        </a>
                    </div>

                    <div class="flex gap-12 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-black text-gray-900">37k+</div>
                            <div class="text-gray-600 text-sm font-medium">User BS</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-gray-900">20kg+</div>
                            <div class="text-gray-600 text-sm font-medium">Sampah</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-black text-gray-900">99k+</div>
                            <div class="text-gray-600 text-sm font-medium">Produk BS</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Gallery -->
                <div class="grid grid-cols-2 grid-rows-3 gap-3 h-[500px]">
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                    <div class="bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
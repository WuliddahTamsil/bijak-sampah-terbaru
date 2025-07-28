@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Notifikasi</span>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="fixed left-0 top-12 h-full w-20 bg-gradient-to-b from-teal-800 to-teal-600 flex flex-col items-center py-6 text-white z-40">
        <div class="mb-8">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-leaf text-white text-sm"></i>
            </div>
        </div>
        <nav class="flex flex-col gap-6 text-xl">
            <a href="/dashboard" class="hover:text-teal-200 transition-colors"><i class="fas fa-home"></i></a>
            <a href="/notifikasi" class="hover:text-teal-200 transition-colors"><i class="fas fa-bell"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-store"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-users"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-list"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-comments"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-info-circle"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Notifikasi</h1>
            <!-- Section Terkini -->
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Terkini</h2>
                <div class="relative">
                    <div class="absolute left-4 right-0 top-6 h-6 bg-gray-300 rounded-lg opacity-40 z-0"></div>
                    <div class="relative z-10 rounded-xl text-white shadow-lg px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between mb-4" style="background: linear-gradient(90deg, #05445E 0%, #0CC9C8 50%, #75E6DA 100%);">
                        <div>
                            <span class="font-bold">Bank Sampah, Lodaya II Bogor:</span> Sampah dari Lodaya II Bogor
                        </div>
                        <div class="flex gap-2 mt-4 md:mt-0">
                            <button class="bg-white text-teal-900 font-semibold px-4 py-1 rounded-md mr-2">Ambil sekarang</button>
                            <button class="bg-white text-teal-900 font-semibold px-4 py-1 rounded-md">Ambil nanti</button>
                        </div>
                        <a href="#" class="ml-4 text-white underline">Selengkapnya</a>
                        <button class="ml-4 text-white text-lg">&times;</button>
                    </div>
                </div>
            </div>
            <!-- Section Riwayat -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Riwayat</h2>
                <div class="space-y-6">
                    <div class="rounded-xl text-white shadow-lg px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between" style="background: linear-gradient(90deg, #05445E 0%, #0CC9C8 50%, #75E6DA 100%);">
                        <div>
                            <span class="font-bold">Bank Sampah, Lodaya II Bogor:</span> Sampah dari Lodaya II Bogor
                        </div>
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <span class="bg-white text-teal-900 px-4 py-1 rounded-md text-sm">02/02/2025</span>
                            <a href="#" class="text-white underline">Selengkapnya</a>
                            <button class="text-white text-lg">&times;</button>
                        </div>
                    </div>
                    <div class="rounded-xl text-white shadow-lg px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between" style="background: linear-gradient(90deg, #05445E 0%, #0CC9C8 50%, #75E6DA 100%);">
                        <div>
                            <span class="font-bold">Toko Anda:</span> Pesanan Tas Nusantara dari Bambang
                        </div>
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <span class="bg-white text-teal-900 px-4 py-1 rounded-md text-sm">02/02/2025</span>
                            <a href="#" class="text-white underline">Selengkapnya</a>
                            <button class="text-white text-lg">&times;</button>
                        </div>
                    </div>
                    <div class="rounded-xl text-white shadow-lg px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between" style="background: linear-gradient(90deg, #05445E 0%, #0CC9C8 50%, #75E6DA 100%);">
                        <div>
                            <span class="font-bold">Toko Anda:</span> Pesanan Tas Nusantara dari Bambang
                        </div>
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <span class="bg-white text-teal-900 px-4 py-1 rounded-md text-sm">02/02/2025</span>
                            <a href="#" class="text-white underline">Selengkapnya</a>
                            <button class="text-white text-lg">&times;</button>
                        </div>
                    </div>
                    <div class="rounded-xl text-white shadow-lg px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between" style="background: linear-gradient(90deg, #05445E 0%, #0CC9C8 50%, #75E6DA 100%);">
                        <div>
                            <span class="font-bold">Toko Anda:</span> Pesanan Tas Nusantara dari Bambang
                        </div>
                        <div class="flex items-center gap-4 mt-4 md:mt-0">
                            <span class="bg-black text-teal-900 px-4 py-1 rounded-md text-sm">02/02/2025</span>
                            <a href="#" class="text-black underline">Selengkapnya</a>
                            <button class="text-black text-lg">&times;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
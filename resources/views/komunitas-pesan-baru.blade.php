@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Komunitas</span>
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
            <a href="/bank-sampah" class="hover:text-teal-200 transition-colors"><i class="fas fa-balance-scale"></i></a>
            <a href="/komunitas" class="hover:text-teal-200 transition-colors"><i class="fas fa-comments"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-info-circle"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1" style="background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%);">
        <div class="p-8 flex gap-8">
            <!-- Left Panel -->
            <div class="w-80 flex-shrink-0">
                <button class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-3 rounded-t-lg">Pesan Baru</button>
                <button class="w-full bg-yellow-200 text-yellow-700 font-semibold py-3 rounded-b-lg mb-6">Balas Pesan Lainnya</button>
                <div class="bg-white rounded-lg shadow p-6 mb-6 flex flex-col items-center border">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-24 h-24 rounded-full object-cover mb-2 border-4 border-white shadow" alt="Profile">
                    <div class="font-bold text-lg">@Putri</div>
                    <div class="text-blue-400 mt-2"><i class="fas fa-users"></i> 125 [ 8 ]</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 mb-6 border">
                    <div class="font-semibold mb-2">&#9733; Diskusi Wajib Dibaca</div>
                    <ul class="list-disc list-inside text-blue-500 text-sm space-y-1">
                        <li><a href="#" class="underline">Panduan Forum: Aturan & Etika Diskusi Komunitas</a></li>
                        <li><a href="#" class="underline">Visi & Misi Bijak Sampah</a></li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg shadow p-4 border">
                    <div class="font-semibold mb-2">Tautan Bermanfaat</div>
                    <ul class="list-disc list-inside text-blue-500 text-sm space-y-1">
                        <li><a href="#" class="underline">Tips Digital Marketing</a></li>
                        <li><a href="#" class="underline">UMKM Daur Ulang Berbasis IoT</a></li>
                        <li><a href="#" class="underline">Panduan Ekspor</a></li>
                    </ul>
                </div>
            </div>
            <!-- Right Panel: Form -->
            <div class="flex-1 bg-transparent flex flex-col justify-center">
                <div class="bg-transparent rounded-lg p-10">
                    <h2 class="text-3xl font-extrabold text-white mb-2">Let's discuss</h2>
                    <h3 class="text-2xl font-bold text-white mb-6">on something <span class="text-lime-300">cool</span> together</h3>
                    <div class="mb-6">
                        <div class="text-white mb-2">Saya tertarik tentang....</div>
                        <div class="flex flex-wrap gap-4">
                            <button class="bg-teal-600 text-white px-6 py-2 rounded-lg font-semibold">Marketing</button>
                            <button class="border border-white text-white px-6 py-2 rounded-lg font-semibold">Daur Ulang</button>
                            <button class="border border-white text-white px-6 py-2 rounded-lg font-semibold">IoT</button>
                            <button class="border border-white text-white px-6 py-2 rounded-lg font-semibold">Sistem</button>
                            <button class="border border-white text-white px-6 py-2 rounded-lg font-semibold">lainnya</button>
                        </div>
                    </div>
                    <form class="space-y-6 mt-8">
                        <div>
                            <label class="block text-white mb-1">Nama Anda</label>
                            <input type="text" class="w-full bg-transparent border-b-2 border-white text-white py-2 px-2 focus:outline-none" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-white mb-1">Email Anda</label>
                            <input type="email" class="w-full bg-transparent border-b-2 border-white text-white py-2 px-2 focus:outline-none" placeholder="Email Anda">
                        </div>
                        <div>
                            <label class="block text-white mb-1">Pesan Anda</label>
                            <textarea class="w-full bg-transparent border-b-2 border-white text-white py-2 px-2 focus:outline-none" rows="3" placeholder="Pesan Anda..."></textarea>
                        </div>
                        <button type="submit" class="mt-6 bg-[#05445E] hover:bg-teal-700 text-white font-semibold px-8 py-3 rounded-lg flex items-center gap-2 mx-auto">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
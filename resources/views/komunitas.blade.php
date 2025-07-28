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
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">Komunitas</h1>
            <div class="flex gap-8">
                <!-- Left Panel -->
                <div class="w-80 flex-shrink-0">
                    <a href="/komunitas/pesan-baru" class="w-full block bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-3 rounded-t-lg text-center">Pesan Baru</a>
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
                <!-- Right Panel: Diskusi -->
                <div class="flex-1 space-y-6">
                    <div class="flex gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">New</span>
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Top</span>
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Hot</span>
                        <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Closed</span>
                    </div>
                    <!-- Diskusi Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">Aisyah <span class="text-gray-400 text-xs ml-2">5 min ago</span></div>
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </div>
                        <div class="font-bold mb-1">Bagaimana cara memasarkan produk UMKM daur ulang secara digital?</div>
                        <div class="text-gray-600 text-sm mb-2">Mohon saran strategi pemasaran digital yang cocok untuk skala kecil menengah.</div>
                        <div class="flex gap-2 mb-2">
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">UMKM</span>
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">DAUR ULANG</span>
                        </div>
                        <div class="flex gap-6 text-gray-400 text-xs">
                            <span><i class="fas fa-eye"></i> 125</span>
                            <span><i class="fas fa-comment"></i> 15</span>
                            <span><i class="fas fa-heart"></i> 155</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">Ghina <span class="text-gray-400 text-xs ml-2">25 min ago</span></div>
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </div>
                        <div class="font-bold mb-1">Apa perbedaan sistem IoT untuk monitoring sampah rumah tangga dan industri?</div>
                        <div class="text-gray-600 text-sm mb-2">Apakah ada referensi atau studi kasus yang bisa saya pelajari?</div>
                        <div class="flex gap-2 mb-2">
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">UMKM</span>
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">IoT</span>
                        </div>
                        <div class="flex gap-6 text-gray-400 text-xs">
                            <span><i class="fas fa-eye"></i> 125</span>
                            <span><i class="fas fa-comment"></i> 15</span>
                            <span><i class="fas fa-heart"></i> 155</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">Wuwu <span class="text-gray-400 text-xs ml-2">2 days ago</span></div>
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </div>
                        <div class="font-bold mb-1">Saya ingin belajar IoT untuk mendukung produk UMKM. Harus mulai dari mana?</div>
                        <div class="text-gray-600 text-sm mb-2">Adakah sumber belajar yang mudah dipahami?</div>
                        <div class="flex gap-2 mb-2">
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">IT</span>
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">SENSOR</span>
                        </div>
                        <div class="flex gap-6 text-gray-400 text-xs">
                            <span><i class="fas fa-eye"></i> 125</span>
                            <span><i class="fas fa-comment"></i> 15</span>
                            <span><i class="fas fa-heart"></i> 155</span>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold">WUGIS <span class="text-gray-400 text-xs ml-2">2 days ago</span></div>
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </div>
                        <div class="font-bold mb-1">-</div>
                        <div class="text-gray-600 text-sm mb-2">-</div>
                        <div class="flex gap-2 mb-2">
                            <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs">-</span>
                        </div>
                        <div class="flex gap-6 text-gray-400 text-xs">
                            <span><i class="fas fa-eye"></i> 125</span>
                            <span><i class="fas fa-comment"></i> 15</span>
                            <span><i class="fas fa-heart"></i> 155</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
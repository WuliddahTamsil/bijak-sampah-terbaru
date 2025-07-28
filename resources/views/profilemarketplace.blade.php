<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Profil</span>
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
            <h1 class="text-4xl font-bold text-gray-900 mb-6">Profil</h1>
            <!-- Banner Gradasi -->
            <div class="w-full h-6 rounded-lg mb-8" style="background: linear-gradient(90deg, #B6D0E2 0%, #F7EEDD 100%);"></div>
            <!-- Profile Info -->
            <div class="flex items-center gap-6 mb-8">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow" alt="Profile">
                <div>
                    <div class="text-xl font-bold text-gray-800">Putri Cantika</div>
                    <div class="text-blue-400">putricantika@gmail.com</div>
                </div>
                <button class="ml-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold">Edit</button>
            </div>
            <!-- Form 2 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" value="Putri Cantika" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                    <label class="block text-gray-700 font-semibold mb-2">Gender</label>
                    <input type="text" value="Perempuan" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                    <label class="block text-gray-700 font-semibold mb-2">No. Telepon/Email</label>
                    <input type="text" value="087806181962" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Pendek</label>
                    <input type="text" value="Putri" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                    <label class="block text-gray-700 font-semibold mb-2">Nama UMKM</label>
                    <input type="text" value="UMKM ASIK" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                    <label class="block text-gray-700 font-semibold mb-2">Alamat UMKM</label>
                    <input type="text" value="Lodaya II, Bogor" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Alamat e-mail saya</label>
                    <div class="flex items-center gap-4 bg-blue-50 rounded-lg p-4 mb-2">
                        <span class="bg-blue-400 text-white rounded-full w-8 h-8 flex items-center justify-center"><i class="fas fa-envelope"></i></span>
                        <div>
                            <div class="text-gray-800">putricantika@gmail.com</div>
                            <div class="text-gray-400 text-xs">1 bulan yang lalu</div>
                        </div>
                    </div>
                    <button class="bg-blue-100 text-blue-500 px-4 py-2 rounded-lg font-semibold">+Tambah alamat email</button>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Password Anda</label>
                    <input type="password" value="passworddummy" class="w-full bg-[#05445E] text-black rounded-lg px-4 py-3 mb-4" readonly>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
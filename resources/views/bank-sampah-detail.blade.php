@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Detail Bank Sampah</span>
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
        <div class="p-8 max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Invoice #TEK12345</h1>
            <div class="flex flex-col md:flex-row gap-8">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="w-full md:w-80 h-60 object-cover rounded-lg shadow" alt="Sampah">
                <div class="flex-1 space-y-4">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Tanggal:</span>
                        <span class="font-semibold text-gray-800">12/02/2025</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Jenis Sampah:</span>
                        <span class="font-semibold text-gray-800">Botol Plastik</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Nama:</span>
                        <span class="font-semibold text-gray-800">BS - Lodaya II</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Phone number:</span>
                        <span class="font-semibold text-gray-800">087876529</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Alamat:</span>
                        <span class="font-semibold text-gray-800">Lodaya II, Bogor</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">Quantity:</span>
                        <span class="font-semibold text-gray-800">100 Kg</span>
                    </div>
                    <div class="flex gap-4 mt-6">
                        <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg">Diambil nanti</button>
                        <button class="bg-green-400 hover:bg-green-500 text-white font-semibold px-6 py-2 rounded-lg">Sudah diambil</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
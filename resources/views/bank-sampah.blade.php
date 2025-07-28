@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Bank Sampah</span>
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
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Bank Sampah</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-center">
                <!-- Card 1 -->
                <div class="rounded-xl shadow-lg p-4 bg-white" style="background: linear-gradient(180deg, #05445E 0%, #0CC9C8 80%, #75E6DA 100%);">
                    <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="w-full h-56 object-cover rounded-lg mb-4" alt="Lodaya II">
                    <div class="flex justify-between text-blue-100 text-sm mb-2">
                        <span>@Wugis</span>
                        <span>Berat</span>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <span class="font-bold text-white">Lodaya II</span>
                        <span class="font-bold text-white">10KG</span>
                    </div>
                    <a href="/bank-sampah/1" class="block w-full text-center bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 rounded-lg transition-colors">Selengkapnya</a>
                </div>
                <!-- Card 2 -->
                <div class="rounded-xl shadow-lg p-4 bg-white" style="background: linear-gradient(180deg, #05445E 0%, #0CC9C8 80%, #75E6DA 100%);">
                    <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" class="w-full h-56 object-cover rounded-lg mb-4" alt="Malabar">
                    <div class="flex justify-between text-blue-100 text-sm mb-2">
                        <span>@Wugis</span>
                        <span>Berat</span>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <span class="font-bold text-white">Malabar</span>
                        <span class="font-bold text-white">10KG</span>
                    </div>
                    <a href="/bank-sampah/2" class="block w-full text-center bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 rounded-lg transition-colors">Selengkapnya</a>
                </div>
                <!-- Card 3 -->
                <div class="rounded-xl shadow-lg p-4 bg-white" style="background: linear-gradient(180deg, #05445E 0%, #0CC9C8 80%, #75E6DA 100%);">
                    <img src="https://images.unsplash.com/photo-1506784983877-45594efa4cbe?auto=format&fit=crop&w=400&q=80" class="w-full h-56 object-cover rounded-lg mb-4" alt="Sancang Dalam">
                    <div class="flex justify-between text-blue-100 text-sm mb-2">
                        <span>@Wugis</span>
                        <span>Berat</span>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <span class="font-bold text-white">Sancang Dalam</span>
                        <span class="font-bold text-white">10KG</span>
                    </div>
                    <a href="/bank-sampah/3" class="block w-full text-center bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 rounded-lg transition-colors">Selengkapnya</a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
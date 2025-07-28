@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Berita</span>
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
            <a href="/berita" class="hover:text-teal-200 transition-colors"><i class="fas fa-newspaper"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Berita</h1>
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-teal-900 mb-2">Berita Lainnya</h2>
                <p class="text-teal-400">Yuk baca beberapa berita!</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 justify-items-center">
                @for ($i = 0; $i < 6; $i++)
                <div class="rounded-2xl shadow-lg bg-white pb-6" style="background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%); min-width:300px; max-width:340px;">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" class="w-full h-48 object-cover rounded-t-2xl" alt="Berita">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-16 h-16 rounded-full border-4 border-white absolute left-1/2 -bottom-8 transform -translate-x-1/2" alt="Avatar">
                    </div>
                    <div class="pt-12 px-6 text-center">
                        <div class="font-bold text-white text-lg mb-2">Wugis</div>
                        <div class="text-white text-sm mb-6">Para pelaku UMKM semakin memperhatikan pentingnya pengelolaan sampah melalui pendekatan daur ulang yang berbasis teknologi.</div>
                        <a href="/berita/{{ $i+1 }}" class="block w-full text-center bg-lime-400 hover:bg-lime-500 text-white font-semibold py-2 rounded-lg transition-colors">Baca</a>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </main>
</div>
@endsection 
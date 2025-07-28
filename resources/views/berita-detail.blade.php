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
        <div class="p-8 max-w-3xl mx-auto">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover rounded-2xl mb-8" alt="Berita">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Pentingnya Pengelolaan Sampah Berbasis Teknologi</h1>
            <div class="flex items-center gap-6 mb-6 text-gray-500 text-sm">
                <span><i class="fas fa-user"></i> Wugis</span>
                <span><i class="fas fa-calendar"></i> 2024</span>
            </div>
            <div class="text-lg text-gray-800 leading-relaxed mb-8">
                Para pelaku UMKM semakin memperhatikan pentingnya pengelolaan sampah melalui pendekatan daur ulang yang berbasis teknologi. Dengan inovasi dan kolaborasi, pengelolaan sampah kini menjadi peluang bisnis sekaligus solusi lingkungan. Teknologi digital, IoT, dan edukasi masyarakat menjadi kunci sukses pengelolaan sampah modern.<br><br>
                Selain itu, peran komunitas sangat penting dalam mendorong perubahan perilaku dan membangun ekosistem daur ulang yang berkelanjutan. Pemerintah, pelaku usaha, dan masyarakat perlu bersinergi agar pengelolaan sampah tidak hanya berdampak pada lingkungan, tetapi juga ekonomi lokal.
            </div>
            <a href="/berita" class="inline-block bg-teal-700 hover:bg-teal-800 text-white font-semibold px-6 py-2 rounded-lg">Kembali ke Berita</a>
        </div>
    </main>
</div>
@endsection 
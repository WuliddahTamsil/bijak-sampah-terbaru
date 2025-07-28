@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Chat</span>
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
            <a href="/keuangan" class="hover:text-teal-200 transition-colors"><i class="fas fa-wallet"></i></a>
            <a href="/chat" class="hover:text-teal-200 transition-colors"><i class="fas fa-envelope"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="flex h-[80vh] mt-8 bg-white rounded-xl shadow overflow-hidden">
            <!-- Daftar Chat -->
            <div class="w-80 border-r bg-white flex flex-col">
                <div class="p-6 text-2xl font-bold text-gray-800">Pesan</div>
                <div class="flex-1 overflow-y-auto">
                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-[#05445E] to-[#75E6DA] rounded-xl mx-4 mb-2 cursor-pointer">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-white">BS Lodaya II</div>
                            <div class="text-white text-xs">Baik Terima Kasih</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-gray-100 rounded-xl mx-4 mb-2 cursor-pointer">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <div class="font-bold text-gray-800">Wugis</div>
                            <div class="text-gray-500 text-xs">Baik...terima kasih</div>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex justify-end">
                    <button class="bg-[#05445E] text-white p-3 rounded-full shadow"><i class="fas fa-pen"></i></button>
                </div>
            </div>
            <!-- Area Chat -->
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between border-b p-4">
                    <div>
                        <div class="font-bold text-gray-800">BS Lodaya II</div>
                        <div class="text-xs text-teal-500">Online</div>
                    </div>
                    <button><i class="fas fa-ellipsis-v text-gray-500"></i></button>
                </div>
                <div class="flex-1 bg-gray-50 p-6 overflow-y-auto flex flex-col gap-4">
                    <div class="self-start bg-teal-200 text-gray-800 px-4 py-2 rounded-2xl rounded-bl-sm text-sm max-w-xs">Baik <span class="text-xs text-black-500 ml-2">00:08</span></div>
                    <div class="self-end bg-[#05445E] text-black px-4 py-2 rounded-2xl rounded-br-sm text-sm max-w-xs">Halo, saya akan kesana ya. Mohon ditunggu <span class="text-xs text-black-300 ml-2">00:08</span></div>
                    <div class="self-end bg-[#05445E] text-black px-4 py-2 rounded-2xl rounded-br-sm text-sm max-w-xs">Baik terima kasih <span class="text-xs text-black-300 ml-2">00:08</span></div>
                </div>
                <form class="flex items-center gap-4 border-t p-4">
                    <input type="text" class="flex-1 border-2 border-teal-400 rounded-xl px-4 py-2 focus:outline-none" placeholder="Tulis pesan...">
                    <button type="submit" class="bg-[#05445E] text-white px-4 py-2 rounded-xl"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection 
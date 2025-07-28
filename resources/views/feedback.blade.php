@extends('layouts.app')

@section('content')
<style>
    .emoji-radio input:checked + span {
        border: 2px solid #0CC9C8;
        box-shadow: 0 0 0 2px #0CC9C8;
        transform: scale(1.2);
        background: #e0f7fa;
    }
    .emoji-radio span {
        transition: all 0.2s;
        border-radius: 9999px;
        padding: 0.1em 0.2em;
        display: inline-block;
    }
</style>
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Feedback</span>
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
            <a href="/feedback" class="hover:text-teal-200 transition-colors"><i class="fas fa-info-circle"></i></a>
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="p-8 max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">Umpan Balik</h1>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Mari beri <span class="text-teal-500">masukan</span><br>tentang sesuatu <span class="text-teal-400">bersama-sama</span></h2>
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
            @endif
            <form class="space-y-6 pb-24" method="POST" action="{{ url('/feedback') }}">
                @csrf
                <input name="name" type="text" class="w-full border-2 border-blue-400 rounded-full px-4 py-3 focus:outline-none mb-2" placeholder="Nama Anda..." required>
                <input name="email" type="email" class="w-full border-2 border-gray-300 rounded-full px-4 py-3 focus:outline-none mb-2" placeholder="Email Anda..." required>
                <div>
                    <label class="block text-gray-800 font-semibold mb-2">Bagaimana pengalaman Anda?</label>
                    <div class="flex gap-4 text-3xl mb-2">
                        <label class="emoji-radio"><input type="radio" name="rating" value="1" class="hidden" required><span>😔</span></label>
                        <label class="emoji-radio"><input type="radio" name="rating" value="2" class="hidden"><span>😟</span></label>
                        <label class="emoji-radio"><input type="radio" name="rating" value="3" class="hidden"><span>🙂</span></label>
                        <label class="emoji-radio"><input type="radio" name="rating" value="4" class="hidden"><span>😊</span></label>
                        <label class="emoji-radio"><input type="radio" name="rating" value="5" class="hidden"><span>😁</span></label>
                    </div>
                    <div class="text-gray-400 italic text-sm">Pilih salah satu!</div>
                </div>
                <textarea name="message" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:outline-none" rows="3" placeholder="Kasih saran atau pendapat Anda!" required></textarea>
                <button type="submit" class="fixed left-1/2 -translate-x-1/2 bottom-8 w-2/3 bg-[#05445E] hover:bg-teal-700 text-black font-semibold py-3 rounded-full shadow-lg z-50">Send Feedback</button>
            </form>
        </div>
    </main>
</div>
<script>
    // Highlight emoji saat dipilih
    document.querySelectorAll('.emoji-radio input[type=radio]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.emoji-radio span').forEach(function(span) {
                span.style.background = '';
            });
            if (this.checked) {
                this.nextElementSibling.style.background = '#b2f5ea';
            }
        });
    });
</script>
@endsection 
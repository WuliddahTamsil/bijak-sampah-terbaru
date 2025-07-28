@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    <!-- Top Bar -->
    <div class="fixed top-0 left-0 right-0 h-12 bg-gray-800 z-50">
        <div class="flex items-center h-full px-6">
            <span class="text-white font-medium">Keuangan</span>
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
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-cog"></i></a>
        </nav>
        <div class="mt-auto">
            <a href="#" class="hover:text-teal-200 transition-colors"><i class="fas fa-chevron-right"></i></a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-20 pt-12 flex-1">
        <div class="p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Keuangan</h1>
            <div class="flex gap-6 mb-8">
                <button class="px-8 py-3 rounded-full font-semibold bg-lime-400 text-black shadow">Pemasukan</button>
                <button class="px-8 py-3 rounded-full font-semibold bg-yellow-400 text-black shadow">Pengeluaran</button>
            </div>
            <div class="flex flex-col md:flex-row gap-8 mb-8">
                <!-- Card Saldo -->
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between w-full md:w-1/3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-semibold">23 Maret 25</span>
                    </div>
                    <div class="font-bold text-lg mb-1">BS, PAY!</div>
                    <div class="text-gray-400 text-sm mb-4">Saldo anda terbilang...</div>
                    <span class="inline-block bg-lime-100 text-lime-700 px-3 py-1 rounded-full text-xs font-semibold mb-4">Medium</span>
                    <div class="flex items-center gap-4">
                        <div class="bg-gray-100 rounded-full p-4">
                            <i class="fas fa-wallet text-2xl text-teal-700"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-800">Rp202.000</div>
                            <div class="text-gray-400 text-sm">Pemasukan</div>
                        </div>
                    </div>
                </div>
                <!-- Chart Dummy -->
                <div class="flex-1 bg-gradient-to-b from-[#05445E] to-[#75E6DA] rounded-2xl shadow p-6 flex flex-col justify-end">
                    <div class="flex items-end h-64 gap-6 justify-between relative">
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-black-700 rounded-t-lg" style="height: 40%; width: 100%"></div>
                            <span class="text-xs text-black mt-2">16 Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 70%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">17 Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-12 relative">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 100%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">18 Mar</span>
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-white text-gray-800 px-4 py-1 rounded-lg shadow text-xs font-semibold">Hurraaahhh!<br>Super Laris<br>97%</div>
                        </div>
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 70%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">19 Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 50%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">20 Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 60%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">21 Mar</span>
                        </div>
                        <div class="flex flex-col items-center w-12">
                            <div class="bg-blue-700 rounded-t-lg" style="height: 60%; width: 100%"></div>
                            <span class="text-xs text-white mt-2">22 Mar</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabel Riwayat Pemasukan -->
            <div class="bg-gradient-to-br from-[#05445E] to-[#75E6DA] rounded-2xl shadow p-8">
                <div class="text-black text-xl font-bold mb-4">Pemasukan</div>
                <div class="text-white mb-4">Cek riwayat pemasukan Anda!</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-black">
                        <thead>
                            <tr class="border-b border-white/30">
                                <th class="px-4 py-2 text-left">No. Invoice</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Nama Pembeli</th>
                                <th class="px-4 py-2 text-left">Nama Produk</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 8; $i++)
                            <tr class="border-b border-black/20">
                                <td class="px-4 py-2">1#TEK12{{ $i+3 }}</td>
                                <td class="px-4 py-2">16/06/25</td>
                                <td class="px-4 py-2">{{ $i % 2 == 0 ? 'Wugis' : 'BS' }}</td>
                                <td class="px-4 py-2">{{ $i % 2 == 0 ? 'T#Tas Kreasi' : 'TopUp Coin' }}</td>
                                <td class="px-4 py-2">Rp20.000</td>
                                <td class="px-4 py-2">...</td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection 
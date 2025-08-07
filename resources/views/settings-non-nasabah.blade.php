@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'settings';
@endphp

@section('title', 'Pengaturan - Bijak Sampah')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            <i class="fas fa-cog text-blue-500 mr-3"></i>
            Pengaturan
        </h1>
        <p class="text-gray-600">Atur preferensi aplikasi Anda</p>
    </div>

    <!-- Settings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Tema -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-palette text-2xl text-purple-500"></i>
                <h3 class="text-lg font-semibold">Tema</h3>
            </div>
            <div class="space-y-3">
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></div>
                        <span>Terang</span>
                    </div>
                    <input type="radio" name="theme" value="light" class="text-blue-500" checked>
                </label>
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gray-800 rounded-full mr-3"></div>
                        <span>Gelap</span>
                    </div>
                    <input type="radio" name="theme" value="dark" class="text-blue-500">
                </label>
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-gradient-to-r from-yellow-400 to-gray-800 rounded-full mr-3"></div>
                        <span>Otomatis</span>
                    </div>
                    <input type="radio" name="theme" value="auto" class="text-blue-500">
                </label>
            </div>
        </div>

        <!-- Bahasa -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-language text-2xl text-green-500"></i>
                <h3 class="text-lg font-semibold">Bahasa</h3>
            </div>
            <select class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="id">Bahasa Indonesia</option>
                <option value="en">English</option>
                <option value="ja">日本語</option>
                <option value="ko">한국어</option>
            </select>
        </div>

        <!-- Ukuran Font -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-text-height text-2xl text-blue-500"></i>
                <h3 class="text-lg font-semibold">Ukuran Font</h3>
            </div>
            <div class="space-y-3">
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <span>Kecil</span>
                    <input type="radio" name="fontSize" value="small" class="text-blue-500">
                </label>
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <span>Sedang</span>
                    <input type="radio" name="fontSize" value="medium" class="text-blue-500" checked>
                </label>
                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <span>Besar</span>
                    <input type="radio" name="fontSize" value="large" class="text-blue-500">
                </label>
            </div>
        </div>

        <!-- Notifikasi -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-bell text-2xl text-orange-500"></i>
                <h3 class="text-lg font-semibold">Notifikasi</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span>Notifikasi Push</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <span>Email Notifikasi</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <span>Reminder Eco Challenge</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Privasi -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-shield-alt text-2xl text-red-500"></i>
                <h3 class="text-lg font-semibold">Privasi</h3>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span>Analytics</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <span>Lokasi</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <span>Data Personal</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Akun -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fas fa-user text-2xl text-indigo-500"></i>
                <h3 class="text-lg font-semibold">Akun</h3>
            </div>
            <div class="space-y-3">
                <button class="w-full text-left p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <span>Edit Profil</span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                </button>
                <button class="w-full text-left p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <span>Ubah Password</span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                </button>
                <button class="w-full text-left p-3 border rounded-lg hover:bg-red-50 transition-colors text-red-600">
                    <div class="flex items-center justify-between">
                        <span>Hapus Akun</span>
                        <i class="fas fa-trash text-red-400"></i>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="text-center mt-8">
        <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-600 hover:to-purple-700 transition-all transform hover:scale-105">
            <i class="fas fa-save mr-2"></i>
            Simpan Pengaturan
        </button>
    </div>
</div>
@endsection 
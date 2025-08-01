<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/kontakld', function () {
    return view('kontakld');
})->name('kontakld');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/notifikasi', function () {
    return view('notifikasi');
})->name('notifikasi');

Route::get('/bank-sampah', function () {
    return view('bank-sampah');
})->name('bank-sampah');

Route::get('/bank-sampah/{id}', function ($id) {
    return view('bank-sampah-detail');
})->name('bank-sampah-detail');

Route::get('/toko', function () {
    return view('toko');
})->name('toko');

Route::get('/product-detail/{id}', function ($id) {
    return view('product-detail', compact('id'));
})->name('product-detail');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/komunitas', function () {
    return view('komunitas');
})->name('komunitas');

Route::get('/komunitas/pesan-baru', function () {
    return view('komunitas-pesan-baru');
})->name('komunitas-pesan-baru');

Route::get('/berita', function () {
    return view('berita');
})->name('berita');

Route::get('/berita/{id}', function ($id) {
    return view('berita-detail');
})->name('berita-detail');

Route::get('/keuangan', function () {
    return view('keuangan');
})->name('keuangan');

Route::get('/pesan', function () {
    return view('pesan');
})->name('pesan');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::get('/umpan-balik', function () {
    return view('umpan-balik');
})->name('umpan-balik');

Route::get('/feedback', function () {
    return view('feedback');
})->name('feedback');

Route::post('/feedback', function (Request $request) {
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'rating' => 'required|integer|between:1,5',
        'message' => 'required|string|max:1000',
    ]);

    // Simpan feedback ke database atau kirim email di sini jika ingin
    // Untuk dummy, cukup tampilkan pesan sukses
    
    // Jika request AJAX, kembalikan JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Terima kasih atas umpan balik Anda!'
        ]);
    }
    
    // Jika bukan AJAX, redirect dengan flash message
    return redirect('/feedback')->with('success', 'Terima kasih atas umpan balik Anda!');
});

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/logout', function () {
    // Logika logout bisa ditambahkan di sini
    return redirect('/')->with('success', 'Berhasil logout!');
})->name('logout');

Route::get('/test-theme', function () {
    return view('test-theme');
})->name('test-theme');

Route::get('/demo-theme', function () {
    return view('demo-theme');
})->name('demo-theme');

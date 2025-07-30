<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/aboutbj', function () {
    return view('aboutbj');
});

Route::get('/kontakld', function () {
    return view('kontakld');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/notifikasi', function () {
    return view('notifikasi');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/bank-sampah', function () {
    return view('bank-sampah');
});

Route::get('/bank-sampah/{id}', function ($id) {
    return view('bank-sampah-detail');
});

Route::get('/komunitas', function () {
    return view('komunitas');
});

Route::get('/komunitas/pesan-baru', function () {
    return view('komunitas-pesan-baru');
});

Route::get('/berita', function () {
    return view('berita');
});

Route::get('/berita/{id}', function ($id) {
    return view('berita-detail');
});

Route::get('/keuangan', function () {
    return view('keuangan');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::get('/feedback', function () {
    return view('feedback');
});
Route::post('/feedback', function (Request $request) {
    // Simpan feedback ke database atau kirim email di sini jika ingin
    // Untuk dummy, cukup tampilkan pesan sukses
    return redirect('/feedback')->with('success', 'Terima kasih atas umpan balik Anda!');
});

// Route untuk nasabahregister
Route::get('/nasabahregister', function () {
    return view('nasabahregister');
});

Route::get('/nasabahdashboard', function () {
    return view('nasabahdashboard');
});
// ...existing code...
Route::get('/nasabahregister', function () {
    return view('nasabahregister');
})->name('nasabah.register');
// ...existing code...
Route::get('/sampahnasabah', function () {
    return view('sampahnasabah');
});

Route::get('/nasabahkomunitas', function () {
    return view('nasabahkomunitas');
});

Route::get('/poin-nasabah', function () {
    return view('poin-nasabah');
});



Route::get('/non-nasabah-register', function () {
    return view('non-nasabah-register');
});



Route::get('/non-nasabah-dashboard', function () {
    return view('non-nasabah-dashboard');
});


Route::get('/poin-non-nasabah', function () {
    return view('poin-non-nasabah');
});

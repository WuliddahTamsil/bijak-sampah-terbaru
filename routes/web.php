<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/profil', function () {
    return view('profil');
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

Route::get('/profil', function () {
    return view('profil');
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

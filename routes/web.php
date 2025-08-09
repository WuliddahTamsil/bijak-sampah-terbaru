<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('pilihan-login');
})->name('login');

Route::get('/register', function () {
    return view('pilihan-login');
})->name('register');

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

Route::get('/test-settings', function () {
    return view('test-settings');
})->name('test-settings');

Route::get('/logout', function () {
    // Redirect ke halaman login atau home setelah logout
    return redirect('/login');
})->name('logout');

Route::get('/test-theme', function () {
    return view('test-theme');
})->name('test-theme');


Route::get('/demo-theme', function () {
    return view('demo-theme');
})->name('demo-theme');

Route::get('/poin-nasabah', function () {
    return view('poin-nasabah');
})->name('poin-nasabah');

Route::get('/non-nasabah-register', function () {
    return view('non-nasabah-register');
})->name('non-nasabah-register');

Route::get('/non-nasabah-dashboard', function () {
    return view('non-nasabah-dashboard');
})->name('non-nasabah-dashboard');

Route::get('/poin-non-nasabah', function () {
    return view('poin-non-nasabah');
})->name('poin-non-nasabah');

Route::get('/settingsbank', function () {
    return view('settingsbank');
})->name('settingsbank');

Route::get('/profilebank', function () {
    return view('profilebank');
})->name('profilebank');

Route::get('/notifikasibank', function () {
    return view('notifikasibank');
})->name('notifikasibank');

Route::get('/pilihan-login', function () {
    return view('pilihan-login');
})->name('pilihan-login');

Route::get('/dashboard-banksampah', function () {
    return view('dashboard-banksampah');
})->name('dashboard-banksampah');

Route::get('/data-nasabah-banksampah', function () {
    return view('data-nasabah-banksampah');
})->name('data-nasabah-banksampah');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/penjemputan-sampah-banksampah', function () {
    return view('penjemputan-sampah-banksampah');
})->name('penjemputan-sampah-banksampah');

Route::get('/nasabahdashboard', function () {
    return view('nasabahdashboard');
})->name('nasabahdashboard');

Route::get('/nasabahregister', function () {
    return view('nasabahregister');
})->name('nasabahregister');

Route::get('/sampahnasabah', function () {
    return view('sampahnasabah');
})->name('sampahnasabah');

Route::get('/nasabahkomunitas', function () {
    return view('nasabahkomunitas');
})->name('nasabahkomunitas');

Route::get('/profilenasabah', function () {
    return view('profilenasabah');
})->name('profilenasabah');

Route::get('/riwayattransaksinasabah', function () {
    return view('riwayattransaksinasabah');
})->name('riwayattransaksinasabah');

Route::get('/tokou', function () {
    return view('tokou');
})->name('tokou');

Route::get('/tokon', function () {
    return view('tokon');
})->name('tokon');

Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/settings-non-nasabah', function () {
    return view('settings-non-nasabah');
})->name('settings-non-nasabah');

Route::get('/settingsnasab', function () {
    return view('settings');
})->name('settingsnasab');


Route::get('/penimbangansampah-banksampah', function () {
    return view('penimbangansampah-banksampah');
})->name('penimbangansampah-banksampah');

Route::get('/datasampah-banksampah', function () {
    return view('datasampah-banksampah');
})->name('datasampah-banksampah');

Route::get('/penjualansampah-banksampah', function () {
    return view('penjualansampah-banksampah');
})->name('penjualansampah-banksampah');

Route::get('/verifikasi-nasabah-banksampah', function () {
    return view('verifikasi-nasabah-banksampah');
})->name('verifikasi-nasabah-banksampah');

// Route baru yang ditambahkan untuk mengatasi error
Route::get('/input-setoran', function () {
    return view('input-setoran');
})->name('input-setoran');

Route::post('/send-verification-email', function (Request $request) {
    // Validasi input
    $request->validate([
        'to' => 'required|email',
        'name' => 'required|string',
        'accountNumber' => 'required|string',
        'deviceId' => 'required|string',
        'jenisBak' => 'required|string',
        'noBak' => 'required|string',
        'email' => 'required|email'
    ]);

    try {
        // Data email
        $emailData = $request->all();
        
        // Kirim email menggunakan Laravel Mail
        \Mail::send('emails.verification-success', $emailData, function($message) use ($emailData) {
            $message->to($emailData['to'])
                    ->subject('Verifikasi Nasabah Bijak Sampah - Berhasil');
        });

        return response()->json([
            'success' => true,
            'message' => 'Email verifikasi berhasil dikirim'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim email: ' . $e->getMessage()
        ], 500);
    }
})->name('send-verification-email');
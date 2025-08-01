# Sistem Tema Global BijakSampah

## Overview
Sistem tema global memungkinkan pengguna untuk mengubah tema (terang/gelap), bahasa, dan ukuran font yang akan diterapkan secara serentak ke semua halaman aplikasi.

## Fitur Utama

### 1. Tema (Theme)
- **Light**: Tema terang (default)
- **Dark**: Tema gelap
- **Auto**: Mengikuti preferensi sistem

### 2. Bahasa (Language)
- **Indonesia** (id): Bahasa default
- **English** (en): Bahasa Inggris
- **日本語** (ja): Bahasa Jepang

### 3. Ukuran Font
- **Small**: 14px
- **Medium**: 16px (default)
- **Large**: 18px

## Implementasi

### File Utama
1. **`resources/views/layouts/app.blade.php`**: Layout utama dengan CSS variables dan Alpine.js
2. **`public/asset/js/theme-manager.js`**: JavaScript untuk mengelola tema global
3. **`public/asset/js/update-themes.js`**: Script untuk memperbarui tema di semua halaman
4. **`resources/views/settings.blade.php`**: Halaman pengaturan yang terintegrasi dengan sistem global

### CSS Variables
Sistem menggunakan CSS variables untuk konsistensi tema:

```css
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --text-primary: #1f2937;
    --sidebar-gradient: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
    /* ... */
}

.dark {
    --bg-primary: #1f2937;
    --bg-secondary: #111827;
    --text-primary: #f9fafb;
    --sidebar-gradient: linear-gradient(135deg, #1e293b 0%, #0f172a 63%);
    /* ... */
}
```

### Storage
Pengaturan disimpan di `localStorage` dengan key `globalSettings`:
```javascript
{
    "theme": "light",
    "language": "id", 
    "fontSize": "medium"
}
```

## Cara Kerja

### 1. Inisialisasi
- Theme manager diinisialisasi saat halaman dimuat
- Pengaturan dibaca dari localStorage
- Tema diterapkan sesuai pengaturan

### 2. Perubahan Pengaturan
- Pengguna mengubah pengaturan di halaman Settings
- Pengaturan disimpan ke localStorage
- Event `storage` dipicu untuk sinkronisasi antar tab/window
- Semua halaman otomatis memperbarui tema

### 3. Sinkronisasi Antar Halaman
- Menggunakan `localStorage` dan `storage` event
- Perubahan di satu halaman langsung diterapkan di halaman lain
- Tidak perlu refresh halaman

## Penggunaan

### Di Halaman Settings
```javascript
// Mengubah tema
this.settings.appearance.theme = 'dark';
this.applyTheme();

// Mengubah bahasa
this.settings.appearance.language = 'en';
this.applyLanguage();

// Mengubah ukuran font
this.settings.appearance.fontSize = 'large';
this.applyFontSize();
```

### Di Halaman Lain
```javascript
// Mengakses pengaturan global
const settings = window.themeManager.getSettings();

// Memperbarui tema secara manual
window.updateThemeManually();
```

## Keuntungan

1. **Konsistensi**: Tema diterapkan serentak ke semua halaman
2. **Real-time**: Perubahan langsung terlihat tanpa refresh
3. **Persisten**: Pengaturan tersimpan dan tidak hilang saat refresh
4. **Sinkronisasi**: Antar tab/window tetap sinkron
5. **Performant**: Menggunakan CSS variables untuk performa optimal

## Troubleshooting

### Tema tidak berubah
1. Pastikan `theme-manager.js` dimuat
2. Cek localStorage untuk pengaturan yang tersimpan
3. Pastikan CSS variables sudah didefinisikan

### Gradient tidak berubah
1. Pastikan menggunakan `var(--sidebar-gradient)`
2. Jalankan `updateGradients()` untuk memperbarui manual
3. Cek apakah ada inline styles yang override

### Bahasa tidak berubah
1. Pastikan label sudah didefinisikan untuk bahasa tersebut
2. Cek apakah `applyLanguage()` dipanggil
3. Pastikan `document.documentElement.lang` diupdate 
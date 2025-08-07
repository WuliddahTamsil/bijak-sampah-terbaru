@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Test Pengaturan Global</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Current Settings Display -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Pengaturan Saat Ini</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="font-medium">Tema:</span>
                        <span id="currentTheme" class="text-blue-600">Loading...</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Bahasa:</span>
                        <span id="currentLanguage" class="text-blue-600">Loading...</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Ukuran Font:</span>
                        <span id="currentFontSize" class="text-blue-600">Loading...</span>
                    </div>
                </div>
            </div>

            <!-- Test Controls -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Test Kontrol</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tema</label>
                        <select id="testTheme" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="light">Terang</option>
                            <option value="dark">Gelap</option>
                            <option value="auto">Auto</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Font</label>
                        <select id="testFontSize" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="small">Kecil</option>
                            <option value="medium">Sedang</option>
                            <option value="large">Besar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bahasa</label>
                        <select id="testLanguage" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option value="id">Indonesia</option>
                            <option value="en">English</option>
                            <option value="ja">日本語</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Content -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Konten Test</h2>
            <p class="text-gray-600 mb-4">
                Ini adalah halaman test untuk memverifikasi bahwa pengaturan tema, bahasa, dan ukuran font 
                bekerja dengan baik di seluruh aplikasi. Jika pengaturan berfungsi dengan benar, Anda akan 
                melihat perubahan pada halaman ini dan halaman lainnya.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-900">Tema</h3>
                    <p class="text-blue-700 text-sm">Background dan warna teks akan berubah sesuai tema yang dipilih.</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-900">Ukuran Font</h3>
                    <p class="text-green-700 text-sm">Ukuran teks akan berubah sesuai pengaturan yang dipilih.</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-900">Bahasa</h3>
                    <p class="text-purple-700 text-sm">Preferensi bahasa akan tersimpan untuk halaman berikutnya.</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-8 flex gap-4">
            <a href="/settings" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Settings
            </a>
            <a href="/dashboard" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                Dashboard
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update current settings display
    function updateCurrentSettings() {
        const settings = window.globalSettings || {
            theme: localStorage.getItem('theme') || 'light',
            language: localStorage.getItem('language') || 'id',
            fontSize: localStorage.getItem('fontSize') || 'medium'
        };

        document.getElementById('currentTheme').textContent = settings.theme;
        document.getElementById('currentLanguage').textContent = settings.language;
        document.getElementById('currentFontSize').textContent = settings.fontSize;

        // Update test controls
        document.getElementById('testTheme').value = settings.theme;
        document.getElementById('testLanguage').value = settings.language;
        document.getElementById('testFontSize').value = settings.fontSize;
    }

    // Initialize test controls
    const testTheme = document.getElementById('testTheme');
    const testLanguage = document.getElementById('testLanguage');
    const testFontSize = document.getElementById('testFontSize');

    if (testTheme) {
        testTheme.addEventListener('change', function() {
            if (window.saveSettings) {
                window.saveSettings('theme', this.value);
            } else {
                localStorage.setItem('theme', this.value);
                if (window.applyGlobalSettings) {
                    window.applyGlobalSettings();
                }
            }
            updateCurrentSettings();
        });
    }

    if (testLanguage) {
        testLanguage.addEventListener('change', function() {
            if (window.saveSettings) {
                window.saveSettings('language', this.value);
            } else {
                localStorage.setItem('language', this.value);
            }
            updateCurrentSettings();
            alert('Perubahan bahasa akan diterapkan pada halaman berikutnya.');
        });
    }

    if (testFontSize) {
        testFontSize.addEventListener('change', function() {
            if (window.saveSettings) {
                window.saveSettings('fontSize', this.value);
            } else {
                localStorage.setItem('fontSize', this.value);
                if (window.applyGlobalSettings) {
                    window.applyGlobalSettings();
                }
            }
            updateCurrentSettings();
        });
    }

    // Update display initially and listen for changes
    updateCurrentSettings();
    
    // Listen for settings changes
    window.addEventListener('settingsChanged', function(e) {
        console.log('Settings changed on test page:', e.detail);
        updateCurrentSettings();
    });

    // Update periodically to catch any changes
    setInterval(updateCurrentSettings, 2000);
});
</script>
@endsection 
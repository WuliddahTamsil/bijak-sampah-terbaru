@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background-color: var(--bg-secondary);">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8" style="color: var(--text-primary);">Demo: Global Theme System</h1>
        
        <!-- Language Demo -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Language Demo</h2>
            <p class="mb-4" style="color: var(--text-secondary);">This text will change language when you change the language setting:</p>
            
            <div class="space-y-2">
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Current Language:</strong> 
                    <span id="current-lang-display" style="color: var(--text-secondary);">Loading...</span>
                </div>
                
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Sample Text:</strong>
                    <div id="sample-text" style="color: var(--text-secondary);">
                        <p>Welcome to our application! This text will change based on your language setting.</p>
                        <p>Go to Settings page and change the language to see this text update in real-time.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Font Size Demo -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Font Size Demo</h2>
            <p class="mb-4" style="color: var(--text-secondary);">This text will change size when you change the font size setting:</p>
            
            <div class="space-y-2">
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Current Font Size:</strong> 
                    <span id="current-font-display" style="color: var(--text-secondary);">Loading...</span>
                </div>
                
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Sample Text (will resize):</strong>
                    <div id="font-demo-text" style="color: var(--text-secondary);">
                        <p>This is a sample text that demonstrates font size changes.</p>
                        <p>Go to Settings page and change the font size to see this text resize in real-time.</p>
                        <p>The entire page font size will change based on your setting.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Demo -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Theme Demo</h2>
            <p class="mb-4" style="color: var(--text-secondary);">This section demonstrates theme changes:</p>
            
            <div class="space-y-2">
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Current Theme:</strong> 
                    <span id="current-theme-display" style="color: var(--text-secondary);">Loading...</span>
                </div>
                
                <div class="p-3 rounded border" style="border-color: var(--border-primary);">
                    <strong style="color: var(--text-primary);">Theme Colors:</strong>
                    <div style="color: var(--text-secondary);">
                        <p>Background: This card uses theme background colors</p>
                        <p>Text: This text uses theme text colors</p>
                        <p>Border: This border uses theme border colors</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="bg-white rounded-lg shadow-md p-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Navigation</h2>
            <div class="space-y-2">
                <a href="{{ route('settings') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Go to Settings
                </a>
                <a href="{{ route('test-theme') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 ml-2">
                    Go to Test Page
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Sample text translations
const translations = {
    id: {
        welcome: "Selamat datang di aplikasi kami! Teks ini akan berubah berdasarkan pengaturan bahasa Anda.",
        instruction: "Pergi ke halaman Settings dan ubah bahasa untuk melihat teks ini diperbarui secara real-time.",
        fontDemo: "Ini adalah contoh teks yang mendemonstrasikan perubahan ukuran font.",
        fontInstruction: "Pergi ke halaman Settings dan ubah ukuran font untuk melihat teks ini berubah ukuran secara real-time.",
        fontNote: "Ukuran font seluruh halaman akan berubah berdasarkan pengaturan Anda.",
        themeDemo: "Bagian ini mendemonstrasikan perubahan tema:",
        themeColors: "Warna Tema:",
        themeBg: "Latar Belakang: Kartu ini menggunakan warna latar belakang tema",
        themeText: "Teks: Teks ini menggunakan warna teks tema",
        themeBorder: "Batas: Batas ini menggunakan warna batas tema"
    },
    en: {
        welcome: "Welcome to our application! This text will change based on your language setting.",
        instruction: "Go to Settings page and change the language to see this text update in real-time.",
        fontDemo: "This is a sample text that demonstrates font size changes.",
        fontInstruction: "Go to Settings page and change the font size to see this text resize in real-time.",
        fontNote: "The entire page font size will change based on your setting.",
        themeDemo: "This section demonstrates theme changes:",
        themeColors: "Theme Colors:",
        themeBg: "Background: This card uses theme background colors",
        themeText: "Text: This text uses theme text colors",
        themeBorder: "Border: This border uses theme border colors"
    },
    ja: {
        welcome: "アプリケーションへようこそ！このテキストは言語設定に基づいて変更されます。",
        instruction: "設定ページに移動して言語を変更すると、このテキストがリアルタイムで更新されるのを確認できます。",
        fontDemo: "これはフォントサイズの変更を示すサンプルテキストです。",
        fontInstruction: "設定ページに移動してフォントサイズを変更すると、このテキストがリアルタイムでサイズ変更されるのを確認できます。",
        fontNote: "ページ全体のフォントサイズは設定に基づいて変更されます。",
        themeDemo: "このセクションはテーマの変更を示します：",
        themeColors: "テーマカラー：",
        themeBg: "背景：このカードはテーマの背景色を使用します",
        themeText: "テキスト：このテキストはテーマのテキスト色を使用します",
        themeBorder: "境界線：この境界線はテーマの境界線色を使用します"
    }
};

// Font size labels
const fontSizeLabels = {
    small: { id: 'Kecil', en: 'Small', ja: '小' },
    medium: { id: 'Sedang', en: 'Medium', ja: '中' },
    large: { id: 'Besar', en: 'Large', ja: '大' }
};

// Language labels
const languageLabels = {
    id: 'Indonesia',
    en: 'English',
    ja: '日本語'
};

// Theme labels
const themeLabels = {
    light: { id: 'Terang', en: 'Light', ja: 'ライト' },
    dark: { id: 'Gelap', en: 'Dark', ja: 'ダーク' },
    auto: { id: 'Otomatis', en: 'Auto', ja: '自動' }
};

function updateDemoContent() {
    // Get current settings
    let settings = { theme: 'light', language: 'id', fontSize: 'medium' };
    if (window.themeManager && window.themeManager.initialized) {
        settings = window.themeManager.getSettings();
    }
    
    // Update language display
    const langDisplay = document.getElementById('current-lang-display');
    if (langDisplay) {
        langDisplay.textContent = languageLabels[settings.language] || settings.language;
    }
    
    // Update font size display
    const fontDisplay = document.getElementById('current-font-display');
    if (fontDisplay) {
        const fontSizeLabel = fontSizeLabels[settings.fontSize];
        const currentLang = settings.language;
        fontDisplay.textContent = fontSizeLabel ? fontSizeLabel[currentLang] || fontSizeLabel.en : settings.fontSize;
    }
    
    // Update theme display
    const themeDisplay = document.getElementById('current-theme-display');
    if (themeDisplay) {
        const themeLabel = themeLabels[settings.theme];
        const currentLang = settings.language;
        themeDisplay.textContent = themeLabel ? themeLabel[currentLang] || themeLabel.en : settings.theme;
    }
    
    // Update sample text
    const sampleText = document.getElementById('sample-text');
    if (sampleText && translations[settings.language]) {
        sampleText.innerHTML = `
            <p>${translations[settings.language].welcome}</p>
            <p>${translations[settings.language].instruction}</p>
        `;
    }
    
    // Update font demo text
    const fontDemoText = document.getElementById('font-demo-text');
    if (fontDemoText && translations[settings.language]) {
        fontDemoText.innerHTML = `
            <p>${translations[settings.language].fontDemo}</p>
            <p>${translations[settings.language].fontInstruction}</p>
            <p>${translations[settings.language].fontNote}</p>
        `;
    }
}

// Listen for changes
document.addEventListener('DOMContentLoaded', function() {
    updateDemoContent();
    
    // Update every 2 seconds
    setInterval(updateDemoContent, 2000);
    
    // Listen for storage events
    window.addEventListener('storage', function(e) {
        if (e.key === 'globalSettings') {
            setTimeout(updateDemoContent, 100);
        }
    });
    
    // Listen for language and font size changes
    window.addEventListener('languageChanged', function(e) {
        console.log('Demo page: Language changed to:', e.detail.language);
        setTimeout(updateDemoContent, 100);
    });
    
    window.addEventListener('fontSizeChanged', function(e) {
        console.log('Demo page: Font size changed to:', e.detail.fontSize);
        setTimeout(updateDemoContent, 100);
    });
});
</script>
@endsection 
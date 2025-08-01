@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background-color: var(--bg-secondary);">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold" style="color: var(--text-primary);">Test Theme System</h1>
        
        <!-- Debug Section -->
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
            <h3 class="font-bold mb-2">Debug Information:</h3>
            <div id="debug-info" class="text-sm">
                <p>Loading debug info...</p>
            </div>
        </div>

        <!-- Manual Test Section -->
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <h3 class="font-bold mb-2">Manual Test:</h3>
            <div class="space-y-2">
                <button onclick="manualTestDark()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Force Dark Theme (Manual Test)
                </button>
                <button onclick="manualTestLight()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Force Light Theme (Manual Test)
                </button>
                <button onclick="debugTheme()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Debug Theme (Console)
                </button>
            </div>
        </div>

        <!-- Current Settings -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Current Settings</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded" style="background-color: var(--bg-secondary);">
                    <h3 class="font-medium" style="color: var(--text-primary);">Theme</h3>
                    <p style="color: var(--text-secondary);" id="current-theme">Loading...</p>
                </div>
                <div class="p-4 rounded" style="background-color: var(--bg-secondary);">
                    <h3 class="font-medium" style="color: var(--text-primary);">Language</h3>
                    <p style="color: var(--text-secondary);" id="current-language">Loading...</p>
                </div>
                <div class="p-4 rounded" style="background-color: var(--bg-secondary);">
                    <h3 class="font-medium" style="color: var(--text-primary);">Font Size</h3>
                    <p style="color: var(--text-secondary);" id="current-fontsize">Loading...</p>
                </div>
            </div>
        </div>

        <!-- Test Buttons -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Test Theme Changes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <h3 class="font-medium mb-2" style="color: var(--text-primary);">Theme</h3>
                    <div class="space-y-2">
                        <button onclick="testTheme('light')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Light</button>
                        <button onclick="testTheme('dark')" class="w-full bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">Dark</button>
                        <button onclick="testTheme('auto')" class="w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Auto</button>
                    </div>
                </div>
                <div>
                    <h3 class="font-medium mb-2" style="color: var(--text-primary);">Language</h3>
                    <div class="space-y-2">
                        <button onclick="testLanguage('id')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Indonesia</button>
                        <button onclick="testLanguage('en')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">English</button>
                        <button onclick="testLanguage('ja')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Japanese</button>
                    </div>
                </div>
                <div>
                    <h3 class="font-medium mb-2" style="color: var(--text-primary);">Font Size</h3>
                    <div class="space-y-2">
                        <button onclick="testFontSize('small')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Small</button>
                        <button onclick="testFontSize('medium')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Medium</button>
                        <button onclick="testFontSize('large')" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Large</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Test -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Visual Test</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 rounded border" style="background-color: var(--bg-secondary); border-color: var(--border-primary);">
                    <h3 class="font-medium mb-2" style="color: var(--text-primary);">Background Test</h3>
                    <p style="color: var(--text-secondary);">This should change color with theme</p>
                    <div class="mt-2 p-2 border rounded" style="background-color: var(--bg-primary); border-color: var(--border-primary);">
                        <p class="text-sm" style="color: var(--text-primary);">White background test</p>
                    </div>
                </div>
                <div class="p-4 rounded border" style="background-color: var(--bg-primary); border-color: var(--border-primary);">
                    <h3 class="font-medium mb-2" style="color: var(--text-primary);">Text Test</h3>
                    <p style="color: var(--text-secondary);">This text should change color with theme</p>
                    <p class="text-sm" style="color: var(--text-muted);">Secondary text color</p>
                </div>
            </div>
        </div>

        <!-- Gradient Test -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Gradient Test</h2>
            <div class="space-y-4">
                <div class="sidebar-gradient p-4 rounded text-white">
                    <h3 class="font-medium mb-2">Sidebar Gradient</h3>
                    <p>This should change gradient with theme</p>
                </div>
                <div class="fixed-header p-4 rounded text-white">
                    <h3 class="font-medium mb-2">Fixed Header Gradient</h3>
                    <p>This should also change gradient with theme</p>
                </div>
            </div>
        </div>

        <!-- Settings Link -->
        <div class="bg-white rounded-lg shadow-md p-6" style="background-color: var(--bg-primary); color: var(--text-primary);">
            <h2 class="text-xl font-semibold mb-4" style="color: var(--text-primary);">Settings Page</h2>
            <p class="mb-4" style="color: var(--text-secondary);">Go to settings page to test the full functionality:</p>
            <div class="space-y-2">
                <a href="{{ route('settings') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Go to Settings
                </a>
                <a href="{{ route('demo-theme') }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 ml-2">
                    Go to Demo Page
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Manual test functions
function manualTestDark() {
    console.log('Manual test: Applying dark theme');
    document.documentElement.classList.add('dark');
    document.body.classList.add('dark');
    updateDebugInfo();
}

function manualTestLight() {
    console.log('Manual test: Applying light theme');
    document.documentElement.classList.remove('dark');
    document.body.classList.remove('dark');
    updateDebugInfo();
}

// Debug function
function updateDebugInfo() {
    const debugDiv = document.getElementById('debug-info');
    const currentTheme = document.getElementById('current-theme');
    const currentLanguage = document.getElementById('current-language');
    const currentFontsize = document.getElementById('current-fontsize');
    
    // Check if theme manager exists
    const hasThemeManager = typeof window.themeManager !== 'undefined';
    const hasGlobalTheme = typeof window.globalTheme !== 'undefined';
    const isInitialized = hasThemeManager && window.themeManager.initialized;
    
    // Get current settings
    let settings = { theme: 'unknown', language: 'unknown', fontSize: 'unknown' };
    if (hasThemeManager && isInitialized) {
        settings = window.themeManager.getSettings();
    }
    
    // Check localStorage
    const globalSettings = localStorage.getItem('globalSettings');
    const settingsApp = localStorage.getItem('settingsApp');
    
    // Check DOM classes
    const hasDarkClass = document.documentElement.classList.contains('dark');
    const bodyHasDarkClass = document.body.classList.contains('dark');
    
    // Update debug info
    debugDiv.innerHTML = `
        <p><strong>Theme Manager:</strong> ${hasThemeManager ? 'Available' : 'Not Available'}</p>
        <p><strong>Theme Manager Initialized:</strong> ${isInitialized ? 'Yes' : 'No'}</p>
        <p><strong>Global Theme:</strong> ${hasGlobalTheme ? 'Available' : 'Not Available'}</p>
        <p><strong>HTML Dark Class:</strong> ${hasDarkClass ? 'Yes' : 'No'}</p>
        <p><strong>Body Dark Class:</strong> ${bodyHasDarkClass ? 'Yes' : 'No'}</p>
        <p><strong>Global Settings in localStorage:</strong> ${globalSettings ? 'Yes' : 'No'}</p>
        <p><strong>SettingsApp in localStorage:</strong> ${settingsApp ? 'Yes' : 'No'}</p>
        <p><strong>CSS Variables:</strong> ${getComputedStyle(document.documentElement).getPropertyValue('--bg-primary') || 'Not set'}</p>
    `;
    
    // Update current settings display
    currentTheme.textContent = settings.theme;
    currentLanguage.textContent = settings.language;
    currentFontsize.textContent = settings.fontSize;
}

// Test functions
function testTheme(theme) {
    if (window.globalTheme) {
        window.globalTheme.updateSettings({ theme: theme });
        updateDebugInfo();
    } else {
        alert('Theme manager not available!');
    }
}

function testLanguage(language) {
    if (window.globalTheme) {
        window.globalTheme.updateSettings({ language: language });
        updateDebugInfo();
    } else {
        alert('Theme manager not available!');
    }
}

function testFontSize(fontSize) {
    if (window.globalTheme) {
        window.globalTheme.updateSettings({ fontSize: fontSize });
        updateDebugInfo();
    } else {
        alert('Theme manager not available!');
    }
}

    // Update debug info on load and periodically
    document.addEventListener('DOMContentLoaded', function() {
        updateDebugInfo();
        
        // Update every 2 seconds
        setInterval(updateDebugInfo, 2000);
        
        // Listen for storage events
        window.addEventListener('storage', function(e) {
            if (e.key === 'globalSettings') {
                setTimeout(updateDebugInfo, 100);
            }
        });
        
        // Listen for language and font size changes
        window.addEventListener('languageChanged', function(e) {
            console.log('Test page: Language changed to:', e.detail.language);
            setTimeout(updateDebugInfo, 100);
        });
        
        window.addEventListener('fontSizeChanged', function(e) {
            console.log('Test page: Font size changed to:', e.detail.fontSize);
            setTimeout(updateDebugInfo, 100);
        });
    });
</script>
@endsection 
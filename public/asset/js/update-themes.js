// Script untuk memperbarui tema di semua halaman
document.addEventListener('DOMContentLoaded', function() {
    // Update semua gradient yang menggunakan warna lama
    updateGradients();
    
    // Listen for theme changes
    window.addEventListener('storage', function(e) {
        if (e.key === 'globalSettings') {
            updateGradients();
        }
    });
});

function updateGradients() {
    // Update sidebar gradients
    const sidebarGradients = document.querySelectorAll('.sidebar-gradient');
    sidebarGradients.forEach(element => {
        element.style.background = 'var(--sidebar-gradient)';
    });
    
    // Update fixed header gradients
    const fixedHeaders = document.querySelectorAll('.fixed-header');
    fixedHeaders.forEach(element => {
        element.style.background = 'var(--sidebar-gradient)';
    });
    
    // Update inline styles yang menggunakan gradient lama
    const elementsWithGradient = document.querySelectorAll('[style*="linear-gradient"]');
    elementsWithGradient.forEach(element => {
        const style = element.getAttribute('style');
        if (style && style.includes('#75E6DA') && style.includes('#05445E')) {
            // Replace dengan variabel CSS
            const newStyle = style.replace(
                /linear-gradient\([^)]*#75E6DA[^)]*#05445E[^)]*\)/g,
                'var(--sidebar-gradient)'
            );
            element.setAttribute('style', newStyle);
        }
    });
    
    // Update background gradients
    const bgGradients = document.querySelectorAll('[style*="background: linear-gradient"]');
    bgGradients.forEach(element => {
        const style = element.getAttribute('style');
        if (style && style.includes('#75E6DA') && style.includes('#05445E')) {
            // Replace dengan variabel CSS
            const newStyle = style.replace(
                /background:\s*linear-gradient\([^)]*#75E6DA[^)]*#05445E[^)]*\)/g,
                'background: var(--sidebar-gradient)'
            );
            element.setAttribute('style', newStyle);
        }
    });
}

// Function untuk memperbarui tema secara manual
function updateThemeManually() {
    updateGradients();
    
    // Update warna teks dan background
    const textElements = document.querySelectorAll('.text-gray-900, .text-gray-600, .text-gray-500');
    textElements.forEach(element => {
        // Classes sudah dihandle oleh CSS variables di layout utama
    });
    
    // Update background elements
    const bgElements = document.querySelectorAll('.bg-white, .bg-gray-50, .bg-gray-100');
    bgElements.forEach(element => {
        // Classes sudah dihandle oleh CSS variables di layout utama
    });
    
    // Update border elements
    const borderElements = document.querySelectorAll('.border-gray-100, .border-gray-300');
    borderElements.forEach(element => {
        // Classes sudah dihandle oleh CSS variables di layout utama
    });
}

// Export untuk penggunaan global
window.updateThemeManually = updateThemeManually;
window.updateGradients = updateGradients; 
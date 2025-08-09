// Super Admin JavaScript Enhancements

// Modal Management
class SuperAdminModal {
    constructor() {
        this.modal = null;
        this.init();
    }

    init() {
        // Create modal container
        const modalHTML = `
            <div id="superAdminModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white"></h3>
                                <button onclick="superAdminModal.close()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <div id="modalContent" class="text-gray-600 dark:text-gray-400 mb-6"></div>
                            <div class="flex justify-end gap-3">
                                <button id="modalCancel" onclick="superAdminModal.close()" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                                    Cancel
                                </button>
                                <button id="modalConfirm" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        this.modal = document.getElementById('superAdminModal');
    }

    show(title, content, onConfirm) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalContent').innerHTML = content;
        
        const confirmBtn = document.getElementById('modalConfirm');
        confirmBtn.onclick = () => {
            if (onConfirm) onConfirm();
            this.close();
        };
        
        this.modal.classList.remove('hidden');
        setTimeout(() => {
            this.modal.querySelector('.bg-white').classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    close() {
        const modalContent = this.modal.querySelector('.bg-white');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            this.modal.classList.add('hidden');
        }, 300);
    }
}

// Initialize modal
const superAdminModal = new SuperAdminModal();

// Enhanced User Actions
function enhancedViewUser(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (user) {
        const content = `
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">${user.email}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">ID: ${user.id}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Role</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${user.role}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${user.password ? 'Verified' : 'Pending'}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Created At</label>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">${new Date(user.createdAt).toLocaleString('id-ID')}</p>
                    </div>
                </div>
            </div>
        `;
        
        superAdminModal.show('User Details', content);
    }
}

function enhancedEditUser(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (user) {
        const content = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" value="${user.email}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option value="Nasabah" ${user.role === 'Nasabah' ? 'selected' : ''}>Nasabah</option>
                        <option value="UMKM" ${user.role === 'UMKM' ? 'selected' : ''}>UMKM</option>
                        <option value="Bank Sampah" ${user.role === 'Bank Sampah' ? 'selected' : ''}>Bank Sampah</option>
                        <option value="Non Nasabah" ${user.role === 'Non Nasabah' ? 'selected' : ''}>Non Nasabah</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" placeholder="Enter new password" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                </div>
            </div>
        `;
        
        superAdminModal.show('Edit User', content, () => {
            showNotification('User updated successfully!', 'success');
        });
    }
}

function enhancedVerifyUser(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (user) {
        const content = `
            <div class="text-center space-y-4">
                <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-check text-white text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Verify User Account</h4>
                    <p class="text-gray-600 dark:text-gray-400">Are you sure you want to verify this user account?</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-left">
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Email:</strong> ${user.email}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Role:</strong> ${user.role}</p>
                </div>
            </div>
        `;
        
        superAdminModal.show('Verify User', content, () => {
            showNotification(`User ${user.email} verified successfully!`, 'success');
            // Add your verification logic here
        });
    }
}

function enhancedDeleteUser(userId) {
    const user = allUsers.find(u => u.id === userId);
    if (user) {
        const content = `
            <div class="text-center space-y-4">
                <div class="w-20 h-20 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto">
                    <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Delete User Account</h4>
                    <p class="text-gray-600 dark:text-gray-400">This action cannot be undone. Are you sure?</p>
                </div>
                <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 text-left border border-red-200 dark:border-red-800">
                    <p class="text-sm text-red-600 dark:text-red-400"><strong>Email:</strong> ${user.email}</p>
                    <p class="text-sm text-red-600 dark:text-red-400"><strong>Role:</strong> ${user.role}</p>
                    <p class="text-sm text-red-600 dark:text-red-400"><strong>Warning:</strong> All user data will be permanently deleted.</p>
                </div>
            </div>
        `;
        
        superAdminModal.show('Delete User', content, () => {
            showNotification(`User ${user.email} deleted successfully!`, 'success');
            // Add your delete logic here
        });
    }
}

// Enhanced Notifications
function showEnhancedNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    const icon = type === 'success' ? 'fa-check-circle' : 
                 type === 'error' ? 'fa-exclamation-triangle' : 
                 type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    const bgColor = type === 'success' ? 'bg-gradient-to-r from-green-500 to-green-600' :
                    type === 'error' ? 'bg-gradient-to-r from-red-500 to-red-600' :
                    type === 'warning' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600' :
                    'bg-gradient-to-r from-blue-500 to-blue-600';
    
    notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-2xl z-50 ${bgColor} text-white transform translate-x-full transition-transform duration-300`;
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas ${icon} text-xl"></i>
            <div>
                <p class="font-medium">${message}</p>
                <div class="w-full bg-white bg-opacity-20 rounded-full h-1 mt-2">
                    <div class="bg-white h-1 rounded-full transition-all duration-300" style="width: 100%"></div>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-white/80 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 10);
    
    // Progress bar animation
    const progressBar = notification.querySelector('.bg-white.h-1');
    setTimeout(() => {
        progressBar.style.width = '0%';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, duration);
}

// Enhanced Search with Debouncing
function setupEnhancedSearch() {
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = e.target.value.toLowerCase();
            filteredUsers = allUsers.filter(user => 
                user.email.toLowerCase().includes(searchTerm) ||
                user.role.toLowerCase().includes(searchTerm) ||
                user.id.toLowerCase().includes(searchTerm)
            );
            currentPageIndex = 0;
            displayUsers();
            
            // Show search results count
            if (searchTerm) {
                showEnhancedNotification(`Found ${filteredUsers.length} users matching "${searchTerm}"`, 'info', 2000);
            }
        }, 300);
    });
}

// Export functions to global scope
window.enhancedViewUser = enhancedViewUser;
window.enhancedEditUser = enhancedEditUser;
window.enhancedVerifyUser = enhancedVerifyUser;
window.enhancedDeleteUser = enhancedDeleteUser;
window.showEnhancedNotification = showEnhancedNotification;
window.setupEnhancedSearch = setupEnhancedSearch;

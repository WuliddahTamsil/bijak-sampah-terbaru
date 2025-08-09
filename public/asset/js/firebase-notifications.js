// Firebase Real-time Notifications untuk Bank Sampah
import { database, ref, onValue, off } from './firebase-config.js';

class FirebaseNotifications {
    constructor() {
        this.notifications = [];
        this.listeners = new Map();
        this.init();
    }

    init() {
        this.listenToUsersData();
        this.setupNotificationSound();
    }

    // Mendengarkan perubahan data dari Firebase
    listenToUsersData() {
        const usersDataRef = ref(database, 'UsersData');
        
        onValue(usersDataRef, (snapshot) => {
            const data = snapshot.val();
            if (data) {
                this.processUsersData(data);
            }
        }, (error) => {
            console.error('Error listening to Firebase:', error);
        });
    }

    // Memproses data yang masuk dari Firebase
    processUsersData(data) {
        const newNotifications = [];
        
        // Loop melalui semua nasabah
        Object.keys(data).forEach(nasabahKey => {
            if (nasabahKey === 'users verification') return; // Skip verification data
            
            const nasabahData = data[nasabahKey];
            if (nasabahData.status && nasabahData.timestamp) {
                const notification = {
                    id: `${nasabahKey}_${Date.now()}`,
                    nasabah: nasabahKey,
                    status: nasabahData.status,
                    timestamp: nasabahData.timestamp,
                    isNew: true,
                    priority: this.getPriority(nasabahData.status)
                };
                
                newNotifications.push(notification);
                
                // Cek apakah ini notifikasi baru
                if (this.isNewNotification(notification)) {
                    this.showNotification(notification);
                    this.playNotificationSound();
                }
            }
        });
        
        this.notifications = newNotifications;
        this.updateNotificationDisplay();
    }

    // Menentukan prioritas notifikasi berdasarkan status
    getPriority(status) {
        if (status.includes('PENUH')) return 'high';
        if (status.includes('HAMPIR PENUH')) return 'medium';
        return 'low';
    }

    // Cek apakah notifikasi baru
    isNewNotification(notification) {
        const existing = this.notifications.find(n => 
            n.nasabah === notification.nasabah && 
            n.status === notification.status
        );
        return !existing;
    }

    // Menampilkan notifikasi
    showNotification(notification) {
        // Buat toast notification
        const toast = document.createElement('div');
        toast.className = `notification-toast notification-${notification.priority}`;
        toast.innerHTML = `
            <div class="toast-header">
                <strong>${notification.nasabah}</strong>
                <span class="toast-time">${notification.timestamp}</span>
            </div>
            <div class="toast-body">
                Status: ${notification.status}
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animasi masuk
        setTimeout(() => toast.classList.add('show'), 100);
        
        // Auto remove setelah 5 detik
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // Update tampilan notifikasi di dashboard
    updateNotificationDisplay() {
        const container = document.getElementById('firebase-notifications');
        if (!container) return;
        
        container.innerHTML = '';
        
        this.notifications.forEach(notification => {
            const card = this.createNotificationCard(notification);
            container.appendChild(card);
        });
    }

    // Membuat card notifikasi
    createNotificationCard(notification) {
        const card = document.createElement('div');
        card.className = `card notification-card ${notification.priority}`;
        card.innerHTML = `
            <div class="card-header">
                <h4>${notification.nasabah}</h4>
                <span class="status-badge ${notification.priority}">${notification.status}</span>
            </div>
            <div class="card-body">
                <p class="timestamp">${notification.timestamp}</p>
                <div class="actions">
                    <button class="btn btn-primary btn-sm" onclick="handleNotification('${notification.id}')">
                        Tindak Lanjut
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="dismissNotification('${notification.id}')">
                        Tutup
                    </button>
                </div>
            </div>
        `;
        
        return card;
    }

    // Setup suara notifikasi
    setupNotificationSound() {
        this.notificationSound = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT');
    }

    // Mainkan suara notifikasi
    playNotificationSound() {
        if (this.notificationSound) {
            this.notificationSound.play().catch(e => console.log('Audio play failed:', e));
        }
    }

    // Hapus notifikasi
    dismissNotification(id) {
        this.notifications = this.notifications.filter(n => n.id !== id);
        this.updateNotificationDisplay();
    }

    // Cleanup listeners
    destroy() {
        this.listeners.forEach((listener, ref) => {
            off(ref, 'value', listener);
        });
        this.listeners.clear();
    }
}

// Global functions untuk digunakan di HTML
window.handleNotification = function(id) {
    console.log('Handle notification:', id);
    // Implementasi tindak lanjut notifikasi
};

window.dismissNotification = function(id) {
    if (window.firebaseNotifications) {
        window.firebaseNotifications.dismissNotification(id);
    }
};

// Initialize ketika DOM ready
document.addEventListener('DOMContentLoaded', function() {
    window.firebaseNotifications = new FirebaseNotifications();
});

export default FirebaseNotifications;

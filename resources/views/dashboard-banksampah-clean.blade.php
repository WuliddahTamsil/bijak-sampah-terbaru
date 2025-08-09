<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bijak Sampah</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
    
    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .notification-item {
            background: white;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            border-left: 4px solid #10b981;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .notification-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .status-active { background-color: #10b981; }
        .status-inactive { background-color: #ef4444; }
        .status-warning { background-color: #f59e0b; }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .firebase-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .firebase-status.connected {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        
        .firebase-status.disconnected {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .firebase-status.connecting {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fed7aa;
        }
        
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .toast.show {
            transform: translateX(0);
        }
        
        .toast.success { background-color: #10b981; }
        .toast.error { background-color: #ef4444; }
        .toast.info { background-color: #3b82f6; }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: true, expanded: false }" class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar text-white w-16 transition-all duration-300" :class="{ 'w-64': sidebarOpen }">
            <div class="p-4">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <span x-show="sidebarOpen" x-transition class="text-lg font-semibold">Bijak Sampah</span>
                    </div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:text-gray-300">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                
                <nav class="space-y-4">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-home text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-users text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Nasabah</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-truck text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Penjemputan</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-shopping-bag text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Transaksi</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-trash text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Sampah</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-cog text-xl"></i>
                        <span x-show="sidebarOpen" x-transition>Pengaturan</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i class="fas fa-bell text-gray-600 text-xl"></i>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </div>
                        <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Firebase Status -->
                <div id="firebase-status" class="firebase-status connecting">
                    Menghubungkan Firebase...
                </div>

                <!-- Firebase Real-time Analytics -->
                <div class="chart-container mb-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-fire text-red-500 text-xl mr-3"></i>
                        <h2 class="text-xl font-semibold text-gray-800">Firebase Real-time Analytics</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Data real-time dari Firebase Realtime Database</p>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- Status Tempat Sampah -->
                        <div class="bg-white rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Tempat Sampah</h3>
                            <div id="status-container">
                                <!-- Data akan dimuat dari Firebase -->
                            </div>
                        </div>
                        
                        <!-- Aktivitas Update Status -->
                        <div class="bg-white rounded-lg p-6 border">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Update Status</h3>
                            <div id="activity-container">
                                <!-- Data akan dimuat dari Firebase -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Grafik Perubahan Status -->
                    <div class="bg-white rounded-lg p-6 border">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Perubahan Status Over Time</h3>
                        <canvas id="timeseries-chart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- Notifications Container -->
                <div id="firebase-notifications">
                    <!-- Notifications will be loaded here from Firebase -->
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <script>
        // Firebase Configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
            authDomain: "bijaksampah-aeb82.firebaseapp.com",
            databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "bijaksampah-aeb82",
            storageBucket: "bijaksampah-aeb82.firebasestorage.app",
            messagingSenderId: "140467230562",
            appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b"
        };

        // Initialize Firebase
        let database = null;
        let notifications = [];
        let chartData = [];

        // Initialize Firebase when page loads
        document.addEventListener('DOMContentLoaded', function() {
            try {
                firebase.initializeApp(firebaseConfig);
                database = firebase.database();
                updateFirebaseStatus('connected');
                console.log('Firebase initialized successfully');
                
                // Initialize Firebase components
                const firebaseNotifications = new FirebaseNotifications();
                const firebaseCharts = new FirebaseCharts();
                
            } catch (error) {
                console.error('Error initializing Firebase:', error);
                updateFirebaseStatus('disconnected');
            }
        });

        // Firebase Notifications Class
        class FirebaseNotifications {
            constructor() {
                this.notifications = [];
                this.listeners = new Map();
                this.init();
            }

            init() {
                this.listenToAlatData();
                this.setupNotificationSound();
            }

            listenToAlatData() {
                if (!database) {
                    console.error('Database not initialized');
                    return;
                }
                
                const alatDataRef = database.ref('AlatData');
                console.log('Listening to AlatData path:', alatDataRef.toString());
                
                alatDataRef.on('value', (snapshot) => {
                    const data = snapshot.val();
                    console.log('Firebase AlatData received:', data);
                    
                    if (data) {
                        this.processAlatData(data);
                    } else {
                        console.log('No data found in AlatData');
                    }
                }, (error) => {
                    console.error('Error listening to Firebase:', error);
                    updateFirebaseStatus('disconnected');
                });
            }

            processAlatData(data) {
                this.notifications = [];
                
                Object.keys(data).forEach(alatId => {
                    const alat = data[alatId];
                    if (alat.readings) {
                        Object.keys(alat.readings).forEach(readingId => {
                            const reading = alat.readings[readingId];
                            if (reading.status && reading.timestamp) {
                                const notification = {
                                    id: `${alatId}-${readingId}`,
                                    title: `Status Alat ${alatId}`,
                                    message: `Status: ${reading.status}`,
                                    timestamp: reading.timestamp,
                                    status: reading.status,
                                    alatId: alatId
                                };
                                this.notifications.push(notification);
                            }
                        });
                    }
                });
                
                this.displayNotifications();
                this.updateNotificationCount();
            }

            displayNotifications() {
                const container = document.getElementById('firebase-notifications');
                if (!container) return;
                
                container.innerHTML = '';
                
                if (this.notifications.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Belum ada data dari Firebase</p>
                        </div>
                    `;
                    return;
                }
                
                this.notifications.forEach(notif => {
                    const notifElement = this.createNotificationElement(notif);
                    container.appendChild(notifElement);
                });
            }

            createNotificationElement(notification) {
                const div = document.createElement('div');
                div.className = 'notification-item';
                
                const statusClass = this.getStatusClass(notification.status);
                const statusText = this.getStatusText(notification.status);
                
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="status-indicator ${statusClass}"></span>
                            <div>
                                <h4 class="font-semibold text-gray-800">${notification.title}</h4>
                                <p class="text-gray-600 text-sm">${notification.message}</p>
                                <p class="text-gray-500 text-xs mt-1">${this.formatTimestamp(notification.timestamp)}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 rounded-full ${statusClass === 'status-active' ? 'bg-green-100 text-green-800' : statusClass === 'status-warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">
                                ${statusText}
                            </span>
                        </div>
                    </div>
                `;
                
                return div;
            }

            getStatusClass(status) {
                if (status === 'active' || status === 'online' || status === '1') return 'status-active';
                if (status === 'warning' || status === 'maintenance') return 'status-warning';
                return 'status-inactive';
            }

            getStatusText(status) {
                if (status === 'active' || status === 'online' || status === '1') return 'Aktif';
                if (status === 'warning' || status === 'maintenance') return 'Peringatan';
                return 'Tidak Aktif';
            }

            formatTimestamp(timestamp) {
                if (!timestamp) return 'Unknown time';
                
                try {
                    const date = new Date(timestamp);
                    return date.toLocaleString('id-ID');
                } catch (error) {
                    return timestamp;
                }
            }

            updateNotificationCount() {
                const badge = document.querySelector('.fa-bell + span');
                if (badge) {
                    badge.textContent = this.notifications.length;
                }
            }

            setupNotificationSound() {
                // Setup notification sound if needed
            }
        }

        // Firebase Charts Class
        class FirebaseCharts {
            constructor() {
                this.charts = new Map();
                this.init();
            }

            init() {
                this.listenToAlatData();
            }

            listenToAlatData() {
                if (!database) {
                    console.error('Database not initialized');
                    return;
                }
                
                const alatDataRef = database.ref('AlatData');
                console.log('Listening to AlatData for charts:', alatDataRef.toString());
                
                alatDataRef.on('value', (snapshot) => {
                    const data = snapshot.val();
                    console.log('Firebase AlatData for charts received:', data);
                    
                    if (data) {
                        this.processChartData(data);
                    } else {
                        console.log('No chart data found in AlatData');
                    }
                }, (error) => {
                    console.error('Error listening to Firebase for charts:', error);
                });
            }

            processChartData(data) {
                // Process data for status chart
                this.updateStatusChart(data);
                
                // Process data for activity chart
                this.updateActivityChart(data);
                
                // Process data for time series chart
                this.updateTimeSeriesChart(data);
            }

            updateStatusChart(data) {
                const container = document.getElementById('status-container');
                if (!container) return;
                
                let activeCount = 0;
                let inactiveCount = 0;
                let warningCount = 0;
                
                Object.keys(data).forEach(alatId => {
                    const alat = data[alatId];
                    if (alat.readings) {
                        const latestReading = Object.values(alat.readings).pop();
                        if (latestReading && latestReading.status) {
                            if (latestReading.status === 'active' || latestReading.status === 'online' || latestReading.status === '1') {
                                activeCount++;
                            } else if (latestReading.status === 'warning' || latestReading.status === 'maintenance') {
                                warningCount++;
                            } else {
                                inactiveCount++;
                            }
                        }
                    }
                });
                
                container.innerHTML = `
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">${activeCount}</div>
                            <div class="text-sm text-gray-600">Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">${warningCount}</div>
                            <div class="text-sm text-gray-600">Peringatan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">${inactiveCount}</div>
                            <div class="text-sm text-gray-600">Tidak Aktif</div>
                        </div>
                    </div>
                `;
            }

            updateActivityChart(data) {
                const container = document.getElementById('activity-container');
                if (!container) return;
                
                const activities = [];
                Object.keys(data).forEach(alatId => {
                    const alat = data[alatId];
                    if (alat.readings) {
                        Object.keys(alat.readings).forEach(readingId => {
                            const reading = alat.readings[readingId];
                            if (reading.timestamp) {
                                activities.push({
                                    alatId: alatId,
                                    status: reading.status,
                                    timestamp: reading.timestamp
                                });
                            }
                        });
                    }
                });
                
                // Sort by timestamp (newest first)
                activities.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
                
                // Show last 5 activities
                const recentActivities = activities.slice(0, 5);
                
                container.innerHTML = `
                    <div class="space-y-3">
                        ${recentActivities.map(activity => `
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-circle text-xs text-blue-500 mr-3"></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Alat ${activity.alatId}</p>
                                        <p class="text-xs text-gray-600">Status: ${activity.status}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">${this.formatTimestamp(activity.timestamp)}</span>
                            </div>
                        `).join('')}
                    </div>
                `;
            }

            updateTimeSeriesChart(data) {
                const canvas = document.getElementById('timeseries-chart');
                if (!canvas) return;
                
                // Destroy existing chart if it exists
                if (this.charts.has('timeseries')) {
                    this.charts.get('timeseries').destroy();
                }
                
                // Process data for time series
                const timeData = this.processTimeSeriesData(data);
                
                const ctx = canvas.getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: timeData.labels,
                        datasets: [{
                            label: 'Status Changes',
                            data: timeData.values,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
                
                this.charts.set('timeseries', chart);
            }

            processTimeSeriesData(data) {
                const timeMap = new Map();
                
                Object.keys(data).forEach(alatId => {
                    const alat = data[alatId];
                    if (alat.readings) {
                        Object.keys(alat.readings).forEach(readingId => {
                            const reading = alat.readings[readingId];
                            if (reading.timestamp) {
                                const date = new Date(reading.timestamp);
                                const dateKey = date.toLocaleDateString('id-ID');
                                
                                if (timeMap.has(dateKey)) {
                                    timeMap.set(dateKey, timeMap.get(dateKey) + 1);
                                } else {
                                    timeMap.set(dateKey, 1);
                                }
                            }
                        });
                    }
                });
                
                // Sort by date
                const sortedEntries = Array.from(timeMap.entries()).sort((a, b) => {
                    return new Date(a[0]) - new Date(b[0]);
                });
                
                return {
                    labels: sortedEntries.map(entry => entry[0]),
                    values: sortedEntries.map(entry => entry[1])
                };
            }

            formatTimestamp(timestamp) {
                if (!timestamp) return 'Unknown time';
                
                try {
                    const date = new Date(timestamp);
                    return date.toLocaleString('id-ID');
                } catch (error) {
                    return timestamp;
                }
            }
        }

        // Utility Functions
        function updateFirebaseStatus(status) {
            const statusElement = document.getElementById('firebase-status');
            if (!statusElement) return;
            
            statusElement.className = `firebase-status ${status}`;
            
            switch (status) {
                case 'connected':
                    statusElement.textContent = '✅ Firebase Connected';
                    break;
                case 'disconnected':
                    statusElement.textContent = '❌ Firebase Disconnected';
                    break;
                case 'connecting':
                    statusElement.textContent = '🔄 Menghubungkan Firebase...';
                    break;
            }
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;
            
            container.appendChild(toast);
            
            // Show toast
            setTimeout(() => toast.classList.add('show'), 100);
            
            // Hide and remove toast
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => container.removeChild(toast), 300);
            }, 3000);
        }
    </script>
</body>
</html>

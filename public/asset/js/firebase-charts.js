// Firebase Charts dan Analytics untuk Bank Sampah
import { database, ref, onValue } from './firebase-config.js';

class FirebaseCharts {
    constructor() {
        this.chartData = {
            statusHistory: [],
            nasabahStats: {},
            timeSeriesData: []
        };
        this.charts = {};
        this.init();
    }

    init() {
        this.listenToData();
        this.setupCharts();
    }

    // Mendengarkan data dari Firebase untuk grafik
    listenToData() {
        const usersDataRef = ref(database, 'UsersData');
        
        onValue(usersDataRef, (snapshot) => {
            const data = snapshot.val();
            if (data) {
                this.processChartData(data);
                this.updateCharts();
            }
        }, (error) => {
            console.error('Error listening to Firebase for charts:', error);
        });
    }

    // Memproses data untuk grafik
    processChartData(data) {
        const statusHistory = [];
        const nasabahStats = {};
        const timeSeriesData = [];

        Object.keys(data).forEach(nasabahKey => {
            if (nasabahKey === 'users verification') return;
            
            const nasabahData = data[nasabahKey];
            if (nasabahData.status && nasabahData.timestamp) {
                // Data untuk status history
                statusHistory.push({
                    nasabah: nasabahKey,
                    status: nasabahData.status,
                    timestamp: nasabahData.timestamp,
                    date: this.parseTimestamp(nasabahData.timestamp)
                });

                // Data untuk statistik nasabah
                if (!nasabahStats[nasabahKey]) {
                    nasabahStats[nasabahKey] = {
                        totalUpdates: 0,
                        statusCounts: {},
                        lastUpdate: nasabahData.timestamp
                    };
                }
                nasabahStats[nasabahKey].totalUpdates++;
                nasabahStats[nasabahKey].statusCounts[nasabahData.status] = 
                    (nasabahStats[nasabahKey].statusCounts[nasabahData.status] || 0) + 1;
                nasabahStats[nasabahKey].lastUpdate = nasabahData.timestamp;

                // Data untuk time series
                timeSeriesData.push({
                    date: this.parseTimestamp(nasabahData.timestamp),
                    nasabah: nasabahKey,
                    status: nasabahData.status
                });
            }
        });

        this.chartData = {
            statusHistory: statusHistory.sort((a, b) => new Date(b.date) - new Date(a.date)),
            nasabahStats,
            timeSeriesData: timeSeriesData.sort((a, b) => new Date(a.date) - new Date(b.date))
        };
    }

    // Parse timestamp dari format "09-08-2025 13:51"
    parseTimestamp(timestamp) {
        const [datePart, timePart] = timestamp.split(' ');
        const [day, month, year] = datePart.split('-');
        const [hour, minute] = timePart.split(':');
        
        return new Date(year, month - 1, day, hour, minute);
    }

    // Setup grafik
    setupCharts() {
        this.setupStatusChart();
        this.setupNasabahChart();
        this.setupTimeSeriesChart();
    }

    // Grafik status sampah
    setupStatusChart() {
        const ctx = document.getElementById('status-chart');
        if (!ctx) return;

        this.charts.statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        '#FF6B6B', // Merah untuk PENUH
                        '#FFA726', // Orange untuk HAMPIR PENUH
                        '#66BB6A', // Hijau untuk NORMAL
                        '#42A5F5'  // Biru untuk lainnya
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Status Tempat Sampah'
                    }
                }
            }
        });
    }

    // Grafik statistik nasabah
    setupNasabahChart() {
        const ctx = document.getElementById('nasabah-chart');
        if (!ctx) return;

        this.charts.nasabahChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Update Status',
                    data: [],
                    backgroundColor: '#4CAF50',
                    borderColor: '#388E3C',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Aktivitas Update Status per Nasabah'
                    }
                }
            }
        });
    }

    // Grafik time series
    setupTimeSeriesChart() {
        const ctx = document.getElementById('timeseries-chart');
        if (!ctx) return;

        this.charts.timeSeriesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'hour',
                            displayFormats: {
                                hour: 'HH:mm'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Perubahan Status Over Time'
                    }
                }
            }
        });
    }

    // Update semua grafik
    updateCharts() {
        this.updateStatusChart();
        this.updateNasabahChart();
        this.updateTimeSeriesChart();
    }

    // Update grafik status
    updateStatusChart() {
        if (!this.charts.statusChart) return;

        const statusCounts = {};
        this.chartData.statusHistory.forEach(item => {
            statusCounts[item.status] = (statusCounts[item.status] || 0) + 1;
        });

        this.charts.statusChart.data.labels = Object.keys(statusCounts);
        this.charts.statusChart.data.datasets[0].data = Object.values(statusCounts);
        this.charts.statusChart.update();
    }

    // Update grafik nasabah
    updateNasabahChart() {
        if (!this.charts.nasabahChart) return;

        const nasabahNames = Object.keys(this.chartData.nasabahStats);
        const updateCounts = nasabahNames.map(name => this.chartData.nasabahStats[name].totalUpdates);

        this.charts.nasabahChart.data.labels = nasabahNames;
        this.charts.nasabahChart.data.datasets[0].data = updateCounts;
        this.charts.nasabahChart.update();
    }

    // Update grafik time series
    updateTimeSeriesChart() {
        if (!this.charts.timeSeriesChart) return;

        // Group data by nasabah
        const nasabahGroups = {};
        this.chartData.timeSeriesData.forEach(item => {
            if (!nasabahGroups[item.nasabah]) {
                nasabahGroups[item.nasabah] = [];
            }
            nasabahGroups[item.nasabah].push({
                x: item.date,
                y: this.getStatusValue(item.status)
            });
        });

        // Create datasets for each nasabah
        const datasets = Object.keys(nasabahGroups).map((nasabah, index) => ({
            label: nasabah,
            data: nasabahGroups[nasabah],
            borderColor: this.getColor(index),
            backgroundColor: this.getColor(index, 0.1),
            tension: 0.1
        }));

        this.charts.timeSeriesChart.data.datasets = datasets;
        this.charts.timeSeriesChart.update();
    }

    // Convert status ke nilai numerik untuk grafik
    getStatusValue(status) {
        if (status.includes('PENUH')) return 3;
        if (status.includes('HAMPIR PENUH')) return 2;
        return 1;
    }

    // Get color untuk grafik
    getColor(index, alpha = 1) {
        const colors = [
            `rgba(255, 107, 107, ${alpha})`,   // Merah
            `rgba(255, 167, 38, ${alpha})`,    // Orange
            `rgba(102, 187, 106, ${alpha})`,   // Hijau
            `rgba(66, 165, 245, ${alpha})`,    // Biru
            `rgba(156, 39, 176, ${alpha})`,    // Ungu
            `rgba(255, 193, 7, ${alpha})`      // Kuning
        ];
        return colors[index % colors.length];
    }

    // Export data untuk download
    exportData() {
        const dataStr = JSON.stringify(this.chartData, null, 2);
        const dataBlob = new Blob([dataStr], {type: 'application/json'});
        const url = URL.createObjectURL(dataBlob);
        
        const link = document.createElement('a');
        link.href = url;
        link.download = 'bank-sampah-data.json';
        link.click();
        
        URL.revokeObjectURL(url);
    }

    // Cleanup
    destroy() {
        Object.values(this.charts).forEach(chart => {
            if (chart && chart.destroy) {
                chart.destroy();
            }
        });
        this.charts = {};
    }
}

// Initialize ketika DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan Chart.js sudah dimuat
    if (typeof Chart !== 'undefined') {
        window.firebaseCharts = new FirebaseCharts();
    } else {
        console.warn('Chart.js not loaded. Charts will not be available.');
    }
});

export default FirebaseCharts;

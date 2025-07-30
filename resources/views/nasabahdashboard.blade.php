<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Nasabah - Bijak Sampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f8f9fc;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar dari kode pertama (disesuaikan) */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            color: white;
            padding: 20px 0;
            min-height: 100vh;
            transition: width 0.3s;
            position: fixed;
            left: 0;
            top: 0;
            overflow: hidden;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .logo-container {
            padding: 0 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            height: 60px;
            justify-content: space-between;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }

        .logo span {
            color: #4ADE80;
        }

        .toggle-collapse {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
        }

        .menu-items {
            list-style: none;
        }

        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #f16728;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-text {
            font-size: 15px;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        .sidebar.collapsed .logo-icon {
            font-size: 22px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 30px;
            transition: margin-left 0.3s, width 0.3s;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #0A3A60;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            position: relative;
            transition: all 0.3s;
        }

        .profile-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .profile-icon.notif::after {
            content: '';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 8px;
            height: 8px;
            background: #FF5A5F;
            border-radius: 50%;
            border: 2px solid white;
        }

        .profile-icon i {
            color: #05445E;
            font-size: 18px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #05445E;
            cursor: pointer;
            transition: all 0.3s;
        }

        .avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
        }

        /* Notifikasi Cards - Diperbagus */
        .notif-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #75E6DA, #05445E);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card h4 {
            color: #0a3a60;
            font-weight: 600;
            font-size: 17px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h4 i {
            color: #05445E;
            font-size: 20px;
        }

        .card p {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #777;
        }

        .card-actions {
            display: flex;
            gap: 10px;
        }

        .card-btn {
            background: none;
            border: none;
            color: #05445E;
            cursor: pointer;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .card-btn:hover {
            background: rgba(5, 68, 94, 0.1);
        }

        .card-btn.delete:hover {
            color: #FF5A5F;
        }

        /* Grafik dengan Animasi */
        .chart-section {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .chart-title {
            color: #0a3a60;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chart-title i {
            color: #05445E;
            font-size: 24px;
        }

        .chart-sub {
            font-size: 15px;
            color: #777;
            margin-bottom: 30px;
        }
        
        .chart-content {
            display: flex;
            align-items: flex-end;
            justify-content: space-around;
            position: relative;
            height: 220px;
            padding-top: 40px;
            padding-bottom: 30px;
        }

        .chart-content::before {
            content: '';
            position: absolute;
            bottom: 30px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #eee;
        }

        .chart-bar-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
            position: relative;
            height: var(--height); /* Tinggi item akan disesuaikan dengan data */
            transition: height 0.3s ease;
        }

        .bar {
            width: 100%;
            max-width: 50px;
            background: linear-gradient(to top, #05445E, #189AB4); /* Warna default untuk semua bar */
            border-radius: 8px 8px 0 0;
            position: relative;
            height: 100%; /* Batang akan mengisi penuh tingginya */
            transform: scaleY(0); /* Mulai dari nol */
            transform-origin: bottom;
            animation: grow-scale 1.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.2s);
        }

        @keyframes grow-scale {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        /* .bar.green tidak diperlukan lagi jika semua bar berwarna sama,
           tapi tetap bisa dipertahankan untuk fleksibilitas jika suatu saat
           ada bar dengan warna berbeda. */
        /* .bar.green {
            background: linear-gradient(to top, #05445E, #189AB4);
        } */

        .bar-label {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 13px;
            font-weight: 600;
            background: white;
            padding: 6px 12px;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            white-space: nowrap;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
            animation-delay: calc(var(--order) * 0.2s + 1s);
            color: #05445E; /* Warna label agar terlihat di atas bar */
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-50%) translateY(10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        
        .day {
            position: absolute;
            bottom: -40px; /* Nilai negatif untuk memposisikan lebih ke bawah dari batas parent */
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #555; /* Warna teks yang sedikit lebih gelap untuk kontras */
        }

        /* Modal untuk CRUD */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 22px;
            color: #05445E;
            font-weight: 700;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #777;
            transition: all 0.2s;
        }

        .close-modal:hover {
            color: #05445E;
            transform: rotate(90deg);
        }

        .modal-body {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input, 
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: #75E6DA;
            outline: none;
            box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .btn-outline {
            background: white;
            border: 1px solid #ddd;
            color: #555;
        }

        .btn-outline:hover {
            background: #f5f5f5;
        }

        .btn-danger {
            background: #FF5A5F;
            color: white;
        }

        .btn-danger:hover {
            background: #e04a50;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 90, 95, 0.3);
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 14px;
            color: #666;
        }

        .footer strong {
            font-weight: 700;
            color: #05445E;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .notif-cards {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar .menu-text,
            .sidebar .logo-text {
                display: none;
            }
            
            .sidebar .logo-icon {
                font-size: 22px;
            }
            
            .main-content {
                margin-left: 80px;
                width: calc(100% - 80px);
                padding: 20px;
            }

            .notif-cards {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .profile-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <div class="logo">
                <span class="logo-icon"><i class="fas fa-recycle"></i></span>
                <span class="logo-text">Bijak<span>Sampah</span></span>
            </div>
            <button class="toggle-collapse" id="toggleCollapse">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <ul class="menu-items">
            <li class="menu-item active">
                <div class="menu-icon"><i class="fas fa-home"></i></div>
                <span class="menu-text">Dashboard</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-users"></i></div>
                <span class="menu-text">Komunitas</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-trash-alt"></i></div>
                <span class="menu-text">Riwayat Sampah</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-coins"></i></div>
                <span class="menu-text">Poin Mu</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-history"></i></div>
                <span class="menu-text">Riwayat Transaksi</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-store"></i></div>
                <span class="menu-text">Marketplace</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-cog"></i></div>
                <span class="menu-text">Settings</span>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
                <span class="menu-text">Logout</span>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1 class="page-title"><i class="fas fa-bell"></i> Notifikasi</h1>
            <div class="profile-actions">
                <div class="profile-icon notif" id="notifBtn" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="profile-icon" id="searchBtn" title="Cari">
                    <i class="fas fa-search"></i>
                </div>
                <img class="avatar" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" id="profileBtn">
            </div>
        </div>

        <div class="notif-cards" id="notifContainer">
            </div>

        <div class="chart-section">
            <div class="chart-title">
                <i class="fas fa-chart-line"></i> Data Partisipasi Anda
            </div>
            <div class="chart-sub">Minggu Lalu</div>

            <div class="chart-content" id="chart-content">
                </div>
        </div>

        <div class="footer">
            Created by <strong>TEK(G)</strong> | All Right Reserved!
        </div>
    </div>

    <div class="modal" id="notifModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Kelola Notifikasi</h3>
                <button class="close-modal" id="closeNotifModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="notifInput">Tambah Notifikasi Baru</label>
                    <input type="text" id="notifInput" placeholder="Masukkan pesan notifikasi">
                </div>
                <div id="notifList">
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelNotif">Batal</button>
                <button class="btn btn-primary" id="saveNotif">Simpan</button>
            </div>
        </div>
    </div>

    <div class="modal" id="searchModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cari</h3>
                <button class="close-modal" id="closeSearchModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="searchInput" placeholder="Masukkan kata kunci...">
                </div>
                <div id="searchResults">
                    </div>
            </div>
        </div>
    </div>

    <div class="modal" id="profileModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Profil Saya</h3>
                <button class="close-modal" id="closeProfileModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group" style="text-align: center;">
                    <img id="profileImage" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #05445E; margin-bottom: 15px; cursor: pointer;">
                    <input type="file" id="profileUpload" accept="image/*" style="display: none;">
                    <button class="btn btn-outline" id="changeProfileBtn" style="margin-top: 10px;">Ganti Foto Profil</button>
                </div>
                <div class="form-group">
                    <label for="profileName">Nama Lengkap</label>
                    <input type="text" id="profileName" value="Nasabah Bijak Sampah">
                </div>
                <div class="form-group">
                    <label for="profileEmail">Email</label>
                    <input type="email" id="profileEmail" value="nasabah@bijaksampah.com">
                </div>
                <div class="form-group">
                    <label for="profilePhone">No. Telepon</label>
                    <input type="tel" id="profilePhone" value="+6281234567890">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelProfile">Batal</button>
                <button class="btn btn-primary" id="saveProfile">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <script>
        // Data Notifikasi
        let notifications = [
            { 
                id: 1,
                title: "Sampah Telah di Ambil",
                icon: "fas fa-trash-restore",
                message: "Sampah Anda telah diambil oleh petugas bank sampah. Terima kasih atas partisipasinya!",
                date: "22 Juni 2025",
                time: "20:45"
            },
            { 
                id: 2,
                title: "Sampah akan di Ambil",
                icon: "fas fa-truck",
                message: "Petugas bank sampah akan menjemput sampah Anda hari ini. Mohon siapkan ya!",
                date: "23 Juni 2025",
                time: "14:14"
            },
            { 
                id: 3,
                title: "Sampah telah penuh",
                icon: "fas fa-exclamation-circle",
                message: "Tempat sampah Nasabah Rahimi telah penuh. Segera ambil sampah untuk penimbangan.",
                date: "23 Juni 2025",
                time: "16:14"
            }
        ];

        // Data untuk grafik
        // Semua 'isGreen' diatur menjadi 'true' agar semua batang grafik berwarna
        const chartData = [
            { height: 30, value: '30%', isGreen: true }, 
            { height: 75, value: '75%', isGreen: true }, 
            { height: 97, value: '97%', isGreen: true },
            { height: 65, value: '65%', isGreen: true }, 
            { height: 40, value: '40%', isGreen: true }, 
            { height: 68, value: '68%', isGreen: true }, 
            { height: 70, value: '70%', isGreen: true }  
        ];

        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const toggleCollapse = document.getElementById('toggleCollapse');
        const mainContent = document.querySelector('.main-content');
        const notifBtn = document.getElementById('notifBtn');
        const searchBtn = document.getElementById('searchBtn');
        const profileBtn = document.getElementById('profileBtn');
        const notifModal = document.getElementById('notifModal');
        const searchModal = document.getElementById('searchModal');
        const profileModal = document.getElementById('profileModal');
        const notifContainer = document.getElementById('notifContainer');
        const notifList = document.getElementById('notifList');
        const notifInput = document.getElementById('notifInput');
        const saveNotif = document.getElementById('saveNotif');
        const profileImage = document.getElementById('profileImage');
        const profileUpload = document.getElementById('profileUpload');
        const changeProfileBtn = document.getElementById('changeProfileBtn');
        const saveProfile = document.getElementById('saveProfile');
        const chartContent = document.getElementById('chart-content');

        // Toggle Sidebar
        toggleCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
            const icon = toggleCollapse.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        });

        // Load Notifications
        function loadNotifications() {
            notifContainer.innerHTML = '';
            notifications.forEach(notif => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <h4><i class="${notif.icon}"></i> ${notif.title}</h4>
                    <p>${notif.message}</p>
                    <div class="card-footer">
                        <span>${notif.date} • ${notif.time}</span>
                        <div class="card-actions">
                            <button class="card-btn delete" data-id="${notif.id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;
                notifContainer.appendChild(card);
            });

            // Add delete event listeners
            document.querySelectorAll('.card-btn.delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = parseInt(this.getAttribute('data-id'));
                    notifications = notifications.filter(n => n.id !== id);
                    loadNotifications();
                    loadNotifModal();
                });
            });
        }

        // Load Notifications in Modal
        function loadNotifModal() {
            notifList.innerHTML = '';
            notifications.forEach(notif => {
                const item = document.createElement('div');
                item.className = 'card';
                item.style.marginBottom = '10px';
                item.innerHTML = `
                    <h4 style="font-size: 16px;">${notif.title}</h4>
                    <p style="font-size: 14px;">${notif.message}</p>
                    <div class="card-footer" style="font-size: 12px;">
                        <span>${notif.date} • ${notif.time}</span>
                        <button class="card-btn delete" data-id="${notif.id}"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                notifList.appendChild(item);
            });
        }

        // Generate Chart
        function generateChart() {
            chartContent.innerHTML = '';
            const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const today = new Date();
            const currentDay = today.getDay(); // 0 (Minggu), 1 (Senin), ..., 6 (Sabtu)

            // Hitung tanggal Senin pada minggu ini
            // Jika hari ini Minggu (0), maka Senin minggu ini adalah 6 hari yang lalu
            // Jika hari ini Senin (1), maka Senin minggu ini adalah 0 hari yang lalu
            // dst.
            const daysSinceMonday = currentDay === 0 ? 6 : currentDay - 1;
            const thisMonday = new Date(today);
            thisMonday.setDate(today.getDate() - daysSinceMonday);

            // Hitung tanggal Senin pada MINGGU SEBELUMNYA
            const lastMonday = new Date(thisMonday);
            lastMonday.setDate(thisMonday.getDate() - 7);

            // Generate tanggal untuk 7 hari dari Senin hingga Minggu pada MINGGU LALU
            for (let i = 0; i < 7; i++) {
                const date = new Date(lastMonday);
                date.setDate(lastMonday.getDate() + i);

                const dayOfWeek = dayNames[date.getDay()];
                const dayOfMonth = date.getDate();
                const month = monthNames[date.getMonth()];
                const year = date.getFullYear();

                const data = chartData[i];
                const chartBarItem = document.createElement('div');
                chartBarItem.className = 'chart-bar-item';
                chartBarItem.style.setProperty('--height', `${data.height}%`); // Set tinggi item
                chartBarItem.innerHTML = `
                    <div class="bar" style="--order: ${i + 1};">
                        <span class="bar-label">${data.value}</span>
                    </div>
                    <div class="day">${dayOfWeek}<br/>${dayOfMonth} ${month} ${year}</div>
                `;
                chartContent.appendChild(chartBarItem);
            }
        }

        // Modal Toggles
        notifBtn.addEventListener('click', function() {
            loadNotifModal();
            notifModal.style.display = 'flex';
        });

        searchBtn.addEventListener('click', function() {
            searchModal.style.display = 'flex';
        });

        profileBtn.addEventListener('click', function() {
            profileModal.style.display = 'flex';
        });

        // Close Modals
        document.getElementById('closeNotifModal').addEventListener('click', function() {
            notifModal.style.display = 'none';
        });

        document.getElementById('closeSearchModal').addEventListener('click', function() {
            searchModal.style.display = 'none';
        });

        document.getElementById('closeProfileModal').addEventListener('click', function() {
            profileModal.style.display = 'none';
        });

        document.getElementById('cancelNotif').addEventListener('click', function() {
            notifModal.style.display = 'none';
        });

        document.getElementById('cancelProfile').addEventListener('click', function() {
            profileModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === notifModal) {
                notifModal.style.display = 'none';
            }
            if (event.target === searchModal) {
                searchModal.style.display = 'none';
            }
            if (event.target === profileModal) {
                profileModal.style.display = 'none';
            }
        });

        // Add New Notification
        saveNotif.addEventListener('click', function() {
            if (notifInput.value.trim()) {
                const newId = notifications.length > 0 ? Math.max(...notifications.map(n => n.id)) + 1 : 1;
                const now = new Date();
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const date = now.toLocaleDateString('id-ID', options);
                const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                notifications.unshift({
                    id: newId,
                    title: "Notifikasi Baru",
                    icon: "fas fa-info-circle",
                    message: notifInput.value.trim(),
                    date: date,
                    time: time
                });
                
                notifInput.value = '';
                loadNotifications();
                loadNotifModal();
            }
        });

        // Change Profile Image
        changeProfileBtn.addEventListener('click', function() {
            profileUpload.click();
        });

        profileUpload.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImage.src = event.target.result;
                    profileBtn.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Save Profile Changes
        saveProfile.addEventListener('click', function() {
            // In a real app, you would save to database here
            alert('Perubahan profil berhasil disimpan!');
            profileModal.style.display = 'none';
        });

        // Initialize
        loadNotifications();
        generateChart();
    </script>
</body>
</html>
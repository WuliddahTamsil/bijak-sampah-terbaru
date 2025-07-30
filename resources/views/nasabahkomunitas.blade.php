<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Komunitas - Bijak Sampah</title>
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

    /* Top Bar */
    .top-bar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
      color: white;
      display: flex;
      align-items: center;
      padding: 0 20px;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .top-bar-title {
      font-size: 18px;
      font-weight: 600;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
      color: white;
      padding: 20px 0;
      min-height: 100vh;
      position: fixed;
      left: 0;
      top: 60px;
      overflow-y: auto;
      transition: transform 0.3s ease;
      z-index: 90;
    }

    .sidebar.collapsed {
      transform: translateX(-250px);
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
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      margin-top: 60px;
      width: calc(100% - 250px);
      padding: 30px;
      transition: margin-left 0.3s;
      background: linear-gradient(180deg, #05445E 0%, #75E6DA 100%);
      min-height: calc(100vh - 60px);
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: 0;
      width: 100%;
    }

    /* Komunitas Content */
    .komunitas-container {
      display: flex;
      gap: 30px;
    }

    /* Left Panel */
    .left-panel {
      width: 300px;
    }

    .new-message-btn {
      width: 100%;
      background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
      color: white;
      font-weight: 600;
      padding: 12px;
      border: none;
      border-radius: 8px 8px 0 0;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .new-message-btn:hover {
      background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 70%);
      transform: translateY(-2px);
    }

    .reply-message-btn {
      width: 100%;
      background: #fef3c7;
      color: #92400e;
      font-weight: 600;
      padding: 12px;
      border: none;
      border-radius: 0 0 8px 8px;
      cursor: pointer;
      transition: all 0.3s;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .reply-message-btn:hover {
      background: #fde68a;
    }

    .profile-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #75E6DA;
      margin-bottom: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .profile-name {
      font-size: 18px;
      font-weight: 700;
      color: #05445E;
      margin-bottom: 5px;
    }

    .profile-stats {
      color: #3b82f6;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .info-card {
      background: white;
      border-radius: 12px;
      padding: 16px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .info-card-title {
      font-size: 16px;
      font-weight: 700;
      color: #05445E;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .info-list {
      list-style: none;
    }

    .info-list li {
      margin-bottom: 8px;
    }

    .info-list a {
      color: #3b82f6;
      text-decoration: underline;
      font-size: 14px;
      transition: color 0.3s;
    }

    .info-list a:hover {
      color: #1d4ed8;
    }

    /* Right Panel - Diskusi */
    .right-panel {
      flex: 1;
    }

    .filter-tags {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .filter-tag {
      background: #bfdbfe;
      color: #1e40af;
      font-size: 12px;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .filter-tag:hover {
      background: #93c5fd;
    }

    .filter-tag.active {
      background: #3b82f6;
      color: white;
    }

    .diskusi-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      transition: all 0.3s;
    }

    .diskusi-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px rgba(0,0,0,0.1);
    }

    .diskusi-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .diskusi-author {
      font-weight: 600;
      color: #05445E;
    }

    .diskusi-time {
      color: #9ca3af;
      font-size: 12px;
      margin-left: 8px;
    }

    .diskusi-menu {
      color: #9ca3af;
      cursor: pointer;
      padding: 5px;
    }

    .diskusi-title {
      font-size: 18px;
      font-weight: 700;
      color: #111827;
      margin-bottom: 8px;
    }

    .diskusi-content {
      color: #4b5563;
      font-size: 14px;
      margin-bottom: 12px;
    }

    .diskusi-tags {
      display: flex;
      gap: 8px;
      margin-bottom: 12px;
      flex-wrap: wrap;
    }

    .diskusi-tag {
      background: #f3f4f6;
      color: #374151;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 20px;
    }

    .diskusi-stats {
      display: flex;
      gap: 20px;
      color: #9ca3af;
      font-size: 12px;
    }

    .diskusi-stat {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* Right Panel - Form Pesan Baru */
    .form-panel {
      flex: 1;
      display: none;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      padding: 40px;
      max-width: 800px;
      margin: 0 auto;
    }

    .form-title {
      font-size: 32px;
      font-weight: 800;
      color: white;
      margin-bottom: 8px;
    }

    .form-subtitle {
      font-size: 24px;
      font-weight: 700;
      color: white;
      margin-bottom: 30px;
    }

    .form-subtitle span {
      color: #bef264;
    }

    .interest-label {
      color: white;
      margin-bottom: 12px;
      font-weight: 500;
    }

    .interest-tags {
      display: flex;
      gap: 12px;
      margin-bottom: 30px;
      flex-wrap: wrap;
    }

    .interest-tag {
      background: #0891b2;
      color: white;
      padding: 8px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      border: none;
    }

    .interest-tag.outline {
      background: transparent;
      border: 1px solid white;
      color: white;
    }

    .interest-tag:hover {
      background: #0e7490;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      color: white;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .form-input {
      width: 100%;
      background: transparent;
      border: none;
      border-bottom: 2px solid white;
      color: white;
      padding: 10px 0;
      font-size: 16px;
      transition: all 0.3s;
    }

    .form-input:focus {
      outline: none;
      border-bottom-color: #75E6DA;
    }

    .form-input::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .submit-btn {
      background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
      color: white;
      font-weight: 600;
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin: 40px auto 0;
    }

    .submit-btn:hover {
      background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .komunitas-container {
        flex-direction: column;
      }
      
      .left-panel {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-250px);
      }
      
      .sidebar.collapsed {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
        width: 100%;
      }
      
      .form-container {
        padding: 30px 20px;
      }
      
      .form-title {
        font-size: 28px;
      }
      
      .form-subtitle {
        font-size: 20px;
      }
    }

    @media (max-width: 480px) {
      .interest-tags {
        gap: 8px;
      }
      
      .interest-tag {
        padding: 6px 12px;
        font-size: 14px;
      }
      
      .form-title {
        font-size: 24px;
      }
      
      .form-subtitle {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>

  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-bar-title">Komunitas</div>
  </div>

  <!-- Sidebar -->
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
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-home"></i></div>
        <span class="menu-text">Dashboard</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-bell"></i></div>
        <span class="menu-text">Notifikasi</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-store"></i></div>
        <span class="menu-text">Marketplace</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-users"></i></div>
        <span class="menu-text">Komunitas</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-balance-scale"></i></div>
        <span class="menu-text">Bank Sampah</span>
      </li>
      <li class="menu-item active">
        <div class="menu-icon"><i class="fas fa-comments"></i></div>
        <span class="menu-text">Forum Diskusi</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-info-circle"></i></div>
        <span class="menu-text">Informasi</span>
      </li>
      <li class="menu-item">
        <div class="menu-icon"><i class="fas fa-cog"></i></div>
        <span class="menu-text">Pengaturan</span>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="komunitas-container">
      <!-- Left Panel -->
      <div class="left-panel">
        <button class="new-message-btn" id="newMessageBtn">
          <i class="fas fa-plus"></i> Pesan Baru
        </button>
        <button class="reply-message-btn" id="replyMessageBtn">
          <i class="fas fa-reply"></i> Balas Pesan Lainnya
        </button>
        
        <div class="profile-card">
          <img src="https://randomuser.me/api/portraits/women/44.jpg" class="profile-img" alt="Profile">
          <div class="profile-name">@Putri</div>
          <div class="profile-stats">
            <i class="fas fa-users"></i> 125 [ 8 ]
          </div>
        </div>
        
        <div class="info-card">
          <div class="info-card-title">
            <i class="fas fa-star"></i> Diskusi Wajib Dibaca
          </div>
          <ul class="info-list">
            <li><a href="#">Panduan Forum: Aturan & Etika Diskusi Komunitas</a></li>
            <li><a href="#">Visi & Misi Bijak Sampah</a></li>
          </ul>
        </div>
        
        <div class="info-card">
          <div class="info-card-title">
            <i class="fas fa-link"></i> Tautan Bermanfaat
          </div>
          <ul class="info-list">
            <li><a href="#">Tips Digital Marketing</a></li>
            <li><a href="#">UMKM Daur Ulang Berbasis IoT</a></li>
            <li><a href="#">Panduan Ekspor</a></li>
          </ul>
        </div>
      </div>
      
      <!-- Right Panel - Diskusi -->
      <div class="right-panel" id="diskusiPanel">
        <div class="filter-tags">
          <div class="filter-tag active">New</div>
          <div class="filter-tag">Top</div>
          <div class="filter-tag">Hot</div>
          <div class="filter-tag">Closed</div>
        </div>
        
        <div class="diskusi-card">
          <div class="diskusi-header">
            <div>
              <span class="diskusi-author">Aisyah</span>
              <span class="diskusi-time">5 min ago</span>
            </div>
            <div class="diskusi-menu">
              <i class="fas fa-ellipsis-v"></i>
            </div>
          </div>
          <div class="diskusi-title">Bagaimana cara memasarkan produk UMKM daur ulang secara digital?</div>
          <div class="diskusi-content">Mohon saran strategi pemasaran digital yang cocok untuk skala kecil menengah.</div>
          <div class="diskusi-tags">
            <div class="diskusi-tag">UMKM</div>
            <div class="diskusi-tag">DAUR ULANG</div>
          </div>
          <div class="diskusi-stats">
            <div class="diskusi-stat">
              <i class="fas fa-eye"></i> 125
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-comment"></i> 15
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-heart"></i> 155
            </div>
          </div>
        </div>
        
        <div class="diskusi-card">
          <div class="diskusi-header">
            <div>
              <span class="diskusi-author">Ghina</span>
              <span class="diskusi-time">25 min ago</span>
            </div>
            <div class="diskusi-menu">
              <i class="fas fa-ellipsis-v"></i>
            </div>
          </div>
          <div class="diskusi-title">Apa perbedaan sistem IoT untuk monitoring sampah rumah tangga dan industri?</div>
          <div class="diskusi-content">Apakah ada referensi atau studi kasus yang bisa saya pelajari?</div>
          <div class="diskusi-tags">
            <div class="diskusi-tag">UMKM</div>
            <div class="diskusi-tag">IoT</div>
          </div>
          <div class="diskusi-stats">
            <div class="diskusi-stat">
              <i class="fas fa-eye"></i> 125
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-comment"></i> 15
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-heart"></i> 155
            </div>
          </div>
        </div>
        
        <div class="diskusi-card">
          <div class="diskusi-header">
            <div>
              <span class="diskusi-author">Wuwu</span>
              <span class="diskusi-time">2 days ago</span>
            </div>
            <div class="diskusi-menu">
              <i class="fas fa-ellipsis-v"></i>
            </div>
          </div>
          <div class="diskusi-title">Saya ingin belajar IoT untuk mendukung produk UMKM. Harus mulai dari mana?</div>
          <div class="diskusi-content">Adakah sumber belajar yang mudah dipahami?</div>
          <div class="diskusi-tags">
            <div class="diskusi-tag">IT</div>
            <div class="diskusi-tag">SENSOR</div>
          </div>
          <div class="diskusi-stats">
            <div class="diskusi-stat">
              <i class="fas fa-eye"></i> 125
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-comment"></i> 15
            </div>
            <div class="diskusi-stat">
              <i class="fas fa-heart"></i> 155
            </div>
          </div>
        </div>
      </div>
      
      <!-- Right Panel - Form Pesan Baru -->
      <div class="form-panel" id="formPanel">
        <div class="form-container">
          <h2 class="form-title">Let's discuss</h2>
          <h3 class="form-subtitle">on something <span>cool</span> together</h3>
          
          <div class="mb-6">
            <div class="interest-label">Saya tertarik tentang....</div>
            <div class="interest-tags">
              <button class="interest-tag">Marketing</button>
              <button class="interest-tag outline">Daur Ulang</button>
              <button class="interest-tag outline">IoT</button>
              <button class="interest-tag outline">Sistem</button>
              <button class="interest-tag outline">lainnya</button>
            </div>
          </div>
          
          <form id="messageForm" class="space-y-6 mt-8">
            <div class="form-group">
              <label class="form-label">Nama Anda</label>
              <input type="text" class="form-input" placeholder="Nama Anda" required>
            </div>
            <div class="form-group">
              <label class="form-label">Email Anda</label>
              <input type="email" class="form-input" placeholder="Email Anda" required>
            </div>
            <div class="form-group">
              <label class="form-label">Pesan Anda</label>
              <textarea class="form-input" rows="3" placeholder="Pesan Anda..." required></textarea>
            </div>
            <button type="submit" class="submit-btn">
              <i class="fas fa-paper-plane"></i> Kirim Pesan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle sidebar
    const sidebar = document.getElementById('sidebar');
    const toggleCollapse = document.getElementById('toggleCollapse');
    
    toggleCollapse.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
      const icon = toggleCollapse.querySelector('i');
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
      } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
      }
    });

    // Toggle between diskusi and form panels
    const newMessageBtn = document.getElementById('newMessageBtn');
    const replyMessageBtn = document.getElementById('replyMessageBtn');
    const diskusiPanel = document.getElementById('diskusiPanel');
    const formPanel = document.getElementById('formPanel');
    
    newMessageBtn.addEventListener('click', function() {
      diskusiPanel.style.display = 'none';
      formPanel.style.display = 'block';
    });
    
    replyMessageBtn.addEventListener('click', function() {
      diskusiPanel.style.display = 'block';
      formPanel.style.display = 'none';
    });

    // Filter tags
    const filterTags = document.querySelectorAll('.filter-tag');
    filterTags.forEach(tag => {
      tag.addEventListener('click', function() {
        filterTags.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Interest tags
    const interestTags = document.querySelectorAll('.interest-tag');
    interestTags.forEach(tag => {
      tag.addEventListener('click', function() {
        interestTags.forEach(t => {
          t.classList.remove('outline');
          t.style.backgroundColor = '#0891b2';
        });
        this.classList.add('outline');
        this.style.backgroundColor = '#0e7490';
      });
    });

    // Form submission
    const messageForm = document.getElementById('messageForm');
    messageForm.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Pesan Anda telah berhasil dikirim!');
      diskusiPanel.style.display = 'block';
      formPanel.style.display = 'none';
      this.reset();
    });

    // Responsive sidebar toggle for mobile
    function checkScreenSize() {
      if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
      } else {
        sidebar.classList.remove('collapsed');
      }
    }
    
    window.addEventListener('resize', checkScreenSize);
    checkScreenSize();
  </script>
</body>
</html>
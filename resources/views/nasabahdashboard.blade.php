<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Nasabah - Bisak Sampah</title>
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

    /* Improved Sidebar */
    .sidebar {
      width: 280px;
      background: linear-gradient(180deg, #05445E 0%, #189AB4 100%);
      color: white;
      min-height: 100vh;
      padding: 30px 0;
      display: flex;
      flex-direction: column;
      position: fixed;
      box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
      z-index: 100;
    }

    .sidebar-header {
      padding: 0 25px 30px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar h2 {
      font-size: 24px;
      font-weight: 700;
      color: white;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .sidebar h2 span {
      color: #75E6DA;
      font-weight: 800;
    }

    .sidebar h2 i {
      color: #75E6DA;
      font-size: 22px;
    }

    .sidebar ul {
      list-style: none;
      padding: 20px 0;
      flex-grow: 1;
    }

    .sidebar li {
      display: flex;
      align-items: center;
      padding: 14px 25px;
      margin: 5px 0;
      border-radius: 8px;
      transition: all 0.3s ease;
      cursor: pointer;
      font-weight: 500;
    }

    .sidebar li:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .sidebar li.active {
      background: white;
      color: #05445E;
      font-weight: 600;
    }

    .sidebar li i {
      width: 24px;
      margin-right: 12px;
      font-size: 18px;
      text-align: center;
    }

    .sidebar-footer {
      padding: 20px 25px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout {
      display: flex;
      align-items: center;
      padding: 12px 16px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      transition: all 0.3s;
      cursor: pointer;
      font-weight: 500;
    }

    .logout:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    .logout i {
      margin-right: 10px;
      font-size: 18px;
    }

    /* Main Content */
    .main {
      flex: 1;
      padding: 40px 40px 40px 320px;
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      font-size: 28px;
      color: #0a3a60;
      font-weight: 700;
    }

    .profile {
      display: flex;
      align-items: center;
      gap: 20px;
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
    }

    .profile-icon i {
      color: #05445E;
      font-size: 18px;
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

    .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #05445E;
      cursor: pointer;
    }

    /* Notifikasi Cards */
    .notif-cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .card h4 {
      color: #0a3a60;
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .card h4 i {
      color: #05445E;
    }

    .card p {
      font-size: 14px;
      color: #555;
      margin-bottom: 15px;
      line-height: 1.5;
    }

    .card-footer {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      color: #777;
    }

    /* Chart */
    .chart-section {
      background: white;
      padding: 25px 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }

    .chart-title {
      color: #0a3a60;
      font-weight: 700;
      font-size: 20px;
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .chart-title i {
      color: #05445E;
    }

    .chart-sub {
      font-size: 14px;
      color: #777;
      margin-bottom: 25px;
    }

    .bars {
      display: flex;
      align-items: flex-end;
      gap: 24px;
      height: 200px;
      padding-top: 30px;
    }

    .bar {
      flex: 1;
      max-width: 50px;
      background-color: #E3E9EF;
      border-radius: 8px;
      position: relative;
      transition: height 0.5s ease;
    }

    .bar.green {
      background: linear-gradient(to top, #75E6DA, #189AB4);
    }

    .bar span {
      position: absolute;
      top: -30px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 12px;
      font-weight: 600;
      background: white;
      padding: 4px 8px;
      border-radius: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      white-space: nowrap;
    }

    .bar.green span {
      color: #05445E;
    }

    .days {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
      padding: 0 10px;
    }

    .day {
      font-size: 12px;
      color: #777;
      width: 36px;
      text-align: center;
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
      .sidebar {
        width: 240px;
      }
      .main {
        padding-left: 260px;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        overflow: hidden;
      }
      .sidebar h2 span, 
      .sidebar li span {
        display: none;
      }
      .sidebar li {
        justify-content: center;
        padding: 14px 0;
      }
      .sidebar li i {
        margin-right: 0;
        font-size: 20px;
      }
      .logout span {
        display: none;
      }
      .main {
        padding-left: 90px;
      }
    }
  </style>
</head>
<body>

  <!-- Improved Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <h2><i class="fas fa-recycle"></i> <span>Bisak Sampah</span></h2>
    </div>
    
    <ul>
      <li class="active">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </li>
      <li>
        <i class="fas fa-users"></i>
        <span>Komunitas</span>
      </li>
      <li>
        <i class="fas fa-trash-alt"></i>
        <span>Penjemputan Sampah</span>
      </li>
      <li>
        <i class="fas fa-coins"></i>
        <span>Poin Mu</span>
      </li>
      <li>
        <i class="fas fa-history"></i>
        <span>Riwayat Sampah</span>
      </li>
      <li>
        <i class="fas fa-store"></i>
        <span>Marketplace</span>
      </li>
      <li>
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </li>
    </ul>
    
    <div class="sidebar-footer">
      <div class="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="header">
      <h1><i class="fas fa-bell"></i> Notifikasi</h1>
      <div class="profile">
        <div class="profile-icon notif">
          <i class="fas fa-bell"></i>
        </div>
        <div class="profile-icon">
          <i class="fas fa-search"></i>
        </div>
        <img class="avatar" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile">
      </div>
    </div>

    <!-- Notifikasi -->
    <div class="notif-cards">
      <div class="card">
        <h4><i class="fas fa-trash-restore"></i> Sampah Telah di Ambil</h4>
        <p>Sampah Anda telah diambil oleh petugas bank sampah. Terima kasih atas partisipasinya!</p>
        <div class="card-footer">
          <span>22 Juni 2025</span>
          <span>20:45</span>
        </div>
      </div>

      <div class="card">
        <h4><i class="fas fa-truck"></i> Sampah akan di Ambil</h4>
        <p>Petugas bank sampah akan menjemput sampah Anda hari ini. Mohon siapkan ya!</p>
        <div class="card-footer">
          <span>23 Juni 2025</span>
          <span>14:14</span>
        </div>
      </div>

      <div class="card">
        <h4><i class="fas fa-exclamation-circle"></i> Sampah telah penuh</h4>
        <p>Tempat sampah Nasabah Rahimi telah penuh. Segera ambil sampah untuk penimbangan.</p>
        <div class="card-footer">
          <span>23 Juni 2025</span>
          <span>16:14</span>
        </div>
      </div>
    </div>

    <!-- Grafik Partisipasi -->
    <div class="chart-section">
      <div class="chart-title">
        <i class="fas fa-chart-line"></i> Data Partisipasi Anda
      </div>
      <div class="chart-sub">Minggu Lalu</div>

      <div class="bars">
        <div class="bar" style="height: 30%;"></div>
        <div class="bar" style="height: 75%;"></div>
        <div class="bar green" style="height: 97%;"><span>97%</span></div>
        <div class="bar" style="height: 65%;"></div>
        <div class="bar" style="height: 40%;"></div>
        <div class="bar" style="height: 68%;"></div>
        <div class="bar" style="height: 70%;"></div>
      </div>
      
      <div class="days">
        <div class="day">Sen</div>
        <div class="day">Sel</div>
        <div class="day">Rab</div>
        <div class="day">Kam</div>
        <div class="day">Jum</div>
        <div class="day">Sab</div>
        <div class="day">Min</div>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      Created by <strong>TEK(G)</strong> | All Right Reserved!
    </div>
  </div>
</body>
</html>
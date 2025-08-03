<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Verifikasi Nasabah - Bijak Sampah</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #05445E;
      --secondary-color: #75E6DA;
      --accent-color: #f16728;
      --success-color: #2b8a3e;
      --danger-color: #c0392b;
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }
    
    body {
      background: #f8f9fc;
      color: #333;
      min-height: 100vh;
      display: flex;
    }

    /* Sidebar dari kode pertama (disesuaikan) */
    .sidebar {
      width: 80px;
      background: linear-gradient(135deg, var(--secondary-color) 0%, var(--primary-color) 30%, var(--primary-color) 100%);
      color: white;
      padding: 20px 0;
      min-height: 100vh;
      transition: width 0.3s ease;
      position: fixed;
      left: 0;
      top: 0;
      overflow: hidden;
      box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      z-index: 1000;
    }

    .sidebar:hover {
      width: 250px;
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
      display: flex;
      align-items: center;
      gap: 10px;
      white-space: nowrap;
    }

    .logo img {
      width: 200px;
      height: 200px;
      object-fit: contain;
    }

    .logo-text {
      font-size: 18px;
      font-weight: bold;
      color: white;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover .logo-text {
      opacity: 1;
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
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .sidebar:hover .toggle-collapse {
      opacity: 1;
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
      border-left: 4px solid var(--accent-color);
    }

    .sub-menu-item {
      padding: 10px 20px 10px 50px;
      display: flex;
      align-items: center;
      cursor: pointer;
      transition: all 0.3s;
      white-space: nowrap;
      font-size: 14px;
      position: relative;
    }

    .sub-menu-item:hover {
      background: rgba(255, 255, 255, 0.1);
    }

    .sub-menu-item.active {
      background: rgba(255, 255, 255, 0.15);
      font-weight: 500;
    }

    .menu-icon {
      width: 24px;
      height: 24px;
      margin-right: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .menu-text {
      font-size: 15px;
      transition: opacity 0.3s ease;
      opacity: 0;
    }

    .sidebar:hover .menu-text {
      opacity: 1;
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

    .sidebar-footer {
      padding: 0;
      border-top: 1px solid rgba(255,255,255,0.1);
      margin-top: auto;
      flex-shrink: 0;
    }

    /* Main Content Styles */
    .main-content {
      margin-left: 80px;
      width: calc(100% - 80px);
      padding: 30px;
      transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .sidebar:hover ~ .main-content {
      margin-left: 250px;
      width: calc(100% - 250px);
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: 80px;
      width: calc(100% - 80px);
    }

    /* Header Styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: var(--primary-color);
      font-size: 28px;
    }

    /* Table Styles */
    .customers-container {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    .table-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .search-sort {
      display: flex;
      gap: 15px;
    }

    .search {
      position: relative;
    }

    .search input {
      padding: 10px 15px 10px 35px;
      border: 1px solid #ddd;
      border-radius: 8px;
      width: 250px;
    }

    .search i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    .sort select {
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 8px;
      background-color: #fff;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      font-weight: 600;
      color: var(--primary-color);
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    .btn-review {
      padding: 6px 12px;
      background-color: #fee2e2;
      color: #dc2626;
      border: none;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-review:hover {
      background-color: #fecaca;
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
      font-size: 14px;
      color: #666;
    }

    .pagination-controls {
      display: flex;
      gap: 8px;
    }

    .pagination-btn {
      padding: 6px 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .pagination-btn:hover {
      background-color: #f0f0f0;
    }

    .pagination-btn.active {
      background-color: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: white;
      width: 90%;
      max-width: 600px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      animation: modalFadeIn 0.3s;
    }

    @keyframes modalFadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .modal-header {
      padding: 15px 20px;
      background-color: var(--primary-color);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .modal-header h3 {
      font-size: 18px;
      font-weight: 600;
    }

    .modal-close {
      background: none;
      border: none;
      color: white;
      font-size: 20px;
      cursor: pointer;
    }

    .modal-body {
      padding: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #555;
    }

    .form-group input, .form-group select {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      background-color: #f9f9f9;
    }

    .modal-footer {
      padding: 15px 20px;
      background-color: #f5f5f5;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .btn {
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
      border: none;
    }

    .btn-primary:hover {
      background-color: #04384e;
    }

    .btn-secondary {
      background-color: #e5e7eb;
      color: #333;
      border: none;
    }

    .btn-secondary:hover {
      background-color: #d1d5db;
    }

    .btn-danger {
      background-color: var(--danger-color);
      color: white;
      border: none;
    }

    .btn-danger:hover {
      background-color: #a33226;
    }

    .btn-success {
      background-color: var(--success-color);
      color: white;
      border: none;
    }

    .btn-success:hover {
      background-color: #247532;
    }

    /* Step Indicator */
    .step-indicator {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .step {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #e5e7eb;
      color: #6b7280;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      margin: 0 10px;
      position: relative;
    }

    .step.active {
      background-color: var(--primary-color);
      color: white;
    }

    .step.completed {
      background-color: var(--success-color);
      color: white;
    }

    .step-line {
      flex: 1;
      height: 2px;
      background-color: #e5e7eb;
      margin: 0 -10px;
      position: relative;
      top: 15px;
    }

    .step-line.completed {
      background-color: var(--success-color);
    }

    /* Trash Bin Registration Form */
    .trash-bin-form {
      display: none;
    }

    /* Success Message */
    .success-message {
      display: none;
      text-align: center;
      padding: 40px;
    }

    .success-icon {
      font-size: 60px;
      color: var(--success-color);
      margin-bottom: 20px;
    }

    .success-title {
      font-size: 24px;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    .success-details {
      color: #555;
      margin-bottom: 20px;
    }

    .success-account {
      background-color: #f0f7ff;
      padding: 15px;
      border-radius: 8px;
      margin-top: 20px;
      text-align: left;
    }

    .success-account p {
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo-container">
      <div class="logo">
        <img src="{{ asset('asset/img/Logo Alternative_Dark (1).png') }}" alt="Bijak Sampah Logo">
      </div>
      <button class="toggle-collapse">
        <i class="fas fa-chevron-left"></i>
      </button>
    </div>
    
    <div class="menu-container">
      <ul class="menu-items">
        <li class="menu-item">
          <a href="{{ route('dashboard-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-home"></i></div>
            <span class="menu-text">Dashboard</span>
          </a>
        </li>
        <li class="menu-item active">
          <div class="menu-icon"><i class="fas fa-users"></i></div>
          <span class="menu-text">Nasabah</span>
        </li>
        <li class="sub-menu-item active">
          <a href="{{ route('verifikasi-nasabah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-user-check"></i></div>
            <span class="menu-text">Verifikasi Nasabah</span>
          </a>
        </li>
        <li class="sub-menu-item">
          <a href="{{ route('data-nasabah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-database"></i></div>
            <span class="menu-text">Data Nasabah</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('penjemputan-sampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-truck"></i></div>
            <span class="menu-text">Penjemputan Sampah</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('penimbangansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-weight-hanging"></i></div>
            <span class="menu-text">Penimbangan</span>
          </a>
        </li>
        <li class="sub-menu-item">
          <div class="menu-icon"><i class="fas fa-plus-circle"></i></div>
          <span class="menu-text">Input Setoran</span>
        </li>
        <li class="menu-item">
          <a href="{{ route('datasampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-trash-alt"></i></div>
            <span class="menu-text">Data Sampah</span>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('penjualansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-shopping-cart"></i></div>
            <span class="menu-text">Penjualan Sampah</span>
          </a>
        </li>
        <li class="menu-item">
          <div class="menu-icon"><i class="fas fa-cog"></i></div>
          <span class="menu-text">Setting</span>
        </li>
      </ul>
    </div>

    <div class="sidebar-footer">
      <div class="menu-item" id="logoutBtn">
        <div class="menu-icon"><i class="fas fa-sign-out-alt"></i></div>
        <span class="menu-text">Logout</span>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h1>Verifikasi Nasabah</h1>
      <div class="search-sort">
        <div class="search">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Cari nasabah...">
        </div>
        <div class="sort">
          <select>
            <option>Sort by: Terbaru</option>
            <option>Sort by: Terlama</option>
          </select>
        </div>
      </div>
    </div>

    <div class="customers-container">
      <table>
        <thead>
          <tr>
            <th>Nasabah</th>
            <th>Tanggal Pengajuan</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Jane Cooper</td>
            <td>12-05-2025</td>
            <td>jane@microsoft.com</td>
            <td><button class="btn-review" onclick="showVerificationModal('Jane Cooper', 'jane@microsoft.com', '+62 85752517237', 'Jl. Golf Perum Citra Sari', 'RT 33 RW 07', '25-10-1997', 'Perempuan', '6475299382400000', '6475299382400000', 'Kepala keluarga')">Tinjau</button></td>
          </tr>
          <tr>
            <td>Floyd Miles</td>
            <td>12-05-2025</td>
            <td>floyd@yahoo.com</td>
            <td><button class="btn-review" onclick="showVerificationModal('Floyd Miles', 'floyd@yahoo.com', '+62 8123456789', 'Jl. Merdeka No. 123', 'RT 01 RW 05', '15-08-1990', 'Laki-laki', '6475299382400001', '6475299382400001', 'Anggota keluarga')">Tinjau</button></td>
          </tr>
          <tr>
            <td>Ronald Richards</td>
            <td>12-05-2025</td>
            <td>ronald@adobe.com</td>
            <td><button class="btn-review" onclick="showVerificationModal('Ronald Richards', 'ronald@adobe.com', '+62 8234567890', 'Jl. Sudirman Kav. 1', 'RT 02 RW 03', '03-12-1985', 'Laki-laki', '6475299382400002', '6475299382400002', 'Kepala keluarga')">Tinjau</button></td>
          </tr>
          <tr>
            <td>Wuliddah Tamsil</td>
            <td>30-07-2025</td>
            <td>19tamsilwuliddah@apps.ipb.ac.id</td>
            <td><button class="btn-review" onclick="showVerificationModal('Wuliddah Tamsil', '19tamsilwuliddah@apps.ipb.ac.id', '85294939357', 'jln borobudur candi prambanan', 'RT 09 RW 03', '19-01-2005', 'Perempuan', '6475299382400003', '6475299382400003', 'Anak')">Tinjau</button></td>
          </tr>
          <tr>
            <td>Titing</td>
            <td>30-07-2025</td>
            <td>sentry3b2@gmail.com</td>
            <td><button class="btn-review" onclick="showVerificationModal('Titing', 'sentry3b2@gmail.com', '08123456789', 'Dusun Ciuyah RT/RW 09/03 Desa Ciniru', 'RT 09 RW 03', '05-05-1995', 'Perempuan', '6475299382400004', '6475299382400004', 'Istri')">Tinjau</button></td>
          </tr>
        </tbody>
      </table>

      <div class="pagination">
        <span>Showing data 1 to 5 of 8 entries</span>
        <div class="pagination-controls">
          <button class="pagination-btn">&lt;</button>
          <button class="pagination-btn active">1</button>
          <button class="pagination-btn">2</button>
          <button class="pagination-btn">&gt;</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Address Verification Modal -->
  <div class="modal" id="addressVerificationModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Verifikasi Data Alamat Nasabah</h3>
        <button class="modal-close" onclick="closeVerificationModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="step-indicator">
          <div class="step active">1</div>
          <div class="step-line"></div>
          <div class="step">2</div>
        </div>
        <form>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="modalEmail" disabled>
          </div>
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" id="modalName" disabled>
          </div>
          <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" id="modalPhone" disabled>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" id="modalAddress" disabled>
          </div>
          <div class="form-group">
            <label>RT/RW</label>
            <input type="text" id="modalRtRw" disabled>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeVerificationModal()">Tutup</button>
        <button class="btn btn-primary" onclick="showPersonalDataVerification()">Berikutnya</button>
      </div>
    </div>
  </div>

  <!-- Personal Data Verification Modal -->
  <div class="modal" id="personalDataVerificationModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Verifikasi Data Pribadi Nasabah</h3>
        <button class="modal-close" onclick="closeVerificationModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="step-indicator">
          <div class="step completed">1</div>
          <div class="step-line completed"></div>
          <div class="step active">2</div>
        </div>
        <form>
          <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="text" id="modalDob" disabled>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <select id="modalGender" disabled>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div class="form-group">
            <label>NIK</label>
            <input type="text" id="modalNik" disabled>
          </div>
          <div class="form-group">
            <label>No KK</label>
            <input type="text" id="modalKk" disabled>
          </div>
          <div class="form-group">
            <label>Posisi Dalam Keluarga</label>
            <input type="text" id="modalFamilyPosition" disabled>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="backToAddressVerification()">Kembali</button>
        <button class="btn btn-danger" onclick="rejectVerification()">Tolak</button>
        <button class="btn btn-success" onclick="acceptVerification()">Terima</button>
      </div>
    </div>
  </div>

  <!-- Trash Bin Registration Modal -->
  <div class="modal" id="trashBinRegistrationModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Pendaftaran Unit Bak Sampah</h3>
        <button class="modal-close" onclick="closeVerificationModal()">&times;</button>
      </div>
      <div class="modal-body">
        <form id="trashBinForm">
          <div class="form-group">
            <label for="jenisBak">Jenis Bak Sampah</label>
            <input type="text" id="jenisBak" placeholder="Masukkan jenis unit bak yang akan diserahkan" required>
          </div>
          <div class="form-group">
            <label for="noBak">No Bak Sampah</label>
            <input type="text" id="noBak" placeholder="Masukkan no bak sampah yang akan diserahkan" required>
          </div>
          <div class="form-group">
            <label for="idBak">ID Unit Bak Sampah</label>
            <input type="text" id="idBak" placeholder="Masukkan ID alat bak sampah" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="backToPersonalDataVerification()">Kembali</button>
        <button class="btn btn-primary" onclick="submitTrashBinRegistration()">Verifikasi</button>
      </div>
    </div>
  </div>

  <!-- Success Message Modal -->
  <div class="modal" id="successModal">
    <div class="modal-content">
      <div class="modal-body">
        <div class="success-message">
          <div class="success-icon">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="success-title">Berhasil!</div>
          <div class="success-details">
            Nasabah <strong id="successName"></strong> berhasil ditambahkan.
          </div>
          <div class="success-account">
            <p>No Rekening: <strong id="successAccountNumber">427312671342</strong></p>
            <p>ID Alat: <strong id="successDeviceId">SR-453301</strong></p>
            <p>Link verifikasi beserta password dan username untuk login telah dikirim ke email nasabah.</p>
          </div>
          <button class="btn btn-primary" onclick="closeVerificationModal()">Selesai</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Current customer data
    let currentCustomerData = null;

    // Sidebar toggle functionality
    document.querySelector('.toggle-collapse').addEventListener('click', function() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
      const icon = this.querySelector('i');
      
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
      } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
      }
    });

    // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function() {
      // Add your logout logic here
      console.log('Logout clicked');
      // window.location.href = 'login.html';
    });

    // Show address verification modal
    function showVerificationModal(name, email, phone, address, rtRw, dob, gender, nik, kk, familyPosition) {
      // Store customer data
      currentCustomerData = {
        name,
        email,
        phone,
        address,
        rtRw,
        dob,
        gender,
        nik,
        kk,
        familyPosition
      };

      // Set address verification form data
      document.getElementById('modalName').value = name;
      document.getElementById('modalEmail').value = email;
      document.getElementById('modalPhone').value = phone;
      document.getElementById('modalAddress').value = address;
      document.getElementById('modalRtRw').value = rtRw;
      
      // Show address verification modal
      document.getElementById('addressVerificationModal').style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    // Show personal data verification
    function showPersonalDataVerification() {
      // Set personal data verification form
      document.getElementById('modalDob').value = currentCustomerData.dob;
      document.getElementById('modalGender').value = currentCustomerData.gender;
      document.getElementById('modalNik').value = currentCustomerData.nik;
      document.getElementById('modalKk').value = currentCustomerData.kk;
      document.getElementById('modalFamilyPosition').value = currentCustomerData.familyPosition;
      
      // Switch modals
      document.getElementById('addressVerificationModal').style.display = 'none';
      document.getElementById('personalDataVerificationModal').style.display = 'flex';
    }

    // Back to address verification
    function backToAddressVerification() {
      document.getElementById('personalDataVerificationModal').style.display = 'none';
      document.getElementById('addressVerificationModal').style.display = 'flex';
    }

    // Back to personal data verification
    function backToPersonalDataVerification() {
      document.getElementById('trashBinRegistrationModal').style.display = 'none';
      document.getElementById('personalDataVerificationModal').style.display = 'flex';
    }

    // Close verification modal
    function closeVerificationModal() {
      document.getElementById('addressVerificationModal').style.display = 'none';
      document.getElementById('personalDataVerificationModal').style.display = 'none';
      document.getElementById('trashBinRegistrationModal').style.display = 'none';
      document.getElementById('successModal').style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Reject verification
    function rejectVerification() {
      alert('Verifikasi nasabah ' + currentCustomerData.name + ' ditolak');
      closeVerificationModal();
      // Add your rejection logic here
    }

    // Accept verification
    function acceptVerification() {
      // Show trash bin registration form
      document.getElementById('personalDataVerificationModal').style.display = 'none';
      document.getElementById('trashBinRegistrationModal').style.display = 'flex';
    }

         // Submit trash bin registration
     function submitTrashBinRegistration() {
       const jenisBak = document.getElementById('jenisBak').value;
       const noBak = document.getElementById('noBak').value;
       const idBak = document.getElementById('idBak').value;
       
       if (!jenisBak || !noBak || !idBak) {
         alert('Harap isi semua field pendaftaran bak sampah');
         return;
       }
       
       // Generate random account number (in a real app, this would come from your backend)
       const accountNumber = '4273' + Math.floor(10000000 + Math.random() * 90000000);
       
       // Show success message
       document.getElementById('trashBinRegistrationModal').style.display = 'none';
       document.getElementById('successName').textContent = currentCustomerData.name;
       document.getElementById('successAccountNumber').textContent = accountNumber;
       document.getElementById('successDeviceId').textContent = idBak;
       document.getElementById('successModal').style.display = 'flex';
       
       // Kirim email dengan informasi bak sampah
       sendVerificationEmail(currentCustomerData.email, currentCustomerData.name, accountNumber, idBak, jenisBak, noBak);
     }

     // Fungsi untuk mengirim email verifikasi
     function sendVerificationEmail(email, name, accountNumber, deviceId, jenisBak, noBak) {
       // Data yang akan dikirim ke backend
       const emailData = {
         to: email,
         subject: 'Verifikasi Nasabah Bijak Sampah - Berhasil',
         name: name,
         accountNumber: accountNumber,
         deviceId: deviceId,
         jenisBak: jenisBak,
         noBak: noBak,
         email: email
       };

       // Kirim data ke backend menggunakan fetch
       fetch('/send-verification-email', {
         method: 'POST',
         headers: {
           'Content-Type': 'application/json',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
         },
         body: JSON.stringify(emailData)
       })
       .then(response => response.json())
       .then(data => {
         if (data.success) {
           console.log('Email berhasil dikirim ke:', email);
           console.log('Informasi yang dikirim:');
           console.log('- Nama:', name);
           console.log('- Email:', email);
           console.log('- No Rekening:', accountNumber);
           console.log('- ID Alat:', deviceId);
           console.log('- Jenis Bak:', jenisBak);
           console.log('- No Bak:', noBak);
         } else {
           console.error('Gagal mengirim email:', data.message);
           alert('Gagal mengirim email verifikasi. Silakan coba lagi.');
         }
       })
       .catch(error => {
         console.error('Error mengirim email:', error);
         alert('Terjadi kesalahan saat mengirim email. Silakan coba lagi.');
       });
     }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      const addressModal = document.getElementById('addressVerificationModal');
      const personalModal = document.getElementById('personalDataVerificationModal');
      const trashBinModal = document.getElementById('trashBinRegistrationModal');
      const successModal = document.getElementById('successModal');
      
      if (event.target === addressModal || 
          event.target === personalModal || 
          event.target === trashBinModal ||
          event.target === successModal) {
        closeVerificationModal();
      }
    });
  </script>
</body>
</html>
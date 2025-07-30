<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profil Non Nasabah - Bijak Sampah</title>
<style>
/* ... (CSS yang sudah ada tidak berubah) ... */
* {
box-sizing: border-box;
margin: 0;
padding: 0;
font-family: 'Segoe UI', sans-serif;
}
body {
background: #f5f6f8;
display: flex;
min-height: 100vh;
}
/* Sidebar */
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
/* Main content */
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
font-size: 24px;
color: #0A3A60;
}
.toggle-sidebar {
background: none;
border: none;
font-size: 20px;
cursor: pointer;
color: #0A3A60;
}
/* Tab Navigation */
.tab-nav {
display: flex;
border-bottom: 1px solid #ddd;
margin-bottom: 30px;
}
.tab-btn {
padding: 12px 25px;
background: none;
border: none;
border-bottom: 3px solid transparent;
cursor: pointer;
font-weight: 500;
color: #666;
transition: all 0.3s;
}
.tab-btn.active {
color: #05445E;
border-bottom-color: #05445E;
}
.tab-content {
display: none;
}
.tab-content.active {
display: block;
}
/* Form Container */
.container {
background: white;
padding: 30px;
border-radius: 10px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
.form-grid {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 20px;
}
label {
display: block;
margin-bottom: 6px;
font-weight: 500;
color: #444;
font-size: 14px;
}
input, select {
width: 100%;
padding: 10px 12px;
border: 1px solid #ddd;
border-radius: 6px;
font-size: 14px;
background-color: #f9f9f9;
transition: border 0.3s;
}
input:focus, select:focus {
border-color: #75E6DA;
outline: none;
box-shadow: 0 0 0 2px rgba(117, 230, 218, 0.2);
}
.input-group {
margin-bottom: 20px;
}
.dob-group {
display: flex;
gap: 10px;
}
.dob-group input {
flex: 1;
}
.submit-btn {
text-align: center;
margin-top: 30px;
grid-column: span 2;
}
/* Improved Button Styles */
.btn {
border: none;
padding: 12px 25px;
font-size: 16px;
border-radius: 8px;
cursor: pointer;
transition: all 0.3s;
font-weight: 600;
display: inline-flex;
align-items: center;
justify-content: center;
gap: 8px;
}
.btn-primary {
background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
color: white;
box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
}
.btn-primary:hover {
background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
box-shadow: 0 6px 16px rgba(5, 68, 94, 0.3);
transform: translateY(-2px);
}
.btn-success {
background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
color: white;
box-shadow: 0 4px 12px rgba(46, 204, 113, 0.2);
}
.btn-success:hover {
background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
box-shadow: 0 6px 16px rgba(46, 204, 113, 0.3);
transform: translateY(-2px);
}
.btn-next {
background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
color: white;
box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
}
.btn-next:hover {
background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
transform: translateY(-2px);
}
.phone-input {
display: flex;
gap: 5px;
}
.phone-input input:first-child {
width: 60px;
text-align: center;
}
.phone-input input:last-child {
flex: 1;
}
/* Verification Tab Styles */
.verification-container {
display: flex;
gap: 40px;
flex-wrap: wrap;
align-items: flex-start;
}
.left-box {
background-color: white;
padding: 30px;
border-radius: 12px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
width: 300px;
}
.left-box h2 {
font-size: 20px;
margin-bottom: 10px;
color: #222;
}
.left-box p {
font-size: 14px;
color: #555;
margin-bottom: 25px;
}
.ktp-card {
display: flex;
align-items: center;
background-color: #f9f9f9;
border-radius: 10px;
padding: 15px 20px;
cursor: pointer;
transition: 0.2s;
border: 1px solid #e0e0e0;
margin-bottom: 15px;
}
.ktp-card:hover {
box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
.ktp-card-icon {
width: 40px;
height: 40px;
background-color: #0A3A60;
border-radius: 50%;
margin-right: 15px;
display: flex;
align-items: center;
justify-content: center;
color: white;
font-size: 20px;
}
.ktp-card-content {
flex: 1;
}
.ktp-card-content h3 {
margin: 0;
font-size: 16px;
}
.ktp-card-content p {
margin: 4px 0 0;
font-size: 13px;
color: #666;
}
.right-box {
background-color: white;
border-radius: 12px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
padding: 20px;
max-width: 420px;
}
.success-alert {
display: flex;
align-items: center;
gap: 10px;
background-color: #e8f9f0;
border-left: 5px solid #2ecc71;
padding: 15px 20px;
border-radius: 8px;
margin-bottom: 20px;
display: none; /* Awalnya disembunyikan */
}
.success-alert span {
color: #2c8c59;
font-weight: 600;
}
.ktp-preview {
width: 100%;
border-radius: 8px;
border: 3px solid #2ecc71;
object-fit: cover;
margin-bottom: 20px;
display: none;
}
.upload-container {
border: 2px dashed #ccc;
border-radius: 8px;
padding: 30px;
text-align: center;
cursor: pointer;
transition: all 0.3s;
margin-bottom: 20px;
}
.upload-container:hover {
border-color: #75E6DA;
background-color: #f8fdfd;
}
.upload-icon {
font-size: 40px;
color: #05445E;
margin-bottom: 15px;
}
.upload-text {
color: #555;
margin-bottom: 10px;
}
.upload-hint {
font-size: 12px;
color: #888;
}
#fileInput {
display: none;
}
/* Success Tab Styles */
.success-box {
background-color: white;
box-shadow: 0 4px 16px rgba(0,0,0,0.08);
border-radius: 20px;
padding: 40px 50px;
max-width: 600px;
margin: 0 auto;
text-align: center;
}
.success-icon {
font-size: 56px;
background-color: #e9fbdc;
color: #28a745;
border-radius: 50%;
width: 80px;
height: 80px;
display: flex;
align-items: center;
justify-content: center;
margin: 0 auto 20px;
}
.success-title {
font-size: 32px;
font-weight: 700;
color: #0a3a60;
margin-bottom: 15px;
}
.success-text {
color: #444;
font-size: 16px;
line-height: 1.6;
margin-bottom: 30px;
}
.success-text strong {
color: #111;
}
.success-details {
background: #f8f9fa;
border-radius: 10px;
padding: 20px;
margin: 25px 0;
text-align: left;
}
.detail-row {
display: flex;
margin-bottom: 10px;
}
.detail-label {
width: 150px;
color: #666;
}
.detail-value {
font-weight: 500;
color: #333;
}
/* Profile Page Styles */
.profile-container {
background: white;
padding: 30px;
border-radius: 10px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
.profile-banner {
width: 100%;
height: 6px;
border-radius: 8px;
margin-bottom: 30px;
background: linear-gradient(90deg, #B6D0E2 0%, #F7EEDD 100%);
}
.profile-header {
display: flex;
align-items: center;
gap: 20px;
margin-bottom: 30px;
position: relative;
}
.profile-avatar-container {
position: relative;
width: 80px;
height: 80px;
cursor: pointer;
}
.profile-avatar-container::before {
content: '\f030';
font-family: 'Font Awesome 5 Free';
font-weight: 900;
font-size: 1.5rem;
color: white;
background: rgba(0,0,0,0.5);
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
opacity: 0;
transition: opacity 0.3s;
}
.profile-avatar-container.editable:hover::before {
opacity: 1;
}
.profile-avatar {
width: 80px;
height: 80px;
border-radius: 50%;
object-fit: cover;
border: 4px solid white;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.profile-info {
flex: 1;
}
.profile-name {
font-size: 24px;
font-weight: bold;
color: #333;
margin-bottom: 5px;
}
.profile-email {
color: #75E6DA;
font-size: 14px;
}
.profile-buttons {
display: flex;
gap: 10px;
}
.profile-edit-btn, .profile-cancel-btn {
background: #05445E;
color: white;
border: none;
padding: 10px 20px;
border-radius: 8px;
font-weight: 600;
cursor: pointer;
transition: all 0.3s;
}
.profile-edit-btn:hover, .profile-cancel-btn:hover {
background: #0A3A60;
}
.profile-cancel-btn {
background: #e74c3c;
}
.profile-cancel-btn:hover {
background: #c0392b;
}
.profile-form-grid {
display: grid;
grid-template-columns: 1fr 1fr;
gap: 20px;
margin-bottom: 30px;
}
.profile-input-group {
margin-bottom: 15px;
}
.profile-label {
display: block;
margin-bottom: 8px;
font-weight: 600;
color: #555;
}
.profile-input-container {
position: relative;
}
.profile-input {
width: 100%;
padding: 12px 15px;
border: 1px solid #ddd;
border-radius: 8px;
background-color: #f5f9fa;
color: #333;
padding-right: 40px; /* Tambahkan ruang untuk ikon */
}
.profile-input[readonly] {
background-color: #f9f9f9;
cursor: not-allowed;
}
.profile-input-toggle {
position: absolute;
right: 15px;
top: 50%;
transform: translateY(-50%);
cursor: pointer;
color: #888;
}
.email-card {
display: flex;
align-items: center;
gap: 15px;
background-color: #f0f7ff;
border-radius: 8px;
padding: 15px;
margin-bottom: 15px;
}
.email-icon {
width: 32px;
height: 32px;
background-color: #75E6DA;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
color: white;
}
.email-info {
flex: 1;
}
.email-address {
font-weight: 500;
color: #333;
}
.email-date {
font-size: 12px;
color: #888;
}
.add-email-btn {
background: #e1f5fe;
color: #05445E;
border: none;
padding: 8px 15px;
border-radius: 6px;
font-weight: 600;
cursor: pointer;
transition: all 0.3s;
}
.add-email-btn:hover {
background: #d0ebff;
}
@media (max-width: 992px) {
.form-grid, .profile-form-grid {
grid-template-columns: 1fr;
}

.submit-btn {
grid-column: span 1;
}
.verification-container {
flex-direction: column;
}
.profile-header {
flex-direction: column;
text-align: center;
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
.left-box, .right-box {
width: 100%;
max-width: 100%;
}
.success-box {
padding: 30px 20px;
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
<li class="menu-item">
<div class="menu-icon"><i class="fas fa-home"></i></div>
<span class="menu-text">Dashboard</span>
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
<li class="menu-item active">
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
<div class="header" style="display:flex;justify-content:space-between;align-items:center;">
<h1 class="page-title">Registrasi Non-Nasabah</h1>
<div style="display:flex;align-items:center;gap:18px;">
<button class="icon-btn" title="Notifikasi" id="notificationBtn" style="background:none;border:none;cursor:pointer;font-size:1.3rem;color:#05445E;">
<i class="fas fa-bell"></i>
</button>
<button class="icon-btn" title="Cari" id="searchBtn" style="background:none;border:none;cursor:pointer;font-size:1.3rem;color:#05445E;">
<i class="fas fa-search"></i>
</button>
<div class="profile-pic" style="width:38px;height:38px;border-radius:50%;overflow:hidden;border:2px solid #05445E;display:flex;align-items:center;justify-content:center;cursor:pointer;" id="header-profile-pic-container">
<img src="https://ui-avatars.com/api/?name=User&background=75E6DA&color=05445E" alt="Profile" style="width:100%;height:100%;object-fit:cover;" id="header-profile-pic"/>
</div>
<button class="toggle-sidebar" id="toggleSidebar" style="margin-left:10px;">
<i class="fas fa-bars"></i>
</button>
</div>
</div>

<div class="tab-nav">
<button class="tab-btn active" data-tab="data-diri">Data Diri</button>
<button class="tab-btn" data-tab="verifikasi">Verifikasi Dokumen</button>
<button class="tab-btn" data-tab="sukses" id="suksesTabBtn" style="display:none;">Status Registrasi</button>
<button class="tab-btn" data-tab="profile" id="profileTabBtn" style="display:none;">Profil Saya</button>
</div>

<div class="tab-content active" id="data-diri">
<div class="container">
<form id="registrationForm">
<div class="form-grid">
<div>
<div class="input-group">
<label>No. HP</label>
<div class="phone-input">
<input type="text" value="+62" readonly>
<input type="text" placeholder="Nomor telepon" required>
</div>
</div>
<div class="input-group">
<label>Nama Depan</label>
<input type="text" id="firstName" placeholder="Tulis nama depan" required>
</div>
<div class="input-group">
<label>Nama Belakang</label>
<input type="text" id="lastName" placeholder="Tulis nama belakang" required>
</div>
<div class="input-group">
<label>Alias (opsional)</label>
<input type="text" id="alias" placeholder="Tulis nama alias">
</div>
<div class="input-group">
<label>Tanggal Lahir</label>
<div class="dob-group">
<input type="text" id="dobDay" placeholder="Hari" required>
<input type="text" id="dobMonth" placeholder="Bulan" required>
<input type="text" id="dobYear" placeholder="Tahun" required>
</div>
</div>
<div class="input-group">
<label>Negara</label>
<select id="country" required>
<option value="" selected disabled>Pilih Negara</option>
<option>Indonesia</option>
<option>Malaysia</option>
<option>Singapura</option>
<option>Thailand</option>
<option>Lainnya</option>
</select>
</div>
</div>
<div>
<div class="input-group">
<label>Provinsi</label>
<select id="province" required>
<option value="" selected disabled>Pilih Provinsi</option>
<option>Jawa Barat</option>
<option>Jawa Tengah</option>
<option>Jawa Timur</option>
<option>DKI Jakarta</option>
<option>Banten</option>
<option>DI Yogyakarta</option>
<option>Bali</option>
<option>Sumatera Utara</option>
<option>Sumatera Barat</option>
<option>Sumatera Selatan</option>
<option>Kalimantan Barat</option>
<option>Kalimantan Timur</option>
<option>Sulawesi Selatan</option>
<option>Sulawesi Utara</option>
<option>Papua</option>
<option>Papua Barat</option>
</select>
</div>
<div class="input-group">
<label>Kabupaten/Kota</label>
<select id="city" required>
<option value="" selected disabled>Pilih Kabupaten/Kota</option>
<option>Bandung</option>
<option>Jakarta Selatan</option>
<option>Jakarta Pusat</option>
<option>Jakarta Barat</option>
<option>Jakarta Timur</option>
<option>Jakarta Utara</option>
<option>Bogor</option>
<option>Depok</option>
<option>Tangerang</option>
<option>Bekasi</option>
<option>Surabaya</option>
<option>Malang</option>
<option>Yogyakarta</option>
<option>Semarang</option>
<option>Medan</option>
<option>Palembang</option>
<option>Makassar</option>
<option>Denpasar</option>
</select>
</div>
<div class="input-group">
<label>Alamat Jalan atau Desa</label>
<input type="text" id="address" placeholder="Tulis alamat jalan atau desa" required>
</div>
<div class="input-group">
<label>Kode Pos</label>
<input type="text" id="postal" placeholder="Tulis kode pos" required>
</div>
<div class="input-group">
<label>Email</label>
<input type="email" id="email" placeholder="Tulis email" required>
</div>
<div class="input-group">
<label>Password</label>
<input type="password" id="password" placeholder="Tulis password" required>
</div>
<div class="input-group">
<label>Registrasi sebagai</label>
<select id="registrationType" required>
<option value="nasabah" selected>Nasabah</option>
<option value="non-nasabah">Non-Nasabah</option>
</select>
</div>
</div>
</div>
<div class="submit-btn">
<button type="button" id="nextBtn" class="btn btn-next">
<i class="fas fa-arrow-right"></i> Lanjut ke Verifikasi
</button>
</div>
</form>
</div>
</div>

<div class="tab-content" id="verifikasi">
<div class="container">
<div class="verification-container">
<div class="left-box">
<h2>Unggah Dokumen Asli untuk Verifikasi</h2>
<p>Pilih dokumen asli yang akan diunggah untuk memverifikasi identitasmu.</p>
<div class="ktp-card" id="ktpUploadBtn">
<div class="ktp-card-icon"> 🪪 </div>
<div class="ktp-card-content">
<h3>Kartu Tanda Penduduk (KTP)</h3>
<p>Gunakan KTP untuk mengkonfirmasi data pribadimu</p>
</div>
</div>

<input type="file" id="fileInput" accept=".png,.jpg,.jpeg">
</div>
<div class="right-box">
<div class="success-alert" id="successAlert">
✅  <span>Berhasil Verifikasi</span>
</div>
<p id="uploadInstruction">Silakan unggah foto KTP Anda</p>
<img class="ktp-preview" id="ktpPreview" alt="KTP Preview"/>

<div class="upload-container" id="uploadContainer">
<div class="upload-icon">
<i class="fas fa-cloud-upload-alt"></i>
</div>
<div class="upload-text">
Seret & lepas file KTP di sini atau klik untuk memilih file
</div>
<div class="upload-hint">
Format yang didukung: PNG, JPG, JPEG (maks. 5MB)
</div>
</div>
</div>
</div>
<div class="submit-btn">
<button type="button" id="submitBtn" class="btn btn-primary">
<i class="fas fa-check"></i> Selesaikan Registrasi
</button>
</div>
</div>
</div>

<div class="tab-content" id="sukses">
<div class="container">
<div class="success-box">
<div class="success-icon"> ✔️ </div>
<div class="success-title">Registrasi Berhasil!</div>
<div class="success-text">
<p>Selamat datang, <strong id="successName">Nama Nasabah</strong>, data Anda berhasil disimpan.
Gunakan email dan password tadi utk lanjut ke halaman login.
</p>
</div>
<div class="success-details" id="successDetails">
<div class="detail-row" id="accountNumberRow">
<div class="detail-label">No. Rekening</div>
<div class="detail-value" id="accountNumber">427312671342</div>
</div>
<div class="detail-row" id="deviceIdRow">
<div class="detail-label">ID Alat</div>
<div class="detail-value" id="deviceId">SR-453301</div>
</div>
<div class="detail-row">
<div class="detail-label">Tanggal Registrasi</div>
<div class="detail-value" id="regDate">12 Oktober 2023</div>
</div>
</div>
<button class="btn btn-success" id="dashboardBtn">
<i class="fas fa-home"></i> Lihat Profil Anda
</button>
</div>
</div>
</div>
<div class="tab-content" id="profile">
<div class="profile-container">
<div class="profile-banner"></div>

<div class="profile-header">
<div class="profile-avatar-container">
<img src="https://ui-avatars.com/api/?name=User&background=75E6DA&color=05445E" class="profile-avatar" alt="Profile" id="profile-avatar">
<input type="file" id="avatarInput" accept="image/*" style="display:none;">
</div>
<div class="profile-info">
<div class="profile-name" id="profile-name"></div>
<div class="profile-email" id="profile-email"></div>
</div>
<div class="profile-buttons">
<button class="profile-edit-btn" id="editProfileBtn">Edit Profil</button>
<button class="profile-cancel-btn" id="cancelEditBtn" style="display:none;">Batal</button>
</div>
</div>

<div class="profile-form-grid">
<div>
<div class="profile-input-group">
<label class="profile-label">Nama Lengkap</label>
<input type="text" class="profile-input" id="profile-fullname" readonly>
</div>

<div class="profile-input-group">
<label class="profile-label">Gender</label>
<input type="text" class="profile-input" value="Perempuan" readonly>
</div>

<div class="profile-input-group">
<label class="profile-label">No. Telepon</label>
<input type="text" class="profile-input" id="profile-phone" readonly>
</div>
</div>

<div>
<div class="profile-input-group">
<label class="profile-label">Nama Pendek</label>
<input type="text" class="profile-input" id="profile-alias" readonly>
</div>

<div class="profile-input-group">
<label class="profile-label">No. Rekening</label>
<div class="profile-input-container">
<input type="password" class="profile-input" id="profile-account" readonly>
<span class="profile-input-toggle"><i class="fas fa-eye"></i></span>
</div>
</div>

<div class="profile-input-group">
<label class="profile-label">ID Alat</label>
<input type="text" class="profile-input" id="profile-deviceid" readonly>
</div>
</div>
</div>

<div class="profile-form-grid">
<div>
<label class="profile-label">Alamat e-mail saya</label>
<div class="email-card">
<div class="email-icon">
<i class="fas fa-envelope"></i>
</div>
<div class="email-info">
<div class="email-address" id="profile-email-card"></div>
<div class="email-date"></div>
</div>
</div>
<button class="add-email-btn">+ Tambah alamat email</button>
</div>

<div>
<div class="profile-input-group">
<label class="profile-label">Password Anda</label>
<div class="profile-input-container">
<input type="password" class="profile-input" id="profile-password" readonly>
<span class="profile-input-toggle"><i class="fas fa-eye"></i></span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-database-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-storage-compat.js"></script>
<script>
// Toggle sidebar
const toggleSidebar = document.getElementById('toggleSidebar');
const toggleCollapse = document.getElementById('toggleCollapse');
const sidebar = document.getElementById('sidebar');

function toggleSidebarState() {
sidebar.classList.toggle('collapsed');
const icon = toggleCollapse.querySelector('i');
if (sidebar.classList.contains('collapsed')) {
icon.classList.remove('fa-chevron-left');
icon.classList.add('fa-chevron-right');
} else {
icon.classList.remove('fa-chevron-right');
icon.classList.add('fa-chevron-left');
}
}

toggleSidebar.addEventListener('click', toggleSidebarState);
toggleCollapse.addEventListener('click', toggleSidebarState);

// Fungsionalitas klik untuk ikon notifikasi, cari, dan foto profil header
document.getElementById('notificationBtn').addEventListener('click', function() {
    alert('Belum ada notifikasi baru.');
});

document.getElementById('searchBtn').addEventListener('click', function() {
    const searchTerm = prompt('Masukkan kata kunci pencarian (contoh: Nomor Rekening, ID Alat):');
    if (searchTerm) {
        alert(`Anda mencari: "${searchTerm}". Fungsionalitas pencarian akan menampilkan hasil di sini.`);
        // Di sini bisa ditambahkan logika pencarian yang lebih kompleks,
        // seperti mencari data dari Firebase dan menampilkannya.
    } else {
        alert('Pencarian dibatalkan.');
    }
});

document.getElementById('header-profile-pic-container').addEventListener('click', function() {
    // Fungsi ini akan mengarahkan ke halaman profil atau menampilkan menu
    alert('Foto profil header berfungsi! Mengarahkan ke halaman profil atau menampilkan menu.');
});


// Set active menu item
const menuItems = document.querySelectorAll('.menu-item');
menuItems.forEach(item => {
item.addEventListener('click', function() {
menuItems.forEach(i => i.classList.remove('active'));
this.classList.add('active');
});
});
// Tab functionality
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');
const suksesTabBtn = document.getElementById('suksesTabBtn');
const profileTabBtn = document.getElementById('profileTabBtn');

// Sembunyikan tab sukses dan profil saat halaman dimuat
function initializeTabs() {
    suksesTabBtn.style.display = 'none';
    profileTabBtn.style.display = 'none';

    // Pastikan hanya tab pertama yang aktif
    tabContents.forEach((content, index) => {
        if (index === 0) {
            content.classList.add('active');
        } else {
            content.classList.remove('active');
        }
    });
    tabBtns.forEach((btn, index) => {
        if (index === 0) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}
window.onload = initializeTabs;

// Fungsi helper untuk beralih tab
function showTab(tabId) {
    tabContents.forEach(content => content.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    
    tabBtns.forEach(btn => {
        if (btn.style.display !== 'none') {
            btn.classList.remove('active');
        }
    });
    document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active');
}

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.getAttribute('data-tab');
        showTab(tabId);
    });
});

// Toggle password dan visibilitas nomor rekening
const toggleIcons = document.querySelectorAll('.profile-input-toggle');
toggleIcons.forEach(icon => {
    icon.addEventListener('click', () => {
        const input = icon.previousElementSibling;
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);

        icon.querySelector('i').classList.toggle('fa-eye');
        icon.querySelector('i').classList.toggle('fa-eye-slash');
    });
});

// Tombol Lanjut ke Verifikasi
document.getElementById('nextBtn').addEventListener('click', function() {
    const form = document.getElementById('registrationForm');
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;

    requiredFields.forEach(field => {
        if (!field.value) {
            isValid = false;
            field.style.borderColor = 'red';
        } else {
            field.style.borderColor = '#ddd';
        }
    });

    if (isValid) {
        // Simpan data form sementara
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const registrationType = document.getElementById('registrationType').value;

        document.getElementById('successName').textContent = `${firstName} ${lastName}`;

        const accountNumberRow = document.getElementById('accountNumberRow');
        const deviceIdRow = document.getElementById('deviceIdRow');
        if (registrationType === 'nasabah') {
            accountNumberRow.style.display = 'flex';
            deviceIdRow.style.display = 'flex';

            const randomAccount = '4' + Math.floor(100000000 + Math.random() * 900000000);
            const randomDeviceId = 'SR-' + Math.floor(100000 + Math.random() * 900000);
            document.getElementById('accountNumber').textContent = randomAccount;
            document.getElementById('deviceId').textContent = randomDeviceId;
        } else {
            accountNumberRow.style.display = 'none';
            deviceIdRow.style.display = 'none';
        }

        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        const today = new Date().toLocaleDateString('id-ID', options);
        document.getElementById('regDate').textContent = today;

        showTab('verifikasi');
    } else {
        alert('Harap isi semua field yang wajib diisi!');
    }
});

// Fungsionalitas Unggah File
const fileInput = document.getElementById('fileInput');
const ktpPreview = document.getElementById('ktpPreview');
const uploadContainer = document.getElementById('uploadContainer');
const successAlert = document.getElementById('successAlert');
const uploadInstruction = document.getElementById('uploadInstruction');
let ktpUploaded = false; // Flag untuk mengecek apakah KTP sudah diunggah

document.getElementById('ktpUploadBtn').addEventListener('click', () => fileInput.click());
uploadContainer.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];

        const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            alert('Format file tidak didukung. Harap unggah file PNG, JPG, atau JPEG.');
            return;
        }

        if (file.size > maxSize) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(event) {
            ktpPreview.src = event.target.result;
            ktpPreview.style.display = 'block';
            uploadContainer.style.display = 'none';
            successAlert.style.display = 'flex';
            uploadInstruction.textContent = 'Kamu berhasil memverifikasi dokumen';
            ktpUploaded = true; // Set flag menjadi true
        };
        reader.readAsDataURL(file);
    }
});

uploadContainer.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadContainer.style.borderColor = '#75E6DA';
    uploadContainer.style.backgroundColor = '#f8fdfd';
});

uploadContainer.addEventListener('dragleave', () => {
    uploadContainer.style.borderColor = '#ccc';
    uploadContainer.style.backgroundColor = 'transparent';
});

uploadContainer.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadContainer.style.borderColor = '#ccc';
    uploadContainer.style.backgroundColor = 'transparent';

    if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    }
});

// Firebase config & init
const firebaseConfig = {
    apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
    authDomain: "bijaksampah-aeb82.firebaseapp.com",
    projectId: "bijaksampah-aeb82",
    storageBucket: "bijaksampah-aeb82.appspot.com",
    messagingSenderId: "140467230562",
    appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b",
    databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app/"
};
firebase.initializeApp(firebaseConfig);
const db = firebase.database();
const storage = firebase.storage();

// Tombol Selesaikan Registrasi
document.getElementById('submitBtn').addEventListener('click', function() {
    if (!ktpUploaded) {
        alert('Harap unggah foto KTP terlebih dahulu untuk menyelesaikan registrasi!');
        return;
    }

    const form = document.getElementById('registrationForm');
    const data = {
        phone: form.querySelector('input[placeholder="Nomor telepon"]').value,
        firstName: document.getElementById('firstName').value,
        lastName: document.getElementById('lastName').value,
        alias: document.getElementById('alias').value,
        dob: {
            day: document.getElementById('dobDay').value,
            month: document.getElementById('dobMonth').value,
            year: document.getElementById('dobYear').value
        },
        country: document.getElementById('country').value,
        province: document.getElementById('province').value,
        city: document.getElementById('city').value,
        address: document.getElementById('address').value,
        postal: document.getElementById('postal').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
        registrationType: document.getElementById('registrationType').value,
        regDate: new Date().toISOString(),
        photoURL: "https://ui-avatars.com/api/?name=" + document.getElementById('firstName').value + "&background=75E6DA&color=05445E", // Default avatar
    };

    const userEmailKey = data.email.replace(/\./g, ',');

    db.ref('users/' + userEmailKey)
        .set(data)
        .then(() => {
            console.log("Data berhasil disimpan ke Firebase.");
            // Tampilkan tab sukses
            suksesTabBtn.style.display = 'block';
            showTab('sukses');
            // Juga perbarui foto profil di header dengan avatar default
            document.getElementById('header-profile-pic').src = data.photoURL;
        })
        .catch((error) => {
            console.error("Error saat menyimpan data: ", error);
            alert("Terjadi kesalahan saat menyimpan data. Silakan coba lagi.");
        });
});

// Tombol Lihat Profil Anda
document.getElementById('dashboardBtn').addEventListener('click', function() {
    profileTabBtn.style.display = 'block';
    showTab('profile');
    loadProfileData();
});

// LOGIKA HALAMAN PROFIL (CRUD)
const editProfileBtn = document.getElementById('editProfileBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const profileFullname = document.getElementById('profile-fullname');
const profileAlias = document.getElementById('profile-alias');
const profileAvatarContainer = document.querySelector('.profile-avatar-container');
const avatarInput = document.getElementById('avatarInput');
let isEditing = false;
let originalProfileData = {};

function toggleEditMode(enable) {
    isEditing = enable;
    profileFullname.readOnly = !enable;
    profileAlias.readOnly = !enable;

    if (enable) {
        profileFullname.classList.add('editable');
        profileAlias.classList.add('editable');
        editProfileBtn.textContent = 'Simpan Perubahan';
        editProfileBtn.style.background = '#2ecc71';
        cancelEditBtn.style.display = 'inline-block';
        profileAvatarContainer.classList.add('editable');
    } else {
        profileFullname.classList.remove('editable');
        profileAlias.classList.remove('editable');
        editProfileBtn.textContent = 'Edit Profil';
        editProfileBtn.style.background = '#05445E';
        cancelEditBtn.style.display = 'none';
        profileAvatarContainer.classList.remove('editable');
    }
}

async function uploadAvatarAndSaveProfile(file, userEmailKey, updates) {
    const storageRef = storage.ref('profile-pictures/' + userEmailKey + '.jpg');
    try {
        const snapshot = await storageRef.put(file);
        const downloadURL = await snapshot.ref.getDownloadURL();
        console.log('File uploaded:', downloadURL);
        
        updates.photoURL = downloadURL; // Tambahkan URL foto ke data yang akan disimpan

        await db.ref('users/' + userEmailKey).update(updates);
        console.log('Profile updated successfully!');
        alert('Profil berhasil diperbarui!');
        document.getElementById('profile-avatar').src = downloadURL;
        document.getElementById('header-profile-pic').src = downloadURL; // Perbarui juga foto di header
        toggleEditMode(false);
    } catch (error) {
        console.error('Error uploading file or updating profile:', error);
        alert('Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
    }
}

editProfileBtn.addEventListener('click', async function() {
    if (isEditing) {
        // Simpan perubahan
        const newAvatarFile = avatarInput.files[0];
        const updatedFullname = profileFullname.value;
        const updatedAlias = profileAlias.value;
        const userEmail = document.getElementById('email').value;
        const userEmailKey = userEmail.replace(/\./g, ',');
        
        const updates = {
            firstName: updatedFullname.split(' ')[0], // Ambil nama depan
            lastName: updatedFullname.split(' ').slice(1).join(' '), // Ambil nama belakang
            alias: updatedAlias,
        };

        if (newAvatarFile) {
            await uploadAvatarAndSaveProfile(newAvatarFile, userEmailKey, updates);
        } else {
            // Tanpa avatar baru, hanya update data teks
            await db.ref('users/' + userEmailKey).update(updates)
                .then(() => {
                    console.log('Profile updated successfully (no new avatar)!');
                    alert('Profil berhasil diperbarui!');
                    // Perbarui nama di header jika perlu
                    document.getElementById('profile-name').textContent = updatedFullname;
                    toggleEditMode(false);
                })
                .catch(error => {
                    console.error('Error updating profile:', error);
                    alert('Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.');
                });
        }
    } else {
        // Masuk mode edit
        originalProfileData = {
            fullname: profileFullname.value,
            alias: profileAlias.value,
        };
        toggleEditMode(true);
    }
});

cancelEditBtn.addEventListener('click', function() {
    // Kembalikan data ke kondisi semula
    profileFullname.value = originalProfileData.fullname;
    profileAlias.value = originalProfileData.alias;
    avatarInput.value = ''; // Reset input file
    toggleEditMode(false);
});

profileAvatarContainer.addEventListener('click', function() {
    if (isEditing) {
        avatarInput.click();
    }
});

avatarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('profile-avatar').src = event.target.result;
            document.getElementById('header-profile-pic').src = event.target.result; // Perbarui juga foto di header
        };
        reader.readAsDataURL(file);
    }
});

// Fungsi untuk memuat data profil dari Firebase
function loadProfileData() {
    const userEmail = document.getElementById('email').value;
    if (!userEmail) {
        console.error("Email not found. Cannot load profile data.");
        return;
    }
    const userEmailKey = userEmail.replace(/\./g, ',');
    db.ref('users/' + userEmailKey).once('value')
        .then(snapshot => {
            const data = snapshot.val();
            if (data) {
                const fullName = `${data.firstName} ${data.lastName}`;
                document.getElementById('profile-name').textContent = fullName;
                document.getElementById('profile-email').textContent = data.email;
                document.getElementById('profile-email-card').textContent = data.email;

                profileFullname.value = fullName;
                profileAlias.value = data.alias || data.firstName;
                document.getElementById('profile-phone').value = `+62${data.phone}`;
                document.getElementById('profile-password').value = data.password;

                if (data.registrationType === 'nasabah') {
                    document.getElementById('profile-account').value = document.getElementById('accountNumber').textContent;
                    document.getElementById('profile-deviceid').value = document.getElementById('deviceId').textContent;
                } else {
                    document.getElementById('profile-account').value = "Tidak tersedia";
                    document.getElementById('profile-deviceid').value = "Tidak tersedia";
                }
                // Muat foto profil
                const photoURL = data.photoURL || "https://ui-avatars.com/api/?name=" + encodeURIComponent(fullName) + "&background=75E6DA&color=05445E";
                document.getElementById('profile-avatar').src = photoURL;
                document.getElementById('header-profile-pic').src = photoURL; // Perbarui juga foto di header
                
                // Set tanggal registrasi pada email card
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                const today = new Date(data.regDate).toLocaleDateString('id-ID', options);
                document.querySelector('.email-date').textContent = today;
            }
        })
        .catch(error => {
            console.error("Error loading profile data:", error);
        });
}
</script>
</body>
</html>
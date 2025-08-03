<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Penimbangan - Bijak Sampah</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
    
    body {
      font-family: 'Inter', sans-serif;
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
      max-width: 800px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3);
      max-height: 90vh;
      overflow-y: auto;
    }

    .modal-header {
      padding: 15px 20px;
      background-color: var(--primary-color);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .modal-close {
      background: none;
      border: none;
      color: white;
      font-size: 20px;
      cursor: pointer;
    }

    /* Form Styles */
    .form-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 20px;
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

    .kategori-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 20px;
    }

    .kategori {
      flex: 1 1 250px;
      min-width: 250px;
    }

    .kategori h3 {
      margin-bottom: 10px;
      color: var(--primary-color);
      font-size: 16px;
      font-weight: 600;
    }

    .kategori-item {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }

    .kategori-item input[type="checkbox"] {
      margin-right: 10px;
    }

    .berat-input {
      margin-left: 10px;
      width: 80px;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .summary {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      padding: 15px;
      background-color: #f5f5f5;
      border-radius: 6px;
      font-size: 16px;
    }

    .summary strong {
      color: var(--primary-color);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
      .sidebar {
        width: 80px;
      }
      .sidebar.collapsed {
        width: 80px;
      }
      .main-content {
        margin-left: 80px;
        width: calc(100% - 80px);
      }
      .menu-text, .logo-text {
        display: none;
      }
      .logo-container {
        justify-content: center;
      }
      .form-grid {
        grid-template-columns: 1fr;
      }
      .summary {
        flex-direction: column;
        gap: 10px;
      }
    }
  </style>
</head>
<body class="bg-gray-100">

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
        <li class="menu-item">
          <div class="menu-icon"><i class="fas fa-users"></i></div>
          <span class="menu-text">Nasabah</span>
        </li>
        <li class="sub-menu-item">
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
        <li class="menu-item active">
          <a href="{{ route('penimbangansampah-banksampah') }}" style="text-decoration: none; color: inherit;">
            <div class="menu-icon"><i class="fas fa-weight-hanging"></i></div>
            <span class="menu-text">Penimbangan</span>
          </a>
        </li>
        <li class="sub-menu-item active">
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
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-700">Penimbangan</h2>
      <button id="inputSetoranBtn" class="bg-green-700 text-white px-6 py-2 rounded-lg shadow hover:bg-green-800">
        <i class="fas fa-plus mr-2"></i>Input Setoran Nasabah
      </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-white p-6 rounded shadow flex items-center gap-4">
        <div class="bg-green-100 text-green-600 p-4 rounded-full">
          <i class="fas fa-check-circle"></i>
        </div>
        <div>
          <p class="text-lg font-semibold">Telah Ditimbang</p>
          <p class="text-2xl font-bold text-green-600" id="countSelesai">2</p>
        </div>
      </div>
      <div class="bg-white p-6 rounded shadow flex items-center gap-4">
        <div class="bg-red-100 text-red-600 p-4 rounded-full">
          <i class="fas fa-clock"></i>
        </div>
        <div>
          <p class="text-lg font-semibold">Belum Ditimbang</p>
          <p class="text-2xl font-bold text-red-600" id="countProses">1</p>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded shadow p-6">
      <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
        <h3 class="text-lg font-bold text-gray-700">Daftar Penimbangan</h3>
        <div class="relative w-full md:w-auto">
          <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
          <input type="text" id="searchInput" placeholder="Cari nasabah..." class="border rounded pl-10 pr-3 py-2 text-sm w-full">
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead>
            <tr class="border-b">
              <th class="py-3 px-4">Nama Nasabah</th>
              <th class="py-3 px-4">No Rumah-RT</th>
              <th class="py-3 px-4">ID Unit Bak Sampah</th>
              <th class="py-3 px-4">No Telepon</th>
              <th class="py-3 px-4">Waktu</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4">Aksi</th>
            </tr>
          </thead>
          <tbody id="penimbanganTableBody">
            <!-- Data akan diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>
      <!-- Pagination -->
      <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-sm text-gray-600">
          Menampilkan <span id="showingFrom">1</span> sampai <span id="showingTo">3</span> dari <span id="totalEntries">3</span> entri
        </div>
        <div class="flex gap-1">
          <button class="px-3 py-1 rounded border bg-gray-200">1</button>
          <button class="px-3 py-1 rounded border hover:bg-gray-100">2</button>
          <button class="px-3 py-1 rounded border hover:bg-gray-100">3</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Input Setoran -->
  <div class="modal" id="inputSetoranModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="text-lg font-semibold">Input Setoran Nasabah</h3>
        <button class="modal-close" onclick="closeModal('inputSetoranModal')">&times;</button>
      </div>
      <div class="modal-body p-6">
        <div class="form-grid">
          <div class="form-group">
            <label>Nama Nasabah</label>
            <input type="text" id="namaNasabah" placeholder="Masukkan nama nasabah">
          </div>
          <div class="form-group">
            <label>No Rekening</label>
            <input type="text" id="noRekening" placeholder="Masukkan rekening nasabah">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" id="alamatNasabah" placeholder="Masukkan alamat nasabah">
          </div>
          <div class="form-group">
            <label>ID Bak Sampah</label>
            <input type="text" id="idBakSampah" placeholder="Masukkan ID Bak Sampah">
          </div>
        </div>

        <h4 class="text-md font-semibold mb-4 text-gray-700">Kategori Sampah</h4>
        <div class="kategori-container">
          <!-- Plastik -->
          <div class="kategori">
            <h3>Plastik</h3>
            <div class="kategori-item">
              <input type="checkbox" id="plastikBotolBening" data-harga="5000">
              <label for="plastikBotolBening">Plastik Botol Bening</label>
              <input type="number" class="berat-input" id="beratPlastikBotolBening" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="plastikBotolWarna" data-harga="4000">
              <label for="plastikBotolWarna">Plastik Botol Warna</label>
              <input type="number" class="berat-input" id="beratPlastikBotolWarna" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="plastikGelasKecil" data-harga="3000">
              <label for="plastikGelasKecil">Plastik Gelas Kecil</label>
              <input type="number" class="berat-input" id="beratPlastikGelasKecil" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="plastikKerasan" data-harga="4500">
              <label for="plastikKerasan">Plastik Kerasan</label>
              <input type="number" class="berat-input" id="beratPlastikKerasan" placeholder="gram" disabled>
            </div>
          </div>

          <!-- Logam -->
          <div class="kategori">
            <h3>Logam</h3>
            <div class="kategori-item">
              <input type="checkbox" id="aluminiumKaleng" data-harga="10000">
              <label for="aluminiumKaleng">Aluminium Kaleng Minuman</label>
              <input type="number" class="berat-input" id="beratAluminiumKaleng" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="aluminiumBiasa" data-harga="8000">
              <label for="aluminiumBiasa">Aluminium Biasa</label>
              <input type="number" class="berat-input" id="beratAluminiumBiasa" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="besiPutih" data-harga="7000">
              <label for="besiPutih">Besi Putih</label>
              <input type="number" class="berat-input" id="beratBesiPutih" placeholder="gram" disabled>
            </div>
          </div>

          <!-- Kertas -->
          <div class="kategori">
            <h3>Kertas</h3>
            <div class="kategori-item">
              <input type="checkbox" id="kertasKoran" data-harga="2000">
              <label for="kertasKoran">Kertas Koran</label>
              <input type="number" class="berat-input" id="beratKertasKoran" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="kertasHVS" data-harga="2500">
              <label for="kertasHVS">Kertas HVS</label>
              <input type="number" class="berat-input" id="beratKertasHVS" placeholder="gram" disabled>
            </div>
          </div>

          <!-- Lain-lain -->
          <div class="kategori">
            <h3>Lain-lain</h3>
            <div class="kategori-item">
              <input type="checkbox" id="botolKaca" data-harga="3000">
              <label for="botolKaca">Botol Kaca</label>
              <input type="number" class="berat-input" id="beratBotolKaca" placeholder="gram" disabled>
            </div>
            <div class="kategori-item">
              <input type="checkbox" id="minyakJelantah" data-harga="12000">
              <label for="minyakJelantah">Minyak Jelantah</label>
              <input type="number" class="berat-input" id="beratMinyakJelantah" placeholder="gram" disabled>
            </div>
          </div>
        </div>

        <div class="summary">
          <div>Total Setoran Sampah: <strong id="totalBerat">0 gr</strong></div>
          <div>Nominal Harga Setoran: <strong id="totalHarga">Rp 0</strong></div>
        </div>

        <div class="flex justify-end gap-4 mt-6">
          <button class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400" onclick="closeModal('inputSetoranModal')">
            Batal
          </button>
          <button class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800" onclick="submitSetoran()">
            Setorkan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Detail Penimbangan -->
  <div class="modal" id="detailModal">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="text-lg font-semibold">Detail Penimbangan</h3>
        <button class="modal-close" onclick="closeModal('detailModal')">&times;</button>
      </div>
      <div class="modal-body p-6">
        <div class="mb-6">
          <h4 class="text-md font-semibold mb-2 text-gray-700">Informasi Nasabah</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-600">Nama Nasabah</p>
              <p class="font-medium" id="detailNama">Jane Cooper</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">No Rekening</p>
              <p class="font-medium" id="detailRekening">1234567890</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">Alamat</p>
              <p class="font-medium" id="detailAlamat">Jl. Merdeka No. 45, RT 35/RW 12</p>
            </div>
            <div>
              <p class="text-sm text-gray-600">ID Bak Sampah</p>
              <p class="font-medium" id="detailBakSampah">1/35/43</p>
            </div>
          </div>
        </div>

        <div class="mb-6">
          <h4 class="text-md font-semibold mb-2 text-gray-700">Detail Sampah</h4>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
              <thead>
                <tr class="border-b">
                  <th class="py-2 px-3 text-left">Jenis Sampah</th>
                  <th class="py-2 px-3 text-right">Berat (gram)</th>
                  <th class="py-2 px-3 text-right">Harga Satuan</th>
                  <th class="py-2 px-3 text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody id="detailSampahBody">
                <!-- Data akan diisi oleh JavaScript -->
              </tbody>
              <tfoot>
                <tr class="border-t font-semibold">
                  <td class="py-2 px-3 text-right" colspan="3">Total</td>
                  <td class="py-2 px-3 text-right" id="detailTotal">Rp 45.000</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        <div class="flex justify-end">
          <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700" onclick="closeModal('detailModal')">
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Data penyimpanan untuk transaksi
    let transaksiPenimbangan = [
      {
        id: 1,
        nama: "Jane Cooper",
        noRumah: "45-35",
        bakSampah: "1/35/43",
        telepon: "(+62) 888123456",
        waktu: "Kemarin",
        status: "Selesai",
        detail: {
          noRekening: "1234567890",
          alamat: "Jl. Merdeka No. 45, RT 35/RW 12",
          sampah: [
            { jenis: "Plastik Botol Bening", berat: 500, harga: 5000, subtotal: 2500 },
            { jenis: "Aluminium Kaleng Minuman", berat: 300, harga: 10000, subtotal: 3000 },
            { jenis: "Kertas Koran", berat: 1000, harga: 2000, subtotal: 2000 }
          ],
          total: 7500
        }
      },
      {
        id: 2,
        nama: "Floyd Miles",
        noRumah: "26-33",
        bakSampah: "1/35/26",
        telepon: "(+62) 888234567",
        waktu: "30m yang lalu",
        status: "Selesai",
        detail: {
          noRekening: "2345678901",
          alamat: "Jl. Sudirman No. 26, RT 33/RW 10",
          sampah: [
            { jenis: "Plastik Gelas Kecil", berat: 800, harga: 3000, subtotal: 2400 },
            { jenis: "Besi Putih", berat: 500, harga: 7000, subtotal: 3500 }
          ],
          total: 5900
        }
      },
      {
        id: 3,
        nama: "Ronald Richards",
        noRumah: "1-31",
        bakSampah: "1/3/1",
        telepon: "(+62) 888345678",
        waktu: "1m yang lalu",
        status: "Proses",
        detail: {
          noRekening: "3456789012",
          alamat: "Jl. Gatot Subroto No. 1, RT 31/RW 5",
          sampah: [
            { jenis: "Minyak Jelantah", berat: 2000, harga: 12000, subtotal: 24000 }
          ],
          total: 24000
        }
      }
    ];

    // Inisialisasi variabel
    let totalBerat = 0;
    let totalHarga = 0;

    // Fungsi untuk menampilkan data ke tabel
    function renderTable() {
      const tbody = document.getElementById('penimbanganTableBody');
      tbody.innerHTML = '';
      
      // Hitung statistik
      const countSelesai = transaksiPenimbangan.filter(t => t.status === 'Selesai').length;
      const countProses = transaksiPenimbangan.filter(t => t.status === 'Proses').length;
      
      document.getElementById('countSelesai').textContent = countSelesai;
      document.getElementById('countProses').textContent = countProses;
      
      transaksiPenimbangan.forEach(transaksi => {
        const row = document.createElement('tr');
        row.className = 'border-b hover:bg-gray-50';
        row.innerHTML = `
          <td class="py-3 px-4">${transaksi.nama}</td>
          <td class="py-3 px-4">${transaksi.noRumah}</td>
          <td class="py-3 px-4">${transaksi.bakSampah}</td>
          <td class="py-3 px-4">${transaksi.telepon}</td>
          <td class="py-3 px-4">${transaksi.waktu}</td>
          <td class="py-3 px-4">
            <span class="bg-${transaksi.status === 'Selesai' ? 'green' : 'yellow'}-100 text-${transaksi.status === 'Selesai' ? 'green' : 'yellow'}-800 text-xs font-semibold px-2.5 py-0.5 rounded">
              ${transaksi.status}
            </span>
          </td>
          <td class="py-3 px-4">
            <button class="text-blue-600 hover:text-blue-800 mr-2" onclick="viewDetail(${transaksi.id})">
              <i class="fas fa-eye"></i>
            </button>
            <button class="text-green-600 hover:text-green-800" onclick="editItem(${transaksi.id})">
              <i class="fas fa-edit"></i>
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
      
      // Update informasi pagination
      document.getElementById('showingFrom').textContent = '1';
      document.getElementById('showingTo').textContent = transaksiPenimbangan.length;
      document.getElementById('totalEntries').textContent = transaksiPenimbangan.length;
    }

    // Fungsi untuk menambahkan transaksi baru
    function addTransaksi(data) {
      const newId = transaksiPenimbangan.length > 0 ? 
        Math.max(...transaksiPenimbangan.map(t => t.id)) + 1 : 1;
      
      const newTransaksi = {
        id: newId,
        nama: data.namaNasabah,
        noRumah: data.noRumah || "00-00",
        bakSampah: data.idBakSampah,
        telepon: data.noTelepon || "(+62) 888000000",
        waktu: "Baru saja",
        status: "Selesai",
        detail: {
          noRekening: data.noRekening,
          alamat: data.alamatNasabah,
          sampah: data.sampah,
          total: data.totalHarga
        }
      };
      
      transaksiPenimbangan.unshift(newTransaksi);
      renderTable();
    }

    // Fungsi untuk menghitung total
    function calculateTotal() {
      totalBerat = 0;
      totalHarga = 0;
      
      document.querySelectorAll('.kategori-item input[type="checkbox"]:checked').forEach(checkbox => {
        const beratId = 'berat' + checkbox.id.replace(/(^\w)/, m => m.toUpperCase());
        const berat = parseFloat(document.getElementById(beratId).value) || 0;
        const hargaPerGram = parseFloat(checkbox.dataset.harga) / 1000;
        const subtotal = berat * hargaPerGram;
        
        totalBerat += berat;
        totalHarga += subtotal;
      });
      
      updateTotals();
    }

    function updateTotals() {
      document.getElementById('totalBerat').textContent = totalBerat.toFixed(1) + ' gr';
      document.getElementById('totalHarga').textContent = 'Rp ' + totalHarga.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Submit setoran
    function submitSetoran() {
      const namaNasabah = document.getElementById('namaNasabah').value;
      const noRekening = document.getElementById('noRekening').value;
      const alamatNasabah = document.getElementById('alamatNasabah').value;
      const idBakSampah = document.getElementById('idBakSampah').value;
      
      if (!namaNasabah || !noRekening) {
        alert('Nama nasabah dan no rekening harus diisi!');
        return;
      }
      
      if (totalBerat === 0) {
        alert('Harap pilih setidaknya satu jenis sampah dan masukkan beratnya!');
        return;
      }
      
      // Kumpulkan data sampah yang dipilih
      const sampahData = [];
      document.querySelectorAll('.kategori-item input[type="checkbox"]:checked').forEach(checkbox => {
        const beratId = 'berat' + checkbox.id.replace(/(^\w)/, m => m.toUpperCase());
        const berat = parseFloat(document.getElementById(beratId).value) || 0;
        const jenis = checkbox.nextElementSibling.textContent.trim();
        const harga = parseFloat(checkbox.dataset.harga);
        const subtotal = (berat * harga) / 1000;
        
        sampahData.push({
          jenis,
          berat,
          harga,
          subtotal
        });
      });
      
      // Buat objek data transaksi
      const transaksiData = {
        namaNasabah,
        noRekening,
        alamatNasabah,
        idBakSampah,
        sampah: sampahData,
        totalHarga: totalHarga
      };
      
      // Tambahkan ke data transaksi
      addTransaksi(transaksiData);
      
      // Tampilkan notifikasi
      alert(`Setoran untuk ${namaNasabah} (${noRekening}) sebesar ${totalBerat} gram dengan total harga Rp ${totalHarga.toFixed(0)} berhasil disimpan!`);
      
      // Tutup modal
      closeModal('inputSetoranModal');
    }

    // View detail function
    function viewDetail(id) {
      const transaksi = transaksiPenimbangan.find(t => t.id === id);
      if (!transaksi) return;
      
      document.getElementById('detailNama').textContent = transaksi.nama;
      document.getElementById('detailRekening').textContent = transaksi.detail.noRekening;
      document.getElementById('detailAlamat').textContent = transaksi.detail.alamat;
      document.getElementById('detailBakSampah').textContent = transaksi.bakSampah;
      
      const tbody = document.getElementById('detailSampahBody');
      tbody.innerHTML = '';
      
      transaksi.detail.sampah.forEach(item => {
        const row = document.createElement('tr');
        row.className = 'border-b';
        row.innerHTML = `
          <td class="py-2 px-3">${item.jenis}</td>
          <td class="py-2 px-3 text-right">${item.berat}</td>
          <td class="py-2 px-3 text-right">Rp ${item.harga.toLocaleString()}/kg</td>
          <td class="py-2 px-3 text-right">Rp ${item.subtotal.toLocaleString()}</td>
        `;
        tbody.appendChild(row);
      });
      
      document.getElementById('detailTotal').textContent = 'Rp ' + transaksi.detail.total.toLocaleString();
      
      openModal('detailModal');
    }

    // Edit item function
    function editItem(id) {
      const transaksi = transaksiPenimbangan.find(t => t.id === id);
      if (!transaksi) return;
      
      // Isi form dengan data yang ada
      document.getElementById('namaNasabah').value = transaksi.nama;
      document.getElementById('noRekening').value = transaksi.detail.noRekening;
      document.getElementById('alamatNasabah').value = transaksi.detail.alamat;
      document.getElementById('idBakSampah').value = transaksi.bakSampah;
      
      // Reset semua checkbox dan berat
      document.querySelectorAll('.kategori-item input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
        const beratId = 'berat' + checkbox.id.replace(/(^\w)/, m => m.toUpperCase());
        document.getElementById(beratId).value = '';
        document.getElementById(beratId).disabled = true;
      });
      
      // Centang checkbox dan isi berat berdasarkan data
      transaksi.detail.sampah.forEach(item => {
        const checkboxId = item.jenis.toLowerCase().replace(/ /g, '');
        const checkbox = document.getElementById(checkboxId);
        if (checkbox) {
          checkbox.checked = true;
          const beratId = 'berat' + checkboxId.replace(/(^\w)/, m => m.toUpperCase());
          document.getElementById(beratId).value = item.berat;
          document.getElementById(beratId).disabled = false;
        }
      });
      
      // Hitung ulang total
      calculateTotal();
      
      openModal('inputSetoranModal');
    }

    // Modal functions
    function openModal(modalId) {
      document.getElementById(modalId).style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
      document.body.style.overflow = 'auto';
    }

    // Sidebar toggle functionality
    document.querySelector('.toggle-collapse').addEventListener('click', function() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
      const icon = this.querySelector('i');
      
      if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
        document.querySelector('.main-content').style.marginLeft = '80px';
        document.querySelector('.main-content').style.width = 'calc(100% - 80px)';
      } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
        document.querySelector('.main-content').style.marginLeft = '250px';
        document.querySelector('.main-content').style.width = 'calc(100% - 250px)';
      }
    });

    // Logout functionality
    document.getElementById('logoutBtn').addEventListener('click', function() {
      if (confirm('Apakah Anda yakin ingin logout?')) {
        // Redirect to login page or perform logout action
        window.location.href = '/logout';
      }
    });

    // Input Setoran Button
    document.getElementById('inputSetoranBtn').addEventListener('click', function() {
      // Reset form
      document.getElementById('namaNasabah').value = '';
      document.getElementById('noRekening').value = '';
      document.getElementById('alamatNasabah').value = '';
      document.getElementById('idBakSampah').value = '';
      
      // Reset checkboxes and weight inputs
      document.querySelectorAll('.kategori-item input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
        const beratId = 'berat' + checkbox.id.replace(/(^\w)/, m => m.toUpperCase());
        document.getElementById(beratId).value = '';
        document.getElementById(beratId).disabled = true;
      });
      
      // Reset totals
      totalBerat = 0;
      totalHarga = 0;
      updateTotals();
      
      openModal('inputSetoranModal');
    });

    // Enable/disable weight input based on checkbox
    document.querySelectorAll('.kategori-item input[type="checkbox"]').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const beratId = 'berat' + this.id.replace(/(^\w)/, m => m.toUpperCase());
        const beratInput = document.getElementById(beratId);
        beratInput.disabled = !this.checked;
        if (!this.checked) {
          beratInput.value = '';
          calculateTotal();
        }
      });
    });

    // Calculate total when weight changes
    document.querySelectorAll('.berat-input').forEach(input => {
      input.addEventListener('input', calculateTotal);
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#penimbanganTableBody tr');
      
      rows.forEach(row => {
        const nama = row.cells[0].textContent.toLowerCase();
        if (nama.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });

    // Initialize the table when page loads
    document.addEventListener('DOMContentLoaded', function() {
      renderTable();
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
      if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        document.body.style.overflow = 'auto';
      }
    });
  </script>
</body>
</html>
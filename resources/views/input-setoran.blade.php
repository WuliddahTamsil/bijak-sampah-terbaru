<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Input Setoran - Bijak Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            background-color: #f8fafc;
        }

        /* Custom CSS untuk efek gradasi sidebar */
        .sidebar-banksampah-gradient {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
        }
        
        /* Ensure seamless connection between topbar and sidebar */
        .topbar-sidebar-seamless {
            background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);
            border: none;
            box-shadow: none;
        }

        /* Style untuk area main content */
        .main-content {
            padding-top: 64px; /* Menyesuaikan dengan tinggi top bar */
            min-height: 100vh;
            width: 100%;
            margin-left: 0;
            margin-right: 0;
        }
    
    
    
    
        /* Full Width Styles */
        .stats-cards {
            width: 100%;
        margin: 0;
        padding: 0;
        }

        .data-table-section {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .data-table th,
        .data-table td {
            word-wrap: break-word;
            max-width: 200px;
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

        .form-group input, .form-group select, .form-group textarea {
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

        .btn-secondary {
            background-color: #e5e7eb;
            color: #333;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #d1d5db;
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
            border: none;
        }

        .btn-success:hover {
            background-color: #247532;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .table-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .search-input, .filter-select {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .table-actions {
                width: 100%;
                justify-content: flex-start;
            }
    }
    

    .main-content-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        padding-top: 60px; 
        padding-left: 4rem; 
        padding-right: 0;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow-x: hidden;
        width: 100%;
        scroll-behavior: smooth;
    }
    .content-container { 
        width: 100%; 
        margin: 0; 
        padding: 2rem; 
        position: relative; 
        z-index: 1; 
        box-sizing: border-box;
        scroll-behavior: smooth;
        max-width: none;
    }
    .sidebar-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 45; opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }
    

    
    @media (max-width: 768px) {
        .main-content-wrapper {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .content-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
    

    .page-title {
        color: #05445E;
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        border: 1px solid #e9ecef;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .form-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-title {
        color: #05445E;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border-bottom: 2px solid #75E6DA;
        padding-bottom: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        color: #05445E;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        cursor: pointer;
    }

    .form-select:focus {
        outline: none;
        border-color: #75E6DA;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .btn-primary {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #05445E, #043a4e);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 68, 94, 0.4);
    }

    .text-highlight {
        color: #75E6DA;
    }

    .weight-display {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 1rem;
    }

    .weight-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .weight-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>

<div class="flex min-h-screen bg-gray-50 w-full" x-data="{ sidebarOpen: false, activeMenu: 'input-setoran' }" x-init="activeMenu = 'input-setoran'">
    {{-- Sidebar --}}
    <aside 
        class="fixed top-0 left-0 z-40 flex flex-col py-6 overflow-hidden shadow-2xl group sidebar-banksampah-gradient text-white"
        :class="sidebarOpen ? 'w-[250px]' : 'w-16'"
        style="transition: width 0.3s ease; height: 100vh; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            
            {{-- Logo Section with Toggle Button --}}
            {{-- PASTIKAN FILE logo-icon.png ADA DI public/asset/img --}}
            <div class="flex items-center justify-center mb-8 mt-14" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
                <div class="flex items-center justify-center gap-2" :class="sidebarOpen ? 'flex-1' : ''">
                    <img x-show="sidebarOpen" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                    <img x-show="!sidebarOpen" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Kecil">
                    {{-- Toggle Button --}}
                    <button 
                        @click="sidebarOpen = !sidebarOpen"
                        class="p-1 rounded-full bg-white/20 hover:bg-white/30 transition-colors duration-200 text-white"
                        :class="sidebarOpen ? 'rotate-180' : ''"
                        style="transition: transform 0.3s ease;"
                    >
                        <i class="fas fa-chevron-left text-sm"></i>
                    </button>
                </div>
            </div>
            
            {{-- Navigation Menu --}}
            <nav class="flex flex-col gap-2 w-full flex-1 overflow-y-auto">
                <a 
                    href="{{ route('dashboard-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center; padding-left: 0; padding-right: 0;'"
                    @click="activeMenu = 'dashboard'"
                >
                    <i class="fas fa-home text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Dashboard</span>
                </a>

                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                    <i class="fas fa-users text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Nasabah</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('verifikasi-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'verifikasi-nasabah'"
                        >
                            <i class="fas fa-user-check"></i>
                            <span x-show="sidebarOpen">Verifikasi Nasabah</span>
                        </a>
                        <a 
                            href="{{ route('data-nasabah-banksampah') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'data-nasabah'"
                        >
                            <i class="fas fa-database"></i>
                            <span x-show="sidebarOpen">Data Nasabah</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('penjemputan-sampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjemputan-sampah'"
                >
                    <i class="fas fa-truck text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjemputan Sampah</span>
                </a>
                
                <div 
                    class="group"
                    x-data="{ expanded: false }"
                    x-init="$watch('sidebarOpen', value => { if (!value) expanded = false })"
                >
                    <button 
                        @click="expanded = !expanded" 
                        class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 bg-white/20 shadow-sm"
                        :style="sidebarOpen ? 'justify-between; gap: 12px;' : 'justify-content: center;'"
                    >
                        <div class="flex items-center" :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'">
                            <i class="fas fa-weight-hanging text-lg"></i>
                            <span x-show="sidebarOpen" class="text-sm font-medium">Penimbangan</span>
                        </div>
                        <i x-show="sidebarOpen" class="fas fa-chevron-down text-xs opacity-70 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="expanded && sidebarOpen" x-collapse.duration.300ms class="pl-6 pt-2 space-y-1">
                        <a 
                            href="{{ route('input-setoran') }}" 
                            class="flex items-center gap-3 p-2 rounded-lg whitespace-nowrap w-full text-sm hover:bg-white/10 hover:shadow-sm transition-colors duration-200"
                            @click="activeMenu = 'input-setoran'"
                        >
                            <i class="fas fa-plus-circle"></i>
                            <span x-show="sidebarOpen">Input Setoran</span>
                        </a>
                    </div>
                </div>

                <a 
                    href="{{ route('datasampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'data-sampah'"
                >
                    <i class="fas fa-trash-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Data Sampah</span>
                </a>
                
                <a 
                    href="{{ route('penjualansampah-banksampah') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'penjualansampah'"
                >
                    <i class="fas fa-shopping-cart text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Penjualan Sampah</span>
                </a>
                
                <a 
                    href="{{ route('settingsbank') }}" 
                    class="flex items-center p-3 font-medium rounded-lg whitespace-nowrap w-full transition-colors duration-200 hover:bg-white/10 hover:shadow-sm"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                    @click="activeMenu = 'pengaturan'"
                >
                    <i class="fas fa-cog text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Pengaturan</span>
                </a>
            </nav>
            
            {{-- Logout Section --}}
            <div class="w-full flex items-center py-3 mt-auto border-t border-white/20">
                <a 
                    href="{{ route('logout') }}" 
                    class="flex items-center p-3 rounded-lg hover:bg-white/10 hover:shadow-sm text-white transition-all duration-200 w-full whitespace-nowrap"
                    :style="sidebarOpen ? 'gap: 12px;' : 'justify-content: center;'"
                >
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span x-show="sidebarOpen" class="text-sm font-medium">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-content" :class="sidebarOpen ? 'pl-24' : 'pl-24'" style="transition: padding-left 0.3s ease; width: 100%;">
        {{-- Top Header Bar --}}
        <div class="fixed top-0 left-0 right-0 h-12 z-40 flex items-center justify-between px-6 text-white" :style="'padding-left:' + (sidebarOpen ? '16rem' : '4rem') + '; background: linear-gradient(135deg, #75E6DA 0%, #05445E 30%, #05445E 100%); width: 100%;'">
            <h1 class="text-white font-semibold text-lg" style="position: absolute; left: 1.5rem;">BijakSampah</h1>
            <div class="flex items-center gap-4" style="position: absolute; right: 1.5rem;">
                <a href="{{ route('notifikasibank') }}" class="relative">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">3</span>
                </a>
                <button class="focus:outline-none">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <a href="{{ route('profilebank') }}" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300">
                        <img src="{{ asset('asset/img/user_profile.jpg') }}" alt="Profile" class="w-full h-full object-cover">
                    </a>
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                </div>
            </div>
        </div>
        <div class="p-8" style="padding-top: 30px; width: 100%; max-width: 100%;">
            <h1 class="text-4xl font-bold text-center mb-8 text-highlight">Input Setoran Sampah</h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Form Input Setoran --}}
                <div class="form-card">
                    <h2 class="form-title">Data Setoran</h2>
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Nama Nasabah</label>
                            <select name="nasabah" class="form-select" required>
                                <option value="">Pilih Nasabah</option>
                                <option value="Ahmad Nasabah">Ahmad Nasabah</option>
                                <option value="Siti Nasabah">Siti Nasabah</option>
                                <option value="Budi Nasabah">Budi Nasabah</option>
                                <option value="Dewi Nasabah">Dewi Nasabah</option>
                                <option value="Rina Nasabah">Rina Nasabah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Sampah</label>
                            <select name="jenisSampah" class="form-select" required>
                                <option value="">Pilih Jenis Sampah</option>
                                <option value="plastik">Plastik</option>
                                <option value="kertas">Kertas</option>
                                <option value="kardus">Kardus</option>
                                <option value="botol">Botol</option>
                                <option value="kaleng">Kaleng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat (kg)</label>
                            <input name="berat" type="number" class="form-input" placeholder="Masukkan berat sampah" step="0.1" min="0" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga per kg</label>
                            <input name="hargaPerKg" type="number" class="form-input" placeholder="Masukkan harga per kg" step="100" min="0" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Setoran</label>
                            <input type="date" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-input" rows="3" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                        </div>
                        <button type="button" onclick="simpanSetoran()" class="btn-primary px-6 py-2 rounded-lg w-full">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Setoran
                        </button>
                    </div>
                </div>

                {{-- Informasi Setoran --}}
                <div class="form-card">
                    <h2 class="form-title">Informasi Setoran</h2>
                    <div class="form-section">
                        <div class="weight-display">
                            <div class="weight-value">0.0 kg</div>
                            <div class="weight-label">Total Berat Sampah</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Total Harga</label>
                            <div class="text-2xl font-bold text-green-600">Rp 0</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Status Setoran</label>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                    Pending
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Statistik Hari Ini</label>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="bg-blue-50 p-2 rounded">
                                    <div class="font-bold text-blue-600" id="totalSetoranHariIni">0</div>
                                    <div class="text-blue-500">Total Setoran</div>
                                </div>
                                <div class="bg-green-50 p-2 rounded">
                                    <div class="font-bold text-green-600" id="totalBeratHariIni">0.0 kg</div>
                                    <div class="text-green-500">Total Berat</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Riwayat Setoran Hari Ini</label>
                            <div id="riwayatHariIni" class="space-y-2">
                                <!-- Riwayat akan diisi oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Setoran Terbaru --}}
            <div class="form-card">
                <div class="flex justify-between items-center mb-4">
                <h2 class="form-title">Setoran Terbaru</h2>
                    <div class="flex gap-2">
                        <button onclick="exportData()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-bold">
                            <i class="fas fa-download mr-2"></i>Export
                        </button>
                        <button onclick="printData()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors font-bold">
                            <i class="fas fa-print mr-2"></i>Print
                        </button>
                        <button onclick="resetAllData()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-bold">
                            <i class="fas fa-trash mr-2"></i>Reset
                        </button>
                        <button onclick="addDummyData()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors font-bold">
                            <i class="fas fa-plus mr-2"></i>Test Data
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Tanggal</th>
                                <th class="px-4 py-2 text-left">Nasabah</th>
                                <th class="px-4 py-2 text-left">Jenis Sampah</th>
                                <th class="px-4 py-2 text-left">Berat</th>
                                <th class="px-4 py-2 text-left">Harga</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Data untuk aplikasi
    let setoranData = [];
    let currentSetoran = {
        nasabah: '',
        jenisSampah: '',
        berat: 0,
        hargaPerKg: 0,
        tanggal: '',
        keterangan: '',
        totalHarga: 0
    };

    // Harga per kg untuk setiap jenis sampah
    const hargaSampah = {
        'plastik': 5000,
        'kertas': 3000,
        'kardus': 4000,
        'botol': 6000,
        'kaleng': 8000
    };

    // Inisialisasi aplikasi
    document.addEventListener('DOMContentLoaded', function() {
        try {
            initializeForm();
            loadSetoranData();
            updateDisplay();
            updateTable();
        } catch (error) {
            console.error('Error initializing application:', error);
            showNotification('Terjadi kesalahan saat memuat aplikasi', 'error');
        }
    });

    // Inisialisasi form
    function initializeForm() {
        // Set tanggal hari ini
        document.querySelector('input[type="date"]').value = new Date().toISOString().split('T')[0];
        
        // Event listeners untuk form
        document.querySelector('select[name="jenisSampah"]').addEventListener('change', updateHarga);
        document.querySelector('input[name="berat"]').addEventListener('input', calculateTotal);
        document.querySelector('input[name="hargaPerKg"]').addEventListener('input', calculateTotal);
        document.querySelector('button[onclick="simpanSetoran()"]').addEventListener('click', simpanSetoran);
    }

    // Update harga berdasarkan jenis sampah
    function updateHarga() {
        const jenisSampah = document.querySelector('select[name="jenisSampah"]').value;
        const hargaInput = document.querySelector('input[name="hargaPerKg"]');
        
        if (jenisSampah && hargaSampah[jenisSampah]) {
            hargaInput.value = hargaSampah[jenisSampah];
            calculateTotal();
        }
    }

    // Hitung total harga
    function calculateTotal() {
        const berat = parseFloat(document.querySelector('input[name="berat"]').value) || 0;
        const hargaPerKg = parseFloat(document.querySelector('input[name="hargaPerKg"]').value) || 0;
        const total = berat * hargaPerKg;
        
        document.querySelector('.weight-value').textContent = berat.toFixed(1) + ' kg';
        document.querySelector('.text-2xl.font-bold.text-green-600').textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        currentSetoran.berat = berat;
        currentSetoran.hargaPerKg = hargaPerKg;
        currentSetoran.totalHarga = total;
    }

    // Simpan setoran
    function simpanSetoran() {
        // Validasi form
        const nasabah = document.querySelector('select[name="nasabah"]').value;
        const jenisSampah = document.querySelector('select[name="jenisSampah"]').value;
        const berat = parseFloat(document.querySelector('input[name="berat"]').value);
        const hargaPerKg = parseFloat(document.querySelector('input[name="hargaPerKg"]').value);
        const tanggal = document.querySelector('input[type="date"]').value;
        const keterangan = document.querySelector('textarea').value;

        // Validasi field wajib
        if (!nasabah) {
            showNotification('Pilih nama nasabah!', 'error');
            document.querySelector('select[name="nasabah"]').focus();
            return;
        }

        if (!jenisSampah) {
            showNotification('Pilih jenis sampah!', 'error');
            document.querySelector('select[name="jenisSampah"]').focus();
            return;
        }

        if (!berat || berat <= 0) {
            showNotification('Berat harus lebih dari 0!', 'error');
            document.querySelector('input[name="berat"]').focus();
            return;
        }

        if (!hargaPerKg || hargaPerKg <= 0) {
            showNotification('Harga per kg harus lebih dari 0!', 'error');
            document.querySelector('input[name="hargaPerKg"]').focus();
            return;
        }

        if (!tanggal) {
            showNotification('Pilih tanggal setoran!', 'error');
            document.querySelector('input[type="date"]').focus();
            return;
        }

        // Buat objek setoran baru
        const setoranBaru = {
            id: Date.now(),
            nasabah: nasabah,
            jenisSampah: jenisSampah,
            berat: berat,
            hargaPerKg: currentSetoran.hargaPerKg,
            totalHarga: currentSetoran.totalHarga,
            tanggal: tanggal,
            keterangan: keterangan,
            status: 'Pending',
            waktuInput: new Date().toLocaleString('id-ID')
        };

        // Tambahkan ke array data
        setoranData.unshift(setoranBaru);

        // Simpan ke localStorage
        localStorage.setItem('setoranData', JSON.stringify(setoranData));

        // Update tampilan
        updateDisplay();
        updateTable();

        // Reset form
        resetForm();

        // Tampilkan notifikasi sukses
        showNotification('Setoran berhasil disimpan!', 'success');
    }

    // Reset form
    function resetForm() {
        document.querySelector('select[name="nasabah"]').value = '';
        document.querySelector('select[name="jenisSampah"]').value = '';
        document.querySelector('input[name="berat"]').value = '';
        document.querySelector('input[name="hargaPerKg"]').value = '';
        document.querySelector('textarea').value = '';
        document.querySelector('input[type="date"]').value = new Date().toISOString().split('T')[0];
        
        // Reset display
        document.querySelector('.weight-value').textContent = '0.0 kg';
        document.querySelector('.text-2xl.font-bold.text-green-600').textContent = 'Rp 0';
    }

    // Update display informasi
    function updateDisplay() {
        const totalBerat = setoranData.reduce((sum, item) => sum + item.berat, 0);
        const totalHarga = setoranData.reduce((sum, item) => sum + item.totalHarga, 0);
        
        document.querySelector('.weight-value').textContent = totalBerat.toFixed(1) + ' kg';
        document.querySelector('.text-2xl.font-bold.text-green-600').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
        
        // Update riwayat hari ini
        updateRiwayatHariIni();
    }

    // Update riwayat setoran hari ini
    function updateRiwayatHariIni() {
        const today = new Date().toISOString().split('T')[0];
        const setoranHariIni = setoranData.filter(item => item.tanggal === today);
        const riwayatContainer = document.getElementById('riwayatHariIni');
        
        if (setoranHariIni.length === 0) {
            riwayatContainer.innerHTML = '<p class="text-sm text-gray-500 text-center">Belum ada setoran hari ini</p>';
            return;
        }
        
        riwayatContainer.innerHTML = setoranHariIni.slice(0, 3).map(item => `
            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                <span class="text-sm">${item.jenisSampah} - ${item.berat} kg</span>
                <span class="text-sm font-medium text-green-600">Rp ${item.totalHarga.toLocaleString('id-ID')}</span>
            </div>
        `).join('');
        
        if (setoranHariIni.length > 3) {
            riwayatContainer.innerHTML += `
                <div class="text-center text-xs text-gray-500">
                    +${setoranHariIni.length - 3} setoran lainnya
                </div>
            `;
        }
    }

    // Update tabel setoran
    function updateTable() {
        const tbody = document.querySelector('table tbody');
        tbody.innerHTML = '';

        if (setoranData.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Belum ada data setoran</p>
                    </td>
                </tr>
            `;
            return;
        }

        setoranData.slice(0, 10).forEach(setoran => {
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-2">${formatDate(setoran.tanggal)}</td>
                <td class="px-4 py-2">${setoran.nasabah}</td>
                <td class="px-4 py-2">${setoran.jenisSampah}</td>
                <td class="px-4 py-2">${setoran.berat} kg</td>
                <td class="px-4 py-2">Rp ${setoran.totalHarga.toLocaleString('id-ID')}</td>
                <td class="px-4 py-2">
                    <select onchange="updateStatus(${setoran.id}, this.value)" class="text-xs border rounded px-2 py-1 ${getStatusClass(setoran.status)}">
                        <option value="Pending" ${setoran.status === 'Pending' ? 'selected' : ''}>Pending</option>
                        <option value="Proses" ${setoran.status === 'Proses' ? 'selected' : ''}>Proses</option>
                        <option value="Selesai" ${setoran.status === 'Selesai' ? 'selected' : ''}>Selesai</option>
                    </select>
                </td>
                <td class="px-4 py-2">
                    <button onclick="hapusSetoran(${setoran.id})" class="text-red-600 hover:text-red-800 mr-2">
                        <i class="fas fa-trash"></i>
                    </button>
                    <button onclick="editSetoran(${setoran.id})" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    // Format tanggal
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }

    // Get status class
    function getStatusClass(status) {
        switch(status) {
            case 'Selesai': return 'bg-green-100 text-green-800';
            case 'Pending': return 'bg-yellow-100 text-yellow-800';
            case 'Proses': return 'bg-blue-100 text-blue-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }

    // Load data dari localStorage
    function loadSetoranData() {
        const savedData = localStorage.getItem('setoranData');
        if (savedData) {
            setoranData = JSON.parse(savedData);
        }
    }

    // Show notification
    function showNotification(message, type = 'info') {
        try {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
            
            if (type === 'success') {
                notification.classList.add('bg-green-500');
            } else if (type === 'error') {
                notification.classList.add('bg-red-500');
            } else {
                notification.classList.add('bg-blue-500');
            }
            
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        } catch (error) {
            console.error('Error showing notification:', error);
            alert(message);
        }
    }

    // Export data ke Excel (simulasi)
    function exportData() {
        if (setoranData.length === 0) {
            showNotification('Tidak ada data untuk diexport!', 'error');
            return;
        }

        // Buat CSV content
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Tanggal,Nasabah,Jenis Sampah,Berat (kg),Harga per kg,Total Harga,Status,Keterangan\n";
        
        setoranData.forEach(item => {
            csvContent += `${formatDate(item.tanggal)},${item.nasabah},${item.jenisSampah},${item.berat},${item.hargaPerKg},${item.totalHarga},${item.status},"${item.keterangan}"\n`;
        });

        // Download file
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `setoran_sampah_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        showNotification('Data berhasil diexport ke CSV!', 'success');
    }

    // Print data
    function printData() {
        if (setoranData.length === 0) {
            showNotification('Tidak ada data untuk dicetak!', 'error');
            return;
        }

        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Laporan Setoran Sampah</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        h1 { color: #05445E; }
                        .header { text-align: center; margin-bottom: 20px; }
                        .summary { margin: 20px 0; padding: 10px; background-color: #f9f9f9; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Laporan Setoran Sampah</h1>
                        <p>Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                    </div>
                    
                    <div class="summary">
                        <h3>Ringkasan:</h3>
                        <p>Total Setoran: ${setoranData.length}</p>
                        <p>Total Berat: ${setoranData.reduce((sum, item) => sum + item.berat, 0).toFixed(1)} kg</p>
                        <p>Total Nilai: Rp ${setoranData.reduce((sum, item) => sum + item.totalHarga, 0).toLocaleString('id-ID')}</p>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nasabah</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>Harga/kg</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${setoranData.map((item, index) => `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${formatDate(item.tanggal)}</td>
                                    <td>${item.nasabah}</td>
                                    <td>${item.jenisSampah}</td>
                                    <td>${item.berat}</td>
                                    <td>Rp ${item.hargaPerKg.toLocaleString('id-ID')}</td>
                                    <td>Rp ${item.totalHarga.toLocaleString('id-ID')}</td>
                                    <td>${item.status}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    // Reset semua data
    function resetAllData() {
        if (confirm('Apakah Anda yakin ingin menghapus semua data setoran? Tindakan ini tidak dapat dibatalkan.')) {
            setoranData = [];
            localStorage.removeItem('setoranData');
            updateDisplay();
            updateTable();
            showNotification('Semua data berhasil direset!', 'success');
        }
    }

    // Hapus setoran tertentu
    function hapusSetoran(id) {
        if (confirm('Apakah Anda yakin ingin menghapus setoran ini?')) {
            setoranData = setoranData.filter(item => item.id !== id);
            localStorage.setItem('setoranData', JSON.stringify(setoranData));
            updateDisplay();
            updateTable();
            showNotification('Setoran berhasil dihapus!', 'success');
        }
    }

    // Update status setoran
    function updateStatus(id, newStatus) {
        const setoran = setoranData.find(item => item.id === id);
        if (setoran) {
            setoran.status = newStatus;
            localStorage.setItem('setoranData', JSON.stringify(setoranData));
            updateTable();
            showNotification('Status berhasil diupdate!', 'success');
        }
    }

    // Reset semua data
    function resetAllData() {
        if (confirm('Apakah Anda yakin ingin menghapus semua data setoran? Tindakan ini tidak dapat dibatalkan.')) {
            setoranData = [];
            localStorage.removeItem('setoranData');
            updateDisplay();
            updateTable();
            showNotification('Semua data berhasil direset!', 'success');
        }
    }

    // Hapus setoran tertentu
    function hapusSetoran(id) {
        if (confirm('Apakah Anda yakin ingin menghapus setoran ini?')) {
            setoranData = setoranData.filter(item => item.id !== id);
            localStorage.setItem('setoranData', JSON.stringify(setoranData));
            updateDisplay();
            updateTable();
            showNotification('Setoran berhasil dihapus!', 'success');
        }
    }

    // Update status setoran
    function updateStatus(id, newStatus) {
        const setoran = setoranData.find(item => item.id === id);
        if (setoran) {
            setoran.status = newStatus;
            localStorage.setItem('setoranData', JSON.stringify(setoranData));
            updateTable();
            showNotification('Status berhasil diupdate!', 'success');
        }
    }

    // Edit setoran
    function editSetoran(id) {
        const setoran = setoranData.find(item => item.id === id);
        if (setoran) {
            // Isi form dengan data setoran
            document.querySelector('select[name="nasabah"]').value = setoran.nasabah;
            document.querySelector('select[name="jenisSampah"]').value = setoran.jenisSampah;
            document.querySelector('input[name="berat"]').value = setoran.berat;
            document.querySelector('input[name="hargaPerKg"]').value = setoran.hargaPerKg;
            document.querySelector('input[type="date"]').value = setoran.tanggal;
            document.querySelector('textarea').value = setoran.keterangan;
            
            // Update display
            calculateTotal();
            
            // Scroll ke form
            document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth' });
            
            showNotification('Data setoran dimuat untuk diedit!', 'info');
        }
    }

    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tools text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">${featureName} - Fitur Dalam Pengembangan</h3>
                <p class="text-gray-600 mb-4">Fitur ini sedang dalam tahap pengembangan. Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.</p>
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Mengerti
                </button>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Debug function untuk testing
    function debugData() {
        console.log('Setoran Data:', setoranData);
        console.log('Current Setoran:', currentSetoran);
        showNotification('Data debug telah dicetak ke console', 'info');
    }

    // Test function untuk menambah data dummy
    function addDummyData() {
        const dummyData = [
            {
                id: Date.now() + 1,
                nasabah: 'Ahmad Nasabah',
                jenisSampah: 'plastik',
                berat: 2.5,
                hargaPerKg: 5000,
                totalHarga: 12500,
                tanggal: new Date().toISOString().split('T')[0],
                keterangan: 'Setoran sampah plastik',
                status: 'Selesai',
                waktuInput: new Date().toLocaleString('id-ID')
            },
            {
                id: Date.now() + 2,
                nasabah: 'Siti Nasabah',
                jenisSampah: 'kertas',
                berat: 1.0,
                hargaPerKg: 3000,
                totalHarga: 3000,
                tanggal: new Date().toISOString().split('T')[0],
                keterangan: 'Setoran sampah kertas',
                status: 'Pending',
                waktuInput: new Date().toLocaleString('id-ID')
            }
        ];

        setoranData.unshift(...dummyData);
        localStorage.setItem('setoranData', JSON.stringify(setoranData));
        updateDisplay();
        updateTable();
        showNotification('Data dummy berhasil ditambahkan!', 'success');
    }
</script>
</script>
</body>
</html> 
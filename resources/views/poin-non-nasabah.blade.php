@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'poin';
@endphp



@section('content')
@section('additional-styles')
<style>
    :root {
        --primary-color: #05445E;
        --secondary-color: #f16728;
        --accent-color: #75E6DA;
        --success-color: #4ADE80;
        --danger-color: #FF5A5F;
        --background-color: #f8f9fc;
        --card-background: #ffffff;
        --text-color: #333;
        --subtle-text: #666;
        --shadow-light: rgba(0,0,0,0.05);
        --shadow-medium: rgba(0,0,0,0.1);
        --border-radius: 16px;
    }

    /* PoinMu Section Specific Styles */
    .poinmu-header-card {
        display: flex;
        background: var(--primary-color);
        border-radius: var(--border-radius);
        padding: 30px;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        width: 100%;
    }
    .poinmu-info-section {
        flex: 1; /* Take up 1/4 of space */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .poinmu-image-section {
        flex: 3; /* Take up 3/4 of space */
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .poinmu-image-section img {
        max-width: 100%;
        max-height: 200px; /* Adjust height as needed */
        object-fit: contain;
        filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.2));
    }

    .poinmu-user-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .poinmu-user-info .avatar {
        width: 60px;
        height: 60px;
        border: 3px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    .poinmu-user-info .user-name {
        font-size: 20px;
        font-weight: 600;
    }
    .poinmu-balance-info {
        text-align: left;
    }
    .poinmu-balance-info .title {
        font-size: 16px;
        opacity: 0.8;
        margin-bottom: 5px;
    }
    .poinmu-balance-info .amount {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 10px;
    }
    .poinmu-balance-info .last-updated {
        font-size: 14px;
        opacity: 0.7;
    }

    .poin-flow-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        width: 100%;
    }
    .poin-flow-card {
        background: var(--card-background);
        padding: 20px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-light);
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }
    .poin-flow-card .icon {
        font-size: 24px;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }
    .poin-flow-card .icon.in {
        background: var(--success-color);
    }
    .poin-flow-card .icon.out {
        background: var(--secondary-color);
    }
    .poin-flow-card .info h4 {
        font-size: 14px;
        color: var(--subtle-text);
        margin-bottom: 5px;
    }
    .poin-flow-card .info p {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Sections Container */
    .poinmu-content-wrapper > div {
        display: none; /* Hide all sections by default */
    }
    .poinmu-content-wrapper > div.active-section {
        display: block; /* Show only the active section */
    }

    /* E-Wallet Section */
    .ewallet-section {
        background: var(--card-background);
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-light);
        margin-bottom: 30px;
        width: 100%;
    }
    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-title i {
        color: var(--primary-color);
        font-size: 24px;
    }
    .section-title img {
        height: 30px;
        width: auto;
        margin-right: 10px;
        object-fit: contain;
    }
    .ewallet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 20px;
    }
    .ewallet-card {
        background: var(--card-background);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px var(--shadow-light);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #eee;
    }
    .ewallet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px var(--shadow-medium);
        border-color: var(--accent-color);
    }
    .ewallet-logo {
        height: 50px;
        width: 80px;
        object-fit: contain;
        margin-bottom: 15px;
    }
    .ewallet-name {
        font-weight: 600;
        color: var(--text-color);
        text-align: center;
        font-size: 14px;
    }
    .ewallet-icon {
        font-size: 40px;
        color: var(--primary-color);
        margin-bottom: 15px;
    }

    /* Nominal Selection Section */
    .nominal-section {
        background: var(--card-background);
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-light);
        margin-bottom: 30px;
    }
    .nominal-back {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 20px;
        cursor: pointer;
    }
    .nominal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    .nominal-item {
        background: var(--card-background);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px var(--shadow-light);
        transition: all 0.3s;
        border: 1px solid #eee;
        text-align: center;
        cursor: pointer;
    }
    .nominal-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px var(--shadow-medium);
        border-color: var(--accent-color);
    }
    .nominal-provider {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
    .nominal-currency {
        font-size: 14px;
        color: var(--subtle-text);
    }
    .nominal-amount {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-color);
        margin: 10px 0;
    }
    .nominal-points {
        background: linear-gradient(135deg, var(--primary-color) 0%, #0A3A60 100%);
        color: white;
        padding: 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Redemption Confirmation Section */
    .redemption-section {
        background: var(--card-background);
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-light);
        margin-bottom: 30px;
    }
    .redemption-summary {
        background: var(--background-color);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .redemption-summary .summary-info h4 {
        font-size: 18px;
        color: var(--primary-color);
        margin-bottom: 5px;
    }
    .redemption-summary .summary-info p {
        font-size: 14px;
        color: var(--subtle-text);
    }
    .redemption-summary .summary-points {
        background: var(--primary-color);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 8px;
    }
    .form-group input {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 16px;
        transition: border-color 0.3s;
    }
    .form-group input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 2px rgba(117, 230, 218, 0.2);
    }
    .redemption-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 25px;
    }
    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }
    .btn-primary {
        background: var(--primary-color);
        color: white;
    }
    .btn-primary:hover {
        background: #0A3A60;
        box-shadow: 0 4px 8px var(--shadow-medium);
    }
    .btn-secondary {
        background: var(--secondary-color);
        color: white;
    }
    .btn-secondary:hover {
        background: #e05e24;
        box-shadow: 0 4px 8px var(--shadow-medium);
    }
    .error-message {
        color: var(--danger-color);
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }
    .input-note {
        font-size: 12px;
        color: var(--subtle-text);
        margin-top: 5px;
    }

    /* Transaction History Section */
    .transaction-history-section {
        background: var(--card-background);
        padding: 30px;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-light);
        margin-bottom: 30px;
    }
    .history-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }
    .history-table th {
        text-align: left;
        padding: 15px 0;
        border-bottom: 1px solid #e0e0e0;
        color: var(--subtle-text);
        font-weight: 500;
        font-size: 14px;
        text-transform: uppercase;
    }
    .history-table td {
        padding: 20px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .transaction-item:last-child td {
        border-bottom: none;
    }
    .transaction-details {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .transaction-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
        border-radius: 10px;
        background: var(--background-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--primary-color);
    }
    .transaction-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-color);
    }
    .transaction-info p {
        font-size: 14px;
        color: var(--subtle-text);
    }
    .transaction-amount {
        font-size: 16px;
        font-weight: 600;
        white-space: nowrap;
    }
    .transaction-amount.positive {
        color: var(--success-color);
    }
    .transaction-amount.negative {
        color: var(--danger-color);
    }
    .back-to-poinmu {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 20px;
        cursor: pointer;
    }
    
    .print-button {
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
        font-weight: 600;
    }
    .print-button:hover {
        background-color: #0A3A60;
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

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    /* Footer */
    .footer {
        text-align: center;
        margin-top: 50px;
        font-size: 14px;
        color: var(--subtle-text);
    }
    .footer strong {
        font-weight: 700;
        color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .poin-flow-cards {
            flex-direction: column;
        }
        .poinmu-header-card {
            flex-direction: column;
        }
        .poinmu-image-section {
            justify-content: center;
            margin-top: 20px;
        }
    }
    @media (max-width: 768px) {
        .ewallet-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        .nominal-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
        .transaction-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
        .transaction-icon {
            margin-right: 0;
            margin-bottom: 5px;
        }
        .poinmu-user-info {
            flex-direction: column;
            text-align: center;
        }
    }
    @media (max-width: 480px) {
        .redemption-summary {
            flex-direction: column;
            align-items: flex-start;
        }
        .redemption-actions {
            flex-direction: column;
            width: 100%;
        }
        .btn {
            width: 100%;
        }
    }
</style>
@endsection

 {{-- Main Content Area --}}
 <div class="main-content-wrapper">
        <div class="content-container">
            <div class="poinmu-content-wrapper space-y-8">
                <div class="active-section" id="poinmuDashboard">
                    <div class="poinmu-header-card flex flex-col md:flex-row items-center justify-between bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <div class="poinmu-info-section flex-1 flex flex-col md:flex-row items-center gap-6">
                            <div class="flex flex-col items-center md:items-start">
                                <div class="poinmu-user-info flex items-center gap-3 mb-2">
                                    <img class="avatar w-14 h-14 rounded-full border-2 border-blue-200" src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile">
                                    <span class="user-name font-semibold text-lg text-gray-700">Hello, Nasabah!</span>
                                </div>
                                <div class="poinmu-balance-info">
                                    <div class="title text-gray-500">Total Poin Anda</div>
                                    <div class="amount text-3xl font-bold text-blue-700 mt-1 mb-1" id="user-points-display">4.297 Poin</div>
                                    <div class="last-updated text-xs text-gray-400">Terakhir Diperbarui: <span id="current-date-1"></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="poinmu-image-section flex justify-center items-center">
                            <img src="asset/img/poin.png" alt="Ilustrasi Poin Mu" class="w-28 h-28 object-contain rounded-xl shadow-md" />
                        </div>
                    </div>
                    <div class="poin-flow-cards flex gap-6 mb-6">
                        <div class="poin-flow-card flex-1 bg-gradient-to-r from-green-200 to-green-400 rounded-xl p-5 flex items-center gap-4 shadow">
                            <div class="icon in bg-white rounded-full p-3 shadow"><i class="fas fa-arrow-down text-green-600 text-xl"></i></div>
                            <div class="info">
                                <h4 class="font-semibold text-green-800">Poin Masuk</h4>
                                <p id="poin-in-display" class="text-lg font-bold">0 Poin</p>
                            </div>
                        </div>
                        <div class="poin-flow-card flex-1 bg-gradient-to-r from-red-200 to-red-400 rounded-xl p-5 flex items-center gap-4 shadow">
                            <div class="icon out bg-white rounded-full p-3 shadow"><i class="fas fa-arrow-up text-red-600 text-xl"></i></div>
                            <div class="info">
                                <h4 class="font-semibold text-red-800">Poin Keluar</h4>
                                <p id="poin-out-display" class="text-lg font-bold">0 Poin</p>
                            </div>
                        </div>
                    </div>
                    <div class="ewallet-section bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 mb-8 border border-blue-100">
                        <div class="text-center mb-8">
                            <h2 class="section-title text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3 flex items-center justify-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wallet text-white text-lg"></i>
                                </div>
                                Tukar Poin Mu
                            </h2>
                            <p class="text-gray-600 text-lg">Pilih e-wallet favoritmu dan tukarkan poin dengan mudah!</p>
                        </div>
                        
                        <div class="ewallet-grid grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <!-- Gopay -->
                            <div class="ewallet-card group bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-green-200 hover:border-green-400 hover:scale-105" onclick="openEwalletModal('gopay', 'Gopay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png" alt="Gopay" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-green-800 mb-2 group-hover:text-green-900 transition-colors">Gopay</h3>
                                    <p class="text-green-600 text-sm font-medium">GoPay Indonesia</p>
                                </div>
                            </div>
                            
                            <!-- OVO -->
                            <div class="ewallet-card group bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-purple-200 hover:border-purple-400 hover:scale-105" onclick="openEwalletModal('ovo', 'OVO', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-purple-800 mb-2 group-hover:text-purple-900 transition-colors">OVO</h3>
                                    <p class="text-purple-600 text-sm font-medium">OVO Digital</p>
                                </div>
                            </div>

                            <!-- DANA -->
                            <div class="ewallet-card group bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-blue-200 hover:border-blue-400 hover:scale-105" onclick="openEwalletModal('dana', 'DANA', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" alt="DANA" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-blue-800 mb-2 group-hover:text-blue-900 transition-colors">DANA</h3>
                                    <p class="text-blue-600 text-sm font-medium">DANA Indonesia</p>
                                </div>
                            </div>

                            <!-- ShopeePay -->
                            <div class="ewallet-card group bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-orange-200 hover:border-orange-400 hover:scale-105" onclick="openEwalletModal('shopeepay', 'ShopeePay', 'https://cdn-icons-png.flaticon.com/512/5969/5969059.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://bloguna.com/wp-content/uploads/2025/06/Logo-ShopeePay-PNG-CDR-SVG-EPS-Kualitas-HD.png" alt="ShopeePay" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-orange-800 mb-2 group-hover:text-orange-900 transition-colors">ShopeePay</h3>
                                    <p class="text-orange-600 text-sm font-medium">Shopee Digital</p>
                                </div>
                            </div>

                            <!-- LinkAja -->
                            <div class="ewallet-card group bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-teal-200 hover:border-teal-400 hover:scale-105" onclick="openEwalletModal('linkaja', 'LinkAja', 'https://cdn-icons-png.flaticon.com/512/5969/5969059.png')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-white rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjVlPZwKzWUoaxBpt6mJCixaNjGdbraFXJjCQcdVwuLsqz02UAAzAidd6y745xuXLvCtVPfhObIWVLPT6oZbS9U5iICX2XhEmBqbR-AGL-Edx3Iipq-4qGwLBAcqpB8Q5QQ3p0bG3By-7o/s2048/Logo+LinkAja.png" alt="LinkAja" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-teal-800 mb-2 group-hover:text-teal-900 transition-colors">LinkAja</h3>
                                    <p class="text-teal-600 text-sm font-medium">LinkAja Digital</p>
                                </div>
                            </div>
                            
                            <!-- Pulsa -->
                            <div class="ewallet-card group bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-indigo-200 hover:border-indigo-400 hover:scale-105" onclick="openEwalletModal('pulsa', 'Pulsa', 'placeholder')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-indigo-800 mb-2 group-hover:text-indigo-900 transition-colors">Pulsa</h3>
                                    <p class="text-indigo-600 text-sm font-medium">Mobile Credit</p>
                                </div>
                            </div>

                            <!-- Token Listrik -->
                            <div class="ewallet-card group bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border-2 border-yellow-200 hover:border-yellow-400 hover:scale-105" onclick="openEwalletModal('tokenlistrik', 'Token Listrik', 'placeholder')">
                                <div class="text-center">
                                    <div class="ewallet-logo-container w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-3 shadow-lg group-hover:shadow-xl transition-all duration-300 flex items-center justify-center">
                                        <i class="fas fa-bolt text-white text-2xl"></i>
                                    </div>
                                    <h3 class="ewallet-name text-lg font-bold text-yellow-800 mb-2 group-hover:text-yellow-900 transition-colors">Token Listrik</h3>
                                    <p class="text-yellow-600 text-sm font-medium">Electricity Token</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Info Section -->
                        <div class="mt-8 text-center">
                            <div class="inline-flex items-center gap-2 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                                <i class="fas fa-info-circle"></i>
                                <span>Semua e-wallet tersedia 24/7 • Proses instan • Tanpa biaya tersembunyi</span>
                            </div>
                        </div>
                    </div>

                    <!-- List Transaksi Section -->
                    <div class="transaction-section bg-white rounded-2xl shadow-lg p-6">
                        <h2 class="section-title text-xl font-bold text-blue-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </h2>
                        <div class="transaction-list">
                            <div id="transaction-history-list" class="space-y-3">
                                <!-- Transactions will be loaded here -->
                            </div>
                            <div id="no-history-message" class="text-center py-8 text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>Belum ada transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="footer text-center mt-10 text-gray-500">
                Created by <strong>TEK(G)</strong> | All Right Reserved
            </div>
        </div>
    </div>

    <!-- E-Wallet Modal -->
    <div id="ewalletModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <div class="flex items-center gap-3">
                        <img id="modalProviderLogo" src="" alt="Provider" class="w-8 h-8 rounded-lg">
                        <h3 class="text-xl font-bold text-gray-800" id="modalProviderName">E-Wallet</h3>
                    </div>
                    <button onclick="closeEwalletModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Step 1: Input Nominal -->
                <div id="step1" class="p-6">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-wallet text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Input Nominal</h4>
                        <p class="text-gray-600 text-sm">Masukkan nominal yang ingin ditukar</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                            <input type="number" id="ewalletAmount" placeholder="0" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors text-center text-lg font-semibold">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP/Rekening</label>
                            <input type="text" id="ewalletNumber" placeholder="Masukkan nomor HP atau rekening" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik</label>
                            <input type="text" id="ewalletOwner" placeholder="Masukkan nama pemilik rekening" 
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Poin yang akan ditukar:</span>
                                <span id="pointsToExchange" class="font-semibold text-blue-600">0 poin</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mt-2">
                                <span class="text-gray-600">Sisa poin:</span>
                                <span id="remainingPoints" class="font-semibold text-green-600">0 poin</span>
                            </div>
                        </div>

                        <button onclick="nextToStep2()" id="nextStep1Btn" 
                                class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            Lanjutkan
                        </button>
                    </div>
                </div>

                <!-- Step 2: Konfirmasi -->
                <div id="step2" class="p-6 hidden">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Penukaran</h4>
                        <p class="text-gray-600 text-sm">Periksa detail penukaran Anda</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Provider:</span>
                                <span id="confirmProvider" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nomor HP/Rekening:</span>
                                <span id="confirmNumber" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nama Pemilik:</span>
                                <span id="confirmOwner" class="font-semibold text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Nominal E-Wallet:</span>
                                <span id="confirmAmount" class="font-semibold text-gray-800">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Poin yang ditukar:</span>
                                <span id="confirmPoints" class="font-semibold text-blue-600">0 poin</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Biaya admin:</span>
                                <span id="confirmAdminFee" class="font-semibold text-gray-800">Rp 0</span>
                            </div>
                            <hr class="border-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-semibold">Total:</span>
                                <span id="confirmTotal" class="font-bold text-lg text-blue-600">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <button onclick="backToStep1()" 
                                class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                            Kembali
                        </button>
                        <button onclick="confirmExchange()" 
                                class="flex-1 bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-blue-700 transition-all duration-200">
                            Konfirmasi
                        </button>
                    </div>
                </div>

                <!-- Step 3: Sukses -->
                <div id="step3" class="p-6 hidden">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Penukaran Berhasil!</h4>
                        <p class="text-gray-600 text-sm">E-wallet telah ditambahkan ke akun Anda</p>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                            <div>
                                <h5 class="font-semibold text-green-800">Transaksi Selesai</h5>
                                <p class="text-green-600 text-sm">Poin berhasil ditukar ke e-wallet</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 mb-6">
                        <h6 class="font-semibold text-gray-800 mb-3">Detail Transaksi:</h6>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Transaksi:</span>
                                <span id="transactionId" class="font-mono text-gray-800">TRX-001</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span id="transactionDate" class="text-gray-800">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="text-green-600 font-semibold">Berhasil</span>
                            </div>
                        </div>
                    </div>

                    <button onclick="closeEwalletModal()" 
                            class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
        <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-500" style="width: 0%"></div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <script>
        // E-Wallet Modal Functions
        let currentStep = 1;
        let ewalletData = {
            provider: '',
            providerName: '',
            providerLogo: '',
            amount: 0,
            points: 0,
            adminFee: 0
        };

        // User data
        let userPoints = 4297; // Poin user saat ini
        let transactions = []; // Array untuk menyimpan transaksi

        // Add some dummy transactions for testing
        function addDummyTransactions() {
            const dummyTransactions = [
                {
                    id: 'TRX-001',
                    provider: 'Gopay',
                    number: '081234567890',
                    owner: 'John Doe',
                    amount: 50000,
                    points: 500,
                    date: '15 Januari 2025, 14:30',
                    status: 'Berhasil'
                },
                {
                    id: 'TRX-002',
                    provider: 'OVO',
                    number: '081234567891',
                    owner: 'Jane Smith',
                    amount: 25000,
                    points: 250,
                    date: '12 Januari 2025, 09:15',
                    status: 'Berhasil'
                },
                {
                    id: 'TRX-003',
                    provider: 'DANA',
                    number: '081234567892',
                    owner: 'Bob Johnson',
                    amount: 100000,
                    points: 1000,
                    date: '10 Januari 2025, 16:45',
                    status: 'Berhasil'
                }
            ];
            
            transactions = dummyTransactions;
            renderTransactionHistory();
            
            // Also update the user points to be more realistic
            userPoints = 2500; // Set a realistic starting point
            document.getElementById('user-points-display').textContent = userPoints + ' Poin';
        }

        function openEwalletModal(providerId, providerName, providerLogo) {
            ewalletData.provider = providerId;
            ewalletData.providerName = providerName;
            ewalletData.providerLogo = providerLogo;
            
            // Update modal header
            document.getElementById('modalProviderLogo').src = providerLogo;
            document.getElementById('modalProviderName').textContent = providerName;
            
            // Reset modal
            resetEwalletModal();
            
            // Show modal
            document.getElementById('ewalletModal').classList.remove('hidden');
            
            // Update progress bar
            updateProgressBar();
        }

        function closeEwalletModal() {
            document.getElementById('ewalletModal').classList.add('hidden');
            resetEwalletModal();
        }

        function resetEwalletModal() {
            currentStep = 1;
            
            // Hide all steps
            document.getElementById('step1').classList.remove('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');
            
            // Reset form
            document.getElementById('ewalletAmount').value = '';
            document.getElementById('ewalletNumber').value = '';
            document.getElementById('ewalletOwner').value = '';
            document.getElementById('pointsToExchange').textContent = '0 poin';
            document.getElementById('remainingPoints').textContent = userPoints + ' poin';
            
            // Reset data
            ewalletData.amount = 0;
            ewalletData.points = 0;
            ewalletData.adminFee = 0;
            ewalletData.number = '';
            ewalletData.owner = '';
            
            // Disable next button
            document.getElementById('nextStep1Btn').disabled = true;
            
            // Update progress bar
            updateProgressBar();
        }

        function updateProgressBar() {
            const progress = (currentStep / 3) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        }

        function nextToStep2() {
            const amount = parseInt(document.getElementById('ewalletAmount').value);
            const number = document.getElementById('ewalletNumber').value.trim();
            const owner = document.getElementById('ewalletOwner').value.trim();
            
            if (amount <= 0) {
                alert('Masukkan nominal yang valid');
                return;
            }
            
            if (!number) {
                alert('Masukkan nomor HP atau rekening');
                return;
            }
            
            if (!owner) {
                alert('Masukkan nama pemilik rekening');
                return;
            }
            
            // Calculate points and admin fee
            ewalletData.amount = amount;
            ewalletData.points = Math.ceil(amount / 100); // 1 poin = Rp 100
            ewalletData.adminFee = Math.ceil(amount * 0.02); // 2% admin fee
            ewalletData.number = number;
            ewalletData.owner = owner;
            
            // Check if user has enough points
            if (ewalletData.points > userPoints) {
                alert('Poin Anda tidak cukup untuk nominal ini');
                return;
            }
            
            // Update confirmation screen
            document.getElementById('confirmProvider').textContent = ewalletData.providerName;
            document.getElementById('confirmNumber').textContent = number;
            document.getElementById('confirmOwner').textContent = owner;
            document.getElementById('confirmAmount').textContent = 'Rp ' + amount.toLocaleString('id-ID');
            document.getElementById('confirmPoints').textContent = ewalletData.points + ' poin';
            document.getElementById('confirmAdminFee').textContent = 'Rp ' + ewalletData.adminFee.toLocaleString('id-ID');
            document.getElementById('confirmTotal').textContent = 'Rp ' + (amount + ewalletData.adminFee).toLocaleString('id-ID');
            
            // Hide step 1, show step 2
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            
            currentStep = 2;
            updateProgressBar();
        }

        function backToStep1() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            
            currentStep = 1;
            updateProgressBar();
        }

        function confirmExchange() {
            // Deduct points from user
            userPoints -= ewalletData.points;
            
            // Generate transaction ID
            const transactionId = 'TRX-' + Date.now().toString().slice(-6);
            
            // Add to transaction history
            addToTransactionHistory(transactionId, ewalletData.amount, ewalletData.points, new Date());
            
            // Update user points display
            document.getElementById('user-points-display').textContent = userPoints + ' Poin';
            document.getElementById('remainingPoints').textContent = userPoints + ' poin';
            
            // Update transaction details in step 3
            document.getElementById('transactionId').textContent = transactionId;
            document.getElementById('transactionDate').textContent = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Hide step 2, show step 3
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
            
            currentStep = 3;
            updateProgressBar();
        }

        function addToTransactionHistory(id, amount, points, date) {
            const transaction = {
                id: id,
                provider: ewalletData.providerName,
                number: ewalletData.number,
                owner: ewalletData.owner,
                amount: amount,
                points: points,
                date: date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }),
                status: 'Berhasil'
            };
            
            transactions.unshift(transaction);
            renderTransactionHistory();
            updatePointsDisplay(); // Update points display after adding new transaction
        }

        function renderTransactionHistory() {
            const transactionList = document.getElementById('transaction-history-list');
            const noHistoryMessage = document.getElementById('no-history-message');
            
            if (transactions.length === 0) {
                noHistoryMessage.classList.remove('hidden');
                return;
            }
            
            noHistoryMessage.classList.add('hidden');
            transactionList.innerHTML = '';
            
            transactions.forEach(transaction => {
                const transactionItem = document.createElement('div');
                transactionItem.className = 'bg-gray-50 rounded-xl p-4 border border-gray-200';
                transactionItem.innerHTML = `
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wallet text-white text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-800">${transaction.provider}</h5>
                                    <p class="text-sm text-gray-600">ID: ${transaction.id}</p>
                                    <p class="text-sm text-gray-600">${transaction.number} - ${transaction.owner}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">${transaction.date}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-600">Rp ${transaction.amount.toLocaleString('id-ID')}</div>
                            <div class="text-sm text-gray-600">-${transaction.points} poin</div>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">${transaction.status}</span>
                        </div>
                    </div>
                `;
                transactionList.appendChild(transactionItem);
            });
        }

        // Function to update current date/time
        function updateDateTime() {
            const now = new Date();
            const dateString = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const dateElement = document.getElementById('current-date-1');
            if (dateElement) {
                dateElement.textContent = dateString;
            }
        }
        
        // Function to calculate and update points display
        function updatePointsDisplay() {
            let totalPointsIn = 0;
            let totalPointsOut = 0;
            
            // Calculate points from transaction history
            transactions.forEach(transaction => {
                if (transaction.status === 'Berhasil') {
                    // For now, assume all successful transactions are points out (e-wallet exchanges)
                    // In a real system, you'd have different transaction types
                    totalPointsOut += transaction.points;
                }
            });
            
            // For demo purposes, let's add some sample points in (you can modify this logic)
            // In a real system, this would come from actual point earning transactions
            totalPointsIn = userPoints + totalPointsOut; // Total points user has + what they've spent
            
            // Update the display
            document.getElementById('poin-in-display').textContent = totalPointsIn.toLocaleString('id-ID') + ' Poin';
            document.getElementById('poin-out-display').textContent = totalPointsOut.toLocaleString('id-ID') + ' Poin';
        }
        
        // Real-time calculation for step 1
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('ewalletAmount');
            if (amountInput) {
                amountInput.addEventListener('input', function() {
                    const amount = parseInt(this.value) || 0;
                    const points = Math.ceil(amount / 100);
                    const remaining = userPoints - points;
                    
                    document.getElementById('pointsToExchange').textContent = points + ' poin';
                    document.getElementById('remainingPoints').textContent = remaining + ' poin';
                    
                    // Enable/disable next button
                    const nextBtn = document.getElementById('nextStep1Btn');
                    if (amount > 0 && points <= userPoints) {
                        nextBtn.disabled = false;
                        nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        nextBtn.disabled = true;
                        nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
            
            // Initialize transaction history with dummy data
            addDummyTransactions();
            updatePointsDisplay(); // Update points display after loading transactions
        });

        // Close modal when clicking outside
        document.getElementById('ewalletModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEwalletModal();
            }
        });

        // Toast notification function
        function showToast(type, title, message) {
            // Simple alert for now, can be enhanced with proper toast
            alert(`${title}: ${message}`);
        }
    </script>
</div>
@endsection
@extends('layouts.non-nasabah-layout')

@php
$activeMenu = 'poin';
@endphp

@section('title', 'Poin Mu - Bijak Sampah')

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

@section('content')
<div class="p-6" style="padding-top: 60px; width: 100%; max-width: 100%;">
    <div class="poinmu-content-wrapper">
        <div class="active-section" id="poinmuDashboard">
            <div class="poinmu-header-card">
                <div class="poinmu-info-section">
                    <div>
                        <div class="poinmu-user-info">
                            <img class="avatar" src="https://ui-avatars.com/api/?name=Non-Nasabah&background=75E6DA&color=05445E" alt="Profile">
                            <span class="user-name">Hello, Non-Nasabah!</span>
                        </div>
                        <div class="poinmu-balance-info">
                            <div class="title">Total Poin Anda</div>
                            <div class="amount" id="user-points-display">4.297 Poin</div>
                            <div class="last-updated">Terakhir Diperbarui: <span id="current-date-1"></span></div>
                        </div>
                    </div>
                </div>
                <div class="poinmu-image-section">
                     <img src="https://rbtv.disway.id/upload/7973c3e23499d8cb1b1ad11767042315.jpg" alt="Ilustrasi Poin Mu" />
                </div>
            </div>

            <div class="poin-flow-cards">
                <div class="poin-flow-card">
                    <div class="icon in"><i class="fas fa-arrow-down"></i></div>
                    <div class="info">
                        <h4>Poin Masuk</h4>
                        <p id="poin-in-display">0 Poin</p>
                    </div>
                </div>
                <div class="poin-flow-card">
                    <div class="icon out"><i class="fas fa-arrow-up"></i></div>
                    <div class="info">
                        <h4>Poin Keluar</h4>
                        <p id="poin-out-display">0 Poin</p>
                    </div>
                </div>
            </div>
            
            <div class="ewallet-section" id="ewalletSelectionSection">
                <h2 class="section-title">
                    <i class="fas fa-wallet"></i> Tukar Poin Mu
                </h2>
                
                <div class="ewallet-grid">
                    <div class="ewallet-card" data-provider-id="gopay" onclick="showNominalSelection('gopay', 'Gopay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png')">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/1200px-Gopay_logo.svg.png" alt="Gopay" class="ewallet-logo">
                        <span class="ewallet-name">Gopay</span>
                    </div>
                    
                    <div class="ewallet-card" data-provider-id="ovo" onclick="showNominalSelection('ovo', 'OVO', 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png')">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/1200px-Logo_ovo_purple.svg.png" alt="OVO" class="ewallet-logo">
                        <span class="ewallet-name">OVO</span>
                    </div>

                    <div class="ewallet-card" data-provider-id="dana" onclick="showNominalSelection('dana', 'DANA', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png')">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/1200px-Logo_dana_blue.svg.png" alt="DANA" class="ewallet-logo">
                        <span class="ewallet-name">DANA</span>
                    </div>

                    <div class="ewallet-card" data-provider-id="shopeepay" onclick="showNominalSelection('shopeepay', 'ShopeePay', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/ShopeePay_logo.svg/1200px-ShopeePay_logo.svg.png')">
                        <img src="https://bloguna.com/wp-content/uploads/2025/06/Logo-ShopeePay-PNG-CDR-SVG-EPS-Kualitas-HD.png" alt="ShopeePay" class="ewallet-logo">
                        <span class="ewallet-name">ShopeePay</span>
                    </div>

                    <div class="ewallet-card" data-provider-id="linkaja" onclick="showNominalSelection('linkaja', 'LinkAja', 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/LinkAja.svg/1200px-LinkAja.svg.png')">
                        <img src="https://assets-a1.kompasiana.com/items/album/2023/04/13/beli-saldo-paypal-via-linkaja-6437c7be4addee244748a212.png" alt="LinkAja" class="ewallet-logo">
                        <span class="ewallet-name">LinkAja</span>
                    </div>
                    
                    <div class="ewallet-card" data-provider-id="pulsa" onclick="showNominalSelection('pulsa', 'Pulsa', 'placeholder')">
                        <i class="fas fa-mobile-alt ewallet-icon"></i>
                        <span class="ewallet-name">Pulsa</span>
                    </div>

                    <div class="ewallet-card" data-provider-id="tokenlistrik" onclick="showNominalSelection('tokenlistrik', 'Token Listrik', 'placeholder')">
                        <i class="fas fa-bolt ewallet-icon"></i>
                        <span class="ewallet-name">Token Listrik</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="nominal-section" id="nominalSelectionSection">
            <a class="nominal-back" onclick="showSection('poinmuDashboard')"><i class="fas fa-arrow-left"></i> Kembali</a>
            <h2 class="section-title">
                Pilih Nominal <span id="nominal-provider-name"></span>
            </h2>
            <div class="nominal-grid" id="nominal-grid">
                </div>
        </div>

        <div class="redemption-section" id="redemptionConfirmationSection">
            <a class="nominal-back" onclick="showSection('nominalSelectionSection')"><i class="fas fa-arrow-left"></i> Kembali</a>
            <h2 class="section-title">Konfirmasi Penukaran</h2>
            
            <div class="redemption-summary">
                <div class="summary-info">
                    <h4>Poin yang Ditukar</h4>
                    <p id="summary-points-text">1.000 Poin</p>
                </div>
                <div class="summary-points">
                    <span id="summary-points-amount">1000 Poin</span>
                </div>
            </div>

            <div class="form-group">
                <label for="recipient-number">Nomor Tujuan</label>
                <input type="text" id="recipient-number" placeholder="Masukkan nomor tujuan">
                <span class="error-message" id="number-error">Nomor tujuan tidak valid.</span>
            </div>

            <div class="form-group">
                <label for="bijaksampah-pin">PIN BijakSampah Pay</label>
                <input type="password" id="bijaksampah-pin" placeholder="PIN saat kamu register/login" maxlength="6">
                <span class="error-message" id="pin-error">PIN salah.</span>
            </div>

            <div class="redemption-actions">
                <button class="btn btn-secondary" onclick="showSection('poinmuDashboard')">Batalkan</button>
                <button class="btn btn-primary" id="confirm-redemption-btn">Konfirmasi Penukaran</button>
            </div>
        </div>

        <div class="transaction-history-section" id="transactionHistorySection">
            <div class="history-controls">
                <h2 class="section-title"><i class="fas fa-history"></i> Riwayat Transaksi</h2>
                <div class="history-actions">
                    <button class="btn print-button" id="print-history-btn">
                        <i class="fas fa-print"></i> Cetak Riwayat
                    </button>
                </div>
            </div>
            
            <div class="transaction-list-container">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-history-list">
                        </tbody>
                </table>
                <div id="no-history-message" style="text-align: center; color: var(--subtle-text); padding: 30px; display: none;">
                    Belum ada riwayat transaksi.
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        Created by <strong>TEK(G)</strong> | All Right Reserved
    </div>
</div>

{{-- Modal untuk menu dalam pengembangan --}}
<div class="modal" id="developmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Fitur Dalam Pengembangan</h3>
            <button class="close-modal" id="closeDevelopmentModal">&times;</button>
        </div>
        <div class="modal-body">
            <div style="text-align: center; padding: 20px;">
                <i class="fas fa-tools" style="font-size: 48px; color: #05445E; margin-bottom: 20px;"></i>
                <h4 style="color: #05445E; font-size: 18px; margin-bottom: 10px;">Fitur Sedang Dikembangkan</h4>
                <p style="color: #666; font-size: 14px; line-height: 1.6;">
                    Fitur ini sedang dalam tahap pengembangan. 
                    Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
                </p>
                <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <p style="color: #05445E; font-size: 12px; margin: 0;">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeDevModal">Mengerti</button>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
<script>
    // Data Dummy
    let userPoints = 4297; // Poin awal pengguna
    let transactions = []; // Riwayat transaksi kosong

    const nominalData = {
        gopay: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 150000, points: 18735 },
            { amount: 200000, points: 24980 }
        ],
        ovo: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 150000, points: 18735 },
            { amount: 200000, points: 24980 }
        ],
        dana: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 150000, points: 18735 },
            { amount: 200000, points: 24980 }
        ],
        shopeepay: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 150000, points: 18735 },
            { amount: 200000, points: 24980 }
        ],
        linkaja: [
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 150000, points: 18735 },
            { amount: 200000, points: 24980 }
        ],
        pulsa: [
            { amount: 5000, points: 625 },
            { amount: 10000, points: 1249 },
            { amount: 15000, points: 1874 },
            { amount: 20000, points: 2498 },
            { amount: 30000, points: 3747 },
            { amount: 35000, points: 4372 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 }
        ],
        tokenlistrik: [
            { amount: 20000, points: 2498 },
            { amount: 50000, points: 6245 },
            { amount: 100000, points: 12490 },
            { amount: 250000, points: 31225 },
            { amount: 500000, points: 62450 }
        ]
    };

    let selectedProvider = {};
    let selectedNominal = {};

    // Helper function to format points
    function formatPoints(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Function to render balances and point flow cards
    function renderBalances() {
        document.getElementById('user-points-display').innerText = `${formatPoints(userPoints)} Poin`;
        
        const poinIn = transactions.filter(t => t.amount > 0).reduce((sum, t) => sum + t.amount, 0);
        const poinOut = transactions.filter(t => t.amount < 0).reduce((sum, t) => sum + Math.abs(t.amount), 0);
        
        document.getElementById('poin-in-display').innerText = `${formatPoints(poinIn)} Poin`;
        document.getElementById('poin-out-display').innerText = `${formatPoints(poinOut)} Poin`;
    }

    // Function to show a specific section and hide others
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.poinmu-content-wrapper > div');
        sections.forEach(section => {
            section.classList.remove('active-section');
        });
        document.getElementById(sectionId).classList.add('active-section');
        updateActiveMenu(sectionId);
        updatePageTitle(sectionId);
    }

    // Function to update the active menu item in the sidebar
    function updateActiveMenu(activeSectionId) {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.classList.remove('active');
        });

        if (activeSectionId === 'poinmuDashboard' || activeSectionId === 'ewalletSelectionSection' || activeSectionId === 'nominalSelectionSection' || activeSectionId === 'redemptionConfirmationSection') {
            document.getElementById('poinmu-menu').classList.add('active');
        } else if (activeSectionId === 'transactionHistorySection') {
            document.getElementById('history-menu').classList.add('active');
        }
    }

    // Function to update the page title
    function updatePageTitle(activeSectionId) {
        const pageTitleElement = document.getElementById('page-title-text');
        if (activeSectionId === 'poinmuDashboard' || activeSectionId === 'ewalletSelectionSection') {
            pageTitleElement.innerText = 'Poin Mu';
        } else if (activeSectionId === 'transactionHistorySection') {
            pageTitleElement.innerText = 'Riwayat Transaksi';
        } else if (activeSectionId === 'nominalSelectionSection') {
            pageTitleElement.innerText = `Pilih Nominal ${selectedProvider.name || ''}`;
        } else if (activeSectionId === 'redemptionConfirmationSection') {
            pageTitleElement.innerText = 'Konfirmasi Penukaran';
        }
    }

    // Function to render nominal selection
    function showNominalSelection(providerId, providerName, providerLogo) {
        selectedProvider = { id: providerId, name: providerName, logo: providerLogo };
        const nominals = nominalData[providerId];
        const nominalGrid = document.getElementById('nominal-grid');
        nominalGrid.innerHTML = '';

        const nominalTitle = document.getElementById('nominal-provider-name');
        nominalTitle.innerText = providerName;

        if (!nominals) {
            nominalGrid.innerHTML = '<p style="text-align: center; color: var(--subtle-text);">Nominal tidak tersedia.</p>';
            return;
        }

        nominals.forEach(nominal => {
            const item = document.createElement('div');
            item.className = 'nominal-item';
            item.innerHTML = `
                <div class="nominal-provider">${providerName}</div>
                <div class="nominal-currency">Rp</div>
                <div class="nominal-amount">${formatPoints(nominal.amount)}</div>
                <div class="nominal-points">${formatPoints(nominal.points)} Poin</div>
            `;
            item.onclick = () => showConfirmation(nominal);
            nominalGrid.appendChild(item);
        });

        showSection('nominalSelectionSection');
    }

    // Function to show confirmation screen
    function showConfirmation(nominal) {
        selectedNominal = nominal;
        document.getElementById('summary-points-text').innerText = `${formatPoints(selectedNominal.points)} Poin`;
        document.getElementById('summary-points-amount').innerText = `${formatPoints(selectedNominal.points)} Poin`;
        
        document.getElementById('confirm-redemption-btn').onclick = () => {
            const recipientNumber = document.getElementById('recipient-number').value;
            const pin = document.getElementById('bijaksampah-pin').value;
            
            document.getElementById('number-error').style.display = 'none';
            document.getElementById('pin-error').style.display = 'none';

            if (recipientNumber.trim() === '') {
                document.getElementById('number-error').innerText = 'Nomor tujuan tidak boleh kosong.';
                document.getElementById('number-error').style.display = 'block';
                return;
            }
            if (pin !== '123456') { // PIN dummy
                document.getElementById('pin-error').innerText = 'PIN yang Anda masukkan salah.';
                document.getElementById('pin-error').style.display = 'block';
                return;
            }

            redeemPointsToEwallet(recipientNumber, pin);
        };

        showSection('redemptionConfirmationSection');
    }

    // Function to redeem points to e-wallet
    function redeemPointsToEwallet(recipientNumber, pin) {
        if (userPoints >= selectedNominal.points) {
            userPoints -= selectedNominal.points;
            const transactionDescription = `Penukaran ${new Intl.NumberFormat('id-ID').format(selectedNominal.amount)} ke ${selectedProvider.name} (${recipientNumber})`;
            const transactionAmount = -selectedNominal.points;
            addTransaction(transactionDescription, transactionAmount);
            
            alert('Penukaran berhasil! Silakan cek riwayat transaksi Anda.');
            
            renderBalances();
            showSection('transactionHistorySection');
        } else {
            alert('Poin Anda tidak cukup untuk melakukan penukaran ini.');
        }
    }

    // Function to add a new transaction
    function addTransaction(description, amount) {
        const today = new Date();
        const date = today.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        transactions.unshift({
            date: date,
            description: description,
            amount: amount
        });
        renderTransactionHistory();
    }

    // Function to render the transaction history list
    function renderTransactionHistory() {
        const transactionList = document.getElementById('transaction-history-list');
        const noHistoryMessage = document.getElementById('no-history-message');
        transactionList.innerHTML = '';
        
        if (transactions.length === 0) {
            noHistoryMessage.style.display = 'block';
            return;
        } else {
            noHistoryMessage.style.display = 'none';
        }

        transactions.forEach(transaction => {
            const row = document.createElement('tr');
            row.className = 'transaction-item';
            const amountClass = transaction.amount > 0 ? 'positive' : 'negative';
            const formattedAmount = transaction.amount > 0 ?
                `+${formatPoints(transaction.amount)} Poin` :
                `${formatPoints(transaction.amount)} Poin`;

            row.innerHTML = `
                <td>
                    <div class="transaction-details">
                        <div class="transaction-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="transaction-info">
                            <h4>${transaction.description}</h4>
                            <p>${transaction.amount > 0 ? 'Pemasukan' : 'Pengeluaran'}</p>
                        </div>
                    </div>
                </td>
                <td>${transaction.date}</td>
                <td style="text-align: right;">
                    <span class="transaction-amount ${amountClass}">${formattedAmount}</span>
                </td>
            `;
            transactionList.appendChild(row);
        });
    }

    // Function to print transaction history
    function printTransactionHistory() {
        const containerToPrint = document.getElementById('transactionHistorySection');
        if (transactions.length === 0) {
             alert('Tidak ada riwayat transaksi yang dapat dicetak.');
             return;
        }
        
        html2canvas(containerToPrint, { scale: 2 }).then(canvas => {
            const imageData = canvas.toDataURL('image/png');
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Cetak Riwayat Transaksi</title>
                    <style>
                        @media print {
                            body { margin: 0; }
                            img { max-width: 100%; height: auto; display: block; }
                        }
                    </style>
                </head>
                <body>
                    <img src="${imageData}" onload="window.print(); window.close();" />
                </body>
                </html>
            `);
            printWindow.document.close();
        });
    }
    
    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.getElementById('developmentModal');
        const title = modal.querySelector('.modal-title');
        title.textContent = `${featureName} - Fitur Dalam Pengembangan`;
        modal.style.display = 'flex';
    }

    // Close Development Modal
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('closeDevelopmentModal').addEventListener('click', function() {
            document.getElementById('developmentModal').style.display = 'none';
        });

        document.getElementById('closeDevModal').addEventListener('click', function() {
            document.getElementById('developmentModal').style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            const developmentModal = document.getElementById('developmentModal');
            if (event.target === developmentModal) {
                developmentModal.style.display = 'none';
            }
        });
    });

    // Event listeners
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date();
        const formattedDate = today.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('current-date-1').innerText = formattedDate;
        renderBalances();
        renderTransactionHistory();
        showSection('poinmuDashboard');
        
        document.getElementById('print-history-btn').addEventListener('click', printTransactionHistory);
    });
</script>
@endsection
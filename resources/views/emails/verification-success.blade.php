<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Nasabah Berhasil - Bijak Sampah</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fc;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #75E6DA;
        }
        .logo {
            width: 150px;
            height: auto;
            margin-bottom: 15px;
        }
        .title {
            color: #05445E;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
        }
        .success-icon {
            font-size: 48px;
            color: #2b8a3e;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #05445E;
        }
        .message {
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.8;
        }
        .info-section {
            background-color: #f0f7ff;
            border: 1px solid #75E6DA;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .info-title {
            font-weight: bold;
            color: #05445E;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        .info-value {
            color: #05445E;
            font-weight: 500;
        }
        .trash-bin-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .trash-bin-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 15px;
            font-size: 14px;
            color: #888;
        }
        .highlight {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .highlight-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
        }
        .highlight-content {
            color: #856404;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1 class="title">Verifikasi Nasabah Berhasil!</h1>
            <p class="subtitle">Selamat datang di Bijak Sampah</p>
        </div>

        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $name }}</strong>,
            </div>

            <div class="message">
                Selamat! Verifikasi data nasabah Anda telah berhasil disetujui. 
                Akun Anda telah aktif dan siap digunakan untuk layanan Bijak Sampah.
            </div>

            <div class="info-section">
                <div class="info-title">📋 Informasi Akun Nasabah</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap:</div>
                        <div class="info-value">{{ $name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email:</div>
                        <div class="info-value">{{ $email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. Rekening:</div>
                        <div class="info-value">{{ $accountNumber }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">ID Alat:</div>
                        <div class="info-value">{{ $deviceId }}</div>
                    </div>
                </div>
            </div>

            <div class="trash-bin-info">
                <div class="trash-bin-title">🗑️ Informasi Bak Sampah</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Jenis Bak Sampah:</div>
                        <div class="info-value">{{ $jenisBak }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. Bak Sampah:</div>
                        <div class="info-value">{{ $noBak }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">ID Unit Bak:</div>
                        <div class="info-value">{{ $deviceId }}</div>
                    </div>
                </div>
            </div>

            <div class="highlight">
                <div class="highlight-title">⚠️ Penting!</div>
                <div class="highlight-content">
                    <strong>Bak sampah akan segera dikirimkan ke alamat Anda.</strong><br>
                    Pastikan alamat pengiriman sudah benar dan ada yang menerima saat pengiriman.
                    Tim kami akan menghubungi Anda untuk konfirmasi jadwal pengiriman.
                </div>
            </div>

            <div class="message">
                <strong>Langkah selanjutnya:</strong>
                <ol style="margin-top: 10px; padding-left: 20px;">
                    <li>Tim kami akan menghubungi Anda dalam 1-2 hari kerja</li>
                    <li>Bak sampah akan dikirimkan ke alamat terdaftar</li>
                    <li>Setelah instalasi, Anda dapat mulai menggunakan layanan</li>
                    <li>Download aplikasi Bijak Sampah untuk monitoring</li>
                </ol>
            </div>
        </div>

        <div class="footer">
            <p><strong>Terima kasih telah bergabung dengan Bijak Sampah!</strong></p>
            <p>Bersama kita wujudkan lingkungan yang lebih bersih dan berkelanjutan.</p>
            
            <div class="contact-info">
                <p><strong>Hubungi Kami:</strong></p>
                <p>📧 Email: info@bijaksampah.com</p>
                <p>📞 Telepon: (021) 1234-5678</p>
                <p>🌐 Website: www.bijaksampah.com</p>
            </div>
        </div>
    </div>
</body>
</html> 
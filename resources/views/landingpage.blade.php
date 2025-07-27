<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bijak Sampah - Solusi Pengelolaan Sampah Berkelanjutan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary: #0369A1;
      --secondary: #4ADE80;
      --accent: #10B981;
      --light-blue: #E0F2FE;
      --dark-blue: #1E3A8A;
      --teal: #0F766E;
      --sky-blue: #0EA5E9;
      --lime: #A3E635;
      --white: #FFFFFF;
      --gray-100: #F3F4F6;
      --gray-200: #E5E7EB;
      --gray-500: #6B7280;
      --gray-700: #374151;
      --gray-900: #111827;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background: var(--white);
      color: var(--gray-900);
      line-height: 1.6;
    }
    
    /* Header Styles */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 5%;
      background: var(--white);
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    
    .logo {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark-blue);
      display: flex;
      align-items: center;
    }
    
    .logo span {
      color: var(--secondary);
      font-weight: 800;
    }
    
    .logo i {
      margin-right: 10px;
      color: var(--secondary);
    }
    
    nav {
      display: flex;
      gap: 30px;
    }
    
    nav a {
      text-decoration: none;
      color: var(--gray-900);
      font-weight: 500;
      transition: color 0.3s;
      position: relative;
    }
    
    nav a:hover {
      color: var(--accent);
    }
    
    nav a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -5px;
      left: 0;
      background-color: var(--accent);
      transition: width 0.3s;
    }
    
    nav a:hover::after {
      width: 100%;
    }
    
    .buttons a {
      margin-left: 15px;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
    }
    
    .buttons .masuk {
      background: var(--accent);
      color: var(--white);
    }
    
    .buttons .masuk:hover {
      background: #0CA678;
      transform: translateY(-2px);
    }
    
    .buttons .daftar {
      background: var(--light-blue);
      color: var(--dark-blue);
    }
    
    .buttons .daftar:hover {
      background: #BFDBFE;
      transform: translateY(-2px);
    }
    
    /* Hero Section */
    .hero {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 80px 5%;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
      color: var(--white);
      position: relative;
      overflow: hidden;
    }
    
    .hero::before {
      content: '';
      position: absolute;
      top: -50px;
      right: -50px;
      width: 300px;
      height: 300px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }
    
    .hero::after {
      content: '';
      position: absolute;
      bottom: -100px;
      left: -100px;
      width: 400px;
      height: 400px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
    }
    
    .hero-text {
      flex: 1 1 500px;
      margin-bottom: 40px;
      position: relative;
      z-index: 1;
    }
    
    .hero-text h1 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      line-height: 1.2;
      font-weight: 700;
    }
    
    .hero-text p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      max-width: 500px;
    }
    
    .hero-text .cta {
      display: flex;
      gap: 20px;
    }
    
    .hero-text .cta a {
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .cta .contact {
      background: var(--lime);
      color: var(--dark-blue);
    }
    
    .cta .contact:hover {
      background: #84CC16;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .cta .view {
      background: var(--white);
      color: var(--primary);
    }
    
    .cta .view:hover {
      background: #E0F2FE;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .hero-img {
      flex: 1 1 500px;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    
    .hero-img img {
      width: 100%;
      max-width: 500px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0px); }
    }
    
    /* About Section */
    .about {
      padding: 100px 5%;
      text-align: center;
      background: var(--white);
    }
    
    .about h2 {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: var(--dark-blue);
    }
    
    .about span {
      color: var(--secondary);
    }
    
    .about p {
      font-size: 1.1rem;
      color: var(--gray-700);
      max-width: 700px;
      margin: 0 auto 40px;
    }
    
    /* Steps Section */
    .steps {
      padding: 100px 5%;
      position: relative;
      background: var(--white);
    }
    
    .steps h2 {
      text-align: center;
      font-size: 2.2rem;
      margin-bottom: 60px;
      color: var(--dark-blue);
    }
    
    .step-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 80px;
      position: relative;
      z-index: 1;
    }
    
    .step-text {
      flex: 1 1 500px;
      padding: 0 30px;
    }
    
    .step-number {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .step-circle {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: var(--teal);
      color: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 1.3rem;
    }
    
    .step-title {
      margin-left: 15px;
      font-size: 1.5rem;
      font-weight: 600;
    }
    
    .step-title span {
      color: var(--sky-blue);
    }
    
    .step-description {
      color: var(--gray-700);
      margin-bottom: 20px;
    }
    
    .step-image {
      flex: 1 1 500px;
      text-align: center;
      padding: 0 30px;
    }
    
    .step-image img {
      max-width: 100%;
      border-radius: 16px;
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    
    .step-image img:hover {
      transform: scale(1.03);
    }
    
    /* How It Works Section */
    .how-it-works {
      padding: 100px 5%;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
      text-align: center;
    }
    
    .how-it-works h2 {
      font-size: 2.2rem;
      margin-bottom: 60px;
      color: var(--teal);
    }
    
    .steps-grid {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .step-card {
      background: var(--white);
      border-radius: 16px;
      padding: 40px 30px;
      width: 300px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      transition: transform 0.3s, box-shadow 0.3s;
      position: relative;
      overflow: hidden;
    }
    
    .step-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    
    .step-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--accent), var(--secondary));
    }
    
    .step-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--accent), var(--secondary));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 25px;
      color: var(--white);
      font-size: 1.8rem;
    }
    
    .step-card h3 {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: var(--teal);
    }
    
    .step-card p {
      color: var(--gray-700);
      font-size: 0.95rem;
    }
    
    /* Quote & Contact Section */
    .quote-contact {
      padding: 100px 5%;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
      color: var(--white);
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
    }
    
    blockquote {
      flex: 1 1 500px;
      font-size: 1.8rem;
      font-weight: 500;
      font-style: italic;
      position: relative;
      padding-left: 40px;
      margin-bottom: 40px;
    }
    
    blockquote::before {
      content: '"';
      position: absolute;
      left: 0;
      top: -20px;
      font-size: 4rem;
      color: rgba(255,255,255,0.2);
    }
    
    .contact-info {
      flex: 1 1 500px;
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 16px;
    }
    
    .contact-info p {
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
      font-size: 1.1rem;
    }
    
    .contact-info i {
      font-size: 1.3rem;
      color: var(--lime);
    }
    
    /* Map Section */
    .map-section {
      padding: 100px 5%;
      background: var(--white);
      text-align: center;
    }
    
    .map-section h2 {
      font-size: 2.2rem;
      margin-bottom: 40px;
      color: var(--dark-blue);
    }
    
    .map-container {
      height: 500px;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      margin: 0 auto;
      max-width: 1200px;
    }
    
    .map-container iframe {
      width: 100%;
      height: 100%;
      border: none;
    }
    
    /* Footer */
    footer {
      background: linear-gradient(135deg, var(--primary) 0%, var(--teal) 100%);
      padding: 60px 5% 30px;
      color: var(--white);
    }
    
    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      gap: 40px;
    }
    
    .footer-column {
      flex: 1 1 250px;
      margin-bottom: 30px;
    }
    
    .footer-logo {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    
    .footer-logo span {
      color: var(--lime);
    }
    
    .footer-logo i {
      margin-right: 10px;
    }
    
    .footer-description {
      margin-bottom: 20px;
      opacity: 0.8;
    }
    
    .social-icons {
      display: flex;
      gap: 15px;
    }
    
    .social-icons a {
      color: var(--white);
      font-size: 1.2rem;
      transition: color 0.3s;
    }
    
    .social-icons a:hover {
      color: var(--lime);
    }
    
    .footer-column h3 {
      font-size: 1.3rem;
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
    }
    
    .footer-column h3::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 2px;
      background: var(--lime);
    }
    
    .footer-links {
      list-style: none;
    }
    
    .footer-links li {
      margin-bottom: 12px;
    }
    
    .footer-links a {
      color: var(--white);
      text-decoration: none;
      opacity: 0.8;
      transition: opacity 0.3s;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .footer-links a:hover {
      opacity: 1;
    }
    
    .footer-links i {
      font-size: 0.8rem;
    }
    
    .copyright {
      text-align: center;
      margin-top: 50px;
      padding-top: 20px;
      border-top: 1px solid rgba(255,255,255,0.1);
      opacity: 0.8;
      font-size: 0.9rem;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .hero-text h1 {
        font-size: 2.4rem;
      }
      
      .step-container {
        flex-direction: column;
      }
      
      .step-text, .step-image {
        flex: 1 1 100%;
        margin-bottom: 30px;
      }
      
      .step-container:nth-child(even) {
        flex-direction: column-reverse;
      }
    }
    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        gap: 20px;
      }
      
      nav {
        flex-direction: column;
        gap: 15px;
        align-items: center;
      }
      
      .buttons {
        margin-top: 15px;
      }
      
      .hero-text h1 {
        font-size: 2rem;
      }
      
      .hero-text .cta {
        flex-direction: column;
        gap: 15px;
      }
      
      .steps-grid {
        flex-direction: column;
        align-items: center;
      }
      
      .quote-contact {
        flex-direction: column;
      }
      
      blockquote {
        padding-left: 20px;
        font-size: 1.5rem;
      }
    }
    
    @media (max-width: 576px) {
      .hero-text h1 {
        font-size: 1.8rem;
      }
      
      .about h2, .steps h2, .how-it-works h2, .map-section h2 {
        font-size: 1.8rem;
      }
      
      .step-card {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header>
    <div class="logo">
      <i class="fas fa-recycle"></i>Bi<span>j</span>ak Sampah
    </div>
    <nav>
      <a href="#">Home</a>
      <a href="#">Profil</a>
      <a href="#">Kontak</a>
    </nav>
    <div class="buttons">
      <a href="#" class="masuk"><i class="fas fa-sign-in-alt"></i> Masuk</a>
      <a href="#" class="daftar"><i class="fas fa-user-plus"></i> Daftar</a>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Selamat Datang di BijakSampah</h1>
      <p>Solusi Terbaik untuk Pengelolaan Sampah yang Berkelanjutan dan Menguntungkan!</p>
      <div class="cta">
        <a href="#" class="contact"><i class="fas fa-envelope"></i> Contact us</a>
        <a href="#" class="view"><i class="fas fa-eye"></i> View more</a>
      </div>
    </div>
    <div class="hero-img">
      <img src="asset/img/hero.png" alt="Bijak Sampah Illustration" />
    </div>
  </section>

  <!-- About Section -->
  <section class="about">
    <h2>Tentang <span>Bi</span>jak Sampah</h2>
    <p>BijakSampah adalah platform edukasi dan reward inovatif yang mengajak masyarakat untuk memilah sampah dengan benar dan mendapatkan poin tabungan setiap kali membuang sampah di bank sampah.</p>
  </section>

  <!-- Steps Section -->
  <section class="steps">
    <h2>Langkah <span>Revolusi</span> Pengelolaan Sampah</h2>
    
    <!-- Step 1 -->
    <div class="step-container">
      <div class="step-text">
        <div class="step-number">
          <div class="step-circle">1</div>
          <h3 class="step-title"><span>Digitalisasi</span> Pengelolaan Bank Sampah</h3>
        </div>
        <p class="step-description">Meningkatkan efisiensi dan transparansi pengelolaan bank sampah melalui sistem digital terintegrasi yang mencatat transaksi, memantau kapasitas tempat sampah dengan sensor IoT, dan menghubungkan data antar pemangku kepentingan.</p>
        <a href="#" class="view"><i class="fas fa-arrow-right"></i> Pelajari Lebih Lanjut</a>
      </div>
      <div class="step-image">
        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Digitalisasi Bank Sampah">
      </div>
    </div>
    
    <!-- Step 2 -->
    <div class="step-container">
      <div class="step-image">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Ekonomi Sirkular">
      </div>
      <div class="step-text">
        <div class="step-number">
          <div class="step-circle">2</div>
          <h3 class="step-title"><span>Platform</span> untuk Ekonomi Sirkular</h3>
        </div>
        <p class="step-description">Menyediakan platform konektif bagi nasabah, bank sampah, UMKM, dan masyarakat umum untuk mempercepat distribusi sampah terpilah serta memfasilitasi pertumbuhan ekonomi sirkular melalui sistem poin dan marketplace.</p>
        <a href="#" class="view"><i class="fas fa-arrow-right"></i> Pelajari Lebih Lanjut</a>
      </div>
    </div>
    
    <!-- Step 3 -->
    <div class="step-container">
      <div class="step-text">
        <div class="step-number">
          <div class="step-circle">3</div>
          <h3 class="step-title"><span>Perubahan</span> Gaya Hidup Minim Sampah</h3>
        </div>
        <p class="step-description">Mendorong perubahan perilaku masyarakat menuju gaya hidup minim sampah, melalui edukasi digital, insentif poin, dan kolaborasi lintas sektor, sejalan dengan tujuan SDGs 11 – Kota dan Permukiman yang Berkelanjutan.</p>
        <a href="#" class="view"><i class="fas fa-arrow-right"></i> Pelajari Lebih Lanjut</a>
      </div>
      <div class="step-image">
        <img src="https://images.unsplash.com/photo-1503596476-1c12a8ba09a9?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Gaya Hidup Minim Sampah">
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <h2>Bagaimana <span>Kami</span> Bekerja</h2>
    
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-icon">
          <i class="fas fa-sort-amount-down"></i>
        </div>
        <h3>Pilah Sampah</h3>
        <p>Pisahkan sampah organik dan anorganik sesuai kategori yang tersedia untuk memudahkan proses daur ulang.</p>
      </div>
      
      <div class="step-card">
        <div class="step-icon">
          <i class="fas fa-truck"></i>
        </div>
        <h3>Setor ke Bank Sampah</h3>
        <p>Kirimkan sampah yang sudah dipilah ke lokasi bank sampah terdekat atau gunakan layanan penjemputan kami.</p>
      </div>
      
      <div class="step-card">
        <div class="step-icon">
          <i class="fas fa-coins"></i>
        </div>
        <h3>Tukar Jadi Rupiah</h3>
        <p>Dapatkan insentif atau saldo dari sampah yang telah disetorkan dan tukarkan dengan berbagai hadiah menarik.</p>
      </div>
    </div>
  </section>

  <!-- Quote & Contact Section -->
  <section class="quote-contact">
    <blockquote>"Jangkauan bank sampah yang luas merubah sampah menjadi sumber daya berharga bagi masyarakat dan lingkungan."</blockquote>
    <div class="contact-info">
      <p><i class="fas fa-map-marker-alt"></i> Bogor, Jawa Barat, Indonesia</p>
      <p><i class="fas fa-phone"></i> (123) 456-7890</p>
      <p><i class="fas fa-envelope"></i> info@bijaksampah.com</p>
      <p><i class="fas fa-clock"></i> Senin-Jumat: 08.00-17.00 WIB</p>
    </div>
  </section>

  <!-- Map Section -->
  <section class="map-section">
    <h2>Peta <span>Jangkauan</span> Kami</h2>
    <div class="map-container">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d106.68942925!3d-6.5971469!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c44a0cd6aab5%3A0x301576d14feb9c0!2sBogor%2C%20Kota%20Bogor%2C%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1621234567890!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <div class="footer-column">
        <div class="footer-logo">
          <i class="fas fa-recycle"></i>Bi<span>j</span>ak Sampah
        </div>
        <p class="footer-description">Dari Pilah, Jadi Rupiah! Solusi pengelolaan sampah berkelanjutan untuk masa depan yang lebih baik.</p>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      
      <div class="footer-column">
        <h3>Tentang Kami</h3>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-chevron-right"></i> Produk</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Sumber Daya</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Syarat & Ketentuan</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
        </ul>
      </div>
      
      <div class="footer-column">
        <h3>Perusahaan</h3>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-chevron-right"></i> Tim Kami</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Partner Kami</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Kebijakan Privasi</a></li>
          <li><a href="#"><i class="fas fa-chevron-right"></i> Fitur</a></li>
        </ul>
      </div>
      
      <div class="footer-column">
        <h3>Kontak</h3>
        <ul class="footer-links">
          <li><a href="#"><i class="fas fa-phone"></i> +62 878 0598 7309</a></li>
          <li><a href="#"><i class="fas fa-envelope"></i> info@bijaksampah.com</a></li>
          <li><a href="#"><i class="fas fa-map-marker-alt"></i> Bogor, Jawa Barat</a></li>
        </ul>
      </div>
    </div>
    
    <div class="copyright">
      &copy; 2023 Dibuat oleh <strong>TEK(G)</strong> | Seluruh Hak Cipta Dilindungi
    </div>
  </footer>
</body>
</html>
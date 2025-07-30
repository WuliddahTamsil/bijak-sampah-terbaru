<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil - Bijak Sampah</title>
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
    
    /* Container */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* About Section */
    .about-section {
      padding: 100px 5%;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
    }

    .about-images {
      flex: 1 1 500px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      position: relative;
    }

    .about-images img {
      width: 100%;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.5s ease, box-shadow 0.5s ease;
      object-fit: cover;
      aspect-ratio: 1/1;
    }
    
    .about-images img:hover {
      transform: scale(1.05);
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
      z-index: 2;
    }

    .about-text {
      flex: 1 1 500px;
    }

    .about-text h2 {
      font-size: 1.2rem;
      color: var(--accent);
      margin-bottom: 15px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .about-text h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      line-height: 1.2;
      color: var(--dark-blue);
    }
    
    .about-text h1 span {
      color: var(--secondary);
    }

    .about-text p {
      font-size: 1.1rem;
      color: var(--gray-700);
      margin-bottom: 30px;
    }
    
    /* Features Section */
    .features-section {
      padding: 80px 5%;
      background: var(--gray-100);
      text-align: center;
    }
    
    .features-section h2 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      color: var(--dark-blue);
    }
    
    .features-section h2 span {
      color: var(--secondary);
    }
    
    .features-section p {
      max-width: 800px;
      margin: 0 auto 50px;
      color: var(--gray-700);
      font-size: 1.1rem;
    }
    
    /* Keunggulan Section */
    .keunggulan-section {
      padding: 100px 5%;
      background: var(--white);
    }
    
    .keunggulan-content {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
    }
    
    .keunggulan-text {
      flex: 1 1 500px;
    }
    
    .keunggulan-text h2 {
      font-size: 2.2rem;
      margin-bottom: 30px;
      color: var(--dark-blue);
    }
    
    .keunggulan-text h2 span {
      color: var(--secondary);
    }
    
    .keunggulan-text ul {
      list-style: none;
      margin-bottom: 30px;
    }
    
    .keunggulan-text li {
      position: relative;
      padding-left: 35px;
      margin-bottom: 15px;
      color: var(--gray-700);
      font-size: 1.1rem;
    }
    
    .keunggulan-text li::before {
      content: '';
      position: absolute;
      left: 0;
      top: 8px;
      width: 20px;
      height: 20px;
      background-color: var(--secondary);
      border-radius: 50%;
    }
    
    .btn-outline {
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 2px solid var(--accent);
      color: var(--accent);
      background: transparent;
      cursor: pointer;
    }
    
    .btn-outline:hover {
      background: var(--accent);
      color: var(--white);
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .fitur-grid {
      flex: 1 1 500px;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
    }
    
    .fitur-card {
      padding: 30px 20px;
      border-radius: 16px;
      text-align: center;
      transition: all 0.5s ease;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transform: scale(0.95);
    }
    
    .fitur-card:hover {
      transform: scale(1.05);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
      z-index: 1;
    }
    
    .fitur-card i {
      font-size: 2.5rem;
      margin-bottom: 15px;
      display: inline-block;
      color: var(--dark-blue);
      transition: transform 0.3s;
    }
    
    .fitur-card:hover i {
      transform: scale(1.2);
    }
    
    .fitur-card p {
      font-weight: 600;
      color: var(--gray-900);
    }
    
    .fitur-card.orange { 
      background-color: #FFF2E6;
      border: 1px solid #FFD8B8;
    }
    
    .fitur-card.blue { 
      background-color: #E6F7FF;
      border: 1px solid #BAE7FF;
    }
    
    .fitur-card.purple { 
      background-color: #F6F0FF;
      border: 1px solid #D3ADF7;
    }
    
    .fitur-card.pink { 
      background-color: #FFF0F6;
      border: 1px solid #FFADD2;
    }
    
    /* Testimoni Section */
    .testimoni-section {
      padding: 100px 5%;
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
      color: var(--white);
      position: relative;
      overflow: hidden;
    }
    
    .testimoni-section h5 {
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 15px;
      color: var(--lime);
      text-align: center;
    }
    
    .testimoni-section h2 {
      font-size: 2.2rem;
      margin-bottom: 50px;
      text-align: center;
    }
    
    .testimoni-section h2 span {
      color: var(--lime);
    }
    
    .testimoni-container {
      position: relative;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .testi-slider {
      display: flex;
      transition: transform 0.5s ease;
      width: 100%;
      overflow: visible;
      gap: 24px;
      justify-content: center;
    }
    
    .testi-card {
      flex: 0 0 70%;
      background: var(--white);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      color: var(--gray-900);
      transition: all 0.3s;
      opacity: 0.5;
      transform: scale(0.85);
      z-index: 1;
      margin: 0 0.5rem;
    }
    
    .testi-card.active {
      opacity: 1;
      transform: scale(1);
      z-index: 2;
    }
    
    .testi-card.prev, .testi-card.next {
      opacity: 0.8;
      transform: scale(0.92);
      z-index: 1;
    }
    
    .testi-card h4 {
      font-size: 1.3rem;
      margin-bottom: 20px;
      color: var(--dark-blue);
      font-style: italic;
    }
    
    .testi-card p {
      font-size: 1rem;
      margin-bottom: 25px;
      color: var(--gray-700);
    }
    
    .user {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .user img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid var(--accent);
    }
    
    .user-info strong {
      display: block;
      color: var(--dark-blue);
    }
    
    .user-info small {
      color: var(--gray-500);
      font-size: 0.9rem;
    }
    
    .testi-nav {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
    }
    
    .testi-nav-btn {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      border: none;
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .testi-nav-btn.active {
      background: var(--lime);
      transform: scale(1.2);
    }
    
    .testi-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 50px;
      height: 50px;
      background: var(--white);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      z-index: 10;
      border: none;
      color: var(--dark-blue);
      font-size: 1.2rem;
      transition: all 0.3s;
    }
    
    .testi-arrow:hover {
      background: var(--lime);
      color: var(--white);
    }
    
    .testi-prev {
      left: 20px;
    }
    
    .testi-next {
      right: 20px;
    }
    
    /* Team Section */
    .team-section {
      padding: 100px 5%;
      background: white;
      text-align: center;
      color: var(--white);
    }
    
    .team-section h2 {
      font-size: 2.2rem;
      margin-bottom: 60px;
    }
    
    .team-section h2 span {
      color: var(--lime);
    }
    
    .team-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .team-card {
      flex: 1 1 250px;
      max-width: 280px;
      transition: transform 0.5s;
    }
    
    .team-card:hover {
      transform: translateY(-15px);
    }
    
    .team-img {
      width: 200px;
      height: 250px;
      margin: 0 auto 20px;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }
    
    .team-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }
    
    .team-card:hover .team-img img {
      transform: scale(1.1);
    }
    
    .team-card p {
      font-size: 0.9rem;
      opacity: 0.8;
      margin-bottom: 5px;
    }
    
    .team-card h4 {
      color: var(--lime);
      font-size: 1.2rem;
      margin-top: 5px;
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
    
    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .animate {
      opacity: 0;
      animation: fadeInUp 0.8s ease forwards;
    }
    
    .animate-delay-1 {
      animation-delay: 0.2s;
    }
    
    .animate-delay-2 {
      animation-delay: 0.4s;
    }
    
    .animate-delay-3 {
      animation-delay: 0.6s;
    }
    
    .gradient-text {
      background: linear-gradient(90deg, #75E6DA 0%, #05445E 63%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      color: unset;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .about-text h1 {
        font-size: 2rem;
      }
      
      .keunggulan-content {
        flex-direction: column;
      }
      
      .fitur-grid {
        width: 100%;
      }
      
      .testi-arrow {
        width: 40px;
        height: 40px;
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
      
      .about-section {
        flex-direction: column;
      }

      .about-images {
        grid-template-columns: 1fr;
      }
      
      .testi-card {
        flex: 0 0 100%;
      }
      
      .testi-arrow {
        top: auto;
        bottom: 20px;
        transform: none;
      }
      
      .testi-prev {
        left: 30%;
      }
      
      .testi-next {
        right: 30%;
      }
    }
    
    @media (max-width: 576px) {
      .about-text h1, 
      .features-section h2,
      .keunggulan-text h2,
      .testimoni-section h2,
      .team-section h2 {
        font-size: 1.8rem;
      }
      
      .fitur-grid {
        grid-template-columns: 1fr;
      }
      
      .testi-prev {
        left: 20%;
      }
      
      .testi-next {
        right: 20%;
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
      <a href="/">Home</a>
      <a href="/profil">Profil</a>
      <a href="/kontakld">Kontak</a>
    </nav>
    <div class="buttons">
      <a href="#" class="masuk"><i class="fas fa-sign-in-alt"></i> Masuk</a>
      <a href="#" class="daftar"><i class="fas fa-user-plus"></i> Daftar</a>
    </div>
  </header>

  <!-- About Section -->
  <section class="about-section container">
    <div class="about-images animate">
      <img src="asset/img/bijak1.jpg" alt="Tim Bijak Sampah" class="animate-delay-1">
      <img src="asset/img/bijak2.jpg" alt="Bank Sampah Digital" class="animate-delay-2">
      <img src="asset/img/bijak3.jpg" alt="Proses Daur Ulang" class="animate-delay-1">
      <img src="asset/img/bijak4.jpg" alt="Komunitas Bijak Sampah" class="animate-delay-2">
      </div>
    <div class="about-text animate">
        <h2>Tentang Kami</h2>
      <h1>Bijak<span>Sampah</span>!!!</h1>
        <p>
          BijakSampah adalah platform digital berbasis IoT yang menghubungkan masyarakat dengan layanan bank sampah secara efisien dan transparan. Kami hadir untuk mendorong pengelolaan sampah yang lebih bijak melalui teknologi.
        </p>
      </div>
    </section>

  <!-- Features Section -->
  <section class="features-section">
    <div class="container">
      <h2 class="animate">Fitur <span>Unggulan</span></h2>
      <p class="animate animate-delay-1">
        <a href="#" style="color: var(--accent); font-weight: 600; text-decoration: none;">BijakSampah</a> hadir dengan fitur unggulan berupa bank sampah terintegrasi IoT yang memungkinkan pemantauan volume sampah, jadwal penjemputan otomatis, dan pencatatan transaksi secara digital. Selain itu, tersedia marketplace untuk produk daur ulang yang membantu UMKM menjual hasil olahan sampah.
      </p>
    </div>
  </section>

  <!-- Keunggulan Section -->
  <section class="keunggulan-section">
    <div class="container">
      <div class="keunggulan-content">
        <div class="keunggulan-text animate">
          <h2><span>Keunggulan</span> Kami<br>Bijak<span>Sampah</span></h2>
          <ul>
            <li>Teknologi modern berbasis IoT</li>
            <li>Memberdayakan UMKM lokal</li>
            <li>Transaksi mudah dan transparan</li>
            <li>Kontribusi nyata untuk lingkungan</li>
          </ul>
          <button class="btn-outline animate-delay-1"><i class="fas fa-phone-alt"></i> Hubungi Kami</button>
        </div>
        <div class="fitur-grid animate animate-delay-2">
          <div class="fitur-card orange">
            <i class="fas fa-trash-alt"></i>
            <p>Sampah Terkelola</p>
          </div>
          <div class="fitur-card blue">
            <i class="fas fa-coins"></i>
            <p>Reward</p>
          </div>
          <div class="fitur-card purple">
            <i class="fas fa-store"></i>
            <p>Membantu UMKM</p>
          </div>
          <div class="fitur-card pink">
            <i class="fas fa-check-circle"></i>
            <p>Praktis</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimoni Section -->
  <section class="testimoni-section">
    <div class="container">
      <h5 class="animate">TESTIMONI BIJAK SAMPAH</h5>
      <h2 class="animate animate-delay-1"><span>Ini Kata</span> Mereka!!!</h2>
      <div class="testimoni-container">
        <button class="testi-arrow testi-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="testi-arrow testi-next"><i class="fas fa-chevron-right"></i></button>
        
        <div class="testi-slider">
          <!-- Testimoni 1 -->
          <div class="testi-card active">
            <h4>"Solusi Modern Pengelolaan Sampah Desa"</h4>
            <p>"BijakSampah membantu warga kami mengelola sampah dengan lebih mudah dan terpantau. Semoga terus berkembang!"</p>
            <div class="user">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Suryana">
              <div class="user-info">
                <strong>Suryana</strong>
                <small>Kepala Desa Mekarjaya</small>
              </div>
            </div>
          </div>
          
          <!-- Testimoni 2 -->
          <div class="testi-card active">
            <h4>"Sampah Jadi Poin dan Uang"</h4>
            <p>"Sekarang buang sampah lebih praktis lewat aplikasi BijakSampah. Dapat poin juga, jadi makin semangat pilah sampah di rumah."</p>
            <div class="user">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Ratna">
              <div class="user-info">
                <strong>Ratna</strong>
                <small>Ibu Rumah Tangga</small>
              </div>
            </div>
          </div>
          
          <!-- Testimoni 3 -->
          <div class="testi-card active">
            <h4>"Pemasaran Produk Jadi Mudah"</h4>
            <p>"BijakSampah membuka jalan untuk pemasaran produk daur ulang dari usaha saya. Produk daur ulang saya bisa langsung terlihat dan dibeli lewat aplikasi."</p>
            <div class="user">
              <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Fajar">
              <div class="user-info">
                <strong>Fajar Susanto</strong>
                <small>Pelaku UMKM</small>
              </div>
            </div>
          </div>
          
          <!-- Testimoni 4 -->
          <div class="testi-card active">
            <h4>"Sistem yang Sangat Membantu"</h4>
            <p>"Sebagai pengelola bank sampah, sistem digital dari BijakSampah sangat membantu operasional kami sehari-hari. Transaksi lebih cepat dan akurat."</p>
            <div class="user">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Dewi">
              <div class="user-info">
                <strong>Dewi Lestari</strong>
                <small>Pengelola Bank Sampah</small>
              </div>
            </div>
          </div>
        </div>
        
        <div class="testi-nav">
          <button class="testi-nav-btn active"></button>
          <button class="testi-nav-btn"></button>
          <button class="testi-nav-btn"></button>
          <button class="testi-nav-btn"></button>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section class="team-section">
    <div class="container">
      <h2 class="animate gradient-text">Our <span class="gradient-text">Team</span></h2>
      <div class="team-grid">
        <div class="team-card animate">
          <div class="team-img">
            <img src="asset/img/formal (2).jpg" alt="CTO">
          </div>
          <p class="gradient-text">CTO</p>
          <h4 class="gradient-text">Aisyah Putri Harmelia</h4>
        </div>
        <div class="team-card animate animate-delay-1">
          <div class="team-img">
            <img src="asset/img/wuwu ft.jpg" alt="CEO">
          </div>
          <p class="gradient-text">CEO</p>
          <h4 class="gradient-text">Wuliddah Tamsil Barokah</h4>
        </div>
        <div class="team-card animate animate-delay-2">
          <div class="team-img">
            <img src="asset/img/gina ft.jpg" alt="COO">
          </div>
          <p class="gradient-text">COO</p>
          <h4 class="gradient-text">Ghina Rania</h4>
        </div>
      </div>
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
      &copy; 2025 Dibuat oleh <strong>TEK(G)</strong> | Seluruh Hak Cipta Dilindungi
    </div>
  </footer>

  <script>
    // Animasi scroll
    document.addEventListener('DOMContentLoaded', function() {
      const animateElements = document.querySelectorAll('.animate');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = 1;
            entry.target.style.animationPlayState = 'running';
          }
        });
      }, { threshold: 0.1 });
      animateElements.forEach(el => { observer.observe(el); });

      // Testimoni Slider
      const slider = document.querySelector('.testi-slider');
      const cards = document.querySelectorAll('.testi-card');
      const navBtns = document.querySelectorAll('.testi-nav-btn');
      const prevBtn = document.querySelector('.testi-prev');
      const nextBtn = document.querySelector('.testi-next');
      let currentIndex = 0;

      function updateSlider() {
        // Update position
        slider.style.transform = `translateX(-${currentIndex * 76}%)`;
        // Update active/prev/next card
        cards.forEach((card, index) => {
          card.classList.remove('active', 'prev', 'next');
          if (index === currentIndex) {
            card.classList.add('active');
          } else if (index === (currentIndex - 1 + cards.length) % cards.length) {
            card.classList.add('prev');
          } else if (index === (currentIndex + 1) % cards.length) {
            card.classList.add('next');
          }
        });
        // Update navigation buttons
        navBtns.forEach((btn, index) => {
          btn.classList.toggle('active', index === currentIndex);
        });
      }
      // Navigation buttons
      navBtns.forEach((btn, index) => {
        btn.addEventListener('click', () => {
          currentIndex = index;
          updateSlider();
        });
      });
      // Previous button
      prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + cards.length) % cards.length;
        updateSlider();
      });
      // Next button
      nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % cards.length;
        updateSlider();
      });
      // Auto slide (optional)
      let slideInterval = setInterval(() => {
        currentIndex = (currentIndex + 1) % cards.length;
        updateSlider();
      }, 5000);
      // Pause on hover
      slider.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
      });
      slider.addEventListener('mouseleave', () => {
        slideInterval = setInterval(() => {
          currentIndex = (currentIndex + 1) % cards.length;
          updateSlider();
        }, 5000);
      });
      // Initial state
      updateSlider();
    });
  </script>
</body>
</html>
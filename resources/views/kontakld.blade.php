<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kontak - BijakSampah</title>
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
    
    nav a.active {
      color: var(--accent);
      font-weight: 600;
    }
    
    nav a.active::after {
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
    
    /* Main Content Container */
    .main-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    /* Hero Section */
    .hero-section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 80px 0;
      gap: 40px;
    }
    
    .hero-text {
      flex: 1 1 500px;
    }
    
    .hero-text h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: var(--dark-blue);
    }
    
    .hero-text h1 span {
      color: var(--secondary);
    }
    
    .hero-text p {
      font-size: 1.1rem;
      color: var(--gray-700);
    }
    
    .hero-image {
      flex: 1 1 500px;
      display: flex;
      justify-content: center;
    }
    
    .hero-image img {
      max-width: 100%;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    /* Contact Info Section */
    .contact-info-section {
      padding: 40px 0;
      border-top: 1px solid var(--gray-200);
      border-bottom: 1px solid var(--gray-200);
      margin: 40px 0;
    }
    
    .contact-info-grid {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }
    
    .contact-info-item {
      text-align: center;
      padding: 20px;
      min-width: 200px;
    }
    
    .contact-info-item i {
      font-size: 1.8rem;
      color: var(--accent);
      margin-bottom: 15px;
      display: block;
    }
    
    /* Feedback Section */
    .feedback-section {
      background: linear-gradient(135deg, var(--primary) 0%, var(--teal) 100%);
      color: var(--white);
      padding: 80px 0;
      margin: 60px 0;
    }
    
    .feedback-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .feedback-section h2 {
      text-align: center;
      font-size: 2rem;
      margin-bottom: 15px;
    }
    
    .feedback-section p {
      text-align: center;
      font-size: 1.1rem;
      margin-bottom: 30px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      opacity: 0.9;
    }
    
    .feedback-form {
      background: var(--white);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }
    
    .form-group {
      flex: 1;
    }
    
    input, textarea {
      width: 100%;
      padding: 15px;
      border: 1px solid var(--gray-200);
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s;
    }
    
    input:focus, textarea:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    
    textarea {
      height: 150px;
      resize: vertical;
    }
    
    .btn-submit {
      background: var(--lime);
      color: var(--dark-blue);
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
    }
    
    .btn-submit:hover {
      background: #84CC16;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Footer */
    footer {
      background: var(--gray-900);
      padding: 60px 0 30px;
      color: var(--white);
    }
    
    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      gap: 40px;
      padding: 0 20px;
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
    
    .footer-social-icons {
      display: flex;
      gap: 15px;
    }
    
    .footer-social-icons a {
      color: var(--white);
      font-size: 1.2rem;
      transition: color 0.3s;
    }
    
    .footer-social-icons a:hover {
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
      padding: 0;
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
        font-size: 2rem;
      }
      
      .form-row {
        flex-direction: column;
        gap: 15px;
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
      
      .hero-section {
        flex-direction: column;
        text-align: center;
        padding: 60px 0;
      }
      
      .contact-info-grid {
        flex-direction: column;
        align-items: center;
      }
      
      .footer-content {
        flex-direction: column;
        gap: 30px;
      }
    }
    
    @media (max-width: 576px) {
      .hero-text h1 {
        font-size: 1.8rem;
      }
      
      .feedback-section h2 {
        font-size: 1.8rem;
      }
      
      .feedback-form {
        padding: 30px 20px;
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
      <a href="/kontakld" class="active">Kontak</a>
    </nav>
    <div class="buttons">
      <a href="#" class="masuk"><i class="fas fa-sign-in-alt"></i> Masuk</a>
      <a href="#" class="daftar"><i class="fas fa-user-plus"></i> Daftar</a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="main-container">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-text">
        <h1>Ayo <span>Kolaborasi</span>!!!</h1>
        <p>Solusi Terbaik untuk Pengelolaan Sampah yang Berkelanjutan!</p>
      </div>
      <div class="hero-image">
        <img src="asset/img/peta (2).png" alt="Peta Lokasi Bijak Sampah">
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section">
      <div class="contact-info-grid">
        <div class="contact-info-item">
          <i class="fas fa-share-alt"></i>
          <h3>Follow Us</h3>
          <p>Media Sosial Kami</p>
        </div>
        <div class="contact-info-item">
          <i class="fas fa-phone-alt"></i>
          <h3>Telepon</h3>
          <p>+62 878 0598 7309</p>
        </div>
        <div class="contact-info-item">
          <i class="fas fa-map-marker-alt"></i>
          <h3>Lokasi</h3>
          <p>IPB University, Bogor</p>
        </div>
      </div>
    </section>

    <!-- Feedback Section -->
    <section class="feedback-section">
      <div class="feedback-container">
        <h2>Kritik dan Saran</h2>
        <p>Kami terbuka untuk segala kritik dan saran. Yuk, bantu kami berkembang jadi lebih baik dengan memberikan masukan yang membangun!</p>
        
        <div class="feedback-form">
          <form>
            <div class="form-row">
              <div class="form-group">
                <input type="text" placeholder="Nama Depan" required />
              </div>
              <div class="form-group">
                <input type="text" placeholder="Nama Belakang" required />
              </div>
            </div>
            <div class="form-group">
              <input type="email" placeholder="Alamat Email" required />
            </div>
            <div class="form-group">
              <textarea placeholder="Kritik/Saran Anda" required></textarea>
            </div>
            <button type="submit" class="btn-submit">
              <i class="fas fa-paper-plane"></i> KIRIM
            </button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <div class="footer-column">
        <div class="footer-logo">
          <i class="fas fa-recycle"></i>Bi<span>j</span>ak Sampah
        </div>
        <p class="footer-description">Dari Pilah, Jadi Rupiah! Solusi pengelolaan sampah berkelanjutan untuk masa depan yang lebih baik.</p>
        <div class="footer-social-icons">
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
</body>
</html>
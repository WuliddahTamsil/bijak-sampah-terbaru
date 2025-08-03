<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="kontakApp()" x-init="init()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kontak - BijakSampah</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
  {{-- Alpine.js --}}
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
  
  {{-- Theme Manager Scripts --}}
  <script src="{{ asset('asset/js/theme-manager.js') }}" defer></script>
  <script src="{{ asset('asset/js/update-themes.js') }}" defer></script>
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
      --whatsapp: #25D366;
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
      padding: 50px 0 20px;
      gap: 30px;
    }
    
    .hero-text {
      flex: 1 1 500px;
    }
    
    .hero-text h1 {
      font-size: 2.5rem;
      margin-bottom: 15px;
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
      padding: 15px 0;
      border-top: 1px solid var(--gray-200);
      border-bottom: 1px solid var(--gray-200);
      margin: 20px 0;
    }
    
    .contact-info-grid {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 15px;
    }
    
    .contact-info-item {
      text-align: center;
      padding: 15px;
      min-width: 180px;
    }
    
    .contact-info-item i {
      font-size: 1.8rem;
      color: var(--accent);
      margin-bottom: 10px;
    }
    
    /* Feedback Section */
    .feedback-section {
      color: var(--white);
      padding: 70px 20px;
      margin: 40px 0;
      width: 100%;
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
      margin-bottom: 25px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      opacity: 0.9;
    }
    
    .feedback-form {
      background: var(--white);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .form-row {
      display: flex;
      gap: 15px;
      margin-bottom: 15px;
    }
    
    .form-group {
      flex: 1;
    }
    
    input, textarea {
      width: 100%;
      padding: 12px;
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
      height: 140px;
      resize: vertical;
    }
    
    .btn-submit {
      background: var(--whatsapp);
      color: var(--white);
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin-top: 10px;
    }
    
    .btn-submit:hover {
      background: #128C7E;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    /* Footer */
    footer {
      background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
      padding: 50px 0 20px;
      color: var(--white);
    }
    
    .footer-content {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      max-width: 1200px;
      margin: 0 auto;
      gap: 30px;
      padding: 0 20px;
    }
    
    .footer-column {
      flex: 1 1 220px;
      margin-bottom: 20px;
    }
    
    .footer-logo {
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
    }
    
    .footer-logo span {
      color: var(--lime);
    }
    
    .footer-logo i {
      margin-right: 8px;
    }
    
    .footer-description {
      margin-bottom: 15px;
      opacity: 0.8;
      font-size: 0.95rem;
    }
    
    .footer-social-icons {
      display: flex;
      gap: 12px;
    }
    
    .footer-social-icons a {
      color: var(--white);
      font-size: 1.1rem;
      transition: color 0.3s;
    }
    
    .footer-social-icons a:hover {
      color: var(--lime);
    }
    
    .footer-column h3 {
      font-size: 1.2rem;
      margin-bottom: 15px;
      position: relative;
      padding-bottom: 8px;
    }
    
    .footer-column h3::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 2px;
      background: var(--lime);
    }
    
    .footer-links {
      list-style: none;
      padding: 0;
    }
    
    .footer-links li {
      margin-bottom: 10px;
    }
    
    .footer-links a {
      color: var(--white);
      text-decoration: none;
      opacity: 0.8;
      transition: opacity 0.3s;
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.9rem;
    }
    
    .footer-links a:hover {
      opacity: 1;
    }
    
    .footer-links i {
      font-size: 0.7rem;
    }
    
    .copyright {
      text-align: center;
      margin-top: 40px;
      padding-top: 15px;
      border-top: 1px solid rgba(255,255,255,0.1);
      opacity: 0.8;
      font-size: 0.85rem;
    }
    
    /* Message Alert */
    #formMessage {
      display: none;
      margin-top: 15px;
      padding: 10px;
      border-radius: 8px;
      font-size: 0.95rem;
    }
    
    .success {
      background: #d4edda;
      color: #155724;
    }
    
    .error {
      background: #f8d7da;
      color: #721c24;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .hero-text h1 {
        font-size: 2rem;
      }
      
      .form-row {
        flex-direction: column;
        gap: 12px;
      }
    }
    
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        gap: 15px;
      }
      
      nav {
        flex-direction: column;
        gap: 12px;
        align-items: center;
      }
      
      .buttons {
        margin-top: 12px;
      }
      
      .hero-section {
        flex-direction: column;
        text-align: center;
        padding: 40px 0;
      }
      
      .contact-info-grid {
        flex-direction: column;
        align-items: center;
      }
      
      .footer-content {
        flex-direction: column;
        gap: 25px;
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
        padding: 25px 15px;
      }
    }
    .feedback-section h2, .feedback-section p {
      background: linear-gradient(90deg, #10B981 0%, #0EA5E9 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      text-fill-color: transparent;
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
      <a href="/profile">Profil</a>
      <a href="/kontakld" class="active">Kontak</a>
    </nav>
    <div class="buttons">
      <a href="{{ route('pilihan-login') }}" class="masuk"><i class="fas fa-sign-in-alt"></i> Masuk</a>
      <a href="{{ route('pilihan-login') }}" class="daftar"><i class="fas fa-user-plus"></i> Daftar</a>
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
        <img src="asset/img/petabj.png" alt="Peta Lokasi Bijak Sampah">
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="contact-info-section">
      <div class="contact-info-grid">
        <div class="contact-info-item">
          <div style="display:flex; justify-content:center; gap:15px; font-size:1.7rem; margin-bottom:8px;">
            <a href="mailto:info@bijaksampah.com" target="_blank" title="Email" style="color:#EA4335;"><i class="fas fa-envelope"></i></a>
            <a href="https://instagram.com/akunbijaksampah" target="_blank" title="Instagram" style="color:#E1306C;"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/6285294939357" target="_blank" title="WhatsApp" style="color:#25D366;"><i class="fab fa-whatsapp"></i></a>
          </div>
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
  </main>

  <!-- Feedback Section -->
  <section class="feedback-section">
    <div class="feedback-container">
      <h2>Kritik dan Saran</h2>
      <p>Kami terbuka untuk segala kritik dan saran. Yuk, bantu kami berkembang jadi lebih baik dengan memberikan masukan yang membangun!</p>
      
      <div class="feedback-form">
        <form id="feedbackForm">
          <div class="form-row">
            <div class="form-group">
              <input type="text" id="firstName" placeholder="Nama Depan" required />
            </div>
            <div class="form-group">
              <input type="text" id="lastName" placeholder="Nama Belakang" required />
            </div>
          </div>
          <div class="form-group">
            <input type="email" id="email" placeholder="Alamat Email" required />
          </div>
          <div class="form-group">
            <textarea id="message" placeholder="Kritik/Saran Anda" required></textarea>
          </div>
          <button type="submit" class="btn-submit">
            <i class="fab fa-whatsapp"></i> KIRIM VIA WHATSAPP
          </button>
        </form>
        <div id="formMessage"></div>
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
  <script>
    // Alpine.js component for kontak page
    function kontakApp() {
      return {
        language: 'id',
        labels: {
          // Indonesian labels
          id: {
            navHome: 'Beranda',
            navAbout: 'Tentang',
            navServices: 'Layanan',
            navContact: 'Kontak',
            navProfile: 'Profil',
            heroTitle: 'Hubungi <span>Kami</span>',
            heroSubtitle: 'Kami siap membantu Anda dengan pertanyaan dan kebutuhan terkait pengelolaan sampah',
            contactTitle: 'Informasi <span>Kontak</span>',
            contactSubtitle: 'Berbagai cara untuk menghubungi tim kami',
            emailTitle: 'Email',
            emailDesc: 'Kirim pesan langsung',
            emailAddress: 'info@bijaksampah.com',
            phoneTitle: 'Telepon',
            phoneDesc: 'Hubungi kami langsung',
            phoneNumber: '+62 878 0598 7309',
            locationTitle: 'Lokasi',
            locationDesc: 'Kunjungi kantor kami',
            locationAddress: 'IPB University, Bogor',
            socialTitle: 'Follow Us',
            socialDesc: 'Media Sosial Kami',
            feedbackTitle: 'Kritik dan Saran',
            feedbackSubtitle: 'Kami terbuka untuk segala kritik dan saran. Yuk, bantu kami berkembang jadi lebih baik dengan memberikan masukan yang membangun!',
            firstNamePlaceholder: 'Nama Depan',
            lastNamePlaceholder: 'Nama Belakang',
            emailPlaceholder: 'Alamat Email',
            messagePlaceholder: 'Kritik/Saran Anda',
            submitButton: 'KIRIM VIA WHATSAPP',
            footerAbout: 'Tentang Kami',
            footerCompany: 'Perusahaan',
            footerContact: 'Kontak',
            footerProducts: 'Produk',
            footerResources: 'Sumber Daya',
            footerTerms: 'Syarat & Ketentuan',
            footerFAQ: 'FAQ',
            footerTeam: 'Tim Kami',
            footerPartners: 'Partner Kami',
            footerPrivacy: 'Kebijakan Privasi',
            footerFeatures: 'Fitur',
            footerPhone: '+62 878 0598 7309',
            footerEmail: 'info@bijaksampah.com',
            footerAddress: 'Bogor, Jawa Barat',
            footerDesc: 'Dari Pilah, Jadi Rupiah! Solusi pengelolaan sampah berkelanjutan untuk masa depan yang lebih baik.',
            copyright: '© 2025 Dibuat oleh TEK(G) | Seluruh Hak Cipta Dilindungi'
          },
          // English labels
          en: {
            navHome: 'Home',
            navAbout: 'About',
            navServices: 'Services',
            navContact: 'Contact',
            navProfile: 'Profile',
            heroTitle: 'Contact <span>Us</span>',
            heroSubtitle: 'We are ready to help you with questions and needs related to waste management',
            contactTitle: 'Contact <span>Information</span>',
            contactSubtitle: 'Various ways to contact our team',
            emailTitle: 'Email',
            emailDesc: 'Send direct message',
            emailAddress: 'info@bijaksampah.com',
            phoneTitle: 'Phone',
            phoneDesc: 'Call us directly',
            phoneNumber: '+62 878 0598 7309',
            locationTitle: 'Location',
            locationDesc: 'Visit our office',
            locationAddress: 'IPB University, Bogor',
            socialTitle: 'Follow Us',
            socialDesc: 'Our Social Media',
            feedbackTitle: 'Feedback & Suggestions',
            feedbackSubtitle: 'We are open to all criticism and suggestions. Help us grow better by providing constructive input!',
            firstNamePlaceholder: 'First Name',
            lastNamePlaceholder: 'Last Name',
            emailPlaceholder: 'Email Address',
            messagePlaceholder: 'Your Feedback/Suggestion',
            submitButton: 'SEND VIA WHATSAPP',
            footerAbout: 'About Us',
            footerCompany: 'Company',
            footerContact: 'Contact',
            footerProducts: 'Products',
            footerResources: 'Resources',
            footerTerms: 'Terms & Conditions',
            footerFAQ: 'FAQ',
            footerTeam: 'Our Team',
            footerPartners: 'Our Partners',
            footerPrivacy: 'Privacy Policy',
            footerFeatures: 'Features',
            footerPhone: '+62 878 0598 7309',
            footerEmail: 'info@bijaksampah.com',
            footerAddress: 'Bogor, West Java',
            footerDesc: 'From Sort to Cash! Sustainable waste management solution for a better future.',
            copyright: '© 2025 Made by TEK(G) | All Rights Reserved'
          }
        },
        
        init() {
          // Wait for theme manager to be available
          this.waitForThemeManager();
          
          // Listen for language changes
          window.addEventListener('languageChanged', (e) => {
            console.log('Kontak: Language changed to:', e.detail.language);
            this.language = e.detail.language;
            this.updateContent();
          });
          
          // Listen for storage changes
          window.addEventListener('storage', (e) => {
            if (e.key === 'globalSettings') {
              const settings = JSON.parse(e.newValue || '{}');
              if (settings.language && settings.language !== this.language) {
                this.language = settings.language;
                this.updateContent();
              }
            }
          });
        },
        
        waitForThemeManager() {
          if (window.themeManager && window.themeManager.initialized) {
            const settings = window.themeManager.getSettings();
            this.language = settings.language || 'id';
            this.updateContent();
          } else {
            setTimeout(() => this.waitForThemeManager(), 100);
          }
        },
        
        updateContent() {
          // Update HTML lang attribute
          document.documentElement.lang = this.language;
          
          // Update navigation
          this.updateNavigation();
          
          // Update hero section
          this.updateHero();
          
          // Update contact section
          this.updateContact();
          
          // Update feedback section
          this.updateFeedback();
          
          // Update footer
          this.updateFooter();
        },
        
        updateNavigation() {
          const navLinks = document.querySelectorAll('nav a');
          if (navLinks.length >= 3) {
            navLinks[0].textContent = this.labels[this.language].navHome;
            navLinks[1].textContent = this.labels[this.language].navProfile;
            navLinks[2].textContent = this.labels[this.language].navContact;
          }
        },
        
        updateHero() {
          const heroTitle = document.querySelector('.hero-text h1');
          const heroSubtitle = document.querySelector('.hero-text p');
          
          if (heroTitle) heroTitle.innerHTML = this.labels[this.language].heroTitle;
          if (heroSubtitle) heroSubtitle.textContent = this.labels[this.language].heroSubtitle;
        },
        
        updateContact() {
          // Update contact info items
          const contactItems = document.querySelectorAll('.contact-info-item');
          if (contactItems.length >= 3) {
            // Social
            contactItems[0].querySelector('h3').textContent = this.labels[this.language].socialTitle;
            contactItems[0].querySelector('p').textContent = this.labels[this.language].socialDesc;
            
            // Phone
            contactItems[1].querySelector('h3').textContent = this.labels[this.language].phoneTitle;
            contactItems[1].querySelector('p').textContent = this.labels[this.language].phoneNumber;
            
            // Location
            contactItems[2].querySelector('h3').textContent = this.labels[this.language].locationTitle;
            contactItems[2].querySelector('p').textContent = this.labels[this.language].locationAddress;
          }
        },
        
        updateFeedback() {
          const feedbackTitle = document.querySelector('.feedback-section h2');
          const feedbackSubtitle = document.querySelector('.feedback-section p');
          
          if (feedbackTitle) feedbackTitle.textContent = this.labels[this.language].feedbackTitle;
          if (feedbackSubtitle) feedbackSubtitle.textContent = this.labels[this.language].feedbackSubtitle;
          
          // Update form placeholders
          const formInputs = document.querySelectorAll('.feedback-form input, .feedback-form textarea');
          if (formInputs.length >= 4) {
            formInputs[0].placeholder = this.labels[this.language].firstNamePlaceholder;
            formInputs[1].placeholder = this.labels[this.language].lastNamePlaceholder;
            formInputs[2].placeholder = this.labels[this.language].emailPlaceholder;
            formInputs[3].placeholder = this.labels[this.language].messagePlaceholder;
          }
          
          // Update submit button
          const submitButton = document.querySelector('.btn-submit');
          if (submitButton) {
            const icon = submitButton.querySelector('i');
            submitButton.innerHTML = icon.outerHTML + ' ' + this.labels[this.language].submitButton;
          }
        },
        
        updateFooter() {
          const footerColumns = document.querySelectorAll('.footer-column h3');
          if (footerColumns.length >= 3) {
            footerColumns[0].textContent = this.labels[this.language].footerAbout;
            footerColumns[1].textContent = this.labels[this.language].footerCompany;
            footerColumns[2].textContent = this.labels[this.language].footerContact;
          }
          
          const footerDesc = document.querySelector('.footer-description');
          if (footerDesc) footerDesc.textContent = this.labels[this.language].footerDesc;
          
          const copyright = document.querySelector('.copyright');
          if (copyright) copyright.innerHTML = this.labels[this.language].copyright;
        }
      };
    }
    
    // WhatsApp form submission
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const firstName = document.getElementById('firstName').value;
      const lastName = document.getElementById('lastName').value;
      const email = document.getElementById('email').value;
      const message = document.getElementById('message').value;
      const formMessage = document.getElementById('formMessage');
      
      // Validation
      if (!firstName || !lastName || !email || !message) {
        formMessage.textContent = "Harap isi semua field!";
        formMessage.className = "error";
        formMessage.style.display = "block";
        setTimeout(() => { formMessage.style.display = "none"; }, 3000);
        return;
      }
      
      // Prepare WhatsApp message
      const whatsappText = `Halo, saya *${firstName} ${lastName}* (${email}). Saya ingin memberikan kritik/saran:\n\n${message}`;
      
      // Encode for WhatsApp URL
      const encodedText = encodeURIComponent(whatsappText);
      
      // Open WhatsApp
      window.open(`https://wa.me/6285294939357?text=${encodedText}`, '_blank');
      
      // Show success message
      formMessage.textContent = "Terima kasih! Anda akan diarahkan ke WhatsApp.";
      formMessage.className = "success";
      formMessage.style.display = "block";
      
      // Reset form
      document.getElementById('feedbackForm').reset();
      
      // Hide message after 5 seconds
      setTimeout(() => { formMessage.style.display = "none"; }, 5000);
    });
  </script>
  </script>
</body>
</html>
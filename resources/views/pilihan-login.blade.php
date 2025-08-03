<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Bijak Sampah</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #05445E;
            --secondary-color: #189AB4;
            --accent-color: #75E6DA;
            --text-dark: #2E2E2E;
            --text-medium: #5A5A5A;
            --text-light: #B0B0B0;
            --background-light: #F5F5F6;
            --white: #FFFFFF;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            display: flex;
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            max-width: 1200px;
            width: 100%;
            overflow: hidden;
            min-height: 600px;
            position: relative;
        }

        .left-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(117, 230, 218, 0.7) 0%, rgba(5, 68, 94, 0.5) 63%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .main-illustration {
            max-width: 100%;
            height: auto;
            z-index: 2;
            animation: zoomInOut 8s infinite alternate ease-in-out;
        }

        @keyframes zoomInOut {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        .right-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
            position: relative;
        }

        .welcome-text {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .welcome-text span:first-child {
            color: #05445E;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .bijaksampah-logo {
            height: 12.5rem;
            vertical-align: middle;
            transition: transform 0.3s ease;
        }

        .bijaksampah-logo:hover {
            transform: rotate(5deg);
        }

        .auth-buttons {
            display: flex;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 30px;
            overflow: hidden;
            width: fit-content;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .btn {
            padding: 12px 30px;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-medium);
            transition: var(--transition);
            border-radius: 30px;
            position: relative;
            z-index: 1;
        }

        .btn.active {
            background-color: var(--primary-color);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .description {
            font-size: 0.95rem;
            color: var(--text-medium);
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* Role Selection */
        .role-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .role-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
            background-color: var(--white);
            border: 2px solid rgba(117, 230, 218, 0.3);
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: var(--transition);
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .role-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }

        .role-btn.selected {
            background-color: rgba(117, 230, 218, 0.1);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.3);
        }

        .role-icon {
            font-size: 2rem;
            margin-bottom: 12px;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .role-btn:hover .role-icon {
            transform: scale(1.1);
            color: var(--secondary-color);
        }

        .btn-lanjut {
            padding: 14px 35px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            align-self: flex-end;
            transition: var(--transition);
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .btn-lanjut:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(5, 68, 94, 0.4);
        }

        .btn-lanjut:disabled {
            background-color: var(--text-light);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Form Styling */
        .form-container {
            display: none;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 0.9rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-group input {
            padding: 14px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
            transition: var(--transition);
            background-color: rgba(0, 0, 0, 0.02);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(5, 68, 94, 0.2);
            background-color: var(--white);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-light);
            font-size: 1.1rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-medium);
            margin-top: 5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: var(--secondary-color);
        }

        .btn-submit-form {
            padding: 14px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        }

        .btn-submit-form:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(5, 68, 94, 0.4);
        }

        .back-button {
            position: absolute;
            top: 30px;
            left: 30px;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--text-medium);
            cursor: pointer;
            transition: var(--transition);
            display: none;
        }

        .back-button:hover {
            color: var(--primary-color);
            transform: translateX(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                max-width: 600px;
            }

            .left-section {
                min-height: 250px;
                padding: 30px;
            }

            .right-section {
                padding: 40px 30px;
            }

            .welcome-text {
                font-size: 1.8rem;
                justify-content: center;
            }

            .welcome-text span:first-child {
                font-size: 1.2rem;
            }

            .auth-buttons {
                width: 100%;
                justify-content: center;
            }

            .btn-lanjut, .btn-submit-form {
                width: 100%;
                align-self: center;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 15px;
            }

            .right-section {
                padding: 30px 20px;
            }

            .welcome-text {
                font-size: 1.5rem;
                flex-direction: column;
                text-align: center;
                gap: 5px;
            }

            .welcome-text span:first-child {
                font-size: 1rem;
            }

            .auth-buttons {
                width: 100%;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }

            .role-selection {
                grid-template-columns: 1fr;
            }

            .role-btn {
                padding: 20px 10px;
            }

            .back-button {
                top: 20px;
                left: 20px;
            }
        }

        /* Animation for the left section */
        .left-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: rotate 20s linear infinite;
            z-index: 1;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Modal for forgot password */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: fadeIn 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .modal h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .modal p {
            color: var(--text-medium);
            margin-bottom: 20px;
        }

        .modal-btn {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-btn:hover {
            background-color: var(--secondary-color);
        }

        /* Change password form */
        .change-password-form {
            display: none;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .change-password-form input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            width: 100%;
        }

        .change-password-btn {
            padding: 12px;
            background-color: var(--accent-color);
            color: var(--white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        .change-password-btn:hover {
            background-color: var(--secondary-color);
        }

        /* Loading spinner */
        .spinner {
            display: none;
            width: 40px;
            height: 40px;
            margin: 0 auto;
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="asset/img/iconBS (2).png" alt="Ilustrasi Daur Ulang" class="main-illustration">
        </div>
        <div class="right-section">
            <button class="back-button" id="backButton">
                <i class="fas fa-arrow-left"></i>
            </button>

            <h1 class="welcome-text">
                <span>Selamat Datang di Bijak Sampah</span>
            </h1>

            <div class="auth-buttons">
                <button class="btn active" id="loginTab">Login</button>
                <button class="btn" id="registerTab">Register</button>
            </div>

            <p class="description" id="descriptionText">Sistem terintegrasi untuk pengelolaan sampah yang lebih baik. Pilih peran Anda untuk melanjutkan.</p>

            <div class="role-selection" id="roleSelection">
                <button class="role-btn" data-role="Nasabah">
                    <i class="fas fa-user role-icon"></i>
                    Nasabah
                </button>
                <button class="role-btn" data-role="UMKM">
                    <i class="fas fa-store role-icon"></i>
                    UMKM
                </button>
                <button class="role-btn" data-role="Non Nasabah">
                    <i class="fas fa-users role-icon"></i>
                    Non Nasabah
                </button>
                <button class="role-btn" data-role="Bank Sampah">
                    <i class="fas fa-recycle role-icon"></i>
                    Bank Sampah
                </button>
            </div>

            <button class="btn-lanjut" id="lanjutButton" disabled>Lanjut</button>

            <div class="form-container" id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" placeholder="Masukkan email Anda">
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="loginPassword" placeholder="Masukkan password Anda">
                        <button type="button" class="password-toggle" id="toggleLoginPassword">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-password" id="forgotPassword">Lupa Password?</a>
                </div>
                <button class="btn-submit-form" id="loginSubmit">Login</button>
                <div class="spinner" id="loginSpinner"></div>
            </div>

            <div class="form-container" id="registerForm">
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" placeholder="Masukkan email Anda">
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="registerPassword" placeholder="Buat password Anda (minimal 6 karakter)">
                        <button type="button" class="password-toggle" id="toggleRegisterPassword">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="registerConfirmPassword">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="registerConfirmPassword" placeholder="Konfirmasi password Anda">
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="fa fa-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <button class="btn-submit-form" id="registerSubmit">Register</button>
                <div class="spinner" id="registerSpinner"></div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal" id="forgotPasswordModal">
        <div class="modal-content">
            <h3>Lupa Password</h3>
            <p id="passwordInfoText">Masukkan email Anda untuk menerima link reset password</p>
            
            <div class="change-password-form" id="changePasswordForm">
                <input type="email" id="resetEmail" placeholder="Masukkan email Anda">
                <button class="change-password-btn" id="resetPasswordBtn">Kirim Link Reset Password</button>
                <div class="spinner" id="resetSpinner"></div>
            </div>
            
            <button class="modal-btn" id="closeModal">Tutup</button>
        </div>
    </div>

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.0/firebase-database-compat.js"></script>
    
    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
            authDomain: "bijaksampah-aeb82.firebaseapp.com",
            databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "bijaksampah-aeb82",
            storageBucket: "bijaksampah-aeb82.appspot.com",
            messagingSenderId: "140467230562",
            appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b"
        };

        // Initialize Firebase
        const app = firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();
        const database = firebase.database();

        // DOM Elements
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const descriptionText = document.getElementById('descriptionText');
        const roleSelection = document.getElementById('roleSelection');
        const roleButtons = document.querySelectorAll('.role-btn');
        const lanjutButton = document.getElementById('lanjutButton');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const backButton = document.getElementById('backButton');
        const forgotPasswordLink = document.getElementById('forgotPassword');
        const forgotPasswordModal = document.getElementById('forgotPasswordModal');
        const closeModalBtn = document.getElementById('closeModal');
        const loginSubmitBtn = document.getElementById('loginSubmit');
        const registerSubmitBtn = document.getElementById('registerSubmit');
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const resetEmail = document.getElementById('resetEmail');
        const changePasswordForm = document.getElementById('changePasswordForm');
        const passwordInfoText = document.getElementById('passwordInfoText');
        const loginSpinner = document.getElementById('loginSpinner');
        const registerSpinner = document.getElementById('registerSpinner');
        const resetSpinner = document.getElementById('resetSpinner');

        // Password toggle elements
        const toggleLoginPassword = document.getElementById('toggleLoginPassword');
        const loginPasswordInput = document.getElementById('loginPassword');
        const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
        const registerPasswordInput = document.getElementById('registerPassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordInput = document.getElementById('registerConfirmPassword');

        // State variables
        let activeTab = 'login';
        let selectedRole = null;

        // Initialize the page
        function init() {
            showRoleSelection();
            loginTab.classList.add('active');
            
            // Check if user was remembered
            if (localStorage.getItem('rememberMe') === 'true') {
                const rememberedEmail = localStorage.getItem('email');
                if (rememberedEmail) {
                    document.getElementById('loginEmail').value = rememberedEmail;
                    document.getElementById('rememberMe').checked = true;
                }
            }
        }

        // --- View Management Functions ---
        function showRoleSelection() {
            descriptionText.style.display = 'block';
            roleSelection.style.display = 'grid';
            lanjutButton.style.display = 'block';
            loginForm.style.display = 'none';
            registerForm.style.display = 'none';
            backButton.style.display = 'none';
        }

        function showLoginFormContent() {
            descriptionText.style.display = 'none';
            roleSelection.style.display = 'none';
            lanjutButton.style.display = 'none';
            loginForm.style.display = 'flex';
            registerForm.style.display = 'none';
            backButton.style.display = 'block';
        }

        function showRegisterFormContent() {
            descriptionText.style.display = 'none';
            roleSelection.style.display = 'none';
            lanjutButton.style.display = 'none';
            loginForm.style.display = 'none';
            registerForm.style.display = 'flex';
            backButton.style.display = 'block';
        }

        // --- Event Handlers ---
        // Tab switching
        loginTab.addEventListener('click', () => {
            activeTab = 'login';
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
            resetRoleSelection();
            showRoleSelection();
        });

        registerTab.addEventListener('click', () => {
            activeTab = 'register';
            registerTab.classList.add('active');
            loginTab.classList.remove('active');
            resetRoleSelection();
            showRoleSelection();
        });

        // Role selection
        roleButtons.forEach(button => {
            button.addEventListener('click', () => {
                roleButtons.forEach(btn => btn.classList.remove('selected'));
                button.classList.add('selected');
                selectedRole = button.dataset.role;
                lanjutButton.disabled = false;
            });
        });

        // Continue button
        lanjutButton.addEventListener('click', () => {
            if (selectedRole) {
                if (activeTab === 'login') {
                    showLoginFormContent();
                } else {
                    showRegisterFormContent();
                }
            }
        });

        // Back button
        backButton.addEventListener('click', () => {
            showRoleSelection();
        });

        // Password toggle
        toggleLoginPassword.addEventListener('click', function() {
            const type = loginPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            loginPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        toggleRegisterPassword.addEventListener('click', function() {
            const type = registerPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            registerPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Forgot password
        forgotPasswordLink.addEventListener('click', (e) => {
            e.preventDefault();
            forgotPasswordModal.style.display = 'flex';
            changePasswordForm.style.display = 'flex';
            passwordInfoText.textContent = "Masukkan email Anda untuk menerima link reset password";
        });

        closeModalBtn.addEventListener('click', () => {
            forgotPasswordModal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === forgotPasswordModal) {
                forgotPasswordModal.style.display = 'none';
            }
        });

        // Form submissions
        loginSubmitBtn.addEventListener('click', loginUser);
        registerSubmitBtn.addEventListener('click', registerUser);
        resetPasswordBtn.addEventListener('click', sendPasswordReset);

        // --- Helper Functions ---
        function resetRoleSelection() {
            selectedRole = null;
            roleButtons.forEach(btn => btn.classList.remove('selected'));
            lanjutButton.disabled = true;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function showLoading(button, spinner) {
            button.disabled = true;
            spinner.style.display = 'block';
        }

        function hideLoading(button, spinner) {
            button.disabled = false;
            spinner.style.display = 'none';
        }

        // --- Firebase Functions ---
        function loginUser() {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            
            // Validate email
            if (!validateEmail(email)) {
                alert("Masukkan email yang valid");
                return;
            }
            
            // Validate password
            if (password.length < 6) {
                alert("Password harus minimal 6 karakter");
                return;
            }
            
            showLoading(loginSubmitBtn, loginSpinner);
            
            auth.signInWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    // Success
                    const user = userCredential.user;
                    
                    // Store remember me preference
                    if (rememberMe) {
                        localStorage.setItem('rememberMe', 'true');
                        localStorage.setItem('email', email);
                    } else {
                        localStorage.removeItem('rememberMe');
                        localStorage.removeItem('email');
                    }
                    
                    // Get user role from database
                    return database.ref('users verification/' + user.uid).once('value');
                })
                .then((snapshot) => {
                    const userData = snapshot.val();
                    if (!userData) {
                        throw new Error("Data pengguna tidak ditemukan di database");
                    }
                    
                    // Redirect based on role
                    redirectBasedOnRole(auth.currentUser.uid, userData.role);
                })
                .catch((error) => {
                    console.error("Login error:", error);
                    let errorMessage = "Login gagal: ";
                    switch(error.code) {
                        case "auth/invalid-email":
                            errorMessage += "Email tidak valid";
                            break;
                        case "auth/user-disabled":
                            errorMessage += "Akun ini dinonaktifkan";
                            break;
                        case "auth/user-not-found":
                            errorMessage += "Tidak ada pengguna dengan email ini";
                            break;
                        case "auth/wrong-password":
                            errorMessage += "Password salah";
                            break;
                        default:
                            errorMessage += error.message;
                    }
                    alert(errorMessage);
                })
                .finally(() => {
                    hideLoading(loginSubmitBtn, loginSpinner);
                });
        }

        function registerUser() {
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('registerConfirmPassword').value;
            
            // Validate email
            if (!validateEmail(email)) {
                alert("Masukkan email yang valid");
                return;
            }
            
            // Validate password
            if (password.length < 6) {
                alert("Password harus minimal 6 karakter");
                return;
            }
            
            // Check if passwords match
            if (password !== confirmPassword) {
                alert("Password dan konfirmasi password tidak cocok");
                return;
            }
            
            // Check if role is selected
            if (!selectedRole) {
                alert("Silakan pilih peran Anda terlebih dahulu");
                return;
            }
            
            showLoading(registerSubmitBtn, registerSpinner);
            
            // Create user with email and password
            auth.createUserWithEmailAndPassword(email, password)
                .then((userCredential) => {
                    // Success
                    const user = userCredential.user;
                    
                    // Save additional user data to Realtime Database
                    const userData = {
                        email: email,
                        role: selectedRole,
                        createdAt: firebase.database.ServerValue.TIMESTAMP
                    };
                    
                    return database.ref('users verification/' + user.uid).set(userData);
                })
                .then(() => {
                    alert("Registrasi berhasil! Anda akan diarahkan ke halaman sesuai peran Anda.");
                    // Redirect based on role
                    redirectBasedOnRole(auth.currentUser.uid, selectedRole);
                })
                .catch((error) => {
                    console.error("Registration error:", error);
                    let errorMessage = "Registrasi gagal: ";
                    switch(error.code) {
                        case "auth/email-already-in-use":
                            errorMessage += "Email sudah digunakan";
                            break;
                        case "auth/invalid-email":
                            errorMessage += "Email tidak valid";
                            break;
                        case "auth/weak-password":
                            errorMessage += "Password terlalu lemah";
                            break;
                        default:
                            errorMessage += error.message;
                    }
                    alert(errorMessage);
                })
                .finally(() => {
                    hideLoading(registerSubmitBtn, registerSpinner);
                });
        }

        function sendPasswordReset() {
            const email = resetEmail.value;
            
            if (!validateEmail(email)) {
                alert("Masukkan email yang valid");
                return;
            }
            
            showLoading(resetPasswordBtn, resetSpinner);
            
            auth.sendPasswordResetEmail(email)
                .then(() => {
                    passwordInfoText.textContent = "Link reset password telah dikirim ke email Anda. Silakan cek inbox Anda.";
                    changePasswordForm.style.display = 'none';
                    resetEmail.value = '';
                })
                .catch((error) => {
                    console.error("Password reset error:", error);
                    let errorMessage = "Gagal mengirim link reset password: ";
                    switch(error.code) {
                        case "auth/invalid-email":
                            errorMessage += "Email tidak valid";
                            break;
                        case "auth/user-not-found":
                            errorMessage += "Tidak ada pengguna dengan email ini";
                            break;
                        default:
                            errorMessage += error.message;
                    }
                    alert(errorMessage);
                })
                .finally(() => {
                    hideLoading(resetPasswordBtn, resetSpinner);
                });
        }

        function redirectBasedOnRole(userId, role) {
            // Use the role parameter instead of selectedRole for more reliability
            let redirectUrl;
            
            switch(role) {
                case "Nasabah":
                    redirectUrl = "{{ route('nasabahdashboard') }}";
                    break;
                case "UMKM":
                    redirectUrl = "{{ route('toko') }}";
                    break;
                case "Non Nasabah":
                    redirectUrl = "{{ route('non-nasabah-dashboard') }}";
                    break;
                case "Bank Sampah":
                    redirectUrl = "{{ route('dashboard-banksampah') }}";
                    break;
                default:
                    redirectUrl = "{{ route('home') }}";
            }
            
            // Save user session
            sessionStorage.setItem('currentUser', userId);
            sessionStorage.setItem('userRole', role);
            
            // Redirect
            window.location.href = redirectUrl;
        }

        // Initialize the application
        init();
    </script>
</body>
</html>
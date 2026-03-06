<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - CLSD</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        min-height: 100vh;
        padding: 60px 20px;
        display: flex;
        justify-content: center;
        position: relative;
        overflow-x: hidden;
    }

    /* Animated background elements */
    body::before {
        content: '';
        position: absolute;
        width: 1500px;
        height: 1500px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.03);
        top: -400px;
        right: -400px;
        animation: float 20s infinite ease-in-out;
    }

    body::after {
        content: '';
        position: absolute;
        width: 1000px;
        height: 1000px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.02);
        bottom: -300px;
        left: -300px;
        animation: float 15s infinite ease-in-out reverse;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(30px, 20px); }
    }

    .register-wrapper {
        width: 100%;
        max-width: 950px;
        position: relative;
        z-index: 10;
    }

    .register-header {
        text-align: center;
        color: white;
        margin-bottom: 35px;
    }

    .register-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .register-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 16px;
    }

    .register-form-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        display: block;
    }

    label i {
        margin-right: 6px;
        color: #2563eb;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 16px;
    }

    input, select {
        width: 100%;
        padding: 12px 15px 12px 42px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        color: #1f2937;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
    }

    select {
        padding: 12px 15px;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    select option {
        background-color: white;
        color: #1f2937;
    }

    input::placeholder {
        color: #9ca3af;
    }

    input:focus, select:focus {
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    /* Password strength */
    .password-strength {
        margin-top: 8px;
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
    }

    .strength-bar {
        height: 100%;
        width: 0;
        transition: width 0.3s, background 0.3s;
    }

    .strength-text {
        font-size: 11px;
        margin-top: 5px;
        color: #6b7280;
    }

    .match-text {
        font-size: 11px;
        margin-top: 5px;
    }

    .btn-primary {
        width: 100%;
        padding: 15px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
    }

    .btn-primary i {
        font-size: 16px;
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .links {
        text-align: center;
        margin-top: 25px;
        font-size: 14px;
        color: #6b7280;
    }

    .links a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .links a:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    .links i {
        margin-right: 5px;
    }

    .error {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .error i {
        color: #ef4444;
        font-size: 18px;
    }

    /* Toast notification */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        border-radius: 12px;
        padding: 15px 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 10px;
        animation: slideIn 0.3s ease;
        z-index: 1001;
    }

    .toast.success {
        border-left: 4px solid #10b981;
    }

    .toast.error {
        border-left: 4px solid #ef4444;
    }

    .toast i {
        font-size: 20px;
    }

    .toast.success i {
        color: #10b981;
    }

    .toast.error i {
        color: #ef4444;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0%); opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .register-form-card {
            padding: 30px 20px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
</head>
<body>

<div class="register-wrapper">

    <div class="register-header">
        <h1>Create Your CLSD Account</h1>
        <p>Please provide accurate professional information.</p>
    </div>

    <div class="register-form-card">

        <!-- ERROR -->
        <?php if (!empty($data['error'])): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <!-- SUCCESS TOAST (will be shown via JavaScript if needed) -->
        <?php if (!empty($_SESSION['success'])): ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    showToast("<?= $_SESSION['success']; ?>", "success");
                });
            </script>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form id="registerForm" method="POST" action="<?= BASE_URL ?>/register">

            <!-- NAME SECTION -->
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> First Name *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="first_name" placeholder="e.g. Juan" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user"></i> Middle Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="middle_name" placeholder="e.g. Santos">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Last Name *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-user-tag"></i> Suffix</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" name="suffix" placeholder="e.g. Jr., MIT">
                    </div>
                </div>
            </div>

            <!-- PROFESSIONAL DETAILS -->
            <div class="form-group">
                <label><i class="fas fa-briefcase"></i> Designation *</label>
                <select name="designation" required>
                    <option value="">-- Select Designation --</option>
                    <option value="Researcher">Researcher</option>
                    <option value="Affiliate Researcher">Affiliate Researcher</option>
                    <option value="Research Assistant">Research Assistant</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-university"></i> Institution *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-university"></i>
                        <input type="text" name="institution" placeholder="e.g. Central Luzon State University" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-building"></i> Department *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-building"></i>
                        <input type="text" name="department" placeholder="e.g. College of Science" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-microscope"></i> Research Interests *</label>
                <div class="input-wrapper">
                    <i class="fas fa-microscope"></i>
                    <input type="text" name="research_interest" placeholder="e.g. Molecular Biology, Ecology" required>
                </div>
            </div>

            <!-- ACCOUNT DETAILS -->
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="e.g. juan.delacruz@clsu.edu.ph" required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required onkeyup="checkPasswordStrength()">
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-check-circle"></i> Confirm Password *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-check-circle"></i>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required onkeyup="checkPasswordMatch()">
                    </div>
                    <div class="match-text" id="matchText"></div>
                </div>
            </div>

            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-user-plus"></i> Create Account
            </button>

        </form>

        <div class="links">
            <i class="fas fa-sign-in-alt"></i> Already have an account?  
            <a href="<?= BASE_URL ?>/login">Login here</a>
        </div>

    </div>

</div>

<script>
// Password strength checker
function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    let strength = 0;
    
    if (password.length >= 8) strength += 1;
    if (password.match(/[a-z]+/)) strength += 1;
    if (password.match(/[A-Z]+/)) strength += 1;
    if (password.match(/[0-9]+/)) strength += 1;
    if (password.match(/[$@#&!]+/)) strength += 1;
    
    const width = (strength / 5) * 100;
    strengthBar.style.width = width + '%';
    
    if (strength <= 2) {
        strengthBar.style.background = '#ef4444';
        strengthText.textContent = 'Weak password';
        strengthText.style.color = '#ef4444';
    } else if (strength <= 4) {
        strengthBar.style.background = '#f59e0b';
        strengthText.textContent = 'Medium password';
        strengthText.style.color = '#f59e0b';
    } else {
        strengthBar.style.background = '#10b981';
        strengthText.textContent = 'Strong password';
        strengthText.style.color = '#10b981';
    }
    
    checkPasswordMatch();
}

// Password match checker
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    const matchText = document.getElementById('matchText');
    const submitBtn = document.getElementById('submitBtn');
    
    if (confirm.length > 0) {
        if (password === confirm) {
            matchText.textContent = '✓ Passwords match';
            matchText.style.color = '#10b981';
            submitBtn.disabled = false;
        } else {
            matchText.textContent = '✗ Passwords do not match';
            matchText.style.color = '#ef4444';
            submitBtn.disabled = true;
        }
    } else {
        matchText.textContent = '';
        submitBtn.disabled = false;
    }
}

// Toast function
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

</body>
</html>
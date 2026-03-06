<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Registration - CLSD</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 280px;
        background: white;
        color: #1e3a8a;
        padding: 25px 0;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 0 20px 20px 0;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: 800;
        color: #1e3a8a;
        letter-spacing: 1px;
    }

    .sidebar > a, .dropdown-title {
        display: block;
        padding: 12px 25px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        cursor: pointer;
    }

    .sidebar > a:hover, .dropdown-title:hover {
        background: #eff6ff;
        color: #2563eb;
        padding-left: 30px;
    }

    .sidebar > a.active {
        background: #2563eb;
        color: white;
        border-radius: 0 10px 10px 0;
    }

    .sidebar > a i, .dropdown-title i {
        margin-right: 10px;
        width: 20px;
    }

    .dropdown-links {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background: #f9fafb;
    }

    .dropdown-links.show {
        max-height: 300px;
        transition: max-height 0.5s ease-in;
    }

    .dropdown-links a {
        display: block;
        padding: 10px 40px 10px 55px;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9em;
        transition: all 0.3s ease;
    }

    .dropdown-links a:hover {
        background: #eff6ff;
        color: #2563eb;
        padding-left: 65px;
    }

    .dropdown-links a.active {
        color: #2563eb;
        font-weight: 600;
        border-left: 3px solid #2563eb;
        background: #eff6ff;
    }

    .dropdown-links a i {
        margin-right: 8px;
        width: 18px;
    }

    /* Main Content Styles */
    .main {
        flex: 1;
        margin-left: 280px;
        padding: 30px;
    }

    .topbar {
        background: white;
        border-radius: 20px;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .topbar h1 {
        color: #1e3a8a;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .topbar h1 i {
        color: #2563eb;
    }

    .topbar span {
        color: #4b5563;
        font-weight: 500;
        background: #f3f4f6;
        padding: 8px 20px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .topbar span i {
        color: #2563eb;
    }

    /* Register Wrapper */
    .register-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header h1 {
        color: white;
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

    /* Form Styles */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-group label i {
        margin-right: 6px;
        color: #2563eb;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
        background: #f9fafb;
        color: #1f2937;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .form-group input::placeholder {
        color: #9ca3af;
    }

    .modern-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
    }

    /* Research Interests */
    .research-wrapper {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
    }

    .research-input {
        flex: 1;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
        background: #f9fafb;
    }

    .research-input:focus {
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .btn-add {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0 25px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }

    .research-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .research-tag {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 15px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #bfdbfe;
    }

    .research-tag i {
        cursor: pointer;
        font-size: 12px;
        color: #6b7280;
    }

    .research-tag i:hover {
        color: #ef4444;
    }

    /* Password Strength */
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
        font-size: 12px;
        margin-top: 5px;
        color: #6b7280;
    }

    .match-text {
        font-size: 12px;
        margin-top: 5px;
    }

    /* Submit Button */
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
        margin-top: 20px;
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

    /* Toast Notification */
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
        to { transform: translateX(0); opacity: 1; }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #2563eb;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #1e40af;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .sidebar {
            width: 240px;
        }
        .main {
            margin-left: 240px;
        }
    }

    @media (max-width: 768px) {
        body {
            flex-direction: column;
        }
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
            border-radius: 0;
        }
        .main {
            margin-left: 0;
            padding: 20px;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .register-form-card {
            padding: 25px;
        }
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>CLSD</h2>

    <a href="<?= BASE_URL ?>/superadmin/dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('manageMenu')">
            <i class="fas fa-users-cog"></i> Manage Accounts ▼
        </div>
        <div class="dropdown-links show" id="manageMenu">
            <a href="<?= BASE_URL ?>/superadmin/users">
                <i class="fas fa-user"></i> Users
            </a>
            <a href="<?= BASE_URL ?>/superadmin/admins">
                <i class="fas fa-user-shield"></i> Admins
            </a>
        </div>
    </div>

    <a href="<?= BASE_URL ?>/superadmin/register" class="active">
        <i class="fas fa-user-plus"></i> Admin Registration
    </a>

    <a href="<?= BASE_URL ?>/logout">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="main">

    <div class="topbar">
        <h1>
            <i class="fas fa-user-plus"></i> Admin Registration
        </h1>
        <span>
            <i class="fas fa-user-circle"></i>
            Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Super Admin') ?>
        </span>
    </div>

    <div class="register-wrapper">

        <div class="register-header">
            <h1>Create Admin Account</h1>
            <p>
                Add a new administrator to the CLSD platform.
                Ensure all information is accurate before submission.
            </p>
        </div>

        <div class="register-form-card">

            <!-- FLASH MESSAGES will be handled by toast in JavaScript -->

            <form id="registerForm" method="POST" action="<?= BASE_URL ?>/superadmin/register">

                <!-- NAME SECTION -->
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> First Name *</label>
                        <input type="text" name="first_name" placeholder="e.g. Juan" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Middle Name *</label>
                        <input type="text" name="middle_name" placeholder="e.g. Santos" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Last Name *</label>
                        <input type="text" name="last_name" placeholder="e.g. Dela Cruz" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user-tag"></i> Suffix (Optional)</label>
                        <input type="text" name="suffix" placeholder="e.g. Jr., III">
                    </div>
                </div>

                <!-- PROFESSIONAL DETAILS -->
                <div class="form-group">
                    <label><i class="fas fa-briefcase"></i> Designation *</label>
                    <select name="designation" class="modern-select" required>
                        <option value="">-- Select Designation --</option>
                        <option value="Director">Director</option>
                        <option value="Researcher">Researcher</option>
                        <option value="Affiliate Researcher">Affiliate Researcher</option>
                        <option value="Research Assistant">Research Assistant</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-university"></i> Institution *</label>
                        <input type="text" name="institution" placeholder="e.g. Central Luzon State University" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-building"></i> Department *</label>
                        <input type="text" name="department" placeholder="e.g. College of Science" required>
                    </div>
                </div>

                <!-- RESEARCH INTEREST -->
                <div class="form-group">
                    <label for="researchInput"><i class="fas fa-microscope"></i> Research Interests *</label>

                    <div class="research-wrapper">
                        <input 
                            type="text"
                            id="researchInput"
                            placeholder="e.g. Molecular Biology"
                            class="research-input"
                        >

                        <button 
                            type="button"
                            id="addResearchBtn"
                            class="btn-add"
                        >
                            <i class="fas fa-plus"></i> Add
                        </button>
                    </div>

                    <div id="researchTags" class="research-tags"></div>
                    <input type="hidden" name="research_interest" id="researchHidden">
                </div>

                <!-- ACCOUNT DETAILS -->
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email *</label>
                    <input type="email" name="email" placeholder="e.g. juan.delacruz@clsu.edu.ph" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Password *</label>
                        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required onkeyup="checkPasswordStrength()">
                        <div class="password-strength">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-check-circle"></i> Confirm Password *</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required onkeyup="checkPasswordMatch()">
                        <div class="match-text" id="matchText"></div>
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-user-plus"></i> Register Admin
                </button>

            </form>

        </div>

    </div>

</div>

<script>
const BASE_URL = "<?= BASE_URL ?>";

function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        menu.classList.toggle("show");
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
        } else {
            matchText.textContent = '✗ Passwords do not match';
            matchText.style.color = '#ef4444';
        }
    } else {
        matchText.textContent = '';
    }
}

// Research Interests Tags
document.addEventListener('DOMContentLoaded', function() {
    const researchInput = document.getElementById('researchInput');
    const addBtn = document.getElementById('addResearchBtn');
    const tagsContainer = document.getElementById('researchTags');
    const hiddenInput = document.getElementById('researchHidden');
    
    addBtn.addEventListener('click', function() {
        const value = researchInput.value.trim();
        if (value) {
            addTag(value);
            researchInput.value = '';
            updateHiddenInput();
        }
    });
    
    researchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addBtn.click();
        }
    });
    
    function addTag(text) {
        const tag = document.createElement('span');
        tag.className = 'research-tag';
        tag.innerHTML = `${text} <i class="fas fa-times" onclick="this.parentElement.remove(); updateHiddenInput()"></i>`;
        tagsContainer.appendChild(tag);
    }
    
    window.updateHiddenInput = function() {
        const tags = document.querySelectorAll('.research-tag');
        const values = Array.from(tags).map(tag => tag.textContent.replace('×', '').trim());
        hiddenInput.value = values.join(', ');
    };

    // Flash messages
    <?php if (!empty($_SESSION['error'])): ?>
        showToast("<?= $_SESSION['error']; ?>", "error");
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        showToast("<?= $_SESSION['success']; ?>", "success");
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
});

// Auto-expand dropdown if current page is inside
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const dropdowns = document.querySelectorAll('.dropdown-links');
    
    dropdowns.forEach(dropdown => {
        const links = dropdown.querySelectorAll('a');
        links.forEach(link => {
            if (link.href.includes(currentPath) && !link.classList.contains('active')) {
                dropdown.classList.add('show');
            }
        });
    });
});
</script>

</body>
</html>
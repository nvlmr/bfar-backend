<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - CLSD</title>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header with white background */
        .card-header {
            background: white;
            padding: 40px 30px 20px;
            text-align: center;
            position: relative;
            border-bottom: 1px solid #e5e7eb;
        }

        .logo-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            background: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 4px solid white;
        }

        .logo-wrapper img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .card-header h1 {
            color: #1e3a8a;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .card-header p {
            color: #6b7280;
            font-size: 14px;
            font-weight: 400;
        }

        /* Card body */
        .card-body {
            padding: 30px 30px 35px;
            background: white;
        }

        .description {
            text-align: center;
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 25px;
            line-height: 1.6;
            background: #f9fafb;
            padding: 15px;
            border-radius: 12px;
        }

        .description i {
            color: #2563eb;
            margin-right: 5px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .alert-success i {
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
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

        input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border-radius: 12px;
            border: 1.5px solid #e5e7eb;
            background: #f9fafb;
            color: #1f2937;
            outline: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        input::placeholder {
            color: #9ca3af;
        }

        input:focus {
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

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

        .btn {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .btn i {
            font-size: 16px;
        }

        .links {
            margin-top: 25px;
            text-align: center;
        }

        .links a {
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .links a:hover {
            color: #2563eb;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #9ca3af;
        }

        @media (max-width: 480px) {
            .card-header {
                padding: 30px 20px 15px;
            }
            
            .logo-wrapper {
                width: 80px;
                height: 80px;
            }
            
            .logo-wrapper img {
                width: 60px;
                height: 60px;
            }
            
            .card-body {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Header with white background -->
    <div class="card-header">
        <div class="logo-wrapper">
            <img src="<?= BASE_URL ?>/assets/images/logo/LSD.png" alt="CLSD Logo" onerror="this.src='https://via.placeholder.com/80?text=CLSD'">
        </div>
        <h1>CLSD</h1>
        <p>Create New Password</p>
    </div>

    <!-- Card body -->
    <div class="card-body">
        <div class="description">
            <i class="fas fa-shield-alt" style="color: #2563eb;"></i>
            Enter your new password below. Make sure it is strong and secure.
        </div>

        <!-- Error Alert -->
        <?php if (!empty($data['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <!-- Success Alert -->
        <?php if (!empty($data['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong><?= htmlspecialchars($data['success']) ?></strong>
                    <p style="margin-top: 5px; font-size: 13px;">Redirecting to login page...</p>
                </div>
            </div>

            <script>
                setTimeout(function() {
                    window.location.href = "<?= BASE_URL ?>/login";
                }, 3000);
            </script>
        <?php else: ?>

        <form method="POST" action="<?= BASE_URL ?>/reset-password" onsubmit="return validatePassword();">
            
            <input type="hidden" name="token" value="<?= htmlspecialchars($data['token'] ?? '') ?>">

            <div class="form-group">
                <label><i class="fas fa-lock"></i> New Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Enter new password"
                        onkeyup="checkPasswordStrength()"
                        required
                    >
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
            </div>

            <div class="form-group">
                <label><i class="fas fa-check-circle"></i> Confirm Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-check-circle"></i>
                    <input 
                        type="password" 
                        name="confirm_password"
                        id="confirm_password"
                        placeholder="Confirm new password"
                        onkeyup="checkPasswordMatch()"
                        required
                    >
                </div>
                <div class="strength-text" id="matchText" style="color: #6b7280;"></div>
            </div>

            <button type="submit" class="btn" id="submitBtn">
                <i class="fas fa-key"></i> Reset Password
            </button>
        </form>

        <?php endif; ?>

        <div class="links">
            <a href="<?= BASE_URL ?>/login">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>

        <div class="footer">
            © <?= date('Y') ?> CLSD. All rights reserved.
        </div>
    </div>
</div>

<script>
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
}

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

function validatePassword() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    
    if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        return false;
    }
    
    if (password !== confirm) {
        alert('Passwords do not match.');
        return false;
    }
    
    return true;
}
</script>

</body>
</html>
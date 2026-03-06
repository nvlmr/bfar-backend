<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - CLSD</title>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            overflow: hidden;
            position: relative;
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

        .login-card {
            width: 420px;
            padding: 50px 40px;
            border-radius: 24px;
            background: rgba(219, 234, 254, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: #1e3a8a;
            animation: fadeIn 0.6s ease-in-out;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container {
            margin-bottom: 15px;
        }

        .logo-container img {
            width: 80px;
            height: auto;
            border-radius: 50%;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            border: 3px solid white;
        }

        .brand h2 {
            font-size: 28px;
            letter-spacing: 1px;
            margin-bottom: 6px;
            color: #1e3a8a;
            font-weight: 700;
        }

        .brand p {
            font-size: 13px;
            color: #6b7280;
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
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid #ef4444;
            color: #b91c1c;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
            color: #047857;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 6px;
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
            color: #93c5fd;
            font-size: 16px;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            border-radius: 12px;
            border: 2px solid rgba(37, 99, 235, 0.2);
            background: white;
            color: #1e3a8a;
            outline: none;
            transition: all 0.3s;
            font-size: 14px;
        }

        input::placeholder {
            color: #93c5fd;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .login-btn {
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

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }

        .login-btn i {
            font-size: 16px;
        }

        .links {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
            transition: all 0.2s;
            display: block;
            margin-top: 8px;
            font-weight: 500;
        }

        .links a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: rgba(37, 99, 235, 0.2);
            margin: 20px 0 15px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #6b7280;
        }

        @media (max-width: 480px) {
            .login-card {
                width: 90%;
                padding: 40px 25px;
            }
            
            .logo-container img {
                width: 60px;
            }
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="brand">
        <div class="logo-container">
            <img src="<?= BASE_URL ?>/assets/images/logo/LSD.png" alt="CLSD Logo">
        </div>
        <h2>CLSD</h2>
        <p>Center for Lakes Sustainable Development</p>
    </div>

    <!-- Error Alert -->
    <?php if (!empty($data['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($data['error']) ?>
        </div>
    <?php endif; ?>

    <!-- Success Alert -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/login">

        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email Address</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Enter your email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label><i class="fas fa-lock"></i> Password</label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Enter your password"
                    required
                >
            </div>
        </div>

        <button type="submit" class="login-btn">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </button>
    </form>

    <div class="links">
        <a href="<?= BASE_URL ?>/forgot-password"><i class="fas fa-key"></i> Forgot Password?</a>
        <div class="divider"></div>
        <a href="<?= BASE_URL ?>/register"><i class="fas fa-user-plus"></i> Create an Account</a>
    </div>

    <div class="footer">
        © <?= date('Y') ?> CLSD Data System. All rights reserved.
    </div>

</div>

</body>
</html>
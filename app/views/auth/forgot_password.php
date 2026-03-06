<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - CLSD</title>
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
            padding: 0 10px;
            background: #f9fafb;
            padding: 15px;
            border-radius: 12px;
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
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }


        .alert-success a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .alert-success a:hover {
            text-decoration: underline;
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
        <p>Reset Your Password</p>
    </div>

    <!-- Card body -->
    <div class="card-body">
        <div class="description">
            <i class="fas fa-info-circle" style="color: #2563eb; margin-right: 5px;"></i>
            Enter your registered email address. If your account is active, we will send you a secure reset link.
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
                <span><?= htmlspecialchars($data['success']) ?></span>
                <?php if (!empty($data['link'])): ?>
                    <a href="<?= htmlspecialchars($data['link']) ?>">
                        <i class="fas fa-external-link-alt"></i> Click here to reset your password
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/forgot-password">
            <div class="form-group">
                <label><i class="fas fa-envelope"></i> Email Address</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Enter your registered email"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-paper-plane"></i> Send Reset Link
            </button>
        </form>

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

</body>
</html>
<?php

class Auth extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /* =========================================
       LOGIN
    ========================================= */

    public function loginForm()
    {
        $this->view('auth/login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            return $this->view('auth/login', [
                'error' => 'Please fill in all fields.'
            ]);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return $this->view('auth/login', [
                'error' => 'Invalid credentials.'
            ]);
        }

        // Account must be active
        if ($user['status'] !== 'active') {
            return $this->view('auth/login', [
                'error' => 'Your account is pending admin approval.'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->view('auth/login', [
                'error' => 'Invalid credentials.'
            ]);
        }

        // Login success
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name']  = $user['last_name'];

        // Role-based redirect
        switch ($user['role']) {
            case 'super_admin':
                header("Location: " . BASE_URL . "/superadmin/dashboard");
                break;
            case 'admin':
                header("Location: " . BASE_URL . "/admin/dashboard");
                break;
            default:
                header("Location: " . BASE_URL . "/user/dashboard");
                break;
        }

        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit;
    }

    /* =========================================
       FORGOT PASSWORD
    ========================================= */

    public function forgotForm()
    {
        $this->view('auth/forgot_password');
    }

    public function sendResetLink()
    {
        $email = trim($_POST['email']);

        if (empty($email)) {
            return $this->view('auth/forgot_password', ['error' => 'Email is required']);
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user) {
            // Do not reveal if email exists (security)
            return $this->view('auth/forgot_password', [
                'success' => 'If the account exists, a reset link has been sent.'
            ]);
        }

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $userModel->saveResetToken($email, $token, $expires);

        $resetLink = BASE_URL . "/reset-password?token=" . $token;

        $year = date("Y");

        $body = "
        <!DOCTYPE html>
        <html>
        <body style='margin:0; padding:0; background:#f4f6f8; font-family: Arial, sans-serif;'>

        <table width='100%' cellpadding='0' cellspacing='0' style='padding:40px 0;'>
        <tr>
        <td align='center'>

        <table width='600' cellpadding='0' cellspacing='0' 
        style='background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);'>

        <tr>
        <td style='background:#123b52; padding:25px; text-align:center; font-family:Arial, Helvetica, sans-serif;'>
            <span style='color:#ffffff; font-size:28px; font-weight:bold; letter-spacing:2px;'>
                CLSD
            </span>
            <div style='color:#cbd5e1; font-size:12px; margin-top:6px;'>
                Center for Lakes Sustainable Development
            </div>
        </td>
        </tr>

        <tr>
        <td style='padding:40px 30px; color:#333;'>

        <h2 style='margin-top:0;'>Reset Your Password</h2>

        <p style='font-size:15px; line-height:1.6;'>
        We received a request to reset your password. Click the button below to continue.
        </p>

        <div style='text-align:center; margin:30px 0;'>
        <a href='{$resetLink}' 
        style='background:#2bbbad; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:6px; font-size:15px; display:inline-block;'>
        Reset Password
        </a>
        </div>

        <p style='font-size:14px; color:#666;'>
        This link will expire in 1 hour for security reasons.
        </p>

        <p style='font-size:14px; color:#666;'>
        If you did not request this, you may ignore this email.
        </p>

        <hr style='border:none; border-top:1px solid #eee; margin:30px 0;'>

        <p style='font-size:13px; color:#999;'>
        If the button does not work, copy and paste this link into your browser:
        </p>

        <p style='font-size:13px; word-break:break-all; color:#2bbbad;'>
        {$resetLink}
        </p>

        </td>
        </tr>

        <tr>
        <td style='background:#f4f6f8; padding:20px; text-align:center; font-size:12px; color:#999;'>
        © {$year} CLSD Data System. All rights reserved.
        </td>
        </tr>

        </table>

        </td>
        </tr>
        </table>

        </body>
        </html>
        ";

        Mailer::send($email, "CLSD Password Reset", $body);

        return $this->view('auth/forgot_password', [
            'success' => 'If the account exists, a reset link has been sent.'
        ]);
    }

    /* =========================================
       RESET PASSWORD
    ========================================= */

    public function resetForm()
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $this->view('auth/reset', [
            'token' => $token
        ]);
    }

    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $token = $_POST['token'] ?? '';
        $password = trim($_POST['password'] ?? '');

        if (empty($token) || empty($password)) {
            return $this->view('auth/reset', [
                'error' => 'Invalid request.',
                'token' => $token
            ]);
        }

        $user = $this->userModel->findByResetToken($token);

        if (!$user) {
            return $this->view('auth/reset', [
                'error' => 'Invalid or expired token.',
                'token' => $token
            ]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($user['id'], $hashedPassword);
        $this->userModel->clearResetToken($user['id']);

        $_SESSION['success'] = "Password successfully changed. You may now login.";

        header("Location: " . BASE_URL . "/login");
        exit;
    }

    /* =========================================
       REGISTER (Placeholder)
    ========================================= */

    public function registerForm()
    {
        $this->view('auth/register');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/register");
            exit;
        }

        /* ===============================
        SANITIZE INPUT
        =============================== */

        $firstName = ucfirst(strtolower(trim($_POST['first_name'] ?? '')));
        $middleName = ucfirst(strtolower(trim($_POST['middle_name'] ?? '')));
        $lastName = ucfirst(strtolower(trim($_POST['last_name'] ?? '')));
        $suffix = strtoupper(trim($_POST['suffix'] ?? ''));
        $designation = trim($_POST['designation'] ?? '');
        $institution = trim($_POST['institution'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $researchInterest = trim($_POST['research_interest'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        /* ===============================
        VALIDATION
        =============================== */

        if (empty($firstName) || empty($lastName)) {
            $errors[] = "First name and last name are required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        if ($this->userModel->findByEmail($email)) {
            $errors[] = "Email is already registered.";
        }

        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[0-9]/', $password)
        ) {
            $errors[] = "Password must be at least 8 characters with one uppercase letter and one number.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (!empty($errors)) {
            return $this->view('auth/register', [
                'error' => implode('<br>', $errors)
            ]);
        }

        /* ===============================
        CREATE USER
        =============================== */

        $created = $this->userModel->create([
            'first_name' => $firstName,
            'middle_name' => $middleName ?: null,
            'last_name' => $lastName,
            'suffix' => $suffix ?: null,
            'designation' => $designation ?: null,
            'institution' => $institution ?: null,
            'department' => $department ?: null,
            'research_interest' => $researchInterest ?: null,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'inactive'
        ]);

        if ($created) {

            $_SESSION['success'] = "Registration successful. Your account is pending admin approval.";

            header("Location: " . BASE_URL . "/login");
            exit;

        } else {

            return $this->view('auth/register', [
                'error' => 'Registration failed. Please try again.'
            ]);
        }
    }
}
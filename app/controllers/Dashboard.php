<?php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class Dashboard extends Controller
{
    /* ================= SUPER ADMIN DASHBOARD ================= */

    public function superAdmin()
    {
        Middleware::auth();
        Middleware::role('super_admin');

        $userModel = $this->model('User');

        $stats = $userModel->getDashboardStats();

        $data = [
            'totalUsers'      => $stats['totalUsers'] ?? 0,
            'totalAdmins'     => $stats['totalAdmins'] ?? 0,
            'activeUsers'     => $stats['activeUsers'] ?? 0,
            'inactiveUsers'   => $stats['inactiveUsers'] ?? 0,
            'activeAdmins'    => $stats['activeAdmins'] ?? 0,
            'inactiveAdmins'  => $stats['inactiveAdmins'] ?? 0
        ];

        $this->view('superadmin/s_dashboard', $data);
    }

    /* ================= USERS PAGE ================= */

    public function users()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('super_admin');

        $userModel = $this->model('User');

        $search = $_GET['search'] ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $data['users'] = $userModel->getPaginatedByRole('user', $search, $limit, $offset);
        $data['total'] = $userModel->countPaginatedByRole('user', $search);

        $data['search'] = $search;
        $data['page']   = $page;
        $data['limit']  = $limit;

        $this->view('superadmin/users', $data);
    }

    /* ================= ADMINS PAGE ================= */

    public function admins()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('super_admin');

        $userModel = $this->model('User');

        $search = $_GET['search'] ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $data['admins'] = $userModel->getPaginatedByRole('admin', $search, $limit, $offset);
        $data['total']  = $userModel->countPaginatedByRole('admin', $search);

        $data['search'] = $search;
        $data['page']   = $page;
        $data['limit']  = $limit;

        $this->view('superadmin/admins', $data);
    }

    /* ================= TOGGLE USER STATUS ================= */

    public function toggleUser()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('super_admin');

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false]);
            return;
        }

        $id     = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$id || !in_array($status, ['active', 'inactive'])) {
            http_response_code(400);
            echo json_encode(['success' => false]);
            return;
        }

        $userModel = $this->model('User');
        $user      = $userModel->findById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['success' => false]);
            return;
        }

        // Prevent super admin from deactivating themselves
        if ($user['id'] == $_SESSION['user_id']) {
            http_response_code(403);
            echo json_encode(['success' => false]);
            return;
        }

        $updated = $userModel->updateStatus($id, $status);

        if (!$updated) {
            http_response_code(500);
            echo json_encode(['success' => false]);
            return;
        }

        echo json_encode([
            'success' => true,
            'id'      => $id,
            'status'  => $status
        ]);
    }

    /* ================= ADMIN REGISTRATION FORM ================= */

    public function registerAdminForm()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('super_admin');

        $this->view('superadmin/register');
    }

    /* ================= REGISTER ADMIN ================= */

    public function registerAdmin()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('super_admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        /* ================= INPUT ================= */

        $firstName  = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName   = trim($_POST['last_name'] ?? '');
        $suffix     = trim($_POST['suffix'] ?? '');

        $designation      = trim($_POST['designation'] ?? '');
        $institution      = trim($_POST['institution'] ?? '');
        $department       = trim($_POST['department'] ?? '');
        $researchInterest = trim($_POST['research_interest'] ?? '');

        $email           = trim($_POST['email'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        /* ================= REQUIRED FIELDS ================= */

        if (!$firstName || !$lastName || !$email || !$password || !$confirmPassword) {
            $_SESSION['error'] = "First name, last name, email and passwords are required.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        /* ================= EMAIL VALIDATION ================= */

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        /* ================= PASSWORD MATCH ================= */

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        /* ================= PASSWORD STRENGTH ================= */

        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password)
        ) {
            $_SESSION['error'] = "Password must be at least 8 characters and contain uppercase, lowercase, and a number.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        /* ================= DUPLICATE EMAIL CHECK ================= */

        $userModel = $this->model('User');

        if ($userModel->emailExists($email)) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        /* ================= CREATE ADMIN ================= */

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $created = $userModel->create([
            'first_name'        => htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'),
            'middle_name'       => htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8'),
            'last_name'         => htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'),
            'suffix'            => htmlspecialchars($suffix, ENT_QUOTES, 'UTF-8'),
            'designation'       => htmlspecialchars($designation, ENT_QUOTES, 'UTF-8'),
            'institution'       => htmlspecialchars($institution, ENT_QUOTES, 'UTF-8'),
            'department'        => htmlspecialchars($department, ENT_QUOTES, 'UTF-8'),
            'research_interest' => htmlspecialchars($researchInterest, ENT_QUOTES, 'UTF-8'),
            'email'             => $email,
            'password'          => $hashedPassword,
            'role'              => 'admin',
            'status'            => 'active'
        ]);

        if (!$created) {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("Location: " . BASE_URL . "/superadmin/register");
            exit;
        }

        $_SESSION['success'] = "Admin registered successfully.";
        header("Location: " . BASE_URL . "/superadmin/admins");
        exit;
    }
    public function admin()
    {
        // Role protection
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASE_URL . "/login");
            exit;
    }

    // Temporary simple view load (no data yet)
    return $this->view('admin/a_dashboard');
    }
}
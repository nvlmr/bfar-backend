<?php
// app/controllers/ResearchTeamController.php

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../middleware/RoleMiddleware.php';

class ResearchTeamController extends Controller
{
    /**
     * Display list of researchers (Admin only)
     */
    public function index()
    {
        // Protect route - only authenticated admins can access
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Load the ResearchTeam model
        $researchTeamModel = $this->model('ResearchTeam');

        // Get search parameter if any
        $search = $_GET['search'] ?? '';

        // Get all researchers with optional search
        $researchers = $researchTeamModel->getAll($search);

        // Prepare data for view
        $data = [
            'researchers' => $researchers,
            'search' => $search
        ];

        // Load the view
        $this->view('research-team/index', $data);
    }

    /**
     * Show create researcher form
     */
    public function create()
    {
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        $researchTeamModel = $this->model('ResearchTeam');
        $directorExists = $researchTeamModel->directorExists();

        $data = [
            'directorExists' => $directorExists
        ];

        $this->view('research-team/create', $data);
    }

    /**
     * Store new researcher
     */
    public function store()
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        /* ================= INPUT VALIDATION ================= */

        $firstName  = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName   = trim($_POST['last_name'] ?? '');
        $suffix     = trim($_POST['suffix'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $institution = trim($_POST['institution'] ?? '');
        $researchInterest = trim($_POST['research_interest'] ?? '');
        $status = isset($_POST['status']) ? 1 : 0;

        /* ================= REQUIRED FIELDS ================= */

        if (!$firstName || !$lastName || !$email || !$designation || !$institution) {
            $_SESSION['error'] = "First name, last name, email, designation, and institution are required.";
            header("Location: " . BASE_URL . "/admin/research-team/create");
            exit;
        }

        /* ================= EMAIL VALIDATION ================= */

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            header("Location: " . BASE_URL . "/admin/research-team/create");
            exit;
        }

        /* ================= CHECK FOR DUPLICATE EMAIL ================= */

        $researchTeamModel = $this->model('ResearchTeam');
        
        if ($researchTeamModel->emailExists($email)) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: " . BASE_URL . "/admin/research-team/create");
            exit;
        }

        /* ================= HANDLE IMAGE UPLOAD ================= */

        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $this->uploadImage($_FILES['image']);
            if (!$imageName) {
                $_SESSION['error'] = "Failed to upload image. Please check file type and size (max 5MB, JPG/PNG/GIF).";
                header("Location: " . BASE_URL . "/admin/research-team/create");
                exit;
            }
        }

        /* ================= CREATE RESEARCHER ================= */

        $data = [
            'user_id' => $_SESSION['user_id'] ?? 1,
            'first_name' => htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'),
            'middle_name' => $middleName ? htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8') : null,
            'last_name' => htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'),
            'suffix' => $suffix ? htmlspecialchars($suffix, ENT_QUOTES, 'UTF-8') : null,
            'email' => $email,
            'designation' => htmlspecialchars($designation, ENT_QUOTES, 'UTF-8'),
            'department' => $department ? htmlspecialchars($department, ENT_QUOTES, 'UTF-8') : null,
            'institution' => htmlspecialchars($institution, ENT_QUOTES, 'UTF-8'),
            'research_interest' => $researchInterest ? htmlspecialchars($researchInterest, ENT_QUOTES, 'UTF-8') : null,
            'status' => $status
        ];

        $created = $researchTeamModel->create($data, $imageName);

        if (!$created) {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("Location: " . BASE_URL . "/admin/research-team/create");
            exit;
        }

        $_SESSION['success'] = "Researcher added successfully.";
        header("Location: " . BASE_URL . "/admin/research-team");
        exit;
    }

    /**
     * Show edit researcher form
     */
    public function edit($id)
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        $researchTeamModel = $this->model('ResearchTeam');
        $researcher = $researchTeamModel->getById($id);

        if (!$researcher) {
            $_SESSION['error'] = "Researcher not found.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $data = [
            'researcher' => $researcher
        ];

        $this->view('research-team/edit', $data);
    }

    /**
     * Update researcher
     */
    public function update($id)
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $researchTeamModel = $this->model('ResearchTeam');
        
        // Check if researcher exists
        $existing = $researchTeamModel->getById($id);
        if (!$existing) {
            $_SESSION['error'] = "Researcher not found.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        /* ================= INPUT VALIDATION ================= */

        $firstName  = trim($_POST['first_name'] ?? '');
        $middleName = trim($_POST['middle_name'] ?? '');
        $lastName   = trim($_POST['last_name'] ?? '');
        $suffix     = trim($_POST['suffix'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $institution = trim($_POST['institution'] ?? '');
        $researchInterest = trim($_POST['research_interest'] ?? '');
        $status = isset($_POST['status']) ? 1 : 0;

        /* ================= REQUIRED FIELDS ================= */

        if (!$firstName || !$lastName || !$email || !$designation || !$institution) {
            $_SESSION['error'] = "First name, last name, email, designation, and institution are required.";
            header("Location: " . BASE_URL . "/admin/research-team/edit/" . $id);
            exit;
        }

        /* ================= EMAIL VALIDATION ================= */

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format.";
            header("Location: " . BASE_URL . "/admin/research-team/edit/" . $id);
            exit;
        }

        /* ================= CHECK FOR DUPLICATE EMAIL (excluding current) ================= */

        if ($researchTeamModel->emailExistsExcludingId($email, $id)) {
            $_SESSION['error'] = "Email already exists.";
            header("Location: " . BASE_URL . "/admin/research-team/edit/" . $id);
            exit;
        }

        /* ================= HANDLE IMAGE UPLOAD ================= */

        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $this->uploadImage($_FILES['image']);
            if (!$imageName) {
                $_SESSION['error'] = "Failed to upload image. Please check file type and size (max 5MB, JPG/PNG/GIF).";
                header("Location: " . BASE_URL . "/admin/research-team/edit/" . $id);
                exit;
            }
            
            // Delete old image if exists
            if ($existing->image && file_exists(__DIR__ . '/../../public/uploads/research/' . $existing->image)) {
                unlink(__DIR__ . '/../../public/uploads/research/' . $existing->image);
            }
        }

        /* ================= UPDATE RESEARCHER ================= */

        $data = [
            'first_name' => htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8'),
            'middle_name' => $middleName ? htmlspecialchars($middleName, ENT_QUOTES, 'UTF-8') : null,
            'last_name' => htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8'),
            'suffix' => $suffix ? htmlspecialchars($suffix, ENT_QUOTES, 'UTF-8') : null,
            'email' => $email,
            'designation' => htmlspecialchars($designation, ENT_QUOTES, 'UTF-8'),
            'department' => $department ? htmlspecialchars($department, ENT_QUOTES, 'UTF-8') : null,
            'institution' => htmlspecialchars($institution, ENT_QUOTES, 'UTF-8'),
            'research_interest' => $researchInterest ? htmlspecialchars($researchInterest, ENT_QUOTES, 'UTF-8') : null,
            'status' => $status
        ];

        $updated = $researchTeamModel->update($id, $data, $imageName);

        if (!$updated) {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("Location: " . BASE_URL . "/admin/research-team/edit/" . $id);
            exit;
        }

        $_SESSION['success'] = "Researcher updated successfully.";
        header("Location: " . BASE_URL . "/admin/research-team");
        exit;
    }

    /**
     * Delete researcher (PERMANENTLY removes from database)
     */
    public function delete()
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Invalid researcher ID.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $researchTeamModel = $this->model('ResearchTeam');
        
        // Check if researcher exists
        $researcher = $researchTeamModel->getById($id);
        if (!$researcher) {
            $_SESSION['error'] = "Researcher not found.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        // Delete from database (PERMANENT)
        $deleted = $researchTeamModel->delete($id);

        if (!$deleted) {
            $_SESSION['error'] = "Failed to delete researcher.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        // Delete image file if exists
        if ($researcher->image && file_exists(__DIR__ . '/../../public/uploads/research/' . $researcher->image)) {
            unlink(__DIR__ . '/../../public/uploads/research/' . $researcher->image);
        }

        $_SESSION['success'] = "Researcher deleted successfully.";
        header("Location: " . BASE_URL . "/admin/research-team");
        exit;
    }

    /**
     * Publish researcher (set status to 1)
     * This ONLY changes the status field, all other data remains
     */
    public function publish()
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Invalid researcher ID.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $researchTeamModel = $this->model('ResearchTeam');
        
        // Check if researcher exists
        $researcher = $researchTeamModel->getById($id);
        if (!$researcher) {
            $_SESSION['error'] = "Researcher not found.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        // Update ONLY the status to 1 (published)
        // All other data remains exactly the same
        $data = ['status' => 1];
        $updated = $researchTeamModel->update($id, $data, null);

        if (!$updated) {
            $_SESSION['error'] = "Failed to publish researcher.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $_SESSION['success'] = "Researcher published successfully.";
        header("Location: " . BASE_URL . "/admin/research-team");
        exit;
    }

    /**
     * Move researcher to draft (set status to 0)
     * This ONLY changes the status field, all other data remains
     */
    public function draft()
    {
        // Protect route
        AuthMiddleware::handle();
        RoleMiddleware::handle('admin');

        // Check if POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "Invalid researcher ID.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $researchTeamModel = $this->model('ResearchTeam');
        
        // Check if researcher exists
        $researcher = $researchTeamModel->getById($id);
        if (!$researcher) {
            $_SESSION['error'] = "Researcher not found.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        // Update ONLY the status to 0 (draft)
        // All other data remains exactly the same
        $data = ['status' => 0];
        $updated = $researchTeamModel->update($id, $data, null);

        if (!$updated) {
            $_SESSION['error'] = "Failed to move researcher to draft.";
            header("Location: " . BASE_URL . "/admin/research-team");
            exit;
        }

        $_SESSION['success'] = "Researcher moved to draft successfully.";
        header("Location: " . BASE_URL . "/admin/research-team");
        exit;
    }

    /**
     * Upload image helper method
     */
    private function uploadImage($file)
    {
        $targetDir = __DIR__ . '/../../public/uploads/research/';
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate unique filename
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $targetFile = $targetDir . $fileName;
        
        // Check if image file is actual image
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return false;
        }
        
        // Check file size (max 5MB)
        if ($file['size'] > 5000000) {
            return false;
        }
        
        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($extension, $allowedTypes)) {
            return false;
        }
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        }
        
        return false;
    }
}
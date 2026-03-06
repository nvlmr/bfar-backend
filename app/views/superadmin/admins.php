<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Admins - CLSD</title>
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

    /* Content Area */
    .content-area {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* Table Header with Search */
    .table-header {
        margin-bottom: 25px;
        display: flex;
        justify-content: flex-end;
    }

    .table-header form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-input {
        padding: 12px 20px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        width: 300px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    .btn-search {
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-search:hover {
        background: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-search i {
        font-size: 14px;
    }

    /* Table Styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead tr {
        background: #f9fafb;
        border-radius: 12px;
    }

    .table th {
        padding: 18px 15px;
        text-align: left;
        font-weight: 600;
        color: #4b5563;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 18px 15px;
        border-bottom: 1px solid #f3f4f6;
        color: #1f2937;
        font-size: 14px;
    }

    .table tbody tr:hover td {
        background: #f9fafb;
    }

    /* Status Badges */
    .badge-active {
        background: #10b981;
        color: white;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-inactive {
        background: #ef4444;
        color: white;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-active i, .badge-inactive i {
        font-size: 10px;
    }

    /* Action Buttons */
    .btn-danger-modern {
        background: #ef4444;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-danger-modern:hover {
        background: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-success-modern {
        background: #10b981;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-success-modern:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }

    .page-btn {
        background: white;
        color: #2563eb;
        border: 2px solid #2563eb;
        padding: 8px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .page-btn:hover {
        background: #2563eb;
        color: white;
    }

    .page-number {
        color: #6b7280;
        font-size: 14px;
    }

    /* Modal Styles */
    .modern-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modern-modal-box {
        background: white;
        border-radius: 20px;
        padding: 30px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .modal-header h3 {
        color: #1e3a8a;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #9ca3af;
    }

    .modal-close:hover {
        color: #ef4444;
    }

    .modal-text {
        color: #6b7280;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .modern-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 20px;
        outline: none;
        font-size: 14px;
    }

    .modern-input:focus {
        border-color: #2563eb;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #6b7280;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    .btn-confirm {
        background: #ef4444;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-confirm:hover {
        background: #dc2626;
    }

    .btn-confirm:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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

    .toast i {
        font-size: 20px;
    }

    .toast.success i {
        color: #10b981;
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
        .table-header form {
            flex-direction: column;
            width: 100%;
        }
        .search-input {
            width: 100%;
        }
        .table {
            display: block;
            overflow-x: auto;
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
            <a href="<?= BASE_URL ?>/superadmin/admins" class="active">
                <i class="fas fa-user-shield"></i> Admins
            </a>
        </div>
    </div>

    <a href="<?= BASE_URL ?>/superadmin/register">
        <i class="fas fa-user-plus"></i> Admin Registration
    </a>

    <a href="<?= BASE_URL ?>/logout">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="main">

    <div class="topbar">
        <h1>
            <i class="fas fa-user-shield"></i> Manage Admins
        </h1>
        <span>
            <i class="fas fa-user-circle"></i>
            Welcome, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Super Admin') ?>
        </span>
    </div>

    <div class="content-area">

        <!-- SEARCH -->
        <div class="table-header">
            <form method="GET">
                <input type="text"
                       name="search"
                       value="<?= htmlspecialchars($data['search'] ?? '') ?>"
                       placeholder="Search by name or email..."
                       class="search-input">
                <button type="submit" class="btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        <!-- TABLE -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Designation</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($data['admins'])): ?>
                <?php foreach ($data['admins'] as $admin): ?>

                    <?php
                        $fullName = $admin['first_name'];

                        if (!empty($admin['middle_name'])) {
                            $fullName .= ' ' . $admin['middle_name'];
                        }

                        $fullName .= ' ' . $admin['last_name'];

                        if (!empty($admin['suffix'])) {
                            $fullName .= ' ' . $admin['suffix'];
                        }
                    ?>

                <tr>
                    <td><?= $admin['id'] ?></td>

                    <td><?= htmlspecialchars($fullName) ?></td>

                    <td>
                        <?= !empty($admin['designation']) 
                            ? htmlspecialchars($admin['designation']) 
                            : '<span style="color:#9ca3af;">—</span>' ?>
                    </td>

                    <td><?= htmlspecialchars($admin['email']) ?></td>

                    <td id="user-status-<?= $admin['id'] ?>">
                        <?php if ($admin['status'] === 'active'): ?>
                            <span class="badge-active"><i class="fas fa-check-circle"></i> Active</span>
                        <?php else: ?>
                            <span class="badge-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                        <?php endif; ?>
                    </td>

                    <td id="user-action-<?= $admin['id'] ?>">
                        <?php if ($admin['status'] === 'active'): ?>
                            <button class="btn-danger-modern"
                                onclick="confirmDeactivate(<?= $admin['id'] ?>, '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>')">
                                <i class="fas fa-ban"></i> Deactivate
                            </button>
                        <?php else: ?>
                            <button class="btn-success-modern"
                                onclick="confirmActivate(<?= $admin['id'] ?>, '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>')">
                                <i class="fas fa-check"></i> Activate
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px;">
                        <i class="fas fa-user-shield" style="font-size: 48px; color: #d1d5db; margin-bottom: 15px; display: block;"></i>
                        <p style="color: #6b7280;">No admins found.</p>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- PAGINATION -->
        <?php
        $totalPages = ceil(($data['total'] ?? 0) / ($data['limit'] ?? 10));
        $currentPage = $data['page'] ?? 1;
        ?>

        <?php if ($totalPages > 1): ?>
        <div class="pagination">

            <?php if ($currentPage > 1): ?>
                <a href="?search=<?= urlencode($data['search']) ?>&page=<?= $currentPage - 1 ?>"
                   class="page-btn"><i class="fas fa-chevron-left"></i> Prev</a>
            <?php endif; ?>

            <span class="page-number">
                Page <?= $currentPage ?> of <?= $totalPages ?>
            </span>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?search=<?= urlencode($data['search']) ?>&page=<?= $currentPage + 1 ?>"
                   class="page-btn">Next <i class="fas fa-chevron-right"></i></a>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</div>

<!-- CONFIRMATION MODAL -->
<div id="confirmModal" class="modern-modal">
    <div class="modern-modal-box">

        <div class="modal-header">
            <h3 id="modalTitle"></h3>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>

        <p id="modalText" class="modal-text"></p>

        <input type="text"
               id="confirmInput"
               class="modern-input"
               placeholder="Type 'CONFIRM' to proceed">

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button id="confirmBtn" class="btn-confirm" disabled>Confirm</button>
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

// Modal functions
let currentUserId = null;
let currentAction = null;

function confirmDeactivate(id, name) {
    currentUserId = id;
    currentAction = 'deactivate';
    
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> Deactivate Admin';
    document.getElementById('modalText').innerHTML = `Are you sure you want to deactivate <strong>${name}</strong>? They will lose access to the system.`;
    document.getElementById('confirmInput').value = '';
    document.getElementById('confirmBtn').disabled = true;
    document.getElementById('confirmModal').style.display = 'flex';
}

function confirmActivate(id, name) {
    currentUserId = id;
    currentAction = 'activate';
    
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i> Activate Admin';
    document.getElementById('modalText').innerHTML = `Are you sure you want to activate <strong>${name}</strong>? They will regain access to the system.`;
    document.getElementById('confirmInput').value = '';
    document.getElementById('confirmBtn').disabled = true;
    document.getElementById('confirmModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
}

// Enable confirm button when typing CONFIRM
document.getElementById('confirmInput')?.addEventListener('input', function(e) {
    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.disabled = e.target.value !== 'CONFIRM';
});

// Handle confirm action
document.getElementById('confirmBtn')?.addEventListener('click', function() {
    if (!currentUserId || !currentAction) return;
    
    // Show success message
    closeModal();
    showToast(`Admin ${currentAction}d successfully`, 'success');
    
    // Reload page after 1 second
    setTimeout(() => {
        location.reload();
    }, 1000);
});

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

<?php if (!empty($_SESSION['success'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    showToast("<?= $_SESSION['success']; ?>", "success");
});
</script>
<?php unset($_SESSION['success']); ?>
<?php endif; ?>

</body>
</html>
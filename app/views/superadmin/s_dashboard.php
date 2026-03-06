<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Super Admin Dashboard - CLSD</title>
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

    /* Stats Grid */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-left: 5px solid transparent;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .card.total {
        border-left-color: #2563eb;
    }

    .card.admin {
        border-left-color: #8b5cf6;
    }

    .card.active {
        border-left-color: #10b981;
    }

    .card.inactive {
        border-left-color: #ef4444;
    }

    .card h3 {
        color: #6b7280;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card h3 i {
        color: #2563eb;
        font-size: 16px;
    }

    .card h2 {
        color: #1f2937;
        font-size: 36px;
        font-weight: 700;
        line-height: 1.2;
    }

    .card small {
        display: block;
        margin-top: 10px;
        color: #9ca3af;
        font-size: 12px;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-text h2 {
        color: #1e3a8a;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .welcome-text p {
        color: #6b7280;
        font-size: 14px;
    }

    .welcome-icon {
        width: 60px;
        height: 60px;
        background: #eff6ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 24px;
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
        .stats {
            grid-template-columns: 1fr;
        }
        .welcome-banner {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>CLSD</h2>

    <a href="<?= BASE_URL ?>/superadmin/dashboard" class="active">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('manageMenu')">
            <i class="fas fa-users-cog"></i> Manage Accounts ▼
        </div>

        <div class="dropdown-links" id="manageMenu">
            <a href="<?= BASE_URL ?>/superadmin/users">
                <i class="fas fa-user"></i> Users
            </a>
            <a href="<?= BASE_URL ?>/superadmin/admins">
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
            <i class="fas fa-tachometer-alt"></i> Super Admin Dashboard
        </h1>
        <span>
            <i class="fas fa-user-circle"></i>
            <?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Super Admin'; ?>
        </span>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-text">
            <h2>Welcome back, <?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Super Admin'; ?>!</h2>
            <p>Here's what's happening with your platform today.</p>
        </div>
        <div class="welcome-icon">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>

    <div class="stats">
        <!-- Row 1 -->
        <div class="card total">
            <h3><i class="fas fa-users"></i> Total Users</h3>
            <h2><?= number_format($data['totalUsers'] ?? 0) ?></h2>
            <small>All registered users</small>
        </div>

        <div class="card admin">
            <h3><i class="fas fa-user-shield"></i> Total Admins</h3>
            <h2><?= number_format($data['totalAdmins'] ?? 0) ?></h2>
            <small>All administrators</small>
        </div>

        <!-- Row 2 -->
        <div class="card active">
            <h3><i class="fas fa-check-circle"></i> Active Users</h3>
            <h2><?= number_format($data['activeUsers'] ?? 0) ?></h2>
            <small>Currently active accounts</small>
        </div>

        <div class="card inactive">
            <h3><i class="fas fa-times-circle"></i> Inactive Users</h3>
            <h2><?= number_format($data['inactiveUsers'] ?? 0) ?></h2>
            <small>Disabled accounts</small>
        </div>

        <!-- Row 3 -->
        <div class="card active">
            <h3><i class="fas fa-check-circle"></i> Active Admins</h3>
            <h2><?= number_format($data['activeAdmins'] ?? 0) ?></h2>
            <small>Active administrators</small>
        </div>

        <div class="card inactive">
            <h3><i class="fas fa-times-circle"></i> Inactive Admins</h3>
            <h2><?= number_format($data['inactiveAdmins'] ?? 0) ?></h2>
            <small>Disabled administrators</small>
        </div>
    </div>
</div>

<script>
function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        menu.classList.toggle("show");
    }
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

</body>
</html>
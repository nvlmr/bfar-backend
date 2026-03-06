<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - CLSD</title>
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

    /* Sidebar Styles - Using blue-100 background */
    .sidebar {
        width: 280px;
        background: #dbeafe; /* blue-100 */
        color: #1e3a8a; /* blue-900 for contrast */
        padding: 25px 0;
        box-shadow: 5px 0 15px rgba(37, 99, 235, 0.2);
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
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    .sidebar > a, .dropdown-title {
        display: block;
        padding: 12px 25px;
        color: #1e40af; /* blue-800 */
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        cursor: pointer;
    }

    .sidebar > a:hover, .dropdown-title:hover {
        background: linear-gradient(135deg, #2563eb20 0%, #1e40af20 100%);
        color: #2563eb; /* blue-600 */
        padding-left: 30px;
    }

    .sidebar > a.active {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        color: white;
        border-radius: 0 10px 10px 0;
    }

    .dropdown-links {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background: rgba(37, 99, 235, 0.05); /* blue-600 with opacity */
    }

    .dropdown-links.show {
        max-height: 300px;
        transition: max-height 0.5s ease-in;
    }

    .dropdown-links a {
        display: block;
        padding: 10px 40px;
        color: #1e40af; /* blue-800 */
        text-decoration: none;
        font-size: 0.9em;
        transition: all 0.3s ease;
    }

    .dropdown-links a:hover {
        background: linear-gradient(135deg, #2563eb15 0%, #1e40af15 100%);
        color: #2563eb; /* blue-600 */
        padding-left: 45px;
    }

    .dropdown-links a.active {
        color: #2563eb; /* blue-600 */
        font-weight: 600;
        border-left: 3px solid #2563eb; /* blue-600 */
    }

    /* Main Content Styles */
    .main {
        flex: 1;
        margin-left: 280px;
        padding: 30px;
    }

    .topbar {
        background: #dbeafe; /* blue-100 */
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
    }

    .topbar h1 {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .topbar span {
        color: #1e40af; /* blue-800 */
        font-weight: 500;
        background: rgba(37, 99, 235, 0.1); /* blue-600 with opacity */
        padding: 8px 20px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Stats Cards */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .card {
        background: #dbeafe; /* blue-100 */
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.3);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
    }

    .card.total::before {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
    }

    .card h3 {
        color: #1e40af; /* blue-800 */
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card h2 {
        color: #1e3a8a; /* blue-900 */
        font-size: 24px;
        font-weight: 600;
        line-height: 1.4;
    }

    /* Quick Stats Section */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-top: 30px;
    }

    .stat-item {
        background: #dbeafe; /* blue-100 */
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.3);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2563eb20 0%, #1e40af20 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: #2563eb; /* blue-600 */
    }

    .stat-content h4 {
        color: #1e40af; /* blue-800 */
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-content .number {
        color: #1e3a8a; /* blue-900 */
        font-size: 28px;
        font-weight: 700;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Recent Activity Section */
    .recent-activity {
        background: #dbeafe; /* blue-100 */
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        margin-top: 30px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
    }

    .recent-activity h3 {
        color: #1e3a8a; /* blue-900 */
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-list {
        list-style: none;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(37, 99, 235, 0.2);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        border-radius: 50%;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content p {
        color: #1e40af; /* blue-800 */
        font-size: 14px;
        margin-bottom: 5px;
    }

    .activity-time {
        color: #3b82f6; /* blue-500 */
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(37, 99, 235, 0.1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        border-radius: 10px;
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
        .stats, .quick-stats {
            grid-template-columns: 1fr;
        }
    }

    /* Welcome Banner Enhancement - Updated to blue gradient */
    .welcome-banner {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); /* blue-600 to blue-800 */
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .welcome-banner h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
    }

    .welcome-banner p {
        font-size: 16px;
        opacity: 0.9;
        position: relative;
    }

    /* Additional blue elements */
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
    }
</style>
</head>
<body>

<div class="sidebar">
    <h2>CLSD</h2>

    <a href="<?= BASE_URL ?>/admin/dashboard" class="active">
        <i class="fas fa-dashboard" style="margin-right: 10px;"></i> Dashboard
    </a>

    <!-- Research and Development -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('researchMenu')">
            <i class="fas fa-flask" style="margin-right: 10px;"></i> Research and Development ▼
        </div>

        <div class="dropdown-links" id="researchMenu">
            <a href="<?= BASE_URL ?>/admin/research-team"><i class="fas fa-users" style="margin-right: 8px; width: 20px;"></i> Research Team</a>
            <a href="<?= BASE_URL ?>/admin/clsd-project"><i class="fas fa-project-diagram" style="margin-right: 8px; width: 20px;"></i> CLSD Project</a>
            <a href="<?= BASE_URL ?>/admin/research-paper"><i class="fas fa-file-alt" style="margin-right: 8px; width: 20px;"></i> CLSD Research Paper</a>
            <a href="<?= BASE_URL ?>/admin/lakes-database"><i class="fas fa-database" style="margin-right: 8px; width: 20px;"></i> Philippine Lakes DB</a>
        </div>
    </div>

    <!-- Science and Research -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('scienceMenu')">
            <i class="fas fa-microscope" style="margin-right: 10px;"></i> Science and Research ▼
        </div>

        <div class="dropdown-links" id="scienceMenu">
            <a href="<?= BASE_URL ?>/admin/dost-projects"><i class="fas fa-flask" style="margin-right: 8px; width: 20px;"></i> DOST Funded Projects</a>
        </div>
    </div>

    <!-- Media -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('mediaMenu')">
            <i class="fas fa-play-circle" style="margin-right: 10px;"></i> Media ▼
        </div>

        <div class="dropdown-links" id="mediaMenu">
            <a href="<?= BASE_URL ?>/admin/videos"><i class="fas fa-video" style="margin-right: 8px; width: 20px;"></i> Video Gallery</a>
            <a href="<?= BASE_URL ?>/admin/iec-materials"><i class="fas fa-file-pdf" style="margin-right: 8px; width: 20px;"></i> IEC Materials</a>
        </div>
    </div>

    <!-- Projects and Events -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('projectsMenu')">
            <i class="fas fa-calendar-alt" style="margin-right: 10px;"></i> Projects and Events ▼
        </div>

        <div class="dropdown-links" id="projectsMenu">
            <a href="<?= BASE_URL ?>/admin/projects"><i class="fas fa-tasks" style="margin-right: 8px; width: 20px;"></i> Projects</a>
            <a href="<?= BASE_URL ?>/admin/events"><i class="fas fa-calendar-check" style="margin-right: 8px; width: 20px;"></i> Events</a>
        </div>
    </div>

    <a href="<?= BASE_URL ?>/logout">
        <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
    </a>
</div>

<div class="main">

    <div class="topbar">
        <h1>
            <i class="fas fa-dashboard"></i>
            Admin Dashboard
        </h1>
        <span>
            <i class="fas fa-user-circle"></i>
            <?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) : 'Admin'; ?>
        </span>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <h2>Welcome back, <?= isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'Admin'; ?>! 👋</h2>
        <p>Manage your content, track performance, and monitor activities from your central dashboard.</p>
    </div>

    <!-- Main Stats Card -->
    <div class="stats">
        <div class="card total">
            <h3><i class="fas fa-cog" style="margin-right: 8px;"></i> Content Management Panel</h3>
            <h2>Manage Website Content</h2>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h4>Total Researchers</h4>
                <span class="number">24</span>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <h4>Research Papers</h4>
                <span class="number">156</span>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="stat-content">
                <h4>Active Projects</h4>
                <span class="number">12</span>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h4>Upcoming Events</h4>
                <span class="number">8</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <h3>
            <i class="fas fa-history" style="color: #2563eb;"></i>
            Recent Activity
        </h3>
        
        <ul class="activity-list">
            <li class="activity-item">
                <div class="activity-dot"></div>
                <div class="activity-content">
                    <p>New research paper added: "Climate Change Impact on Philippine Lakes"</p>
                    <div class="activity-time">
                        <i class="far fa-clock"></i>
                        5 minutes ago
                    </div>
                </div>
            </li>

            <li class="activity-item">
                <div class="activity-dot"></div>
                <div class="activity-content">
                    <p>Dr. Maria Santos joined the research team</p>
                    <div class="activity-time">
                        <i class="far fa-clock"></i>
                        2 hours ago
                    </div>
                </div>
            </li>

            <li class="activity-item">
                <div class="activity-dot"></div>
                <div class="activity-content">
                    <p>DOST Project: "Lake Biodiversity Study" updated to 75% completion</p>
                    <div class="activity-time">
                        <i class="far fa-clock"></i>
                        5 hours ago
                    </div>
                </div>
            </li>

            <li class="activity-item">
                <div class="activity-dot"></div>
                <div class="activity-content">
                    <p>New video uploaded to Media Gallery: "Lake Conservation Techniques"</p>
                    <div class="activity-time">
                        <i class="far fa-clock"></i>
                        1 day ago
                    </div>
                </div>
            </li>
        </ul>
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
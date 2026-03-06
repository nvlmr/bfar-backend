<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Research Team - CLSD Admin</title>
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
            background: #dbeafe;
            backdrop-filter: blur(10px);
            color: #1e3a8a;
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
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .sidebar > a, .dropdown-title {
            display: block;
            padding: 12px 25px;
            color: #1e40af;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            cursor: pointer;
        }

        .sidebar > a:hover, .dropdown-title:hover {
            background: linear-gradient(135deg, #2563eb20 0%, #1e40af20 100%);
            color: #2563eb;
            padding-left: 30px;
        }

        .sidebar > a.active {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border-radius: 0 10px 10px 0;
        }

        .dropdown-links {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background: rgba(37, 99, 235, 0.05);
        }

        .dropdown-links.show {
            max-height: 300px;
            transition: max-height 0.5s ease-in;
        }

        .dropdown-links a {
            display: block;
            padding: 10px 40px;
            color: #1e40af;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }

        .dropdown-links a:hover {
            background: linear-gradient(135deg, #2563eb15 0%, #1e40af15 100%);
            color: #2563eb;
            padding-left: 45px;
        }

        .dropdown-links a.active {
            color: #2563eb;
            font-weight: 600;
            border-left: 3px solid #2563eb;
        }

        /* Main Content Styles */
        .main {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .topbar {
            background: #dbeafe;
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
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar span {
            color: #1e40af;
            font-weight: 500;
            background: rgba(37, 99, 235, 0.1);
            padding: 8px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
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

        /* Content Header */
        .content-header {
            background: #dbeafe;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        }

        .btn-add {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
            background: white;
            padding: 5px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.1);
            flex-wrap: wrap;
        }

        .search-box input {
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            width: 250px;
            font-size: 14px;
            outline: none;
            color: #1e3a8a;
        }

        .search-box input::placeholder {
            color: #93c5fd;
        }

        .search-box button {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .search-box button:hover {
            opacity: 0.9;
        }

        .search-box a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .search-box a:hover {
            background: rgba(37, 99, 235, 0.1);
        }

        /* Table Container */
        .table-container {
            background: #dbeafe;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: linear-gradient(135deg, #2563eb10 0%, #1e40af10 100%);
            border-radius: 15px;
        }

        th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            color: #1e40af;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 18px 15px;
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            color: #1e3a8a;
            font-size: 14px;
        }

        tr:hover td {
            background: rgba(37, 99, 235, 0.05);
        }

        .research-img {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
            transition: transform 0.3s;
            border: 2px solid white;
        }

        .research-img:hover {
            transform: scale(2);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
            cursor: pointer;
            z-index: 1000;
            position: relative;
        }

        /* Status Badges - Fixed visibility */
        .status {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .status.published {
            background: #10b981;
            color: white;
            border: 1px solid #059669;
        }

        .status.draft {
            background: #f59e0b;
            color: white;
            border: 1px solid #d97706;
        }

        .status i {
            font-size: 12px;
        }

        /* Action buttons container */
        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Base button styles for all action buttons */
        .btn-edit, .btn-delete, .btn-publish, .btn-draft {
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Edit Button */
        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .btn-edit:hover {
            background: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }

        /* Delete Button */
        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.4);
        }

        /* Publish Button */
        .btn-publish {
            background: #10b981;
            color: white;
        }

        .btn-publish:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        /* Draft Button - FIXED and VISIBLE */
        .btn-draft {
            background: #f59e0b;
            color: white;
        }

        .btn-draft:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #1e40af;
        }

        .empty-state i {
            font-size: 64px;
            color: #93c5fd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .empty-state .btn-add {
            display: inline-flex;
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
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
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
            .content-header {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn-edit, .btn-delete, .btn-publish, .btn-draft {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>CLSD</h2>

    <a href="<?= BASE_URL ?>/admin/dashboard">
        <i class="fas fa-dashboard"></i> Dashboard
    </a>

    <!-- Research and Development -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('researchMenu')">
            <i class="fas fa-flask"></i> Research and Development ▼
        </div>

        <div class="dropdown-links show" id="researchMenu">
            <a href="<?= BASE_URL ?>/admin/research-team" class="active"><i class="fas fa-users"></i> Research Team</a>
            <a href="<?= BASE_URL ?>/admin/clsd-project"><i class="fas fa-project-diagram"></i> CLSD Project</a>
            <a href="<?= BASE_URL ?>/admin/research-paper"><i class="fas fa-file-alt"></i> CLSD Research Paper</a>
            <a href="<?= BASE_URL ?>/admin/lakes-database"><i class="fas fa-database"></i> Philippine Lakes Database</a>
        </div>
    </div>

    <!-- Science and Research -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('scienceMenu')">
            <i class="fas fa-microscope"></i> Science and Research ▼
        </div>

        <div class="dropdown-links" id="scienceMenu">
            <a href="<?= BASE_URL ?>/admin/dost-projects"><i class="fas fa-flask"></i> DOST Funded Projects</a>
        </div>
    </div>

    <!-- Media -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('mediaMenu')">
            <i class="fas fa-play-circle"></i> Media ▼
        </div>

        <div class="dropdown-links" id="mediaMenu">
            <a href="<?= BASE_URL ?>/admin/videos"><i class="fas fa-video"></i> Video Gallery</a>
            <a href="<?= BASE_URL ?>/admin/iec-materials"><i class="fas fa-file-pdf"></i> IEC Materials</a>
        </div>
    </div>

    <!-- Projects and Events -->
    <div class="dropdown">
        <div class="dropdown-title" onclick="toggleDropdown('projectsMenu')">
            <i class="fas fa-calendar-alt"></i> Projects and Events ▼
        </div>

        <div class="dropdown-links" id="projectsMenu">
            <a href="<?= BASE_URL ?>/admin/projects"><i class="fas fa-tasks"></i> Projects</a>
            <a href="<?= BASE_URL ?>/admin/events"><i class="fas fa-calendar-check"></i> Events</a>
        </div>
    </div>

    <a href="<?= BASE_URL ?>/logout">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="main">
    <div class="topbar">
        <h1><i class="fas fa-users"></i> Research Team</h1>
        <span>
            <i class="fas fa-user-circle"></i>
            <?= isset($_SESSION['first_name']) 
                ? htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) 
                : 'Admin'; ?>
        </span>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Research Controls -->
    <div class="content-header">
        <a href="<?= BASE_URL ?>/admin/research-team/create" class="btn-add">
            <i class="fas fa-plus"></i> Add Researcher
        </a>

        <form method="GET" action="<?= BASE_URL ?>/admin/research-team" class="search-box">
            <input type="text" name="search" placeholder="Search by name, designation, or institution..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button type="submit"><i class="fas fa-search"></i> Search</button>
            <a href="<?= BASE_URL ?>/admin/research-team"><i class="fas fa-sync-alt"></i> Display All</a>
        </form>
    </div>

    <!-- Research Table -->
    <div class="table-container">
        <?php if(!empty($researchers)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Full Name</th>
                        <th>Designation</th>
                        <th>Institution</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($researchers as $researcher): ?>
                    <tr>
                        <td>
                            <?php if($researcher->image): ?>
                                <img src="<?= BASE_URL ?>/uploads/research/<?= $researcher->image ?>" class="research-img" alt="<?= htmlspecialchars($researcher->first_name . ' ' . $researcher->last_name) ?>">
                            <?php else: ?>
                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2563eb20 0%, #1e40af20 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($researcher->first_name . ' ' . $researcher->middle_name . ' ' . $researcher->last_name . ($researcher->suffix ? ', ' . $researcher->suffix : '')) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($researcher->designation) ?></td>
                        <td><?= htmlspecialchars($researcher->institution) ?></td>
                        <td>
                            <?php if($researcher->status == 1): ?>
                                <span class="status published"><i class="fas fa-check-circle"></i> Published</span>
                            <?php else: ?>
                                <span class="status draft"><i class="fas fa-clock"></i> Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Edit Button -->
                                <a href="<?= BASE_URL ?>/admin/research-team/edit/<?= $researcher->id ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                
                                <!-- Publish/Draft Toggle -->
                                <?php if($researcher->status == 1): ?>
                                    <!-- If Published, show Draft button -->
                                    <form action="<?= BASE_URL ?>/admin/research-team/draft" method="POST" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $researcher->id ?>">
                                        <button type="submit" class="btn-draft" onclick="return confirm('Move this researcher to draft?')">
                                            <i class="fas fa-file"></i> Draft
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <!-- If Draft, show Publish button -->
                                    <form action="<?= BASE_URL ?>/admin/research-team/publish" method="POST" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $researcher->id ?>">
                                        <button type="submit" class="btn-publish" onclick="return confirm('Publish this researcher?')">
                                            <i class="fas fa-globe"></i> Publish
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                <!-- Delete Button -->
                                <form action="<?= BASE_URL ?>/admin/research-team/delete" method="POST" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $researcher->id ?>">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this researcher? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No researchers found</h3>
                <p><?= isset($search) && !empty($search) ? 'No results match your search criteria.' : 'Get started by adding your first researcher.' ?></p>
                <?php if(isset($search) && !empty($search)): ?>
                    <a href="<?= BASE_URL ?>/admin/research-team" class="btn-add">
                        <i class="fas fa-sync-alt"></i> Clear Search
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/admin/research-team/create" class="btn-add">
                        <i class="fas fa-plus"></i> Add Your First Researcher
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if(menu){
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Researcher - CLSD Admin</title>
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

        /* Form Container */
        .form-container {
            background: #dbeafe;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(37, 99, 235, 0.2);
        }

        .form-header h2 {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 600;
        }

        .btn-back {
            background: transparent;
            color: #2563eb;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid #2563eb;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: #2563eb;
            color: white;
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

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            display: block;
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-label i {
            margin-right: 8px;
            color: #2563eb;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(37, 99, 235, 0.2);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
            color: #1e3a8a;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .help-text {
            color: #6b7280;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Image Upload */
        .image-upload-container {
            border: 2px dashed rgba(37, 99, 235, 0.3);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: rgba(37, 99, 235, 0.02);
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-upload-container:hover {
            border-color: #2563eb;
            background: rgba(37, 99, 235, 0.05);
        }

        .image-upload-container i {
            font-size: 48px;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .image-upload-container p {
            color: #1e40af;
            margin-bottom: 5px;
        }

        .image-upload-container small {
            color: #6b7280;
            font-size: 12px;
        }

        .image-preview {
            margin-top: 15px;
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            display: none;
            margin-left: auto;
            margin-right: auto;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #2563eb;
        }

        .checkbox-group label {
            color: #1e40af;
            font-weight: 500;
            cursor: pointer;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid rgba(37, 99, 235, 0.2);
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-submit {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-cancel {
            background: transparent;
            color: #6b7280;
            padding: 12px 30px;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 768px) {
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
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
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
        <h1><i class="fas fa-user-plus"></i> Add New Researcher</h1>
        <span>
            <i class="fas fa-user-circle"></i>
            <?= isset($_SESSION['first_name']) 
                ? htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) 
                : 'Admin'; ?>
        </span>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h2><i class="fas fa-user-graduate"></i> Researcher Information</h2>
            <a href="<?= BASE_URL ?>/admin/research-team" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
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

        <form action="<?= BASE_URL ?>/admin/research-team/store" method="POST" enctype="multipart/form-data">
            <div class="form-grid">
                <!-- First Name -->
                <div class="form-group">
                    <label class="form-label" for="first_name">
                        <i class="fas fa-user"></i> First Name *
                    </label>
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           class="form-control <?= isset($_SESSION['errors']['first_name']) ? 'error' : '' ?>"
                           value="<?= isset($_SESSION['old']['first_name']) ? htmlspecialchars($_SESSION['old']['first_name']) : '' ?>"
                           required>
                    <?php if(isset($_SESSION['errors']['first_name'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['first_name']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label class="form-label" for="middle_name">
                        <i class="fas fa-user"></i> Middle Name
                    </label>
                    <input type="text" 
                           id="middle_name" 
                           name="middle_name" 
                           class="form-control"
                           value="<?= isset($_SESSION['old']['middle_name']) ? htmlspecialchars($_SESSION['old']['middle_name']) : '' ?>">
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label class="form-label" for="last_name">
                        <i class="fas fa-user"></i> Last Name *
                    </label>
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           class="form-control <?= isset($_SESSION['errors']['last_name']) ? 'error' : '' ?>"
                           value="<?= isset($_SESSION['old']['last_name']) ? htmlspecialchars($_SESSION['old']['last_name']) : '' ?>"
                           required>
                    <?php if(isset($_SESSION['errors']['last_name'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['last_name']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Suffix -->
                <div class="form-group">
                    <label class="form-label" for="suffix">
                        <i class="fas fa-user-tag"></i> Suffix
                    </label>
                    <input type="text" 
                        id="suffix" 
                        name="suffix" 
                        class="form-control" 
                        placeholder="e.g., Jr., Sr., III, PhD, MIT, MD"
                        value="<?= isset($_SESSION['old']['suffix']) ? htmlspecialchars($_SESSION['old']['suffix']) : '' ?>">
                </div>

                <!-- Email -->
                <div class="form-group full-width">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Email Address *
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control <?= isset($_SESSION['errors']['email']) ? 'error' : '' ?>"
                           value="<?= isset($_SESSION['old']['email']) ? htmlspecialchars($_SESSION['old']['email']) : '' ?>"
                           required>
                    <?php if(isset($_SESSION['errors']['email'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['email']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Designation -->
                <div class="form-group">
                    <label class="form-label" for="designation">
                        <i class="fas fa-briefcase"></i> Designation/Title *
                    </label>

                    <select id="designation"
                            name="designation"
                            class="form-control <?= isset($_SESSION['errors']['designation']) ? 'error' : '' ?>"
                            required>

                        <option value="">Select Designation</option>

                        <option value="Director"
                            <?= ($directorExists) ? 'disabled' : '' ?>
                            <?= (isset($_SESSION['old']['designation']) && $_SESSION['old']['designation'] == 'Director') ? 'selected' : '' ?>>
                            Director <?= ($directorExists) ? '(Already Assigned)' : '' ?>
                        </option>

                        <option value="Researcher"
                            <?= (isset($_SESSION['old']['designation']) && $_SESSION['old']['designation'] == 'Researcher') ? 'selected' : '' ?>>
                            Researcher
                        </option>

                        <option value="Research Assistant"
                            <?= (isset($_SESSION['old']['designation']) && $_SESSION['old']['designation'] == 'Research Assistant') ? 'selected' : '' ?>>
                            Research Assistant
                        </option>

                        <option value="Affiliate Researcher"
                            <?= (isset($_SESSION['old']['designation']) && $_SESSION['old']['designation'] == 'Affiliate Researcher') ? 'selected' : '' ?>>
                            Affiliate Researcher
                        </option>

                    </select>

                    <?php if(isset($_SESSION['errors']['designation'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['designation']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Department -->
                <div class="form-group">
                    <label class="form-label" for="department">
                        <i class="fas fa-building"></i> Department/Division
                    </label>
                    <input type="text" 
                           id="department" 
                           name="department" 
                           class="form-control"
                           value="<?= isset($_SESSION['old']['department']) ? htmlspecialchars($_SESSION['old']['department']) : '' ?>"
                           placeholder="e.g., Biology Department, etc.">
                </div>

                <!-- Institution -->
                <div class="form-group full-width">
                    <label class="form-label" for="institution">
                        <i class="fas fa-university"></i> Institution/University *
                    </label>
                    <input type="text" 
                           id="institution" 
                           name="institution" 
                           class="form-control <?= isset($_SESSION['errors']['institution']) ? 'error' : '' ?>"
                           value="<?= isset($_SESSION['old']['institution']) ? htmlspecialchars($_SESSION['old']['institution']) : '' ?>"
                           placeholder="e.g., University of the Philippines, etc."
                           required>
                    <?php if(isset($_SESSION['errors']['institution'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['institution']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Research Interest -->
                <div class="form-group full-width">
                    <label class="form-label" for="research_interest">
                        <i class="fas fa-microscope"></i> Research Interest
                    </label>
                    <textarea id="research_interest" 
                              name="research_interest" 
                              class="form-control" 
                              rows="4"
                              placeholder="Describe their research interests, expertise, etc."><?= isset($_SESSION['old']['research_interest']) ? htmlspecialchars($_SESSION['old']['research_interest']) : '' ?></textarea>
                </div>

                <!-- Profile Image -->
                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="fas fa-image"></i> Profile Image
                    </label>
                    <div class="image-upload-container" onclick="document.getElementById('image').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload profile image</p>
                        <small>JPG, PNG or GIF (Max. 5MB)</small>
                    </div>
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*" 
                           style="display: none;"
                           onchange="previewImage(this)">
                    <img id="imagePreview" class="image-preview" src="#" alt="Preview">
                    <?php if(isset($_SESSION['errors']['image'])): ?>
                        <span class="error-message"><?= $_SESSION['errors']['image']; ?></span>
                    <?php endif; ?>
                </div>

                <!-- Status -->
                <div class="form-group full-width">
                    <div class="checkbox-group">
                        <input type="checkbox" 
                               id="status" 
                               name="status" 
                               value="1"
                               <?= (isset($_SESSION['old']['status']) && $_SESSION['old']['status'] == '1') ? 'checked' : '' ?>>
                        <label for="status">
                            <i class="fas fa-globe"></i> Publish immediately
                        </label>
                    </div>
                    <span class="help-text">If unchecked, the researcher profile will be saved as draft</span>
                </div>
            </div>

            <div class="form-actions">
                <a href="<?= BASE_URL ?>/admin/research-team" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Save Researcher
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDropdown(menuId) {
    const menu = document.getElementById(menuId);
    if(menu){
        menu.classList.toggle("show");
    }
}

function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
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

<?php 
// Clear session old data after displaying
if(isset($_SESSION['old'])) {
    unset($_SESSION['old']);
}
if(isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}
?>
</body>
</html>
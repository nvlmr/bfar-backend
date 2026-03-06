<!DOCTYPE html>
<html>
<head>
    <title>Super Admin</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
</head>
<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>CLSD</h2>
        <ul>
            <li><a href="<?= BASE_URL ?>/superadmin/dashboard">Dashboard</a></li>
            <li><a href="<?= BASE_URL ?>/superadmin/users">Users</a></li>
            <li><a href="<?= BASE_URL ?>/superadmin/admins">Admins</a></li>
            <li><a href="<?= BASE_URL ?>/logout">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?= $content ?>
    </div>

</div>

</body>
</html>
<?php require_once '../includes/config.php';
require_once '../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Information</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body>
    <header class="topbar">
        <div class="brand"><span>✚</span> Blood Bank Project Info</div>
        <nav><a href="<?php echo BASE_URL; ?>login.php">Admin Login</a><a href="<?php echo BASE_URL; ?>user/user_login.php">User Login</a></nav>
    </header>
    <main class="container">
        <h2 class="page-title">Project Information</h2>
        <div class="form-card wide-card">
            <h3>Blood Bank Management System</h3>
            <p>This page is made for the presentation QR code. It explains the project objective, main features, technology stack, and group work.</p>
            <h4>Objective</h4>
            <p>To manage blood donor records, receiver records, blood stock, and user blood requests using PHP and MySQL.</p>
            <h4>Main Features</h4>
            <ul>
                <li>Admin login, logout, and protected admin pages</li>
                <li>User registration, login, logout, and protected user pages</li>
                <li>Donor CRUD: add, view/search, edit, and delete donors</li>
                <li>Receiver CRUD: add, view/search, edit, and delete receivers</li>
                <li>Blood stock view and update system</li>
                <li>User blood request system</li>
                <li>Admin approve/cancel request system</li>
                <li>Basic validation, safe output, password hashing, and prepared statements</li>
            </ul>
            <h4>Technology Stack</h4>
            <p>HTML, CSS, PHP, MySQL, XAMPP, phpMyAdmin, VS Code, and Git/GitHub.</p>
            <h4>Team Contribution Example</h4>
            <ul>
                <li>Team Leader: project setup, database, admin login, security, final testing</li>
                <li>Member 2: donor and receiver CRUD pages</li>
                <li>Member 3: user registration, login, profile, and request pages</li>
                <li>Member 4: blood stock, admin request approval, UI support, and documentation</li>
            </ul>
        </div>
    </main>
    <footer class="footer">Blood Bank Management System | Web Programming II</footer>
</body>

</html>
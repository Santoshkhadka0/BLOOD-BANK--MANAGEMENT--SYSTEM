<?php require_once __DIR__ . '/config.php'; require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
<header class="topbar">
    <div class="brand"><span>✚</span> Blood Bank MS</div>
    <nav>
        <a href="<?php echo BASE_URL; ?>dashboard.php">Dashboard</a>
        <a href="<?php echo BASE_URL; ?>donor/donor.php">Donors</a>
        <a href="<?php echo BASE_URL; ?>receiver/receiver.php">Receivers</a>
        <a href="<?php echo BASE_URL; ?>stock/stock.php">Stock</a>
        <a href="<?php echo BASE_URL; ?>requests/admin_requests.php">Requests</a>
        <a href="<?php echo BASE_URL; ?>qr/qr_info.php">QR Info</a>
        <a href="<?php echo BASE_URL; ?>change_admin.php">Admin</a>
        <a class="logout" href="<?php echo BASE_URL; ?>logout.php">Logout</a>
    </nav>
</header>
<main class="container">
<?php flash_show(); ?>

<?php require_once __DIR__ . '/config.php'; require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Blood Bank</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
<header class="topbar userbar">
    <div class="brand"><span>✚</span> Blood Bank User</div>
    <nav>
        <a href="<?php echo BASE_URL; ?>user/user_dashboard.php">Dashboard</a>
        <a href="<?php echo BASE_URL; ?>requests/user_request.php">Request Blood</a>
        <a href="<?php echo BASE_URL; ?>requests/my_requests.php">My Requests</a>
        <a href="<?php echo BASE_URL; ?>user/user_profile.php">Profile</a>
        <a class="logout" href="<?php echo BASE_URL; ?>user/user_logout.php">Logout</a>
    </nav>
</header>
<main class="container">
<?php flash_show(); ?>

<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!empty($_SESSION['admin_id'])) redirect('dashboard.php');

$username = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_text($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, username, password FROM admin WHERE username = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);

        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            redirect('dashboard.php');
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body class="login-body">
    <div class="login-box">
        <div class="login-icon">✚</div>
        <h1>Blood Bank<br>Management System</h1>
        <h2>Admin Login</h2>
        <?php if ($error !== '') { ?><div class="error-box"><?php echo e($error); ?></div><?php } ?>
        <form method="POST">
            <div class="input-group"><span>👤</span><input type="text" name="username" placeholder="username" value="<?php echo e($username); ?>"></div>
            <div class="input-group"><span>🔒</span><input type="password" name="password" placeholder="password"></div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <div class="login-links">
            <a href="<?php echo BASE_URL; ?>password/admin_forgot.php">Forgot admin password?</a>
            <a href="<?php echo BASE_URL; ?>user/user_login.php">User Login</a>
        </div>
        <p class="login-message">Default admin: admin / admin123</p>
    </div>
</body>

</html>
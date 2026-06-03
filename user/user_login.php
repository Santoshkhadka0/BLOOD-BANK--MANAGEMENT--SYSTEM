<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
if (!empty($_SESSION['user_id'])) redirect('user/user_dashboard.php');
$email = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean_text($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') $error = 'Valid email and password are required.';
    else {
        $stmt = mysqli_prepare($conn, 'SELECT id,name,email,password FROM users WHERE email=? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            redirect('user/user_dashboard.php');
        } else $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body class="login-body">
    <div class="login-box">
        <div class="login-icon">✚</div>
        <h1>User Login</h1><?php if ($error) echo '<div class="error-box">' . e($error) . '</div>'; ?><form method="POST">
            <div class="input-group"><span>✉️</span><input type="email" name="email" placeholder="email" value="<?php echo e($email); ?>"></div>
            <div class="input-group"><span>🔒</span><input type="password" name="password" placeholder="password"></div><button class="login-button" type="submit">Login</button>
        </form>
        <div class="login-links"><a href="<?php echo BASE_URL; ?>user/register.php">Create account</a><a href="<?php echo BASE_URL; ?>password/user_forgot.php">Forgot password?</a><a href="<?php echo BASE_URL; ?>login.php">Admin Login</a></div>
    </div>
</body>

</html>
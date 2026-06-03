<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
if (!empty($_SESSION['user_id'])) redirect('user/user_dashboard.php');
$errors = [];
$name = $email = $phone = '';
$q1 = 'What is your favorite color?';
$q2 = 'What city do you live in?';
$q3 = 'What is your favorite food?';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_text($_POST['name'] ?? '');
    $email = clean_text($_POST['email'] ?? '');
    $phone = clean_text($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $a1 = clean_text($_POST['answer1'] ?? '');
    $a2 = clean_text($_POST['answer2'] ?? '');
    $a3 = clean_text($_POST['answer3'] ?? '');
    if ($name === '' || strlen($name) > 100) $errors[] = 'Name is required and must be below 100 characters.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($phone === '' || strlen($phone) > 30) $errors[] = 'Phone is required.';
    if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Password confirmation does not match.';
    if ($a1 === '' || $a2 === '' || $a3 === '') $errors[] = 'All security answers are required.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email=? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) $errors[] = 'Email already registered.';
        else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $h1 = answer_hash($a1);
            $h2 = answer_hash($a2);
            $h3 = answer_hash($a3);
            $stmt = mysqli_prepare($conn, 'INSERT INTO users (name,email,phone,password,question1,answer1,question2,answer2,question3,answer3) VALUES (?,?,?,?,?,?,?,?,?,?)');
            mysqli_stmt_bind_param($stmt, 'ssssssssss', $name, $email, $phone, $hash, $q1, $h1, $q2, $h2, $q3, $h3);
            if (mysqli_stmt_execute($stmt)) {
                flash_set('success', 'Registration successful. Please login.');
                redirect('user/user_login.php');
            } else $errors[] = 'Registration failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body class="login-body">
    <div class="login-box wide">
        <h1>User Registration</h1><?php foreach ($errors as $err) echo '<div class="error-box">' . e($err) . '</div>'; ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Full name" value="<?php echo e($name); ?>"><input type="email" name="email" placeholder="Email" value="<?php echo e($email); ?>"><input type="text" name="phone" placeholder="Phone" value="<?php echo e($phone); ?>">
            <input type="password" name="password" placeholder="Password"><input type="password" name="confirm_password" placeholder="Confirm password">
            <label><?php echo e($q1); ?></label><input type="text" name="answer1" autocomplete="off"><label><?php echo e($q2); ?></label><input type="text" name="answer2" autocomplete="off"><label><?php echo e($q3); ?></label><input type="text" name="answer3" autocomplete="off">
            <button class="login-button" type="submit">Register</button>
        </form>
        <div class="login-links"><a href="<?php echo BASE_URL; ?>user/user_login.php">Already have account? Login</a><a href="<?php echo BASE_URL; ?>login.php">Admin Login</a></div>
    </div>
</body>

</html>
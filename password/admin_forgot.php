<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
$errors = [];
$step = 1;
$account = null;
$username = clean_text($_POST['username'] ?? '');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['find_account'])) {
        if ($username === '') $errors[] = 'Username is required.';
        else {
            $stmt = mysqli_prepare($conn, 'SELECT * FROM admin WHERE username=? LIMIT 1');
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            $account = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
            if ($account) $step = 2;
            else $errors[] = 'Account not found.';
        }
    } elseif (isset($_POST['reset_password'])) {
        $username = clean_text($_POST['username'] ?? '');
        $stmt = mysqli_prepare($conn, 'SELECT * FROM admin WHERE username=? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $account = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        $a1 = clean_text($_POST['answer1'] ?? '');
        $a2 = clean_text($_POST['answer2'] ?? '');
        $a3 = clean_text($_POST['answer3'] ?? '');
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if (!$account) $errors[] = 'Account not found.';
        else {
            if (!answer_verify($a1, $account['answer1']) || !answer_verify($a2, $account['answer2']) || !answer_verify($a3, $account['answer3'])) $errors[] = 'Security answers do not match.';
            if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
            if ($new !== $confirm) $errors[] = 'Confirm password does not match.';
            if (!$errors) {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, 'UPDATE admin SET password=? WHERE id=?');
                mysqli_stmt_bind_param($stmt, 'si', $hash, $account['id']);
                mysqli_stmt_execute($stmt);
                flash_set('success', 'Password reset successfully. Please login.');
                redirect('login.php');
            }
            $step = 2;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Forgot Password</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>

<body class="login-body">
    <div class="login-box wide">
        <h1>Admin Forgot Password</h1><?php foreach ($errors as $err) echo '<div class="error-box">' . e($err) . '</div>'; ?>
        <?php if ($step === 1) { ?><form method="POST"><label>Enter username</label><input type="text" name="username" value="<?php echo e($username); ?>"><button class="login-button" name="find_account" type="submit">Continue</button></form><?php } else { ?><form method="POST"><input type="hidden" name="username" value="<?php echo e($username); ?>"><label><?php echo e($account['question1']); ?></label><input type="text" name="answer1" autocomplete="off"><label><?php echo e($account['question2']); ?></label><input type="text" name="answer2" autocomplete="off"><label><?php echo e($account['question3']); ?></label><input type="text" name="answer3" autocomplete="off"><input type="password" name="new_password" placeholder="New password"><input type="password" name="confirm_password" placeholder="Confirm password"><button class="login-button" name="reset_password" type="submit">Reset Password</button></form><?php } ?>
        <div class="login-links"><a href="<?php echo BASE_URL; ?>login.php">Admin Login</a></div>
    </div>
</body>

</html>
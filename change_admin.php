<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_text($_POST['username'] ?? '');
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    $stmt = mysqli_prepare($conn, 'SELECT password FROM admin WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['admin_id']);
    mysqli_stmt_execute($stmt);
    $admin = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($username === '' || strlen($username) < 3) $errors[] = 'Username must be at least 3 characters.';
    if (!$admin || !password_verify($current, $admin['password'])) $errors[] = 'Current password is wrong.';
    if (strlen($new) < 6) $errors[] = 'New password must be at least 6 characters.';
    if ($new !== $confirm) $errors[] = 'Confirm password does not match.';

    if (!$errors) {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, 'UPDATE admin SET username=?, password=? WHERE id=?');
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $hash, $_SESSION['admin_id']);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['admin_username'] = $username;
            flash_set('success', 'Admin username and password updated successfully.');
            redirect('dashboard.php');
        } else $errors[] = 'Update failed. Username may already exist.';
    }
}
require_once 'includes/header.php';
?>
<h2 class="page-title">Change Admin Account</h2>
<?php foreach ($errors as $err) echo '<div class="alert alert-error">' . e($err) . '</div>'; ?>
<form method="POST" class="form-card">
    <label>New Username</label><input type="text" name="username" value="<?php echo e($_SESSION['admin_username']); ?>">
    <label>Current Password</label><input type="password" name="current_password">
    <label>New Password</label><input type="password" name="new_password">
    <label>Confirm New Password</label><input type="password" name="confirm_password">
    <button class="btn primary" type="submit">Update Admin</button>
</form>
<?php require_once 'includes/footer.php'; ?>
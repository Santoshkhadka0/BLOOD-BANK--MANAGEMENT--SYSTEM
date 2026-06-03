<?php
require_once '../includes/user_auth.php';
require_once '../includes/db.php';
require_once '../includes/user_header.php';
$stmt = mysqli_prepare($conn, 'SELECT name, email, phone, created_at FROM users WHERE id=? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<h2 class="page-title">User Profile</h2>
<div class="form-card">
    <p><strong>Name:</strong> <?php echo e($user['name'] ?? $_SESSION['user_name']); ?></p>
    <p><strong>Email:</strong> <?php echo e($user['email'] ?? ''); ?></p>
    <p><strong>Phone:</strong> <?php echo e($user['phone'] ?? ''); ?></p>
    <p><strong>Registered:</strong> <?php echo e($user['created_at'] ?? ''); ?></p>
</div>
<?php require_once '../includes/footer.php'; ?>
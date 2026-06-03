<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM receivers WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$item = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$item) {
    flash_set('error', 'Receiver record not found.');
    redirect('receiver/view_receiver.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = mysqli_prepare($conn, 'DELETE FROM receivers WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        flash_set('success', 'Receiver deleted successfully.');
    } else {
        flash_set('error', 'Delete failed.');
    }
    redirect('receiver/view_receiver.php');
}

require_once '../includes/header.php';
?>
<h2 class="page-title">Delete Receiver</h2>
<div class="form-card">
    <p>Are you sure you want to delete <strong><?php echo e($item['name']); ?></strong>?</p>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo e($id); ?>">
        <button class="btn danger" type="submit">Yes, Delete</button>
        <a class="btn" href="<?php echo BASE_URL; ?>receiver/view_receiver.php">Cancel</a>
    </form>
</div>
<?php require_once '../includes/footer.php'; ?>
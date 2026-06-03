<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM blood_stock WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$stock = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$stock) {
    flash_set('error', 'Blood stock not found.');
    redirect('stock/stock.php');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $units = filter_input(INPUT_POST, 'units', FILTER_VALIDATE_INT);
    if ($units === false || $units < 0) $errors[] = 'Units must be zero or a positive number.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, 'UPDATE blood_stock SET units=? WHERE id=?');
        mysqli_stmt_bind_param($stmt, 'ii', $units, $id);
        if (mysqli_stmt_execute($stmt)) {
            flash_set('success', 'Stock updated successfully.');
            redirect('stock/stock.php');
        } else $errors[] = 'Update failed.';
    }
}
require_once '../includes/header.php';
?>
<h2 class="page-title">Update Stock: <?php echo e($stock['blood_group']); ?></h2>
<?php foreach ($errors as $err) echo '<div class="alert alert-error">' . e($err) . '</div>'; ?>
<form method="POST" class="form-card">
    <label>Units Available</label><input type="number" min="0" name="units" value="<?php echo e($stock['units']); ?>">
    <button class="btn primary" type="submit">Update Stock</button><a class="btn" href="<?php echo BASE_URL; ?>stock/stock.php">Cancel</a>
</form>
<?php require_once '../includes/footer.php'; ?>
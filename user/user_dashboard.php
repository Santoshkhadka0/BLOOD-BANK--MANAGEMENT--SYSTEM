<?php
require_once '../includes/user_auth.php';
require_once '../includes/db.php';
require_once '../includes/user_header.php';

$stock = mysqli_query($conn, "SELECT blood_group, units FROM blood_stock ORDER BY FIELD(blood_group, 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')");
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) total FROM blood_requests WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'] ?? 0;
?>
<h2 class="page-title">Welcome, <?php echo e($_SESSION['user_name']); ?></h2>
<div class="dashboard-cards small">
    <a class="main-card" href="<?php echo BASE_URL; ?>requests/user_request.php"><div class="card-icon">🩸</div><div><h3>Request Blood</h3><p>Submit a blood request to admin.</p><span>Request</span></div></a>
    <a class="main-card" href="<?php echo BASE_URL; ?>requests/my_requests.php"><div class="card-icon">📌</div><div><h3>My Requests</h3><p>You have <?php echo e($total); ?> request(s).</p><span>View Status</span></div></a>
</div>
<h2 class="section-title">Available Blood Stock</h2>
<table>
<tr><th>Blood Group</th><th>Units Available</th></tr>
<?php if ($stock) { while ($row = mysqli_fetch_assoc($stock)) { ?>
<tr><td><?php echo e($row['blood_group']); ?></td><td><?php echo e($row['units']); ?></td></tr>
<?php } } else { ?>
<tr><td colspan="2">Could not load blood stock.</td></tr>
<?php } ?>
</table>
<?php require_once '../includes/footer.php'; ?>

<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/header.php';

$counts = ['donors' => 0, 'receivers' => 0, 'users' => 0, 'pending' => 0];
foreach (
    [
        'donors' => 'SELECT COUNT(*) total FROM donors',
        'receivers' => 'SELECT COUNT(*) total FROM receivers',
        'users' => 'SELECT COUNT(*) total FROM users',
        'pending' => "SELECT COUNT(*) total FROM blood_requests WHERE status='Pending'"
    ] as $key => $sql
) {
    $res = mysqli_query($conn, $sql);
    $counts[$key] = $res ? (mysqli_fetch_assoc($res)['total'] ?? 0) : 0;
}

$stock = mysqli_query($conn, "SELECT blood_group, units FROM blood_stock ORDER BY FIELD(blood_group, 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')");
?>
<h2 class="page-title">Admin Dashboard</h2>
<div class="stats-grid">
    <div class="stat-card"><strong><?php echo e($counts['donors']); ?></strong><span>Total Donors</span></div>
    <div class="stat-card"><strong><?php echo e($counts['receivers']); ?></strong><span>Total Receivers</span></div>
    <div class="stat-card"><strong><?php echo e($counts['users']); ?></strong><span>Registered Users</span></div>
    <div class="stat-card"><strong><?php echo e($counts['pending']); ?></strong><span>Pending Requests</span></div>
</div>
<div class="dashboard-cards">
    <a href="<?php echo BASE_URL; ?>donor/donor.php" class="main-card">
        <div class="card-icon">🩸</div>
        <div>
            <h3>Donor Management</h3>
            <p>Add, view, edit, and delete donor records.</p><span>Open</span>
        </div>
    </a>
    <a href="<?php echo BASE_URL; ?>receiver/receiver.php" class="main-card">
        <div class="card-icon">🏥</div>
        <div>
            <h3>Receiver Management</h3>
            <p>Add, view, edit, and delete receiver records.</p><span>Open</span>
        </div>
    </a>
    <a href="<?php echo BASE_URL; ?>stock/stock.php" class="main-card">
        <div class="card-icon">📦</div>
        <div>
            <h3>Blood Stock</h3>
            <p>View and update units for every blood group.</p><span>Open</span>
        </div>
    </a>
    <a href="<?php echo BASE_URL; ?>requests/admin_requests.php" class="main-card">
        <div class="card-icon">✅</div>
        <div>
            <h3>Blood Requests</h3>
            <p>Approve or cancel user blood requests.</p><span>Open</span>
        </div>
    </a>
</div>

<h2 class="section-title">Available Blood Stock</h2>
<table>
    <tr>
        <th>Blood Group</th>
        <th>Units Available</th>
    </tr>
    <?php if ($stock) {
        while ($row = mysqli_fetch_assoc($stock)) { ?>
            <tr>
                <td><?php echo e($row['blood_group']); ?></td>
                <td><?php echo e($row['units']); ?></td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="2">Could not load blood stock.</td>
        </tr>
    <?php } ?>
</table>
<?php require_once 'includes/footer.php'; ?>
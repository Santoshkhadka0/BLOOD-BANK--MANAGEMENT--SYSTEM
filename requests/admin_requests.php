<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$status = clean_text($_GET['status'] ?? '');
$allowedStatus = ['Pending', 'Approved', 'Cancelled'];

if (in_array($status, $allowedStatus, true)) {
    $stmt = mysqli_prepare($conn, 'SELECT br.*, u.name, u.email FROM blood_requests br JOIN users u ON br.user_id = u.id WHERE br.status = ? ORDER BY br.id DESC');
    mysqli_stmt_bind_param($stmt, 's', $status);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_stmt_get_result($stmt);
} else {
    $rows = mysqli_query($conn, 'SELECT br.*, u.name, u.email FROM blood_requests br JOIN users u ON br.user_id = u.id ORDER BY br.id DESC');
}
?>
<h2 class="page-title">Admin Blood Requests</h2>
<form class="search-form" method="GET">
    <select name="status">
        <option value="">All Status</option>
        <?php foreach ($allowedStatus as $s) { ?>
            <option value="<?php echo e($s); ?>" <?php if ($status === $s) echo 'selected'; ?>><?php echo e($s); ?></option>
        <?php } ?>
    </select>
    <button class="btn" type="submit">Filter</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Patient</th>
        <th>Blood</th>
        <th>Units</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php if ($rows && mysqli_num_rows($rows) > 0) {
        while ($row = mysqli_fetch_assoc($rows)) { ?>
            <tr>
                <td><?php echo e($row['id']); ?></td>
                <td><?php echo e($row['name']); ?><br><small><?php echo e($row['email']); ?></small></td>
                <td><?php echo e($row['patient_name']); ?></td>
                <td><?php echo e($row['blood_group']); ?></td>
                <td><?php echo e($row['units']); ?></td>
                <td><?php echo e($row['reason']); ?></td>
                <td><span class="status <?php echo strtolower(e($row['status'])); ?>"><?php echo e($row['status']); ?></span></td>
                <td>
                    <?php if ($row['status'] === 'Pending') { ?>
                        <form method="POST" action="<?php echo BASE_URL; ?>requests/approve_request.php" class="inline-form">
                            <input type="hidden" name="id" value="<?php echo e($row['id']); ?>">
                            <button class="btn small-btn" type="submit">Approve</button>
                        </form>
                        <form method="POST" action="<?php echo BASE_URL; ?>requests/cancel_request.php" class="inline-form">
                            <input type="hidden" name="id" value="<?php echo e($row['id']); ?>">
                            <button class="btn danger small-btn" type="submit">Cancel</button>
                        </form>
                    <?php } else {
                        echo '-';
                    } ?>
                </td>
            </tr>
        <?php }
    } elseif (!$rows) { ?>
        <tr>
            <td colspan="8">Could not load requests.</td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="8">No requests found.</td>
        </tr>
    <?php } ?>
</table>
<?php require_once '../includes/footer.php'; ?>
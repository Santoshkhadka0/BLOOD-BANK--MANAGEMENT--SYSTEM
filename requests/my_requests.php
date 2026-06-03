<?php
require_once '../includes/user_auth.php';
require_once '../includes/db.php';
require_once '../includes/user_header.php';

$stmt = mysqli_prepare($conn, 'SELECT * FROM blood_requests WHERE user_id = ? ORDER BY id DESC');
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$rows = mysqli_stmt_get_result($stmt);
?>
<h2 class="page-title">My Blood Requests</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Patient</th>
        <th>Blood Group</th>
        <th>Units</th>
        <th>Reason</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    <?php if ($rows && mysqli_num_rows($rows) > 0) {
        while ($row = mysqli_fetch_assoc($rows)) { ?>
            <tr>
                <td><?php echo e($row['id']); ?></td>
                <td><?php echo e($row['patient_name']); ?></td>
                <td><?php echo e($row['blood_group']); ?></td>
                <td><?php echo e($row['units']); ?></td>
                <td><?php echo e($row['reason']); ?></td>
                <td><span class="status <?php echo strtolower(e($row['status'])); ?>"><?php echo e($row['status']); ?></span></td>
                <td><?php echo e($row['created_at']); ?></td>
            </tr>
        <?php }
    } elseif (!$rows) { ?>
        <tr>
            <td colspan="7">Could not load requests.</td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="7">No requests yet.</td>
        </tr>
    <?php } ?>
</table>
<?php require_once '../includes/footer.php'; ?>
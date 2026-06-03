<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$rows = mysqli_query($conn, "SELECT * FROM blood_stock ORDER BY FIELD(blood_group, 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')");
?>
<h2 class="page-title">Blood Stock</h2>
<table>
    <tr>
        <th>Blood Group</th>
        <th>Units</th>
        <th>Action</th>
    </tr>
    <?php if ($rows) {
        while ($row = mysqli_fetch_assoc($rows)) { ?>
            <tr>
                <td><?php echo e($row['blood_group']); ?></td>
                <td><?php echo e($row['units']); ?></td>
                <td><a class="btn small-btn" href="<?php echo BASE_URL; ?>stock/update_stock.php?id=<?php echo e($row['id']); ?>">Update</a></td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="3">Could not load stock.</td>
        </tr>
    <?php } ?>
</table>
<?php require_once '../includes/footer.php'; ?>
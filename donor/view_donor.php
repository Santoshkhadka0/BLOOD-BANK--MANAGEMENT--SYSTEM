<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$q = clean_text($_GET['q'] ?? '');
if ($q !== '') {
    $like = '%' . $q . '%';
    $stmt = mysqli_prepare($conn, 'SELECT * FROM donors WHERE name LIKE ? OR contact LIKE ? OR blood_group LIKE ? ORDER BY id DESC');
    mysqli_stmt_bind_param($stmt, 'sss', $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $rows = mysqli_stmt_get_result($stmt);
} else {
    $rows = mysqli_query($conn, 'SELECT * FROM donors ORDER BY id DESC');
}
?>
<h2 class="page-title">View Donors</h2>
<div class="action-row"><a class="btn primary" href="<?php echo BASE_URL; ?>donor/add_donor.php">Add Donor</a></div>
<form class="search-form" method="GET">
    <input type="text" name="q" placeholder="Search name, contact, blood group" value="<?php echo e($q); ?>">
    <button class="btn" type="submit">Search</button>
</form>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Blood Group</th>
        <th>Donation Date</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    <?php if ($rows && mysqli_num_rows($rows) > 0) {
        while ($row = mysqli_fetch_assoc($rows)) { ?>
            <tr>
                <td><?php echo e($row['id']); ?></td>
                <td><?php echo e($row['name']); ?></td>
                <td><?php echo e($row['contact']); ?></td>
                <td><?php echo e($row['blood_group']); ?></td>
                <td><?php echo e($row['donate_date']); ?></td>
                <td><?php echo e($row['created_at']); ?></td>
                <td>
                    <a class="btn small-btn" href="<?php echo BASE_URL; ?>donor/edit_donor.php?id=<?php echo e($row['id']); ?>">Edit</a>
                    <a class="btn danger small-btn" href="<?php echo BASE_URL; ?>donor/delete_donor.php?id=<?php echo e($row['id']); ?>" onclick="return confirm('Delete this donor record?');">Delete</a>
                </td>
            </tr>
        <?php }
    } elseif (!$rows) { ?>
        <tr>
            <td colspan="7">Could not load donor records.</td>
        </tr>
    <?php } else { ?>
        <tr>
            <td colspan="7">No records found.</td>
        </tr>
    <?php } ?>
</table>
<?php require_once '../includes/footer.php'; ?>
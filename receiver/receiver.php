<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>
<h2 class="page-title">Receiver Management</h2>
<div class="dashboard-cards small">
    <a class="main-card" href="<?php echo BASE_URL; ?>receiver/add_receiver.php">
        <div class="card-icon">➕</div>
        <div>
            <h3>Add Receiver</h3>
            <p>Create a new receiver record.</p><span>Add</span>
        </div>
    </a>
    <a class="main-card" href="<?php echo BASE_URL; ?>receiver/view_receiver.php">
        <div class="card-icon">📋</div>
        <div>
            <h3>View Receivers</h3>
            <p>Search, edit, or delete records.</p><span>View</span>
        </div>
    </a>
</div>
<?php require_once '../includes/footer.php'; ?>
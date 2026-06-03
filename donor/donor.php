<?php
require_once '../includes/auth.php';
require_once '../includes/header.php';
?>
<h2 class="page-title">Donor Management</h2>
<div class="dashboard-cards small">
    <a class="main-card" href="<?php echo BASE_URL; ?>donor/add_donor.php">
        <div class="card-icon">➕</div>
        <div>
            <h3>Add Donor</h3>
            <p>Create a new donor record.</p><span>Add</span>
        </div>
    </a>
    <a class="main-card" href="<?php echo BASE_URL; ?>donor/view_donor.php">
        <div class="card-icon">📋</div>
        <div>
            <h3>View Donors</h3>
            <p>Search, edit, or delete records.</p><span>View</span>
        </div>
    </a>
</div>
<?php require_once '../includes/footer.php'; ?>
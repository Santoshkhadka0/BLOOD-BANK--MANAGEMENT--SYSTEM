<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
$errors = [];
$name = $contact = $date = $blood_group = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_text($_POST['name'] ?? '');
    $contact = clean_text($_POST['contact'] ?? '');
    $date = clean_text($_POST['date'] ?? '');
    $blood_group = clean_text($_POST['blood_group'] ?? '');
    if ($name === '' || strlen($name) > 100) $errors[] = 'Name is required and must be below 100 characters.';
    if ($contact === '' || strlen($contact) > 50) $errors[] = 'Contact is required and must be below 50 characters.';
    if (!valid_date($date)) $errors[] = 'Donation Date must be a valid date.';
    if (!valid_blood_group($blood_group)) $errors[] = 'Invalid blood group.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM donors WHERE contact=? AND blood_group=? AND donate_date=? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'sss', $contact, $blood_group, $date);
        mysqli_stmt_execute($stmt);
        if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
            $errors[] = 'Duplicate donor record already exists.';
        } else {
            $stmt = mysqli_prepare($conn, 'INSERT INTO donors (name, contact, donate_date, blood_group) VALUES (?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $contact, $date, $blood_group);
            if (mysqli_stmt_execute($stmt)) {
                flash_set('success', 'Donor added successfully.');
                redirect('donor/view_donor.php');
            } else $errors[] = 'Database error while saving.';
        }
    }
}
require_once '../includes/header.php';
?>
<h2 class="page-title">Add Donor</h2>
<?php foreach ($errors as $err) echo '<div class="alert alert-error">' . e($err) . '</div>'; ?>
<form method="POST" class="form-card">
    <label>Name</label><input type="text" name="name" value="<?php echo e($name); ?>">
    <label>Contact</label><input type="text" name="contact" value="<?php echo e($contact); ?>">
    <label>Donation Date</label><input type="date" name="date" value="<?php echo e($date); ?>">
    <label>Blood Group</label><select name="blood_group">
        <option value="">Select Blood Group</option><?php foreach (blood_groups() as $bg) { ?><option value="<?php echo e($bg); ?>" <?php if ($blood_group === $bg) echo 'selected'; ?>><?php echo e($bg); ?></option><?php } ?>
    </select>
    <button type="submit" class="btn primary">Save Donor</button>
    <a class="btn" href="<?php echo BASE_URL; ?>donor/donor.php">Back</a>
</form>
<?php require_once '../includes/footer.php'; ?>
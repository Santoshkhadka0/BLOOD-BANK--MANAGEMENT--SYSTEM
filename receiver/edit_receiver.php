<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM receivers WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$item = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$item) {
    flash_set('error', 'Receiver record not found.');
    redirect('receiver/view_receiver.php');
}
$errors = [];
$name = $item['name'];
$contact = $item['contact'];
$date = $item['receive_date'];
$blood_group = $item['blood_group'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_text($_POST['name'] ?? '');
    $contact = clean_text($_POST['contact'] ?? '');
    $date = clean_text($_POST['date'] ?? '');
    $blood_group = clean_text($_POST['blood_group'] ?? '');
    if ($name === '' || strlen($name) > 100) $errors[] = 'Name is required and must be below 100 characters.';
    if ($contact === '' || strlen($contact) > 50) $errors[] = 'Contact is required and must be below 50 characters.';
    if (!valid_date($date)) $errors[] = 'Receive Date must be a valid date.';
    if (!valid_blood_group($blood_group)) $errors[] = 'Invalid blood group.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM receivers WHERE contact=? AND blood_group=? AND receive_date=? AND id<>? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'sssi', $contact, $blood_group, $date, $id);
        mysqli_stmt_execute($stmt);
        if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) $errors[] = 'Another duplicate record already exists.';
        else {
            $stmt = mysqli_prepare($conn, 'UPDATE receivers SET name=?, contact=?, receive_date=?, blood_group=? WHERE id=?');
            mysqli_stmt_bind_param($stmt, 'ssssi', $name, $contact, $date, $blood_group, $id);
            if (mysqli_stmt_execute($stmt)) {
                flash_set('success', 'Receiver updated successfully.');
                redirect('receiver/view_receiver.php');
            } else $errors[] = 'Update failed.';
        }
    }
}
require_once '../includes/header.php';
?>
<h2 class="page-title">Edit Receiver</h2>
<?php foreach ($errors as $err) echo '<div class="alert alert-error">' . e($err) . '</div>'; ?>
<form method="POST" class="form-card">
    <label>Name</label><input type="text" name="name" value="<?php echo e($name); ?>">
    <label>Contact</label><input type="text" name="contact" value="<?php echo e($contact); ?>">
    <label>Receive Date</label><input type="date" name="date" value="<?php echo e($date); ?>">
    <label>Blood Group</label><select name="blood_group">
        <option value="">Select Blood Group</option><?php foreach (blood_groups() as $bg) { ?><option value="<?php echo e($bg); ?>" <?php if ($blood_group === $bg) echo 'selected'; ?>><?php echo e($bg); ?></option><?php } ?>
    </select>
    <button class="btn primary" type="submit">Update</button><a class="btn" href="<?php echo BASE_URL; ?>receiver/view_receiver.php">Cancel</a>
</form>
<?php require_once '../includes/footer.php'; ?>
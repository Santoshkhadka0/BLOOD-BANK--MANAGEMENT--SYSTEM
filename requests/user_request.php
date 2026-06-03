<?php
require_once '../includes/user_auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';
$errors = [];
$patient_name = $blood_group = $units = $reason = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = clean_text($_POST['patient_name'] ?? '');
    $blood_group = clean_text($_POST['blood_group'] ?? '');
    $units = filter_input(INPUT_POST, 'units', FILTER_VALIDATE_INT);
    $reason = clean_text($_POST['reason'] ?? '');
    if ($patient_name === '') $errors[] = 'Patient name is required.';
    if (!valid_blood_group($blood_group)) $errors[] = 'Invalid blood group.';
    if ($units === false || $units < 1 || $units > 10) $errors[] = 'Units must be between 1 and 10.';
    if ($reason === '') $errors[] = 'Reason is required.';
    if (!$errors) {
        $stmt = mysqli_prepare($conn, 'INSERT INTO blood_requests (user_id, patient_name, blood_group, units, reason) VALUES (?,?,?,?,?)');
        mysqli_stmt_bind_param($stmt, 'issis', $_SESSION['user_id'], $patient_name, $blood_group, $units, $reason);
        if (mysqli_stmt_execute($stmt)) {
            flash_set('success', 'Blood request submitted. Status is Pending.');
            redirect('requests/my_requests.php');
        } else $errors[] = 'Request submission failed.';
    }
}
require_once '../includes/user_header.php';
?>
<h2 class="page-title">Submit Blood Request</h2><?php foreach ($errors as $err) echo '<div class="alert alert-error">' . e($err) . '</div>'; ?>
<form method="POST" class="form-card"><label>Patient Name</label><input type="text" name="patient_name" value="<?php echo e($patient_name); ?>"><label>Blood Group</label><select name="blood_group">
        <option value="">Select</option><?php foreach (blood_groups() as $bg) { ?><option value="<?php echo e($bg); ?>" <?php if ($blood_group === $bg) echo 'selected'; ?>><?php echo e($bg); ?></option><?php } ?>
    </select><label>Units Required</label><input type="number" min="1" max="10" name="units" value="<?php echo e($units); ?>"><label>Reason</label><textarea name="reason" rows="4"><?php echo e($reason); ?></textarea><button class="btn primary" type="submit">Submit Request</button></form>
<?php require_once '../includes/footer.php'; ?>
<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    flash_set('error', 'Invalid request method.');
    redirect('requests/admin_requests.php');
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    flash_set('error', 'Invalid request id.');
    redirect('requests/admin_requests.php');
}

$status = 'Cancelled';
$stmt = mysqli_prepare($conn, "UPDATE blood_requests SET status = ? WHERE id = ? AND status = 'Pending'");
mysqli_stmt_bind_param($stmt, 'si', $status, $id);

if ($stmt && mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
    flash_set('success', 'Request cancelled.');
} else {
    flash_set('error', 'Pending request not found.');
}

redirect('requests/admin_requests.php');

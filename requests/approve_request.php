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

mysqli_begin_transaction($conn);
try {
    // 1. Lock and fetch the pending request
    $stmt = mysqli_prepare($conn, "SELECT * FROM blood_requests WHERE id = ? AND status = 'Pending' FOR UPDATE");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $req = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$req) {
        throw new Exception('Pending request not found.');
    }

    // 2. Lock and fetch current stock
    $stmt = mysqli_prepare($conn, 'SELECT units FROM blood_stock WHERE blood_group = ? FOR UPDATE');
    mysqli_stmt_bind_param($stmt, 's', $req['blood_group']);
    mysqli_stmt_execute($stmt);
    $stock = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if (!$stock || $stock['units'] < $req['units']) {
        throw new Exception('Not enough blood stock to approve this request.');
    }

    // 3. Deduct stock
    $newUnits = $stock['units'] - $req['units'];
    $stmt = mysqli_prepare($conn, 'UPDATE blood_stock SET units = ? WHERE blood_group = ?');
    mysqli_stmt_bind_param($stmt, 'is', $newUnits, $req['blood_group']);
    mysqli_stmt_execute($stmt);

    // 4. Mark request as approved
    $status = 'Approved';
    $stmt = mysqli_prepare($conn, 'UPDATE blood_requests SET status = ? WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'si', $status, $id);
    mysqli_stmt_execute($stmt);

    mysqli_commit($conn);
    flash_set('success', 'Request approved and stock updated.');
} catch (Exception $e) {
    mysqli_rollback($conn);
    flash_set('error', $e->getMessage());
}

redirect('requests/admin_requests.php');

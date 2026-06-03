<?php
require_once 'includes/config.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'dashboard.php');
    exit();
}

if (!empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'user/user_dashboard.php');
    exit();
}

header('Location: ' . BASE_URL . 'login.php');
exit();

<?php
require_once __DIR__ . '/config.php';

if (empty($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}

<?php
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'user/user_login.php');
    exit();
}

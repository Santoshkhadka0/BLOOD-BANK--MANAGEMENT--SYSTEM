<?php
require_once '../includes/config.php';
$_SESSION = [];
session_destroy();
header('Location: ' . BASE_URL . 'user/user_login.php');
exit();

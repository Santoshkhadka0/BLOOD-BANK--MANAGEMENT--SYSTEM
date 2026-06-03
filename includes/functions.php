<?php
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect($path) {
    header('Location: ' . BASE_URL . ltrim($path, '/'));
    exit();
}

function flash_set($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_show() {
    if (!empty($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];
        unset($_SESSION['flash']);
        echo '<div class="alert alert-' . e($type) . '">' . e($message) . '</div>';
    }
}

function blood_groups() {
    return ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
}

function valid_blood_group($group) {
    return in_array($group, blood_groups(), true);
}

function clean_text($text) {
    return trim(strip_tags((string)$text));
}

function valid_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function answer_hash($answer) {
    return password_hash(strtolower(trim($answer)), PASSWORD_DEFAULT);
}

function answer_verify($answer, $hash) {
    return password_verify(strtolower(trim($answer)), $hash);
}
?>

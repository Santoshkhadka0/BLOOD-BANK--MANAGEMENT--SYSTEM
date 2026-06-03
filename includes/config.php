<?php
// Main configuration file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database settings for XAMPP/phpMyAdmin
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'bloodbank';

// Auto BASE_URL that also works if the folder is nested inside htdocs.
// Example:
// htdocs/bloodbank_final/ -> /bloodbank_final/
// htdocs/test/bloodbank_final/ -> /test/bloodbank_final/
$projectRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$rawDocumentRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
$documentRootReal = ($rawDocumentRoot !== '') ? realpath($rawDocumentRoot) : false;
$documentRoot = $documentRootReal ? str_replace('\\', '/', $documentRootReal) : '';

if ($documentRoot !== '' && strpos($projectRoot, $documentRoot) === 0) {
    $basePath = substr($projectRoot, strlen($documentRoot));
    $basePath = str_replace('\\', '/', $basePath);
    $basePath = '/' . ltrim($basePath, '/');
    define('BASE_URL', rtrim($basePath, '/') . '/');
} else {
    // Safe fallback for normal XAMPP use
    define('BASE_URL', '/' . basename($projectRoot) . '/');
}

$BLOOD_GROUPS = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

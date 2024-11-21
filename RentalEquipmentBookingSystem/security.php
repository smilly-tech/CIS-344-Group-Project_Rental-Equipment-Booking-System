<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_regenerate_id(true);

ini_set('display_errors', 1);
error_reporting(E_ALL);

function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validate_csrf_token($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}

function sanitize_sql($data) {
    return preg_replace('/[^a-zA-Z0-9_ -]/s', '', $data);
}

function set_security_headers() {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Content-Security-Policy: default-src \'self\';');
}

set_security_headers();

?>

<?php
/**
 * BASE_URL tự động theo domain hiện tại (localhost, Render, v.v.)
 * - Nếu chạy ở thư mục con (ví dụ http://localhost/Vidental/index.php) => BASE_URL = http://localhost/Vidental
 * - Nếu chạy root (Render) => BASE_URL = https://<domain>
 */
$appUrl = getenv('APP_URL') ?: '';
if ($appUrl !== '') {
    // Cho phép set cứng trên Render nếu muốn (vd: https://springking03-github-io.onrender.com)
    define('BASE_URL', rtrim($appUrl, '/'));
} else {
    // Render/Proxy thường set X-Forwarded-Proto=https
    $xfProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || strtolower($xfProto) === 'https';

    $scheme = $isHttps ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';

    // dirname('/index.php') => '/', dirname('/Vidental/index.php') => '/Vidental'
    $basePath = str_replace('\\', '/', dirname($script));
    $basePath = rtrim($basePath, '/');
    if ($basePath === '' || $basePath === '.') $basePath = '';
    if ($basePath === '/') $basePath = '';

    define('BASE_URL', $scheme . '://' . $host . $basePath);
}

define('NOT_FOUND_URL', BASE_URL . '/index.php?controller=home&action=not_found');
define('UNAUTHORIZED_URL', BASE_URL . '/index.php?controller=home&action=unauthorized');

define('LOGIN_CLIENT_URL', BASE_URL . '/index.php?controller=auth&action=login');
define('PROCESS_LOGIN_CLIENT_URL', BASE_URL . '/index.php?controller=auth&action=processLoginClient');
define('LOGIN_ADMIN_URL', BASE_URL . '/index.php?controller=auth&action=loginAdmin');

define('REGISTER_URL', BASE_URL . '/index.php?controller=register&action=register');
define('HOME_CLIENT_URL', BASE_URL . '/index.php?controller=home&action=home');
define('HOME_ADMIN_URL', BASE_URL . '/index.php?controller=home&action=home_admin');
define('FORGOT_URL', BASE_URL . '/index.php?controller=auth&action=confirm_phone');

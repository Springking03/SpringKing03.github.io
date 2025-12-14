<?php
/**
 * Dynamic BASE_URL for both local (XAMPP) and hosted (Render).
 *
 * Priority:
 *  1) ENV APP_URL (recommended on Render), e.g. https://springking03-github-io.onrender.com
 *  2) Auto-detect from request headers (works behind reverse proxies)
 */
function __vidental_base_url(): string {
    $env = getenv('APP_URL');
    if ($env && $env !== '') {
        return rtrim($env, '/');
    }

    $scheme = 'http';
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];
    } elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $scheme = 'https';
    }

    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Detect subfolder for local setups, e.g. /Vidental
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $dir = rtrim(str_replace('\\', '/', dirname($script)), '/');
    $path = ($dir === '' || $dir === '.') ? '' : $dir;

    return rtrim($scheme . '://' . $host . $path, '/');
}

define('BASE_URL', __vidental_base_url());

// ---- Common routes ----
define('NOT_FOUND_URL', BASE_URL . '/index.php?controller=home&action=not_found');
define('UNAUTHORIZED_URL',  BASE_URL . '/index.php?controller=home&action=unauthorized');

define('LOGIN_CLIENT_URL', BASE_URL . '/index.php?controller=auth&action=login');
define('PROCESS_LOGIN_CLIENT_URL', BASE_URL . '/index.php?controller=auth&action=processLoginClient');
define('LOGIN_ADMIN_URL', BASE_URL . '/index.php?controller=auth&action=loginAdmin');

define('REGISTER_URL', BASE_URL . '/index.php?controller=register&action=register');
define('HOME_CLIENT_URL', BASE_URL . '/index.php?controller=home&action=home');
define('HOME_ADMIN_URL', BASE_URL . '/index.php?controller=home&action=home_admin');
define('FORGOT_URL', BASE_URL . '/index.php?controller=auth&action=forgot');

// Add more constants below if your code expects them (keep old names, but BASE_URL is dynamic)

<?php
/**
 * Cloudinary config (KHÔNG hardcode key/secret).
 * - Set env vars trên Render:
 *   CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, CLOUDINARY_API_SECRET
 *
 * Nếu chưa set, hệ thống vẫn chạy; chỉ các chức năng upload sẽ báo lỗi khi gọi.
 */
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
} else {
    if (!defined('CLOUDINARY_LOGGED')) { error_log('[Cloudinary] vendor/autoload.php missing. Hãy chạy: composer install'); define('CLOUDINARY_LOGGED', true); }
    $GLOBALS['cloudinary'] = null;
    return;
}

$cloudName = getenv('CLOUDINARY_CLOUD_NAME') ?: '';
$apiKey    = getenv('CLOUDINARY_API_KEY') ?: '';
$apiSecret = getenv('CLOUDINARY_API_SECRET') ?: '';

if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
    if (!defined('CLOUDINARY_LOGGED')) { error_log('[Cloudinary] Missing env vars: CLOUDINARY_CLOUD_NAME / CLOUDINARY_API_KEY / CLOUDINARY_API_SECRET'); define('CLOUDINARY_LOGGED', true); }
    $GLOBALS['cloudinary'] = null;
    return;
}

$cloudinary = new \Cloudinary\Cloudinary([
    'cloud' => [
        'cloud_name' => $cloudName,
        'api_key'    => $apiKey,
        'api_secret' => $apiSecret
    ],
    'url' => [
        'secure' => true
    ]
]);

$GLOBALS['cloudinary'] = $cloudinary;

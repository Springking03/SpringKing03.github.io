<?php
require_once __DIR__ . '/../vendor/autoload.php';

$cloudName = getenv('CLOUDINARY_CLOUD_NAME') ?: '';
$apiKey    = getenv('CLOUDINARY_API_KEY') ?: '';
$apiSecret = getenv('CLOUDINARY_API_SECRET') ?: '';

if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
    // Không fatal để web vẫn chạy nếu bạn chưa dùng Cloudinary ở môi trường đó
    error_log('[Cloudinary] Missing env vars: CLOUDINARY_CLOUD_NAME / CLOUDINARY_API_KEY / CLOUDINARY_API_SECRET');
    $GLOBALS['cloudinary'] = null;
    return;
}

// Khởi tạo đối tượng Cloudinary
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

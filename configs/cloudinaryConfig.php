<?php
// Only load Cloudinary if configured. This prevents crashes on Render when env vars are missing.
$cloudName = getenv('CLOUDINARY_CLOUD_NAME') ?: '';
$apiKey    = getenv('CLOUDINARY_API_KEY') ?: '';
$apiSecret = getenv('CLOUDINARY_API_SECRET') ?: '';

if ($cloudName === '' || $apiKey === '' || $apiSecret === '') {
    $GLOBALS['cloudinary'] = null;
    error_log('[Cloudinary] Missing env vars: CLOUDINARY_CLOUD_NAME / CLOUDINARY_API_KEY / CLOUDINARY_API_SECRET');
    return;
}

require_once __DIR__ . '/../vendor/autoload.php';

$cloudinary = new \Cloudinary\Cloudinary([
    'cloud' => [
        'cloud_name' => $cloudName,
        'api_key' => $apiKey,
        'api_secret' => $apiSecret,
    ],
    'url' => ['secure' => true],
]);

$GLOBALS['cloudinary'] = $cloudinary;

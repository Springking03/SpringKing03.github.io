<?php
require 'vendor/autoload.php';

// Khởi tạo đối tượng Cloudinary
$cloudinary = new \Cloudinary\Cloudinary([
    'cloud' => [
        'cloud_name' => 'dnp6p86dp',
        'api_key' => '898888481653775',
        'api_secret' => '4ftRkuEos6ZANqh8vTx0Oyd0wxg'
    ],
    'url' => [
        'secure' => true
    ]
]);

// Lưu đối tượng Cloudinary vào biến toàn cục để sử dụng sau này
$GLOBALS['cloudinary'] = $cloudinary;

?>
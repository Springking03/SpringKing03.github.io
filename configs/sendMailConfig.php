<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/convertDate.php';

function __mail_env(string $key, ?string $fallback = null): ?string {
    $v = getenv($key);
    if ($v === false || $v === '') return $fallback;
    return $v;
}

function __build_mailer(): PHPMailer {
    $mail = new PHPMailer(true);

    $host = __mail_env('SMTP_HOST', 'smtp.gmail.com');
    $port = (int)(__mail_env('SMTP_PORT', '587') ?? '587');
    $user = __mail_env('SMTP_USER', '');
    $passRaw = __mail_env('SMTP_PASS', '');

    // Gmail app password sometimes includes spaces; remove whitespace safely
    $pass = preg_replace('/\s+/', '', (string)$passRaw);

    if ($user === '' || $pass === '') {
        throw new Exception('Missing SMTP_USER/SMTP_PASS env vars');
    }

    $secure = __mail_env('SMTP_SECURE', 'tls'); // tls|ssl|none

    $fromEmail = __mail_env('SMTP_FROM_EMAIL', $user);
    $fromName  = __mail_env('SMTP_FROM_NAME', 'Nha khoa Vidental');

    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $user;
    $mail->Password = $pass;
    $mail->CharSet = 'UTF-8';

    if ($secure === 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    } elseif ($secure === 'tls') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    } else {
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
    }
    $mail->Port = $port;

    $mail->setFrom($fromEmail ?: $user, $fromName ?: 'Nha khoa Vidental');
    $mail->isHTML(true);

    return $mail;
}

function send_mail($specialtyName, $doctorName, $dateSlot, $timeSlot, $patientName, $patientPhone, $patientEmail, $patientDescription) {
    $dateFormatted = convertDate::convertDayTimestampToDate($dateSlot);

    try {
        $mail = __build_mailer();
        $mail->addAddress($patientEmail, $patientName);
        $mail->Subject = 'Xác nhận lịch khám – Nha khoa Vidental';

        $mail->Body = <<<HTML
<html>
<head>
<style>
.email-container{font-family:Arial,sans-serif;line-height:1.6;color:#333}
.email-header{background:#f7f7f7;padding:10px;border-bottom:1px solid #ddd}
.email-body{padding:20px}
.email-footer{background:#f7f7f7;padding:10px;border-top:1px solid #ddd;text-align:center;font-size:12px;color:#777}
.info-table{width:100%;border-collapse:collapse}
.info-table th,.info-table td{padding:8px;border:1px solid #ddd}
.info-table th{background:#f2f2f2}
</style>
</head>
<body>
<div class="email-container">
  <div class="email-header"><h2>Nha khoa Vidental</h2></div>
  <div class="email-body">
    <p>Xin chào <strong>{$patientName}</strong>,</p>
    <p>Lịch hẹn của bạn đã được tiếp nhận. Bộ phận CSKH sẽ gọi điện xác minh. Dưới đây là thông tin chi tiết:</p>
    <table class="info-table">
      <tr><th>Dịch vụ</th><td>{$specialtyName}</td></tr>
      <tr><th>Bác sĩ</th><td>{$doctorName}</td></tr>
      <tr><th>Ngày hẹn</th><td>{$dateFormatted}</td></tr>
      <tr><th>Giờ hẹn</th><td>{$timeSlot}</td></tr>
      <tr><th>Số điện thoại</th><td>{$patientPhone}</td></tr>
      <tr><th>Mô tả</th><td>{$patientDescription}</td></tr>
    </table>
    <p>Vui lòng đến đúng giờ. Cảm ơn Quý khách đã tin tưởng!</p>
  </div>
  <div class="email-footer"><p>&copy; 2025 Nha khoa Vidental.</p></div>
</div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Error: {$e->getMessage()}"]);
    }
}

function confirm_mail($specialtyName, $doctorName, $dateSlot, $timeSlot, $patientName, $patientPhone, $patientEmail, $patientDescription) {
    $dateFormatted = convertDate::convertDayTimestampToDate($dateSlot);

    try {
        $mail = __build_mailer();
        $mail->addAddress($patientEmail, $patientName);
        $mail->Subject = 'Xác nhận lịch hẹn – Nha khoa Vidental';

        $mail->Body = <<<HTML
<html><body>
<p>Xin chào <strong>{$patientName}</strong>,</p>
<p>Lịch hẹn của bạn đã được xác nhận:</p>
<ul>
  <li><strong>Dịch vụ:</strong> {$specialtyName}</li>
  <li><strong>Bác sĩ:</strong> {$doctorName}</li>
  <li><strong>Ngày:</strong> {$dateFormatted}</li>
  <li><strong>Giờ:</strong> {$timeSlot}</li>
  <li><strong>SĐT:</strong> {$patientPhone}</li>
  <li><strong>Mô tả:</strong> {$patientDescription}</li>
</ul>
<p>Vui lòng đến đúng giờ. Cảm ơn bạn!</p>
</body></html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Error: {$e->getMessage()}"]);
    }
}

function result_mail($patientName, $patientEmail, $link) {
    try {
        $mail = __build_mailer();
        $mail->addAddress($patientEmail, $patientName);
        $mail->Subject = 'Thông báo kết quả – Nha khoa Vidental';

        $safeLink = htmlspecialchars($link, ENT_QUOTES, 'UTF-8');

        $mail->Body = <<<HTML
<html><body>
<p>Xin chào <strong>{$patientName}</strong>,</p>
<p>Cảm ơn bạn đã sử dụng dịch vụ của Nha khoa Vidental. Vui lòng truy cập link sau để xem kết quả:</p>
<p><a href="{$safeLink}">Xem kết quả</a></p>
</body></html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Error: {$e->getMessage()}"]);
    }
}

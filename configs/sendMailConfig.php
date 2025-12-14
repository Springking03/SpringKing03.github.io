<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
error_log("PHPMailer loaded? " . (class_exists(\PHPMailer\PHPMailer\PHPMailer::class) ? 'YES' : 'NO'));

require_once __DIR__ . '/../utils/convertDate.php';


function send_mail($specialtyName, $doctorName, $dateSlot, $timeSlot, $patientName, $patientPhone, $patientEmail, $patientDescription) {
    $mail = new PHPMailer(true);

    // Format ngày trước khi dùng
    $dateFormatted = convertDate::convertDayTimestampToDate($dateSlot);

    try {
        // Cấu hình Server
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER') ?: '';
        $mail->Password   = getenv('SMTP_PASS') ?: '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)(getenv('SMTP_PORT') ?: 587);
        $mail->CharSet    = 'UTF-8';

        // Người gửi
        $fromEmail = getenv('SMTP_FROM') ?: (getenv('SMTP_USER') ?: 'no-reply@example.com');
        $fromName  = getenv('SMTP_FROM_NAME') ?: 'Nha khoa Vidental';
        $mail->setFrom($fromEmail, $fromName);

        // Người nhận
        $mail->addAddress($patientEmail, $patientName);

        // Nội dung Email
        $mail->isHTML(true);
        $mail->Subject = 'Xác nhận lịch khám – Nha khoa Vidental';

        $mail->Body = <<<HTML
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận lịch khám</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 30px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            color: #333;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .info-table th, .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .info-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Nha khoa Vidental</h2>
        </div>
        <div class="email-body">
            <p>Xin chào <strong>{$patientName}</strong>,</p>
            <p>Bạn đã đặt lịch khám thành công. Dưới đây là thông tin lịch khám:</p>

            <table class="info-table">
                <tr>
                    <th>Chuyên khoa</th>
                    <td>{$specialtyName}</td>
                </tr>
                <tr>
                    <th>Bác sĩ</th>
                    <td>{$doctorName}</td>
                </tr>
                <tr>
                    <th>Ngày hẹn</th>
                    <td>{$dateFormatted}</td>
                </tr>
                <tr>
                    <th>Giờ hẹn</th>
                    <td>{$timeSlot}</td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td>{$patientPhone}</td>
                </tr>
                <tr>
                    <th>Mô tả</th>
                    <td>{$patientDescription}</td>
                </tr>
            </table>

            <p>Vui lòng đến đúng giờ và mang theo các giấy tờ cần thiết.</p>
            <p>Trân trọng,<br><strong>Nha khoa Vidental</strong></p>
        </div>
    </div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['status' => 'success', 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

function confirm_mail($patientEmail, $patientName, $doctorName, $dateSlot, $timeSlot) {
    $mail = new PHPMailer(true);

    $dateFormatted = convertDate::convertDayTimestampToDate($dateSlot);

    try {
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER') ?: '';
        $mail->Password   = getenv('SMTP_PASS') ?: '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)(getenv('SMTP_PORT') ?: 587);
        $mail->CharSet    = 'UTF-8';

        $fromEmail = getenv('SMTP_FROM') ?: (getenv('SMTP_USER') ?: 'no-reply@example.com');
        $fromName  = getenv('SMTP_FROM_NAME') ?: 'Nha khoa Vidental';
        $mail->setFrom($fromEmail, $fromName);

        $mail->addAddress($patientEmail, $patientName);

        $mail->isHTML(true);
        $mail->Subject = 'Lịch hẹn đã được xác nhận – Nha khoa Vidental';

        $mail->Body = <<<HTML
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận lịch hẹn</title>
    <style>
        body { font-family: Arial, sans-serif; background-color:#f4f4f4; margin:0; padding:0; }
        .email-container { background:#fff; max-width:600px; margin:30px auto; border-radius:8px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        .email-header { background:#198754; color:#fff; padding:20px; text-align:center; }
        .email-body { padding:20px; color:#333; }
        .info-table { width:100%; border-collapse:collapse; margin-top:10px; }
        .info-table th, .info-table td { padding:8px; border:1px solid #ddd; }
        .info-table th { background:#f2f2f2; }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>Nha khoa Vidental</h2>
        <p>Lịch hẹn của bạn đã được xác nhận</p>
    </div>
    <div class="email-body">
        <p>Xin chào <strong>{$patientName}</strong>,</p>
        <p>Lịch hẹn của bạn với bác sĩ <strong>{$doctorName}</strong> đã được xác nhận.</p>

        <table class="info-table">
            <tr><th>Bác sĩ</th><td>{$doctorName}</td></tr>
            <tr><th>Ngày hẹn</th><td>{$dateFormatted}</td></tr>
            <tr><th>Giờ hẹn</th><td>{$timeSlot}</td></tr>
        </table>

        <p>Vui lòng đến đúng giờ để được phục vụ tốt nhất.</p>
        <p>Trân trọng,<br><strong>Nha khoa Vidental</strong></p>
    </div>
</div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['status' => 'success', 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

function result_mail($patientEmail, $patientName, $resultTitle, $resultContent) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER') ?: '';
        $mail->Password   = getenv('SMTP_PASS') ?: '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)(getenv('SMTP_PORT') ?: 587);
        $mail->CharSet    = 'UTF-8';

        $fromEmail = getenv('SMTP_FROM') ?: (getenv('SMTP_USER') ?: 'no-reply@example.com');
        $fromName  = getenv('SMTP_FROM_NAME') ?: 'Nha khoa Vidental';
        $mail->setFrom($fromEmail, $fromName);

        $mail->addAddress($patientEmail, $patientName);

        $mail->isHTML(true);
        $mail->Subject = $resultTitle;

        $safeContent = nl2br(htmlspecialchars($resultContent, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));

        $mail->Body = <<<HTML
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kết quả</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
    .wrap { background:#fff; max-width:600px; margin:30px auto; border-radius:8px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    .head { background:#0d6efd; color:#fff; padding:20px; text-align:center; }
    .body { padding:20px; color:#333; }
    .box { background:#f8f9fa; border:1px solid #e9ecef; padding:15px; border-radius:6px; }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="head">
      <h2>Nha khoa Vidental</h2>
    </div>
    <div class="body">
      <p>Xin chào <strong>{$patientName}</strong>,</p>
      <p>Dưới đây là nội dung kết quả:</p>
      <div class="box">{$safeContent}</div>
      <p>Trân trọng,<br><strong>Nha khoa Vidental</strong></p>
    </div>
  </div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['status' => 'success', 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>

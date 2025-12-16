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
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hyn18224@gmail.com';
        $mail->Password   = 'kvvb gfyy sgrh wgja';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // Người gửi
        $mail->setFrom('hyn18224@gmail.com', 'Nha khoa Vidental');

        // Người nhận
        $mail->addAddress($patientEmail, $patientName);

        // Nội dung Email
        $mail->isHTML(true);
        $mail->Subject = 'Xác nhận lịch khám – Nha khoa Vidental';

        $mail->Body = <<<HTML
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .email-header {
            background-color: #f7f7f7;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background-color: #f7f7f7;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
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
            <p>Lịch hẹn của bạn đã được tiếp nhận. Trong thời gian sớm nhất sẽ có bộ phận CSKH gọi điện xác minh lịch hẹn, vui lòng để ý điện thoại của bạn. Dưới đây là thông tin chi tiết:</p>
            <table class="info-table">
                <tr>
                    <th>Dịch vụ</th>
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
            <p>Vui lòng đến đúng giờ. Cảm ơn Quý khách đã tin tưởng!</p>
        </div>
        <div class="email-footer">
            <p>&copy; 2025 Nha khoa Vidental. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

function confirm_mail($specialtyName, $doctorName, $dateSlot, $timeSlot, $patientName, $patientPhone, $patientEmail, $patientDescription) {
    $mail = new PHPMailer(true);

    $dateFormatted = convertDate::convertDayTimestampToDate($dateSlot);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hyn18224@gmail.com';
        $mail->Password   = 'kvvb gfyy sgrh wgja';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('hyn18224@gmail.com', 'Nha khoa Vidental');
        $mail->addAddress($patientEmail, $patientName);

        $mail->isHTML(true);
        $mail->Subject = 'Xác nhận lịch hẹn – Nha khoa Vidental';

        $mail->Body = <<<HTML
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .email-header {
            background-color: #f7f7f7;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background-color: #f7f7f7;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
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
            <p>Lịch hẹn của bạn đã được xác nhận. Dưới đây là thông tin chi tiết:</p>
            <table class="info-table">
                <tr>
                    <th>Dịch vụ</th>
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
        </div>
        <div class="email-footer">
            <p>&copy; 2025 Nha khoa Vidental. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

function result_mail($patientName, $patientEmail, $link) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hyn18224@gmail.com';
        $mail->Password   = 'kvvb gfyy sgrh wgja';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('hyn18224@gmail.com', 'Nha khoa Vidental');
        $mail->addAddress($patientEmail, $patientName);

        $mail->isHTML(true);
        $mail->Subject = 'Thông báo kết quả – Nha khoa Vidental';

        $mail->Body = <<<HTML
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .email-header {
            background-color: #f7f7f7;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            background-color: #f7f7f7;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #777;
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
            <p>Cảm ơn bạn đã sử dụng dịch vụ của Nha khoa Vidental. Vui lòng truy cập link sau để xem kết quả:</p>
            <p><a href="{$link}">Xem kết quả</a></p>
        </div>
        <div class="email-footer">
            <p>&copy; 2025 Nha khoa Vidental. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
HTML;

        $mail->send();
        return json_encode(['success' => true, 'message' => 'Message has been sent']);
    } catch (Exception $e) {
        return json_encode(['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>
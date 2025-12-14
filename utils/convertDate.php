<?php
if (!class_exists('convertDate')) {
    class convertDate {
    public static function convertDateToDayTimestamp($dateString): ?float
    {
        if (!$dateString) return null;
        $parts = explode('/', $dateString);
        $day = intval($parts[0]);
        $month = intval($parts[1]);
        $year = intval($parts[2]);
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone("Asia/Ho_Chi_Minh")); // Sử dụng múi giờ của Việt Nam
        $date->setDate($year, $month, $day);
        $date->setTime(0, 0, 0);

        return ceil($date->getTimestamp() / 86400); // 86400 là số giây trong một ngày
    }

    public static function convertFormYMDToTimestamp($dateString): ?float
    {
        if (!$dateString) return null;
        $parts = explode('-', $dateString);
        $year = intval($parts[0]);
        $month = intval($parts[1]);
        $day = intval($parts[2]);
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone("Asia/Ho_Chi_Minh")); // Sử dụng múi giờ của Việt Nam
        $date->setDate($year, $month, $day);
        $date->setTime(0, 0, 0);

        return ceil($date->getTimestamp() / 86400); // 86400 là số giây trong một ngày
    }

    public static function convertDayTimestampToDate($dayTimestamp) {
        // Chuyển đổi timestamp của ngày trở lại thành miligiây
        $milliseconds = $dayTimestamp * 86400000;

        // Tạo đối tượng DateTime từ timestamp (miligiây)
        $date = new DateTime("@".($milliseconds / 1000)); // Chia cho 1000 để chuyển từ miligiây sang giây

        // Định dạng ngày tháng theo chuẩn mong muốn
        return $date->format('d/m/Y'); // Định dạng ngày/tháng/năm
    }


}
}

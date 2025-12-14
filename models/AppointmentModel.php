<?php
require_once __DIR__ . '/../core/Database.php';
require 'utils/convertDate.php';

class AppointmentModel extends Database {
    protected $connection = null;

    public function __construct() {
        $this->connection = $this->connect();
    }

    private function _query($sql): mysqli_result|bool
    {
        return mysqli_query($this->connection, $sql);
    }

    public function getAppointmentGuests($limit = 10, $page = 1, $search = null): array
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.patient_id AS patient_id,
                       a.patient_name AS patient_name,
                       a.patient_dob AS patient_dob,
                       a.patient_gender AS patient_gender,
                       a.patient_phone AS patient_phone,
                       a.patient_email AS patient_email,
                       COUNT(a.appointment_id) AS total_appointments
                FROM appointments AS a
                         JOIN employees AS e ON e.employee_id = a.employee_id
                         JOIN time_slots AS ts ON ts.time_id = a.time_id
                         JOIN services AS s ON s.service_id = a.service_id
                WHERE a.patient_id IS NULL AND a.status = 2 ";
        if ($search) {
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= "GROUP BY a.patient_phone LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getTotalAppointmentGuests($search = null) {
        $sql = "SELECT COUNT(*) AS total 
               FROM appointments AS a
                         JOIN employees AS e ON e.employee_id = a.employee_id
                         JOIN time_slots AS ts ON ts.time_id = a.time_id
                         JOIN services AS s ON s.service_id = a.service_id
                WHERE a.patient_id IS NULL AND a.status = 2";
        if ($search) {
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointmentsExpired($specialty = null, $doctor = null, $search = null) {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status =  3";

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getAppointmentExpired($limit = 10, $page = 1, $specialty = null, $doctor = null, $search = null): array
    {

        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status =  3";
        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.update_at DESC LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function updateAppointment($id, $employee_id, $service_id, $date_slot, $time_id, $patient_name, $patient_gender, $patient_email, $patient_description, $status, $update_by): bool {

        if ($id === null) {
            return false;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $updated_at = date('Y-m-d H:i:s');

        $sql = "UPDATE appointments SET 
            date_slot = ?,
            employee_id = ?,
            patient_description = ?,
            patient_email = ?,
            patient_gender = ?,
            patient_name = ?,
            service_id = ?,
            status = ?,
            time_id = ?,
            update_at = ?,
            update_by = ?
        WHERE appointment_id = ?";

        // Chuẩn bị và thực thi truy vấn
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param('iissisiiisii',
                $date_slot,
                $employee_id,
                $patient_description,
                $patient_email,
                $patient_gender,
                $patient_name,
                $service_id,
                $status,
                $time_id,
                $updated_at,
                $update_by,
                $id
            );
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi
            error_log('Lỗi cập nhật cuộc hẹn: ' . $e->getMessage());
            return false;
        }
    }

    public function updateResultAppointment($id, $result): bool {
        if ($id === null) {
            return false;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $updatedAt = date('Y-m-d H:i:s');

        // Cập nhật kết quả và trạng thái nếu trạng thái hiện tại là 1
        $sql = "UPDATE appointments SET
                result = ?,
                update_at = ?,
                status = CASE WHEN status = 1 THEN 2 ELSE status END
            WHERE appointment_id = ?";

        // Chuẩn bị và thực thi truy vấn
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param('ssi', $result, $updatedAt, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi
            error_log('Lỗi cập nhật kết quả: ' . $e->getMessage());
            return false;
        }
    }

    public function updateStatusAppointment($id): bool {
        if ($id === null) {
            return false;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $updatedAt = date('Y-m-d H:i:s');

        // Cập nhật kết quả và trạng thái nếu trạng thái hiện tại là 1
        $sql = "UPDATE appointments SET
                update_at = ?,
                status = CASE WHEN status = 1 THEN 3 ELSE status END
            WHERE appointment_id = ?";

        // Chuẩn bị và thực thi truy vấn
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param('si', $updatedAt, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi
            error_log('Lỗi cập nhật kết quả: ' . $e->getMessage());
            return false;
        }
    }

    public function getAppointmentById($appointmentId = null): array
    {
        $sql = "SELECT a.appointment_id AS id,
                       e.name AS doctor_name,
                       e.employee_id AS employee_id,
                       e.name AS employee_name,
                       a.patient_name AS patient_name,
                       a.patient_dob AS patient_dob,
                       a.patient_gender AS patient_gender,
                       a.patient_phone AS patient_phone,
                       a.patient_email AS patient_email,
                       a.patient_description AS patient_description,
                       s.name AS specialty_name,
                       s.service_id AS service_id,
                       s.name AS specialty_name,
                       a.date_slot AS date_slot,
                       ts.slot_time AS time_slot,
                       ts.time_id AS time_id,
                       a.result AS result,
                       a.status AS status
                FROM appointments AS a
                         JOIN employees AS e ON e.employee_id = a.employee_id
                         JOIN time_slots AS ts ON ts.time_id = a.time_id
                         JOIN services AS s ON s.service_id = a.service_id
                WHERE a.appointment_id = " . $appointmentId;

        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function getAppointmentConfirm($limit = 10, $page = 1, $specialty = null, $doctor = null, $search = null): array
    {

        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status =  0 ";
        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.date_slot, ts.slot_time ASC LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getTotalAppointmentsConfirm($specialty = null, $doctor = null, $search = null) {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status =  0";

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getAppointmentToday($limit = 10, $page = 1, $specialty = null, $doctor = null, $date = null, $search = null): array
    {
        $converter = new ConvertDate();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $offset = ($page - 1) * $limit;
        $today = date('d/m/Y');
        $date = $converter->convertDateToDayTimestamp($today);

        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status != 0 AND a.date_slot = " . $date;

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY ts.slot_time, a.date_slot LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getAllAppointmentsForAdmin($limit = 10, $page = 1, $specialty = null, $doctor = null, $statusAppointment = null, $search = null): array {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee')";

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }
        if (isset($statusAppointment) && $statusAppointment !== '') {
            $statusArray = explode(',', $statusAppointment);
            $statusArray = array_filter($statusArray, function($value) {
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            });

            if (count($statusArray) > 0) {
                $statusList = implode("','", $statusArray);
                $sql .= " AND a.status IN ('$statusList')";
            }
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.created_at DESC LIMIT $limit OFFSET $offset";
        error_log("Giá trị của biến: " . $sql);
        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getTotalAppointmentsToday($specialty = null, $doctor = null, $date = null, $search = null)
    {
        $converter = new ConvertDate();

        $today = date('d/m/Y');
        $date = $converter->convertDateToDayTimestamp($today);

        $sql = "SELECT COUNT(*) AS total
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee') AND a.status != 0 AND a.date_slot = " . $date;

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY ts.slot_time, a.date_slot";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments() {
        $sql = "SELECT COUNT(*) AS total FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            WHERE r.role_name = LOWER('employee')";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointmentsWithParam($specialty = null, $doctor = null, $statusAppointment = null, $search = null) {
        $sql = "SELECT COUNT(*) AS total FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN services AS s ON s.service_id = a.service_id
            WHERE r.role_name = LOWER('employee')";

        if ($specialty) {
            $sql .= " AND s.service_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if (isset($statusAppointment) && $statusAppointment !== '') {
            // Chuyển đổi chuỗi thành mảng
            $statusArray = explode(',', $statusAppointment);

            // Lọc và xác thực mỗi giá trị trong mảng
            $statusArray = array_filter($statusArray, function($value) {
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            });

            if (count($statusArray) > 0) {
                // Sử dụng implode() để tạo chuỗi cho câu lệnh SQL
                $statusList = implode("','", $statusArray);
                $sql .= " AND a.status IN ('$statusList')";
            }
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function createAppointment($specialId, $doctorId, $dateSlot, $timeSlotId, $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription, $patient_id): int|string {
        // Đặt múi giờ sang "Asia/Ho_Chi_Minh"
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $createdAt = date('Y-m-d H:i:s');

        // Kiểm tra xem patient_id có giá trị hay không
        if ($patient_id !== null) {
            $sql = "INSERT INTO appointments (
                service_id, employee_id, date_slot, time_id,
                patient_name, patient_gender, patient_dob, patient_phone, patient_email, patient_description,
                patient_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = "iiiissssssiis";
        } else {
            $sql = "INSERT INTO appointments (
                service_id, employee_id, date_slot, time_id,
                patient_name, patient_gender, patient_dob, patient_phone, patient_email, patient_description,
                status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = "iiiissssssis";
        }

        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }

        // Thêm trạng thái và ngày tạo vào bind_param
        $status = 0;  // Giả sử trạng thái mặc định là 0
        if ($patient_id !== null) {
            $stmt->bind_param($params, $specialId, $doctorId, $dateSlot, $timeSlotId,
                $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription,
                $patient_id, $status, $createdAt);
        } else {
            $stmt->bind_param($params, $specialId, $doctorId, $dateSlot, $timeSlotId,
                $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription,
                $status, $createdAt);
        }

        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return $stmt->insert_id; // Trả về ID của bản ghi mới được chèn
    }

    //
    public function getAppointmentsByPatient($phone = null, $patient_id = null): array
    {
        $sql = "SELECT a.appointment_id AS id,
                   a.status AS status,
                   a.result AS result,
                   a.patient_name AS patient_name,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   a.date_slot AS date_slot,
                   e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   s.name AS specialty_name,
                   ts.slot_time AS time_slot
            FROM appointments AS a
                     JOIN employees AS e ON e.employee_id = a.employee_id
                     JOIN time_slots AS ts ON ts.time_id = a.time_id
                     JOIN services AS s ON s.service_id = a.service_id
            WHERE a.patient_phone = ? OR a.patient_id = ?
            ORDER BY a.date_slot ASC";

        if ($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("si", $phone, $patient_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
            return $data;
        } else {
            return [];
        }
    }

    public function getAppointmentsByPhone($phone = null): array
    {
        $sql = "SELECT a.appointment_id AS id,
                   a.status AS status,
                   a.result AS result,
                   a.patient_name AS patient_name,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   a.date_slot AS date_slot,
                   e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   s.name AS specialty_name,
                   ts.slot_time AS time_slot
            FROM appointments AS a
                     JOIN employees AS e ON e.employee_id = a.employee_id
                     JOIN time_slots AS ts ON ts.time_id = a.time_id
                     JOIN services AS s ON s.service_id = a.service_id
            WHERE  a.status = 2 AND a.patient_phone = ? 
            ORDER BY a.date_slot ASC";

        if ($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
            return $data;
        } else {
            return [];
        }
    }

//    get
    public function getTotalAppointmentsCancel() {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            WHERE  a.status = 3";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointmentsSuccess() {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            WHERE  a.status = 2";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointmentsProcess() {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            WHERE  a.status = 1";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments0_14() {
        $sql = "SELECT COUNT(*) AS total
                FROM appointments AS a
                WHERE a.status = 2 
                AND TIMESTAMPDIFF(YEAR, a.patient_dob, CURDATE()) BETWEEN 0 AND 14;";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments15_35() {
        $sql = "SELECT COUNT(*) AS total
                FROM appointments AS a
                WHERE a.status = 2 
                AND TIMESTAMPDIFF(YEAR, a.patient_dob, CURDATE()) BETWEEN 15 AND 35;";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments36_64() {
        $sql = "SELECT COUNT(*) AS total
                FROM appointments AS a
                WHERE a.status = 2 
                AND TIMESTAMPDIFF(YEAR, a.patient_dob, CURDATE()) BETWEEN 36 AND 64;";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments64() {
        $sql = "SELECT COUNT(*) AS total
                FROM appointments AS a
                WHERE a.status = 2 
                AND TIMESTAMPDIFF(YEAR, a.patient_dob, CURDATE()) > 64;;";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }
}
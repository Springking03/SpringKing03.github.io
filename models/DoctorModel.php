<?php
require_once 'configs/cloudinaryConfig.php';
class DoctorModel  extends BaseModel {
    const ROLE = 'doctor';

    protected $connection = null;

    public function __construct() {
        $this->connection = $this->connect();
    }

    private function _query($sql){
        return mysqli_query($this->connection, $sql);
    }

    public function getById($id): array
    {
        $sql = "SELECT e.employee_id AS id,
                        e.name AS name,
                       e.avt AS avt,
                       e.gender AS gender,
                       e.dob AS dob,
                       e.email AS email,
                       e.phone AS phone,
                       e.address AS address,
                       e.status AS status,
                       e.service_id AS service_id,
                       p.name AS positionName,
                       e.employee_code AS employee_code
                FROM employees AS e
                JOIN positions AS p ON e.position_id = p.position_id
                WHERE e.employee_id = $id";

        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    /**
     * @throws Exception
     */
    public function updateDoctor($doctor_id, $name, $dob, $email, $phone, $gender, $address, $service_id, $status, $avt, $update_by)
    {
        // Kiểm tra số điện thoại đã tồn tại chưa và không thuộc về nhân viên hiện tại
        $currentPhone = $this->getById($doctor_id)['phone'];
        if ($phone !== $currentPhone && $this->checkPhoneExists($phone)) {
            return [
                'success' => false,
                'message' => 'Số điện thoại đã tồn tại trong hệ thống.'
            ];
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $updated_at = date("Y-m-d H:i:s");

        $sql = "UPDATE employees SET
                service_id = ?,
                name = ?,
                phone = ?,
                email = ?,
                dob = ?,
                gender = ?,
                address = ?, 
                status = ?,
                update_at = ?,
                avt = ?,
                update_by = ?
            WHERE employee_id = ?";

        $stmt = mysqli_prepare($this->connection, $sql);
        if ($stmt === false) {
            throw new Exception('MySQL prepare error: ' . mysqli_error($this->connection));
        }

        mysqli_stmt_bind_param($stmt, 'issssisissii',
            $service_id, $name, $phone, $email, $dob, $gender,
            $address, $status, $updated_at, $avt, $update_by, $doctor_id);

        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Exception('Failed to execute statement: ' . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
        return [
            'success' => true,
            'message' => 'Thông tin nhân viên đã được cập nhật thành công.'
        ];
    }

    public function addDoctor($name, $dob, $email, $phone, $gender, $address, $service_id, $position_id, $status, $avt, $update_by): array
    {
        // Kiểm tra số điện thoại đã tồn tại chưa
        if ($this->checkPhoneExists($phone)) {
            return [
                'success' => false,
                'message' => 'Số điện thoại đã tồn tại trong hệ thống.'
            ];
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $created_at = date("Y-m-d H:i:s");
        $hashedPassword = password_hash('Abc12345', PASSWORD_BCRYPT, ['cost' => 12]);
        if($position_id == 5) {
            $role_id = 3;
        } else {
            $role_id = 2;
        }
        // Bước 1: Thêm  mà không có employee_code
        $sql = "INSERT INTO employees (
                   service_id,
                   position_id,
                   role_id,
                   name,
                   password,
                   phone,
                   email,
                   dob,
                   gender,
                   address, 
                   status,
                   create_at,
                   avt,
                   update_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->connection, $sql);
        if ($stmt === false) {
            throw new Exception('MySQL prepare error: ' . mysqli_error($this->connection));
        }

        mysqli_stmt_bind_param($stmt, 'iiisssssisissi',
            $service_id, $position_id, $role_id, $name, $hashedPassword, $phone, $email, $dob, $gender,
            $address, $status, $created_at, $avt, $update_by);
        $result = mysqli_stmt_execute($stmt);
        if ($result === false) {
            throw new Exception('Failed to execute statement: ' . mysqli_stmt_error($stmt));
        }

        // Lấy ID của bác sĩ vừa được thêm
        $doctor_id = mysqli_insert_id($this->connection);

        // Bước 2: Tạo employee_code và cập nhật
        $employee_code = 'EMP' . $doctor_id; // Sử dụng tiền tố 'DOC' cho bác sĩ
        $sqlUpdate = "UPDATE employees SET employee_code = ? WHERE employee_id = ?";
        $stmtUpdate = mysqli_prepare($this->connection, $sqlUpdate);
        if ($stmtUpdate === false) {
            throw new Exception('MySQL prepare error: ' . mysqli_error($this->connection));
        }

        mysqli_stmt_bind_param($stmtUpdate, 'si', $employee_code, $doctor_id);
        $resultUpdate = mysqli_stmt_execute($stmtUpdate);
        if ($resultUpdate === false) {
            throw new Exception('Failed to update employee code: ' . mysqli_stmt_error($stmtUpdate));
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmtUpdate);

        return [
            'success' => true,
            'message' => 'Chuyên gia đã được thêm thành công.'
        ];
    }

    public function getDoctorForHome(): array
    {
        $sql = "SELECT e.employee_id, e.name as doctorName, e.avt, s.name as specialtyName
                FROM employees AS e
                JOIN services AS s ON e.service_id = s.service_id
                JOIN roles AS r ON r.role_id = e.role_id
                WHERE r.role_name = 'employee'
                LIMIT 3";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getDoctorForAdmin(): array
    {
        $sql = "SELECT
                    e.employee_id AS id,
                    e.avt AS avt,
                    e.name AS name,
                    p.name AS position,
                    s.name AS specialty,
                    e.email AS email,
                    e.phone AS phone,
                    e.gender AS gender,
                    e.dob AS dob,
                    e.employee_code AS employee_code,
                    e.status AS status
                FROM employees AS e
                    JOIN positions AS p ON e.position_id = p.position_id
                    JOIN services AS s ON e.service_id = s.service_id
                    JOIN roles AS r ON e.role_id = r.role_id
                WHERE r.role_name = LOWER('employee') OR r.role_name = LOWER('consultant') ORDER BY e.employee_id DESC";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getDoctorsBySpecialty($specialty): array
    {
        $sql = "SELECT e.employee_id, e.name
                FROM employees AS e
                JOIN services AS s ON e.service_id = s.service_id
                JOIN roles AS r ON r.role_id = e.role_id
                WHERE r.role_name = 'employee' AND e.status = 1 AND s.service_id = $specialty";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function checkPhoneExists($phone): bool {
        $sql = "SELECT COUNT(*) as count FROM employees WHERE phone = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        if ($stmt === false) {
            throw new Exception('MySQL prepare error: ' . mysqli_error($this->connection));
        }

        mysqli_stmt_bind_param($stmt, 's', $phone);
        if (mysqli_stmt_execute($stmt) === false) {
            throw new Exception('Failed to execute statement: ' . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $row['count'] > 0;
    }
}
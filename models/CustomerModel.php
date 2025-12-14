<?php
class CustomerModel extends Database {
    protected $connection = null;

    public function __construct() {
        $this->connection = $this->connect();
    }

    private function _query($sql){
        return mysqli_query($this->connection, $sql);
    }

    public function getPatientForAdmin(): array
    {
        $sql = "SELECT p.patient_id AS patient_id,
                       p.name AS name,
                       p.dob AS dob,
                       p.gender AS gender,
                       p.address AS address,
                       p.phone AS phone,
                       p.email AS email,
                       COUNT(a.patient_id) AS total_appointments
                FROM customers AS p
                         LEFT JOIN appointments AS a ON p.patient_id = a.patient_id
                GROUP BY p.patient_id, p.name, p.dob, p.gender, p.address, p.phone, p.email";
        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function findById($id): array
    {
        $sql = "SELECT p.patient_id,
                       p.name AS name,
                       p.email AS email,
                       p.phone AS phone,
                       p.gender AS gender,
                       p.dob AS dob,
                       p.address AS address,
                        p.status AS status
                FROM customers AS p WHERE p.patient_id = {$id}";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function findByPhone($phone): array
    {
        $sql = "SELECT p.patient_id,
                       p.name AS name,
                       p.email AS email,
                       p.phone AS phone,
                       p.gender AS gender,
                       p.dob AS dob,
                       p.address AS address,
                        p.status AS status
                FROM customers AS p WHERE p.phone = {$phone}";
        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function updatePatient($name, $gender, $dob, $email, $address, $phone) {
        $sql = "UPDATE customers SET 
                    name = '" . mysqli_real_escape_string($this->connection, $name) . "',
                    email = '" . mysqli_real_escape_string($this->connection, $email) . "',
                    gender = '" . intval($gender) . "',
                    dob = '" . mysqli_real_escape_string($this->connection, $dob) . "',
                    address = '" . mysqli_real_escape_string($this->connection, $address) . "'
                WHERE phone = " . $phone;

        $query = $this->_query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function updateStatus($patient_id, $status, $employee_id) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $update_at = date('Y-m-d H:i:s');
        $sql = "UPDATE customers SET 
                    status = '" . intval($status) . "',
                    update_at = '" . mysqli_real_escape_string($this->connection, $update_at) . "',
                    update_by = '" . intval($employee_id) . "'
                WHERE patient_id = " . $patient_id;

        $query = $this->_query($sql);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPhoneExists($phone): bool {
        $sql = "SELECT COUNT(*) as count FROM customers WHERE phone = ?";
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
<?php
require 'configs/cloudinaryConfig.php';
class EmployeeController extends BaseController {
    private EmployeeModel $employeeModel;
    private SpecialtyModel $specialtyModel;
    private PositionModel $positionModel;

    public function __construct()
    {
        $this->loadModel('EmployeeModel');
        $this->employeeModel = new EmployeeModel();

        $this->loadModel('PositionModel');
        $this->positionModel = new PositionModel();

        $this->loadModel('SpecialtyModel');
        $this->specialtyModel = new SpecialtyModel();
    }

    public function index()
    {
        $listEmployees = $this->employeeModel->getEmployeeForAdmin();
        $listPositions = $this->positionModel->getAll();
        $listSpecialties = $this->specialtyModel->getSpecialtiesForAppointment();
        return $this->view('admin.employees', [
            'listEmployees' => $listEmployees,
            'listPositions' => $listPositions,
//            'listSpecialties' => $listSpecialties,
        ]);
    }

    /**
     * @throws Exception
     */
    public function add()
    {
        session_start();
        if (isset($_SESSION['admin_name'])) {
            $position_id = $_POST['position_id'];
            $name = $_POST['name'];
            $phone  = $_POST['phone'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $address  = $_POST['address'];
            $status  = $_POST['status'];

            $update_by = $_SESSION['admin_id'];

            // Xử lý upload ảnh đại diện
            if (isset($_FILES['avt']) && $_FILES['avt']['error'] == 0) {
                $avt = $this->uploadImageToCloudinary($this->escapeBackslashes($_FILES['avt']['tmp_name']));
            } else {
                $avt = BASE_URL .'/assets/img/doctors/doctor_default.png';
            }

            $result = $this->employeeModel->addEmployee($name,$dob, $email, $phone, $gender, $address, $position_id, $status, $avt, $update_by);
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            }
            return $this->view('test', [
                'result' => $result,
            ]);
        } else {
            header('Location: '. BASE_URL .'/index.php?controller=home&action=not_found');
            exit();
        }
    }

    public function detail()
    {
        $employee_id = $_GET['employee_id'];
        $employee = $this->employeeModel->getById($employee_id);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($employee_id);
            exit;
        }
        return $this->view('admin.employee-detail', [
            'employee' => $employee,
        ]);
    }

    public function update()
    {
        session_start();
        if (isset($_SESSION['admin_name'])) {
            $employee_id = $_POST['id'];
            $name = $_POST['name'];
            $phone  = $_POST['phone'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $address  = $_POST['address'];
            $status  = $_POST['status'];

            $update_by = $_SESSION['admin_id'];

            // Xử lý upload ảnh đại diện
            if (isset($_FILES['avtUpdate']) && $_FILES['avtUpdate']['error'] == 0) {
                $avt = $this->uploadImageToCloudinary($this->escapeBackslashes($_FILES['avtUpdate']['tmp_name']));
            } else {
                $avt = $_POST['avt'];
            }

            $result = $this->employeeModel->updateEmployee($employee_id, $name, $dob, $email, $phone, $gender, $address, $status, $avt, $update_by);
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            }
            return $this->view('admin.employees', [
                'result' => $result,
            ]);
        } else {
            header('Location: '. BASE_URL .'/index.php?controller=home&action=not_found');
            exit();
        }
    }

    public function profile()
    {
        session_start();
        if (isset($_SESSION['admin_id'])) {
            $id = $_SESSION['admin_id'];
            $employee = $this->employeeModel->getById($id);
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($employee);
                exit;
            }
            return $this->view('admin.profile', [
                'employee' => $employee,
            ]);
        } else {
            header('Location: '. NOT_FOUND_URL);
            exit();
        }
    }

    public function uploadImageToCloudinary($imagePath): string
    {
        try {
            // Truy cập đối tượng Cloudinary từ biến toàn cục
            $cloudinary = $GLOBALS['cloudinary'];

            // Upload ảnh lên Cloudinary sử dụng đối tượng Cloudinary
            $result = $cloudinary->uploadApi()->upload($imagePath);

            // Trả về URL an toàn của ảnh đã upload
            return $result['secure_url'];
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    private function escapeBackslashes($string): array|string
    {
        return str_replace("\\", "\\\\", $string);
    }

    /**
     * @throws Exception
     */
    public function checkExistedPhone(): void
    {
        $phone = $_POST['phone'];
        $result = $this->employeeModel->checkPhoneExists($phone);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
    }

}

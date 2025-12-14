<?php
class CustomerController extends BaseController
{
    private $customerModel;
    private $specialtyModel;
    private $appointmentModel;

    public function __construct()
    {
        $this->loadModel('CustomerModel');
        $this->customerModel = new CustomerModel();

        $this->loadModel('SpecialtyModel');
        $this->specialtyModel = new SpecialtyModel();

        $this->loadModel('AppointmentModel');
        $this->appointmentModel = new AppointmentModel();

    }

    public function index()
    {
        $listSpecialties = $this->specialtyModel->getSpecialtiesForAdmin();
        $listPatients = $this->customerModel->getPatientForAdmin();
        return $this->view('admin.customers', [
            'listPatients' => $listPatients,
            'listSpecialties' => $listSpecialties,
        ]);
    }

    public function guest()
    {
        $page= $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? null;

        $totalAppointmentsGuest = $this->appointmentModel->getTotalAppointmentGuests($search);
        $appointmentsGuests = $this->appointmentModel->getAppointmentGuests(10, $page, $search);
        return $this->view('admin.guests', [
            'totalAppointmentsGuest' => $totalAppointmentsGuest,
            'appointmentsGuests' => $appointmentsGuests,
        ]);
    }

    public function guest_detail_admin()
    {
        $phone= $_POST['phone'];

        $listAppointments = $this->appointmentModel->getAppointmentsByPhone($phone);
        return $this->view('admin.guest-detail', [
            'listAppointments' => $listAppointments,
        ]);
    }

    public function guest_detail()
    {
        $phone= $_GET['phone'];

        $listAppointments = $this->appointmentModel->getAppointmentsByPhone($phone);
        return $this->view('admin.guest-detail', [
            'listAppointments' => $listAppointments,
        ]);
    }

    public function profile()
    {
        session_start();
        if (isset($_SESSION['user_phone'])) {
            $phone = $_SESSION['user_phone'];
            $patient = $this->customerModel->findByPhone($phone);
            return $this->view('client.profile', [
                'patient' => $patient,
            ]);
        } else {
            header('Location: '. BASE_URL .'/index.php?controller=home&action=not_found');
            exit();
        }
    }

    public function detail()
    {
        $id = $_GET['patient_id'] ?? null;
        $patient = $this->customerModel->findById($id);
        $listAppointments = $this->appointmentModel->getAppointmentsByPatient($patient['phone'], $patient['patient_id']);
        return $this->view('admin.customer-detail', [
            'patient' => $patient,
            'listAppointments' => $listAppointments,
        ]);
    }

    public function detail_patient()
    {
        $id = $_POST['patient_id'];
        $patient = $this->customerModel->findById($id);
        $listAppointments = $this->appointmentModel->getAppointmentsByPatient($patient['phone'], $patient['patient_id']);
        return $this->view('admin.customer-detail', [
            'patient' => $patient,
            'listAppointments' => $listAppointments,
        ]);
    }

    public function update_information()
    {
        session_start();
        if (isset($_SESSION['user_phone'])) {
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $phone = $_SESSION['user_phone'];
            $result = $this->customerModel->updatePatient($name, $gender, $dob, $email, $address, $phone);
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            } else {
                return $this->view('client.profile', [
                    'result' => $result,
                ]);
            }
        } else {
            header(''. BASE_URL .'/index.php?controller=home&action=login');
            exit();
        }
    }

    public function history()
    {
        session_start();
        if (isset($_SESSION['user_phone'])) {
            $phone = $_SESSION['user_phone'];
            $patient_id = $_SESSION['patient_id'];
            $listAppointments = $this->appointmentModel->getAppointmentsByPatient($phone, $patient_id);
            return $this->view('client.history', [
                'listAppointments' => $listAppointments,
            ]);
        } else {
            header('Location: '.NOT_FOUND_URL);
            exit();
        }
    }

    public function search()
    {
        $phone = $_POST['phone'];
        $listAppointments = $this->appointmentModel->getAppointmentsByPatient($phone);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($listAppointments);
            exit;
        } else {
            return $this->view('client.history', [
                'listAppointments' => $listAppointments,
            ]);
        }

    }

    public function update_status()
    {
        session_start();
        if (isset($_SESSION['admin_name'])) {
            $employee_id = $_SESSION['admin_id'];
            $status = $_POST['status'];
            $patient_id = $_POST['patient_id'];
            $result = $this->customerModel->updateStatus($patient_id, $status, $employee_id );
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode($result);
                exit;
            } else {
                return $this->view('404', [
                    'result' => $result,
                ]);
            }
        } else {
            header('Location: ' .NOT_FOUND_URL);
            exit();
        }
    }

    public function get_one()
    {
        $patient_id = $_POST['patient_id'];
        $patient = $this->customerModel->findById($patient_id);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($patient);
            exit;
        } else {
            return $this->view('404', [
                'patient' => $patient,
            ]);
        }
    }

    public function detail_appointment(): void
    {
        $appointment_id = $_GET['id'];
        $appointment = $this->appointmentModel->getAppointmentById($appointment_id);
        $this->view('client.appointment-detail', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * @throws Exception
     */
    public function check_phone()
    {
        $phone = $_POST['phone'];  // Đảm bảo rằng bạn đang sử dụng POST ở đây
        $result = $this->customerModel->checkPhoneExists($phone);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        } else {
            return $this->view('client.profile', [
                'result' => $result,
            ]);
        }
    }
}

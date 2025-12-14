<?php
//require_once 'BaseController.php';
class HomeController extends BaseController
{
    private $doctorModel;
    private $specialtyModel;
    private $authModel;
    private $appointmentModel;

    public function __construct()
    {
        $this->loadModel('DoctorModel');
        $this->doctorModel = new DoctorModel();

        $this->loadModel('SpecialtyModel');
        $this->specialtyModel = new SpecialtyModel();

        $this->loadModel('AppointmentModel');
        $this->appointmentModel = new AppointmentModel();

        $this->loadModel('AuthModel');
        $this->authModel = new AuthModel();
    }

    public function home()
    {
        $listDoctors = $this->doctorModel->getDoctorForHome();
        return $this->view('client.home_cent', [
            'listDoctors' => $listDoctors,
        ]);
    }

    public function home_admin()
    {
        $appointmentSuccess = $this->appointmentModel->getTotalAppointmentsSuccess();
        $appointmentPending = $this->appointmentModel->getTotalAppointmentsConfirm();
        $appointmentProcess = $this->appointmentModel->getTotalAppointmentsProcess();
        $appointmentCancel = $this->appointmentModel->getTotalAppointmentsCancel();

        $from0_14 = $this->appointmentModel->getTotalAppointments0_14();
        $from15_35 = $this->appointmentModel->getTotalAppointments15_35();
        $from36_64 = $this->appointmentModel->getTotalAppointments36_64();
        $from65 = $this->appointmentModel->getTotalAppointments64();
        return $this->view('admin.index', [
            'appointmentProcess' => $appointmentProcess,
            'appointmentSuccess' => $appointmentSuccess,
            'appointmentPending' => $appointmentPending,
            'appointmentCancel' => $appointmentCancel,
            'from0_14' => $from0_14,
            'from15_35' => $from15_35,
            'from36_64' => $from36_64,
            'from65' => $from65,
        ]);
    }

    public function not_found()
    {
        return $this->view('404', [
        ]);
    }

    public function login()
    {
        return $this->view('client.login');
    }

    public function appointment($specialtyId = null)
    {
        $listSpecialties = $this->specialtyModel->getSpecialtiesForAppointment();
        $listDoctorsBySpecialty = [];
        if ($specialtyId !== null) {
            $listDoctorsBySpecialty = $this->doctorModel->getDoctorsBySpecialty($specialtyId);
        }
        // Kiểm tra xem yêu cầu có phải là AJAX hay không
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Nếu là AJAX, chỉ trả về JSON của listDoctorsBySpecialty
            header('Content-Type: application/json');
            echo json_encode($listDoctorsBySpecialty);
            exit;
        } else {
            // Nếu không phải AJAX, trả về view như bình thường
            return $this->view('client.appointment', [
                'listSpecialties' => $listSpecialties,
                'listDoctorsBySpecialty' => $listDoctorsBySpecialty
            ]);
        }
    }

    public function getDoctor()
    {
        $specialtyId = $_GET['specialtyId'] ?? null;
        $listDoctorsBySpecialty = $this->doctorModel->getDoctorsBySpecialty($specialtyId);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($listDoctorsBySpecialty);
            exit;
        } else {
            return $this->view('test', [
                'listDoctorsBySpecialty' => $listDoctorsBySpecialty
            ]);
        }
    }

    public function confirm()
    {
        return $this->view('client.confirm', [
        ]);
    }

    public function search_client()
    {
        return $this->view('client.search');
    }

    public function about()
    {
        $listDoctors = $this->doctorModel->getDoctorForHome();
        return $this->view('client.about', [
            'listDoctors' => $listDoctors,
        ]);
    }

    public function services()
    {
        return $this->view('client.services');
    }

    public function blog()
    {
        return $this->view('client.blog');
    }

    public function contact()
    {
        return $this->view('client.contact');
    }

    public function unauthorized()
    {
        return $this->view('admin.unauthorized');
    }

    public function logout()
    {
        $this->authModel->logout();
        return $this->view('test', [
        ]);
    }
}
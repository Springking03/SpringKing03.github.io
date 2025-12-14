<?php
session_start(); // Khởi động session
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. LOGIN_ADMIN_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="http://localhost/Vidental/assetsv2/img/logo.svg" rel="icon">
    <title>Xác nhận lịch hẹn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <link href="<?php echo BASE_URL ?>/assets/css/appointment.css" rel="stylesheet">
    <style>
        #btn-action:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
<div id="loading-spinner"
     style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1051; display: flex; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Cập nhật lịch hẹn</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>/index.php?controller=home&action=home_admin">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý đặt lịch</li>
                    <li class="breadcrumb-item active">Cập nhật lịch hẹn</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid pt-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table p-3 m-0">
                        <form method="GET" action="#" class="row">
                            <div class="col-md-6" id="form-time-container">
                                <?php include "./views/admin/components/form-time.php" ?>
                            </div>
                            <div id="form-info-container" class="col-md-6">
                                <?php include "./views/admin/components/form-information.php" ?>
                            </div>
                        </form>
                        <hr>
                        <div class="modal-footer p-0 d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn btn-danger" onclick="window.history.back();">Quay lại</button>
                                <button type="button" class="btn btn-warning ml-3" id="changeInfor">Thay đổi thông tin</button>
                            </div>

                            <button id="btnUpdate" type="button" class="btn btn-primary">
                                Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdropApUp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                Xác nhận cập nhật lịch hẹn
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="update-appointment">Lưu lại</button>
            </div>
        </div>
    </div>
</div>
<script>
    var baseUri = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL ?>/assets/js/appointment-update.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/validate-appointment.js"></script>
<?php include 'import-script.php'?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        App.init()
        document.getElementById('loading-spinner').style.display = 'none';
        var staticBackdropApUp = new bootstrap.Modal(document.getElementById('staticBackdropApUp'));
        disableForm();

        var appointmentUpdate = [];

        $.ajax({
            url: '<?php echo BASE_URL ?>/index.php',
            type: 'GET',
            data: {
                controller: 'appointment',
                action: 'get_one',
                appointmentId: <?php echo $_GET['appointmentId'] ?>
            },
            success: function (response) {
                document.getElementById('timeSlot').innerText = response['time_slot'].substring(0, 5);
                buildAppointment(response);
                showAppointmentUpdate(response)
            },
            error: function () {
                alert('Có lỗi xảy ra khi lấy dữ liệu');
            }
        });

        document.getElementById('changeInfor').addEventListener('click', function (){
            enableForm()
        })

        document.getElementById('selected-doctor').addEventListener('change', function (){
            document.getElementById('input-otherDate').disabled = false;
        })

        // Tạo dữ liệu gốc trước khi update
        function buildAppointment(response) {
            appointmentUpdate['id'] = parseInt(response['id'], 10)
            appointmentUpdate['employee_id'] = parseInt(response['employee_id'], 10)
            appointmentUpdate['specialty_id'] = parseInt(response['service_id'], 10)
            appointmentUpdate['date_slot'] = parseInt(response['date_slot'], 10)
            appointmentUpdate['time_id'] = parseInt(response['time_id'], 10)
            appointmentUpdate['patient_name'] = response['patient_name']
            appointmentUpdate['patient_gender'] = parseInt(response['patient_gender'], 10)
            appointmentUpdate['patient_dob'] = response['patient_dob']
            appointmentUpdate['patient_phone'] = response['patient_phone']
            appointmentUpdate['patient_email'] = response['patient_email']
            appointmentUpdate['patient_description'] = response['patient_description']
            appointmentUpdate['status'] = parseInt(response['status'], 10)

            appointmentUpdate['specialty_name'] = response['specialty_name']
            appointmentUpdate['employee_name'] = response['employee_name']
            appointmentUpdate['patient_phone'] = response['patient_phone']
            appointmentUpdate['time_slot'] = response['time_slot']

            // console.log("parseInt(response['specialty_id'], 10): ", parseInt(response['service_id'], 10))
            return appointmentUpdate;
        }

        // Khi có sự thay đổi dữ liệu sẽ cập nhật lại dữ liệu từng trường
        document.getElementById('patient-name').addEventListener('change', function () {
            appointmentUpdate['patient_name'] = this.value;
        });

        document.getElementById('patient-dob').addEventListener('change', function () {
            appointmentUpdate['patient_dob'] = this.value;
        });

        document.getElementById('patient-phone').addEventListener('change', function () {
            appointmentUpdate['patient_phone'] = this.value;
        });

        document.getElementById('patient-email').addEventListener('change', function () {
            appointmentUpdate['patient_email'] = this.value;
        });

        document.getElementById('patient-description').addEventListener('change', function () {
            appointmentUpdate['patient_description'] = this.value;
        });

        document.getElementById('status-appointment').addEventListener('change', function () {
            document.getElementById('btnUpdate').disabled = false
            appointmentUpdate['status'] = parseInt(this.value, 10);
        });

        var genderInputs = document.getElementsByName('gender');
        Array.from(genderInputs).forEach(function (input) {
            input.addEventListener('change', function () {
                if (this.checked) {
                    appointmentUpdate['patient_gender'] = parseInt(this.value, 10)
                }
            });
        });

        document.getElementById('btnUpdate').addEventListener('click', function () {
            var isValid = true;

            // Kiểm tra tên bệnh nhân
            var errorName = document.getElementById('error-name-gender');
            var patientName = appointmentUpdate['patient_name'];
            if (!patientName) {
                errorName.style.display = 'block';
                errorName.textContent = 'Vui lòng nhập tên bệnh nhân'
                isValid = false;
            } else if(patientName.length < 5 || patientName.length > 100) {
                errorName.style.display = 'block';
                errorName.textContent = 'Tên có độ dài từ 5 đến 100 kí tự'
                isValid = false;
            }
            else {
                errorName.style.display = 'none';
            }

            // Kiểm tra ngày sinh
            var errorDob = document.getElementById('error-dob');
            var patientDob = appointmentUpdate['patient_dob'];

            const dob = new Date(patientDob);
            const now = new Date();
            const oneYearAgo = new Date(now.getFullYear() - 1, now.getMonth(), now.getDate());

            if (!patientDob) {
                errorDob.style.display = 'block';
                errorDob.textContent = 'Vui lòng chọn ngày sinh';
                isValid = false;
            } else if ( dob >= oneYearAgo) {
                errorDob.style.display = 'block';
                errorDob.textContent = 'Ngày sinh không hợp lệ';
                isValid = false;
            } else {
                errorDob.style.display = 'none';
            }

            // Kiểm tra số điện thoại
            var errorPhone = document.getElementById('error-phone');
            var patientPhone = appointmentUpdate['patient_phone'];
            const phoneRegex = /^(0|\+84)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
            if (!patientPhone || !phoneRegex.test(patientPhone)) {
                errorPhone.style.display = 'block';
                errorPhone.textContent = 'Số điện thoại không hợp lệ'
                isValid = false;
            } else {
                errorPhone.style.display = 'none';
            }

            // Kiểm tra email
            var errorEmail = document.getElementById('error-email');
            var patientEmail = appointmentUpdate['patient_email'];
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!patientEmail || !emailRegex.test(patientEmail)) {
                errorEmail.style.display = 'block';
                errorEmail.textContent = 'Email không hợp lệ'
                isValid = false;
            } else {
                errorEmail.style.display = 'none';
            }

            if(isValid === true) staticBackdropApUp.show()

        })

        // Sự kiện click nút cập nhật
        document.getElementById('update-appointment').addEventListener('click', function () {
            document.getElementById('loading-spinner').style.display = 'block';
            staticBackdropApUp.hide()
            var appointmentUpdated = appointmentUpdate;

            appointmentUpdated['specialty_id'] = isNaN(parseInt(document.getElementById('selected-specialty')?.value, 10))
                ? appointmentUpdate['specialty_id']
                : parseInt(document.getElementById('selected-specialty')?.value, 10);

            appointmentUpdated['employee_id'] = isNaN(parseInt(document.getElementById('selected-doctor')?.value, 10))
                ? appointmentUpdate['employee_id']
                : parseInt(document.getElementById('selected-doctor')?.value, 10);

            appointmentUpdated['date_slot'] = isNaN(parseInt(document.getElementById('date-slot').value, 10))
                ? appointmentUpdate['date_slot']
                : parseInt(document.getElementById('date-slot').value, 10);

            console.log(appointmentUpdated['date_slot'])

            appointmentUpdated['time_id'] = isNaN(parseInt(document.getElementById('time-slot')?.value, 10))
                ? appointmentUpdate['time_id']
                : parseInt(document.getElementById('time-slot')?.value, 10);

            console.log('appointmentUpdated', appointmentUpdated)


            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=appointment&action=update',
                type: 'POST',
                data: {
                    id: appointmentUpdated['id'],
                    employee_id: appointmentUpdate['employee_id'],
                    specialty_id: appointmentUpdate['specialty_id'],
                    date_slot: appointmentUpdate['date_slot'],
                    time_id: appointmentUpdate['time_id'],
                    patient_name: appointmentUpdate['patient_name'],
                    patient_gender: appointmentUpdate['patient_gender'],
                    patient_email: appointmentUpdate['patient_email'],
                    patient_description: appointmentUpdate['patient_description'],
                    status: appointmentUpdate['status'],

                    specialty_name:  appointmentUpdate['specialty_name'],
                    employee_name: appointmentUpdate['employee_name'],
                    phone: appointmentUpdate['patient_phone'],
                    time_slot: appointmentUpdate['time_slot'].slice(0, 5)
                },
                success: function (response) {
                    success_toast('<?php echo BASE_URL ?>/index.php?controller=appointment&action=confirm')
                    console.log(response.data)
                },
                error: function () {
                    failed_toast()
                    document.getElementById('loading-spinner').style.display = 'none';
                }
            });
        });

        // in thong tin len man update
        function showAppointmentUpdate(appointment) {
            var specialty = document.getElementById('dropdownMenuButton');
            var doctor = document.getElementById('dropdownMenuButtonDoctor');
            var date_selected = document.getElementById('input-otherDate');
            var patient_name = document.getElementById('patient-name');
            var gender = document.getElementsByName('gender');
            var patient_dob = document.getElementById('patient-dob');
            var patient_phone = document.getElementById('patient-phone');
            var patient_email = document.getElementById('patient-email');
            var patient_description = document.getElementById('patient-description')
            var status_appointment = document.getElementById('status-appointment');

            // Hiển thị các khung giờ
            displayTimeSlots([], appointment['time_slot']);

            // Cập nhật thông tin dịch vụ và chuyen gia
            specialty.textContent = 'Dịch vụ: ' + appointment['specialty_name'];
            doctor.textContent = 'Chuyên gia: ' + appointment['doctor_name'];

            patient_name.value = appointment['patient_name']
            for (var i = 0; i < gender.length; i++) {
                // Kiểm tra nếu giá trị của radio button trùng với 'patient_gender'
                if (gender[i].value == appointment['patient_gender']) {
                    gender[i].checked = true; // Đặt radio button này là checked
                    break; // Thoát vòng lặp sau khi đã tìm thấy và đặt checked
                }
            }
            patient_dob.value = appointment['patient_dob']
            patient_phone.value = appointment['patient_phone']
            patient_email.value = appointment['patient_email']
            patient_description.value = appointment['patient_description']
            status_appointment.value = parseInt(appointment['status'], 10);

            // Tính toán timestamp từ số ngày kể từ ngày 1/1/1970
            var timestamp = appointment['date_slot'] * 86400 * 1000; // Nhân với 1000 để chuyển từ giây sang miligiây

            // Tạo đối tượng Date mới từ timestamp
            var date = new Date(timestamp);

            // Định dạng ngày tháng
            var formattedDate = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear();

            // Hiển thị ngày đã định dạng
            date_selected.value = formattedDate;
        }
    });
</script>
<script>
    function disableForm(){
        document.getElementById('btnUpdate').disabled = true
        document.getElementById('dropdownMenuButton').disabled = true;
        document.getElementById('display-time-slot').style.display = 'none';
        document.getElementById('input-otherDate').disabled = true;
        document.getElementById('patient-name').disabled = true;
        document.getElementById('patient-dob').disabled = true;
        document.getElementById('patient-phone').disabled = true;
        document.getElementById('patient-email').disabled = true;
        document.getElementById('patient-description').disabled = true;
    }

    function enableForm(){
        document.getElementById('dropdownMenuButton').disabled = false;
        document.getElementById('patient-name').disabled = false;
        document.getElementById('patient-dob').disabled = false;
        document.getElementById('patient-phone').disabled = false;
        document.getElementById('patient-email').disabled = false;
        document.getElementById('patient-description').disabled = false;
        document.getElementById('status-appointment').disabled = false;

        document.getElementById('btnUpdate').disabled = false
    }
</script>
<script>
    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              Cập nhật thành công !
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`,
            autohide: true,
            delay: 800
        });

        // Đợi DOM cập nhật
        setTimeout(() => {
            // Lấy phần tử toast mới nhất
            var toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                var bsToast = new bootstrap.Toast(toastElement); // Khởi tạo lại đối tượng Toast nếu cần
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.href = redirectUrl; // Sử dụng URL được truyền vào
                    document.getElementById('loading-spinner').style.display = 'none';
                });
            }
        }, 100); // Đợi 100ms để đảm bảo toast đã được thêm vào DOM
    }

    function failed_toast() {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">
                  Đã có lỗi xảy ra !
                </div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
        })
    }
</script>
</body>
</html>
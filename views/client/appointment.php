<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lịch Hẹn</title>
    <link href="http://localhost/Vidental/assetsv2/img/logo.svg" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/appointment.css" rel="stylesheet">

    <!-- Thêm jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Thêm jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet" href="assetsv2/css/style.css" type="text/css">
</head>

<body>
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <ul class="header__top__left" style="margin-bottom: 0!important;">
                        <li><i class="fa fa-phone"></i> +84 988 526 666</li>
                        <li><i class="fa fa-map-marker"></i> 12 P. Chùa Bộc, Quang Trung, Đống Đa, Hà Nội</li>
                        <li><i class="fa fa-clock-o"></i> Thứ 2 - Thứ 6 8:00 - 17:00</li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="header__top__right" style="padding-top: 13px; text-align: right; color: whitesmoke; ">
                        <?php
                        if (!isset($_SESSION['user_phone'])) {
                            echo
                                '<a href="'. LOGIN_CLIENT_URL .'" class=" order-last order-lg-0" style="color:white;">
                                      <i style="color: white;" class="fa fa-sign-in" aria-hidden="true"></i>
                                      Đăng nhập
                                    </a>';
                        } else {
                            $username =  $_SESSION['user_name'];

                            // Hiển thị số điện thoại người dùng
                            echo '<div class="dropdown order-last order-lg-0">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            ' . htmlspecialchars($username) . '
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="'. BASE_URL .'/index.php?controller=customer&action=profile">
                                    Thông tin cá nhân</a>
                            </li>
                            <li><a class="dropdown-item" href="'. BASE_URL .'/index.php?controller=customer&action=history">
                                    Lịch sử sử dụng dịch vụ</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Đăng xuất
                                </a></li>
                        </ul>
                    </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="header__logo" style="padding-top: 15px">
                    <a href="./index.php"><img width="220" src="http://localhost/Vidental/assetsv2/img/logo.svg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="header__menu__option">
                    <nav class="header__menu">
                        <ul>
                            <li class="<?php echo ($action == 'home') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=home">Trang chủ</a>
                            </li>
                            <li class="<?php echo ($action == 'about') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=about">GIỚI THIỆU</a>
                            </li>
                            <li class="<?php echo ($action == 'services') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=services">Dịch vụ</a>
                            </li>
                            <li class="<?php echo ($action == 'blog') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=blog">Tin Tức</a>
                            </li>
                            <li class="<?php echo ($action == 'contact') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=contact">Liên hệ</a>
                            </li>
                            <li class="<?php echo ($action == 'lookup') ? 'active' : ''; ?>">
                                <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=search_client">Tra cứu</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="header__btn">
                        <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=appointment"
                           class="primary-btn">Đặt Lịch Ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<div id="loading-spinner" style="text-align: center; line-height: 700px; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1051; display: none; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<main id="main">
    <section class="container" style="padding-top: 70px">
        <h2>Đặt Lịch Hẹn</h2>
        <hr>
        <form method="GET" action="#" class="row">
            <div id="form-time-container">
                <?php include "components/form-time.php" ?>
            </div>
            <div id="form-info-container">
                <?php include "components/form-information.php" ?>
            </div>
        </form>
    </section>
</main>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Kiểm tra lịch hẹn</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="mb-2">
                        <label for="conName" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="conName" disabled>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-7">
                            <label for="conDob" class="form-label">Ngày sinh</label>
                            <input type="text" class="form-control" id="conDob" disabled>
                        </div>
                        <div class="col-5">
                            <label for="conGender" class="form-label">Giới tính</label>
                            <input type="text" class="form-control" id="conGender" disabled>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-6">
                            <label for="conEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="conEmail" disabled>
                        </div>
                        <div class="col-6">
                            <label for="conPhone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="conPhone" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <label for="conNameDoctor" class="form-label">Tên bác sĩ</label>
                        <input type="text" class="form-control" id="conNameDoctor" disabled>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-6">
                            <label for="conSpecialty" class="form-label">Dịch vụ</label>
                            <input type="text" class="form-control" id="conSpecialty" disabled>
                        </div>
                        <div class="col-6">
                            <label for="conTime" class="form-label">Thời gian hẹn</label>
                            <input style="background-color: #d25b33" type="text" class="form-control" id="conTime"
                                   disabled>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="conDescription" class="form-label">Ghi chú</label>
                        <textarea class="form-control" rows="2" id="conDescription" disabled></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button id="submit-button" class="btn btn-success" type="button"
                        style="background-color:#d25b33 !important; font-weight: bold; border: none">
                    Đặt lịch
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="informationNoti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Thông tin không đầy đủ để tự động điền, bạn cần bổ sung thông tin tài khoản.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="<?php echo BASE_URL ?>/index.php?controller=customer&action=profile" class="btn btn-primary">Thêm thông tin tài khoản</a>
            </div>
        </div>
    </div>
</div>
<?php include "component_cent/header.php"; ?>

<?php include "component_cent/footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!-- Thêm JavaScript của jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var baseUri = '<?php echo BASE_URL; ?>';
</script>
<script src="assets/js/appointment.js"></script>
<script src="assets/js/validate-appointment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loading-spinner').style.display = 'none';

        const formTimeContainer = document.getElementById('form-time-container');
        const formInfoContainer = document.getElementById('form-info-container');
        const buttonAction = document.getElementById('action-button');

        var informationNoti = new bootstrap.Modal(document.getElementById('informationNoti'));
        // Ban đầu ẩn form thông tin
        formInfoContainer.style.display = 'none';

        document.getElementById('backAppointment').addEventListener('click' , function (){
            formTimeContainer.style.display = 'block';
            formInfoContainer.style.display = 'none';
        });

        const patientId = <?php echo isset($_SESSION['patient_id']) ? json_encode($_SESSION['patient_id']) : 'null'; ?>;
        var autoInformationButton = document.getElementById('autoInformation');


        if (patientId !== null) {
            autoInformationButton.style.display = 'block';
        } else {
            autoInformationButton.style.display = 'none';
        }

        document.getElementById('autoInformation').addEventListener('click', function () {
            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=customer&action=get_one',
                type: 'POST',
                data: {
                    patient_id: patientId
                },
                success: function (response) {
                    document.getElementById('error-name-gender').style.display = 'none';
                    document.getElementById('error-dob').style.display = 'none';
                    document.getElementById('error-phone').style.display = 'none';
                    document.getElementById('error-email').style.display = 'none';
                    if (response.name && response.gender && response.dob && response.email && response.phone) {
                        document.getElementById('patient-name').value = response.name;
                        document.querySelector('input[name="gender"][value="' + response.gender + '"]').checked = true;
                        document.getElementById('patient-dob').value = response.dob;
                        document.getElementById('patient-phone').value = response.phone;
                        document.getElementById('patient-email').value = response.email;

                        document.getElementById('loading-spinner').style.display = 'none';
                        document.getElementById('autoInformation').style.display = 'none';
                        success_toast_2('Điền thông tin thành công')
                    } else {
                        informationNoti.show()
                        document.getElementById('loading-spinner').style.display = 'none';
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                    failed_toast()
                }
            });
        });

        // Kiểm tra các giá trị khi nút được nhấn
        buttonAction.addEventListener('click', function () {
            var specialId = document.getElementById('selected-specialty')?.value;
            var doctorId = document.getElementById('selected-doctor')?.value;
            var dateSlot = document.getElementById('date-slot')?.value;
            var timeSlotId = document.getElementById('time-slot')?.value;

            console.log(validateAppointment(specialId, doctorId, dateSlot, timeSlotId))
            // Kiểm tra nếu một trong các giá trị là rỗng
            if (validateAppointment(specialId, doctorId, dateSlot, timeSlotId)) {
                buttonAction.disabled = false; // Enable nút
                // Ẩn form thời gian và hiển thị form thông tin
                formTimeContainer.style.display = 'none';
                formInfoContainer.style.display = 'block';
            }
        });
    });
</script>
<script>
    const openConfirm = document.getElementById('openConfirm');
    const submitButton = document.getElementById('submit-button');

    openConfirm.addEventListener('click', () => {
        var specialId = parseInt(document.getElementById('selected-specialty')?.value, 10);
        var doctorId = parseInt(document.getElementById('selected-doctor')?.value, 10);
        var dateSlot = parseInt(document.getElementById('date-slot')?.value, 10);
        var timeSlotId = parseInt(document.getElementById('time-slot')?.value, 10);
        var patientName = document.getElementById('patient-name')?.value;
        var patientGender = parseInt(document.querySelector('input[name="gender"]:checked')?.value, 10);
        var patientDob = document.getElementById('patient-dob')?.value;
        var patientPhone = document.getElementById('patient-phone')?.value;
        var patientEmail = document.getElementById('patient-email')?.value;
        var patientDescription = document.getElementById('patient-description')?.value;

        // console.log('patientId:', patientId);
        console.log('specialId:', specialId);
        console.log('doctorId:', doctorId);
        console.log('dateSlot:', dateSlot);
        console.log('timeSlotId:', timeSlotId);
        console.log('patientName:', patientName);
        console.log('patientGender:', patientGender);
        console.log('patientDob:', patientDob);
        console.log('patientPhone:', patientPhone);
        console.log('patientEmail:', patientEmail);
        console.log('patientDescription:', patientDescription);

        if(validatePatientInfo(patientName, patientGender, patientDob, patientPhone, patientEmail, patientDescription)) {
            document.getElementById('conName').value = patientName;
            document.getElementById('conDob').value = patientDob;
            document.getElementById('conGender').value = patientGender === 1 ? 'Nam' : 'Nữ';
            document.getElementById('conPhone').value = patientPhone;
            document.getElementById('conEmail').value = patientEmail;
            document.getElementById('conNameDoctor').value = document.getElementById('selected-doctor-name').value;
            document.getElementById('conSpecialty').value = document.getElementById('selected-specialty-name').value;
            document.getElementById('conTime').value = document.getElementById('selected-time-slot').value
                + ', '
                + document.getElementById('selected-date-slot').value;
            document.getElementById('conDescription').value = patientDescription;

            // Hiển thị modal
            var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            modal.show();
        }

        submitButton.addEventListener('click', () => {
            if (validatePatientInfo(patientName, patientGender, patientDob, patientPhone, patientEmail, patientDescription)) {
                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: '<?php echo BASE_URL ?>/index.php',
                    type: 'POST',
                    data: {
                        controller: 'appointment',
                        action: 'create',
                        specialId: specialId,
                        doctorId: doctorId,
                        dateSlot: dateSlot,
                        timeSlotId: timeSlotId,
                        patientName: patientName,
                        patientGender: patientGender,
                        patientDob: patientDob,
                        patientPhone: patientPhone,
                        patientEmail: patientEmail,
                        patientDescription: patientDescription,

                        specialtyName: document.getElementById('selected-specialty-name').value,
                        doctorName: document.getElementById('selected-doctor-name').value,
                        timeSlot : document.getElementById('selected-time-slot').value
                    },
                    success: function (res) {
  console.log(res);

  if (res.mail && res.mail.success === false) {
    console.error('MAIL FAIL:', res.mail.message);
    failed_toast('Đặt lịch OK nhưng gửi mail thất bại: ' + res.mail.message);
    return;
  }

  success_toast('<?php echo HOME_CLIENT_URL ?>');
},
dataType: 'json',

                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                        failed_toast('Có lỗi xảy ra khi tạo lịch hẹn.')
                    },
                });
            }
        })
    });

</script>
<script>
    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              Đặt lịch hẹn thành công !
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`,
            autohide: true,
            delay: 1000
        });

        setTimeout(() => {
            var toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                var bsToast = new bootstrap.Toast(toastElement);
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.href = redirectUrl;
                });
            }
        }, 100);
    }

    function success_toast_2(message) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              ${message}
            </div>
            <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>`,
            autohide: true,
            delay: 1000
        });
    }

    function failed_toast(message) {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">
                  ${message}
                </div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
        })
    }
</script>
</body>
</html>
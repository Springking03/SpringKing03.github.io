<?php include "component_cent/header.php"; ?>
<!--<link href="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" rel="icon">-->
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">-->
<!--<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="assets/css/style.css" rel="stylesheet">
<style>
    .error {
        border: 2px solid red;
    }
    .error-message {
        color: red;
        font-size: 0.8em;
        margin-top: 5px;
    }
</style>
<body>
<div id="loading-spinner" style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1060; display: flex; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Offcanvas Menu Begin -->
<?php include "component_cent/offMenu.php"; ?>
<!-- Offcanvas Menu End -->

<!-- Header Section Begin -->
<?php include "component_cent/header_content.php"; ?>
<!-- Header Section End -->
<main class="container" style="margin-top: 100px!important; margin-bottom: 30px">
    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="https://png.pngtree.com/png-clipart/20210608/ourlarge/pngtree-dark-gray-simple-avatar-png-image_3418404.jpg" alt="Admin" class="rounded-circle"
                             width="150">
                        <div class="mt-3">
                            <h4><?php echo $patient['name'] ?></h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between" style="padding-top: 193px">
                        <button id="btnChangePassword" type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                            <span class="mdi mdi-lock mr-1"></span>Đổi mật khẩu
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 row">
                            <div class="col-4">
                                <label for="" class="form-label">Họ và tên</label>
                                <input id="paName" type="text" class="form-control" maxlength="255"
                                       value="<?php echo $patient['name'] ?>"
                                       disabled>
                                <span id="error-paName" style="color: red; margin-left: 10px"></span>
                            </div>
                            <div class="col-4">
                                <label for="paGender" class="form-label">Giới tính</label>
                                <select id="paGender" class="form-select mb-3" aria-label="Large select example"
                                        disabled>
                                    <option value="1" <?php echo $patient['gender'] == 0 ? '' : 'selected' ?> >Nam
                                    </option>
                                    <option value="0" <?php echo $patient['gender'] == 1 ? '' : 'selected' ?> >Nữ
                                    </option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="paDob"
                                       placeholder="" value="<?php echo $patient['dob'] ?>"
                                       disabled>
                                <span id="error-paDob" style="color: red; margin-left: 10px"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label for="paEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="paEmail" maxlength="150"
                                   value="<?php echo $patient['email'] ?? '' ?>" disabled>
                            <span id="error-paEmail" style="color: red; margin-left: 10px"></span>
                        </div>
                        <div class="col-6">
                            <label for="paPhone" class="form-label">Số điện thoại</label>
                            <div type="text" class="form-control" style="background-color: var(--bs-secondary-bg)"
                            ><?php echo $patient['phone'] ?? '' ?></div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label for="" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="paAddress" maxlength="255"
                                   value="<?php echo $patient['address'] ?? '' ?>" disabled>
                            <span id="error-paAddress" style="color: red; margin-left: 10px"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-between">
                            <button id="enableUpdate" style="background-color:#D25B33 !important; color: white"
                                    class="btn">Chỉnh sửa
                            </button>
                            <button id="updatePatient" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                    style="background-color:#3fbbc0 !important; color: white; display: none"
                                    class="btn">Cập nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="staticBackdropUpdate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="staticBackdropLabel">Thông báo</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có cập nhật thông tin không ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="confirmUpdate">Cập nhật</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="exampleModalLabel">Thay đổi mật khẩu</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="form-group mb-3">
                        <label for="currentPassword">Mật khẩu hiện tại</label>
                        <input type="password" class="form-control" id="currentPassword" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="newPassword">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Xác nhận mật khẩu mới</label>
                        <input type="password" class="form-control" id="confirmNewPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button id="btnSaveChange" type="button" class="btn btn-primary">Thay đổi</button>
            </div>
        </div>
    </div>
</div>
<?php include "component_cent/footer.php"; ?>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loading-spinner').style.display = 'none';

        var confirmUpdateButton = document.getElementById('confirmUpdate');
        var editButton = document.getElementById('enableUpdate');
        var updateButton = document.getElementById('updatePatient');
        var genderSelect = document.getElementById('paGender');
        var inputs = document.querySelectorAll('.card-body input');

        var nameInput = document.getElementById('paName');
        var dobInput = document.getElementById('paDob');
        var emailInput = document.getElementById('paEmail');
        var addressInput = document.getElementById('paAddress');
        var genderInput = document.getElementById('paGender')

        var staticBackdropUpdate = new bootstrap.Modal(document.getElementById('staticBackdropUpdate'));
        var modalChangePassword = new bootstrap.Modal(document.getElementById('modalChangePassword'));

        updateButton.addEventListener('click', function () {
            var valid = true;

            // Kiểm tra tên
            if (nameInput.value.trim() === '') {
                $('#error-paName').text('Tên không được để trống');
                nameInput.style.borderColor = 'red';
                valid = false;
            } else {
                $('#error-paName').text('');
                nameInput.style.borderColor = '';
            }

            // Kiểm tra ngày sinh
            var dob = new Date(dobInput.value);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            if (dobInput.value.trim() === '' || age < 10 || age > 90) {
                $('#error-paDob').text('Ngày sinh không hợp lệ');
                dobInput.style.borderColor = 'red';
                valid = false;
            } else {
                $('#error-paDob').text('');
                dobInput.style.borderColor = '';
            }

            // Kiểm tra email
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '' || !emailRegex.test(emailInput.value)) {
                $('#error-paEmail').text('Email không hợp lệ');
                emailInput.style.borderColor = 'red';
                valid = false;
            } else {
                $('#error-paEmail').text('');
                emailInput.style.borderColor = '';
            }

            // Nếu tất cả thông tin hợp lệ, có thể gửi dữ liệu
            if (valid) {
                staticBackdropUpdate.show()
            }

        });

        confirmUpdateButton.addEventListener('click', function () {
            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=customer&action=update_information',
                type: 'POST',
                data: {
                    name: nameInput.value,
                    gender: parseInt(genderInput.value, 10),
                    dob: dobInput.value,
                    email: emailInput.value,
                    address: addressInput.value,
                },
                success: function (response) {
                    console.log(response);
                    if (response === true) {
                        success_toast('Cập nhật thành công', '<?php echo BASE_URL ?>/index.php?controller=customer&action=profile')
                    } else {
                        failed_toast('Cập nhật thất bại')
                        document.getElementById('loading-spinner').style.display = 'none';
                    }
                },
                error: function () {
                    failed_toast('Đã có lỗi xảy ra')
                    document.getElementById('loading-spinner').style.display = 'none';
                }
            });
        })

        document.getElementById('btnChangePassword').addEventListener('click', function () {
            modalChangePassword.show()
        })

        document.getElementById('btnSaveChange').addEventListener('click', function (){
            var currentPassword = document.getElementById('currentPassword');
            var newPassword = document.getElementById('newPassword');
            var confirmNewPassword = document.getElementById('confirmNewPassword');

            // Xóa các lỗi trước đó
            $('.error').removeClass('error');
            $('.error-message').remove();

            // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp nhau không
            if (newPassword.value !== confirmNewPassword.value) {
                newPassword.classList.add('error');
                confirmNewPassword.classList.add('error');
                $(confirmNewPassword).after('<div class="error-message">Mật khẩu mới và xác nhận mật khẩu không khớp.</div>');
                return;
            }

            // Kiểm tra độ phức tạp của mật khẩu mới
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            if (!passwordRegex.test(newPassword.value)) {
                newPassword.classList.add('error');
                $(newPassword).after('<div class="error-message">Mật khẩu phải có ít nhất 8 kí tự, bao gồm chữ hoa, chữ thường và số.</div>');
                return;
            }

            var formData = new FormData();
            formData.append('currentPassword', currentPassword.value);
            formData.append('newPassword', newPassword.value);

            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=auth&action=processChangePasswordClient',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response['success'] === true) {
                        console.log(response);
                        success_toast('Đổi mật khẩu thành công', '<?php echo BASE_URL ?>/index.php?controller=customer&action=profile');
                    } else {
                        failed_toast(response['message']);
                        if (response['message'] === 'Mật khẩu hiện tại không đúng') {
                            currentPassword.classList.add('error');
                            $(currentPassword).after('<div style="color: red; font-size: 13px"  class="error-message">' + response['message'] + '</div>');
                        }
                        $("#loading-spinner").hide();
                    }
                },
                error: function (error) {
                    console.log(error);
                    failed_toast('Có lỗi xảy ra');
                    $("#loading-spinner").hide();
                }
            });
        });

        editButton.addEventListener('click', function () {
            updateButton.style.display = 'block';

            inputs.forEach(function (input) {
                input.disabled = false;
            });

            genderSelect.disabled = false;
            nameInput.focus();
        });
    });
</script>
<script>
    function success_toast(message, redirectUrl) {
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
                });
            }
        }, 100); // Đợi 100ms để đảm bảo toast đã được thêm vào DOM
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
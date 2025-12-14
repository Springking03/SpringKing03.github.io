<?php
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
    <title>Chi tiết chuyên gia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php'?>
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"-->
<!--          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
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
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết tài khoản</h2>
        </div>
        <div class="main-content container-fluid" style="margin-top: -50px !important;">
            <div class=" rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <div class="picture">
                                <img src="<?php echo $employee['avt'] ?>" width="150px" height="150px"
                                     class="picture-src" id="docUpAvt" title="">
                            </div>
                            <span class="font-weight-bold mt-2"><?php echo $employee['name'] ?></span>
                            <span class="text-black-50"><?php echo $employee['email'] ?></span>
                        </div>
                    </div>
                    <div class="col-md-5 border-right">
                        <div class="p-3 py-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">Thông tin cá nhân</h4>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 pr-0">
                                    <label class="labels">Họ và tên</label>
                                    <input id="docUpName" type="text" class="form-control" placeholder="Nhập họ và tên"
                                           value="<?php echo $employee['name'] ?>" disabled>
                                    <span id="errorDocName" style="color: red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Mã nhân viên</label>
                                    <div type="text" class="form-control"
                                         style="line-height: 30px; background-color: #eee">
                                        <?php echo $employee['employee_code'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 pr-0">
                                    <label for="docUpGender" class="form-label">Giới tính</label>
                                    <select id="docUpGender" class="form-select mb-3" aria-label="Large select example" style="height: 50px" disabled>
                                        <option value="1" <?php echo ($employee['gender'] == 1) ? 'selected' : ''; ?>>Nam</option>
                                        <option value="0" <?php echo ($employee['gender'] == 0) ? 'selected' : ''; ?>>Nữ</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Ngày sinh</label>
                                    <input id="docUpDob" type="date" class="form-control"
                                           value="<?php echo $employee['dob'] ?>" disabled>
                                    <span id="errorDocDob" style="color: red"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 pr-0">
                                    <label class="labels">Email</label>
                                    <input id="docUpEmail" type="text" class="form-control" placeholder="Nhập email"
                                           value="<?php echo $employee['email'] ?>" disabled>
                                    <span id="errorDocEmail" style="color: red"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="labels">Số điện thoại</label>
                                    <input id="docUpPhone" type="text" class="form-control"
                                           value="<?php echo $employee['phone'] ?>" disabled placeholder="Nhập số điện thoại">
                                    <span id="errorDocPhone" style="color: red"></span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="labels">Địa chỉ</label>
                                <input id="docUpAddress" type="text" class="form-control" placeholder="Nhập địa chỉ"
                                       value="<?php echo $employee['address'] ?>" disabled>
                                <span id="errorDocAddress" style="color: red"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Thông tin làm việc</h4>
                        </div>
                        <div class="col-md-12">
                            <label class="labels">Chức vụ</label>
                            <div id="docUpPosition" class="form-control"
                                 style="height: 50px; background-color: #eee; line-height: 30px; font-size: 13px">
                                <?php echo $employee['position_name'] ?>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <label class="labels">Dịch vụ</label>
                            <div id="docUpPosition" class="form-control"
                                 style="height: 50px; background-color: #eee; line-height: 30px; font-size: 13px">
                                <?php echo $employee['specialty_name'] ?? " không có" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between p-3">
                    <button id="btnChangePassword" type="button" class="btn btn-danger" data-toggle="modal" data-target="#changePasswordModal">
                        <span class="mdi mdi-lock mr-1"></span>Đổi mật khẩu
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thay đổi mật khẩu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm">
                        <div class="form-group">
                            <label for="currentPassword">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword" required>
                        </div>
                        <div class="form-group">
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
</div>

<?php include 'import-script.php'?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        App.init();
        document.getElementById('loading-spinner').style.display = 'none';
        var changePasswordModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));

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
                url: '<?php echo BASE_URL ?>/index.php?controller=auth&action=processChangePasswordAdmin',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response['success'] === true) {
                        console.log(response);
                        success_toast('<?php echo BASE_URL ?>/index.php?controller=employee&action=profile');
                    } else {
                        failed_toast(response['message']);
                        if (response['message'] === 'Mật khẩu hiện tại không đúng') {
                            currentPassword.classList.add('error');
                            $(currentPassword).after('<div class="error-message">' + response['message'] + '</div>');
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
    });
</script>
<script>
    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
          <div class="d-flex w-100" data-bs-theme="dark">
            <div class="flex-grow-1">
              Thay đổi mật khẩu thành công
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
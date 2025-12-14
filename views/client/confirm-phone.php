<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt mật khẩu mới</title>
    <link href="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="assetsv2/css/vidental.css" rel="stylesheet">
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

<?php include "components/header.php" ?>
<div id="loading-spinner"
     style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 900; display: flex; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<main class="container p-0" style="margin-top: 150px!important; margin-bottom: 150px;width: 40%">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Xác minh email</h1>
        </div>
        <div class="modal-body">
            <form id="verifyPhoneForm">
                <div class="mb-3">
                    <label for="phone" class="col-form-label">Vui lòng nhập email liên kết với tài khoản của bạn:</label>
                    <input type="mail" class="form-control" id="phoneNumber">
                </div>
                <div class="mb-3">
                    <label for="op" class="col-form-label">Nhập mã xác minh gồm 6 số:</label>
                    <input type="number" class="form-control" id="otp">
                </div>
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button id="sendCode" type="button" class="btn btn-primary">
                Gửi mã xác minh
            </button>
        </div>
    </div>
    <div class="modal-content" style="display: none;" id="changePasswordSection">
        <div class="modal-header">
            <h5 class="modal-title" id="changePasswordModalLabel">Đổi Mật Khẩu</h5>
        </div>
        <div class="modal-body">
            <form id="changePasswordForm">
                <div class="form-group">
                    <label for="newPassword">Mật khẩu mới:</label>
                    <input type="password" class="form-control" id="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirmNewPassword">Xác nhận mật khẩu mới:</label>
                    <input type="password" class="form-control" id="confirmNewPassword" required>
                </div>
                <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
            </form>
        </div>
    </div>
</main>
<?php include "component_cent/footer.php" ?>

<script src="<?php echo BASE_URL ?>/views/admin/assets/lib\jquery\jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#loading-spinner').hide();
        var sendCode = document.getElementById('sendCode');
        sendCode.disabled = true;
        var phoneNumber = document.getElementById('phoneNumber');

        phoneNumber.addEventListener('change', function (){
            phoneNumber.style.borderColor = ''
            // Xóa các lỗi trước đó
            $('.error').removeClass('error');
            $('.error-message').remove();
            if (!phoneNumber.value) {
                phoneNumber.classList.add('error');
                $(phoneNumber).after('<div class="error-message">Trường này không được để trống.</div>');
                sendCode.disabled = true
            } else if (!/^\d{10}$/.test(phoneNumber.value)) {
                phoneNumber.classList.add('error');
                $(phoneNumber).after('<div class="error-message">Số điện thoại không hợp lệ.</div>');
                sendCode.disabled = true
            } else {
                sendCode.disabled = false
            }
        });

        sendCode.addEventListener('click', function () {
            $('#loading-spinner').show();
            var OTP = 123456;
            var otpInput = document.getElementById('otp');
            var otpreq = parseInt(otpInput?.value, 10);

            phoneNumber.style.borderColor = '';

            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=customer&action=check_phone',
                type: 'POST',
                data: {
                    phone: phoneNumber.value
                },
                success: function(response) {
                    if (response) {
                        if (otpreq === OTP) {
                            $('.modal-content').hide();
                            $('#changePasswordSection').show();
                            $('#loading-spinner').hide();
                        } else {
                            otpInput.value = ''; // Xóa nội dung của ô nhập
                            otpInput.style.borderColor = 'red'; // Thêm border màu đỏ
                            otpInput.focus(); // Đặt focus lại vào ô nhập để người dùng có thể nhập lại
                            failed_toast('Mã OTP không đúng')
                            $('#loading-spinner').hide();
                        }
                    } else {
                        phoneNumber.style.borderColor = 'red';
                        failed_toast('Số điện thoại không tồn tại hoặc không hợp lệ.');
                        $('#loading-spinner').hide();
                    }
                },
                error: function() {
                    failed_toast('Có lỗi xảy ra, vui lòng thử lại.');
                    $('#loading-spinner').hide();
                }
            });
        });

        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

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
            formData.append('phone', phoneNumber.value);
            formData.append('newPassword', newPassword.value);

            $('#loading-spinner').show();
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=auth&action=process_forgot_password',
                type: 'POST',
                data: formData,
                processData: false,  // Không xử lý dữ liệu
                contentType: false,  // Không đặt contentType
                success: function (response) {
                    console.log(response);
                    $('#loading-spinner').hide();
                    if(response.success) {
                        success_toast(response.message, '<?php echo BASE_URL ?>/index.php?controller=home&action=login');
                    } else {
                        failed_toast(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error: " + error);
                    console.log("Status: " + status);
                    console.log("Response: ", xhr.responseText);
                    failed_toast('Có lỗi xảy ra: ' + error);
                    $('#loading-spinner').hide();
                }
            });
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
            delay: 1000
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
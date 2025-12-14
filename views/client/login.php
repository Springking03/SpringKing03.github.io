<?php
if (isset($_SESSION['user_phone'])) {
    header("Location: " . HOME_CLIENT_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Đăng nhập | Vidental</title>

    <link href="http://localhost/Vidental/assetsv2/img/logo.jpg" rel="icon">
    <link href="assetsv2/img/logo.svg" rel="apple-touch-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="assetsv2/css/vidental.css" rel="stylesheet">

    <style>
        /* Giữ spinner (nếu bạn đang dùng) */
        #loading-spinner{
            text-align:center;line-height:700px;position:absolute;top:0;left:0;right:0;bottom:0;
            background:rgba(255,255,255,.75);z-index:9999;display:none;
            align-items:center;justify-content:center;
        }
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
        }
    </style>
</head>
<body>

<div id="loading-spinner">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<section class="vd-auth">
    <div class="container vd-auth__wrap">
        <div class="row g-4 align-items-stretch">
            <!-- Left Panel -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__panel">
                    <div class="vd-auth__brand">
                        <img src="http://localhost/Vidental/assetsv2/img/logo.svg" alt="Vidental">
                        <div>
                            <h2>Vidental Dental Clinic</h2>
                            <div class="vd-auth__tagline">Nơi nụ cười Việt được chăm sóc chuẩn quốc tế</div>
                        </div>
                    </div>

                    <p class="vd-auth__tagline">
                        Đặt lịch nhanh – chọn dịch vụ – chọn bác sĩ – nhận xác nhận qua email.
                        Trải nghiệm nha khoa nhẹ nhàng, minh bạch và chuyên nghiệp.
                    </p>

                    <ul class="vd-auth__list">
                        <li>Khám tổng quát & tư vấn phác đồ</li>
                        <li>Cạo vôi – đánh bóng – chăm sóc nướu</li>
                        <li>Trám răng thẩm mỹ – điều trị sâu răng</li>
                        <li>Tư vấn chỉnh nha – tối ưu nụ cười</li>
                    </ul>
                </div>
            </div>

            <!-- Right Card -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__card">
                    <h1 class="vd-auth__title">Đăng nhập</h1>
                    <p class="vd-auth__sub">
                        Chào mừng bạn quay lại Vidental. Vui lòng nhập thông tin để tiếp tục.
                    </p>
                    <p>
                                        Bạn không có tài khoản?
                                        <a href="<?php echo REGISTER_URL ?>"> Đăng kí</a>
                                    </p>

                    <form method="post" onsubmit="return false;">
                        <div class="row gy-3 overflow-hidden">
                            <div class="col-12">
                                <div class="form-floating mb-2">
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                           placeholder="Số điện thoại" required>
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating mb-2 position-relative">
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="Mật khẩu" required>
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button id="loginButton" class="vd-auth__btn" type="submit">Đăng nhập</button>
                            </div>
                        </div>
                    </form>

                    <div class="vd-auth__divider"></div>

                    <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-3">
                                    <a href="<?php echo FORGOT_URL ?>">Quên mật khẩu</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <a href="<?php echo LOGIN_ADMIN_URL ?>"
                                   style="color: #D25B33; margin-right: 10px">Đăng nhập quản trị
                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        ="fill: #652915;transform: ;msFilter:;">
                                            <path d="m13.061 4.939-2.122 2.122L15.879 12l-4.94 4.939 2.122 2.122L20.121 12z"></path>
                                            <path d="M6.061 19.061 13.121 12l-7.06-7.061-2.122 2.122L8.879 12l-4.94 4.939z"></path>
                                        </svg>
                                </a>

                            </div>
                        </div>
                        <div class="vd-auth__divider"></div>

          <p class="mb-0" style="color: var(--vd-muted);">
            Quay lại trang chủ?
            <a class="vd-auth__link" href="index.php?controller=home&action=home">Về trang chủ</a>
          </p>

                    <div id="toast" class="toast">Thông báo ở đây!</div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    // Toggle password
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput  = document.getElementById('password');
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('loading-spinner').style.display = 'none';

        var inputs = document.querySelectorAll('.form-control');
        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                var errorMessage = input.parentElement.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
                input.classList.remove('invalid-input');
            });
        });

        document.getElementById('loginButton').addEventListener('click', validateAndSubmit);

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });

    function validateAndSubmit() {
        var isValid = true;
        var formData = new FormData();

        var inputs = document.querySelectorAll('.form-control');
        document.querySelectorAll('.error-message').forEach(function (msg) {
            msg.remove();
        });

        inputs.forEach(function (input) {
            var error = null;
            if (!input.value.trim()) {
                error = 'Trường này không được để trống';
            } else if (input.name === 'phone' && !/^\d{10}$/.test(input.value)) {
                error = 'Số điện thoại phải là 10 chữ số';
            }

            if (error) {
                var errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                errorMessage.textContent = error;
                input.classList.add('invalid-input');
                input.parentElement.appendChild(errorMessage);
                isValid = false;
            } else {
                formData.append(input.name, input.value);
                input.classList.remove('invalid-input');
            }
        });

        if (isValid) {
            document.getElementById('loading-spinner').style.display = 'flex';

            $.ajax({
                url: '<?php echo PROCESS_LOGIN_CLIENT_URL ?>',  // Đã an toàn vì dùng nháy đơn PHP
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success === true) {
                        success_toast('<?php echo HOME_CLIENT_URL ?>');
                    } else {
                        failed_toast(response.message || 'Đăng nhập thất bại');
                        document.getElementById('phone').classList.add('invalid-input');
                        document.getElementById('password').classList.add('invalid-input');

                        var errorMessage = document.createElement('div');
                        errorMessage.classList.add('error-message');
                        errorMessage.textContent = response.message || 'Thông tin không chính xác';
                        document.getElementById('password').parentElement.appendChild(errorMessage);
                    }
                    document.getElementById('loading-spinner').style.display = 'none';
                },
                error: function() {
                    failed_toast('Lỗi kết nối, vui lòng thử lại');
                    document.getElementById('loading-spinner').style.display = 'none';
                }
            });
        }
    }

    function success_toast(redirectUrl) {
        toast({
            classes: 'text-bg-success border-0',
            body: `
                <div class="d-flex w-100" data-bs-theme="dark">
                    <div class="flex-grow-1">
                        Đăng nhập thành công!
                    </div>
                    <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`,
            autohide: true,
            delay: 1500
        });

        setTimeout(function() {
            window.location.href = redirectUrl;
        }, 1600);
    }

    function failed_toast(message) {
        toast({
            classes: 'text-bg-danger border-0',
            body: `
                <div class="d-flex w-100" data-bs-theme="dark">
                    <div class="flex-grow-1">
                        ${message}
                    </div>
                    <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`,
            autohide: true,
            delay: 3000
        });
    }
</script>


</body>
</html>


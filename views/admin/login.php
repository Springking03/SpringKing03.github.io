<?php
// Nhớ đảm bảo session_start() đã được gọi ở file bootstrap/config chung
if (isset($_SESSION['admin_name'])) {
    header('Location: ' . HOME_ADMIN_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Đăng nhập quản trị | Vidental</title>

    <link href="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">

    <!-- Nếu bạn không cần css của bs-brain thì có thể bỏ; để lại cũng không sao -->
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css">

    <link href="assets/vendor/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="assetsv2/css/vidental.css" rel="stylesheet">

    <style>
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.82rem;
            margin-top: 6px;
        }

        .invalid-input {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 .15rem rgba(220,38,38,.12);
        }


        /* spinner overlay */
        #loading-spinner{
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,.75);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>

<!-- Spinner (bắt buộc để JS không lỗi) -->
<div id="loading-spinner">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>

<section class="vd-auth vd-auth--admin">
    <div class="container vd-auth__wrap">
        <div class="row g-4 align-items-stretch">

            <!-- Left Panel -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__panel">
                    <div class="vd-auth__brand">
                        <img src="assetsv2/img/logo.svg" alt="Vidental">
                        <div>
                            <h2>Vidental Admin</h2>
                            <div class="vd-auth__tagline">Khu vực quản trị hệ thống</div>
                        </div>
                    </div>

                    <p class="vd-auth__tagline">
                        Đăng nhập để quản lý lịch hẹn, dịch vụ, bác sĩ và tài khoản người dùng.
                    </p>

                    <ul class="vd-auth__list">
                        <li>Quản lý dịch vụ & bác sĩ</li>
                        <li>Duyệt / theo dõi lịch hẹn</li>
                        <li>Quản trị tài khoản & phân quyền</li>
                        <li>Báo cáo tổng quan</li>
                    </ul>
                </div>
            </div>

            <!-- Right Card -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__card">
                    <h1 class="vd-auth__title">Đăng nhập quản trị</h1>
                    <p class="vd-auth__sub">Vui lòng nhập thông tin để truy cập trang admin.</p>

                    <!-- FORM: bỏ onsubmit return false, thay bằng bắt submit JS -->
                    <form id="adminLoginForm" method="post" autocomplete="on">
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
                                    <i class="fas fa-eye password-toggle" id="togglePassword" aria-hidden="true"></i>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button id="loginButton" class="vd-auth__btn" type="submit">Đăng nhập</button>
                            </div>

                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-2">
                                    <a class="vd-auth__link" href="<?php echo FORGOT_URL ?>">Quên mật khẩu</a>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <a class="vd-auth__link" href="<?php echo LOGIN_CLIENT_URL ?>">
                                    Đăng nhập người dùng
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                        <path d="m13.061 4.939-2.122 2.122L15.879 12l-4.94 4.939 2.122 2.122L20.121 12z"></path>
                                        <path d="M6.061 19.061 13.121 12l-7.06-7.061-2.122 2.122L8.879 12l-4.94 4.939z"></path>
                                    </svg>
                                </a>
                            </div>

                            <?php if (!empty($error ?? '')): ?>
                                <div class="col-12">
                                    <div class="error-message"><?= htmlspecialchars($error) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>

                    <div class="vd-auth__divider"></div>

                    <p class="mb-0" style="color: var(--vd-muted);">
                        Quay lại trang khách hàng?
                        <a class="vd-auth__link" href="index.php?controller=home&action=home">Về trang chủ</a>
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- toaster + functions nếu bạn đang dùng -->
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script src="<?php echo BASE_URL ?>/views/admin/assets/js/functions.js"></script>

<script>
    // Toggle password (chỉ gắn 1 lần)
    (function () {
        const t = document.getElementById('togglePassword');
        const p = document.getElementById('password');
        if (t && p) {
            t.addEventListener('click', function () {
                const type = p.getAttribute('type') === 'password' ? 'text' : 'password';
                p.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
    })();

    document.addEventListener('DOMContentLoaded', function () {
        const spinner = document.getElementById('loading-spinner');
        if (spinner) spinner.style.display = 'none';

        // Clear errors on typing
        document.querySelectorAll('.form-control').forEach(function (input) {
            input.addEventListener('input', function () {
                const err = input.parentElement.querySelector('.error-message');
                if (err) err.remove();
                input.classList.remove('invalid-input');
            });
        });

        // Submit handler (bấm Enter cũng chạy)
        const form = document.getElementById('adminLoginForm');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            validateAndSubmit();
        });
    });

    function validateAndSubmit() {
        let isValid = true;
        const formData = new FormData();
        const inputs = document.querySelectorAll('.form-control');

        document.querySelectorAll('.error-message').forEach(m => m.remove());

        inputs.forEach(function (input) {
            let error = null;

            if (!input.value) error = 'Trường này không được để trống';
            else if (input.name === 'phone' && !/^\d{10}$/.test(input.value)) error = 'Số điện thoại phải là 10 chữ số';

            if (error) {
                const errorMessage = document.createElement('div');
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

        if (!isValid) return;

        const spinner = document.getElementById('loading-spinner');
        if (spinner) spinner.style.display = 'flex';

        $.ajax({
            url: '<?php echo BASE_URL ?>/index.php?controller=auth&action=processLoginAdmin',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // ép parse JSON
            success: function (response) {
                console.log('AJAX response:', response);

                if (response && response.success === true) {
                    success_toast('<?php echo BASE_URL ?>/index.php?controller=home&action=home_admin');
                } else {
                    failed_toast(response?.message || 'Đăng nhập thất bại');
                }
            },
            error: function (xhr) {
                console.log('AJAX error:', xhr.responseText);
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            },
            complete: function () {
                if (spinner) spinner.style.display = 'none';
            }
        });
    }

    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">Đăng nhập thành công !</div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
            autohide: true,
            delay: 2000
        });

        setTimeout(() => {
            const toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.href = redirectUrl;
                });
            } else {
                // fallback nếu toast lib render khác
                setTimeout(() => window.location.href = redirectUrl, 1200);
            }
        }, 120);
    }

    function failed_toast(message) {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
              <div class="d-flex w-100" data-bs-theme="dark">
                <div class="flex-grow-1">${message}</div>
                <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>`,
        });
    }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Đăng ký | Vidental</title>

    <link href="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
    </style>
</head>
<body>

<section class="vd-auth">
    <div class="container vd-auth__wrap">
        <div class="row g-4 align-items-stretch">
            <!-- Left Panel -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__panel">
                    <div class="vd-auth__brand">
                        <img src="<?php echo BASE_URL; ?>/assetsv2/img/logo.svg" alt="Vidental">
                        <div>
                            <h2>Tạo tài khoản Vidental</h2>
                            <div class="vd-auth__tagline">Đặt lịch dễ dàng – theo dõi lịch hẹn – nhận nhắc hẹn</div>
                        </div>
                    </div>

                    <p class="vd-auth__tagline">
                        Chỉ mất 1 phút để đăng ký. Sau đó bạn có thể chọn dịch vụ, chọn bác sĩ và thời gian phù hợp.
                    </p>

                    <ul class="vd-auth__list">
                        <li>Quản lý lịch hẹn tập trung</li>
                        <li>Nhận xác nhận và thông báo qua email</li>
                        <li>Thông tin minh bạch – hỗ trợ nhanh</li>
                    </ul>
                </div>
            </div>

            <!-- Right Card -->
            <div class="col-12 col-lg-6">
                <div class="vd-auth__card">
                    <h1 class="vd-auth__title">Đăng ký</h1>
                    <p class="vd-auth__sub">Điền thông tin bên dưới để tạo tài khoản khách hàng.</p>

                    <form method="post" onsubmit="return false;">
                        <div class="row gy-3 overflow-hidden">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" maxlength="255" required>
                                    <label for="name" class="form-label">Họ và tên</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="phone" id="phone" maxlength="10" placeholder="xxxx xxx xxx" required>
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" maxlength="255" required>
                                    <label for="email" class="form-label">Email</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Mật khẩu" required>
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <i class="fas fa-eye password-toggle" id="togglePasswordRe"></i>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating position-relative">
                                    <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Xác nhận mật khẩu" required>
                                    <label for="re-password" class="form-label">Xác nhận mật khẩu</label>
                                    <i class="fas fa-eye password-toggle" id="togglePasswordReCon"></i>
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <button class="vd-auth__btn" type="button" id="registerButton">Đăng ký</button>
                                <div id="response"></div>
                            </div>
                        </div>
                    </form>

                    <div class="vd-auth__divider"></div>

                    <p class="mb-0" style="color: var(--vd-muted);">
                        Đã có tài khoản?
                         <a href="<?php echo LOGIN_CLIENT_URL ?>">Đăng nhập</a>
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
    // Hàm toggle password (giữ lại và dùng duy nhất)
    function bindToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        if (!toggle || !input) return;

        toggle.addEventListener('click', function () {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }

    // Hàm validate và submit
    function validateAndSubmit() {
        const spinner = document.getElementById('loading-spinner');

        let isValid = true;
        const formData = new FormData();
        const inputs = document.querySelectorAll('.form-control');

        // Xóa thông báo lỗi cũ
        document.querySelectorAll('.error-message').forEach(el => el.remove());
        inputs.forEach(input => input.classList.remove('invalid-input'));

        inputs.forEach(function(input) {
            let error = null;

            if (!input.value.trim()) {
                error = 'Trường này không được để trống';
            } else if (input.name === 'phone' && !/^\d{10}$/.test(input.value)) {
                error = 'Số điện thoại phải là 10 chữ số';
            } else if (input.name === 'password') {
                if (input.value.length < 8) error = 'Mật khẩu phải có ít nhất 8 ký tự';
                else if (!/[A-Z]/.test(input.value)) error = 'Mật khẩu phải có ít nhất một chữ cái in hoa';
                else if (!/[a-z]/.test(input.value)) error = 'Mật khẩu phải có ít nhất một chữ cái thường';
                else if (!/[0-9]/.test(input.value)) error = 'Mật khẩu phải có ít nhất một chữ số';
            } else if (input.name === 're-password' && input.value !== document.getElementById('password').value) {
                error = 'Mật khẩu xác nhận không khớp';
            }

            if (error) {
                const errorMessage = document.createElement('div');
                errorMessage.className = 'error-message text-danger mt-1';
                errorMessage.textContent = error;
                input.classList.add('invalid-input');
                input.parentElement.appendChild(errorMessage);
                isValid = false;
            } else {
                formData.append(input.name, input.value);
            }
        });

        if (isValid) {
            if (spinner) spinner.style.display = 'block';

            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=auth&action=processRegister',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Response:', response);

                    if (spinner) spinner.style.display = 'none';

                    if (response.success === true) {
                        success_toast('<?php echo LOGIN_CLIENT_URL ?>');
                    } else {
                        let msg = response.message || 'Đã có lỗi xảy ra, vui lòng thử lại sau';
                        if (msg === 'Số điện thoại đã được đăng ký') {
                            const phoneInput = document.getElementById('phone');
                            phoneInput.classList.add('invalid-input');
                            const errEl = document.createElement('div');
                            errEl.className = 'error-message text-danger mt-1';
                            errEl.textContent = msg;
                            phoneInput.parentElement.appendChild(errEl);
                        }
                        failed_toast(msg);
                    }
                },
                error: function(xhr, status, err) {
                    if (spinner) spinner.style.display = 'none';
                    console.error('AJAX Error:', status, err);
                    console.error('Response Text:', xhr.responseText);
                    failed_toast('Có lỗi kết nối, vui lòng thử lại.');
                }
            });
        }
    }

    // Toast functions
    function success_toast(redirectUrl) {
        toast({
            classes: `text-bg-success border-0`,
            body: `
                <div class="d-flex w-100" data-bs-theme="dark">
                    <div class="flex-grow-1">Đăng ký thành công!</div>
                    <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`,
            autohide: true,
            delay: 1000
        });

        setTimeout(() => {
            const toastEl = document.querySelector('.toast.show');
            if (toastEl) {
                toastEl.addEventListener('hidden.bs.toast', () => {
                    window.location.href = redirectUrl;
                });
            }
        }, 100);
    }

    function failed_toast(message) {
        toast({
            classes: `text-bg-danger border-0`,
            body: `
                <div class="d-flex w-100" data-bs-theme="dark">
                    <div class="flex-grow-1">${message}</div>
                    <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`,
            autohide: true,
            delay: 3000
        });
    }

    // Khởi chạy khi DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        // Bind toggle password (chỉ 1 lần)
        bindToggle('togglePasswordRe', 'password');
        bindToggle('togglePasswordReCon', 're-password');

        // Bind nút đăng ký
        const registerButton = document.getElementById('registerButton');
        if (registerButton) {
            registerButton.addEventListener('click', function (e) {
                e.preventDefault();
                validateAndSubmit();
            });
        }
    });
</script>

</body>
</html>
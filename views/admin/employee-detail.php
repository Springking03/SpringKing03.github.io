<?php
session_start();
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
    <link href="<?php echo BASE_URL ?>/assetsv2/img/logo.svg" rel="icon">
    <title>Chi tiết nhân viên</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php'?>
    <?php include 'import_head.php' ?>

    <style>
        .picture {
            position: relative;
            width: 150px;
            height: 150px;
            background-color: #999999;
            border: 4px solid #CCCCCC;
            color: #FFFFFF;
            border-radius: 50%;
            margin: 0 auto;
            overflow: hidden;
            transition: all 0.2s;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none; /* Ẩn overlay khi chưa nhấn chỉnh sửa */
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: opacity 0.5s ease;
            z-index: 1; /* Đảm bảo overlay nằm dưới input file */
            pointer-events: none; /* Cho phép click qua overlay */
        }

        .picture input[type="file"] {
            cursor: pointer;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0; /* Giữ nguyên để input không hiển thị */
            z-index: 2; /* Đảm bảo input nằm trên các phần tử khác */
            pointer-events: none; /* Cho phép tương tác */
        }

        .picture.editable:hover {
            border-color: #2ca8ff; /* Màu viền khi hover */
        }

        .picture.editable:hover .overlay {
            display: flex; /* Hiển thị overlay khi hover */
            opacity: 1;
        }

        .fa-plus {
            color: white;
            font-size: 30px;
        }
    </style>
</head>
<body>
<div id="loading-spinner" style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1100; display: flex; align-items: center; justify-content: center;">
    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only" style="z-index: 1151">Loading...</span>
    </div>
</div>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết nhân viên</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý nhân viên</li>
                    <li class="breadcrumb-item active">Danh sách nhân viên</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -50px !important;">
            <div class=" rounded bg-white mt-5 mb-5">
                <div class="row">
                    <div class="col-md-3 border-right">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <div class="picture">
                                <img src="<?php echo $employee['avt'] ?>" width="150px" height="150px"
                                     class="picture-src" id="docUpAvt" title="">
                                <input type="file" id="wizard-picture" class="">
                                <div class="overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
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
                                <div class="col-md-7 pr-0">
                                    <label class="labels">Họ và tên</label>
                                    <input id="docUpName" type="text" class="form-control" placeholder="Nhập họ và tên"
                                           value="<?php echo $employee['name'] ?>" disabled>
                                    <span id="errorDocName" style="color: red"></span>
                                </div>
                                <div class="col-md-5">
                                    <label class="labels">Mã nhân viên</label>
                                    <div id="docUpUsername" type="text" class="form-control"
                                         style="line-height: 30px; background-color: #eee">
                                        <?php echo $employee['employee_code'] ?>
                                    </div>
                                    <span id="errorDocUsername" style="color: red"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-7 pr-0">
                                    <label class="labels">Ngày sinh</label>
                                    <input id="docUpDob" type="date" class="form-control"
                                           value="<?php echo $employee['dob'] ?>" disabled>
                                    <span id="errorDocDob" style="color: red"></span>
                                </div>
                                <div class="col-md-5">
                                    <label for="docUpGender" class="form-label">Giới tính</label>
                                    <select id="docUpGender" class="form-select mb-3" aria-label="Large select example"
                                            style="height: 50px" disabled>
                                        <option value="1" <?php echo ($employee['gender'] == 1) ? 'selected' : ''; ?>>
                                            Nam
                                        </option>
                                        <option value="0" <?php echo ($employee['gender'] == 0) ? 'selected' : ''; ?>>
                                            Nữ
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 pr-0">
                                    <label class="labels">Email</label>
                                    <input id="docUpEmail" type="text" class="form-control" placeholder="Nhập email"
                                           value="<?php echo $employee['email'] ?>" disabled>
                                    <span id="errorDocEmail" style="color: red"></span>
                                </div>
                                <div class="col-md-5">
                                    <label class="labels">Số điện thoại</label>
                                    <input id="docUpPhone" type="text" class="form-control"
                                           value="<?php echo $employee['phone'] ?>" disabled
                                           placeholder="Nhập số điện thoại">
                                    <span id="errorDocPhone" style="color: red"></span>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8 pr-0">
                                    <label class="labels">Địa chỉ</label>
                                    <input id="docUpAddress" type="text" class="form-control" placeholder="Nhập địa chỉ"
                                           value="<?php echo $employee['address'] ?>" disabled>
                                    <span id="errorDocAddress" style="color: red"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="labels">Trạng thái</label>
                                    <select id="docUpStatus" class="form-select mb-3" aria-label="Large select example"
                                            style="height: 50px" disabled>
                                        <option value="0" <?php echo ($employee['status'] == 0) ? 'selected' : ''; ?>>
                                            Đóng
                                        </option>
                                        <option value="1" <?php echo ($employee['status'] == 1) ? 'selected' : ''; ?>>
                                            Mở
                                        </option>
                                    </select>
                                </div>
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
                    </div>
                </div>
                <div class="d-flex justify-content-between p-3">
                    <a id="backButton" class="btn btn-danger"
                       href="<?php echo BASE_URL ?>/index.php?controller=employee&action=index">Quay lại danh
                        sách</a>
                    <button type="button" class="btn btn-primary" id="editButtonDoctor">
                        Chỉnh sửa
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1049!important;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn chắc chắn muốn cập nhật chứ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="saveUpdate">Lưu lại</button>
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


        $("#wizard-picture").change(function () {
            readURL(this);
        });

        var exampleModal = new bootstrap.Modal(document.getElementById('detailModal'));

        document.getElementById('editButtonDoctor').addEventListener('click', function () {
            var inputs = document.querySelectorAll('.form-control');
            var selects = document.querySelectorAll('.form-select');
            var fileInput = document.getElementById('wizard-picture');
            var overlay = document.querySelector('.overlay');
            var pictureDiv = document.querySelector('.picture');

            // Bỏ thuộc tính disabled để cho phép chỉnh sửa
            inputs.forEach(function (input) {
                input.disabled = false;
            });
            selects.forEach(function (select) {
                select.disabled = false;
            });

            // Kích hoạt input file và hiển thị overlay
            fileInput.style.pointerEvents = 'auto'; // Cho phép click vào input file
            overlay.style.display = 'flex'; // Hiển thị overlay
            pictureDiv.classList.add('editable'); // Thêm class để kích hoạt hover

            // Đổi tên nút từ "Chỉnh sửa" thành "Lưu lại"
            this.textContent = 'Cập nhật';

            // Thêm sự kiện click cho nút "Lưu lại" để xử lý lưu thông tin
            this.removeEventListener('click', arguments.callee);

            this.addEventListener('click', function () {
                if (validateDoctorInfo()) {
                    document.getElementById('docUpPhone').classList.remove('is-invalid');
                    exampleModal.show();
                }
            });


        });

        document.getElementById('saveUpdate').addEventListener('click', function () {
            exampleModal.hide();
            const formData = new FormData();

            formData.append('id', <?php echo $employee['id'] ?>);
            formData.append('name', document.getElementById('docUpName').value);
            formData.append('gender', parseInt(document.getElementById('docUpGender').value, 10));
            formData.append('dob', document.getElementById('docUpDob').value);
            formData.append('email', document.getElementById('docUpEmail').value);
            formData.append('phone', document.getElementById('docUpPhone').value);
            formData.append('address', document.getElementById('docUpAddress').value);
            formData.append('status', parseInt(document.getElementById('docUpStatus').value, 10));
            formData.append('avt', '<?php echo $employee['avt'] ?>');

            // Thêm file vào FormData nếu có
            const fileInput = document.getElementById('wizard-picture');
            if (fileInput.files.length > 0) {
                formData.append('avtUpdate', fileInput.files[0]);
            }
            // Log dữ liệu trong FormData
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));
            }

            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=employee&action=update',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response['success']){
                        success_toast('<?php echo BASE_URL ?>/index.php?controller=employee&action=index');
                    } else {
                        document.getElementById('errorDocPhone').textContent = 'Số điện thoại đã tồn tại.';
                        document.getElementById('docUpPhone').classList.add('is-invalid');
                        $("#loading-spinner").hide();
                    }
                },
                error: function () {
                    failed_toast()
                    $("#loading-spinner").hide()
                }
            });
        });

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#docUpAvt').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validateDoctorInfo() {
        let isValid = true;
        const name = document.getElementById('docUpName').value.trim();
        const dob = new Date(document.getElementById('docUpDob').value);
        const email = document.getElementById('docUpEmail').value.trim();
        const phone = document.getElementById('docUpPhone').value.trim();
        const address = document.getElementById('docUpAddress').value.trim();
        const fileInput = document.getElementById('wizard-picture');

        // Kiểm tra họ và tên
        if (!name || name.length > 50) {
            document.getElementById('errorDocName').textContent = 'Họ và tên không hợp lệ.';
            document.getElementById('docUpName').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('errorDocName').textContent = '';
        }

        // Kiểm tra ngày sinh
        const today = new Date();
        const minAge = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        if (!dob || dob >= minAge) {
            document.getElementById('errorDocDob').textContent = 'Ngày sinh không hợp lệ.'
            document.getElementById('docUpDob').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('errorDocDob').textContent = '';
        }

        // Kiểm tra email
        if (!email || email.length > 150) {
            document.getElementById('errorDocEmail').textContent = 'Vui lòng nhập email hợp lệ.';
            document.getElementById('docUpEmail').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('errorDocEmail').textContent = '';
        }

        // Kiểm tra số điện thoại
        const phoneRegex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        if (!phone || !phoneRegex.test(phone)) {
            document.getElementById('errorDocPhone').textContent = 'Số điện thoại không hợp lệ.';
            document.getElementById('docUpPhone').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('errorDocPhone').textContent = '';
        }

        // Kiểm tra địa chỉ
        if (!address || address.length > 255) {
            document.getElementById('errorDocAddress').textContent = 'Vui lòng nhập địa chỉ';
            document.getElementById('docUpAddress').classList.add('is-invalid');
            isValid = false;
        } else {
            document.getElementById('errorDocAddress').textContent = '';
        }

        return isValid;
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
<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
    exit();
} else if ($_SESSION['role_id'] == 2){   // Chỉ admin
    header('Location: '. UNAUTHORIZED_URL);
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
    <title>Chi tiết khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <?php include 'import_head.php' ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <style>
        /* Tùy chỉnh line-height cho nội dung toggle */
        .toggle-handle {
            line-height: 40px; /* Đặt line-height bằng với chiều cao của toggle */
        }

        /* Đảm bảo các icon và text được căn giữa */
        .toggle-on, .toggle-off {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<div id="loading-spinner" style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1051; display: flex; align-items: center; justify-content: center;">
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
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết khách hàng</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý khách hàng</li>
                    <li class="breadcrumb-item active">Danh sách khách hàng</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -30px ">
            <div class="row">
                <div class="col-12">
                    <div class="row card card-table pt-1 pb-3">
                        <div class="row p-3">
                            <div class="col-6">
                                <h4>
                                    <strong>Thông tin cá nhân</strong>
                                    <hr>
                                </h4>
                                <div class="mb-3 row">
                                    <div class="col-4">
                                        <label for="" class="form-label">Tên khách hàng</label>
                                        <input type="text" class="form-control" value="<?php echo $patient['name'] ?>"
                                               disabled>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Giới tính</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $patient['name'] == 0 ? 'Nữ' : 'Nam' ?>" disabled>
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Ngày sinh</label>
                                        <input type="text" class="form-control" id="specialtyName"
                                               placeholder="Nhập tên dịch vụ" value="<?php echo $patient['dob'] ?>"
                                               disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-6">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $patient['email'] ?? '' ?>" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $patient['phone'] ?? '' ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-12">
                                        <label for="" class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control"
                                               value="<?php echo $patient['address'] ?? '' ?>" disabled>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-3">
                                        <label for="specialtyStatus" class="form-label" style="line-height: 50px"
                                        >Trạng thái tài khoản</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control"
                                               value="<?php echo $patient['status'] == 1 ? 'Mở' : 'Đóng' ?>" disabled>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger" id="btnLock"
                                        data-bs-toggle="modal" data-bs-target="#confirmChangeStatus">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Thay đổi trạng thái tài khoản
                                </button>
                            </div>
                            <div class="col-6">
                                <h4>
                                    <strong>Lịch sử sử dụng dịch vụ</strong>
                                    <hr>
                                </h4>
                                <?php include 'patient-detail-history.php'?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="confirmChangeStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    Việc thay đổi trạng thái sẽ tiếp tục, bạn chắc chắn chứ ?
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-warning"
                            data-bs-toggle="modal" data-bs-target="#confirmModal"
                    >Tiếp tục</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row pt-0">
                    <div class="col-3 pt-2">Chuyển trạng thái</div>
                    <div class="col-6">
                        <input type="checkbox" id="statusToggle" data-toggle="toggle"
                               data-width="100" data-height="30" data-onstyle="success" data-offstyle="danger"
                               data-on="<i class='fas fa-unlock mr-2'></i> Mở"
                               data-off="<i class='fas fa-lock mr-2'></i> Đóng"
                            <?php echo $patient['status'] == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnUpdateStatus">Lưu thay đổi</button>
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
        document.getElementById('loading-spinner').style.display = 'none';
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        var confirmChangeStatus = new bootstrap.Modal(document.getElementById('confirmChangeStatus'));

        document.getElementById('btnUpdateStatus').addEventListener('click', function() {
            confirmModal.hide()
            const formData = new FormData();
            formData.append('patient_id', <?php echo $patient['patient_id'] ?>);
            formData.append('status', document.getElementById('statusToggle').checked ? 1 : 0);

            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=customer&action=update_status',
                type: 'POST',
                data: formData,
                contentType: false, // Không set contentType
                processData: false, // Không xử lý dữ liệu
                success: function(response) {
                    console.log(response);
                    success_toast('<?php echo BASE_URL ?>/index.php?controller=customer&action=index')
                },
                error: function() {
                    failed_toast()
                    $("#loading-spinner").hide();
                }
            });
        });


        App.init();
    });
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
            delay: 1000
        });

        // Đợi DOM cập nhật
        setTimeout(() => {
            // Lấy phần tử toast mới nhất
            var toastElement = document.querySelector('.toast.show');
            if (toastElement) {
                var bsToast = new bootstrap.Toast(toastElement);
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.href = redirectUrl;
                    $("#loading-spinner").hide();
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
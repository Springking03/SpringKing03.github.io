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
    <link href="<?php echo BASE_URL ?>/assetsv2/img/logo.svg" rel="icon">
    <title>Chi tiết lịch hẹn</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import_head.php' ?>
    <?php include 'import-link-tag.php'?>
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
        <div class="page-head py-0">
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết lịch hẹn</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý đặt lịch</li>
                    <li class="breadcrumb-item active">Danh sách lịch hẹn</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid py-1">
            <div class="card card-table">
                <div class="main-content container-fluid row">
                    <div class="col-6">
                        <h3 class="mt-0">Thông tin cá nhân</h3>
                        <div class="mb-3 row">
                            <div class="col-5">
                                <label for="specialtyName" class="form-label">Tên khách hàng</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_name'] ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="specialtyName" class="form-label">Ngày sinh</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_dob'] ?>
                                </div></div>
                            <div class="col-3">
                                <label for="" class="form-label">Giới tính</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_gender'] == 0 ? 'Nữ' : "Nam" ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label for="" class="form-label">Email</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_email'] ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Số điện thoại</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_phone'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="mt-0">Thông tin lịch hẹn</h3>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Tên chuyên gia</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['doctor_name'] ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Dịch vụ</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['specialty_name'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Ngày đặt lịch hẹn</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo convertDayTimestampToDate($appointment['date_slot']); ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Giờ hẹn</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo substr($appointment['time_slot'], 0, 5) ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Dịch vụ thêm</label>
                            <textarea class="form-control" rows="3" disabled><?php echo $appointment['patient_description'] ?></textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Trạng thái</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php
                                    switch ($appointment['status']) {
                                        case 0:
                                            echo "Chưa xác nhận";
                                            break;
                                        case 1:
                                            echo "Đã xác nhận";
                                            break;
                                        case 2:
                                            echo "Đã hoàn thành";
                                            break;
                                        case 3:
                                            echo "Đã hủy";
                                            break;
                                        default:
                                            echo "Trạng thái không xác định";
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Kết quả</label>
                                <!-- Liên kết để mở modal -->
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php if (empty($appointment['result'])): ?>
                                        Chưa có kết quả
                                    <?php else: ?>
                                        <a href="#" data-toggle="modal" data-target="#resultModal" data-result="<?php echo htmlspecialchars($appointment['result']); ?>">Xem kết quả</a>
                                    <?php endif; ?>
                                </div>

                                <!-- Modal để hiển thị PDF -->
                                <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="resultModalLabel">Hồ sơ sử dụng dịch vụ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe id="resultFrame" src="" style="width:100%; height:500px;" frameborder="0"></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" id="openInNewTab">
                                                    <a href="#" target="_blank" style="color: white; text-decoration: none;">Mở sang tab mới</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <button id="backButton" class="btn btn-danger mr-3" onclick=" window.history.back();">Quay lại</button>
                            <?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            $currentDate = date('Y-m-d');
                            $currentTime = date('H:i'); // Lấy giờ và phút hiện tại

                            $currentDate = convertDate::convertFormYMDToTimestamp($currentDate);

                            if ($appointment['status'] == 1) {
                                if ($appointment['date_slot'] > $currentDate ||
                                    ($appointment['date_slot'] == $currentDate && substr($appointment['time_slot'], 0, 5) < $currentTime)) {
                                    // Hiển thị nút nếu các điều kiện được thỏa mãn
                                    echo '<button id="btnExpired" class="btn btn-warning">Chuyển về danh sách quá giờ</button>';
                                }
                            }
                            ?>
                        </div>
                        <?php
                            if($appointment['status'] == 1 || $appointment['status'] == 2){
                                echo '<form id="uploadForm" enctype="multipart/form-data">
                                        <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" hidden="hidden">
                                        <input type="hidden" name="appointment_id" value=" '.$appointment['id'].'" hidden="hidden">
                                        <button class="btn btn-primary" type="button" id="uploadButton">Tải lên kết quả</button>
                                    </form>';
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="previewModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Bạn có muốn tải lịch hẹn này lên ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfPreview" style="width:100%; height:500px;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnUpload">Tải lên</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="expiredModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thông báo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Việc bệnh nhân đã vắng mặt, bạn có muốn chuyển lịch hẹn này đến danh sách lịch hẹn quá giờ ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="btnRemoveExpired">Chuyển</button>
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
        var expiredModal = new bootstrap.Modal(document.getElementById('expiredModal'));

        document.getElementById('loading-spinner').style.display = 'none';

        document.getElementById('uploadButton').addEventListener('click', function() {
            // Trigger click event on file input to open file dialog
            document.getElementById('pdfFile').click();
        });

        document.getElementById('pdfFile').addEventListener('change', function() {
            if (this.files.length === 0) {
                failed_toast('Vui lòng chọn một file trước khi tải lên.')
                return;
            }
            var file = this.files[0];

            if (file.type !== 'application/pdf') {
                failed_toast('Vui lòng chọn một file PDF.')
                return;
            }

            // Hiển thị PDF trong iframe
            var fileReader = new FileReader();
            var previewModel = new bootstrap.Modal(document.getElementById('previewModel'));
            fileReader.onload = function() {
                previewModel.show()
                document.getElementById('pdfPreview').src = this.result;
            };
            fileReader.readAsDataURL(file);

            document.getElementById('btnUpload').addEventListener('click', function() {
                // previewModel.hide()
                var appointmentId = document.querySelector('input[name="appointment_id"]').value;
                var formData = new FormData();
                formData.append('pdfFile', file);
                formData.append('appointment_id', appointmentId);
                formData.append('name', '<?php echo $appointment['patient_name']; ?>');
                formData.append('email', '<?php echo $appointment['patient_email']; ?>');


                document.getElementById('loading-spinner').style.display = 'block';
                // Gửi AJAX request
                $.ajax({
                    url: '<?php echo BASE_URL ?>/index.php?controller=appointment&action=update_result',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        success_toast('Tải lên kết quả thành công !')
                        $("#loading-spinner").hide();
                    },
                    error: function () {
                        failed_toast('Có lỗi xảy ra, vui lòng thử lại.');
                        $("#loading-spinner").hide();
                    }
                });
            })
        });

        var modal = $('#resultModal');
        var iframe = $('#resultFrame');
        var openInNewTabButton = $('#openInNewTab a');

        modal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var resultUrl = button.data('result');
            iframe.attr('src', resultUrl);
            openInNewTabButton.attr('href', resultUrl);
        });

        openInNewTabButton.on('click', function () {
            modal.modal('hide');
        });

        document.getElementById('btnExpired').addEventListener('click', function(){
            expiredModal.show()
            document.getElementById('btnRemoveExpired').addEventListener('click', function(){
                var appointmentId = document.querySelector('input[name="appointment_id"]').value;
                var formData = new FormData();
                formData.append('appointment_id', appointmentId);
                document.getElementById('loading-spinner').style.display = 'block';
                expiredModal.hide()
                $.ajax({
                    url: '<?php echo BASE_URL ?>/index.php?controller=appointment&action=update_status',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        success_toast('Chuyển đến danh sách quá hẹn thành công')
                    },
                    error: function () {
                        failed_toast('Có lỗi xảy ra, vui lòng thử lại.');
                        $("#loading-spinner").hide();
                    }
                });
            });
        })

        <?php
        function convertDayTimestampToDate($dayTimestamp) {
            if (!isset($dayTimestamp)) return null;
            $timestamp = $dayTimestamp * 86400; // Chuyển đổi số ngày thành giây
            return date('d/m/Y', $timestamp); // Định dạng lại timestamp thành ngày tháng
        }
        ?>
    });
</script>
<script>
    function success_toast(message) {
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
                var bsToast = new bootstrap.Toast(toastElement);
                toastElement.addEventListener('hidden.bs.toast', function () {
                    window.location.reload()
                    $("#loading-spinner").hide();
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
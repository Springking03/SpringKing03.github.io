<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
    exit();
} else if ($_SESSION['role_id'] == 3){
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
    <link href="<?php echo BASE_URL ?>/assetsv2/img/Favicon.png" rel="icon">
    <title>Chi tiết dịch vụ</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <?php include 'import_head.php' ?>
</head>
<body>
<div id="loading-spinner"
     style="text-align: center;line-height:700px;position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1050; display: flex; align-items: center; justify-content: center;">
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
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết dịch vụ</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý dịch vụ</li>
                    <li class="breadcrumb-item active">Danh sách dịch vụ</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -50px !important;">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="main-content container-fluid" style="margin-top: 30px ">
                            <div class="mb-3">
                                <label for="specialtyName" class="form-label">Tên dịch vụ</label>
                                <input type="text" class="form-control" id="specialtyName" maxlength="150"
                                       placeholder="Nhập tên dịch vụ" value="<?php echo $specialty['name'] ?>"
                                       disabled>
                                <span style="margin-left: 10px; color: red" id="errorSpecialtyNameUpdate"></span>
                            </div>
                            <div class="mb-3">
                                <label for="specialtyDescription" class="form-label">Mô tả dịch vụ</label>
                                <textarea class="form-control" id="specialtyDescription" rows="5"
                                          placeholder="Mô tả dịch vụ" maxlength="500"
                                          disabled><?php echo $specialty['description'] ?></textarea>
                                <span style="margin-left: 10px; color: red" id="errorSpecialtyDescriptionUpdate"></span>
                            </div>
                            <div class="mb-3">
                                <label for="specialtyName" class="form-label">Giá</label>
                                <input type="text" class="form-control" id="servicePrice" maxlength="150"
                                       placeholder="Nhập giá dịch vụ" value="<?php echo $specialty['price'] ?>"
                                       disabled>
                                <span style="margin-left: 10px; color: red" id="errorServicePrice"></span>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-1">
                                    <label for="specialtyStatus" class="form-label">Trạng thái</label>
                                </div>
                                <div class="col-3">
                                    <select id="specialtyStatus" class="form-select mb-3"
                                            aria-label="Large select example" disabled>
                                        <option value="0" <?php echo $specialty['status'] == '0' ? 'selected' : ''; ?>>
                                            Đóng
                                        </option>
                                        <option value="1" <?php echo $specialty['status'] == '1' ? 'selected' : ''; ?>>
                                            Mở
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="mt-3 d-flex justify-content-between">
                                <a id="backButton" class="btn btn-danger"
                                   href="<?php echo BASE_URL ?>/index.php?controller=specialty&action=index">Quay lại
                                    danh sách</a>

                                <button id="editButton" class="btn btn-primary">Chỉnh sửa</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="detailSpecialtyModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="z-index: 1049!important;">
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
                    <button type="button" class="btn btn-primary" id="saveSpecialtyUpdate">Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'import-script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL ?>/assets/js/toast/use-bootstrap-toaster.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        App.init();
        document.getElementById('loading-spinner').style.display = 'none';
        var exampleModal = new bootstrap.Modal(document.getElementById('detailSpecialtyModal'));

        const editButton = document.getElementById('editButton');
        const backButton = document.getElementById('backButton');
        const specialtyName = document.getElementById('specialtyName');
        const servicePrice = document.getElementById('servicePrice');
        const specialtyDescription = document.getElementById('specialtyDescription');
        const specialtyStatus = document.getElementById('specialtyStatus');
        const errorSpecialtyName = document.getElementById('errorSpecialtyNameUpdate');
        const errorSpecialtyDescription = document.getElementById('errorSpecialtyDescriptionUpdate');
        const errorServicePrice = document.getElementById('errorServicePrice');

        editButton.addEventListener('click', function () {
            if (editButton.textContent === "Chỉnh sửa") {
                backButton.textContent = "Hủy và quay lại danh sách";
                // Bỏ disable
                specialtyName.disabled = false;
                specialtyDescription.disabled = false;
                specialtyStatus.disabled = false;
                servicePrice.disabled = false;


                // Thay đổi tên nút
                editButton.textContent = "Cập nhật";
            } else {
                let valid = true;
                errorSpecialtyName.textContent = '';
                errorSpecialtyDescription.textContent = '';

                if (!specialtyName.value) {
                    errorSpecialtyName.textContent = 'Tên dịch vụ không được để trống';
                    valid = false;
                }

                if (!specialtyDescription.value) {
                    errorSpecialtyDescription.textContent = 'Mô tả không được để trống';
                    valid = false;
                }

                if (!servicePrice.value) {
                    errorServicePrice.textContent = 'Giá không được để trống';
                    valid = false;
                }

                if (valid) {
                    exampleModal.show()
                }
            }
        });

        document.getElementById('saveSpecialtyUpdate').addEventListener('click', function () {
            exampleModal.hide()

            console.log("Tên dịch vụ:", specialtyName.value);
            console.log("Mô tả dịch vụ:", specialtyDescription.value);
            console.log("Trạng thái:", specialtyStatus.value);

            var formData = new FormData();
            formData.append('specialtyId', <?php echo $specialty['service_id'] ?>);
            formData.append('specialtyName', specialtyName.value);
            formData.append('specialtyDescription', specialtyDescription.value);
            formData.append('specialtyStatus', specialtyStatus.value);
            formData.append('servicePrice', servicePrice.value);

            document.getElementById('loading-spinner').style.display = 'block';
            $.ajax({
                url: '<?php echo BASE_URL ?>/index.php?controller=specialty&action=update',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    success_toast('<?php echo BASE_URL ?>/index.php?controller=specialty&action=index')
                    // document.getElementById('loading-spinner').style.display = 'none';
                },
                error: function () {
                    failed_toast()
                    document.getElementById('loading-spinner').style.display = 'none';
                }
            });
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
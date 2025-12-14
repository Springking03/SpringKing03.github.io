<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử sử dụng dịch vụ</title>
    <link href="http://localhost/Vidental/assetsv2/img/logo.svg" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/views/admin/assets/css/app.css" type="text/css">
    <link href="assetsv2/css/vidental.css" rel="stylesheet">

</head>
<?php include "components/header.php" ?>
<body>

<main class="container p-0" style="margin-top: 30px!important; margin-bottom: 30px">
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
                        <label for="" class="form-label">Tên bác sĩ/label>
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
                    <label for="" class="form-label">Mô tả tình trạng của khách hàng</label>
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
                                <a href="#" data-bs-toggle="modal" data-bs-target="#resultModal" data-result="<?php echo htmlspecialchars($appointment['result']); ?>">Xem kết quả</a>
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
                <button id="backButton" class="btn btn-danger">Quay lại</button>
            </div>
        </div>
    </div>
</main>

<?php include "component_cent/footer.php" ?>
<script src="<?php echo BASE_URL ?>/views/admin/assets/lib\jquery\jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = $('#resultModal');
        var iframe = $('#resultFrame');
        var openInNewTabButton = $('#openInNewTab a');

        modal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var resultUrl = button.data('result'); // Extract info from data-* attributes
            iframe.attr('src', resultUrl); // Update the iframe's content
            openInNewTabButton.attr('href', resultUrl); // Update the link for opening in a new tab
        });

        openInNewTabButton.on('click', function () {
            modal.modal('hide');
        });
    });

    <?php
    function convertDayTimestampToDate($dayTimestamp) {
        if (!isset($dayTimestamp)) return null;
        $timestamp = $dayTimestamp * 86400; // Chuyển đổi số ngày thành giây
        return date('d/m/Y', $timestamp); // Định dạng lại timestamp thành ngày tháng
    }
    ?>

    document.getElementById('backButton').addEventListener('click', function() {
        window.history.back();
    });

</script>
</body>
</html>
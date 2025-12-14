<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
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
    <title>Danh sách khách vãng lai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <style>
        #btn-action:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

    </style>
    <?php include 'import_head.php' ?>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Danh sách khách vãng lai</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="<?php echo HOME_ADMIN_URL ?>">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý khách hàng</li>
                    <li class="breadcrumb-item active">Danh sách khách hàng</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -30px ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="row table-filters-container">
                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">

                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">

                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Nhập tên hoặc sđt ..." autocomplete="off"
                                                   class="form-control" value="<?php echo $_GET['search'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="button" style="background-color: #D25B33!important; color: white" class="btn form-control">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="noSwipe">
                                <table class="table table-striped table-hover be-table-responsive" id="table1">
                                    <thead>
                                    <tr>
                                        <th style="width:2%;">STT</th>
                                        <th style="width:10%;">Tên khách hàng</th>
                                        <th style="width:10%;">Giới tính</th>
                                        <th style="width:10%;">Ngày sinh</th>
                                        <th style="width:10%;">Số điện thoại</th>
                                        <th style="width:10%;">Email</th>
                                        <th style="width:10%;">Số lần sử dụng dịch vụ</th>
                                        <th style="width:1%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $currentPage = $_GET['page'] ?? 1;
                                    $counter = ($currentPage - 1) * 10 + 1;
                                    foreach ($appointmentsGuests as $guest): ?>
                                        <tr>
                                            <td style="text-align: center">
                                                <?php echo $counter; ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($guest['patient_name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($guest['patient_gender'] == 1 ? 'Nam' : 'Nũ'); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($guest['patient_dob']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($guest['patient_phone']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($guest['patient_email']); ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php echo htmlspecialchars($guest['total_appointments']); ?>
                                            </td>
                                            <td class="p-0">
                                                <div class="btn-group">
                                                    <button id="btn-action"
                                                            style="border: none; background-color: transparent; "
                                                            class=" dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
<!--                                                        <a type="button" class="dropdown-item"-->
<!--                                                           href="--><?php //echo BASE_URL ?><!--/index.php?controller=customer&action=guest_detail&phone=--><?php //echo $guest['patient_phone'] ?><!--">Chi tiết</a>-->
                                                        <form action="<?php echo BASE_URL ?>/index.php?controller=customer&action=guest_detail_admin" method="POST">
                                                            <input type="hidden" name="phone" value="<?php echo $guest['patient_phone'] ?>">
                                                            <button class="dropdown-item" style="border: none ;background-color: transparent" type="submit" id="getAppointment">Chi tiết</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    endforeach; ?>
                                    </tbody>
                                </table>
                                <div class="row be-datatable-footer" style="position: fixed; bottom: 0; right: 1.6%; left: 16.8%">
                                    <div class="col-sm-10 dataTables_paginate" id="pagination" style="margin-bottom: 0px!important;">
                                        <nav aria-label="Page navigation example">
                                            <?php
                                            $currentPage = $_GET['page'] ?? 1;
                                            $queryString = $_SERVER['QUERY_STRING'];
                                            parse_str($queryString, $queryParams);
                                            unset($queryParams['page']);
                                            $newQueryString = http_build_query($queryParams);

                                            $totalPages = ceil($totalAppointmentsGuest / 10);
                                            $range = 2; // Số trang hiển thị xung quanh trang hiện tại
                                            $initialNum = $currentPage - $range;
                                            $conditionLimitNum = ($currentPage + $range)  + 1;
                                            ?>
                                            <ul class="pagination">
                                                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=1" aria-label="Previous">
                                                        <span aria-hidden="true">&lt;&lt;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo max(1, $currentPage - 1); ?>" aria-label="Previous">
                                                        <span aria-hidden="true">&lt;</span>
                                                    </a>
                                                </li>
                                                <?php
                                                if ($initialNum > 1) {
                                                    echo '<li class="page-item"><a class="page-link" href="?'.$newQueryString.'&page=1">1</a></li>';
                                                    if ($initialNum > 2) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                }

                                                for ($i = max($initialNum, 1); $i < min($conditionLimitNum, $totalPages + 1); $i++) {
                                                    $activeClass = ($i == $currentPage) ? 'active' : '';
                                                    echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?'.$newQueryString.'&page=' . $i . '">' . $i . '</a></li>';
                                                }

                                                if ($conditionLimitNum < $totalPages + 1) {
                                                    if ($conditionLimitNum < $totalPages) {
                                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                                    }
                                                    echo '<li class="page-item"><a class="page-link" href="?'.$newQueryString.'&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                                                }
                                                ?>
                                                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo min($totalPages, $currentPage + 1); ?>" aria-label="Next">
                                                        <span aria-hidden="true">&gt;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=<?php echo $totalPages; ?>" aria-label="Next">
                                                        <span aria-hidden="true">&gt;&gt;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <?php
                                    $recordsPerPage = 10;
                                    $currentPage = $_GET['page'] ?? 1;
                                    $totalPages = ceil($totalAppointmentsGuest / $recordsPerPage);
                                    $startRecord = ($currentPage - 1) * $recordsPerPage + 1;
                                    $endRecord = $currentPage * $recordsPerPage;
                                    if ($endRecord > $totalAppointmentsGuest) {
                                        $endRecord = $totalAppointmentsGuest;
                                    }
                                    ?>
                                    <div class="col-sm-2 dataTables_info" id="sub-pagination" style="line-height: 48px">
                                        <?php echo $startRecord . " đến " . $endRecord . " trong số " . $totalAppointmentsGuest . " khách"?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<?php include 'import-script.php' ?>
<script type="text/javascript">
    $(document).ready(function(){
        document.querySelectorAll('.dropdown-item').forEach(function(button) {
            button.addEventListener('click', function() {
                var appointmentId = this.getAttribute('data-id');
                showAppointmentDetails(appointmentId);
            });
        });

        function showAppointmentDetails(appointmentId) {
            // Lấy dữ liệu từ server hoặc hiển thị dialog
            console.log('Hiển thị thông tin cho appointment ID:', appointmentId);
            // Code để hiển thị dialog ở đây
        }
        //-initialize the javascript
        App.init();
        App.tableFilters();
    });
</script>
<script>
    var url_appointment = '<?php echo BASE_URL ?>/index.php?controller=customer&action=guest&page=1'

    document.getElementById('button').addEventListener('click', function() {
        var searchInput = document.getElementById('searchInput').value.trim();

        if (searchInput.length > 0) {
            url_appointment += '&search=' + encodeURIComponent(searchInput);
        }

        console.log(url_appointment)

        window.location.href = url_appointment
    });

    function getRowClass(status) {
        switch (status) {
            case 0:
                return 'warning in-progress';
            case 1:
                return 'primary to-do';
            case 2:
                return 'success done';
            case 3:
                return 'danger in-review';
            default:
                return '';
        }
    }

    function formatDate(timestamp) {
        var date = new Date(timestamp * 1000);
        return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
    }

    function convertDateToDayTimestamp(dateString) {
        if (!dateString) return null;
        var parts = dateString.split('/');
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1;
        var year = parseInt(parts[2], 10);
        var date = new Date(Date.UTC(year, month, day));

        // Chuyển đổi ngày sang timestamp và chia cho số giây trong một ngày
        return Math.floor(date.getTime() / 86400000); // 86400000 là số miligiây trong một ngày
    }
</script>
</body>
</html>
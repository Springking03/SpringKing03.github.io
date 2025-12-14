<?php
if (!isset($_SESSION['admin_name'])) {
    header('Location: '. NOT_FOUND_URL);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="<?php echo BASE_URL ?>/assetsv2/img/Favicon.png">

    <title>Trang chủ - QTV</title>
    <?php include 'import_head.php' ?>
</head>
<body>
<div class="be-wrapper be-fixed-sidebar">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="main-content container-fluid">
            <!--            4 so lieu-->
            <div class="row">
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline" >
                            <i class="fa-solid fa-bed-pulse fa-3x"  style="color: #34a853"></i>
                        </div>
                        <div class="data-info">
                            <div class="desc">Ca hẹn đã phục vụ</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-up"></span>
                                <span class="number" data-toggle="counter"
                                      data-end="<?php echo $appointmentSuccess ?>"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-3" >
                    <a class="widget widget-tile" title="Đi đến trang xác nhận lịch hẹn"
                       href="<?php echo BASE_URL ?>/index.php?controller=appointment&action=confirm">
                        <div class="chart sparkline" style="color: black">
                            <i class="fa-solid fa-calendar-check fa-3x" style="color: #fae711"></i>
                        </div>
                        <div class="data-info" style="color: black">
                            <div class="desc" >Cần xác nhận lịch hẹn</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-up" style="color: #fae711"></span>
                                <span class="number" data-toggle="counter"
                                      data-end="<?php echo $appointmentPending ?>">0</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline">
                            <i class="fa-solid fa-clock fa-3x" style="color: #4182ff"></i>
                        </div>
                        <div class="data-info">
                            <div class="desc">Lịch hẹn đang chờ</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-up" style="color: #4182ff"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $appointmentProcess ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline">
                            <i class="fa-solid fa-rectangle-xmark fa-3x" style="color: #fc0303;"></i>
                        </div>
                        <div class="data-info">
                            <div class="desc">Lịch hẹn hủy</div>
                            <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span>
                                <span class="number" data-toggle="counter"
                                      data-end="<?php echo $appointmentCancel ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header card-header-divider pb-3">Phân bổ độ tuổi khách hàng</div>
                        <div class="card-body pt-5">
                            <div class="row user-progress user-progress-small">
                                <div class="col-lg-4"><span class="title">Dưới 14 tuổi </span></div>
                                <div class="col-lg-6">
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                             style="width: <?php echo ($from0_14 / $appointmentSuccess) * 100 ?>%;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-2"><span
                                            class="title"><?php echo round(($from0_14 / $appointmentSuccess) * 100, 1) ?>%</span>
                                </div>
                            </div>
                            <div class="row user-progress user-progress-small">
                                <div class="col-lg-4"><span class="title">Từ 15 - 35 tuổi</span></div>
                                <div class="col-lg-6">
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                             style="width: <?php echo ($from15_35 / $appointmentSuccess) * 100 ?>5%;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-2"><span
                                            class="title"><?php echo round(($from15_35 / $appointmentSuccess) * 100, 1) ?>%</span>
                                </div>
                            </div>
                            <div class="row user-progress user-progress-small">
                                <div class="col-lg-4"><span class="title">Từ 36 - 64 tuổi</span></div>
                                <div class="col-lg-6">
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                             style="width: <?php echo ($from36_64 / $appointmentSuccess) * 100 ?>0%;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-2"><span
                                            class="title"><?php echo round(($from36_64 / $appointmentSuccess) * 100, 1) ?>%</span>
                                </div>
                            </div>
                            <div class="row user-progress user-progress-small">
                                <div class="col-lg-4"><span class="title">Từ 65 tuổi</span></div>
                                <div class="col-lg-6">
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                             style="width: <?php echo ($from65 / $appointmentSuccess) * 100 ?>0%;"></div>
                                    </div>
                                </div>
                                <div class="col-lg-2"><span class="title">
                                        <?php echo round(100
                                            - ($from0_14 / $appointmentSuccess) * 100
                                            - ($from15_35 / $appointmentSuccess) * 100
                                            - ($from36_64 / $appointmentSuccess) * 100)
                                        ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="widget be-loading">
                        <div class="widget-head">
                            <div class="title">Tỷ lệ trạng thái</div>
                        </div>
                        <div class="chart-legend">
                            <div class="chart-container">
                                <canvas id="myPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="widget widget-calendar">
                        <div id="calendar-widget"></div>
                    </div>
                </div>
            </div>

            <div class="row p-0">
                <div class="col-12">
                    <div class="widget widget-fullwidth be-loading">
                        <div class="widget-chart-container">
                            <div id="main-chart" style="height: 1px; background-color: #eee "></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include 'import_script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //-initialize the javascript
        App.init();
        App.dashboard();
        $('#calendar-widget').datepicker();

        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Lịch đã được đặt', 'Lịch hẹn hoàn thành', 'Lịch hẹn bị hủy'],
                datasets: [{
                    data: [
                        <?php echo $appointmentPending + $appointmentProcess ?>,
                        <?php echo $appointmentSuccess ?>,
                        <?php echo $appointmentCancel ?>
                    ],
                    backgroundColor: [
                        'rgba(0, 119, 204, 0.18)',    // Xanh dương nhạt (đã đặt)
                        'rgba(0, 200, 83, 0.22)',     // Xanh lá nhạt (hoàn thành)
                        'rgba(220, 38, 38, 0.18)'     // Đỏ nhạt (hủy)
                    ],
                    borderColor: [
                        '#0077CC',        // Viền xanh dương đậm
                        '#00C853',        // Viền xanh lá
                        '#DC2626'         // Viền đỏ
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 16,
                            padding: 20,
                            font: {
                                size: 13,
                                weight: '600',
                                family: "'Inter', sans-serif"
                            },
                            color: '#E2E8F0',           // Chữ trắng (nền tối)
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });
    });

    // Cấu hình tiếng Việt cho datepicker (giữ nguyên)
    $.datepicker.regional['vi'] = { /* ... giữ nguyên như cũ ... */ };
    $.datepicker.setDefaults($.datepicker.regional['vi']);
</script>
</body>
</html>
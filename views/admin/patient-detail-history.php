<div class="card card-table">
    <div class="card-body">
        <div class="noSwipe">
            <table class="table table-striped table-hover be-table-responsive" id="table1">
                <thead>
                <tr>
                    <th style="width:5%;">STT</th>
                    <th style="width:15%;">Chuyên gia</th>
                    <th style="width:12%;">Khách hàng</th>
                    <th style="width:15%;">Dịch vụ</th>
                    <th style="width:10%;">Thời gian</th>
                    <th style="width:5%;"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $currentPage = $_GET['page'] ?? 1;
                $counter = ($currentPage - 1) * 10 + 1;
                foreach ($listAppointments as $appointment): ?>
                    <tr>
                        <td style="text-align: center">
                            <?php echo $counter; ?>
                        </td>
                        <td>
                            <span><?php echo htmlspecialchars($appointment['doctor_name']); ?></span>
                        </td>
                        <td class="cell-detail milestone" data-project="Bootstrap">
                            <span class="completed"></span>
                            <span class="cell-detail-description"style="font-size: 13px; color: black"><?php echo htmlspecialchars($appointment['patient_name']); ?></span>
                        </td>
                        <td class="cell-detail">
                            <span><?php echo htmlspecialchars($appointment['specialty_name']); ?></span>
                            <!--                                            <span class="cell-detail-description">63e8ec3</span>-->
                        </td>
                        <td class="cell-detail">
                            <span class="date"><?php echo date('H:i', strtotime($appointment['time_slot'])); ?></span>
                            <span class="cell-detail-description">
                            <?php
                            //$appointment['date_slot'] là số ngày kể từ ngày 1/1/1970
                            $timestamp = $appointment['date_slot'] * 86400; // Chuyển đổi số ngày thành giây

                            // Đặt múi giờ sang "Asia/Ho_Chi_Minh" để đảm bảo chuyển đổi ngày chính xác theo giờ Việt Nam
                            date_default_timezone_set('Asia/Ho_Chi_Minh');

                            $date = date('d-m-Y', $timestamp); // Định dạng lại timestamp thành ngày tháng
                            echo htmlspecialchars($date);
                            ?>
                            </span>
                        </td>
                        <td class="p-0">
                            <div class="btn-group">
                                <button id="btn-action"
                                        style="border: none; background-color: transparent;"
                                        class="dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a type="button" class="dropdown-item"
                                       href="<?php echo BASE_URL ?>/index.php?controller=appointment&action=detail&id=<?php echo $appointment['id'] ?>">Chi tiết</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $counter++;
                endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
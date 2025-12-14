<div class="row">
    <div class="col-md-6">
        <h5 class="mb-4">Chọn thông tin dịch vụ</h5>
        <div class="row">
            <div class="mb-3 col-sm-11">
                <?php include "select-specialty.php" ?>
                <input type="text" hidden="hidden" id="selected-specialty"/>
                <input type="text" hidden="hidden" id="selected-specialty-name"/>
            </div>
            <div class="mb-3 col-sm-11">
                <?php include "select-doctor.php" ?>
                <input type="text" hidden="hidden" id="selected-doctor"/>
                <input type="text" hidden="hidden" id="selected-doctor-name"/>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <h5 class="mb-1">Thời gian đặt lịch</h5>
            <p>Ngày hẹn (*)</p>
            <div class="col-12 mb-3" id="format-btn-date">
                <div class="btn-select-day" onclick="selectDateSlot(this)">
                    <div class="date-format" id="todayBtn"></div>
                    <span style="font-size: 13px">Hôm nay</span>
                </div>
                <div class="btn-select-day" onclick="selectDateSlot(this)">
                    <div class="date-format" id="tomorrowBtn"></div>
                    <span style="font-size: 13px">Ngày mai</span>
                </div>
                <div class="btn-select-day" onclick="selectDateSlot(this)">
                    <div class="date-format" id="dayAfterTomorrowBtn"></div>
                    <span style="font-size: 13px">Ngày kia</span>
                </div>
                <div class="btn-select-day" id="otherDay" onclick="selectDateSlot(this)">
                    <form action="#">
                        <div class="input-group">
                            <i class="fa-regular fa-calendar input-group-text"></i>
                            <input type="text" class="form-control" id="input-otherDate" placeholder="Chọn ngày khác"
                                   autocomplete="off">
                        </div>
                        <input type="text" id="date-slot" hidden="hidden">
                        <input type="text" id="selected-date-slot" hidden="hidden">
                    </form>

                </div>
            </div>
            <span id="error-date" class="ml-2" style="color: red;"></span>
            <!-- Chọn gio khám -->
            <p>Giờ hẹn (*)</p>
            <div class="col-12" id="display-time-slot">
            </div>
            <input type="text" id="time-slot" hidden="hidden">
            <input type="text" id="selected-time-slot" hidden="hidden">
            <span id="error-time" class="ml-2" style="color: red;"></span>
            <strong style="font-style: italic; font-size: 13px">Lưu ý: Thời gian đặt lịch trên chỉ là thời gian dự kiến,
                tổng
                đài sẽ liên hệ xác nhận thời
                gian hẹn chính xác tới quý khách sau khi quý khách đặt hẹn</strong>
        </div>
    </div>
    <hr>
    <div class="text-center mt-3">
        <button id="action-button" class="btn btn-success" type="button"
                style="background-color:#d25b33 !important; width: 20%; font-weight: bold; border: none">
            Tiếp tục
        </button>
    </div>
</div>
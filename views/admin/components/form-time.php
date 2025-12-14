<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="col-12">
    <h4 class="mb-4 mt-0"><strong>Chọn thông tin dịch vụ</strong></h4>
    <div class="row">
        <div class="mb-1 col-md-12">
            <?php include "select-specialty.php" ?>
            <input type="text" hidden="hidden" id="selected-specialty"/>
        </div>
        <div class="mb-1 col-md-12">
            <?php include "select-doctor.php" ?>
            <input type="text" hidden="hidden" id="selected-doctor"/>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="row mb-3">
        <div class="col-3 pr-0 m-0">
            <p>Ngày hẹn (*)</p>
        </div>
        <div class="input-group col-md-9">
            <input type="text" value="" id="input-otherDate" placeholder="Chọn ngày khác" autocomplete="off" readonly
            style="width: 100%">
        </div>
        <input type="text" id="date-slot" hidden="hidden">
    </div>
    <div class="row">
        <div class="col-md-12 pr-0">
            <p>Giờ hẹn (*) <strong id="timeSlot" style="font-size: 13px; margin-left: 74px"></strong></p>
        </div>
        <div class="col-md-12 pr-0">
            <div id="display-time-slot"></div>
        </div>
        <input type="text" id="time-slot" hidden="hidden">
        <span id="error-time" class="ml-2" style="color: red;"></span>
    </div>
</div>


<div class="row">
    <div class="col-12  mb-3 d-flex justify-content-between">
        <h5>Nhập thông tin cá nhân</h5>
        <button id="autoInformation" class="btn btn-warning">Tự động nhập thông tin</button>
    </div>
    <div class="col-md-6">
        <div class="row mb-4">
            <div class="col-8">
                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                    <input type="text" class="form-control" id="patient-name" maxlength="50" placeholder="Nhập họ và tên (*)">
                </div>
                <span id="error-name-gender" class="ml-2" style="color: red; display: none"></span>
            </div>
            <div class="col-4 text-center row">
                <div class="col-6 m-0 p-0">
                    <input type="radio" id="male" name="gender" value="1"
                           style="width: 14px; height: 14px;">
                    <label for="male">Nam</label>
                </div>
                <div class="col-6 m-0 p-0">
                    <input type="radio" id="female" name="gender" value="0"
                           style="width: 14px; height: 14px;">
                    <label for="female">Nữ</label>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-birthday-cake"></i>
                                </span>
                <input type="date" class="form-control" id="patient-dob" placeholder="Ngày sinh (*)">
            </div>
            <span id="error-dob" class="ml-2" style="color: red; display: none"></span>
        </div>
        <div class="mb-4">
            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-phone"></i>
                                </span>
                <input type="text" class="form-control" id="patient-phone" maxlength="11"
                       placeholder="Nhập số điện thoại chính xác để xác nhận bởi CSKH (*)">
            </div>
            <span id="error-phone" class="ml-2" style="color: red; display: none"></span>
        </div>
        <div class="mb-4">
            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                <input type="email" class="form-control" id="patient-email" maxlength="150"
                       placeholder="Để lại email để nhận thông tin lịch hẹn">
            </div>
            <span id="error-email" class="ml-2" style="color: red;"></span>
        </div>
    </div>
<!--    <div style="width: 50%; margin: 0">-->
    <div class="col-md-6 mb-4">
    <textarea class="form-control" id="patient-description" rows="9" style="resize: none" maxlength="500"
              placeholder="Ghi chú"></textarea>
        <span id="error-description" class="ml-2" style="color: red;"></span>
    </div>
    <hr>
    <div class="text-center mt-3 d-flex justify-content-between">
        <button id="backAppointment" type="button" class="btn btn-primary"
                style="background-color:#d25b33 !important; width: 15%; font-weight: bold; border: none">
            Quay lại
        </button>
        <button id="openConfirm" type="button" class="btn btn-primary"
                style="background-color:#d25b33 !important; width: 25%; font-weight: bold; border: none">
            Xem lại thông tin và xác nhận
        </button>
    </div>
</div>



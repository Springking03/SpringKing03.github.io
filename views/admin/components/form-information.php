<div class="row p-0 m-0">
    <h4 class="col-md-12"><strong>Nhập thông tin cá nhân</strong></h4>
    <div class="col-md-12 mt-2">
        <div class="row mb-2">
            <div class="col-md-8">
                <label for="patient-name" class="form-label">Họ và tên (*)</label>
                <div class="input-group-sm">
                    <input type="text" class="form-control" id="patient-name" maxlength="50" placeholder="Nhập họ và tên (*)">
                </div>
                <span id="error-name-gender" class="ml-2" style="color: red; display: none"></span>
            </div>
            <div class="col-md-4 text-center row mt-6">
                <div class="col-6">
                    <input type="radio" id="male" name="gender" value="1" style="width: 14px; height: 14px;" disabled>
                    <label for="male">Nam</label>
                </div>
                <div class="col-6">
                    <input type="radio" id="female" name="gender" value="0" style="width: 14px; height: 14px;" disabled>
                    <label for="female">Nữ</label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-5">
                <label for="patient-dob">Ngày sinh (*)</label>
                <div class="input-group-sm">
                    <input type="date" class="form-control" id="patient-dob" placeholder="Ngày sinh (*)">
                </div>
                <span id="error-dob" class="ml-2" style="color: red; display: none"></span>
            </div>
            <div class="col-md-7">
                <label for="patient-phone">Số điện thoại (*)</label>
                <div class="input-group-sm">
                    <input type="text" class="form-control" id="patient-phone" maxlength="11" placeholder="Nhập số điện thoại (*)">
                </div>
                <span id="error-phone" class="ml-2" style="color: red; display: none"></span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <label for="patient-email" class="form-label">Email (*)</label>
                <div class="input-group-sm">
                    <input type="email" class="form-control" id="patient-email" maxlength="150" placeholder="Để lại email để nhận thông tin lịch hẹn">
                </div>
                <span id="error-email" class="ml-2" style="color: red;"></span>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-2">
        <label for="patient-description">Mô tả triệu chứng</label>
        <textarea class="form-control" id="patient-description" maxlength="500" rows="4" style="resize: none" placeholder="Mô tả triệu chứng"></textarea>
    </div>
    <div class="col-md-12 row pr-0">
        <div class="col-3">
            <p style="margin-top: 8px">Trạng thái</p>
        </div>
        <div class="col-9 pr-0 px-0">
            <select id="status-appointment" class="form-select" aria-label="Small select example" style="background-color: #D25B33">
                <option selected hidden="true">Chọn trạng thái</option>
                <option value="0">Chờ xác nhận</option>
                <option value="1">Đã xác nhận</option>
                <option value="2">Hoàn thành</option>
                <option value="3">Đã hủy</option>
            </select>
        </div>
    </div>
</div>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm mới nhân viên</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2 row">
                    <div class="col-6">
                        <label for="emName" class="form-label">Tên nhân viên *</label>
                        <input type="text" class="form-control" id="emName" maxlength="255" placeholder="Nhập tên nhân viên mới" autocomplete="off">
                        <span style="margin-left: 10px; color: red" id="errorEmName"></span>
                    </div>
                    <div class="col-2 p-0">
                        <label for="emGender" class="form-label">Giới tính</label>
                        <select id="emGender" class="form-select mb-3" aria-label="Large select example" style="height: 50px" >
                            <option value="1" selected>Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="emDob" class="form-label">Ngày sinh *</label>
                        <input type="date" class="form-control" id="emDob" autocomplete="off">
                        <span style="margin-left: 10px; color: red" id="errorEmDob"></span>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-6">
                        <label for="emEmail" class="form-label">Email *</label>
                        <input type="text" class="form-control" id="emEmail" maxlength="255" placeholder="Nhập email" autocomplete="off">
                        <span style="margin-left: 10px; color: red" id="errorEmEmail"></span>
                    </div>
                    <div class="col-6">
                        <label for="emPhone" class="form-label">Số điện thoại *</label>
                        <input type="text" class="form-control" id="emPhone" maxlength="10" placeholder="Nhập số điện thoại" autocomplete="off">
                        <span style="margin-left: 10px; color: red" id="errorEmPhone"></span>
                    </div>
                </div>
                <div class="mb-1 row">
                    <div class="col-9">
                        <label for="emAddress" class="form-label">Địa chỉ *</label>
                        <input type="text" class="form-control" id="emAddress" maxlength="255" placeholder="Nhập địa chỉ nhân viên" autocomplete="off">
                        <span style="margin-left: 10px; color: red" id="errorEmAddress"></span>
                    </div>
                    <div class="col-3">
                        <label for="emStatus" class="form-label">Trạng thái</label>
                        <select id="emStatus" class="form-select mb-3" aria-label="Large select example" style="height: 50px">
                            <option value="0" >Đóng</option>
                            <option value="1" selected>Mở</option>
                        </select>
                    </div>
                </div>
                <div class="mb-1 row">
                    <div class="col-5">
                        <label for="emPosition" class="form-label">Chức vụ *</label>
                        <select id="emPosition" class="form-select" aria-label="Large select example" style="height: 50px">
                            <option hidden="hidden" value="0">Chọn chức vụ</option>
                            <?php
                            foreach ($listPositions as $position) {
                                if ($position['position_id'] != 1) {  // Kiểm tra nếu id chức vụ không phải là 1
                                    echo "<option value='" . htmlspecialchars($position['position_id']) . "'>" . htmlspecialchars($position['name']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <span style="margin-left: 10px; color: red" id="errorEmPosition"></span>
                    </div>
                    <div class="col-7">
                        <div class="mb-3">
                            <label for="empAvt" class="form-label">Tải lên ảnh</label>
                            <input class="form-control" type="file" id="empAvt">
                            <span style="margin-left: 10px; color: red" id="errorEmpAvt"></span>
                        </div>
                    </div>
                </div>
                <strong class="pl-3"><i>* Mật khẩu mặc định là: Abc12345</i></strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                <button type="button" id="btnAddEm" class="btn btn-primary">Thêm mới</button>
            </div>
        </div>
    </div>
</div>
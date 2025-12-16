<nav class="navbar navbar-expand fixed-top be-top-header">
    <div class="container-fluid">
        <div class="be-navbar-header">
            <a href="<?php echo BASE_URL ?>/index.php?controller=home&action=home_admin" class="ml-5">
                <img src="<?php echo BASE_URL ?>/assetsv2/img/logo.svg" alt="logo" width="100">
            </a>
        </div>
        <div class="page-title"><span>Bảng điều khiển</span></div>
        <div class="be-right-navbar">
            <!--            tai khoan-->
            <ul class="nav navbar-nav float-right be-user-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                                 role="button" aria-expanded="false">
                        <img src=\"<?php echo $_SESSION['admin_avt'] ?? (BASE_URL . '/assets/img/doctors/doctor_default.png'); ?>\" alt="Avatar" width="190">
                        <span class="user-name"><?php echo $_SESSION['admin_name'] ?></span>
                    </a>
                    <div class="dropdown-menu" role="menu">
                        <div class="user-info">
                            <div class="user-name"><?php echo $_SESSION['admin_name'] ?></div>
                            <div class="user-position online">Hoạt động</div>
                        </div>
                        <a class="dropdown-item" href="<?php echo BASE_URL ?>/index.php?controller=employee&action=profile">
                            <span class="icon mdi mdi-face"></span>Tài khoản
                        </a>
                        <a  data-bs-toggle="modal" data-bs-target="#exampleModal"
                            class="dropdown-item" href="<?php echo BASE_URL ?>/index.php?controller=auth&action=logout">
                            <span class="icon mdi mdi-power"></span>Đăng xuất
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn đăng xuất không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" onclick="logout()" >Đăng xuất</button>
            </div>
        </div>
    </div>
</div>
<script>
    function logout() {
        window.location.href = "<?php echo BASE_URL ?>/index.php?controller=auth&action=logout";
    }
</script>
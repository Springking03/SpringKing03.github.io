<?php include "component_cent/header.php"; ?>

<body>
    <!-- Page Preloder -->
    <?php include "component_cent/loading.php"; ?>

    <!-- Offcanvas Menu Begin -->
    <?php include "component_cent/offMenu.php"; ?>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <?php include "component_cent/header_content.php"; ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option spad set-bg" data-setbg="assetsv2/img/bg3.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Liên hệ với chúng tôi</h2>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Trang chủ</a>
                            <span>Liên hệ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="contact__widget">
                        <div class="contact__widget__icon">
                            <i class="fa fa-map-marker"></i>
                        </div>
                        <div class="contact__widget__text">
                            <h5>Địa chỉ</h5>
                            <p> 12 P. Chùa Bộc, Quang Trung, Đống Đa, Hà Nội</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="contact__widget">
                        <div class="contact__widget__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact__widget__text">
                            <h5>Hotline</h5>
                            <p> +84 927 526 888</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="contact__widget">
                        <div class="contact__widget__icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="contact__widget__text">
                            <h5>Email</h5>
                            <p>Vidental@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact__content">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="contact__pic">
                            <img src="assetsv2/img/contact-pic.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="contact__form p-3">
                            <h3>Ý kiến đóng góp</h3>
                            <form action="#">
                                <input type="text" placeholder="Tên của bạn">
                                <input type="text" placeholder="Email">
                                <textarea placeholder="Ý kiến đóng góp"></textarea>
                                <button type="submit" class="site-btn">Gửi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer Section Begin -->
    <?php include "component_cent/footer.php"; ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <?php include "component_cent/js_import.php"; ?>
</body>

</html>
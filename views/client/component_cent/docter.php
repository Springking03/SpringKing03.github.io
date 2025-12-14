<section class="team spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-title">
                    <span>Đội ngũ của chúng tôi</span>
                    <h2>Đội ngũ bác sĩ</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($listDoctors as $doctor): ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="team__item">
                    <img src="<?php echo $doctor['avt']; ?>" alt="">
                    <h5><?php echo $doctor['doctorName']; ?></h5>
                    <span><?php echo $doctor['specialtyName']; ?></span>
                    <div class="team__item__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
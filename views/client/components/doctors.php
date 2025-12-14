<section id="doctors" class="doctors section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Chuyên gia</h2>
        <p>Các chuyên gia y tế tại trung tâm chúng tôi có kinh nghiệm và uy tín, sẵn lòng hỗ trợ bạn trong mọi vấn đề về sức khỏe.</p>
      </div>

      <div class="row">
        <?php foreach ($listDoctors as $doctor): ?>
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
          <div class="member" data-aos="fade-up" data-aos-delay="100">
            <div class="member-img">
              <img src="<?php echo $doctor['avt']; ?>" class="img-fluid" alt="">
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4><?php echo $doctor['doctorName']; ?></h4>
              <span><?php echo $doctor['specialtyName']; ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>
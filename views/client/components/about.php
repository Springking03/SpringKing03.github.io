<?php
$title = "Về Chúng Tôi";
$description = "Medicare là trung tâm xét nghiệm chuyên nghiệp, cung cấp dịch vụ xét nghiệm chẩn đoán cho bệnh nhân. Chúng tôi cam kết đem đến cho bệnh nhân sự tiện lợi và chăm sóc tốt nhất.";
$commitment = "Chúng tôi cam kết cung cấp dịch vụ chất lượng hàng đầu.";
$details = [
    "Đội ngũ nhân viên chuyên nghiệp và giàu kinh nghiệm.",
    "Công nghệ xét nghiệm hiện đại và tiên tiến.",
    "Chất lượng dịch vụ luôn được đảm bảo cao nhất."
];
$finalNote = "Chúng tôi không ngừng nỗ lực để đem lại sự hài lòng và tin tưởng tuyệt đối từ phía bệnh nhân. Medicare cam kết cung cấp dịch vụ y tế chất lượng hàng đầu.";
?>

<section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2><?php echo $title; ?></h2>
            <p><?php echo $description; ?></p>
        </div>
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="assets/img/Thiết kế chưa có tên.png" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left">
                <h3><?php echo $commitment; ?></h3>
                <p class="fst-italic">
                    Chúng tôi luôn lấy sự hài lòng của bệnh nhân làm mục tiêu hàng đầu trong mọi dịch vụ của mình.
                </p>
                <ul>
                    <?php foreach ($details as $detail): ?>
                        <li><i class="bi bi-check-circle"></i> <?php echo $detail; ?></li>
                    <?php endforeach; ?>
                </ul>
                <p>
                    <?php echo $finalNote; ?>
                </p>
            </div>
        </div>
    </div>
</section>
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2025 at 01:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nha_khoa_vidental`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date_slot` int(11) DEFAULT NULL,
  `time_id` int(11) DEFAULT NULL,
  `patient_name` varchar(50) DEFAULT NULL,
  `patient_gender` tinyint(1) DEFAULT NULL,
  `patient_dob` date DEFAULT NULL,
  `patient_phone` varchar(11) DEFAULT NULL,
  `patient_email` varchar(150) DEFAULT NULL,
  `patient_description` varchar(500) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `result` varchar(500) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `service_id`, `employee_id`, `date_slot`, `time_id`, `patient_name`, `patient_gender`, `patient_dob`, `patient_phone`, `patient_email`, `patient_description`, `status`, `result`, `update_at`, `update_by`, `created_at`) VALUES
(1, 1, 1, 2, 20001, 1, 'Nguyễn Minh Anh', 0, '2000-05-12', '0912345678', 'minhanh@example.com', 'Đau răng hàm dưới bên phải, khó nhai', 2, NULL, NULL, NULL, '2025-01-01 08:10:00'),
(2, 2, 2, 3, 20001, 3, 'Trần Hoàng Long', 1, '1998-09-23', '0987654321', 'longth@example.com', 'Răng ố vàng, muốn cạo vôi và đánh bóng', 2, NULL, NULL, NULL, '2025-01-01 09:00:00'),
(3, 1, 4, 2, 20002, 5, 'Nguyễn Minh Anh', 0, '2000-05-12', '0912345678', 'minhanh@example.com', 'Răng sâu nhỏ, cần trám răng thẩm mỹ', 1, NULL, NULL, NULL, '2025-01-02 10:00:00'),
(4, 4, 1, 8, 20465, 3, 'Tạ Huyền', 0, '2004-02-18', '0378283197', '25a4041853@hvnh.edu.vn', '', 1, NULL, '2025-12-14 04:19:00', 1, '2025-12-12 15:44:53'),
(5, 4, 2, 3, 20496, 5, 'Tạ Huyền', 0, '2004-02-18', '0378283197', '25a4041853@hvnh.edu.vn', '10h30', 3, NULL, '2025-12-14 04:19:41', 1, '2025-12-12 16:06:27'),
(11, 4, 2, 10, 20555, 14, 'Tạ Huyền', 0, '2004-02-18', '0378283197', '25a4041853@hvnh.edu.vn', '', 1, NULL, '2025-12-14 18:30:59', 1, '2025-12-14 17:55:54'),
(12, 1, 1, 8, 20524, 2, 'Nguyễn Minh Anh', 0, '2000-05-12', '0912345678', 'minhanh@example.com', '', 0, NULL, NULL, NULL, '2025-12-14 18:41:01'),
(13, 5, 5, 7, 20524, 10, 'Nguyễn Đức Minh', 1, '2004-08-09', '0705311047', '25a4041853@hvnh.edu.vn', '', 0, NULL, NULL, NULL, '2025-12-14 19:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`patient_id`, `name`, `password`, `dob`, `gender`, `address`, `phone`, `email`, `status`, `create_at`, `update_by`, `update_at`) VALUES
(1, 'Nguyễn Minh Anh', '$2b$12$GAnsAgEVKwR/2h2jaxWvFuF6Cs1y8K.Y0.4wkG0wOrrKroTxPMd2G', '2000-05-12', 0, 'Số 10 Phạm Hùng, Nam Từ Liêm, Hà Nội', '0912345678', 'minhanh@example.com', 1, '2025-01-01 08:00:00', NULL, NULL),
(2, 'Trần Hoàng Long', '$2b$12$GAnsAgEVKwR/2h2jaxWvFuF6Cs1y8K.Y0.4wkG0wOrrKroTxPMd2G', '1998-09-23', 1, 'Số 25 Láng Hạ, Đống Đa, Hà Nội', '0987654321', 'longth@example.com', 1, '2025-01-01 08:05:00', NULL, NULL),
(3, 'Tạ Huyền', '$2y$12$nArCB8.C/F/bRAAP4k2v/Om46NXGmp1IyGr1vvnQvnNhgRsMJiBii', NULL, NULL, NULL, '0228877688', NULL, 1, NULL, NULL, NULL),
(4, 'Tạ Huyền', '$2y$12$BnB5bXyuDWcCXgJq4EgeGOvByE2S6oS6HX4fBpbH2hWFWnX1SGAZa', '2004-02-18', 0, '41, ngõ 41, Thái Hà, Đống Đa, Hà Nội', '0378283197', '25a4041853@hvnh.edu.vn', 1, NULL, NULL, NULL),
(5, 'Nguyễn Đức Minh', '$2y$12$ncSupTnkbLRoDKPmJSIxP.KZA4Wz4QB13/b1/lARuhoNfvMWb22Vq', '2004-08-09', 1, 'Bạch Mai - Hà Nội', '0705311047', '25a4041853@hvnh.edu.vn', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `position_id` int(11) DEFAULT NULL,
  `employee_code` varchar(55) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avt` varchar(250) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `role_id`, `service_id`, `position_id`, `employee_code`, `name`, `password`, `avt`, `phone`, `email`, `dob`, `gender`, `address`, `status`, `create_at`, `update_at`, `update_by`) VALUES
(1, 1, NULL, 4, 'ADMIN', 'Admin', '$2b$12$N75316KFAH.AI3qNI3LFeepCemtiKObSfSBo3OxNd4gNGyMY0yYBi', 'https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg', '0900000000', 'admin@vidental.vn', '1995-01-01', 1, 'Hà Nội', 1, '2025-01-01 08:00:00', NULL, NULL),
(2, 2, 5, 1, 'BS001', 'BS. Nguyễn Quốc Dũng', '$2y$10$K3WT4.jnF7wCXsTQ0YS0feJgH/Wd/57.UBpC2f3Xe7Nf2ifdZCJKe', 'https://res.cloudinary.com/dnp6p86dp/image/upload/v1765619569/kg3jrhnzhtvdrdjl9c0m.jpg', '0911111111', 'dung.nguyen@vidental.vn', '1988-04-20', 1, 'Số 15 Trần Duy Hưng, Cầu Giấy, Hà Nội', 1, '2025-01-01 08:10:00', '2025-12-13 16:52:50', 1),
(3, 2, 5, 1, 'BS002', 'BS. Trần Thu Hằng', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/dnp6p86dp/image/upload/v1765619620/czt2hx22y2ohbfbnixuc.jpg', '0922222222', 'hang.tran@vidental.vn', '1990-09-15', 0, 'Số 21 Kim Mã, Ba Đình, Hà Nội', 1, '2025-01-01 08:15:00', '2025-12-13 17:33:53', 1),
(4, 3, NULL, 3, 'TV001', 'Nguyễn Hải Yến', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553560/tuvan1.jpg', '0933333333', 'yen.nguyen@vidental.vn', '1999-03-22', 0, 'Số 5 Lê Đức Thọ, Nam Từ Liêm, Hà Nội', 1, '2025-01-01 08:20:00', NULL, 1),
(5, 2, 3, 1, 'BS003', 'BS. Phạm Minh Quân', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553800/dentist3.jpg', '0912340003', 'quan.pham@vidental.vn', '1987-07-15', 1, 'Cầu Giấy, Hà Nội', 1, '2025-12-11 22:19:47', NULL, 1),
(6, 2, 4, 1, 'BS004', 'BS. Lê Thu Trang', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553801/dentist4.jpg', '0912340004', 'trang.le@vidental.vn', '1991-03-22', 0, 'Ba Đình, Hà Nội', 1, '2025-12-11 22:19:47', NULL, 1),
(7, 2, 5, 1, 'BS005', 'BS. Nguyễn Hải Nam', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553802/dentist5.jpg', '0912340005', 'nam.nguyen@vidental.vn', '1989-11-05', 1, 'Thanh Xuân, Hà Nội', 1, '2025-12-11 22:19:47', NULL, 1),
(8, 2, 1, 1, 'BS006', 'BS. Phạm Thùy Anh', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/dnp6p86dp/image/upload/v1765622279/zxlq5h69b9imspp0qolq.jpg', '0901116001', 'hang.pham@vidental.vn', '1992-04-10', 0, 'Hai Bà Trưng, Hà Nội', 1, '2025-12-11 22:43:41', '2025-12-13 17:38:00', 1),
(9, 2, 1, 1, 'BS007', 'BS. Trần Quốc Khánh', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/dnp6p86dp/image/upload/v1765619512/cccvuu7mgqoncori5wyv.jpg', '0901116002', 'khanh.tran@vidental.vn', '1986-09-18', 1, 'Long Biên, Hà Nội', 1, '2025-12-11 22:43:41', '2025-12-13 16:51:53', 1),
(10, 2, 2, 1, 'BS008', 'BS. Nguyễn Thu Phương', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/dnp6p86dp/image/upload/v1765622597/p2i6le0egwdms6rsiksl.jpg', '0901116003', 'phuong.nguyen@vidental.vn', '1993-01-25', 0, 'Đống Đa, Hà Nội', 1, '2025-12-11 22:43:41', '2025-12-13 17:43:19', 1),
(11, 2, 3, 1, 'BS010', 'BS. Vũ Thị Hạnh', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553905/dentist10.jpg', '0901116005', 'hanh.vu@vidental.vn', '1990-11-30', 0, 'Nam Từ Liêm, Hà Nội', 1, '2025-12-11 22:43:41', NULL, 1),
(12, 2, 3, 1, 'BS011', 'BS. Hoàng Anh Tú', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553906/dentist11.jpg', '0901116006', 'tu.hoang@vidental.vn', '1985-03-19', 1, 'Hoàng Mai, Hà Nội', 1, '2025-12-11 22:43:41', NULL, 1),
(13, 2, 5, 1, 'BS015', 'BS. Trịnh Văn Long', '$2b$12$ROzdLToFqT6XP28uXms5S.AR9N8sEztQtU8/Q4wUSIHTky4Cj0nMi', 'https://res.cloudinary.com/demo/image/upload/v1733553910/dentist15.jpg', '0901116010', 'long.trinh@vidental.vn', '1987-05-27', 1, 'Bắc Từ Liêm, Hà Nội', 1, '2025-12-11 22:43:41', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `name`) VALUES
(1, 'Bác sĩ nha khoa'),
(2, 'Phụ tá nha khoa'),
(3, 'Lễ tân / Tư vấn'),
(4, 'Quản lý cơ sở');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'admin', 'Quản trị hệ thống'),
(2, 'employee', 'Chuyên viên'),
(3, 'consultant', 'Nhân viên tư vấn');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `price` int(11) NOT NULL,
  `update_at` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `description`, `price`, `update_at`, `update_by`, `create_at`, `status`) VALUES
(1, 'Khám răng tổng quát', 'Khám, chụp phim và tư vấn tổng quát về tình trạng răng miệng.', 150000, NULL, 1, '2025-01-01 08:00:00', 1),
(2, 'Cạo vôi & đánh bóng răng', 'Loại bỏ mảng bám, vôi răng và đánh bóng bề mặt răng.', 350000, NULL, 1, '2025-01-01 08:05:00', 1),
(3, 'Nhổ răng thường', 'Nhổ răng sâu, răng lung lay mức độ nhẹ đến trung bình.', 500000, NULL, 1, '2025-01-01 08:10:00', 1),
(4, 'Trám răng thẩm mỹ', 'Trám răng sâu bằng vật liệu thẩm mỹ, màu sắc giống răng thật.', 600000, NULL, 1, '2025-01-01 08:15:00', 1),
(5, 'Tư vấn chỉnh nha (niềng răng)', 'Thăm khám, tư vấn và lập phác đồ chỉnh nha.', 200000, NULL, 1, '2025-01-01 08:20:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `time_id` int(11) NOT NULL,
  `slot_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `time_slots`
--

INSERT INTO `time_slots` (`time_id`, `slot_time`) VALUES
(1, '08:00:00'),
(2, '08:30:00'),
(3, '09:00:00'),
(4, '09:30:00'),
(5, '10:00:00'),
(6, '10:30:00'),
(7, '11:00:00'),
(8, '13:00:00'),
(9, '13:30:00'),
(10, '14:00:00'),
(11, '14:30:00'),
(12, '15:00:00'),
(13, '15:30:00'),
(14, '16:00:00'),
(15, '16:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `specialty_id` (`service_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `date_id` (`date_slot`),
  ADD KEY `time_id` (`time_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD KEY `specialty_id` (`service_id`),
  ADD KEY `position_id` (`position_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`time_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`),
  ADD CONSTRAINT `appointments_ibfk_5` FOREIGN KEY (`time_id`) REFERENCES `time_slots` (`time_id`),
  ADD CONSTRAINT `fk_appointments_customers` FOREIGN KEY (`patient_id`) REFERENCES `customers` (`patient_id`) ON UPDATE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`),
  ADD CONSTRAINT `employees_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

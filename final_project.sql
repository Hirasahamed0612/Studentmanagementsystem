-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 08:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(200) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`, `ins_id`) VALUES
(6, '2022 Batch', 4),
(7, '2021', 5),
(8, '2022', 5);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `com_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `heading` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`com_id`, `stu_id`, `heading`, `description`, `timestamp`, `status`, `ins_id`) VALUES
(24, 21, 'Hostel', 'Hostel fans are not working', '2023-11-15 23:29:15', 'Solved', 5);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `c_id` int(11) NOT NULL,
  `course_name` varchar(250) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`c_id`, `course_name`, `lecturer_id`, `ins_id`) VALUES
(17, 'HND in ICT', 13, 4),
(18, 'HND Civil', 13, 4),
(19, 'BICT', 14, 5),
(20, 'Civil', 15, 5);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `d_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`d_id`, `name`) VALUES
(4, 'Ampara'),
(5, 'Anuradhapura'),
(6, 'Badulla'),
(7, 'Batticaloa'),
(8, 'Colombo'),
(9, 'Galle'),
(10, 'Gampaha'),
(11, 'Hambantota'),
(12, 'Jaffna'),
(13, 'Kalutara'),
(14, 'Kandy'),
(15, 'Kegalle'),
(16, 'Kilinochchi'),
(17, 'Kurunegala'),
(18, 'Mannar'),
(19, 'Matale'),
(20, 'Matara'),
(21, 'Monaragala'),
(22, 'Mullaitivu'),
(23, 'Nuwara Eliya'),
(24, 'Polonnaruwa'),
(25, 'Puttalam'),
(26, 'Ratnapura'),
(27, 'Trincomalee'),
(28, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `ex_id` int(11) NOT NULL,
  `exam_name` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`ex_id`, `exam_name`, `date`, `batch_id`, `course_id`, `ins_id`) VALUES
(6, 'First Year', '2022-10-20', 6, 17, 4),
(7, 'First year', '2022-10-21', 6, 18, 4),
(12, 'First Semester', '2023-11-17', 7, 19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `exam_subjects`
--

CREATE TABLE `exam_subjects` (
  `exs_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_subjects`
--

INSERT INTO `exam_subjects` (`exs_id`, `exam_id`, `sub_id`) VALUES
(11, 6, 30),
(12, 6, 31),
(13, 7, 32),
(14, 7, 33),
(19, 12, 34),
(20, 12, 35);

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `ins_id` int(11) NOT NULL,
  `ins_name` varchar(250) NOT NULL,
  `district` int(11) NOT NULL,
  `city` varchar(150) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`ins_id`, `ins_name`, `district`, `city`, `address`, `contact_no`, `email`, `image`) VALUES
(4, 'Bcas Kalmunai', 4, 'Kalmunai', '15 Old Road, Kalmunai', '07587475662', 'bcaskalmunai@yahoo.com', 'http://localhost/final/assets/images/inrfx1%20(1).png'),
(5, 'South Eastern University', 4, 'oluvil', 'ol', '1765656', 'susl@gmail.com', 'http://localhost/final/assets/images/1231.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `l_id` int(11) NOT NULL,
  `lecturer_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `image` varchar(500) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`l_id`, `lecturer_name`, `email`, `contact_no`, `image`, `ins_id`) VALUES
(13, 'K. Faleel', 'faleel@yahoo.com', '0778589647', 'http://localhost/final/assets/images/default.png', 4),
(14, 'Uruthiran', 'uruthiran@gmail.com', '7584', 'http://localhost/final/assets/images/istockphoto-1335941248-170667a.jpg', 5),
(15, 'Asanka', 'asanka@gmail.com', '755', 'http://localhost/final/assets/images/20211213_Vegas-tanner.jpg_600x600_q75_autocrop_crop-smart_upscale.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `m_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `marks` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`m_id`, `exam_id`, `stu_id`, `sub_id`, `marks`) VALUES
(11, 7, 16, 32, '80'),
(12, 7, 16, 33, '100'),
(19, 12, 21, 34, '15'),
(20, 12, 21, 35, '20');

-- --------------------------------------------------------

--
-- Table structure for table `paid_details`
--

CREATE TABLE `paid_details` (
  `pay_update_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `paid_date` date NOT NULL,
  `u_user` int(11) DEFAULT NULL,
  `u_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paid_details`
--

INSERT INTO `paid_details` (`pay_update_id`, `payment_id`, `stu_id`, `status`, `paid_date`, `u_user`, `u_timestamp`) VALUES
(20, 14, 15, 'Paid', '2023-11-17', 154, '2023-11-15 22:13:15'),
(21, 15, 21, 'Paid', '2023-11-15', 155, '2023-11-15 23:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `payment_name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `amount` double(7,2) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `payment_name`, `description`, `due_date`, `amount`, `batch_id`, `course_id`, `ins_id`) VALUES
(13, 'renewal fee', '<p>Renewal fee</p>\r\n', '2023-11-18', 6500.00, 6, 18, 4),
(14, 'Exam Fee', '<p>Exam fee</p>\r\n', '2023-11-24', 4500.00, 6, 17, 4),
(15, 'Renewal feee', '<p>renewal fee</p>\r\n', '2023-11-16', 10000.00, 7, 19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(10) NOT NULL,
  `post_heading` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `u_timestamp` datetime NOT NULL,
  `u_user` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_heading`, `description`, `date`, `u_timestamp`, `u_user`, `ins_id`) VALUES
(13, 'Test Post', '<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device.</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n', '2023-07-12', '2023-07-12 15:29:27', 154, 4),
(14, 'Test Post', '<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</span></span></p>\r\n\r\n<p><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,sans-serif\">Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device.</span></span></p>\r\n\r\n<p>&nbsp;</p>\r\n', '2023-11-16', '2023-11-15 23:25:34', 155, 5);

-- --------------------------------------------------------

--
-- Table structure for table `post_attachments`
--

CREATE TABLE `post_attachments` (
  `at_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `attachment` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_attachments`
--

INSERT INTO `post_attachments` (`at_id`, `post_id`, `attachment`) VALUES
(21, 13, 'http://localhost/final/assets/images/about-banner.jpg'),
(22, 13, 'http://localhost/final/assets/images/backgroundimage-1024x683.jpg'),
(23, 14, 'http://localhost/final/assets/images/1231.jpg'),
(24, 14, 'http://localhost/final/assets/images/20211213_Vegas-tanner.jpg_600x600_q75_autocrop_crop-smart_upscale.jpg'),
(25, 14, 'http://localhost/final/assets/images/backgroundimage-1024x683.jpg'),
(26, 14, 'http://localhost/final/assets/images/about-banner.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stu_id` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `student_name` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `image` varchar(300) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `batch_id` int(11) NOT NULL,
  `ins_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stu_id`, `registration_no`, `student_name`, `email`, `password`, `image`, `course_id`, `batch_id`, `ins_id`) VALUES
(14, 'ICT/01', 'MNM. Nusree', '', '', '', 17, 6, 4),
(15, 'ICT/02', 'H. Haseen', 'haseen@gmail.com', '$2y$10$jlRYoKlNuuwS60/y8L8Zau2ubjqmTnfPNztTGvBNNRTFZVHWuX5p6', 'http://localhost/final/assets/images/20211213_Vegas-tanner.jpg_600x600_q75_autocrop_crop-smart_upscale.jpg', 17, 6, 4),
(16, 'CIV/01', 'K. Rifai', '', '', '', 18, 6, 4),
(17, 'CIV/02', 'T. Ali Risa', '', '', '', 18, 6, 4),
(21, '2021/01', 'Afrin', 'afrin@gmail.com', '$2y$10$Le/gIw/L0JDMtNX3TiGiFOqojKQ7dBBl2YFuvGA0KcGDdt9hobIXu', 'http://localhost/final/assets/images/istockphoto-1365223878-170667a.jpg', 19, 7, 5),
(22, '2022/01', 'Arham', 'arham222@gmail.com', '$2y$10$yjnBTuRMtFH.LzshQdpxXODuh5CAdDdx/d.zLfvVHDsvOiPFwyVlS', 'http://localhost/final/assets/images/20211213_Vegas-tanner.jpg_600x600_q75_autocrop_crop-smart_upscale.jpg', 19, 8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_id` int(11) NOT NULL,
  `subject_name` varchar(250) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sub_id`, `subject_name`, `course_id`) VALUES
(30, 'Introduction to ICT', 17),
(31, 'Basic Access', 17),
(32, 'Basic Civils', 18),
(33, 'Calculations', 18),
(34, 'Basic Mathematics ', 19),
(35, 'Communication Skills', 19),
(36, 'Surveying ', 20),
(37, 'Advance Mathematics', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `type` varchar(12) NOT NULL,
  `password` varchar(800) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `ins_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `contact_no`, `address`, `email`, `type`, `password`, `status`, `image`, `ins_id`) VALUES
(143, 'Fast', '343', '4343', 'fastinneeded@gmail.com', 'Admin', '$2y$10$OQ8RbkDWt6nAeziQtfXOQ.8XxePO/RjqW9tjgNaJaXhLHVpbQWHFS', 'Active', 'http://localhost/final/assets/images/4.jpg', NULL),
(154, 'Nazar', '0768778889', 'kky', 'bcas@gmail.com', 'User', '$2y$10$evc/twiyCsn2oJ6f030hteLU1slSRFiVy.NehTk/OOfxJJLQYPanu', 'Active', 'http://localhost/final/assets/images/default.png', 4),
(155, 'Afrin', '4848', 'fdfd', 'seusl@gmail.com', 'User', '$2y$10$iJJ0uxfBMaRDEOVyTPZ16OX3V.mdkzQiZrV7DAD41s6B4jwMT7zau', 'Active', 'http://localhost/final/assets/images/20211213_Vegas-tanner.jpg_600x600_q75_autocrop_crop-smart_upscale.jpg', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`batch_id`),
  ADD KEY `fk20` (`ins_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `fk40` (`stu_id`),
  ADD KEY `fk41` (`ins_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk4` (`lecturer_id`),
  ADD KEY `fk6` (`ins_id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`ex_id`),
  ADD KEY `fk10` (`batch_id`),
  ADD KEY `fk11` (`ins_id`),
  ADD KEY `fk21` (`course_id`);

--
-- Indexes for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD PRIMARY KEY (`exs_id`),
  ADD KEY `fk22` (`exam_id`),
  ADD KEY `fk23` (`sub_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`ins_id`),
  ADD KEY `fk_29` (`district`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`l_id`),
  ADD KEY `fk2` (`ins_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `fk16` (`sub_id`),
  ADD KEY `fk17` (`stu_id`),
  ADD KEY `fk30` (`exam_id`);

--
-- Indexes for table `paid_details`
--
ALTER TABLE `paid_details`
  ADD PRIMARY KEY (`pay_update_id`),
  ADD KEY `fk36` (`payment_id`),
  ADD KEY `fk35` (`stu_id`),
  ADD KEY `fk37` (`u_user`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk32` (`batch_id`),
  ADD KEY `fk33` (`course_id`),
  ADD KEY `fk34` (`ins_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk25` (`ins_id`),
  ADD KEY `fk26` (`u_user`);

--
-- Indexes for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD PRIMARY KEY (`at_id`),
  ADD KEY `fk28` (`post_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `fk8` (`batch_id`),
  ADD KEY `fk9` (`ins_id`),
  ADD KEY `fk5` (`course_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `fk3` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk1` (`ins_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  MODIFY `exs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `ins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `paid_details`
--
ALTER TABLE `paid_details`
  MODIFY `pay_update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `post_attachments`
--
ALTER TABLE `post_attachments`
  MODIFY `at_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `fk20` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `fk40` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk41` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk4` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`l_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk6` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `fk10` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk11` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk21` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_subjects`
--
ALTER TABLE `exam_subjects`
  ADD CONSTRAINT `fk22` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`ex_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk23` FOREIGN KEY (`sub_id`) REFERENCES `subjects` (`sub_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `institutes`
--
ALTER TABLE `institutes`
  ADD CONSTRAINT `fk_29` FOREIGN KEY (`district`) REFERENCES `districts` (`d_id`);

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `fk16` FOREIGN KEY (`sub_id`) REFERENCES `subjects` (`sub_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk17` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk30` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`ex_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paid_details`
--
ALTER TABLE `paid_details`
  ADD CONSTRAINT `fk35` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk36` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk37` FOREIGN KEY (`u_user`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk32` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk33` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk34` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk25` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk26` FOREIGN KEY (`u_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD CONSTRAINT `fk28` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk5` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk8` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk9` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `fk3` FOREIGN KEY (`course_id`) REFERENCES `courses` (`c_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`ins_id`) REFERENCES `institutes` (`ins_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

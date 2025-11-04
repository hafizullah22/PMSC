-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2025 at 10:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmsc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hints` varchar(256) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `name`, `email`, `password`, `hints`, `created_at`) VALUES
(2, 'Md. Monirul Islam', 'monir@cse.jnu.ac.bd', '$2a$12$6quMGiVyTc1BYQrzFe5vleVJZFSaYs/FAQrG3BCpo7qANciGS.mym', 'JnU@2025', '2025-07-22 03:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `batch_id` int(11) UNSIGNED NOT NULL,
  `batch_name` varchar(100) DEFAULT NULL,
  `session` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`, `session`) VALUES
(1, '18th  Batch', 'Summer-2025'),
(2, '2nd Batch', 'summer-2016'),
(3, '3rd Batch', 'summer-2017'),
(4, '4th batch', 'summer 2019'),
(5, '5th Batch', 'Summer-2021'),
(7, '7th batch ', 'Summer 2021'),
(12, '15th Batch', '');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) UNSIGNED NOT NULL,
  `batch_id` int(11) UNSIGNED NOT NULL,
  `semester_id` int(11) UNSIGNED NOT NULL,
  `exam_year` varchar(9) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `mid_exam_date` date DEFAULT NULL,
  `final_exam_date` date DEFAULT NULL,
  `mid_student_list` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `batch_id`, `semester_id`, `exam_year`, `course_name`, `mid_exam_date`, `final_exam_date`, `mid_student_list`) VALUES
(1, 1, 2, '2025', 'CSE-5300 Bio molecular technologia', '2025-07-24', '2025-07-30', 'M230201014,M230201015'),
(2, 1, 1, '2025', 'CSE-5300 Bio Informatics', NULL, NULL, 'M230201015,M230201017, M230201019, M230201016'),
(4, 1, 1, '2025', 'Internet Security and Policy (CSE-5310)', '2025-07-07', '2025-12-01', 'M230201012,M230201013, M230201014, M230201015,M230201014, M230201015,M230201012, M230201014,\r\nM230201015,M230201012, M230201014, M230201015'),
(5, 1, 3, '2025', 'Project (CSEP-5300)/Thesis (CSET-5300)', '2025-07-01', '2025-08-09', ''),
(6, 1, 3, '2025', 'Software Quality Assurance and Testing (CSE-5309)', '2025-07-31', '2025-09-25', ''),
(7, 1, 2, '2025', 'Software Quality Assurance and Testing (CSE-5309) ', '2025-10-08', '2025-07-29', ''),
(10, 1, 3, '2025', 'Project (CSEP-5300)/Thesis (CSET-5300)', '2025-10-01', '2025-10-15', ''),
(11, 2, 1, '2025', 'Project (CSEP-5300)/Thesis (CSET-5300)', '1970-01-01', '1970-01-01', ''),
(12, 2, 1, '2025', 'Internet Security and Policy (CSE-5310)', '1970-07-02', '1970-01-01', ''),
(13, 2, 1, '2025', 'Internet Security and Policy (CSE-5310)', '2025-07-09', '2025-07-31', ''),
(14, 2, 1, '2025', 'CSE-5300 Bio Information', '2025-07-17', '2025-07-30', ''),
(15, 2, 2, '2025', 'CSE-5300 Bio Information', '2025-07-01', '0000-00-00', ''),
(21, 1, 1, '2025', 'Network Performance analysis (CSE-5112)', '2025-07-16', '0000-00-00', 'M230201015, M230201016'),
(22, 12, 3, '2025', 'CSE-5300 Bio Informatics', NULL, NULL, ''),
(23, 1, 2, '2025', 'CSE-5300 Bio Informatics', NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `course_bank`
--

CREATE TABLE `course_bank` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(256) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_bank`
--

INSERT INTO `course_bank` (`course_id`, `course_name`, `status`) VALUES
(1, 'Advanced Database Management (CSE-5201)', 1),
(3, 'Project (CSEP-5300)/Thesis (CSET-5300)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) UNSIGNED NOT NULL,
  `batch_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `exam_year` int(11) NOT NULL,
  `exam_type` tinyint(2) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `course_id` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `batch_id`, `session_id`, `semester_id`, `exam_year`, `exam_type`, `student_id`, `course_id`, `created_at`) VALUES
(1, 1, 'Summer-2025', 1, 2025, 0, 'M210202121', '[\"2\",\"4\",\"21\"]', '2025-11-04 10:24:12'),
(2, 1, 'Summer-2025', 1, 2025, 0, 'M230201015', '[\"2\",\"4\",\"21\"]', '2025-11-04 10:24:56'),
(3, 1, 'Summer-2025', 1, 2025, 0, 'M210202120', '[\"2\",\"4\",\"21\"]', '2025-11-04 10:24:56'),
(4, 1, 'Summer-2025', 1, 2025, 0, 'M240302014', '[\"2\",\"4\",\"21\"]', '2025-11-04 10:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `retake_list`
--

CREATE TABLE `retake_list` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_list` text NOT NULL,
  `exam_year` varchar(256) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `retake_list`
--

INSERT INTO `retake_list` (`id`, `course_id`, `student_list`, `exam_year`, `status`) VALUES
(1, 1, 'M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015', 'July-2025', 1),
(7, 3, 'M230102014', 'July-2025', 1),
(8, 4, 'M230102014', 'July-2025', 1),
(10, 5, 'M230102014, M230102015, M230102015,', 'December-2025', 1),
(11, 6, 'M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015,M230201012, M230201014, M230201015', 'July-2026', 1),
(12, 1, 'M230102014,M230102015', 'July-2025', 1);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` int(11) UNSIGNED NOT NULL,
  `semester_id` int(11) UNSIGNED NOT NULL,
  `batch_id` int(11) UNSIGNED NOT NULL,
  `jnu_amount` decimal(10,2) DEFAULT 0.00,
  `miscellaneous_amount` decimal(10,2) DEFAULT 0.00,
  `seminar_amount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `semester_id`, `batch_id`, `jnu_amount`, `miscellaneous_amount`, `seminar_amount`) VALUES
(1, 1, 1, 40500.00, 4000.00, 4000.00),
(2, 2, 1, 40500.00, 4000.00, 4000.00),
(3, 3, 1, 49500.00, 4000.00, 4000.00),
(4, 1, 2, 50500.00, 4000.00, 4000.00),
(5, 2, 2, 40500.00, 4000.00, 4000.00),
(6, 3, 2, 49500.00, 4000.00, 4000.00),
(9, 1, 3, 40500.00, 4000.00, 4000.00);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) UNSIGNED NOT NULL,
  `std_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `batch_id` int(11) UNSIGNED NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `std_id`, `name`, `batch_id`, `phone`, `email`, `image`) VALUES
(1, 'M210202121', 'Md. Hafiz Ullah', 1, '01723411403', 'admin@mail.com', 'batch-1/M210202121.jpg'),
(2, 'M230201012', 'Jannatul Tasnim', 1, '01689932507', 'tasnim@gmail.com', NULL),
(3, 'M230201013', 'Shakil Khan', 1, '01724123456', 'shakil@gmail.com', 'batch-1/M230201013.JPG'),
(4, 'B230201014', 'Biplob Biswas', 1, '01782453120', 'biplob@gmail.com', NULL),
(5, 'M230201015', 'Rahim Afroz', 1, '01723411409', 'rahim_afroz@gmail.com', NULL),
(6, 'M210202120', 'Rahim KHan', 1, '01580318192', 'rahim@gmail.com', NULL),
(7, 'M240302012', 'Afzal Khan', 2, '01580318195', 'mobarokhossin2@gmail.com', NULL),
(8, 'M210202122', 'John Doe', 1, '01700000000', 'john@example.com', NULL),
(9, 'M210202123', 'Jane Smith', 1, '01800000001', 'jane@example.com', NULL),
(10, 'M240302014', 'nizmu Khan', 1, '01800000004', 'nizmu@gmail.com', NULL),
(11, 'M210202102', 'Rahim Khan', 12, '01800000000', 'as@gmail.com', NULL),
(12, '1001', 'John Doe', 12, '01700000000', 'john@example.com', NULL),
(13, '1002', 'Jane Smith', 12, '01800000000', 'jane@example.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `semester_id` varchar(50) NOT NULL,
  `receipt_no_jnu` varchar(100) DEFAULT NULL,
  `JnU_Amount` decimal(10,2) DEFAULT 0.00,
  `receipt_no_misc` varchar(100) DEFAULT NULL,
  `miscellaneous_amount` decimal(10,2) DEFAULT 0.00,
  `receipt_no_seminar` varchar(100) DEFAULT NULL,
  `Seminar_amount` decimal(10,2) DEFAULT 0.00,
  `waiver` int(11) NOT NULL DEFAULT 0,
  `waiver_comment` text NOT NULL,
  `transaction_date` date NOT NULL,
  `entry_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `student_id`, `semester_id`, `receipt_no_jnu`, `JnU_Amount`, `receipt_no_misc`, `miscellaneous_amount`, `receipt_no_seminar`, `Seminar_amount`, `waiver`, `waiver_comment`, `transaction_date`, `entry_date`) VALUES
(2, 'M210202121', '2', 'JnU12346', 900.00, '0', 500.00, '0', 0.00, 4100, '', '2025-07-10', '2025-07-10'),
(4, 'M210202121', '2', 'JnU12347', 40000.00, '', 0.00, '', 0.00, 0, '', '2025-07-10', '2025-07-10'),
(7, 'M210202121', '1', 'JnU12349', 4500.00, '', 2000.00, '', 2000.00, 0, '', '2025-07-10', '2025-07-10'),
(8, 'M230201012', '1', 'JnU23410', 30500.00, 'mis 12348', 4000.00, 'semi12340', 4000.00, 0, '', '2025-07-12', '2025-07-12'),
(9, 'M210202121', '1', 'JnU23456', 40000.00, '', 0.00, '', 0.00, 0, '', '2025-07-13', '2025-07-13'),
(12, 'M210202121', '3', 'JnU220304', 6000.00, '', 0.00, '', 0.00, 0, '', '2025-07-13', '2025-07-13'),
(13, 'M230201012', '2', 'JnU220305', 4000.00, 'mis220305 ', 1205.00, 'semi220305', 0.00, 0, '', '2025-07-13', '2025-07-13'),
(14, 'M230201012', '2', 'JnU220306', 5000.00, '', 0.00, '', 0.00, 0, '', '2025-07-12', '2025-07-13'),
(16, 'M230201013', '2', 'JnU896523', 12000.00, '', 0.00, '', 0.00, 0, '', '2025-07-15', '2025-07-15'),
(17, 'M210202121', '3', 'JnU789501', 37000.00, '', 0.00, '', 0.00, 2000, '', '2025-07-15', '2025-07-15'),
(18, 'M230201013', '3', 'JNU58642', 500.00, '', 0.00, '', 0.00, 2000, '', '2025-07-17', '2025-07-17'),
(20, 'M210202122', '1', 'JnUP09879', 40000.00, '', 0.00, '', 0.00, 0, '', '2025-07-18', '2025-07-18'),
(21, 'M240302012', '1', 'JnU9845ppp', 40000.00, 'mis12we', 4000.00, 'sem234', 4000.00, 0, '', '2025-07-18', '2025-07-18'),
(22, 'M240302014', '1', 'JnU23456p', 40000.00, 'mis 12345o', 4000.00, 'sem234o', 4000.00, 0, '', '2025-07-18', '2025-07-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `semester_id` (`semester_id`);

--
-- Indexes for table `course_bank`
--
ALTER TABLE `course_bank`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_enrollment` (`batch_id`,`session_id`,`semester_id`,`exam_year`,`exam_type`,`student_id`);

--
-- Indexes for table `retake_list`
--
ALTER TABLE `retake_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `std_id` (`std_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `unique_receipt_no` (`receipt_no_jnu`,`receipt_no_misc`,`receipt_no_seminar`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `batch_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `course_bank`
--
ALTER TABLE `course_bank`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `retake_list`
--
ALTER TABLE `retake_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`);

--
-- Constraints for table `semester`
--
ALTER TABLE `semester`
  ADD CONSTRAINT `semester_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`std_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

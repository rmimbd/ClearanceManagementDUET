-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: fdb27.runhosting.com
-- Generation Time: Dec 05, 2023 at 08:11 AM
-- Server version: 5.7.40-log
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `4180147_dcs`
--
CREATE DATABASE IF NOT EXISTS `4180147_dcs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `4180147_dcs`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `designation` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `office_id` int(4) DEFAULT NULL,
  `active` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `name`, `designation`, `office_id`, `active`) VALUES
(1, 'M.I.M', NULL, 40, 1),
(12345, 'Mr. ABC', 'Officer In Charge', 4, 1),
(20001, 'Dr. H. I. Chowdhury', 'Professor', 2, 1),
(30001, 'Dr. A. C', 'Professor', 3, 1),
(40001, 'Dr. G.H. Khan', 'Professor', 4, 1),
(40002, 'Dr. P. I.', 'Associate Professor', 4, 1),
(44686, 'Dr. YC', 'Professor', 4, 1),
(49001, 'Lab Assistant 1', 'Lab Assistant', 4, 1),
(49002, 'Lab Assistant 2', 'Lab Assistant', 4, 1),
(49003, 'Lab In Charge', 'Lab In Charge', 4, 1),
(54321, 'Mr. AAA', 'Section Officer', 21, 1),
(54322, 'Test User', 'Test User Designation', 21, 0);

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `add_new_user2` AFTER INSERT ON `admin` FOR EACH ROW INSERT INTO combined_users VALUES(new.user_id, 2)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_user2` AFTER DELETE ON `admin` FOR EACH ROW DELETE FROM combined_users WHERE user_id=old.user_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user2` AFTER UPDATE ON `admin` FOR EACH ROW UPDATE combined_users SET user_id=new.user_id WHERE user_id=old.user_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `approver`
--

CREATE TABLE `approver` (
  `approver_id` int(5) NOT NULL,
  `level` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `approver`
--

INSERT INTO `approver` (`approver_id`, `level`) VALUES
(12345, 1),
(54321, 11);

-- --------------------------------------------------------

--
-- Table structure for table `approver_category`
--

CREATE TABLE `approver_category` (
  `level` int(2) NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `approver_category`
--

INSERT INTO `approver_category` (`level`, `type`) VALUES
(1, 'Section Officer, Exam Controller'),
(2, 'Assistant Section Officer, Hall'),
(3, 'Provost, Hall'),
(4, 'Labs'),
(5, 'Assistant Section Officer, Department'),
(6, 'Thesis Supervisor'),
(7, 'Head of the Department'),
(8, 'Administrative offices'),
(9, 'Assistant DSW'),
(10, 'DSW'),
(11, 'Deputy Exam Controller');

-- --------------------------------------------------------

--
-- Table structure for table `clearance`
--

CREATE TABLE `clearance` (
  `clearance_id` int(10) UNSIGNED NOT NULL,
  `student_id` int(6) DEFAULT NULL,
  `approved_level` int(2) NOT NULL DEFAULT '0',
  `so_exam_controller` int(1) NOT NULL DEFAULT '0',
  `aso_hall` int(1) NOT NULL DEFAULT '0',
  `provost` int(1) NOT NULL DEFAULT '0',
  `labs` int(1) NOT NULL DEFAULT '0',
  `aso_department` int(1) NOT NULL DEFAULT '0',
  `thesis_supervisor` int(1) NOT NULL DEFAULT '0',
  `head_department` int(1) NOT NULL DEFAULT '0',
  `exam_controller` int(1) DEFAULT '0',
  `comptroller` int(1) NOT NULL DEFAULT '0',
  `medical_center` int(1) NOT NULL DEFAULT '0',
  `computer_center` int(1) NOT NULL DEFAULT '0',
  `physical_edu_center` int(1) NOT NULL DEFAULT '0',
  `central_library` int(1) NOT NULL DEFAULT '0',
  `assistant_dsw` int(1) NOT NULL DEFAULT '0',
  `dsw` int(1) NOT NULL DEFAULT '0',
  `deputy_exam_controller` int(1) NOT NULL DEFAULT '0',
  `final_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`clearance_id`, `student_id`, `approved_level`, `so_exam_controller`, `aso_hall`, `provost`, `labs`, `aso_department`, `thesis_supervisor`, `head_department`, `exam_controller`, `comptroller`, `medical_center`, `computer_center`, `physical_edu_center`, `central_library`, `assistant_dsw`, `dsw`, `deputy_exam_controller`, `final_status`) VALUES
(2022172000, 172000, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2022174000, 174000, 11, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1),
(2022194089, 194089, 5, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2022194105, 194105, 7, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `combined_users`
--

CREATE TABLE `combined_users` (
  `user_id` int(6) NOT NULL,
  `user_type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `combined_users`
--

INSERT INTO `combined_users` (`user_id`, `user_type`) VALUES
(1, 0),
(12345, 2),
(20001, 2),
(30001, 2),
(40001, 2),
(40002, 2),
(44686, 2),
(49001, 2),
(49002, 2),
(49003, 2),
(54321, 2),
(54322, 2),
(172000, 1),
(174000, 1),
(192030, 1),
(194071, 1),
(194089, 1),
(194105, 1),
(194106, 1),
(194111, 1);

--
-- Triggers `combined_users`
--
DELIMITER $$
CREATE TRIGGER `add_new_user3` AFTER INSERT ON `combined_users` FOR EACH ROW INSERT INTO users(user_id, user_type) VALUES (new.user_id, new.user_type)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(2) NOT NULL,
  `department_name` varchar(40) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'CE'),
(2, 'EEE'),
(3, 'ME'),
(4, 'CSE'),
(5, 'TE'),
(6, 'ARCH'),
(7, 'IPE'),
(8, 'CFE'),
(9, 'MME');

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `hall_id` int(2) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `short_name` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `provost` int(6) DEFAULT NULL,
  `a_provost1` int(6) DEFAULT NULL,
  `a_provost2` int(6) DEFAULT NULL,
  `a_provost3` int(6) DEFAULT NULL,
  `a_provost4` int(6) DEFAULT NULL,
  `a_section_officer` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`hall_id`, `name`, `short_name`, `provost`, `a_provost1`, `a_provost2`, `a_provost3`, `a_provost4`, `a_section_officer`) VALUES
(1, 'Dr. Fazlur Rahman Khan Hall', 'FR Khan Hall', 40001, NULL, NULL, NULL, NULL, 12345),
(2, 'Dr. Qudrat-E-Khuda Hall', 'QK Hall', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Kazi Nazrul Islam Hall', 'KNI Hall', 40001, NULL, NULL, NULL, NULL, 12345),
(4, 'Shahid Muktijodda Hall', 'SM Hall', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Shaheed Tazuddin Ahmad Hall', 'STA Hall', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Madam Curie Hall', 'MC Hall', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `labs`
--

CREATE TABLE `labs` (
  `lab_id` int(4) NOT NULL,
  `department` int(2) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `assistant` int(6) DEFAULT NULL,
  `officer` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `labs`
--

INSERT INTO `labs` (`lab_id`, `department`, `name`, `assistant`, `officer`) VALUES
(2001, 2, 'Communication Lab', NULL, NULL),
(4001, 4, 'Mobile Application Development Lab', 49001, 49003),
(4002, 4, 'Network Lab', 49002, 49003),
(4003, 4, 'IICT-1 Lab', 49001, 49003);

-- --------------------------------------------------------

--
-- Table structure for table `labs_approve_log`
--

CREATE TABLE `labs_approve_log` (
  `sl` bigint(20) NOT NULL,
  `clearance_id` int(10) UNSIGNED DEFAULT NULL,
  `department_id` int(2) DEFAULT NULL,
  `lab_id` int(4) DEFAULT NULL,
  `assistant_approved` int(1) DEFAULT '0',
  `officer_approved` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `labs_approve_log`
--

INSERT INTO `labs_approve_log` (`sl`, `clearance_id`, `department_id`, `lab_id`, `assistant_approved`, `officer_approved`) VALUES
(5, 2022194105, 4, 4001, 1, 1),
(6, 2022194105, 4, 4002, 1, 1),
(7, 2022174000, 4, 4001, 1, 1),
(9, 2022174000, 4, 4002, 1, 1),
(10, 2022172000, 2, 2001, 0, 0),
(11, 2022194089, 4, 4001, 1, 1),
(12, 2022194089, 4, 4002, 1, 1),
(13, 2022194089, 4, 4003, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `office_id` int(4) NOT NULL,
  `office_name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `administrative_head` int(6) DEFAULT NULL,
  `head_officer` int(6) DEFAULT NULL,
  `office_loc` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`office_id`, `office_name`, `administrative_head`, `head_officer`, `office_loc`) VALUES
(1, 'Department of CE', NULL, NULL, ''),
(2, 'Department of EEE', 20001, NULL, ''),
(3, 'Department of ME', NULL, NULL, ''),
(4, 'Department of CSE', 40001, 12345, '3rd Floor, Old Academic Building'),
(20, 'Academic Section', 40001, NULL, 'Old Academic Building, Room #210'),
(21, 'Office of the Controller of Examinations', 40001, 12345, NULL),
(22, 'Office of the Comptroller', 40001, 12345, NULL),
(23, 'Medical Center', 40001, 12345, NULL),
(24, 'Computer Center', 40001, 12345, NULL),
(25, 'Physical Education Center', NULL, NULL, ''),
(26, 'Central Library', NULL, NULL, ''),
(27, 'Office of the DSW', NULL, NULL, ''),
(40, 'ICT Cell', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` bigint(14) NOT NULL,
  `student_id` int(6) NOT NULL,
  `issuer` int(6) NOT NULL,
  `issuer_office` int(4) DEFAULT NULL,
  `issue_date` datetime NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `description` varchar(1000) COLLATE utf8mb4_bin DEFAULT NULL,
  `report_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `site_strings`
--

CREATE TABLE `site_strings` (
  `name` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `for_user_type` int(2) NOT NULL DEFAULT '0',
  `value` varchar(300) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `site_strings`
--

INSERT INTO `site_strings` (`name`, `for_user_type`, `value`) VALUES
('site_title', 0, 'DUET Clearance Approval System'),
('university_name', 0, 'Dhaka University of Engineering & Technology, Gazipur'),
('text_help', 0, 'Help'),
('text_terms_conditions', 0, 'Terms & Conditions'),
('text_contact_us', 0, 'Contact Us'),
('text_quick_links', 0, 'Quick Links'),
('text_admin_panel', 0, 'Admin Panel'),
('text_main_website', 0, 'DUET Main Website'),
('login_form_title', 0, 'WELCOME'),
('login_form_submit_button', 0, 'Sign In'),
('login_form_username_placeholder', 0, 'Username or ID'),
('login_form_password_placeholder', 0, 'Password'),
('text_log_out', 0, 'Sign Out'),
('invalid_id_or_password', 0, 'Invalid Username/User ID or Password'),
('text_home', 0, 'Home'),
('text_notice', 0, 'Notice'),
('text_reports', 0, 'Reports'),
('clearance_apply_menu_item', 1, 'Apply for Clearance'),
('clearance_apply_submenu_new_application', 1, 'New Application'),
('clearance_apply_submenu_status', 1, 'Application Status'),
('nav_dashboard', 2, 'Dashboard'),
('nav_create_report', 2, 'Create Report'),
('nav_browse_report', 2, 'Browse Report'),
('nav_advising_student_issues', 2, 'Advising Student\'s Issues'),
('nav_clearance_applications', 2, 'Clearance Applications'),
('text_view_report', 0, 'View Report'),
('text_update_report', 2, 'Update Report'),
('text_resolve_report', 2, 'Resolve Report'),
('text_delete_report', 2, 'Delete Report'),
('welcome_greeting', 0, 'Welcome');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(6) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `name_of_father` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `name_of_mother` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8mb4_bin DEFAULT NULL,
  `department_id` int(2) DEFAULT NULL,
  `current_year` int(1) DEFAULT NULL,
  `current_semester` int(1) DEFAULT NULL,
  `session` varchar(9) COLLATE utf8mb4_bin DEFAULT NULL,
  `admission_year` int(4) DEFAULT NULL,
  `advisor` int(6) DEFAULT NULL,
  `thesis_supervisor` int(6) DEFAULT NULL,
  `hall` int(2) DEFAULT NULL,
  `hall_room_number` int(2) DEFAULT NULL,
  `allowed_to_apply` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `name`, `name_of_father`, `name_of_mother`, `gender`, `department_id`, `current_year`, `current_semester`, `session`, `admission_year`, `advisor`, `thesis_supervisor`, `hall`, `hall_room_number`, `allowed_to_apply`) VALUES
(172000, 'Temp Student', NULL, NULL, '1', 2, 4, 2, '2021-2022', 2017, NULL, NULL, 3, NULL, 1),
(174000, 'Student 1', NULL, NULL, '1', 4, 4, 2, '2021-2022', 2019, 40001, 40001, 1, 0, 1),
(192030, 'Mahabul Alam', NULL, NULL, '1', 2, 3, 1, '2021-2022', 2020, 20001, 20001, 5, 7019, 1),
(194071, 'Nayeem Ullah', NULL, NULL, '1', 4, 4, 2, '2022-2023', 2020, 40001, 40001, 2, 304, 1),
(194089, 'Md. Monjurul Islam', NULL, NULL, '1', 4, 4, 2, '2022-2023', 2020, 40001, 40001, 2, 304, 1),
(194105, 'Humayra Farjana', NULL, NULL, '2', 4, 4, 2, NULL, 2020, 40002, 40001, 6, NULL, 1),
(194106, 'Md. Jewel Rana', NULL, NULL, '1', 4, 4, 2, '2022-2023', 2020, 40001, 40001, 2, 304, 1),
(194111, 'Bornali Saha', NULL, NULL, '2', 4, 4, 2, '2021-2022', 2020, NULL, NULL, 6, NULL, 1);

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `add_new_user` AFTER INSERT ON `student` FOR EACH ROW INSERT INTO combined_users VALUES(new.student_id, 1)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_user` AFTER DELETE ON `student` FOR EACH ROW DELETE FROM combined_users WHERE user_id=old.student_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user` AFTER UPDATE ON `student` FOR EACH ROW UPDATE combined_users SET user_id=new.student_id WHERE user_id=old.student_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(6) NOT NULL,
  `username` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `user_type` int(1) NOT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(16) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type`, `email`, `phone`) VALUES
(1, 'admin', 'e00cf25ad42683b3df678c61f42c6bda', 0, NULL, NULL),
(12345, 'mr.abc', 'f92a4742a0c17af252cde821a929fe65', 2, 'mr.abc@duet.ac.bd', '010000089'),
(20001, '', '', 2, 'hichowdhury@duet.ac.bd', ''),
(30001, '', '', 2, '', ''),
(40001, 'dr.ghk', 'c7d04fd36c304ace108b9ca91c2c08a4', 2, '', ''),
(40002, '', '', 2, '', ''),
(44686, 'examcon', 'b47004d2a4c39bf4a544706c4c65aa24', 2, NULL, NULL),
(49001, 'labas1', 'c2ecd816c148ffce1425e6a2c1be8f7d', 2, NULL, NULL),
(49002, 'labas2', 'eda6040adccf33723ad570577e25355b', 2, NULL, NULL),
(49003, 'labin1', '49609727354472e9fc2ccbef1ec7b4ef', 2, NULL, NULL),
(54321, 'tuser2', 'ee8d67eb7f09c3d8db89d395bede0cc0', 2, '', ''),
(54322, '', '', 2, '', ''),
(172000, 'student2', '213ee683360d88249109c2f92789dbc3', 1, '', ''),
(174000, 'student1', '5e5545d38a68148a2d5bd5ec9a89e327', 1, '', ''),
(192030, 'mahabul', '77a3be52017242c22a855100635b0045', 1, '192030@student.duet.ac.bd', '01722431373'),
(194071, 'nayeem', 'f505c3122b948bcb68e4f228fa53cf81', 1, '194071@student.duet.ac.bd', NULL),
(194089, 'rmimbd', 'c66f5f2488992500f1017fed38ca552a', 1, 'rmimbd@yahoo.com', '01717184898'),
(194105, 'humayra', 'fb734adfb14d87586f69b203e06351b5', 1, NULL, NULL),
(194106, 'Rana106', '7d3260a66b0abd74395a3fc41795c043', 1, '194106@student.duet.ac.bd', NULL),
(194111, 'bornali', 'c48aa6bed9d15d8dfb164128aaece9fa', 1, '194111@student.duet.ac.bd', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `office_fk` (`office_id`);

--
-- Indexes for table `approver`
--
ALTER TABLE `approver`
  ADD PRIMARY KEY (`approver_id`),
  ADD KEY `approver_level_fk` (`level`);

--
-- Indexes for table `approver_category`
--
ALTER TABLE `approver_category`
  ADD PRIMARY KEY (`level`);

--
-- Indexes for table `clearance`
--
ALTER TABLE `clearance`
  ADD PRIMARY KEY (`clearance_id`),
  ADD KEY `clearance_student_id_fk` (`student_id`);

--
-- Indexes for table `combined_users`
--
ALTER TABLE `combined_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`hall_id`),
  ADD KEY `provost_fk` (`provost`),
  ADD KEY `a_provost1_fk` (`a_provost1`),
  ADD KEY `a_provost2_fk` (`a_provost2`),
  ADD KEY `a_provost3_fk` (`a_provost3`),
  ADD KEY `a_provost4_fk` (`a_provost4`),
  ADD KEY `a_section_officer_fk` (`a_section_officer`);

--
-- Indexes for table `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `lab_department_fk` (`department`),
  ADD KEY `assistant_fk` (`assistant`),
  ADD KEY `officer_fk` (`officer`);

--
-- Indexes for table `labs_approve_log`
--
ALTER TABLE `labs_approve_log`
  ADD PRIMARY KEY (`sl`),
  ADD KEY `l_clearance_id_fk` (`clearance_id`),
  ADD KEY `l_department_id_fk` (`department_id`),
  ADD KEY `l_lab_id_fk` (`lab_id`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`office_id`),
  ADD KEY `administrative_head_fk` (`administrative_head`),
  ADD KEY `head_officer_fk` (`head_officer`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `reports_student_fk` (`student_id`),
  ADD KEY `reports_issuer_fk` (`issuer`),
  ADD KEY `reports_issuer_office_fk` (`issuer_office`);

--
-- Indexes for table `site_strings`
--
ALTER TABLE `site_strings`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `department_fk` (`department_id`),
  ADD KEY `student_hall_fk` (`hall`),
  ADD KEY `student_advisor_fk` (`advisor`),
  ADD KEY `student_supervisor_fk` (`thesis_supervisor`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `labs_approve_log`
--
ALTER TABLE `labs_approve_log`
  MODIFY `sl` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `office_fk` FOREIGN KEY (`office_id`) REFERENCES `office` (`office_id`);

--
-- Constraints for table `approver`
--
ALTER TABLE `approver`
  ADD CONSTRAINT `Approver_fk` FOREIGN KEY (`approver_id`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `approver_id_fk` FOREIGN KEY (`approver_id`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `approver_level_fk` FOREIGN KEY (`level`) REFERENCES `approver_category` (`level`);

--
-- Constraints for table `clearance`
--
ALTER TABLE `clearance`
  ADD CONSTRAINT `clearance_student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `halls`
--
ALTER TABLE `halls`
  ADD CONSTRAINT `a_provost1_fk` FOREIGN KEY (`a_provost1`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `a_provost2_fk` FOREIGN KEY (`a_provost2`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `a_provost3_fk` FOREIGN KEY (`a_provost3`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `a_provost4_fk` FOREIGN KEY (`a_provost4`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `a_section_officer_fk` FOREIGN KEY (`a_section_officer`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `provost_fk` FOREIGN KEY (`provost`) REFERENCES `admin` (`user_id`);

--
-- Constraints for table `labs`
--
ALTER TABLE `labs`
  ADD CONSTRAINT `assistant_fk` FOREIGN KEY (`assistant`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `lab_department_fk` FOREIGN KEY (`department`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `officer_fk` FOREIGN KEY (`officer`) REFERENCES `admin` (`user_id`);

--
-- Constraints for table `labs_approve_log`
--
ALTER TABLE `labs_approve_log`
  ADD CONSTRAINT `l_clearance_id_fk` FOREIGN KEY (`clearance_id`) REFERENCES `clearance` (`clearance_id`),
  ADD CONSTRAINT `l_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `l_lab_id_fk` FOREIGN KEY (`lab_id`) REFERENCES `labs` (`lab_id`);

--
-- Constraints for table `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `administrative_head_fk` FOREIGN KEY (`administrative_head`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `head_officer_fk` FOREIGN KEY (`head_officer`) REFERENCES `admin` (`user_id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_issuer_fk` FOREIGN KEY (`issuer`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `reports_issuer_office_fk` FOREIGN KEY (`issuer_office`) REFERENCES `office` (`office_id`),
  ADD CONSTRAINT `reports_student_fk` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `department_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `student_advisor_fk` FOREIGN KEY (`advisor`) REFERENCES `admin` (`user_id`),
  ADD CONSTRAINT `student_hall_fk` FOREIGN KEY (`hall`) REFERENCES `halls` (`hall_id`),
  ADD CONSTRAINT `student_supervisor_fk` FOREIGN KEY (`thesis_supervisor`) REFERENCES `admin` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_fk` FOREIGN KEY (`user_id`) REFERENCES `combined_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

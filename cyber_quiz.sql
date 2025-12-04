-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 10:09 AM
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
-- Database: `cyber_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$Wmxvyy4FYvCm7EXzVP5TJuYKvwXCfF6H5ACpxpm.I4hEYbhZPZ8xS');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_takers`
--

CREATE TABLE `quiz_takers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `device_type` varchar(20) DEFAULT NULL,
  `screen_size` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responses` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_takers`
--

INSERT INTO `quiz_takers` (`id`, `full_name`, `email`, `score`, `status`, `device_type`, `screen_size`, `created_at`, `responses`) VALUES
(1, 'Sai Revanth Varma', 'rev@gmail.com', 100, 'Pass', 'desktop', '1272', '2025-11-29 11:44:22', NULL),
(35, 'BADDAM SHASHIVARDHAN REDDY', 'shashivardhan630@gmail.com', 0, 'Fail', 'desktop', '1091', '2025-12-02 13:06:38', '[{\"question\":\"You set up a new device and are prompted to create a password.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Use complex passphrase\",\"is_correct\":false},{\"question\":\"Is it safe to use the same password for your work email and your personal social media accounts?\",\"selected\":\"Not Answered\",\"correct_answer\":\"No, it\'s dangerous\",\"is_correct\":false},{\"question\":\"A flashlight app requests access to your contacts and location.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Deny\\/Uninstall\",\"is_correct\":false},{\"question\":\"IT pushes a notification to install the new company password manager.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Install\",\"is_correct\":false},{\"question\":\"Email asks to scan QR code to update 2FA.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Verify source\",\"is_correct\":false},{\"question\":\"You receive an email from HR about the holiday schedule.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Open Attachment\",\"is_correct\":false},{\"question\":\"You find a USB drive in the parking lot labeled \'Salary Bonuses\'.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Give to IT Security\",\"is_correct\":false},{\"question\":\"You need to share a large file with a client. You use the approved OneDrive link.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Secure Practice\",\"is_correct\":false},{\"question\":\"Excel file asks to \'Enable Content\' to view data.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Don\'t Enable\",\"is_correct\":false},{\"question\":\"You are working on sensitive data on a train.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Use Privacy Screen\",\"is_correct\":false},{\"question\":\"Windows prompts you to restart for a scheduled update.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Restart Now\",\"is_correct\":false},{\"question\":\"You are entering the secure office building. A colleague swipes their badge ahead of you. What should you do?\",\"selected\":\"Not Answered\",\"correct_answer\":\"Swipe your own badge\",\"is_correct\":false},{\"question\":\"You connect to public Wi-Fi and immediately launch the company VPN.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Safe to work\",\"is_correct\":false},{\"question\":\"You received a generic prize notification.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Phishing Attempt\",\"is_correct\":false},{\"question\":\"Your screen turns red and demands Bitcoin to unlock files.\",\"selected\":\"Not Answered\",\"correct_answer\":\"Disconnect & Call IT\",\"is_correct\":false}]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `quiz_takers`
--
ALTER TABLE `quiz_takers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quiz_takers`
--
ALTER TABLE `quiz_takers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

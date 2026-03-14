-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 09:22 AM
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
-- Database: `dnd`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `first_name_admin` varchar(255) NOT NULL,
  `last_name_admin` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `exentation` varchar(255) NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id_client` int(255) NOT NULL,
  `first_name_cli` varchar(255) NOT NULL,
  `last_name_cli` varchar(255) NOT NULL,
  `email_client` varchar(255) NOT NULL,
  `password_client` varchar(255) NOT NULL,
  `exentation` varchar(255) NOT NULL,
  `statut` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `first_name_cli`, `last_name_cli`, `email_client`, `password_client`, `exentation`, `statut`) VALUES
(1, 'veera', 'v', 'veera@gmail.com', 'veera@2005', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id_contact` int(11) NOT NULL,
  `idsend` int(11) NOT NULL,
  `first_name_contact` varchar(255) NOT NULL,
  `last_name_contact` varchar(255) NOT NULL,
  `email_contact` varchar(255) NOT NULL,
  `subject_contact` varchar(255) NOT NULL,
  `message_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `freelancer`
--

CREATE TABLE `freelancer` (
  `id_freelancer` int(255) NOT NULL,
  `first_name_free` varchar(255) NOT NULL,
  `last_name_free` varchar(255) NOT NULL,
  `email_freelancer` varchar(255) NOT NULL,
  `password_freelancer` varchar(255) NOT NULL,
  `profession` varchar(255) NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `profile_views` int(11) NOT NULL DEFAULT 0,
  `skills` varchar(255) NOT NULL,
  `languages` varchar(255) NOT NULL,
  `description_free` text NOT NULL,
  `experiences` text NOT NULL,
  `joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` int(11) NOT NULL DEFAULT 0,
  `exentation` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `freelancer`
--

INSERT INTO `freelancer` (`id_freelancer`, `first_name_free`, `last_name_free`, `email_freelancer`, `password_freelancer`, `profession`, `hourly_rate`, `profile_views`, `skills`, `languages`, `description_free`, `experiences`, `joined`, `statut`, `exentation`) VALUES
(1, 'alwin', 'a', 'alwin@gmail.com', 'alwin@2005', 'Developer', 500.00, 0, '', '', '', '', '2025-04-10 07:06:41', 0, ''),
(2, 'ronaldo', 'r', 'ronaldo@gmail.com', 'ronaldo@2005', 'Developer', 500.00, 0, '', '', '', '', '2025-04-10 07:13:51', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id_job` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `budget` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `job_status` enum('public','private','completed') DEFAULT 'public',
  `id_client` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id_job`, `title`, `type`, `category`, `budget`, `description`, `time`, `job_status`, `id_client`) VALUES
(1, 'hi', 'Full-Time', 'Mobile Development', 50000, '               hi ', 5, 'public', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_sender` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_freelancer` int(11) NOT NULL,
  `message_fc` varchar(255) NOT NULL,
  `time_sent_message` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id_message`, `id_sender`, `id_client`, `id_freelancer`, `message_fc`, `time_sent_message`) VALUES
(1, 1, 1, 1, 'hi', '2025-04-10 09:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id_review` int(11) NOT NULL,
  `id_freelancer` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `description` text NOT NULL,
  `rating` int(1) NOT NULL,
  `created__at` datetime NOT NULL,
  `review_type` enum('freelancer_to_client','client_to_freelancer') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id_review`, `id_freelancer`, `id_client`, `description`, `rating`, `created__at`, `review_type`) VALUES
(1, 1, 1, 'hi', 3, '2025-04-10 09:11:17', 'freelancer_to_client');

-- --------------------------------------------------------

--
-- Table structure for table `suivi_job`
--

CREATE TABLE `suivi_job` (
  `id_request` int(11) NOT NULL,
  `id_job` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_freelancer` int(11) NOT NULL,
  `message_job` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected','completed') NOT NULL DEFAULT 'pending',
  `time_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_accepted` datetime NOT NULL,
  `time_completed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suivi_job`
--

INSERT INTO `suivi_job` (`id_request`, `id_job`, `id_client`, `id_freelancer`, `message_job`, `status`, `time_sent`, `time_accepted`, `time_completed`) VALUES
(1, 1, 1, 1, 'hi', 'pending', '2025-04-10 03:37:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 1, 2, 'i can do it ', 'pending', '2025-04-10 03:44:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id_contact`);

--
-- Indexes for table `freelancer`
--
ALTER TABLE `freelancer`
  ADD PRIMARY KEY (`id_freelancer`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id_job`),
  ADD KEY `fk_clientjob` (`id_client`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `fk_clientmessages` (`id_client`),
  ADD KEY `fk_freelancermessages` (`id_freelancer`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `fk_reviewcli` (`id_client`),
  ADD KEY `fk_reviewfree` (`id_freelancer`);

--
-- Indexes for table `suivi_job`
--
ALTER TABLE `suivi_job`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `fk_suivifreelancer` (`id_freelancer`),
  ADD KEY `fk_suivijob` (`id_job`),
  ADD KEY `fk_suiviclient` (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `freelancer`
--
ALTER TABLE `freelancer`
  MODIFY `id_freelancer` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id_job` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suivi_job`
--
ALTER TABLE `suivi_job`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_clientjob` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_clientmessages` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_freelancermessages` FOREIGN KEY (`id_freelancer`) REFERENCES `freelancer` (`id_freelancer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviewcli` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reviewfree` FOREIGN KEY (`id_freelancer`) REFERENCES `freelancer` (`id_freelancer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Constraints for table `suivi_job`
--
ALTER TABLE `suivi_job`
  ADD CONSTRAINT `fk_suiviclient` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_suivifreelancer` FOREIGN KEY (`id_freelancer`) REFERENCES `freelancer` (`id_freelancer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_suivijob` FOREIGN KEY (`id_job`) REFERENCES `jobs` (`id_job`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 11:11 AM
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
-- Database: `carpool`
--

-- --------------------------------------------------------

--
-- Table structure for table `apu`
--

CREATE TABLE `apu` (
  `id` int(11) NOT NULL,
  `tpnumber` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apu`
--

INSERT INTO `apu` (`id`, `tpnumber`, `name`, `age`) VALUES
(1, 'TP859604', 'Farrand Raiston', '60'),
(2, 'TP782811', 'Nelle Enston', '44'),
(3, 'TP309472', 'Shandee Skirven', '67'),
(4, 'TP317863', 'Ker Bengochea', '57'),
(5, 'TP493545', 'Andy Crevy', '16'),
(6, 'TP162172', 'Philippa Penquet', '43'),
(7, 'TP027471', 'Woodie Courvert', '37'),
(8, 'TP611096', 'Tammie Fibbitts', '60'),
(9, 'TP610967', 'Ari Roy', '55'),
(10, 'TP293125', 'Rosaleen Fibbitts', '63'),
(11, 'TP128373', 'Marijn Franca', '68'),
(12, 'TP402260', 'Lishe Broyd', '29'),
(13, 'TP895100', 'Winni Cyples', '35'),
(14, 'TP176018', 'Quintilla Leyborne', '63'),
(15, 'TP657944', 'Alexander Snaddon', '30'),
(16, 'TP777002', 'Mathew Diamond', '69'),
(17, 'TP799355', 'Dur Dunsmore', '39'),
(18, 'TP398485', 'Nola Hunt', '43'),
(19, 'TP302290', 'Clovis Mashro', '47'),
(20, 'TP733096', 'Erhart Hargerie', '38'),
(21, 'TP743083', 'Idaline Tattersall', '53'),
(22, 'TP401893', 'Sinclare Faas', '61'),
(23, 'TP282086', 'Marylynne Mochan', '67'),
(24, 'TP152801', 'Arch Strickland', '64'),
(25, 'TP194317', 'Reginauld Phinn', '19'),
(26, 'TP839134', 'Latia Ferris', '67'),
(27, 'TP772503', 'Anatollo Routhorn', '67'),
(28, 'TP999513', 'Constantine Gaven', '67'),
(29, 'TP714274', 'Tine Barthorpe', '39'),
(30, 'TP377701', 'Field Barwise', '33'),
(31, 'TP604162', 'Beaufort Jeannequin', '22'),
(32, 'TP633471', 'Callie Lillford', '56'),
(33, 'TP344348', 'Athene Carbonell', '28'),
(34, 'TP543235', 'Emyle Gherardini', '28'),
(35, 'TP643529', 'Sheelah O\'Cosgra', '20'),
(36, 'TP650604', 'Ernestine Tomaszewski', '16'),
(37, 'TP203629', 'Tanya Stennes', '68'),
(38, 'TP890971', 'Maurits Eakins', '34'),
(39, 'TP489221', 'Deidre Haskey', '43'),
(40, 'TP850841', 'Rebecka Yankeev', '52'),
(41, 'TP813405', 'Giorgia Mathou', '48'),
(42, 'TP918222', 'Naoma Hush', '25'),
(43, 'TP613868', 'Yank Potapczuk', '25'),
(44, 'TP441157', 'Antony Minero', '45'),
(45, 'TP965293', 'Franky Gabotti', '27'),
(46, 'TP433267', 'Nathanil Tilt', '18'),
(47, 'TP203556', 'Saunder Bradd', '39'),
(48, 'TP835667', 'Bax Spraggon', '36'),
(49, 'TP977458', 'Adham Curcher', '69'),
(50, 'TP275873', 'Danit Mattecot', '39');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `license_no` varchar(20) NOT NULL,
  `license_expiry_date` varchar(20) NOT NULL,
  `license_photo_front` varchar(100) NOT NULL,
  `license_photo_back` varchar(100) NOT NULL,
  `registration_date` date NOT NULL,
  `rating` int(5) NOT NULL,
  `status` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `cancel_count` int(2) DEFAULT NULL,
  `penalty_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_transaction`
--

CREATE TABLE `driver_transaction` (
  `id` int(11) NOT NULL,
  `driver_revenue` double(10,2) NOT NULL,
  `app_revenue` double(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `ride_completion_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `tp_number` varchar(8) NOT NULL,
  `feedback_message` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `id` int(11) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `registration_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`id`, `phone_no`, `registration_date`, `user_id`, `firstname`, `lastname`) VALUES
(17, '01112343213', '2025-03-27', 18, 'Idaline', 'Tattersall'),
(18, '01234565478', '2025-03-27', 19, 'Sinclare', 'Faas'),
(19, '01145432112', '2025-03-27', 20, 'Marylynne', 'Mochan'),
(20, '0134567889', '2025-03-27', 21, 'Arch', 'Strickland'),
(21, '0156786522', '2025-03-27', 22, 'Reginauld', 'Phinn'),
(22, '0134564323', '2025-03-27', 23, 'Latia', 'Ferris'),
(23, '0134592244', '2025-03-27', 24, 'Anatollo', 'Routhorn'),
(24, '0124567875', '2025-03-27', 25, 'Constantine', 'Gaven'),
(25, '0123212123', '2025-03-27', 26, 'Tine', 'Barthorpe'),
(26, '0123567656', '2025-03-27', 27, 'Field', 'Barwise'),
(27, '0123456789', '2025-03-27', 28, 'Beaufort', 'Jeannequin'),
(28, '0126754323', '2025-03-27', 29, 'Callie', 'Lillford'),
(29, '0122345589', '2025-03-27', 30, 'Athene', 'Carbonell'),
(30, '0126677889', '2025-03-27', 31, 'Emyle', 'Gherardini'),
(31, '0126677887', '2025-03-27', 32, 'Sheelah', 'OCosgra'),
(32, '0126543232', '2025-03-27', 33, 'Ernestine', 'Tomaszewski'),
(33, '0122332213', '2025-03-27', 34, 'Tanya', 'Stennes'),
(34, '0128877898', '2025-03-27', 35, 'Maurits', 'Eakins'),
(35, '01177885456', '2025-03-27', 36, 'Deidre', 'Haskey'),
(36, '01112237685', '2025-03-27', 37, 'Rebecka', 'Yankeev');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_transaction`
--

CREATE TABLE `passenger_transaction` (
  `id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `ride_id` int(11) NOT NULL,
  `ride_rating` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ride`
--

CREATE TABLE `ride` (
  `id` int(11) NOT NULL,
  `pick_up_point` varchar(50) NOT NULL,
  `drop_off_point` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `day` varchar(50) NOT NULL,
  `time` varchar(20) NOT NULL,
  `slots` int(3) NOT NULL,
  `slots_available` int(6) NOT NULL,
  `price` int(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripe_sessions`
--

CREATE TABLE `stripe_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `tpnumber` varchar(20) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `tpnumber`, `password`, `role`, `email`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(18, 'TP743083', '$2y$10$vi9/aqpjWS.phN0gkQVqs.LVUV5zsy/z4nfzNXRkUrFmear.TU3w2', 'passenger', 'Idaline@gmail.com', NULL, NULL),
(19, 'TP401893', '$2y$10$genX2VwtoPxNP6XNtosqve8zZ9UpsXf0cJm0O2aMWngqLOz1.CZFu', 'passenger', 'Sinclare@gmail.com', NULL, NULL),
(20, 'TP282086', '$2y$10$9o6qbFzXLB4jmzwFBcl8GegunQ/nYyxOxxLByfLFLcPYH87YEROt6', 'passenger', 'Marylynne@gmail.com', NULL, NULL),
(21, 'TP152801', '$2y$10$OEG0YKiZpE/X80cjgBIeaeddBiD/lday8W/OgDjgCqrktRnAMqkLm', 'passenger', 'Arch@gmail.com', NULL, NULL),
(22, 'TP194317', '$2y$10$20w4ev.LmlP/9FEoGDQEmuNRZ0UE4eaVGdI9UTIJyvBuQd1cocpJK', 'passenger', 'Reginauld@gmail.com', NULL, NULL),
(23, 'TP839134', '$2y$10$eIl1yvrultrXxp2RjXurRuZZr9DDhFdDHzSc82gXoAuxj/JPlAkQC', 'passenger', 'Latia@gmail.com', NULL, NULL),
(24, 'TP772503', '$2y$10$yaKAFM/xHNHP2o4bofnkwOt/P0tIi8NWH/n9uqocqEocIH8gi1VkG', 'passenger', 'Anatollo@gmail.com', NULL, NULL),
(25, 'TP999513', '$2y$10$oVTBSDiz3WngegWT1/D1x.106CkZ/ZWEJxz3PBNiXCWPx6wLBpzRC', 'passenger', 'Constantine@gmail.com', NULL, NULL),
(26, 'TP714274', '$2y$10$ajXC4dnP2Iu9InIXE2OAfuKTnrpxhOPVtGmPK8bFVW/c8xhhSPr6C', 'passenger', 'Tine@gmail.com', NULL, NULL),
(27, 'TP377701', '$2y$10$M/LkjHFYcZJxDqLQo4TQTu9uhF7z1ObsLT3Re8dd8FK/gCb/9enJe', 'passenger', 'Field@gmail.com', NULL, NULL),
(28, 'TP604162', '$2y$10$u9hmGEbA/m1oFcMBX17Q7.efH6tTXF2S0F7SQ11BIODQ5qPQMt/Zq', 'passenger', 'Beaufort@gmail.com', NULL, NULL),
(29, 'TP633471', '$2y$10$5jNo72moX0r0o3D/Z9Fc8OmCTAA6u686gB9WbhVLhZllthGRKE8vK', 'passenger', 'Callie@gmail.com', NULL, NULL),
(30, 'TP344348', '$2y$10$KLMHtW30R775Dx1Hjp0B0u42tO5ZnRCKRfNUfYMgn5GXox1uMslDS', 'passenger', 'Athene@gmail.com', NULL, NULL),
(31, 'TP543235', '$2y$10$9sPzw9htEfVoPzjoeSJrbO68OGnTkZnPH8cOYwAfNf9iJDJOs8a2q', 'passenger', 'Emyle@gmail.com', NULL, NULL),
(32, 'TP643529', '$2y$10$xbaKxUZBTa.PXIKMP7ifjul2s6xETdl4/5ydxB8CHprBDTeEbx4rC', 'passenger', 'Sheelah@gmail.com', NULL, NULL),
(33, 'TP650604', '$2y$10$zQwfpLjRU7PZP4XV1OcZGeR1BCmxYe0nr2pbfHNPX7JvZtE4DAnZW', 'passenger', 'Ernestine@gmail.com', NULL, NULL),
(34, 'TP203629', '$2y$10$q3rO5YpCLz.pKQI9jhKid.Uy3WTD/CA5HTZstnwraQs8JucwVZy9.', 'passenger', 'Tanya@gmail.com', NULL, NULL),
(35, 'TP890971', '$2y$10$biQMxON4KlXIyZWJ8Jev..jHqms9XTFNOZOMGSE7TRMOXZBV7xGDu', 'passenger', 'Maurits@gmail.com', NULL, NULL),
(36, 'TP489221', '$2y$10$niAU3XZHkqRu72opr6bnmOMwkzbtmWgZ/p7r3k/9tEtRHikzMQUKa', 'passenger', 'Deidre@gmail.com', NULL, NULL),
(37, 'TP850841', '$2y$10$JX7behh2kwfH4VGwOGnAre7XUj4knmD3HevhIZkuOlPKn8K/2zz66', 'passenger', 'Rebecka@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `year` varchar(20) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `color` varchar(30) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `seat_no` varchar(20) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_record`
--

CREATE TABLE `withdraw_record` (
  `id` int(11) NOT NULL,
  `driver_id` int(3) NOT NULL,
  `bank` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `account_number` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apu`
--
ALTER TABLE `apu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `driver_transaction`
--
ALTER TABLE `driver_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passenger_transaction`
--
ALTER TABLE `passenger_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passenger_id` (`passenger_id`),
  ADD KEY `ride_id` (`ride_id`);

--
-- Indexes for table `ride`
--
ALTER TABLE `ride`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `stripe_sessions`
--
ALTER TABLE `stripe_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `withdraw_record`
--
ALTER TABLE `withdraw_record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apu`
--
ALTER TABLE `apu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `driver_transaction`
--
ALTER TABLE `driver_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `passenger_transaction`
--
ALTER TABLE `passenger_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `stripe_sessions`
--
ALTER TABLE `stripe_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `withdraw_record`
--
ALTER TABLE `withdraw_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `driver_transaction`
--
ALTER TABLE `driver_transaction`
  ADD CONSTRAINT `driver_transaction_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `driver_transaction_ibfk_2` FOREIGN KEY (`ride_id`) REFERENCES `ride` (`id`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `passenger_transaction`
--
ALTER TABLE `passenger_transaction`
  ADD CONSTRAINT `passenger_transaction_ibfk_1` FOREIGN KEY (`passenger_id`) REFERENCES `passenger` (`id`),
  ADD CONSTRAINT `passenger_transaction_ibfk_2` FOREIGN KEY (`ride_id`) REFERENCES `ride` (`id`);

--
-- Constraints for table `ride`
--
ALTER TABLE `ride`
  ADD CONSTRAINT `ride_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `ride_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `stripe_sessions`
--
ALTER TABLE `stripe_sessions`
  ADD CONSTRAINT `stripe_sessions_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `passenger_transaction` (`id`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

--
-- Constraints for table `withdraw_record`
--
ALTER TABLE `withdraw_record`
  ADD CONSTRAINT `withdraw_record_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

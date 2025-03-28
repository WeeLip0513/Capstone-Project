-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 04:27 AM
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
(17, '0123454435', '2025-03-28', 18, 'Erhart', 'Hargerie'),
(18, '0123323232', '2025-03-28', 19, 'Idaline', 'Tattersall'),
(19, '0124556564', '2025-03-28', 20, 'Sinclare', 'Faas'),
(20, '0123556537', '2025-03-28', 21, 'Marylynne', 'Mochan'),
(21, '0123567448', '2025-03-28', 22, 'Arch', 'Strickland'),
(22, '0166868689', '2025-03-28', 23, 'Reginauld', 'Phinn'),
(23, '0123738373', '2025-03-28', 24, 'Latia', 'Ferris'),
(24, '0123498327', '2025-03-28', 25, 'Anatollo', 'Routhorn'),
(25, '0123765874', '2025-03-28', 26, 'Constantine', 'Gaven'),
(26, '0124396488', '2025-03-28', 27, 'Tine', 'Barthorpe'),
(27, '0123834938', '2025-03-28', 28, 'Field', 'Barwise'),
(28, '01145655675', '2025-03-28', 29, 'Beaufort', 'Jeannequin'),
(29, '01177889964', '2025-03-28', 30, 'Callie', 'Lillford'),
(30, '0123344558', '2025-03-28', 31, 'Athene', 'Carbonell'),
(31, '0134576849', '2025-03-28', 32, 'Emyle', 'Gheradini'),
(32, '0134763437', '2025-03-28', 33, 'Sheelah', 'OCosgra'),
(33, '0124567589', '2025-03-28', 34, 'Ernestine', 'Tomaszewski'),
(34, '0124489444', '2025-03-28', 35, 'Tanya', 'Stennes'),
(35, '0144753937', '2025-03-28', 36, 'Maurits', 'Eakins'),
(36, '0123473828', '2025-03-28', 37, 'Deidre', 'Haskey'),
(37, '0128394745', '2025-03-28', 38, 'Rebecka', 'Yankeev');

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
(18, 'TP733096', '$2y$10$mXKLUE4hhO/0we6yu1cOguhU9INfNYe6MxP2ZSuTi809LZPHASyYS', 'passenger', 'Erhart@gmail.com', NULL, NULL),
(19, 'TP743083', '$2y$10$trZsz6RyvYe3zvuNmAZOEu0eGf7SLhN12UHzVWDBYlu7Fcy/LgKjW', 'passenger', 'Idaline@gmail.com', NULL, NULL),
(20, 'TP401893', '$2y$10$bXxnzSr2/OeVZTEIMOjwT.211hrSk5xCABJ6NVso8PXgz7/g1rl8W', 'passenger', 'Sinclare@gmail.com', NULL, NULL),
(21, 'TP282086', '$2y$10$.o8VNjvoaQgwjI1YHLLmNOBrI23eMiGOsQIhVSM0mj2MNw3t46Vy.', 'passenger', 'Marylynne@gmail.com', NULL, NULL),
(22, 'TP152801', '$2y$10$OfkuHkAB8oUPkbiLqP2j5.wuswz2gguLD/6J.RxxNek2lYVH.kjEa', 'passenger', 'Arch@gmail.com', NULL, NULL),
(23, 'TP194317', '$2y$10$jFMFqndr4hprQ5mVIkEE8urHihkTHaMp7.Ds5wKjnbutfMmFeLBZ2', 'passenger', 'Reginauld@gmail.com', NULL, NULL),
(24, 'TP839134', '$2y$10$EGQ9sNPz4JvlQVfrHoFd2Ozktm24YKfqzQ6VFqXNUwHvG3aYt5IXC', 'passenger', 'Latia@gmail.com', NULL, NULL),
(25, 'TP772503', '$2y$10$b2/bC.Vv2BK0pMyb1XHbpOvojSnYXjr9FC7Hn/aP25Ao.IhotxbEq', 'passenger', 'Anatollo@gmail.com', NULL, NULL),
(26, 'TP999513', '$2y$10$oph8nNjEAFctJ1jgVD6akOt6GjKULR/LK/Ce9OviypE.88ISFsspK', 'passenger', 'Constantine@gmail.com', NULL, NULL),
(27, 'TP714274', '$2y$10$FrmRys6x2bobfUuZqJY4FuukWE9/7sznBlNQiy1vYMbhr96Ud4416', 'passenger', 'Tine@gmail.com', NULL, NULL),
(28, 'TP377701', '$2y$10$HhFUyqXLbcgOacJFztTnxOQAUn.Tl27KgBXygdDGtjSZvV9mLcAGi', 'passenger', 'Field@gmail.com', NULL, NULL),
(29, 'TP604162', '$2y$10$WpC3yXLTqCM28l1UCLeTSuhDfXDCsH0X2dvRXKTLOqOwpgkbXbxAu', 'passenger', 'Beaufort@gmail.com', NULL, NULL),
(30, 'TP633471', '$2y$10$MiWQPAx9F1VPrN7oBhlh5uGL7ukHqCNlc9cqc2p5Mel6fVsGQEy5.', 'passenger', 'Callie@gmail.com', NULL, NULL),
(31, 'TP344348', '$2y$10$GyujSYXQnDXXzL1gZEqKzuxAl9xzUQJxlN9ndEx68ZkRFDDxQMZVG', 'passenger', 'Athene@gmail.com', NULL, NULL),
(32, 'TP543235', '$2y$10$p5kQn1aPgk7WeU6aWMqKUOPrqohBo8OobpWYgLjWAd71LU5Ea4ILK', 'passenger', 'Emyle@gmail.com', NULL, NULL),
(33, 'TP643529', '$2y$10$FVUQcjbSukzO.IXMmooyheh/.F/s25k6jNAC0lZdlVjUYLo3BUDrq', 'passenger', 'Sheelah@gmail.com', NULL, NULL),
(34, 'TP650604', '$2y$10$CbcXlWhSH/F/D6AHESoRcu5ZD80RTRVCucXnsj0lcEJZldh1wnOqC', 'passenger', 'Ernestine@gmail.com', NULL, NULL),
(35, 'TP203629', '$2y$10$XZA9gIL6.iJMx3RdeIFG/OGN0TlO7c/5Vq/b/ayyVyxCjRdBeTDeW', 'passenger', 'Tanya@gmail.com', NULL, NULL),
(36, 'TP890971', '$2y$10$Oy3QgoevzUSvLXKW9L8ope.P7/jDZLW2cCbXhINzXrTKwW616hdhS', 'passenger', 'Maurits@gmail.com', NULL, NULL),
(37, 'TP489221', '$2y$10$6rww7vkMF.eOVnKw5Of8h.zv6KInIiAArVVtkYYO.fDm1B4zoxPLm', 'passenger', 'Deidre@gmail.com', NULL, NULL),
(38, 'TP850841', '$2y$10$Hg5CA8XyzF.t3CLzJXJEHuOpcepFG51HRRmOP8u4anWrGJAVc9wk2', 'passenger', 'Rebecka@gmail.com', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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

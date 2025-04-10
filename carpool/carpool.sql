-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 10:28 AM
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
(4, 'TP317863', 'Kern Bengochea', '57'),
(5, 'TP493545', 'Andy Crevy', '16'),
(6, 'TP162172', 'Philippa Penquet', '43'),
(7, 'TP027471', 'Woodie Courvert', '37'),
(8, 'TP611096', 'Tammie Fibbitts', '60'),
(9, 'TP610967', 'Aril Roy', '55'),
(10, 'TP293125', 'Rosaleen Fibbitts', '63'),
(11, 'TP128373', 'Marijn Franca', '68'),
(12, 'TP402260', 'Lishe Broyd', '29'),
(13, 'TP895100', 'Winni Cyples', '35'),
(14, 'TP176018', 'Quintilla Leyborne', '63'),
(15, 'TP657944', 'Alexander Snaddon', '30'),
(16, 'TP777002', 'Mathew Diamond', '69'),
(17, 'TP799355', 'Durl Dunsmore', '39'),
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

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `phone_no`, `license_no`, `license_expiry_date`, `license_photo_front`, `license_photo_back`, `registration_date`, `rating`, `status`, `user_id`, `firstname`, `lastname`, `cancel_count`, `penalty_end_date`) VALUES
(16, '01161234496', '4829371GHTYREW', '2025-10-02', '../../image/licenses/front/front_67e67c3d9cd46.jpg', '../../image/licenses/back/back_67e67c3d9cf70.jpg', '2025-03-28', 5, 'restricted', 39, 'Farrand', 'Raiston', 3, '2025-04-30'),
(17, '01245678988', '9304817ASDFQWE', '2025-10-01', '../../image/licenses/front/front_67e67c9c089eb.jpg', '../../image/licenses/back/back_67e67c9c08bf9.jpg', '2025-03-28', 5, 'approved', 40, 'Nelle', 'Enston', NULL, NULL),
(19, '01445678999', '1049583POIUYTR', '2025-09-30', '../../image/licenses/front/front_67e67d35e4804.jpg', '../../image/licenses/back/back_67e67d35e4a63.jpg', '2025-03-28', 5, 'approved', 42, 'Kern', 'Bengochea', NULL, NULL),
(20, '0134567888', '8765432LKJHGFD', '2025-09-30', '../../image/licenses/front/front_67e67d71615e0.jpg', '../../image/licenses/back/back_67e67d7161814.jpg', '2025-03-28', 5, 'approved', 43, 'Andy', 'Crevy', NULL, NULL),
(21, '01845612345', '3201987MNBVCXZ', '2025-09-30', '../../image/licenses/front/front_67e67dd440317.jpg', '../../image/licenses/back/back_67e67dd44051d.jpg', '2025-03-28', 5, 'pending', 44, 'Philippa ', 'Penquet', NULL, NULL),
(22, '01578945555', '1092837QAZWSXE', '2025-10-01', '../../image/licenses/front/front_67e67e2f2c81c.jpg', '../../image/licenses/back/back_67e67e2f2ca84.jpg', '2025-03-28', 5, 'pending', 45, 'Woodie', 'Courvert', NULL, NULL),
(23, '0189785444', '5647382EDCRFVT', '2025-09-30', '../../image/licenses/front/front_67e67e87ee40c.jpg', '../../image/licenses/back/back_67e67e87ee642.jpg', '2025-03-28', 5, 'pending', 46, 'Tammie', 'Fibbitts', NULL, NULL),
(24, '0157884555', '8473629TGBYHNU', '2025-09-30', '../../image/licenses/front/front_67e67ec9a7285.jpg', '../../image/licenses/back/back_67e67ec9a748d.jpg', '2025-03-28', 5, 'pending', 47, 'Aril', 'Roy', NULL, NULL),
(25, '0135458555', '2736458IKOLPMN', '2025-10-01', '../../image/licenses/front/rosaleen license front.png', '../../image/licenses/back/rosaleen license back.png', '2025-03-28', 5, 'approved', 48, 'Rosaleen', 'Fibbitts', NULL, NULL),
(26, '0189546555', '2736458IKOLPMN', '2025-09-30', '../../image/licenses/front/front_67e67f430669b.jpg', '../../image/licenses/back/back_67e67f4306889.jpg', '2025-03-28', 5, 'pending', 49, 'Marjin ', 'Franca', NULL, NULL),
(27, '01356489999', '9182736QWERTYU', '2025-09-29', '../../image/licenses/front/front_67e67f9f3bc29.jpg', '../../image/licenses/back/back_67e67f9f3bf49.jpg', '2025-03-28', 5, 'pending', 50, 'Lishe ', 'Broyd', NULL, NULL),
(28, '01145688777', '3847561ASDFGHJ', '2025-10-11', '../../image/licenses/front/front_67e67fe3d71a4.jpg', '../../image/licenses/back/back_67e67fe3d73e4.jpg', '2025-03-28', 5, 'pending', 51, 'Winni', 'Cyples', NULL, NULL),
(29, '0159875554', '6574839ZXCVBNM', '2025-10-10', '../../image/licenses/front/front_67e680218c487.jpg', '../../image/licenses/back/back_67e680218c729.jpg', '2025-03-28', 5, 'pending', 52, 'Quintilla', 'Leyborne', NULL, NULL),
(30, '0157845112', '1928374POIUYTR', '2025-09-30', '../../image/licenses/front/front_67e680a7a65e7.jpg', '../../image/licenses/back/back_67e680a7a68f7.jpg', '2025-03-28', 5, 'pending', 53, 'Alexander', 'Snaddon', NULL, NULL),
(31, '0125895666', '7462910LKJHGFD', '2025-09-30', '../../image/licenses/front/front_67e680f5bec63.jpg', '../../image/licenses/back/back_67e680f5beea0.jpg', '2025-03-28', 5, 'pending', 54, 'Mathew ', 'Diamond', NULL, NULL),
(32, '01587852486', '3859201MNBVCXZ', '2025-10-10', '../../image/licenses/front/front_67e681325ef4f.jpg', '../../image/licenses/back/back_67e681325f175.jpg', '2025-03-28', 5, 'pending', 55, 'Durl', 'Dunsmore', NULL, NULL),
(33, '0152458788', '8291047QAZWSXE', '2025-10-02', '../../image/licenses/front/front_67e6816850a33.jpg', '../../image/licenses/back/back_67e6816850d3a.jpg', '2025-03-28', 5, 'pending', 56, 'Nola', 'Hunt', NULL, NULL),
(34, '0125488996', '5637281EDCRFVT', '2025-09-30', '../../image/licenses/front/front_67e681a4d385a.jpg', '../../image/licenses/back/back_67e681a4d3a73.jpg', '2025-03-28', 5, 'pending', 57, 'Clovis', 'Mashro', NULL, NULL);

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

--
-- Dumping data for table `driver_transaction`
--

INSERT INTO `driver_transaction` (`id`, `driver_revenue`, `app_revenue`, `status`, `driver_id`, `ride_id`, `ride_completion_date`) VALUES
(30, 6.40, 1.60, 'withdrawn', 16, 124, '2025-03-29'),
(31, 6.40, 1.60, 'active', 16, 128, '2025-03-09'),
(32, 3.20, 1.40, 'active', 16, 123, '2025-03-19'),
(33, 12.80, 3.20, 'completed', 16, 125, '2025-03-30');

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
(37, '0128394745', '2025-03-28', 38, 'Rebecka', 'Yankeev'),
(38, '0124455887', '2025-03-28', 58, 'Nicholas', 'Ong');

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
  `ride_rating` int(5) DEFAULT NULL,
  `amount` int(11) NOT NULL
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

--
-- Dumping data for table `ride`
--

INSERT INTO `ride` (`id`, `pick_up_point`, `drop_off_point`, `date`, `day`, `time`, `slots`, `slots_available`, `price`, `status`, `driver_id`, `vehicle_id`) VALUES
(123, 'lrt_bukit_jalil', 'apu', '2025-03-30', 'sunday', '13:00', 4, 4, 2, 'canceled', 16, 6),
(124, 'lrt_bukit_jalil', 'apu', '2025-03-29', 'saturday', '18:30', 4, 0, 2, 'completed', 16, 6),
(125, 'pav_bukit_jalil', 'apu', '2025-03-30', 'sunday', '11:00', 4, 0, 4, 'canceled', 16, 6),
(126, 'apu', 'pav_bukit_jalil', '2025-03-30', 'sunday', '10:00', 4, 4, 4, 'canceled', 16, 6),
(127, 'lrt_bukit_jalil', 'apu', '2025-04-02', 'wednesday', '07:00', 4, 4, 2, 'upcoming', 16, 6),
(128, 'lrt_bukit_jalil', 'apu', '2025-04-03', 'thursday', '09:00', 4, 4, 2, 'upcoming', 16, 6),
(129, 'apu', 'sri_petaling', '2025-03-19', 'wednesday', '12:00', 4, 1, 4, 'completed', 16, 6),
(130, 'lrt_bukit_jalil', 'apu', '2025-04-05', 'saturday', '10:15', 4, 4, 2, 'upcoming', 16, 6),
(131, 'apu', 'lrt_bukit_jalil', '2025-04-01', 'tuesday', '18:00', 4, 4, 2, 'upcoming', 16, 6),
(132, 'pav_bukit_jalil', 'apu', '2025-03-17', 'monday', '21:00', 4, 1, 4, 'completed', 16, 6),
(133, 'sri_petaling', 'apu', '2025-04-02', 'wednesday', '21:25', 4, 4, 4, 'upcoming', 16, 6),
(134, 'pav_bukit_jalil', 'apu', '2025-03-31', 'monday', '21:00', 4, 4, 4, 'upcoming', 16, 6),
(135, 'apu', 'sri_petaling', '2025-04-02', 'wednesday', '12:00', 4, 4, 4, 'upcoming', 16, 6),
(136, 'lrt_bukit_jalil', 'pav_bukit_jalil', '2025-03-31', 'monday', '10:00', 4, 4, 5, 'upcoming', 16, 6),
(137, 'lrt_bukit_jalil', 'apu', '2025-03-31', 'monday', '10:00', 4, 4, 2, 'upcoming', 17, 7),
(138, 'apu', 'lrt_bukit_jalil', '2025-04-02', 'wednesday', '16:10', 4, 4, 2, 'upcoming', 17, 7),
(139, 'sri_petaling', 'apu', '2025-04-04', 'friday', '10:00', 4, 4, 4, 'upcoming', 17, 7),
(140, 'lrt_bukit_jalil', 'apu', '2025-04-05', 'saturday', '08:00', 4, 4, 2, 'upcoming', 17, 7),
(141, 'lrt_bukit_jalil', 'apu', '2025-04-01', 'tuesday', '13:00', 4, 4, 2, 'upcoming', 17, 7),
(142, 'lrt_bukit_jalil', 'apu', '2025-04-05', 'saturday', '06:00', 6, 6, 2, 'upcoming', 19, 9),
(143, 'lrt_bukit_jalil', 'sri_petaling', '2025-04-01', 'tuesday', '18:00', 6, 6, 0, 'upcoming', 19, 9),
(144, 'lrt_bukit_jalil', 'pav_bukit_jalil', '2025-04-04', 'friday', '10:00', 6, 6, 5, 'upcoming', 19, 9),
(145, 'pav_bukit_jalil', 'apu', '2025-04-01', 'tuesday', '10:00', 6, 3, 4, 'upcoming', 19, 9),
(146, 'sri_petaling', 'apu', '2025-04-05', 'saturday', '13:00', 6, 6, 4, 'upcoming', 19, 9),
(147, 'pav_bukit_jalil', 'apu', '2025-04-02', 'wednesday', '21:00', 6, 6, 4, 'upcoming', 19, 9),
(148, 'apu', 'pav_bukit_jalil', '2025-04-01', 'tuesday', '10:05', 6, 6, 4, 'upcoming', 20, 10),
(149, 'lrt_bukit_jalil', 'apu', '2025-04-02', 'wednesday', '08:00', 6, 6, 2, 'upcoming', 20, 10),
(150, 'pav_bukit_jalil', 'sri_petaling', '2025-04-05', 'saturday', '15:05', 6, 6, 5, 'upcoming', 20, 10),
(151, 'lrt_bukit_jalil', 'apu', '2025-04-03', 'thursday', '10:00', 6, 6, 2, 'upcoming', 20, 10),
(152, 'apu', 'pav_bukit_jalil', '2025-04-04', 'friday', '10:05', 6, 6, 4, 'upcoming', 20, 10);

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
(38, 'TP850841', '$2y$10$Hg5CA8XyzF.t3CLzJXJEHuOpcepFG51HRRmOP8u4anWrGJAVc9wk2', 'passenger', 'Rebecka@gmail.com', NULL, NULL),
(39, 'TP859604', '$2y$10$WzACwGrHZdkXxOeuAqwnd.3VjzoaOhqU4pHmxBCarVi2Qq89pw7SS', 'driver', 'Farrand@gmail.com', '37679222a890bec363d95a3b1ee8ecefee3c8358528e1ae9875858eb5e0b5837', '2025-03-30 11:26:16'),
(40, 'TP782811', '$2y$10$swUiqgfmVLO68o.79qt.Zea6PBpjYbFt3v2Mp3iC1LAqg2GTUX84C', 'driver', 'Nelle@gmail.com', NULL, NULL),
(42, 'TP317863', '$2y$10$I8QrsWO/QIVwGZrBtieXVuZ6M8JT./RcfNnfNu.4qhzy/TGwPv1DG', 'driver', 'Kern@Gmail.com', NULL, NULL),
(43, 'TP493545', '$2y$10$B/xr/h5Cdo7FiAIHaRAnsuT3q6aUbN2wEkgwNy1nQuPHBh0dIOXiC', 'driver', 'Andy@gmail.com', NULL, NULL),
(44, 'TP162172', '$2y$10$2QgpoIsPvASi6zHjPrjBUuqqAxIzo.rfpV9L4l8.CLwTphHHzYmi.', 'driver', 'Philippa@gmail.com', NULL, NULL),
(45, 'TP027471', '$2y$10$pVh.Q7H2HpUv7YjYEn6lkeEfXqLjeFAmfd0nWgJipg7.DvNxPyphS', 'driver', 'Woodie@gmail.com', NULL, NULL),
(46, 'TP611096', '$2y$10$czVaqRUTpE0OS2A4cr.kOuTAK0pSurS84.Cut2jHS.xPO4gehTC6u', 'driver', 'Tammie@gmmai.com', NULL, NULL),
(47, 'TP610967', '$2y$10$0YPojXbEGFTBQ9./kuuldewOY7a6srEMw6mtLfXjf65U5CyQCXDme', 'driver', 'Aril@gmail.com', NULL, NULL),
(48, 'TP293125', '$2y$10$mNGGCilQXH1e/pOhi11hHuV0qs8ZXuwjDX1W6L12Ts5XU43UDEbUK', 'driver', 'Rosaleen@gmail.com', NULL, NULL),
(49, 'TP128373', '$2y$10$rtd1ZP5eOU1pUWqjK9UTBO6mZDlYUgEwzvhg3qJtQjuQM32MlAsx.', 'driver', 'Marjin@gmail.com', NULL, NULL),
(50, 'TP402260', '$2y$10$W07CI5aauxdEfB3xCSKcF.wUqtcoGsdl7a1zKlr.8zNZ3kXmXiwme', 'driver', 'Lishe@gmail.com', NULL, NULL),
(51, 'TP895100', '$2y$10$C/sAFe1WP.bJqRWAueHatOVYwXDulhSLWXweCwGMBQQLXDFewbqOW', 'driver', 'Winni@gmail.com', NULL, NULL),
(52, 'TP176018', '$2y$10$87aJzEob9.O6qKHATo0A9.PaRWUwyEcUDhfJWc5qC0aZAQaTgpvj6', 'driver', 'Quintilla@gmail.com', NULL, NULL),
(53, 'TP657944', '$2y$10$tEs.VDKhn3cHLfRXutGhAuLSKtRLIJpKsU/EHu0VpTkPDBuc0Ka3.', 'driver', 'Alexander@gmail.com', NULL, NULL),
(54, 'TP777002', '$2y$10$Ydhbgkr4n7Azy8j7Lf.AL.0s6vk1cbCgmCdH9UqYQ5lYo3SvbIxE6', 'driver', 'Mathew@gmail.com', NULL, NULL),
(55, 'TP799355', '$2y$10$KgMC1p2b2rtA34H.ejbuaeuD5VTOINLZ6ydkJRxIJQl91sMinxNT6', 'driver', 'Durl@gmail.com', NULL, NULL),
(56, 'TP398485', '$2y$10$88nvRiry0XQ/ehCreEmeguUHHBMeS0WxsSN7.GovAJctOepwPcnyS', 'driver', 'Nola@gmail.com', NULL, NULL),
(57, 'TP302290', '$2y$10$GAQZT2b4sm6sewkwLCE93OVoEE2uA23R8ENWGWnlxTtjcigMBJvRa', 'driver', 'Clovis@gmail.com', NULL, NULL),
(58, 'TP275873', '$2y$10$SMAi3QskKjVuvx9jBy/VDuMlkx4VDLVdckUjwxglCmOXYeTEfoBkK', 'passenger', 'nick123@gmail.com', NULL, NULL);

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

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `type`, `year`, `brand`, `model`, `color`, `plate_no`, `seat_no`, `driver_id`) VALUES
(6, 'sedan', '2012', 'Toyota', 'Vios', 'White', 'WCP3338', '5', 16),
(7, 'sedan', '2015', 'Honda', 'City', 'Silver', 'MMM123', '5', 17),
(9, 'suv', '2021', 'Honda', 'CR-V', 'black', 'HHH5678', '7', 19),
(10, 'mpv', '2023', 'Perodua', 'Alza', 'White', 'JJJ4579', '7', 20),
(11, 'pickup', '2018', 'Toyota', 'Hilux', 'Silver', 'YYY1234', '2', 21),
(12, 'jeep', '2015', 'Jeep', 'Wrangler', 'black', 'KKK1234', '4', 22),
(13, 'van', '2015', 'Nissan', 'Urvan', 'White', 'LLL8888', '12', 23),
(14, 'sedan', '2013', 'Nissan', 'Almera', 'Silver', 'QQQ1234', '5', 24),
(15, 'sedan', '2019', 'Proton', 'Inspira', 'black', 'WWW8888', '5', 25),
(16, 'sedan', '2020', 'Perodua', 'Bezza', 'Silver', 'TTT9999', '5', 26),
(17, 'sedan', '2023', 'Toyota', 'Camry', 'White', 'AAA1595', '5', 27),
(18, 'sedan', '2022', 'Toyota', 'Vios', 'Silver', 'BBB8', '5', 28),
(19, 'sedan', '2023', 'Proton', 'Saga', 'Silver', 'A8', '5', 29),
(20, 'sedan', '2025', 'Toyota', 'Camry', 'White', 'T8', '5', 30),
(21, 'hatchback', '2015', 'Perodua', 'Axia', 'White', 'III8', '5', 31),
(22, 'sedan', '2024', 'Toyota', 'Vios', 'White', 'SSS8888', '5', 32),
(23, 'sedan', '2022', 'Nissan', '', 'Silver', 'MMM88', '5', 33),
(24, 'hatchback', '2019', 'Honda', 'Jazz', 'White', 'SSS98', '5', 34);

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
-- Dumping data for table `withdraw_record`
--

INSERT INTO `withdraw_record` (`id`, `driver_id`, `bank`, `name`, `account_number`, `date`, `amount`) VALUES
(30, 16, 'Maybank', 'ngweelip', '1234567895', '2025-03-30', 6.40);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `driver_transaction`
--
ALTER TABLE `driver_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `passenger_transaction`
--
ALTER TABLE `passenger_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `stripe_sessions`
--
ALTER TABLE `stripe_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `withdraw_record`
--
ALTER TABLE `withdraw_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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

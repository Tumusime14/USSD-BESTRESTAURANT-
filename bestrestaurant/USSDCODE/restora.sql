-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 04:01 PM
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
-- Database: `restora`
--

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `dish_id` int(11) NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `dishphoto` blob DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`dish_id`, `dish_name`, `dishphoto`, `description`, `price`) VALUES
(9, 'Chapati', 0x75706c6f6164732f63686170617469322e6a706567, 'Fast food made in wheat flour.', 500.00),
(10, 'Chicken Tanjine', 0x75706c6f6164732f636869636b656e74616a696e652e6a7067, 'Delicious chicken made food.', 5000.00),
(11, 'Progue', 0x75706c6f6164732f67726f6775652e6a7067, 'Alcoholic Drink to recharge energy.', 3000.00),
(12, 'Mazagran', 0x75706c6f6164732f6d617a616772616e2e6a7067, 'Morroco cocktail', 2500.00),
(13, 'Omellete', 0x75706c6f6164732f4f6d656c6c657465652e6a706567, 'Decious egg made with little vegetables.', 2000.00),
(14, 'Milk (Amasi)', 0x75706c6f6164732f4d696c6b416d6173692e6a7067, 'South Africa fermented milk.', 1500.00),
(15, 'Wat', 0x75706c6f6164732f7761742e6a7067, 'Delicious beaf.', 4000.00),
(16, 'Shakshouka', 0x75706c6f6164732f7368616b73686f756b612e6a7067, 'Ethiopian meal', 1200.00),
(17, 'Pinotage', 0x75706c6f6164732f70696e6f746167652e6a7067, 'Pinotage is cream beer made from South Africa.', 6000.00),
(18, 'Pistilla', 0x75706c6f6164732f70617374696c6c612e6a7067, 'Super delicious meal from Ghana', 2000.00),
(19, 'Ibiraha', 0x75706c6f6164732f696269726168612e6a706567, 'Best delicious irish-made recipe from Rwanda.', 200.00),
(20, 'Pizza', 0x75706c6f6164732f70697a7a612e6a706567, 'Super delicious Pizza from Rwanda', 3000.00),
(21, 'Pizza', 0x75706c6f6164732f70697a7a61682e6a706567, 'Delicious with pleasant taste.', 2500.00),
(22, 'Brai', 0x75706c6f6164732f627261692e6a7067, 'Roasted meat from Egypt.', 5000.00),
(23, 'Chapati', 0x75706c6f6164732f636861706174692e6a706567, 'Chapati with milk.', 400.00),
(24, 'Kunafah', 0x75706c6f6164732f6b756e616661682e6a7067, 'Ethiopian meal', 1500.00);

-- --------------------------------------------------------

--
-- Table structure for table `pending`
--

CREATE TABLE `pending` (
  `p_id` int(11) NOT NULL,
  `dish_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `numOrders` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending`
--

INSERT INTO `pending` (`p_id`, `dish_id`, `user_id`, `status`, `numOrders`, `price`, `Date`) VALUES
(13, 9, 8, 'Canceled', '5', 2500.00, '2024-04-11 11:42:03'),
(14, 9, 8, 'pending', '10', 2500.00, '2024-04-11 11:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `phone`, `email`, `password`) VALUES
(1, 'admin', '0784432886', 'tumusime@gmail.com', 'admin'),
(2, 'Christian', '0784432887', 'chris@gmail.com', '123456'),
(6, 'Felix', '0784432884', 'felex@gmail.com', 'felix'),
(7, '', '', '', ''),
(8, 'Danny', '0784432881', '', '12345');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `pending`
--
ALTER TABLE `pending`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `dish_id` (`dish_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pending`
--
ALTER TABLE `pending`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pending`
--
ALTER TABLE `pending`
  ADD CONSTRAINT `pending_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`dish_id`),
  ADD CONSTRAINT `pending_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

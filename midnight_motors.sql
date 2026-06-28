-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2026 at 02:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midnight_motors`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `colour` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `seller_id`, `model`, `year`, `price`, `colour`, `description`, `image`) VALUES
(2, 1, 'Honda Civic', 2019, 18500.00, 'Black', 'Location: Wellington, Body type: Sedan, Mileage: 45000 km', ''),
(3, 1, 'Mazda Axela', 2018, 13900.00, 'Blue', 'Location: Christchurch, Body type: Hatchback, Mileage: 78000 km', ''),
(4, 2, 'Nissan Leaf', 2021, 21900.00, 'Silver', 'Location: Hamilton, Body type: Hatchback, Mileage: 28000 km', ''),
(5, 2, 'BMW 320i', 2017, 19900.00, 'Grey', 'Location: Tauranga, Body type: Sedan, Mileage: 91000 km', ''),
(7, 5, 'Honda Supercar', 2019, 1690000.00, 'Midnight Black', 'Location: Christchurch, Body type: Hatchback, Mileage: 78000 km', '');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `car_id`, `name`, `email`, `message`, `rating`, `created_at`) VALUES
(1, 2, 'Sarah Mitchell', 'sarah@email.com', 'The car was exactly as described and very clean. The seller was friendly and answered all my questions quickly. The viewing process was easy and I would definitely recommend this seller.', 5, '2026-06-03 09:37:52'),
(2, 2, 'Liam Parker', 'liam@email.com', 'The car was in good condition and matched the photos. The seller was helpful and honest about the vehicle history. Overall it was a smooth experience and I am happy with the purchase.', 4, '2026-06-03 09:38:24'),
(3, 2, 'Noah Wilson', 'noah@email.com', 'he car was okay, but the listing did not include enough detail about the condition. The seller replied slowly and I had to ask a few times for basic information. The experience could have been better.\r\n\r\nFor Task 9 screenshots, take:', 2, '2026-06-03 09:39:39'),
(4, 3, 'Noah Wilson', 'tyagiamarsh2@gmail.com', 'this car is so goood', 5, '2026-06-05 12:11:34'),
(5, 7, 'Noah Wilson', 'noah@email.com', 'The car is too expensive to rent. It did not have enough space.', 3, '2026-06-05 12:23:06'),
(6, 7, 'Sarah Mitchell', 'sarah@email.com', 'I love sports cars they ride super fast.', 5, '2026-06-05 12:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `seller_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`seller_id`, `username`, `password`, `full_name`, `email`, `phone`) VALUES
(1, 'amarsh123', '$2y$10$td8bIqKRo/0mU22TH1TQbeveplzhVc82f5z5o6PPOAa1ekfbVQJDi', 'Amarsh  Tyagi', 'amarsh@test.com', '0212345678'),
(2, 'jturner99', '$2y$10$NpHeHdHsKY6dXS0J1e0lMOKt3hi3oxhkSf/D/FPhMu1r/BiOYSTJO', 'James Turner', 'james@test.com', '0211244538'),
(3, 'aparker22', '$2y$10$5FwcbDN50D4gqX.ys7.hH.H2o.9wsdoIz0/oobu8aQhusWRLZbivC', 'Anjola Parker', 'Anjola@test.com', '0211241111'),
(4, 'Markc99', '$2y$10$z7HZRYOinZ7y1h7FvvjSBe7u8wtbsWsw/emUT87uPw.QbRLPNtOmS', 'Mark Caoul', 'Mark@test.com', '02112411123'),
(5, 'RBrown22', '$2y$10$BiR/fwnHjf79OF5YV9SvZOcHIHr1wgTpBnffYnZs5DBd.6eSNzan.', 'Rachel Brown', 'Rachel@test.com', '0212345222');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`seller_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `seller_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`seller_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

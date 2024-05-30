-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 06:34 PM
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
-- Database: `travelbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_type` enum('Flight','Hotel','Transport') NOT NULL,
  `item_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `customer_id`, `item_type`, `item_id`, `booking_date`) VALUES
(3, 1, 'Flight', 1, '2024-04-23 13:29:19'),
(4, 1, 'Hotel', 1, '2024-04-23 13:29:25'),
(10, 3, 'Hotel', 1, '2024-04-23 13:33:05'),
(22, 1, 'Flight', 1, '2024-04-23 16:05:39'),
(23, 2, 'Flight', 1, '2024-04-23 16:06:04'),
(24, 3, 'Flight', 1, '2024-04-23 16:06:25'),
(30, 3, 'Flight', 2, '2024-04-23 16:17:20'),
(31, 3, 'Flight', 2, '2024-04-23 16:27:13'),
(32, 3, 'Hotel', 1, '2024-04-23 16:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `email`, `phone`, `address`, `username`, `password`, `user_type`) VALUES
(1, 'John', 'john@example.com', '1234567890', '123 Main St, City, Country', 'Jhon', '12345678', 'customer'),
(2, 'Jane Smith', 'jane@example.com', '0987654321', '456 Oak St, City, Country', 'Jane Smith', '12345678', 'customer'),
(3, 'Mahdi', 'mahdi@gmail.com', '01883422698', 'Road 4, Post Office', 'Mahdi', '12345678', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `flight_id` int(11) NOT NULL,
  `airline` varchar(100) NOT NULL,
  `source_city` varchar(100) NOT NULL,
  `source_country` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `destination_country` varchar(100) NOT NULL,
  `departure_datetime` datetime NOT NULL,
  `arrival_datetime` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`flight_id`, `airline`, `source_city`, `source_country`, `destination_city`, `destination_country`, `departure_datetime`, `arrival_datetime`, `price`, `available_seats`) VALUES
(1, 'Airline A', 'New York', 'USA', 'London', 'UK', '2024-05-01 08:00:00', '2024-05-01 12:00:00', 500.00, 100),
(2, 'Airline B', 'London', 'UK', 'Paris', 'France', '2024-05-02 10:00:00', '2024-05-02 12:00:00', 300.00, 50);

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `hotel_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_rooms` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `booked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`hotel_id`, `name`, `city`, `country`, `price`, `available_rooms`, `image_url`, `booked`) VALUES
(1, 'Hotel X', 'Paris', 'France', 150.00, 50, 'http://localhost/travelsite/assets/room1.jpg', 0),
(2, 'Hotel Y', 'London', 'UK', 200.00, 100, 'http://localhost/travelsite/assets/room1.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `transport_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `source_city` varchar(100) NOT NULL,
  `source_country` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `destination_country` varchar(100) NOT NULL,
  `pickup_datetime` datetime NOT NULL,
  `return_datetime` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `available_vehicles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`transport_id`, `type`, `source_city`, `source_country`, `destination_city`, `destination_country`, `pickup_datetime`, `return_datetime`, `price`, `available_vehicles`) VALUES
(1, 'Car Rental', 'New York', 'USA', 'Los Angeles', 'USA', '2024-05-05 09:00:00', '2024-05-10 12:00:00', 400.00, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `fk_flight_id_new` (`item_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`flight_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`transport_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `flight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_flight_id` FOREIGN KEY (`item_id`) REFERENCES `flight` (`flight_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_flight_id_new` FOREIGN KEY (`item_id`) REFERENCES `flight` (`flight_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_hotel_id` FOREIGN KEY (`item_id`) REFERENCES `hotel` (`hotel_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

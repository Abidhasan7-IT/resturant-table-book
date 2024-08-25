-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 07:41 AM
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
-- Database: `mfors`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `pass`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'test', '81dc9bdb52d04dc20036dbd8313ed055');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_category` varchar(255) NOT NULL,
  `food_price` varchar(255) NOT NULL,
  `food_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `food_name`, `food_category`, `food_price`, `food_description`) VALUES
(1, 'spicyburger', 'lunch', '80.00', 'Vestibulum tortor quam feugiat vitae ultricies eget tempor sit amet ante Donec eu libero sit amet quam egestas semper Aenean ultricies mi vitae est Mauris placerat eleifend leo Quisque sit amet est et sapien ullamcorper pharetra Vestibulum erat wisi condimentum sed commodo vitae'),
(2, 'snailchoc', 'breakfast', '150.00', 'Vestibulum tortor quam feugiat vitae ultricies eget tempor sit amet ante Donec eu libero sit amet quam egestas semper Aenean ultricies mi vitae est Mauris placerat eleifend leo Quisque sit amet est et sapien ullamcorper pharetra Vestibulum erat wisi condimentum sed commodo vitae'),
(3, 'salad', 'lunch', '50.00', 'Vestibulum tortor quam feugiat vitae ultricies eget tempor sit amet ante Donec eu libero sit amet quam egestas semper Aenean ultricies mi vitae est Mauris placerat eleifend leo Quisque sit amet est et sapien ullamcorper pharetra Vestibulum erat wisi condimentum sed commodo vitae'),
(4, 'pizza', 'lunch', '350.00', 'Vestibulum tortor quam feugiat vitae ultricies eget tempor sit amet ante Donec eu libero sit amet quam egestas semper Aenean ultricies mi vitae est Mauris placerat eleifend leo Quisque sit amet est et sapien ullamcorper pharetra Vestibulum erat wisi condimentum sed commodo vitae'),
(5, 'shawarma', 'breakfast', '350.00', 'Vestibulum tortor quam feugiat vitae ultricies eget tempor sit amet ante Donec eu libero sit amet quam egestas semper Aenean ultricies mi vitae est Mauris placerat eleifend leo Quisque sit amet est et sapien ullamcorper pharetra Vestibulum erat wisi condimentum sed commodo vitae'),
(6, 'Rice', 'lunch', '50.00', 'This is a tasty meal i bet you dont want miss enjoying the yummy taste'),
(10, 'Eba and Vegetable', 'dinner', '600', 'This is a very nice combination'),
(13, 'jelifish', 'dinner', '500', 'spicy jellyfish salad '),
(14, 'Ice Cream', 'special', '100', 'pure cream millk '),
(15, 'different Ice cream', 'dinner', '200', 'This is different Ice cream');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(55) NOT NULL,
  `resid` int(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Tableno` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `timeslot` varchar(50) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `resid`, `name`, `email`, `Tableno`, `amount`, `date`, `timeslot`, `status`) VALUES
(9, 18, 'Abid Hasan', 'abidhasanstudent20@gmail.com', 'B2', 400.00, '2024-08-25', '7:00PM-10:00PM', 'paid'),
(10, 20, 'Abid Hasan', '20103095@iubat.edu', 'B2', 400.00, '2024-08-26', '2:30PM-5:00PM', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `res_id` int(55) NOT NULL,
  `table_id` int(50) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `amount` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `table` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timeslot` varchar(50) NOT NULL,
  `currenttime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`res_id`, `table_id`, `name`, `email`, `amount`, `table`, `date`, `timeslot`, `currenttime`) VALUES
(13, 1, 'Abid Hasan', 'abidhasanstudent20@gmail.com', '500', 'A1', '2024-08-14', '10:00AM-11:30AM', '2024-08-13 21:55:19'),
(18, 3, 'Abid Hasan', 'abidhasanstudent20@gmail.com', '400', 'B2', '2024-08-25', '7:00PM-10:00PM', '2024-08-22 19:54:33'),
(20, 3, 'Abid Hasan', '20103095@iubat.edu', '400', 'B2', '2024-08-26', '2:30PM-5:00PM', '2024-08-24 20:13:32'),
(21, 3, 'iubat', 'hasomet516@ndiety.com', '300', 'B2', '2024-08-26', '2:30PM-5:00PM', '2024-08-24 20:57:31'),
(23, 3, 'iubat', 'hasomet516@ndiety.com', '300', 'B2', '2024-08-26', '2:30PM-5:00PM', '2024-08-24 21:00:11'),
(24, 2, 'iubat', 'hasomet516@ndiety.com', '500', 'B1', '2024-08-25', '7:00PM-10:00PM', '2024-08-24 21:01:02'),
(25, 4, 'Abid Hasan', 'abidhasanstudent20@gmail.com', '400', 'A1', '2024-08-26', '2:30PM-5:00PM', '2024-08-24 21:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `tid` int(55) NOT NULL,
  `t_name` varchar(150) NOT NULL,
  `chair` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `describe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`tid`, `t_name`, `chair`, `amount`, `describe`) VALUES
(2, 'B1', '6', '700', 'B1 is table looking for 6 person'),
(3, 'B2', '5', '500', 'this is b2 Table'),
(4, 'A1', '4', '400', 'This is A1 Table');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `p_number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `pass`, `p_number`) VALUES
(5, 'Abid Hasan', 'abidhasanstudent20@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '01772010108'),
(13, 'mahajabin', 'mahajabinsarker57@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '0565895'),
(15, 'Abid Hasan', '20103095@iubat.edu', '81dc9bdb52d04dc20036dbd8313ed055', '01772010108');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `tid` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

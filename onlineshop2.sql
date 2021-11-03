-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2019 at 09:42 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineshop2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `client_ID` int(11) NOT NULL,
  `index_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `section_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`ID`, `Name`, `section_ID`) VALUES
(8, 'Accesories', 1),
(9, 'Pants', 1),
(11, 'T Shirt', 1),
(12, 'Shoes', 1),
(13, 'Apple', 3),
(14, 'Oppo', 3),
(16, 'huwawi', 3),
(17, 'Sumsung', 3),
(18, 'Chevrole', 6),
(19, 'kia', 6),
(20, 'Hyundai', 6),
(21, 'BMW', 6),
(22, 'Volvo', 6),
(23, 'Ford', 6),
(24, 'Audi', 6),
(25, 'Toyota', 6),
(26, 'Jeep', 6),
(27, 'Fiat', 6);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `balance` double NOT NULL,
  `sales` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_ID`, `name`, `Email`, `balance`, `sales`) VALUES
(12, 'eslam', 'eslam@yahoo.com', 1436432, 20),
(13, 'ahmed', 'ahmed@gmail.com', 113400, 7),
(14, 'zanhom', 'zanhom@yahoo.com', 0, 0),
(15, 'g3fer', 'ga3fer@yahoo.com', 0, 0),
(16, 'mustafa', 'mustafa@yahoo.com', 0, 0),
(20, 'ahmedea123', 'ahmedsea123@yahoo.com', 0, 0),
(22, 'noor ali', 'noor@yahoo.com', 0, 0),
(23, 'bader name', 'bader@gmail.com', 1753560, 0),
(27, 'hossam name', 'hossam@gmail.com', 0, 0),
(28, 'user1', 'user1@gmail.com', 0, 0),
(29, 'user2', 'user2@gmail.com', 163463, 9),
(30, 'user3', 'user@gmail.com', 23213, 1),
(31, 'user5', 'user5@gmail.com', 60813, 3),
(32, 'user10', 'user10@gmail.com', 69639, 3);

-- --------------------------------------------------------

--
-- Table structure for table `client_products`
--

CREATE TABLE `client_products` (
  `index_ID` int(11) NOT NULL,
  `client_ID` int(11) NOT NULL,
  `P_ID` int(11) NOT NULL,
  `Price` double NOT NULL,
  `Quantity` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `Approve` int(1) NOT NULL DEFAULT '0',
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client_products`
--

INSERT INTO `client_products` (`index_ID`, `client_ID`, `P_ID`, `Price`, `Quantity`, `date`, `description`, `Approve`, `product_image`) VALUES
(48, 32, 39, 23213, 1, '2019-05-10', '  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic ', 1, '53326-Apple-iPhone-Xs-combo-gold-09122018_big.jpg.large.jpg'),
(49, 32, 40, 23213, 0, '2019-05-10', '  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic ', 1, '54917-maxresdefault.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `client_ID` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_ID` int(11) NOT NULL,
  `P_ID` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`client_ID`, `comment`, `comment_ID`, `P_ID`, `date`) VALUES
(32, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic ', 14, 48, '2019-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `client_ID` int(11) NOT NULL,
  `name` int(100) NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `E_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `E_mail` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`E_ID`, `name`, `username`, `password`, `phone`, `E_mail`) VALUES
(11, 'employee1', 'employee1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 3123213, 'employee1@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `O_ID` int(11) NOT NULL,
  `client_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `E_ID` int(11) DEFAULT NULL,
  `totalprice` double NOT NULL,
  `order_state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`O_ID`, `client_ID`, `Date`, `E_ID`, `totalprice`, `order_state`) VALUES
(48, 12, '2019-05-10', 11, 46426, 1),
(49, 12, '2019-05-10', 11, 23213, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_address`
--

CREATE TABLE `order_address` (
  `address_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `Country` varchar(255) NOT NULL,
  `Street` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `O_ID` int(11) NOT NULL,
  `index_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`O_ID`, `index_ID`, `quantity`, `price`) VALUES
(48, 48, 1, 23213),
(48, 49, 1, 23213),
(49, 49, 1, 23213);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `P_ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cat_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`P_ID`, `name`, `cat_ID`) VALUES
(39, 'Apple iPhone XS', 13),
(40, 'Oppo ... FIND X', 14);

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `client_ID` int(11) NOT NULL,
  `index_ID` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_ID`, `Name`) VALUES
(1, 'CLOTHES'),
(3, 'MOBILE'),
(6, 'Vehicles');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `client_ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Group_ID` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`client_ID`, `username`, `password`, `Group_ID`, `avatar`, `Date`) VALUES
(12, 'eslam', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 'default.jpg', '2019-05-01'),
(13, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 'adult-chill-connection-450271.jpg', '2019-05-04'),
(14, 'zanhom', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'adorable-beautiful-boy-35537.jpg', '2019-05-05'),
(15, 'ga3fer', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'adult-blur-close-up-325682.jpg', '2019-05-05'),
(16, 'mustafa', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'adult-angry-businessman-428364.jpg', '2019-05-05'),
(20, 'ahmed123', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 'adult-asian-blue-936593.jpg', '2019-05-05'),
(22, 'noor', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '67610-adult-boy-casual-220453.jpg', '2019-05-07'),
(23, 'bader', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '40488-adult-blur-books-842567.jpg', '2019-05-07'),
(27, 'hossam', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '85307-boy-casual-eyes-1222271.jpg', '2019-05-07'),
(28, 'user1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '45058-black-and-white-boy-casual-555790.jpg', '2019-05-10'),
(29, 'user2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '2972-black-and-white-boy-casual-555790.jpg', '2019-05-10'),
(30, 'user3', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '29793-black-and-white-boy-casual-555790.jpg', '2019-05-10'),
(31, 'user5', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '19818-black-and-white-boy-casual-555790.jpg', '2019-05-10'),
(32, 'user10', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '16649-black-and-white-boy-casual-555790.jpg', '2019-05-10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`client_ID`,`index_ID`),
  ADD KEY `index_ID` (`index_ID`);

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `section_ID` (`section_ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `client_products`
--
ALTER TABLE `client_products`
  ADD PRIMARY KEY (`client_ID`,`P_ID`),
  ADD UNIQUE KEY `index_ID` (`index_ID`),
  ADD UNIQUE KEY `index_ID_2` (`index_ID`),
  ADD UNIQUE KEY `product_image` (`product_image`),
  ADD KEY `P_ID` (`P_ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `client_ID` (`client_ID`),
  ADD KEY `P_ID` (`P_ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`client_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`E_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`O_ID`),
  ADD KEY `client_ID` (`client_ID`),
  ADD KEY `E-ID` (`E_ID`);

--
-- Indexes for table `order_address`
--
ALTER TABLE `order_address`
  ADD PRIMARY KEY (`address_ID`),
  ADD KEY `order_ID` (`order_ID`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`O_ID`,`index_ID`),
  ADD KEY `index_ID` (`index_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `cat-ID` (`cat_ID`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`client_ID`,`index_ID`),
  ADD KEY `index_ID` (`index_ID`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`client_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `avatar` (`avatar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `client_products`
--
ALTER TABLE `client_products`
  MODIFY `index_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `E_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `O_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_address`
--
ALTER TABLE `order_address`
  MODIFY `address_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`index_ID`) REFERENCES `client_products` (`index_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `catagory`
--
ALTER TABLE `catagory`
  ADD CONSTRAINT `catagory_ibfk_1` FOREIGN KEY (`section_ID`) REFERENCES `section` (`section_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_products`
--
ALTER TABLE `client_products`
  ADD CONSTRAINT `client_products_ibfk_1` FOREIGN KEY (`P_ID`) REFERENCES `products` (`P_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_products_ibfk_2` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`P_ID`) REFERENCES `client_products` (`index_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`E_ID`) REFERENCES `employee` (`E_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_address`
--
ALTER TABLE `order_address`
  ADD CONSTRAINT `order_address_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`O_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`O_ID`) REFERENCES `orders` (`O_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`index_ID`) REFERENCES `client_products` (`index_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_ID`) REFERENCES `catagory` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`index_ID`) REFERENCES `client_products` (`index_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`client_ID`) REFERENCES `client` (`client_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

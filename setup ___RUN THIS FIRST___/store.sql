-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2016 at 08:17 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `session_id` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `size` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`session_id`, `product_id`, `qty`, `size`) VALUES
('568ff2f268692', 13, 3, 'Standard'),
('568ff2f268692', 16, 1, 'Standard'),
('568ff2f268692', 12, 1, 'Standard'),
('569405c9cf55d', 17, 37, 'Standard'),
('569404c4bdaca', 1, 18, 'Standard'),
('569404c4bdaca', 7, 12, 'Standard'),
('56de8f716d827', 24, 1, 'Standard'),
('56de8f716d827', 23, 2, 'Standard'),
('56fc1c285916e', 24, 1, 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) DEFAULT NULL,
  `first_name` varchar(40) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address_1` varchar(50) DEFAULT NULL,
  `address_2` varchar(50) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `state` varchar(40) DEFAULT NULL,
  `zip_code` varchar(15) DEFAULT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `session_id`, `first_name`, `last_name`, `address_1`, `address_2`, `city`, `state`, `zip_code`, `phone`, `email`) VALUES
(1, '56924584e477d', 'Haider', 'Khichi', '2-S-16 E/5 Pir Ghazi Rd, ', '', 'Lahore', 'Punjab', 's', '03334772894', ''),
(2, '569408426cc2a', 'Haider', 'Khichi', '2-S 16 e/5 pir ghazi rd, ichraa, Lahore', '', 'Lahore', 'Punjab', '54000', '03334772894', '');

-- --------------------------------------------------------

--
-- Table structure for table `imgs_ref`
--

CREATE TABLE IF NOT EXISTS `imgs_ref` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` int(11) DEFAULT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `imgs_ref`
--

INSERT INTO `imgs_ref` (`img_id`, `product_code`, `img_path`) VALUES
(1, 18, '18chrysanthemum.jpg'),
(3, 19, '19desert.jpg'),
(4, 19, '19hydrangeas.jpg'),
(5, 19, '19jellyfish.jpg'),
(6, 24, '24desert.jpg'),
(7, 24, '24hydrangeas.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` varchar(100) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `cost_subtotal` decimal(6,2) DEFAULT NULL,
  `shipping_subtotal` decimal(6,2) DEFAULT NULL,
  `cost_tax` decimal(6,2) DEFAULT NULL,
  `cost_total` decimal(6,2) DEFAULT NULL,
  `shipping_first_name` varchar(20) DEFAULT NULL,
  `shipping_last_name` varchar(20) DEFAULT NULL,
  `shipping_address_1` varchar(50) DEFAULT NULL,
  `shipping_address_2` varchar(50) DEFAULT NULL,
  `shipping_city` varchar(20) DEFAULT NULL,
  `shipping_state` varchar(20) DEFAULT NULL,
  `shipping_zipcode` varchar(20) DEFAULT NULL,
  `shipping_phone` varchar(40) DEFAULT NULL,
  `shipping_email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `customer_id`, `cost_subtotal`, `shipping_subtotal`, `cost_tax`, `cost_total`, `shipping_first_name`, `shipping_last_name`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_state`, `shipping_zipcode`, `shipping_phone`, `shipping_email`) VALUES
(2, '01-12-2016, Tuesday, 12:54:57 am', 2, '24.00', '10.00', '2.00', '36.00', 'Haider', 'Khichi', '2-S 16 e/5 pir ghazi rd, ichraa, Lahore', '', 'Lahore', 'Punjab', '54000', '03334772894', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `order_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `size` varchar(40) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `order_qty`, `size`, `product_id`) VALUES
(2, 12, 'Standard', 7);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `description` text,
  `price` varchar(100) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `sold` int(11) NOT NULL,
  PRIMARY KEY (`product_code`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_code`, `name`, `description`, `price`, `img`, `stock`, `sold`) VALUES
(1, 'SmoothMove Box', 'This is a kick-ass box which will let you move your things anywhere. Always to your rescue. It will never bail you out', '6.90', '1.jpg', 43, 0),
(2, 'Simple Box', '<p>This is a simple box. It is as simple as a box can get. Great for moving things</p>', '2.40', '2.jpg', 14, 0),
(3, 'Small Box', '<p>This is a small box. Great for storing small shit</p>', '1.50', '3.jpg', 24, 0),
(4, 'Black Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', '4.jpg', 43, 0),
(5, 'Pink Box', '<p>This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc</p>', '10.00', '5.jpg', 16, 0),
(6, 'White Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', '6.jpg', 43, 0),
(7, 'Noodles Box', '<p>This is a box made especially for Noodles. Great for your Chinese noodles shop</p>', '2.00', '7.jpg', 15, 42),
(8, 'Yellow Cylindrical box', 'This is the coolest box ever. You can store anything you like in it', '3.40', '8.jpg', 43, 0),
(9, 'Wooden Box', 'This is a treasure like wooden box. Great for storing old things to show to your grand-children', '50.00', '9.jpg', 43, 0),
(10, 'A box', 'No, really.. it''s a box. Just a simple box. You know what you can do with it', '1.00', '10.jpg', 43, 0),
(11, 'Soap Box', 'This is really cool soap box. You can store your soap in it while you''re traveling', '2.40', '11.jpg', 43, 0),
(12, 'Plastic Soap Box', 'This is a cool transparent soap storing box. You can however store anything in it', '3.50', '12.jpg', 43, 0),
(13, 'Big Box', 'This box is made of cardboard. It''s great for using when you''re moving to another apartment', '4.00', '13.jpg', 43, 0),
(14, 'Blue Box', 'This is a box made of cotton and polyester. Great for storing laundry / newspapers.. etc', '10.00', '14.jpg', 43, 0),
(15, 'Lunch Box', 'This is the coolest, adorable, recyclable cardboard lunch box. You will be coolest person in the school/office if you use this box to store your delicious lunch', '1.99', '15.jpg', 43, 0),
(16, 'Wooden Box w/ a hole', 'This is a box made of wood. You can store your books in it or any other thing you like', '46.00', '16.jpg', 42, 1),
(17, 'Green Box', 'This box is made of cardboard and it also has a lid on it!', '2.00', '17.jpg', 39, 4),
(18, 'l', '<p>l</p>', '5', '18Desert.jpg', 2, 0),
(19, 'l', '<p>l</p>', '5', '19Desert.jpg', 2, 0),
(20, 'test', '<p>test</p>', '2', NULL, 2, 0),
(21, 'test', '<p>test</p>', '2', NULL, 2, 0),
(22, 'test', '<p>test</p>', '2', '22hydrangeas.jpg', 2, 0),
(23, 'Final test', '<p>final test</p>', '3', '23chrysanthemum.jpg', 3, 0),
(24, 'Final test', '<p>final test</p>', '3', '24koala.jpg', 3, 0),
(25, 'test', '<p>test</p>', '3', '25jellyfish.jpg', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE IF NOT EXISTS `product_details` (
  `product_code` int(11) NOT NULL,
  `category` varchar(40) NOT NULL,
  `size` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`product_code`, `category`, `size`) VALUES
(18, 'Shoes', '5'),
(18, 'Shoes', '5.5'),
(18, 'Shoes', '6'),
(18, 'Shoes', '7'),
(18, 'No cat.', 'Standard'),
(19, 'No cat.', 'Standard'),
(20, 'No cat.', 'Standard'),
(21, 'No cat.', 'Standard'),
(22, 'No cat.', 'Standard'),
(23, 'No cat.', 'Standard'),
(24, 'No cat.', 'Standard'),
(25, 'No cat.', 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `pswd` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pswd`) VALUES
(1, 'admin', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

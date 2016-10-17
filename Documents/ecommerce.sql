-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2016 at 09:27 PM
-- Server version: 5.7.9
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
  `product_id` int(11) NOT NULL,
  `attribute` enum('author','artist','director','publisher','genre','pages','runtime','studio','ISBN-10','rating','actor','year') NOT NULL,
  `value` varchar(255) NOT NULL,
  `level` enum('1','2','3') NOT NULL,
  PRIMARY KEY (`product_id`,`attribute`,`value`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`product_id`, `attribute`, `value`, `level`) VALUES
(1, 'author', 'Hawking, Stephen', '1'),
(1, 'publisher', 'Bantam', '2'),
(1, 'genre', 'Nonfiction', '2'),
(1, 'genre', 'Science', '2'),
(1, 'pages', '212', '2'),
(2, 'artist', 'Iron and Wine', '1'),
(2, 'publisher', 'Sub Pop', '2'),
(2, 'genre', 'Folk', '2'),
(2, 'genre', 'Indie', '2'),
(2, 'genre', 'Rock', '2'),
(2, 'runtime', '49:43', '2'),
(3, 'director', 'Coen, Joel and Ethan', '1'),
(3, 'publisher', 'Universal Studios', '2'),
(3, 'genre', 'Comedy', '2'),
(3, 'runtime', '119', '2'),
(4, 'author', 'Orwell, George', '1'),
(4, 'publisher', 'Signet', '2'),
(4, 'genre', 'Fiction', '2'),
(4, 'genre', 'Science Fiction', '2'),
(4, 'pages', '328', '2'),
(4, 'ISBN-10', '0451524934', '2'),
(5, 'author', 'McCourt, Frank', '1'),
(5, 'publisher', 'Scribner', '2'),
(5, 'genre', 'Memoir', '2'),
(5, 'genre', 'Nonfiction', '2'),
(5, 'pages', '368', '2'),
(5, 'ISBN-10', '068484267X', '2'),
(6, 'author', 'Bradbury, Ray', '1'),
(6, 'publisher', 'Simon & Schuster', '2'),
(6, 'genre', 'Fiction', '2'),
(6, 'genre', 'Science Fiction', '2'),
(6, 'pages', '249', '2'),
(6, 'ISBN-10', '1451673310', '2'),
(7, 'director', 'Tarantino, Quentin', '1'),
(7, 'genre', 'Comedy', '2'),
(7, 'genre', 'Drama', '2'),
(7, 'runtime', '154', '2'),
(7, 'studio', 'Lionsgate', '2'),
(7, 'rating', 'R', '2'),
(8, 'director', 'Ramis, Harold', '1'),
(8, 'genre', 'Comedy', '2'),
(8, 'runtime', '99', '2'),
(8, 'studio', 'Warner Bros.', '2'),
(8, 'rating', 'R', '2'),
(8, 'year', '1980', '2');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `CID` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` enum('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY','DC','PR','VI') NOT NULL,
  `zip` varchar(20) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `OID` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `date` timestamp NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping` decimal(6,2) NOT NULL,
  `tax` decimal(8,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `status` enum('cart','ordered','shipped') NOT NULL,
  PRIMARY KEY (`OID`),
  KEY `customer` (`customer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `order_prod_prod` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `inventory` int(11) NOT NULL,
  PRIMARY KEY (`PID`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`PID`, `name`, `type`, `description`, `image`, `price`, `inventory`) VALUES
(1, 'A Brief History of Time', 'Books', 'A landmark volume in science writing by one of the great minds of our time, Stephen Hawking''s book explores such profound questions as: How did the universe begin-and what made its start possible? Does time always flow forward? Is the universe unending-or are there boundaries? Are there other dimensions in space? What will happen when it all ends?', 'https://s-media-cache-ak0.pinimg.com/originals/a5/73/be/a573be563fecff948098e4a852ce04b7.jpg', '11.99', 0),
(2, 'The Shepherd''s Dog', 'Music', 'Following a one-record hiatus to collaborate with Tucson collective Calexico on 2005''s In The Reins, Iron & Wine (Sam Beam, that is) recoils to the earnestness and intimacy that embodied his first two records, his cerebral words and phrases tunneled beneath an orchestra of guitar, banjo, keyboards, and strings. More definitive than ever, the rhythm and percussion complement Beam''s voice, a lulling, almost eerie tone that occasionally recalls John Lennon''s early solo work, especially on delicate tracks like the bluesy "Wolves (Songs of the Shepherd''s Dog" and "Carousel," with its veiled references to Iraq. Those raised on the lo-fi routine of Beam''s earlier work will find rawness and sanctity in the more upbeat selections: The CSN folk-rock of "House by the Sea" and "Boy with a Coin" and the atmospheric beauty of "Pagan Angel and a Borrowed Car" and Shepherd''s best song, "Lovesong of the Buzzard." With an organ swirling about and a slide guitar adding gentle flourishes, Beam concedes that "no one is the savior they would like to be," without realizing that, when it comes to fluent music and pristine storytelling, perhaps he is. --Scott Holter', 'https://subpop-img.s3.amazonaws.com/asset/productable_images/attachments/000/001/000/max_960/3507.jpg?1389003323', '9.99', 0),
(3, 'The Big Lebowski', 'Movies', 'The Coen brothers'' irreverent cult hit comes to DVD as a Collector''s Edition, with all-new bonus material. The hilariously twisted comedy-thriller stars Jeff Bridges, John Goodman, Steve Buscemi and Julianne Moore. Join the "Dude" and his bowling buddies on their journey that blends unforgettable characters, kidnapping, a case of mistaken identity and White Russians. Enter the visually unique and entertaining world from the creative minds of the Coen brothers and remember: the Dude abides.', 'https://www.filmonpaper.com/site/media/2014/04/TheBigLebowski_onesheet_international-1.jpg', '8.50', 0),
(4, '1984', 'Books', 'Written in 1948, 1984 was George Orwell''s chilling prophecy about the future. And while 1984 has come and gone, Orwell''s narrative is timelier than ever. 1984 presents a startling and haunting vision of the world, so powerful that it is completely convincing from start to finish. No one can deny the power of this novel, its hold on the imaginations of multiple generations of readers, or the resiliency of its admonitions—a legacy that seems only to grow with the passage of time.', 'https://images-na.ssl-images-amazon.com/images/I/31BJ1bAJUGL._SX310_BO1,204,203,200_.jpg', '10.49', 0),
(5, 'Angela''s Ashes', 'Books', 'A Pulitzer Prize–winning, #1 New York Times bestseller, Angela’s Ashes is Frank McCourt''s masterful memoir of his childhood in Ireland.', 'https://images-na.ssl-images-amazon.com/images/I/51ILSNc5CHL._SX326_BO1,204,203,200_.jpg', '12.49', 0),
(6, 'Fahrenheit 451', 'Books', 'Ray Bradbury''s internationally acclaimed novel Fahrenheit 451 is a masterwork of twentieth-century literature set in a bleak, dystopian future.', 'https://images-na.ssl-images-amazon.com/images/I/41Cx8mY2UNL._SX324_BO1,204,203,200_.jpg', '7.29', 0),
(7, 'Pulp Fiction', 'Movies', 'Tarantino weaves together several stories that juggle plot lines, time frames and characters that inhabit the seamy side of Los Angeles -- including Travolta and Jackson as hit-men with strong moral codes, Willis as a low-life boxer and, of course, The Gimp.', 'https://images-na.ssl-images-amazon.com/images/I/91Wpbzk%2BHCL._SY500_.jpg', '8.79', 0),
(8, 'Caddyshack', 'Movies', 'A comedy about a construction tycoon who tries to join a snobby country club that doesn''t want him as a member.', 'https://images-na.ssl-images-amazon.com/images/I/91akYx3LjfL._SX425_.jpg', '5.99', 0);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type`) VALUES
('Books'),
('Movies'),
('Music');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `product_attributes` FOREIGN KEY (`product_id`) REFERENCES `products` (`PID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_customer` FOREIGN KEY (`customer`) REFERENCES `customers` (`CID`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_prod_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`OID`),
  ADD CONSTRAINT `order_prod_prod` FOREIGN KEY (`product_id`) REFERENCES `products` (`PID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_types` FOREIGN KEY (`type`) REFERENCES `types` (`type`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

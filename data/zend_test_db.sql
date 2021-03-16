-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2021 at 07:53 PM
-- Server version: 10.5.9-MariaDB-1:10.5.9+maria~focal
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zend_test_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--
-- Creation: Mar 13, 2021 at 10:48 PM
-- Last update: Mar 16, 2021 at 03:41 PM
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `product_id`, `artist_id`, `title`) VALUES
(1, 6, 1, 'In My Dreams'),
(2, 7, 2, '21'),
(3, 8, 3, 'Wrecking Ball (Deluxe)'),
(4, 9, 4, 'Born To Die'),
(5, 10, 5, 'Making Mirrors');

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--
-- Creation: Mar 13, 2021 at 10:30 PM
-- Last update: Mar 13, 2021 at 10:43 PM
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`id`, `name`) VALUES
(2, 'Adele'),
(3, 'Bruce Springsteen'),
(5, 'Gotye'),
(4, 'Lana Del Rey'),
(1, 'The Military Wives');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--
-- Creation: Mar 13, 2021 at 10:31 PM
-- Last update: Mar 16, 2021 at 03:45 PM
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(1, 'Dana Perino'),
(4, 'Dav Pilkey'),
(6, 'Horace G. Feliu'),
(8, 'Jack Arbor'),
(5, 'Marilyn Sadler'),
(9, 'Matt McCormick'),
(3, 'Sister Souljah'),
(7, 'Steven Pressfield'),
(10, 'Tarryn Fisher'),
(2, 'Walter Isaacson');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--
-- Creation: Mar 13, 2021 at 10:41 PM
-- Last update: Mar 16, 2021 at 03:50 PM
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `isbn` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `product_id`, `author_id`, `title`, `isbn`) VALUES
(1, 1, 1, 'Everything Will Be Okay: Life Lessons for Young Women (from a Former Young Woman)', '1538737086'),
(2, 2, 2, 'The Code Breaker: Jennifer Doudna, Gene Editing, and the Future of the Human Race', '1982115858'),
(3, 3, 3, 'Life After Death', '1982139137'),
(4, 4, 4, 'Dog Man: Mothering Heights', '1338680455'),
(5, 5, 5, 'It\'s Not Easy Being a Bunny', '0394861027'),
(6, 28, 6, 'The UNREVEALED', '8976576432'),
(7, 29, 7, 'A Man at Arms', '0393540979'),
(8, 30, 8, 'The Russian Assassin: A Max Austin Thriller', '1232425324'),
(9, 31, 9, 'The Prototype', '6543623423'),
(10, 32, 10, 'The Wrong Family', '6345347643');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--
-- Creation: Mar 13, 2021 at 10:28 PM
-- Last update: Mar 16, 2021 at 03:46 PM
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(28),
(29),
(30),
(31),
(32);

-- --------------------------------------------------------

--
-- Table structure for table `thriller`
--
-- Creation: Mar 13, 2021 at 10:48 PM
-- Last update: Mar 16, 2021 at 03:51 PM
--

DROP TABLE IF EXISTS `thriller`;
CREATE TABLE `thriller` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `excitement_factor` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `thriller`
--

INSERT INTO `thriller` (`id`, `book_id`, `excitement_factor`) VALUES
(1, 6, 67),
(2, 7, 35),
(3, 8, 79),
(4, 9, 64),
(5, 10, 84);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD UNIQUE KEY `artist_id` (`artist_id`,`title`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD UNIQUE KEY `author_id` (`author_id`,`title`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thriller`
--
ALTER TABLE `thriller`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_id` (`book_id`) USING BTREE,
  ADD KEY `excitement_factor` (`excitement_factor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `thriller`
--
ALTER TABLE `thriller`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `album_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `thriller`
--
ALTER TABLE `thriller`
  ADD CONSTRAINT `thriller_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

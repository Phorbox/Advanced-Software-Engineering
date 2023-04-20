-- Table structure for table `brands`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `brands` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` VALUES
(14, 'Acer'),
(6, 'Apple'),
(15, 'Asus'),
(9, 'Chevorlet'),
(1, 'Chrysler'),
(29, 'Dell'),
(21, 'Epson'),
(20, 'Ford'),
(25, 'Gateway'),
(4, 'Generic'),
(11, 'GM'),
(17, 'Hisense'),
(16, 'HP'),
(31, 'Hyundai'),
(30, 'IBM'),
(22, 'Insignia'),
(19, 'Jeep'),
(7, 'KIA'),
(13, 'Lenovo'),
(10, 'LG'),
(33, 'Matt\'s'),
(34, 'Matt\'s2'),
(2, 'Microsoft'),
(3, 'OnePlus'),
(28, 'Optoma'),
(24, 'Panasonic'),
(8, 'Samsung'),
(5, 'Sony'),
(23, 'TCL'),
(18, 'ViewSonic'),
(26, 'VIZIO'),
(12, 'Westinghouse');

ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_2` (`name`);
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;
--
-- Database: `main`
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `inactive`
--

CREATE TABLE `inactive` (
  `id` int NOT NULL,
  `table` varchar(255) NOT NULL,
  `key` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inactive`
--

INSERT INTO `inactive` VALUES
(3, 'brands', 4),
(1, 'brands', 6);


ALTER TABLE `inactive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `table_2` (`table`,`key`),
  ADD KEY `table` (`table`),
  ADD KEY `key` (`key`);
ALTER TABLE `inactive`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

COMMIT;


-- -----------------
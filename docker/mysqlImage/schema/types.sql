
START TRANSACTION;
--
-- Database: `main`
--


CREATE TABLE `types` (
  `id` int NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` VALUES
(4, 'computer'),
(7, 'laptop'),
(3, 'mobile phone'),
(2, 'projector'),
(6, 'tablet'),
(5, 'television'),
(1, 'vehicle');

ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;
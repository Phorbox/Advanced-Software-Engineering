
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

CREATE TABLE `inactive` (
  `id` int NOT NULL,
  `table` varchar(255) NOT NULL,
  `key` int NOT NULL,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO
  `inactive` (`id`, `table`, `key`, `name`)
VALUES
  (18, 'brands', 14, 'Acer'),
  (19,'equipment_production',1,'SN-5b1ab1c6dfcd8c0f16f4dce3a07f6cf8'),
  (21, 'types', 3, 'mobile'),
  (22, 'brands', 6, 'Apple');


ALTER TABLE
  `inactive`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `table_2` (`table`, `key`),
ADD
  KEY `table` (`table`),
ADD
  KEY `key` (`key`),
ADD
  KEY `name` (`name`);

ALTER TABLE
  `inactive`
MODIFY
  `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 23;

COMMIT;


-- Adminer 4.7.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_number` varchar(55) DEFAULT NULL,
  `category_name` varchar(55) DEFAULT NULL,
  `departmant_name` varchar(255) DEFAULT NULL,
  `manufacturer_name` varchar(255) DEFAULT NULL,
  `upc` bigint(20) DEFAULT NULL,
  `sku` bigint(20) DEFAULT NULL,
  `regular_price` decimal(10,0) DEFAULT NULL,
  `sale_price` decimal(10,0) DEFAULT NULL,
  `description` text,
  `url` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2020-09-13 17:21:06
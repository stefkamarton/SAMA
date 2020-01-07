SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `sama` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `sama`;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `cards` (
  `uid` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `step` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
CREATE TABLE `products` (
  `pid` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `count` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;
CREATE TABLE `prod_history` (
  `id` int(11) NOT NULL,
  `pid` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `step` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `money` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

ALTER TABLE `cards`
  ADD PRIMARY KEY (`uid`);
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);
ALTER TABLE `prod_history`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
ALTER TABLE `prod_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
ALTER TABLE `history`
  ADD CONSTRAINT `uid` FOREIGN KEY (`uid`) REFERENCES `cards` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

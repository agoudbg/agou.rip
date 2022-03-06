SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `post` (
  `id` varchar(8) NOT NULL,
  `nick` text CHARACTER SET utf8mb4,
  `email` text,
  `text` text CHARACTER SET utf8mb4 NOT NULL,
  `public` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `ip` text CHARACTER SET utf8mb4 NOT NULL,
  `reply` text,
  `reply_time` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 14 2015 г., 10:48
-- Версия сервера: 5.5.43-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yii2_test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `preview` varchar(255) NOT NULL, 
  `date` date NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `name`, `created`, `updated`, `preview`, `date`, `author_id`) VALUES
(1, 'Автор 2', '2015-03-06', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 1),
(2, 'Автор 3', '2015-03-08', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 2),
(3, 'Автор 4', '2015-03-09', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 3),
(4, 'Автор 5', '2015-03-10', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 4),
(5, 'Автор 6', '2015-03-12', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 1),
(6, 'Автор 7', '2015-04-06', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 2),
(7, 'Автор 8', '2015-05-06', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 3),
(8, 'Автор 9', '2015-05-07', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 4),
(9, 'Автор 10', '2015-05-07', '2015-05-06', 'web/0347_23e2.jpg', '2015-05-06', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `firstname`, `lastname`) VALUES
(1, 'Имя 1', 'Фамилия 1'),
(2, 'Имя 2', 'Фамилия 2'),
(3, 'Имя 3', 'Фамилия 3'),
(4, 'Имя 4', 'Фамилия 4'),
(5, 'Имя 5', 'Фамилия 5'),
(6, 'Имя 6', 'Фамилия 6'),
(7, 'Имя 7', 'Фамилия 7'),
(8, 'Имя 8', 'Фамилия 8'),
(9, 'Имя 9', 'Фамилия 9');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

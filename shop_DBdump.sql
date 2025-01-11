-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 192.168.1.253:3306
-- Время создания: Янв 11 2025 г., 12:48
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parent_id`, `slug`) VALUES
(1, 0, 'kompyuteri'),
(3, 0, 'noutbuki'),
(4, 3, 'mac'),
(5, 3, 'windows'),
(6, 0, 'telefoni'),
(7, 0, 'kamery'),
(29, 0, 'ycukenycu-29');

-- --------------------------------------------------------

--
-- Структура таблицы `category_description`
--

CREATE TABLE `category_description` (
  `category_id` int UNSIGNED NOT NULL,
  `language_id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `content` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category_description`
--

INSERT INTO `category_description` (`category_id`, `language_id`, `title`, `description`, `keywords`, `content`) VALUES
(1, 1, 'Компьютеры', '', '', '<p>Текст контента На Русском языке 123!</p>'),
(1, 2, 'Computers', '', '', '<p>English Content 123!?</p>'),
(3, 1, 'Ноутбуки', '', '', 'Текст контента На Русском языке 123!'),
(3, 2, 'Notebooks', '', '', 'English Content 123!?'),
(4, 1, 'Mac', '', '', 'Текст контента На Русском языке 123!'),
(4, 2, 'Mac', '', '', 'English Content 123!?'),
(5, 1, 'Windows', '', '', 'Текст контента На Русском языке 123!'),
(5, 2, 'Windows', '', '', 'English Content 123!?'),
(6, 1, 'Телефоны', '', '', 'Текст контента На Русском языке 123!'),
(6, 2, 'Phones', '', '', 'English Content 123!?'),
(7, 1, 'Камеры', '', '', '<p>Текст контента На Русском языке 123!</p>'),
(7, 2, 'Cameras', '', '', '<p>English Content 123!?</p>'),
(29, 1, 'йцукенйцу', 'йцу', 'йц', '<p>й2</p>'),
(29, 2, 'qwert123', 'qwe', 'qw', '<p>q1</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `digital`
--

CREATE TABLE `digital` (
  `id` int UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `digital`
--

INSERT INTO `digital` (`id`, `filename`, `original_name`) VALUES
(1, 'windows12.zip.123234345456', 'windows12.zip'),
(2, 'mac_video.txt.123123123', 'mac-video.txt'),
(3, '100.jpg.123654789', '100.jpg'),
(6, 'sketch_nov18a.ino.bin.677d91b916a0b', 'sketch_nov18a.ino.bin');

-- --------------------------------------------------------

--
-- Структура таблицы `digital_description`
--

CREATE TABLE `digital_description` (
  `digital_id` int UNSIGNED NOT NULL,
  `language_id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `digital_description`
--

INSERT INTO `digital_description` (`digital_id`, `language_id`, `name`) VALUES
(1, 1, 'Шиндоус 12'),
(1, 2, 'Windows 12 iso'),
(2, 1, 'Мак видео'),
(2, 2, 'Mac videooo'),
(3, 1, 'пик'),
(3, 2, 'pic'),
(6, 1, 'asd'),
(6, 2, 'qwe');

-- --------------------------------------------------------

--
-- Структура таблицы `language`
--

CREATE TABLE `language` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `base` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `language`
--

INSERT INTO `language` (`id`, `code`, `title`, `base`) VALUES
(1, 'ru', 'Русский', 1),
(2, 'en', 'English', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total` double NOT NULL,
  `qty` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `note`, `created_at`, `updated_at`, `total`, `qty`) VALUES
(43, 6, 0, 'qwe123', '2025-01-02 18:03:03', '2025-01-10 10:11:48', 197, 6),
(44, 6, 0, 'йцу123', '2025-01-02 18:12:44', '2025-01-02 18:12:44', 197, 6),
(45, 8, 0, 'qweqwe 1', '2025-01-02 18:17:42', '2025-01-02 18:17:42', 197, 6),
(46, 8, 0, 'qweqwe 123', '2025-01-02 18:19:33', '2025-01-10 09:58:34', 197, 6),
(47, 8, 0, '', '2025-01-02 18:22:34', '2025-01-10 09:58:26', 197, 6),
(48, 8, 0, '', '2025-01-02 18:23:24', '2025-01-02 18:23:24', 197, 6),
(49, 8, 0, '', '2025-01-02 18:24:25', '2025-01-02 18:24:25', 197, 6),
(50, 8, 0, '', '2025-01-02 18:26:22', '2025-01-02 18:26:22', 197, 6),
(51, 8, 0, '', '2025-01-02 18:29:11', '2025-01-04 07:46:46', 197, 6),
(52, 8, 0, 'qwe', '2025-01-02 18:30:38', '2025-01-10 09:58:38', 13, 1),
(53, 6, 0, 'qwe1', '2025-01-02 20:27:03', '2025-01-02 20:27:03', 113, 3),
(54, 8, 0, '', '2025-01-03 11:21:06', '2025-01-03 11:21:06', 230, 2),
(55, 8, 0, '', '2025-01-03 11:53:26', '2025-01-03 11:53:26', 150, 1),
(56, 8, 0, '', '2025-01-03 14:52:39', '2025-01-03 14:52:39', 18, 1),
(57, 12, 1, '', '2025-01-10 09:54:36', '2025-01-10 10:02:57', 123273, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `order_digital`
--

CREATE TABLE `order_digital` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `digital_id` int UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_digital`
--

INSERT INTO `order_digital` (`id`, `order_id`, `user_id`, `product_id`, `digital_id`, `status`) VALUES
(19, 43, 6, 6, 2, 0),
(20, 44, 6, 6, 2, 1),
(21, 45, 8, 6, 2, 1),
(22, 46, 8, 6, 2, 1),
(23, 47, 8, 6, 2, 1),
(24, 48, 8, 6, 2, 1),
(25, 49, 8, 6, 2, 1),
(26, 50, 8, 6, 2, 1),
(27, 51, 8, 6, 2, 1),
(28, 53, 6, 6, 2, 1),
(29, 54, 8, 6, 2, 1),
(30, 54, 8, 5, 1, 1),
(31, 55, 8, 5, 1, 1),
(32, 57, 12, 5, 1, 1),
(33, 57, 12, 21, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `order_product`
--

CREATE TABLE `order_product` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `price` double NOT NULL,
  `sum` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `title`, `slug`, `qty`, `price`, `sum`) VALUES
(31, 43, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(32, 43, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(33, 43, 3, 'imac (ру)', 'imac', 1, 50, 50),
(34, 43, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(35, 43, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(36, 43, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(37, 44, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(38, 44, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(39, 44, 3, 'imac (ру)', 'imac', 1, 50, 50),
(40, 44, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(41, 44, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(42, 44, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(43, 45, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(44, 45, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(45, 45, 3, 'imac (ру)', 'imac', 1, 50, 50),
(46, 45, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(47, 45, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(48, 45, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(49, 46, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(50, 46, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(51, 46, 3, 'imac (ру)', 'imac', 1, 50, 50),
(52, 46, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(53, 46, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(54, 46, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(55, 47, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(56, 47, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(57, 47, 3, 'imac (ру)', 'imac', 1, 50, 50),
(58, 47, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(59, 47, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(60, 47, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(61, 48, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(62, 48, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(63, 48, 3, 'imac (ру)', 'imac', 1, 50, 50),
(64, 48, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(65, 48, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(66, 48, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(67, 49, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(68, 49, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(69, 49, 3, 'imac (ру)', 'imac', 1, 50, 50),
(70, 49, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(71, 49, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(72, 49, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(73, 50, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(74, 50, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(75, 50, 3, 'imac (ру)', 'imac', 1, 50, 50),
(76, 50, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(77, 50, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(78, 50, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(79, 51, 2, 'mac pro mini (ру)', 'mac-pro-mini', 1, 20, 20),
(80, 51, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(81, 51, 3, 'imac (ру)', 'imac', 1, 50, 50),
(82, 51, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(83, 51, 9, 'Компьютер-4', 'komputer-4', 1, 14, 14),
(84, 51, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(85, 52, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(86, 53, 8, 'Компьютер-3', 'komputer-3', 1, 13, 13),
(87, 53, 4, 'iphone 15 (ру)', 'iphone-15', 1, 20, 20),
(88, 53, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(89, 54, 6, 'Видео мак', 'mac-video', 1, 80, 80),
(90, 54, 5, 'windows 12 (ру)', 'windows-12', 1, 150, 150),
(91, 55, 5, 'windows 12 (ру)', 'windows-12', 1, 150, 150),
(92, 56, 13, 'Компьютер-8', 'komputer-8', 1, 18, 18),
(93, 57, 5, 'windows 12 (ру)', 'windows-12', 1, 150, 150),
(94, 57, 21, 'имя ру', 'imya-ru', 1, 123123, 123123);

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `id` int UNSIGNED NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `slug`) VALUES
(3, 'kontakti'),
(1, 'o-magazine'),
(2, 'oplata-i-dostavka'),
(5, 'test111111');

-- --------------------------------------------------------

--
-- Структура таблицы `page_description`
--

CREATE TABLE `page_description` (
  `page_id` int UNSIGNED NOT NULL,
  `language_Id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `page_description`
--

INSERT INTO `page_description` (`page_id`, `language_Id`, `title`, `content`, `keywords`, `description`) VALUES
(1, 1, 'О магазине', 'Контент страницы О магазине', '', ''),
(1, 2, 'About shop', 'Content of the About shop', '', ''),
(2, 1, 'Оплата и доставка', 'Контент страницы Оплата и доставка', '', ''),
(2, 2, 'Payment and delivery', 'Content of the page Payment and delivery', '', ''),
(3, 1, 'Контакты', 'Контент страницы Контакты', '', ''),
(3, 2, 'Contacts', 'Content of the Contacts', '', ''),
(5, 1, 'Тест1234', '<p>йцу</p><figure class=\"image\"><img src=\"/public/uploads/images/2025-1-6/100.jpg\"></figure>', '', ''),
(5, 2, 'test111111', '<p>qwe123</p>', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `old_price` double NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `hit` tinyint NOT NULL DEFAULT '0',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'uploads/no_image.jpg',
  `is_digital` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `category_id`, `slug`, `price`, `old_price`, `status`, `hit`, `img`, `is_digital`) VALUES
(1, 7, 'nikon-d5600-1', 300, 12, 1, 1, '/public/uploads/2024/12/4/nikon-d5600_1.jpg', 1),
(2, 4, 'mac-pro-mini-2', 20, 15, 1, 1, '/public/uploads/2024/12/4/mac-pro-mini_1.jpg', 1),
(3, 4, 'imac', 50, 20, 1, 1, '/public/uploads/2024/12/4/imac_1.jpg', 0),
(4, 6, 'iphone-15', 20, 12, 1, 1, '/public/uploads/2024/12/4/iphone-15_1.jpg', 0),
(5, 5, 'windows-12', 150, 0, 1, 1, '/public/uploads/2024/12/4/windows-12_1.jpg', 1),
(6, 4, 'mac-video', 80, 150, 1, 1, '/public/uploads/no_image.jpg', 1),
(7, 1, 'komputer-2', 12, 0, 1, 1, '/public/uploads/no_image.jpg', 0),
(8, 1, 'komputer-3', 13, 0, 1, 1, '/public/uploads/no_image.jpg', 0),
(9, 1, 'komputer-4', 14, 0, 1, 0, '/public/uploads/no_image.jpg', 0),
(10, 1, 'komputer-5', 15, 0, 1, 0, '/public/uploads/no_image.jpg', 0),
(11, 1, 'komputer-6', 16, 0, 1, 0, '/public/uploads/no_image.jpg', 0),
(12, 1, 'komputer-7', 17, 0, 1, 0, '/public/uploads/no_image.jpg', 0),
(13, 1, 'komputer-8', 18, 0, 1, 0, '/public/uploads/no_image.jpg', 0),
(21, 5, 'imya-ru', 123123, 12, 1, 1, '/public/uploads/images/2025-1-6/100.jpg', 1),
(23, 29, 'ang-naim', 123123, 987, 0, 0, '/public/uploads/no_image.jpg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_description`
--

CREATE TABLE `product_description` (
  `product_id` int UNSIGNED NOT NULL,
  `language_id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_description`
--

INSERT INTO `product_description` (`product_id`, `language_id`, `title`, `content`, `excerpt`, `keywords`, `description`) VALUES
(1, 1, 'nikon d5600 (ру)', '<p>Описание русс</p>', 'краткое описание', '', ''),
(1, 2, 'nikon d5600', '<p>english description</p>', 'short description', '', ''),
(2, 1, 'mac pro mini (ру)', '<p>Описание русс</p>', 'краткое описание', '', ''),
(2, 2, 'mac pro mini', '<p>english description</p>', 'short description', '', ''),
(3, 1, 'imac (ру)', 'Описание русс', 'краткое описание', '', ''),
(3, 2, 'imac', 'english description', 'short description', '', ''),
(4, 1, 'iphone 15 (ру)', 'Описание русс', 'краткое описание', '', ''),
(4, 2, 'iphone 15', 'english description', 'short description', '', ''),
(5, 1, 'windows 12 (ру)', 'Описание русс', 'краткое описание', '', ''),
(5, 2, 'windows 12', 'english description', 'short description', '', ''),
(6, 1, 'Видео мак', 'Описание русс', 'краткое описание', '', ''),
(6, 2, 'Video mac', 'english description', 'short description', '', ''),
(7, 1, 'Компьютер-2', 'Описание русс', 'краткое описание', '', ''),
(7, 2, 'komputer-2', 'english description', 'short description', '', ''),
(8, 1, 'Компьютер-3', 'Описание русс', 'краткое описание', '', ''),
(8, 2, 'komputer-3', 'english description', 'short description', '', ''),
(9, 1, 'Компьютер-4', 'Описание русс', 'краткое описание', '', ''),
(9, 2, 'komputer-4', 'english description', 'short description', '', ''),
(10, 1, 'Компьютер-5', 'Описание русс', 'краткое описание', '', ''),
(10, 2, 'komputer-5', 'english description', 'short description', '', ''),
(11, 1, 'Компьютер-6', 'Описание русс', 'краткое описание', '', ''),
(11, 2, 'komputer-6', 'english description', 'short description', '', ''),
(12, 1, 'Компьютер-7', 'Описание русс', 'краткое описание', '', ''),
(12, 2, 'komputer-7', 'english description', 'short description', '', ''),
(13, 1, 'Компьютер-8', 'Описание русс', 'краткое описание', '', ''),
(13, 2, 'komputer-8', 'english description', 'short description', '', ''),
(21, 1, 'имя ру', '<figure class=\"image\"><img src=\"/public/uploads/images/3.jpg\"></figure>', 'йцу', '12', '123'),
(21, 2, 'имя ин', '<p>йцу<img src=\"/public/uploads/images/2025-1-6/100.jpg\"></p><p>йцу12</p>', 'йцу ин', 'йцу', 'йцу'),
(23, 1, 'ру наим23', '<p>нюсь</p><figure class=\"image\"><img src=\"/public/uploads/images/2025-1-6/100.jpg\"></figure>', 'ко1', 'кей1', 'мет1'),
(23, 2, 'анг наим', '<figure class=\"image\"><img src=\"/public/uploads/images/2025-1-6/100.jpg\"></figure><p>нюсь</p>', 'ко2', 'кей2', 'мет2');

-- --------------------------------------------------------

--
-- Структура таблицы `product_digital`
--

CREATE TABLE `product_digital` (
  `product_id` int UNSIGNED NOT NULL,
  `digital_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_digital`
--

INSERT INTO `product_digital` (`product_id`, `digital_id`) VALUES
(5, 1),
(6, 2),
(21, 2),
(23, 2),
(1, 3),
(2, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `product_gallery`
--

CREATE TABLE `product_gallery` (
  `id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_gallery`
--

INSERT INTO `product_gallery` (`id`, `product_id`, `img`) VALUES
(4, 21, '/public/uploads/images/2.jpg'),
(5, 21, '/public/uploads/images/2025-1-6/100.jpg'),
(13, 23, '/public/uploads/images/2025-1-6/100.jpg'),
(14, 2, '/public/uploads/images/1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `slider`
--

CREATE TABLE `slider` (
  `id` int UNSIGNED NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `slider`
--

INSERT INTO `slider` (`id`, `img`) VALUES
(4, '/public/uploads/slider/1.jpg'),
(5, '/public/uploads/slider/2.jpg'),
(6, '/public/uploads/slider/3.jpg'),
(7, '/public/uploads/images/2025-1-6/100.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `address`, `role`) VALUES
(5, 'asd@aqw.qw3', '$2y$10$IVxpSVMYEV3ARZId1lXGeurcY7Kprq3KnH.rkEBQE20WxMMpSt7sK', 'qwdqwd', 'qweqwe', 'user'),
(6, 'qwe@123.ru', '$2y$10$ZMPNUcqK.5jpr8bwx3bgpeRsTDiOnnQCia/s84SV93YGxVBiMUWou', 'user qwe', 'adrzxc', 'user'),
(7, '4@123.ru', '$2y$10$kNuTVe54EJp5s4vtr1R3WOvkEG9nV1/aXRfKcBAN5zXyC6qi64ViS', 'qweasdzxc', 'qwefrg', 'user'),
(8, 'tumbashka@gmail.com', '$2y$10$rltrUapKvvzZ.bO11kIsfu25g/oBEgT1qUPYBOOP2gnlSBKJ/HKKu', 'tumbashka', 'qweqweqwe123 12', 'user'),
(9, 'qwe@qwe.qwe', '$2y$10$qhde.gM4RwDfoNRSG9lPJ.FBIvgFR3WPU/6Y3ci0KKyDzFt5AfbMe', 'qwe', 'qwe', 'user'),
(10, 'tumbashka@gmail.comq', '$2y$10$C5cP98cGv//njNnDa6tOgO7cHxOkxW/nqU.c1mMXhc4YetQUGocxu', 'qweqwe', 'qweqwe', 'user'),
(11, 'qweqweqwe@qwe.qwe', '$2y$10$dBvNv/YANKuzmiyd2Z34MO4ZYkkbZYdTm2JKIHwGl4iwx6iim1KHG', 'qweqwe', 'qweqwe', 'user'),
(12, 'tumbashka@vk.com', '$2y$10$XtwN5HyouvIda/Lf8n5SYeIgbjAGlaiGBR9Yd/DYGEghJ8P3gW17i', 'Admin', 'Secret', 'admin'),
(13, 'tumbashka@gmail.comqw', '$2y$10$B8fS/msrw7mhbfnXIK5NTucntgiUMhu091c/Y5tkJdn5sXm0kUHcK', 'imya', 'adr', 'user'),
(14, 'tumbashka@vk.com123', '$2y$10$Oib6UYppKg6/k4PgKLpnLOlA1iArJyN1Ig/3HmNIN5.FMTEmSL4Ge', 'qwe', 'qwe', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `category_description`
--
ALTER TABLE `category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `language_description` (`language_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `digital`
--
ALTER TABLE `digital`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `digital_description`
--
ALTER TABLE `digital_description`
  ADD PRIMARY KEY (`digital_id`,`language_id`),
  ADD KEY `language_id` (`language_id`);

--
-- Индексы таблицы `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_digital`
--
ALTER TABLE `order_digital`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_digital_ibfk_1` (`digital_id`),
  ADD KEY `order_digital_ibfk_2` (`order_id`),
  ADD KEY `order_digital_ibfk_3` (`product_id`),
  ADD KEY `order_digital_ibfk_4` (`user_id`);

--
-- Индексы таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_ibfk_1` (`order_id`),
  ADD KEY `order_product_ibfk_2` (`product_id`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `page_description`
--
ALTER TABLE `page_description`
  ADD PRIMARY KEY (`page_id`,`language_Id`),
  ADD KEY `language_Id` (`language_Id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `product_description`
--
ALTER TABLE `product_description`
  ADD PRIMARY KEY (`product_id`,`language_id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `product_digital`
--
ALTER TABLE `product_digital`
  ADD PRIMARY KEY (`product_id`,`digital_id`),
  ADD KEY `digital_id` (`digital_id`);

--
-- Индексы таблицы `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `digital`
--
ALTER TABLE `digital`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `language`
--
ALTER TABLE `language`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT для таблицы `order_digital`
--
ALTER TABLE `order_digital`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT для таблицы `page`
--
ALTER TABLE `page`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `product_gallery`
--
ALTER TABLE `product_gallery`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category_description`
--
ALTER TABLE `category_description`
  ADD CONSTRAINT `category_description` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `language_description` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `digital_description`
--
ALTER TABLE `digital_description`
  ADD CONSTRAINT `digital_description_ibfk_1` FOREIGN KEY (`digital_id`) REFERENCES `digital` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `digital_description_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `order_digital`
--
ALTER TABLE `order_digital`
  ADD CONSTRAINT `order_digital_ibfk_1` FOREIGN KEY (`digital_id`) REFERENCES `digital` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_digital_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_digital_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_digital_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `page_description`
--
ALTER TABLE `page_description`
  ADD CONSTRAINT `page_description_ibfk_1` FOREIGN KEY (`language_Id`) REFERENCES `language` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `page_description_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `product_description`
--
ALTER TABLE `product_description`
  ADD CONSTRAINT `product_description_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_description_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `product_digital`
--
ALTER TABLE `product_digital`
  ADD CONSTRAINT `product_digital_ibfk_1` FOREIGN KEY (`digital_id`) REFERENCES `digital` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_digital_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `product_gallery`
--
ALTER TABLE `product_gallery`
  ADD CONSTRAINT `product_gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

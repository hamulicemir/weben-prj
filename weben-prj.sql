-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 34.155.121.89:3306
-- Erstellungszeit: 19. Mai 2025 um 18:00
-- Server-Version: 8.0.40-google
-- PHP-Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `weben-prj`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Hoodies'),
(2, 'Jackets'),
(1, 'Pants'),
(3, 'T-Shirts');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','paypal','voucher','bank debit') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_method` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cart` json DEFAULT NULL,
  `status` enum('pending','processing','shipped','delivered','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `voucher_code` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `voucher_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_method`, `shipping_method`, `cart`, `status`, `created_at`, `voucher_code`, `voucher_amount`) VALUES
(1, 10, 250.00, 'credit_card', '', NULL, 'shipped', '2025-05-01 15:18:59', NULL, NULL),
(2, 10, 211.00, 'credit_card', '', NULL, 'processing', '2025-05-01 15:20:06', NULL, NULL),
(3, 1, 5.00, 'credit_card', 'DHL', '{\"34\": 1, \"35\": 1}', 'pending', '2025-05-10 19:13:05', NULL, NULL),
(4, 1, 5.00, 'credit_card', 'DHL', '{\"34\": 1, \"35\": 1}', 'pending', '2025-05-10 19:17:13', NULL, NULL),
(6, 1, 5.00, 'credit_card', 'DHL', '{\"35\": 1, \"38\": 1}', 'pending', '2025-05-10 19:20:37', NULL, NULL),
(7, 1, 5.00, 'credit_card', 'DHL', '{\"36\": 1, \"37\": 1}', 'pending', '2025-05-10 19:27:08', NULL, NULL),
(8, 1, 5.00, 'credit_card', 'DHL', '{\"33\": 1, \"36\": 1}', 'pending', '2025-05-10 19:37:46', NULL, NULL),
(10, 1, 5.00, 'credit_card', 'DHL', '{\"38\": 1}', 'pending', '2025-05-10 20:00:59', NULL, NULL),
(11, 1, 344.00, 'credit_card', 'DHL', '{\"33\": 1, \"36\": 1, \"37\": 1}', 'pending', '2025-05-10 20:04:37', NULL, NULL),
(12, 1, 352.00, 'credit_card', 'DHL', '{\"34\": 1, \"35\": 1, \"38\": 1}', 'pending', '2025-05-10 20:05:01', NULL, NULL),
(13, 1, 252.00, 'credit_card', 'DHL', '{\"34\": 1, \"37\": 1}', 'pending', '2025-05-10 20:05:33', NULL, NULL),
(14, 1, 256.00, 'credit_card', 'DHL', '{\"34\": 1, \"35\": 1}', 'pending', '2025-05-10 20:22:05', NULL, NULL),
(15, 1, 259.00, 'paypal', 'Post', '{\"33\": 2}', 'pending', '2025-05-11 20:16:01', NULL, NULL),
(16, 1, 116.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 21:46:44', NULL, NULL),
(17, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 21:54:07', NULL, NULL),
(18, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 21:56:34', NULL, NULL),
(19, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 21:58:35', NULL, NULL),
(20, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 21:59:09', NULL, NULL),
(21, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 22:00:18', NULL, NULL),
(23, 1, 66.00, 'credit_card', 'DHL', '{\"35\": 1}', 'pending', '2025-05-16 22:01:38', NULL, NULL),
(24, 1, 333.00, 'credit_card', 'DHL', '{\"33\": 1, \"34\": 1, \"35\": 1}', 'pending', '2025-05-17 18:24:35', NULL, NULL),
(25, 1, 256.00, 'credit_card', 'DHL', '{\"34\": 1, \"35\": 1}', 'pending', '2025-05-17 18:51:36', NULL, NULL),
(26, 1, 145.00, 'credit_card', 'DHL', '{\"34\": 1}', 'pending', '2025-05-18 15:52:20', NULL, NULL),
(27, 1, 132.00, 'credit_card', 'DHL', '{\"33\": 1}', 'pending', '2025-05-18 16:06:06', NULL, NULL),
(28, 1, 767.00, 'credit_card', 'DHL', '{\"33\": 6}', 'pending', '2025-05-18 16:08:16', NULL, NULL),
(29, 20, 654.00, 'credit_card', 'DHL', '{\"45\": 3}', 'pending', '2025-05-18 16:23:51', NULL, NULL),
(30, 20, 112.00, 'credit_card', 'DHL', '{\"37\": 1}', 'pending', '2025-05-18 16:32:45', NULL, NULL),
(31, 20, 445.00, 'paypal', 'Post', '{\"37\": 1, \"40\": 1, \"56\": 1, \"63\": 1}', 'pending', '2025-05-18 20:51:43', NULL, NULL),
(32, 20, 247.00, 'credit_card', 'DHL', '{\"33\": 2}', 'pending', '2025-05-19 13:11:47', NULL, NULL),
(33, 20, 374.00, 'credit_card', 'DHL', '{\"33\": 3}', 'pending', '2025-05-19 13:47:54', '1123123', 12.00),
(34, 20, 456.00, 'credit_card', 'Post', '{\"38\": 1, \"40\": 1, \"47\": 1}', 'pending', '2025-05-19 17:00:55', '1123123', 12.00),
(35, 1, 545.00, 'credit_card', 'DHL', '{\"34\": 4}', 'pending', '2025-05-19 17:03:13', '0', 20.00),
(36, 1, 5.00, 'paypal', 'UPS', '[]', 'pending', '2025-05-19 17:38:28', NULL, NULL),
(37, 1, 5.00, 'paypal', 'Post', '[]', 'pending', '2025-05-19 17:39:34', NULL, NULL),
(38, 1, 5.00, 'credit_card', 'DHL', '[]', 'pending', '2025-05-19 17:40:17', NULL, NULL),
(39, 1, 5.00, 'credit_card', 'DHL', '[]', 'pending', '2025-05-19 17:41:57', NULL, NULL),
(40, 1, 145.00, 'credit_card', 'DHL', '{\"34\": 1}', 'pending', '2025-05-19 17:45:47', NULL, NULL),
(41, 1, 145.00, 'credit_card', 'DHL', '{\"34\": 1}', 'pending', '2025-05-19 17:47:08', NULL, NULL),
(42, 1, 145.00, 'credit_card', 'DHL', '{\"34\": 1}', 'pending', '2025-05-19 17:48:36', NULL, NULL),
(43, 21, 259.00, 'credit_card', 'DHL', '{\"33\": 2}', 'pending', '2025-05-19 17:50:43', NULL, NULL),
(44, 21, 340.00, 'bank debit', 'DHL', '{\"33\": 1, \"37\": 1, \"38\": 1}', 'pending', '2025-05-19 17:53:40', NULL, NULL),
(45, 21, 383.00, 'credit_card', 'DHL', '{\"33\": 1, \"34\": 1, \"35\": 1}', 'pending', '2025-05-19 17:54:46', NULL, NULL),
(46, 21, 425.00, 'credit_card', 'DHL', '{\"34\": 3}', 'pending', '2025-05-19 17:57:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 33, 1, 127.00),
(3, 2, 41, 1, 211.00),
(6, 10, 38, 1, 101.00),
(7, 11, 33, 1, 127.00),
(8, 11, 36, 1, 110.00),
(9, 11, 37, 1, 107.00),
(10, 12, 34, 1, 140.00),
(11, 12, 35, 1, 111.00),
(12, 12, 38, 1, 101.00),
(13, 13, 34, 1, 140.00),
(14, 13, 37, 1, 107.00),
(15, 14, 34, 1, 140.00),
(16, 14, 35, 1, 111.00),
(17, 15, 33, 2, 127.00),
(18, 16, 35, 1, 111.00),
(19, 17, 35, 1, 111.00),
(20, 18, 35, 1, 111.00),
(21, 19, 35, 1, 111.00),
(22, 20, 35, 1, 111.00),
(23, 21, 35, 1, 111.00),
(25, 23, 35, 1, 111.00),
(26, 24, 33, 1, 127.00),
(27, 24, 34, 1, 140.00),
(28, 24, 35, 1, 111.00),
(29, 25, 34, 1, 140.00),
(30, 25, 35, 1, 111.00),
(31, 26, 34, 1, 140.00),
(32, 27, 33, 1, 127.00),
(33, 28, 33, 6, 127.00),
(35, 30, 37, 1, 107.00),
(36, 31, 37, 1, 107.00),
(37, 31, 40, 1, 130.00),
(38, 31, 56, 1, 62.00),
(40, 32, 33, 2, 127.00),
(41, 33, 33, 3, 127.00),
(42, 34, 38, 1, 101.00),
(43, 34, 40, 1, 130.00),
(44, 34, 47, 1, 232.00),
(45, 35, 34, 4, 140.00),
(46, 40, 34, 1, 140.00),
(47, 41, 34, 1, 140.00),
(48, 42, 34, 1, 140.00),
(49, 43, 33, 2, 127.00),
(50, 44, 33, 1, 127.00),
(51, 44, 38, 1, 101.00),
(52, 44, 37, 1, 107.00),
(53, 45, 33, 1, 127.00),
(54, 45, 34, 1, 140.00),
(55, 45, 35, 1, 111.00),
(56, 46, 34, 3, 140.00);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT '0.00',
  `stock` int DEFAULT '0',
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gender` enum('men','women') COLLATE utf8mb4_general_ci NOT NULL,
  `colour` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `rating`, `stock`, `category_id`, `created_at`, `updated_at`, `gender`, `colour`) VALUES
(33, 'FlowFlex - Exclusive Pant', 'Exclusive Pant Men', 127.00, '/weben-prj/frontend/assets/img/products/Men/1747312649_33_Pants_Men_I.avif', 4.90, 27, 1, '2025-04-05 13:46:39', '2025-05-19 09:59:11', 'men', 'black'),
(34, 'UrbanEase - Premium Pant', 'UrbanEase - Premium Pant', 140.00, '/weben-prj/frontend/assets/img/products/Men/34_Pants_Men_I.avif', 4.80, 59, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'blue'),
(35, 'CoreTrack - Premium Pant', 'CoreTrack - Premium Pant', 111.00, '/weben-prj/frontend/assets/img/products/Men/35_Pants_Men_I.avif', 3.50, 68, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'brown'),
(36, 'SlimDrip - Premium Pant', 'SlimDrip - Premium Pant', 110.00, '/weben-prj/frontend/assets/img/products/Men/36_Pants_Men_I.avif', 4.30, 65, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'grey'),
(37, 'FlowFlex - Premium Pant', 'FlowFlex - Premium Pant', 107.00, '/weben-prj/frontend/assets/img/products/Women/37_Pant_Women_I.avif\r\n\r\n', 3.70, 84, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'black'),
(38, 'UrbanEase - Premium Pant', 'UrbanEase - Premium Pant', 101.00, '/weben-prj/frontend/assets/img/products/Women/38_Pant_Women_I.avif\r\n', 3.70, 63, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'blue'),
(39, 'CoreTrack - Premium Pant', 'CoreTrack - Premium Pant', 126.00, '/weben-prj/frontend/assets/img/products/Women/39_Pant_Women_I.avif', 4.50, 33, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'brown'),
(40, 'SlimDrip - Premium Pant', 'SlimDrip - Premium Pant', 130.00, '/weben-prj/frontend/assets/img/products/Women/40_Pant_Women_I.avif', 4.30, 90, 1, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'grey'),
(41, 'StormShell - Premium Jacket', 'StormShell - Premium Jacket', 211.00, '/weben-prj/frontend/assets/img/products/Men/41_Jackets_Men_I.avif', 4.80, 68, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'black'),
(42, 'SkyRidge - Premium Jacket', 'SkyRidge - Premium Jacket', 169.00, '/weben-prj/frontend/assets/img/products/Men/42_Jackets_Men_I.avif', 4.00, 73, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'blue'),
(43, 'EchoWrap - Premium Jacket', 'EchoWrap - Premium Jacket', 195.00, '/weben-prj/frontend/assets/img/products/Men/43_Jackets_Men_I.avif', 4.80, 69, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'grey'),
(44, 'CoreShield - Premium Jacket', 'CoreShield - Premium Jacket', 155.00, '/weben-prj/frontend/assets/img/products/Men/44_Jackets_Men_I.avif', 4.20, 56, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'white'),
(45, 'StormShell - Premium Jacket', 'StormShell - Premium Jacket', 233.00, '/weben-prj/frontend/assets/img/products/Women/45_Jacket_Women_I.avif', 4.70, 43, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'black'),
(46, 'SkyRidge - Premium Jacket', 'SkyRidge - Premium Jacket', 243.00, '/weben-prj/frontend/assets/img/products/Women/46_Jacket_Women_I.avif', 4.20, 22, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'blue'),
(47, 'EchoWrap - Premium Jacket ', 'EchoWrap - Premium Jacket ', 232.00, '/weben-prj/frontend/assets/img/products/Women/47_Jacket_Women_I.avif', 4.20, 64, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'grey'),
(48, 'CoreShield - Premium Jacket ', 'CoreShield - Premium Jacket ', 162.00, '/weben-prj/frontend/assets/img/products/Women/48_Jacket_Women_I.avif', 4.40, 99, 2, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'green'),
(49, 'PureFit - Premium T-shirt', 'PureFit - Premium T-shirt', 63.00, '/weben-prj/frontend/assets/img/products/Men/49_TShirt_Men_I.avif', 4.30, 37, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'black'),
(50, 'ChillLayer - Premium T-shirt ', 'ChillLayer - Premium T-shirt ', 59.00, '/weben-prj/frontend/assets/img/products/Men/50_TShirt_Men_I.avif', 4.50, 39, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'white'),
(51, 'VibeTee - Premium T-shirt ', 'VibeTee - Premium T-shirt ', 78.00, '/weben-prj/frontend/assets/img/products/Men/51_TShirt_Men_I.avif', 3.90, 94, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'blue'),
(52, 'FlexForm - Premium T-shirt ', 'FlexForm - Premium T-shirt ', 57.00, '/weben-prj/frontend/assets/img/products/Men/52_TShirt_Men_I.avif', 3.90, 87, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'green'),
(53, 'PureFit - Premium T-shirt ', 'PureFit - Premium T-shirt ', 72.00, '/weben-prj/frontend/assets/img/products/Women/53_TShirt_Women_I.avif', 4.00, 94, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'black'),
(54, 'ChillLayer - Premium T-shirt ', 'ChillLayer - Premium T-shirt ', 62.00, '/weben-prj/frontend/assets/img/products/Women/54_TShirt_Women_I.avif', 4.10, 64, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'white'),
(55, 'VibeTee - Premium T-shirt ', 'VibeTee - Premium T-shirt ', 72.00, '/weben-prj/frontend/assets/img/products/Women/55_TShirt_Women_I.avif', 4.00, 99, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'blue'),
(56, 'FlexForm - Premium T-shirt ', 'FlexForm - Premium T-shirt ', 62.00, '/weben-prj/frontend/assets/img/products/Women/56_TShirt_Women_I.avif', 4.10, 97, 3, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'pink'),
(57, 'WarmCore - Premium Hoodie ', 'WarmCore - Premium Hoodie ', 99.00, '/weben-prj/frontend/assets/img/products/Men/57_Hoodie_Men_I.avif', 4.30, 27, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'black'),
(58, 'UrbanHood - Premium Hoodie ', 'UrbanHood - Premium Hoodie ', 90.00, '/weben-prj/frontend/assets/img/products/Men/58_Hoodie_Men_I.avif', 4.00, 47, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'blue'),
(59, 'BoldLayer - Premium Hoodie', 'BoldLayer - Premium Hoodie', 114.00, '/weben-prj/frontend/assets/img/products/Men/59_Hoodie_Men_I.avif', 4.70, 58, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'brown'),
(60, 'SoftZip - Premium Hoodie', 'SoftZip - Premium Hoodie', 146.00, '/weben-prj/frontend/assets/img/products/Men/60_Hoodie_Men_I.avif', 3.80, 81, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'men', 'grey'),
(61, 'WarmCore - Premium Hoodie', 'WarmCore - Premium Hoodie', 90.00, '/weben-prj/frontend/assets/img/products/Women/61_Hoodie_Women_I.avif', 4.90, 79, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'black'),
(62, 'UrbanHood - Premium Hoodie', 'UrbanHood - Premium Hoodie', 92.00, '/weben-prj/frontend/assets/img/products/Women/62_Hoodie_Women_I.avif', 4.20, 27, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'blue'),
(63, 'BoldLayer - Premium Hoodie', 'BoldLayer - Premium Hoodie', 141.00, '/weben-prj/frontend/assets/img/products/Women/63_Hoodie_Women_I.avif', 3.80, 34, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'red'),
(64, 'SoftZip - Premium Hoodie', 'SoftZip - Premium Hoodie', 129.00, '/weben-prj/frontend/assets/img/products/Women/64_Hoodie_Women_I.avif', 3.90, 72, 4, '2025-04-05 13:46:39', '2025-05-18 20:04:19', 'women', 'violet'),
(77, 'Test Final 1', 'Finale 1', 120.00, '/weben-prj/frontend/assets/img/products/Men/49_TShirt_Men_II.avif', 2.50, 25, 3, '2025-05-19 09:45:16', '2025-05-19 09:45:16', 'men', 'black');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sessions`
--

CREATE TABLE `sessions` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `session_token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` enum('customer','admin') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'customer',
  `salutation` enum('Ms','Mr','Other') COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_info` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) DEFAULT '1',
  `country` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `role`, `salutation`, `first_name`, `last_name`, `address`, `postal_code`, `city`, `email`, `username`, `password_hash`, `payment_info`, `created_at`, `updated_at`, `active`, `country`) VALUES
(1, 'admin', '', 'Admin', 'Admin', 'Höchstädtpl. 6', '1200', 'Wien', 'admin@email.com', 'admin', '$2y$10$oR7VbohoUWYDCnHR79jXs.GyZM9WOL7tV.tb/HlV8mU9LYjNuqx3e', 'No payment', '2025-03-24 16:47:10', '2025-03-24 16:47:10', 1, ''),
(4, 'customer', '', 'Sabine', 'Sommer', 'Sommertstrasse 1 Top 11', '1220', 'Wien', 'sabso@email.com', 'sabineso', '$2y$10$FtzqD3rOx1M92Qi3gCcns.2L022UXyk/8jRcNl.lCuGmHxp61S2sG', 'DE89 3704 0044 0532 0130 00', '2025-04-02 19:23:31', '2025-04-02 19:23:31', 1, 'Wien'),
(7, 'customer', 'Mr', 'Martin', 'Fischer', 'Fischergasse 1 Top 2', '1210', 'Wien', 'martinf@email.com', 'martinfi', '$2y$10$Xob86SkrdYJ.9mAd0RMWuOWQni9Ka898dsWIA6gMMWqJorzcptxVa', 'AT022050302101023600', '2025-04-03 14:56:52', '2025-04-03 14:56:52', 1, 'Austria'),
(10, 'customer', 'Ms', 'Susi', 'Sorglos', 'Sorgenstrasse 1 Top 2', '1100', 'Wien', 'susisorg@email.com', 'susiso', '$2y$10$Nw3H9l8eNWAYMJzL899bB.ALtOGQw7UFYuOuGvhP/dqxL78Q0JJdy', 'AT022050302101023600', '2025-04-03 15:09:28', '2025-04-03 15:09:28', 1, 'Austria'),
(17, 'customer', 'Other', 'Rudi', 'Ru', 'Rudergasse 15 Top 10', '1010', 'Wien', 'rudi@email.com', 'rudi', '$2y$10$fswS0kg23OQjcHfpbrm1n.7WYJkLWHqDwhfJW2w5s9SKbx6TEt3PK', 'AT022050302101023600', '2025-04-03 21:00:00', '2025-04-03 21:00:00', 1, 'Austria'),
(18, 'customer', 'Ms', 'Dieter', 'Traurig', 'Trauergasse 5 Tür 1', '1110', 'Wien', 'didi@email.com', 'didi', '$2y$10$0n7TPVLdKylZn5hI1b4vu.Pa/EQph/iwFt/RlPt0Kb4lBBa0F3KlW', 'NO5015032080119', '2025-04-03 21:06:42', '2025-05-18 14:41:43', 0, 'Austria'),
(19, 'customer', 'Mr', 'Max', 'Mustermann', 'Hauptstraße 1', '12345', 'Musterstadt', 'max@example.com', 'maxmuster', '$2y$10$3xfXNGMJHSOw7qX1k25BwObD02D4gtkfRGzqupyBRVQcnXGZ5UdXC', 'PayPal: max@example.com', '2025-05-06 16:00:41', '2025-05-06 16:00:41', 1, 'Deutschland'),
(20, 'customer', 'Ms', 'Jana', 'Ina', 'Inesstrasse 1', '1100', 'Wien', 'jana@gmail.com', 'jana12', '$2y$10$/aOtMyWWkd/NQUySJXbxT.G7qyv1fgFr7h01TRslnCigt1RSLl87i', 'DE89 3704 0044 0532 0130 00', '2025-05-18 14:17:19', '2025-05-18 14:36:17', 1, 'Austria'),
(21, 'customer', 'Ms', 'Simona', 'Kimbere', 'Wurmsergasse 15', '1150', 'Wien', 'simona@gmail.com', 'skimmy', '$2y$10$ylJ/uIG8Fhr71enljhdVBOlck/3Yl20kaaEkw0zhkeQ5ZiwshKA6C', 'DE89 3704 0044 0532 0130 00', '2025-05-19 15:39:45', '2025-05-19 15:39:45', 1, 'Österreich');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expiration_date` date NOT NULL,
  `used` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `amount`, `expiration_date`, `used`) VALUES
(1, '1123123', 12.00, '2025-06-05', 0),
(4, '73319', 1231.00, '2025-05-16', 0),
(5, '52577', 12.00, '2025-05-10', 0),
(6, '12345', 50.00, '2025-05-30', 0),
(7, '1234567', 500.00, '2028-12-31', 0),
(8, '59885', 200.00, '2029-12-31', 0),
(9, 'HALLO10', 20.00, '2025-05-31', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indizes für die Tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_token` (`session_token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indizes für die Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2026 at 07:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_shop_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_18_000001_create_products_table', 1),
(5, '2026_05_23_195150_add_profile_fields_to_users_table', 2),
(6, '2026_05_23_205812_create_orders_table', 3),
(7, '2026_05_23_205816_create_order_items_table', 3),
(8, '2026_05_24_091418_remove_city_from_users_and_orders_tables', 4),
(9, '2026_05_24_092034_remove_country_from_users_and_orders_tables', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `subtotal`, `shipping`, `total`, `status`, `full_name`, `email`, `phone`, `address`, `province`, `postal_code`, `payment_method`, `created_at`, `updated_at`) VALUES
(3, 2, 'ORD-6A12C43208F33', 831.55, 0.00, 831.55, 'pending', 'Chinnawat Prommatato', 'user@exam.com', '0908579223', 'Huai Yang4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', 'omise', '2026-05-24 02:26:10', '2026-05-24 02:26:10'),
(4, 2, 'ORD-6A12E8E4623F4', 318.99, 0.00, 318.99, 'shipped', 'Chinnawat Prommatato', 'user@exam.com', '0908579223', 'Huai Yang4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', 'omise', '2026-05-24 12:02:44', '2026-05-24 18:38:10'),
(5, 2, 'ORD-6A12EBD6C527F', 1081.57, 0.00, 1081.57, 'pending', 'Chinnawat Prommatato', 'user@exam.com', '0908579223', 'Huai Yang4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', 'omise', '2026-05-24 12:15:18', '2026-05-24 12:15:18'),
(6, 2, 'ORD-6A12EC65497B7', 101.20, 0.00, 101.20, 'completed', 'Chinnawat Prommatato', 'user@exam.com', '0908579223', 'Huai Yang4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', 'omise', '2026-05-24 12:17:41', '2026-05-24 14:52:14'),
(7, 3, 'ORD-6A13467C8C7FE', 835.89, 0.00, 835.89, 'pending', 'Chinnawat Prommatato', 'testcustomer@mail.com', '0908579223', 'Huai Yang4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', 'omise', '2026-05-24 18:42:04', '2026-05-24 18:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `brand`, `name`, `image`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(3, 3, 23, 'ASUS', 'ROG Strix OLED XG27AQDPG', 'https://dlcdnwebimgs.asus.com/gain/3DAD58C9-668E-42CC-A820-42D9C653E37C/w717/h525/fwebp', 831.55, 1, 831.55, '2026-05-24 02:26:10', '2026-05-24 02:26:10'),
(4, 4, 12, 'Xiaomi', 'A27Qi 2026', 'https://xiaomiknowledge.blob.core.windows.net/image/39b2f90f-98d1-f011-8544-000d3a0989f6.png', 159.00, 1, 159.00, '2026-05-24 12:02:44', '2026-05-24 12:02:44'),
(5, 4, 6, 'Dell', 'S2725H', 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/s2725h/pdp/monitor-s2725h-pdp-module-hero.psd?fmt=jpg&wid=3000&hei=2063', 159.99, 1, 159.99, '2026-05-24 12:02:44', '2026-05-24 12:02:44'),
(6, 5, 17, 'Samsung', 'G8 G81SF', 'https://images.samsung.com/is/image/samsung/p6pim/th/ls27fg812sexxt/gallery/th-odyssey-oled-g8-27g81sf-ls27fg812sexxt-545517381?$1164_776_PNG$', 1081.57, 1, 1081.57, '2026-05-24 12:15:18', '2026-05-24 12:15:18'),
(7, 6, 29, 'AOC', '24G50Z/67', 'https://ihcupload.s3.ap-southeast-1.amazonaws.com/img/product/products150542_800.jpg', 101.20, 1, 101.20, '2026-05-24 12:17:41', '2026-05-24 12:17:41'),
(8, 7, 21, 'ASUS', 'ROG STRIX XG27ACMES', 'https://www.jib.co.th/img_master/product/original/20251129152246_81850_287_1.jpg', 235.91, 1, 235.91, '2026-05-24 18:42:04', '2026-05-24 18:42:04'),
(9, 7, 8, 'Dell', 'S2725Q', 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/s2725qs/media-gallery/monitor-s2725qs-gray-gallery-1.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=893&qlt=100,1&resMode=sharp2&size=893,804&chrss=full', 299.99, 2, 599.98, '2026-05-24 18:42:04', '2026-05-24 18:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` text DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `application` varchar(255) DEFAULT NULL,
  `display_size` varchar(255) DEFAULT NULL,
  `resolution` varchar(255) DEFAULT NULL,
  `refresh_rate` varchar(255) DEFAULT NULL,
  `panel_type` varchar(255) DEFAULT NULL,
  `aspect_ratio` varchar(255) DEFAULT NULL,
  `response_time` varchar(255) DEFAULT NULL,
  `screen_curvature` varchar(255) DEFAULT NULL,
  `brightness` varchar(255) DEFAULT NULL,
  `color_bit` varchar(255) DEFAULT NULL,
  `color_depth` varchar(255) DEFAULT NULL,
  `contrast_ratio` varchar(255) DEFAULT NULL,
  `accessory_in_box` text DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `connection_types` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`connection_types`)),
  `color_gamuts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`color_gamuts`)),
  `dimension_width` decimal(10,2) DEFAULT NULL,
  `dimension_height` decimal(10,2) DEFAULT NULL,
  `dimension_depth` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `brand`, `name`, `application`, `display_size`, `resolution`, `refresh_rate`, `panel_type`, `aspect_ratio`, `response_time`, `screen_curvature`, `brightness`, `color_bit`, `color_depth`, `contrast_ratio`, `accessory_in_box`, `weight`, `connection_types`, `color_gamuts`, `dimension_width`, `dimension_height`, `dimension_depth`, `price`, `discount_type`, `discount`, `discounted_price`, `created_at`, `updated_at`) VALUES
(6, 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/s2725h/pdp/monitor-s2725h-pdp-module-hero.psd?fmt=jpg&wid=3000&hei=2063', 'Dell', 'S2725H', 'business / personal', '27', '1920 x 1080', '120 Hz', 'IPS', '16:9', '4', 'flat screen', '300 cd/m2', '8 bit', '16 million', '1500: 1', '1 x Power cable 1 x HDMI cable', '4.30 kg', '{\"HDMI\":\"2\"}', '{\"sRGB\":\"99\"}', 609.69, 354.21, 59.04, 174.99, 'fixed', 159.99, 159.99, '2026-05-18 17:07:21', '2026-05-18 17:07:21'),
(7, 'https://www.lg.com/content/dam/channel/wcms/th/image-update/monitor/2025/34gx90sa-w-atm/gallery/gallery/ultragear-gaming-34gx90sa-2025-gallery-gallery-01-2010.jpg/jcr:content/renditions/thum-1600x1062.jpeg?w=800', 'LG', '34GX90SA-W', 'gaming', '34', '3440 x 1440', '240 Hz', 'OLED', '21:9', '0.03', 'flat screen', '275cd/m²', '10 bit', '1.07 billion colors', '1500000:1', '1 x Power cable 1 x HDMI cable', '15.5kg', '{\"HDMI\":1,\"DisplayPort\":1,\"USB\":1}', '{\"sRGB\":100,\"DCI-P3\":99}', 927.00, 295.00, 550.00, 3998.00, 'fixed', 1024.00, 2974.00, '2026-05-18 17:48:15', '2026-05-20 08:38:02'),
(8, 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/s2725qs/media-gallery/monitor-s2725qs-gray-gallery-1.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=893&qlt=100,1&resMode=sharp2&size=893,804&chrss=full', 'Dell', 'S2725Q', 'business / personal', '27', '3840 x 2160', '120 Hz', 'IPS', '16:9', '4', 'flat screen', '350cd/m²', '10 bit', '1.07 billion colors', '1500: 1', '1 x Power cable 1 x HDMI cable', '4.7', '{\"HDMI\":2,\"DisplayPort\":1}', '{\"sRGB\":99}', 927.00, 295.00, 550.00, 299.99, 'percent', 0.00, 299.99, '2026-05-19 05:20:24', '2026-05-19 09:13:30'),
(9, 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/u-series/u5226kw/pdp/monitor-ultrasharp-u5226kw-pdp-mod-mg.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=1206&qlt=100,1&resMode=sharp2&size=1206,804&chrss=full', 'Dell', 'U5226KW', 'color grading', '52', '6144 x 2560', '120 Hz', 'IPS Black', '21:9', '5', 'curved', '400 cd/m2', '10 bit', '1.07 billion colors', '2,000:1', '1 x Power cable 1 x HDMI cable', '12.95', '{\"HDMI\":1,\"DisplayPort\":2,\"Thunderbolt\":1,\"USB\":4,\"RJ45\":1}', '{\"sRGB\":100,\"DCI-P3\":99}', 1223.26, 529.08, 112.01, 2999.99, 'percent', 0.00, 2999.99, '2026-05-19 09:26:04', '2026-05-19 09:26:52'),
(10, 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/se2225hm/media-gallery/monitor-se2225hm-c-port-black-gallery-1.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=852&qlt=100,1&resMode=sharp2&size=852,804&chrss=full', 'Dell', 'SE2225HM', 'business / personal', '22', '1920 x 1080', '100 Hz', 'VA', '16:9', '5', 'flat screen', '250 cd/m2', '8 bit', '16.7 Million Colors', '3000:1', '1 x Power cable 1 x HDMI cable', '2.96', '{\"HDMI\":1,\"VGA\":1}', '{\"sRGB\":75}', 49.27, 28.65, 4.49, 69.99, 'percent', 0.00, 69.99, '2026-05-22 01:29:58', '2026-05-22 01:29:58'),
(11, 'https://m.media-amazon.com/images/I/51JoW0aDVML._AC_UF894,1000_QL80_.jpg', 'Xiaomi', 'A27i 2026', 'business / personal', '27', '1920 x 1080', '144 Hz', 'IPS', '16:9', '6', 'flat screen', '300nits', '8 bit', '16.7 Million Colors', '1500:1', '1 x Power cable 1 x HDMI 2.0 cable', '3.9', '{\"HDMI\":1,\"DisplayPort\":1}', '{\"sRGB\":99}', 61.13, 47.46, 17.00, 80.00, 'percent', 0.00, 80.00, '2026-05-22 01:39:28', '2026-05-22 01:43:09'),
(12, 'https://xiaomiknowledge.blob.core.windows.net/image/39b2f90f-98d1-f011-8544-000d3a0989f6.png', 'Xiaomi', 'A27Qi 2026', 'business / personal', '27', '2560 x 1440', '120 Hz', 'IPS', '16:9', '6', 'flat screen', '300nits', '8 bit', '16.7 Million Colors', '1300:1', '1 x Power cable 1 x HDMI 2.0 cable', '3.9kg', '{\"HDMI\":1}', '{\"sRGB\":100,\"DCI-P3\":95}', 612.94, 476.70, 169.80, 159.00, 'percent', 0.00, 159.00, '2026-05-22 01:49:36', '2026-05-23 09:07:17'),
(13, 'https://potakait.com/image/cache/catalog/monitor/Xiaomi/g34wq-2026/xiaomi-redmi-g34wq-2026-gaming-monitor-400x400.jpg', 'Xiaomi', 'G34WQi 2026', 'gaming', '34', '3440 x 1440', '180 Hz', 'VA', '21:9', '1', 'flat screen', '400nits', '10 bit', '1.07 billion colors', '3500:1', '1 x Power cable 1 x HDMI 2.0 cable', '6.5kg', '{\"HDMI\":1,\"DisplayPort\":1}', '{\"sRGB\":100,\"DCI-P3\":95}', 811.30, 521.50, 277.30, 305.00, 'percent', 0.00, 305.00, '2026-05-22 02:34:55', '2026-05-22 02:34:55'),
(14, 'https://i02.appmifile.com/402_item_au/09/12/2025/fa4ee4fe5639c2a358b60d2f53507a7b.png', 'Xiaomi', 'G27Qi 2026', 'business / personal', '27', '2560 x 1440', '240 Hz', 'IPS', '16:9', '1', 'flat screen', '400 nits', '8 bit', '16.7 Million Colors', '1200:1', '1 x Power cable 1 x HDMI 2.0 cable', '4.15', '{\"HDMI\":2,\"DisplayPort\":2}', '[]', 811.30, 521.50, 277.30, 305.00, 'fixed', 23.00, 282.00, '2026-05-22 02:46:37', '2026-05-22 02:46:37'),
(15, 'https://images.samsung.com/is/image/samsung/p6pim/th/ls49fg912eexxt/gallery/th-odyssey-g9-g91f-ls49fg912eexxt-545684433?$1164_776_PNG$', 'Samsung', 'G9 G91F', 'gaming', '49', '5120 x 1440', '144 Hz', 'VA', '32:9', '1', 'curved', '280cd/㎡', '10 bit', '1.07 billion colors', '2500:1', '1 x Power cable 1 x HDMI 2.0 cable', '15.6', '{\"HDMI\":2,\"DisplayPort\":1,\"USB-C\":1,\"USB\":1}', '{\"DCI-P3\":92}', 1147.60, 568.40, 420.50, 999.99, 'fixed', 67.00, 932.99, '2026-05-22 02:59:08', '2026-05-22 14:31:00'),
(16, 'https://images.samsung.com/is/image/samsung/p6pim/th/ls24f320gaexxt/gallery/th-essential-s3-s32gf-ls24f320gaexxt-545501300?$1164_776_PNG$', 'Samsung', 'LS24F320GAEXXT', 'business / personal', '24', '1920 x 1080', '120 Hz', 'IPS', '16:9', '5', 'flat screen', '200 cd/㎡', '8 bit', '16.7 Million Colors', '1000:1', '1 x Power cable 1 x HDMI cable', '2.4', '{\"HDMI\":1}', '{\"sRGB\":71}', 540.70, 540.70, 540.70, 91.52, 'fixed', 0.00, 91.52, '2026-05-22 04:02:06', '2026-05-22 14:30:19'),
(17, 'https://images.samsung.com/is/image/samsung/p6pim/th/ls27fg812sexxt/gallery/th-odyssey-oled-g8-27g81sf-ls27fg812sexxt-545517381?$1164_776_PNG$', 'Samsung', 'G8 G81SF', 'gaming', '27', '3840 x 2160', '240 Hz', 'OLED', '16:9', '0.03', 'flat screen', '250cd/㎡', '10 bit', '1.07 billion colors', '1,000,000:1', '1 x Power cable 1 x HDMI cable', '6.9', '{\"HDMI\":2,\"DisplayPort\":2}', '{\"DCI-P3\":99}', 611.70, 554.20, 263.50, 1101.57, 'fixed', 20.00, 1081.57, '2026-05-22 04:51:48', '2026-05-22 14:32:28'),
(18, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbJ1KDdbTzS3ve1gRgi8uo3UG7ZxyXG_D6eQ&s', 'ASUS', 'VP229HF', 'business / personal', '22', '1920 x 1080', '100 Hz', 'IPS', '16:9', '1', 'flat screen', '250cd/m2', '8 bit', '16.7 Million Colors', '1000:1', '1 x Power cable 1 x VGA cable', '2.70', '{\"VGA\":1}', '{\"sRGB\":99}', 493.60, 327.60, 204.40, 59.99, 'percent', 0.00, 59.99, '2026-05-22 14:39:06', '2026-05-22 14:39:42'),
(19, 'https://dlcdnwebimgs.asus.com/gain/fe360c82-bb99-4929-90f0-73569f60b6ce/w692', 'ASUS', 'ProArt PA248QV', 'color grading', '24.1', '1920 x 1200', '60 Hz', 'IPS', '16:10', '5', 'flat screen', '350 cd/㎡', '8 bit', '16.7 Million Colors', '3000:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', '5.4 kg', '{\"HDMI\":1,\"DisplayPort\":1,\"USB\":1}', '{\"sRGB\":100}', 531.80, 531.30, 190.40, 203.99, 'percent', 0.00, 203.99, '2026-05-22 15:05:49', '2026-05-22 15:30:41'),
(20, 'https://www.jib.co.th/img_master/product/original/20250708151812_78294_287_1.jpg', 'ASUS', 'TUF GAMING VG279QM5A', 'gaming', '27', '1920 x 1080', '240 Hz', 'IPS', '16:9', '1', 'flat screen', '300cd:m2', '8 bit', '16.7 Million Colors', '1000:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', '4.50 kg', '{\"HDMI\":2,\"DisplayPort\":1}', '{\"sRGB\":99}', 615.00, 453.00, 193.00, 108.53, 'fixed', 4.70, 103.83, '2026-05-22 15:36:15', '2026-05-22 15:37:52'),
(21, 'https://www.jib.co.th/img_master/product/original/20251129152246_81850_287_1.jpg', 'ASUS', 'ROG STRIX XG27ACMES', 'gaming', '27', '2560 x 1440', '240 Hz', 'IPS', '16:9', '0.3', 'flat screen', '350cd:m2', '10 bit', '1.07 billion colors', '1300:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', NULL, '{\"HDMI\":1,\"DisplayPort\":1}', '{\"sRGB\":100,\"DCI-P3\":97}', 614.80, 50.34, 18.87, 241.21, 'fixed', 5.30, 235.91, '2026-05-22 15:48:10', '2026-05-23 08:08:32'),
(22, 'https://img.advice.co.th/images_nas/pic_product4/A0172681/A0172681OK_BIG_1.jpg', 'ASUS', 'PROART PA278CGV', 'color grading', '27', '2560 x 1440', '144 Hz', 'IPS', '16:9', '350cd:m2', 'flat screen', '350cd:m2', '10 bit', '1.07 billion colors', '1,000 : 1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', '11.78 kg', '{\"HDMI\":2,\"DisplayPort\":1,\"USB\":5}', '{\"sRGB\":100,\"DCI-P3\":95}', 615.00, 524.00, 228.00, 361.66, 'fixed', 4.89, 356.77, '2026-05-22 16:07:02', '2026-05-22 16:08:06'),
(23, 'https://dlcdnwebimgs.asus.com/gain/3DAD58C9-668E-42CC-A820-42D9C653E37C/w717/h525/fwebp', 'ASUS', 'ROG Strix OLED XG27AQDPG', 'gaming', '27', '2560 x 1440', '500 Hz', 'OLED', '16:9', '0.03', 'flat screen', '300cd/㎡', '10 bit', '1.07 billion colors', '1500000:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', '6.6', '{\"HDMI\":1,\"DisplayPort\":1,\"USB-C\":1,\"USB\":1}', '{\"sRGB\":100,\"DCI-P3\":99}', 610.00, 502.10, 169.40, 842.25, 'fixed', 10.70, 831.55, '2026-05-22 16:28:57', '2026-05-22 16:28:57'),
(24, 'https://dlcdnwebimgs.asus.com/gain/f3c260e1-76b8-4714-a6e0-a5c19c8da9ea/w692', 'ASUS', 'PROART PA32QCV', 'color grading', '32', '6144 x 2560', '60 Hz', 'IPS', '16:9', '5', 'flat screen', '400cd/㎡', '10 bit', '1.07 billion colors', '3000:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', NULL, '{\"HDMI\":1,\"DisplayPort\":1,\"USB-C\":1,\"Thunderbolt\":2,\"USB\":4}', '{\"sRGB\":100,\"DCI-P3\":98}', 714.20, 617.90, 240.10, 1188.93, 'fixed', 15.29, 1173.64, '2026-05-22 16:49:21', '2026-05-22 16:49:21'),
(26, 'https://mercular.s3.ap-southeast-1.amazonaws.com/images/products/2024/01/Product/asus-rog-swift-pg34wcdm-34-oled-uwqhd-gaming-monitor-240hz-front-view.jpg', 'ASUS', 'ROG SWIFT PG34WCDN', 'gaming', '32', '3440 x 1440', '360 Hz', 'OLED', '21:9', '0.03', 'curved', '1300cd:m2b', '10 bit', '1.07 billion colors', '1,500,000:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', NULL, '{\"HDMI\":2,\"DisplayPort\":1,\"USB-C\":1,\"USB\":3}', '{\"sRGB\":100,\"DCI-P3\":99}', 786.00, 551.00, 293.00, 1446.65, 'fixed', 17.73, 1428.92, '2026-05-22 17:11:36', '2026-05-23 08:09:16'),
(27, 'https://www.jib.co.th/img_master/product/original/20260218172548_83421_477_1.jpg', 'ASUS', 'TUF GAMING VG32WQ3B', 'gaming', '32', '2560 x 1440', '180 Hz', 'VA', '16:9', '0.5', 'curved', '300cd/㎡', '8 bit', '16.7 Million Colors', '3500:1', '1 x Power cable 1 x HDMI 2.0 cable 1 x DisplayPort', '9.40', '{\"HDMI\":2,\"DisplayPort\":1}', '{\"sRGB\":100,\"DCI-P3\":90}', 710.00, 507.00, 214.00, 228.98, 'fixed', 3.06, 225.92, '2026-05-22 17:17:25', '2026-05-22 17:17:25'),
(28, 'https://cdn.sanity.io/images/hf5b3axp/production/56cd29ee83b834007df0284eea565c318a3c1ca4-5280x4920.png?w=1920&fit=max&auto=format', 'AOC', '22B30HM2', 'business / personal', '22', '1920 x 1080', '60 Hz', 'VA', '16:9', '4', 'flat screen', '250 cd/m²', '8 bit', '16.7 Million Colors', '3000:1', '1 x Power cable 1 x HDMI cable', '3.49', '{\"HDMI\":1,\"VGA\":1}', '{\"sRGB\":80}', 493.80, 379.10, 169.90, 54.42, 'fixed', 1.22, 53.20, '2026-05-22 19:14:01', '2026-05-22 19:14:01'),
(29, 'https://ihcupload.s3.ap-southeast-1.amazonaws.com/img/product/products150542_800.jpg', 'AOC', '24G50Z/67', 'gaming', '24', '1920 x 1080', '240 Hz', 'IPS', '16:9', '0.3', 'flat screen', '300 cd/m²', '8 bit', '16.7 Million Colors', '1000:1', '1 x Power cable 1 x HDMI cable', '4.32', '{\"HDMI\":1,\"DisplayPort\":1}', '{\"sRGB\":100,\"DCI-P3\":87}', 544.00, 418.10, 175.00, 102.42, 'fixed', 1.22, 101.20, '2026-05-23 08:44:45', '2026-05-23 08:44:45'),
(30, 'https://i.dell.com/is/image/DellContent/content/dam/ss2/product-images/dell-client-products/peripherals/monitors/s-series/se2425hm/media-gallery/monitor-se2425hm-black-gallery-1.psd?fmt=png-alpha&pscan=auto&scl=1&hei=804&wid=900&qlt=100,1&resMode=sharp2&size=900,804&chrss=full', 'Dell', 'SE2425HM', 'business / personal', '24', '1920 x 1080', '100 Hz', 'IPS', '16:9', '5', 'flat screen', '250 cd/m2', '8 bit', '16.7 Million Colors', '1000:1', '1 x Power cable 1 x HDMI cable', '3.46', '{\"HDMI\":1,\"DisplayPort\":1}', '{\"sRGB\":72}', 538.70, 412.20, 70.40, 99.99, 'percent', 0.00, 99.99, '2026-05-23 08:50:56', '2026-05-23 08:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('consumer','admin') NOT NULL DEFAULT 'consumer',
  `address` text DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `address`, `province`, `postal_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'AlekZus', NULL, NULL, 'admin@exam.com', NULL, NULL, '$2y$12$e4IkkFNtLkGAVwtjBbuxGuhlQIn8KiuZvbwiCQIzlObxwvoPSTWnu', 'admin', NULL, NULL, NULL, 'sPKGbrXVyBOrjYbV9NTdV4mGEAY8RgBEihA3BY9Gbhhs7vU7MijRxVL37hgv', '2026-05-18 13:46:41', '2026-05-18 13:46:41'),
(2, 'Chinnawat Prommatato', 'Chinnawat', 'Prommatato', 'user@exam.com', '0908579223', NULL, '$2y$12$YiWgH4bSFeUEPV0AD.70q.YFxuOyLGdsJNH7nbEH0gsLZNtPDxO8O', 'consumer', 'Huai Yang\r\n4 Moo 6 Lao Phon Kho, Khok Si Suphan', 'Sakon Nakhon', '47280', NULL, '2026-05-20 10:01:40', '2026-05-23 14:28:05'),
(3, 'Test Customer', NULL, NULL, 'testcustomer@mail.com', NULL, NULL, '$2y$12$XErLUWteu3Td/eWMfuneHOusi.QkyJTTstDor3KMh9L9jITWcjiWW', 'consumer', NULL, NULL, NULL, NULL, '2026-05-24 18:40:26', '2026-05-24 18:40:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

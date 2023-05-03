-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.32-0ubuntu0.20.04.2 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for web_service
CREATE DATABASE IF NOT EXISTS `web_service` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `web_service`;

-- Dumping structure for table web_service.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.migrations: ~5 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(2, '2023_04_15_130739_create_users_table', 1),
	(3, '2023_04_15_130750_create_combos_table', 1),
	(4, '2023_04_15_131753_create_orders_table', 1),
	(5, '2023_04_15_131818_create_order_details_table', 1);

-- Dumping structure for table web_service.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.orders: ~30 rows (approximately)
INSERT INTO `orders` (`id`, `total`, `status`, `address`, `phone`, `bank_code`, `transaction_code`, `user_id`, `created_at`) VALUES
	(1, 769959, 'Payment successfully', '13090 Parisian Hills\nNorth Devyn, AL 14423', '+16308944085', 'MasterCard', 'IT27H34891831818L7D8RN4UI92', 1, '2022-06-20 21:35:38'),
	(2, 178284, 'Payment successfully', '3193 Runolfsson Avenue\nWest Caesar, OH 20189', '650-687-5155', 'MasterCard', 'SI62887000717107292', 1, '2021-09-23 01:22:16'),
	(3, 671923, 'Payment successfully', '3722 Bogisich Fort\nSouth Janelle, WV 46381', '1-551-455-9208', 'American Express', 'NL66DMXF7206198183', 1, '2022-02-11 07:25:05'),
	(4, 330645, 'Payment successfully', '858 Wisoky Shoal Suite 756\nEast Kelsistad, MS 21152-9762', '(928) 217-3967', 'American Express', 'DE54656786159490165196', 1, '2022-01-03 10:33:41'),
	(5, 105148, 'Payment successfully', '2061 Stefanie Ports\nJoellebury, TX 57678-1895', '(559) 576-1294', 'American Express', 'BE72141290491549', 1, '2021-12-04 22:12:08'),
	(6, 815476, 'Payment successfully', '94997 Norma Lodge Suite 184\nSouth Elodymouth, CO 74829-0641', '+1-479-453-6733', 'MasterCard', 'CH9759146768I2770A747', 1, '2022-03-14 11:06:29'),
	(7, 966056, 'Payment successfully', '58572 Hartmann Prairie Apt. 890\nHintzland, GA 64918', '1-804-767-1871', 'MasterCard', 'IT68V1402824051Y1K5G8FCDABA', 1, '2021-11-04 13:41:26'),
	(8, 677052, 'Payment successfully', '385 Schmidt Radial\nLake General, WA 68322-8474', '+1 (740) 640-8345', 'JCB', 'SI34364701377421835', 1, '2022-02-21 10:15:48'),
	(9, 424072, 'Payment successfully', '902 Jerde Track\nSamirmouth, IN 01328', '231.643.4190', 'American Express', 'KZ344155QMX5S4SK15AJ', 1, '2022-03-24 12:21:28'),
	(10, 496352, 'Payment successfully', '713 Laisha Stravenue\nElfriedaborough, OR 77606-6338', '620-478-8099', 'MasterCard', 'MD2075QX6HR909926LX30QG6', 1, '2022-04-05 01:34:12'),
	(11, 375382, 'Payment successfully', '26747 Goodwin Ford Apt. 269\nWest Cynthiafort, NC 38152', '541-913-8960', 'MasterCard', 'LT516682840748186583', 1, '2021-09-21 20:12:01'),
	(12, 700326, 'Payment successfully', '59082 Hill Light\nJacobitown, ND 51041-8656', '463-988-6587', 'MasterCard', 'PS35EYJH7C76G6RVC7Y07LJCX5J32', 1, '2022-05-09 11:28:09'),
	(13, 395405, 'Payment successfully', '905 Lueilwitz Corners Suite 735\nGarthberg, DC 48700', '603.318.6024', 'Discover Card', 'DO558UAV33790531611657521736', 1, '2021-10-20 10:55:52'),
	(14, 389112, 'Payment successfully', '233 Frank Fields\nNorth Floy, SC 09604', '1-815-389-1727', 'MasterCard', 'VG56ATQE5136294514351757', 1, '2021-11-23 20:13:36'),
	(15, 740198, 'Payment successfully', '79017 Roslyn Parkway\nJohnstonmouth, CT 55999', '336-737-9248', 'Visa', 'MD4511RF309NLEMH67V18N65', 1, '2022-04-30 20:29:35'),
	(16, 929022, 'Payment successfully', '12595 Emmet Gardens Apt. 495\nChristianfurt, MO 41832-2336', '(520) 939-0501', 'Visa', 'MR3252000534270173383607218', 1, '2022-02-13 10:35:43'),
	(17, 621607, 'Payment successfully', '7812 Shields Oval Apt. 887\nCollinsview, IN 82844', '805-901-3894', 'MasterCard', 'PT56667071144436126933998', 1, '2021-12-14 00:22:54'),
	(18, 350396, 'Payment successfully', '39022 Roger Parks Suite 611\nWest Elta, NJ 90777', '(650) 719-6671', 'MasterCard', 'PT85010767429526945778131', 1, '2022-04-08 20:12:07'),
	(19, 301480, 'Payment successfully', '5618 Lambert Burg\nPort Jayda, RI 40596-3238', '689.480.3048', 'MasterCard', 'MK339487246NV25CZ52', 1, '2021-08-22 11:46:16'),
	(20, 851420, 'Payment successfully', '876 Waelchi Parkways Suite 765\nSouth Marcelo, VA 07096-1907', '+1-949-300-1536', 'MasterCard', 'MD388AMH017L1SBMW3123FIJ', 1, '2022-06-18 01:35:30'),
	(21, 587678, 'Payment successfully', '368 Labadie Loaf Apt. 906\nBeerstad, KY 27075', '+1-865-777-7212', 'Visa', 'SM41X0648105709W581RDCGTR07', 1, '2021-12-08 20:29:23'),
	(22, 399402, 'Payment successfully', '266 Juwan Crest Suite 302\nMaddisonport, MO 49860-9703', '+1.986.710.8211', 'MasterCard', 'GT716R38A24ML445448QNK3JM5X8', 1, '2021-11-20 19:53:55'),
	(23, 75534, 'Payment successfully', '490 Kertzmann Estate Suite 545\nBrooklynton, NY 94619-1001', '609-362-8389', 'MasterCard', 'KZ510921VT1K31DN42F2', 1, '2021-11-13 04:38:23'),
	(24, 359905, 'Payment successfully', '76512 Alexie Roads\nShannahaven, PA 30358-2382', '1-283-703-9899', 'Visa', 'LB748521M4287Q9S6XJG8ZQ4ZM3H', 1, '2021-11-27 08:32:40'),
	(25, 593871, 'Payment successfully', '54584 Ike Row Apt. 672\nMyaberg, MT 91264-0319', '+1.361.343.5442', 'Discover Card', 'ME02309988072607942884', 1, '2022-01-20 14:23:37'),
	(26, 322929, 'Payment successfully', '3245 Trevor Stravenue\nNewellmouth, FL 01607-4632', '(531) 919-3322', 'Visa', 'FI6183167774231542', 1, '2021-09-07 12:08:02'),
	(27, 581790, 'Payment successfully', '123 Madilyn Locks\nWest Samir, MI 70730-2872', '(559) 762-1149', 'MasterCard', 'DO789L5C37775155959455954231', 1, '2021-10-10 00:11:14'),
	(28, 388008, 'Payment successfully', '4222 Bednar Summit Apt. 216\nLake Otiliaville, CA 09378-0601', '765.344.2510', 'Visa', 'TR12560369RY2554E84F31P396', 1, '2022-01-27 09:05:00'),
	(29, 937704, 'Payment successfully', 'Dia chi nha', 'sdt', 'VNBANK', 'NCB', 3, '2023-04-22 01:32:18'),
	(30, 333830, 'Payment successfully', '83433 Botsford Parkway\nSouth Rosetta, VT 91316-6783', '+13379072961', 'MasterCard', 'DO33NEQ281804658389047676476', 3, '2021-12-19 08:20:38'),
	(34, 0, 'In cart', '', '', '', '', 3, '2023-04-22 01:35:32'),
	(35, 53979, 'In cart', '', '', '', '', 1, '2023-04-28 00:09:49');

-- Dumping structure for table web_service.orders_products
CREATE TABLE IF NOT EXISTS `orders_products` (
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `amount` int NOT NULL,
  `price` double NOT NULL,
  KEY `orders_products_order_id_foreign` (`order_id`),
  KEY `orders_products_product_id_foreign` (`product_id`),
  CONSTRAINT `orders_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `orders_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.orders_products: ~66 rows (approximately)
INSERT INTO `orders_products` (`order_id`, `product_id`, `amount`, `price`) VALUES
	(1, 52, 2, 52591),
	(1, 22, 7, 52795),
	(1, 96, 4, 73803),
	(2, 86, 3, 59428),
	(3, 56, 5, 44266),
	(3, 29, 8, 48058),
	(3, 82, 1, 66129),
	(4, 82, 5, 66129),
	(5, 80, 2, 52574),
	(6, 57, 1, 76103),
	(6, 46, 6, 40000),
	(6, 68, 7, 71339),
	(7, 69, 6, 62097),
	(7, 29, 5, 48058),
	(7, 6, 4, 45012),
	(7, 2, 3, 57712),
	(8, 4, 2, 75659),
	(8, 46, 8, 40000),
	(8, 16, 6, 34289),
	(9, 94, 4, 33540),
	(9, 19, 3, 77222),
	(9, 35, 1, 58246),
	(10, 42, 1, 64986),
	(10, 98, 6, 37767),
	(10, 85, 4, 51191),
	(11, 36, 6, 52945),
	(11, 2, 1, 57712),
	(12, 18, 8, 69354),
	(12, 62, 3, 48498),
	(13, 88, 5, 79081),
	(14, 14, 6, 32418),
	(14, 48, 3, 64868),
	(15, 66, 8, 38063),
	(15, 63, 6, 47880),
	(15, 45, 2, 39530),
	(15, 18, 1, 69354),
	(16, 4, 6, 75659),
	(16, 63, 5, 47880),
	(16, 33, 4, 58917),
	(17, 71, 5, 37955),
	(17, 12, 8, 53979),
	(18, 79, 1, 71318),
	(18, 8, 6, 46513),
	(19, 75, 5, 60296),
	(20, 15, 6, 53094),
	(20, 78, 8, 66607),
	(21, 84, 4, 53430),
	(21, 18, 1, 69354),
	(21, 3, 4, 76151),
	(22, 29, 3, 48058),
	(22, 37, 6, 42538),
	(23, 98, 2, 37767),
	(24, 30, 5, 71981),
	(25, 50, 8, 37077),
	(25, 26, 7, 42465),
	(26, 97, 2, 68319),
	(26, 69, 3, 62097),
	(27, 12, 3, 53979),
	(27, 59, 3, 64873),
	(27, 23, 3, 75078),
	(28, 98, 4, 37767),
	(28, 76, 6, 39490),
	(29, 65, 7, 41981),
	(29, 99, 1, 56669),
	(29, 74, 8, 73396),
	(30, 5, 7, 47690),
	(35, 12, 1, 53979);

-- Dumping structure for table web_service.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table web_service.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.products: ~100 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
	(2, 'Iure ratione dolor magni.', 'Sit dicta ut ut et reiciendis ad consectetur repellat molestias asperiores non natus atque ut sit eius.', 57712, 'https://via.placeholder.com/640x480.png/00bbcc?text=asperiores', '2021-11-14 21:06:06'),
	(3, 'Repellendus reprehenderit delectus temporibus minima aut.', 'Neque eum omnis perspiciatis voluptate ipsa quis animi suscipit qui nisi sit sint.', 76151, 'https://via.placeholder.com/640x480.png/006699?text=molestias', '2021-11-07 08:30:43'),
	(4, 'Ut quo dolore.', 'Consequatur beatae porro dicta non laboriosam voluptas vero harum ad cum eaque officia unde.', 75659, 'https://via.placeholder.com/640x480.png/00dd66?text=delectus', '2022-02-02 14:19:58'),
	(5, 'Doloremque earum amet nulla ullam sed.', 'Molestiae illum omnis ut ut neque porro numquam aliquam hic itaque aut laboriosam voluptas voluptatibus dolore placeat amet aspernatur distinctio expedita quia recusandae placeat qui quam.', 47690, 'https://via.placeholder.com/640x480.png/0022cc?text=odit', '2022-03-21 12:03:08'),
	(6, 'Aliquid rerum quaerat animi quam tempore molestiae.', 'Iure aliquid sed ea vel quia harum libero qui unde et et voluptas odio animi similique perspiciatis delectus sit amet quibusdam.', 45012, 'https://via.placeholder.com/640x480.png/006622?text=tempore', '2021-12-03 14:59:11'),
	(7, 'Quasi molestiae ut minus voluptatem ab possimus.', 'Sapiente iusto laboriosam debitis et impedit quia ut cupiditate corporis exercitationem sint vitae non perferendis qui excepturi recusandae.', 48832, 'https://via.placeholder.com/640x480.png/0055dd?text=voluptatem', '2021-09-16 10:43:28'),
	(8, 'Quos aspernatur est enim sit sunt aut eum.', 'Dolores recusandae id tenetur ea vitae impedit sunt quia aut quis eveniet odit iste.', 46513, 'https://via.placeholder.com/640x480.png/000099?text=autem', '2021-10-11 21:52:13'),
	(9, 'Et aliquid voluptatem autem praesentium.', 'Dicta numquam quibusdam dicta eius maxime aut non sed ad ea ut quibusdam beatae at sequi quas doloremque eaque dolorum aut autem.', 70540, 'https://via.placeholder.com/640x480.png/007722?text=perferendis', '2022-03-24 20:48:51'),
	(10, 'Aspernatur ea omnis nostrum quis itaque.', 'Velit dolorum iste atque repudiandae et aut nulla omnis officia quis cum qui est rerum et saepe hic enim.', 75959, 'https://via.placeholder.com/640x480.png/009933?text=debitis', '2021-09-26 07:33:29'),
	(11, 'Id voluptates dolor dolores iure amet.', 'Asperiores dignissimos suscipit sit blanditiis repudiandae doloribus aut aut unde officiis et mollitia in repellat totam quae sint quae optio consequatur.', 44161, 'https://via.placeholder.com/640x480.png/0055ee?text=minus', '2022-03-27 21:36:46'),
	(12, 'Aperiam minus dignissimos aut.', 'Quasi quas eaque cum rem quae consequatur dolore ipsa sunt id deserunt et optio consequuntur cum eos ea ab sit.', 53979, 'https://via.placeholder.com/640x480.png/002299?text=provident', '2021-09-07 01:11:14'),
	(13, 'Quos velit ea molestiae rerum.', 'Impedit sequi quibusdam sapiente voluptas dolorem est sunt voluptatum minus corporis ut quia.', 70072, 'https://via.placeholder.com/640x480.png/00ffee?text=non', '2021-12-25 07:28:44'),
	(14, 'Quia distinctio excepturi cupiditate eaque quod.', 'Nemo animi et cum et nobis ipsum quam praesentium amet ut nisi nisi et magni atque aut aut.', 32418, 'https://via.placeholder.com/640x480.png/007788?text=corporis', '2021-10-05 08:23:59'),
	(15, 'Dolorem perspiciatis corporis ipsa voluptate.', 'Et qui architecto nobis tempore et eligendi culpa aut recusandae vero distinctio explicabo vitae nulla recusandae ut assumenda voluptatem placeat quibusdam quia.', 53094, 'https://via.placeholder.com/640x480.png/004488?text=quaerat', '2022-01-03 08:23:40'),
	(16, 'A consequatur ipsam illum qui vero.', 'Omnis ea sunt vel est saepe officia consequuntur quod itaque sit quia in dolorem assumenda voluptatem.', 34289, 'https://via.placeholder.com/640x480.png/003333?text=rerum', '2022-01-24 00:36:43'),
	(17, 'Aut occaecati autem.', 'Sed magnam reprehenderit sit deserunt quia et fugit delectus excepturi eum enim distinctio.', 44446, 'https://via.placeholder.com/640x480.png/00eeff?text=atque', '2022-04-23 19:43:09'),
	(18, 'Minima tempora eius quia velit nobis amet.', 'Sit non eligendi beatae aut quia est corrupti voluptas facilis cupiditate et quod.', 69354, 'https://via.placeholder.com/640x480.png/0088ee?text=accusantium', '2022-01-24 22:23:08'),
	(19, 'Reprehenderit natus necessitatibus non.', 'Id tenetur vero soluta tempora sapiente error beatae nisi aut autem aliquid perspiciatis earum ut non est aut voluptatem fugit et ut.', 77222, 'https://via.placeholder.com/640x480.png/008811?text=alias', '2022-03-09 10:33:17'),
	(20, 'Eaque vero dolorem quia.', 'Quia ut tempore mollitia vel quas voluptatum dignissimos adipisci et blanditiis reiciendis deleniti quia perspiciatis voluptas at libero dolores suscipit suscipit ratione.', 40620, 'https://via.placeholder.com/640x480.png/0077cc?text=voluptas', '2021-10-09 05:51:32'),
	(21, 'Commodi vel voluptate similique.', 'A voluptatum autem impedit omnis rerum illum et corporis culpa ducimus et at consequatur et.', 61350, 'https://via.placeholder.com/640x480.png/0022dd?text=officiis', '2022-05-01 05:44:26'),
	(22, 'Et quas tenetur natus dolorem ab expedita.', 'Ut quod voluptas sint optio nostrum cumque omnis quas quisquam porro illum eligendi ut temporibus quam ipsam.', 52795, 'https://via.placeholder.com/640x480.png/00ddaa?text=et', '2022-04-05 07:05:54'),
	(23, 'Non provident nisi ex odio qui.', 'Sapiente sunt aut quasi vel quae quasi inventore et quidem minus quo pariatur optio rerum autem et sit dolorem quia id tempore eum numquam cupiditate voluptatum soluta consequuntur.', 75078, 'https://via.placeholder.com/640x480.png/00eedd?text=reprehenderit', '2021-09-30 02:14:32'),
	(24, 'Saepe voluptatibus ea ea sint.', 'Ut reiciendis et aspernatur voluptatem aperiam id voluptas inventore inventore voluptatibus expedita velit aut optio ratione praesentium dignissimos.', 46407, 'https://via.placeholder.com/640x480.png/0066aa?text=quaerat', '2021-08-22 12:35:45'),
	(25, 'Perferendis ut asperiores natus molestias.', 'Culpa qui voluptate et quis voluptatem est mollitia ut quo blanditiis ullam nihil unde ut quisquam ut rerum expedita.', 33180, 'https://via.placeholder.com/640x480.png/009944?text=quod', '2021-12-31 16:41:32'),
	(26, 'Vel ratione quod ipsam quo aut atque.', 'Aut accusamus culpa facilis deleniti sit et distinctio quia totam aliquam et maxime quo blanditiis earum nulla voluptate et.', 42465, 'https://via.placeholder.com/640x480.png/00ff99?text=consequuntur', '2021-09-15 09:42:18'),
	(27, 'Voluptatem sunt cupiditate dolorum sunt.', 'Error enim placeat deleniti et excepturi corrupti recusandae provident nemo iure aut alias nihil voluptatem incidunt qui nemo ut non tempore.', 72709, 'https://via.placeholder.com/640x480.png/0077bb?text=ex', '2022-03-21 10:16:37'),
	(28, 'Aperiam porro possimus aut beatae.', 'Repellendus alias et temporibus voluptas in animi aut quibusdam enim corrupti et ut et dolorem aliquid ullam voluptatem labore est optio explicabo qui velit eos non eaque inventore.', 48926, 'https://via.placeholder.com/640x480.png/00aa77?text=provident', '2022-06-04 07:18:30'),
	(29, 'Aliquid ut vel velit molestiae iste.', 'Accusamus quia maxime alias atque quis ab occaecati laborum aut et vitae vitae totam.', 48058, 'https://via.placeholder.com/640x480.png/00aaff?text=sed', '2022-04-09 11:22:17'),
	(30, 'Enim nihil ipsum possimus enim.', 'Nobis dolor quo qui et consequatur tenetur odit officiis culpa quod porro sit deserunt placeat autem natus ut alias.', 71981, 'https://via.placeholder.com/640x480.png/00eebb?text=error', '2021-10-11 20:06:07'),
	(31, 'Aut natus quibusdam consequatur laboriosam.', 'Eos enim molestiae doloribus qui molestiae ullam vel accusantium rerum aut et est.', 78539, 'https://via.placeholder.com/640x480.png/0022dd?text=recusandae', '2021-11-29 07:27:53'),
	(32, 'Et qui nesciunt et.', 'Corrupti et quia consequuntur ipsam quis odio vero dolor iure tempore eveniet fugiat dolorem.', 37485, 'https://via.placeholder.com/640x480.png/0011bb?text=id', '2022-01-19 21:06:35'),
	(33, 'Aspernatur esse nemo dolores et velit.', 'Recusandae consequuntur vero molestiae minima amet nesciunt non voluptate alias delectus unde est dolorem culpa quis.', 58917, 'https://via.placeholder.com/640x480.png/00ee77?text=iste', '2022-01-16 07:41:21'),
	(34, 'Commodi facilis sit voluptas voluptatem.', 'Hic expedita facilis ea tempore porro quod repellendus quo rem consequuntur sunt illum eum velit qui deleniti est dolorem.', 69154, 'https://via.placeholder.com/640x480.png/009900?text=accusamus', '2022-06-10 04:55:30'),
	(35, 'Aut sed fugit enim et.', 'Maxime accusantium omnis sunt reiciendis accusamus quas ut enim eos dolorum soluta omnis facilis quidem ut sed tempora possimus aspernatur dolores laudantium illo molestias.', 58246, 'https://via.placeholder.com/640x480.png/00aa77?text=sint', '2022-05-27 22:45:21'),
	(36, 'Assumenda possimus dignissimos voluptas totam.', 'Culpa quo id ut unde consequatur error sed neque voluptatem qui laboriosam et ex odio odio totam dolor accusamus deserunt pariatur deserunt culpa id et eos.', 52945, 'https://via.placeholder.com/640x480.png/00eecc?text=eligendi', '2022-03-03 12:58:37'),
	(37, 'Et ipsum cum itaque ut.', 'Corrupti quam non blanditiis quo illum odio repudiandae ut et illo esse velit odit molestias.', 42538, 'https://via.placeholder.com/640x480.png/0077cc?text=inventore', '2022-01-24 07:55:21'),
	(38, 'Culpa ab laudantium.', 'Illo maxime consequuntur sapiente dolores excepturi asperiores sit est unde quidem dolores dolor qui.', 45349, 'https://via.placeholder.com/640x480.png/0000cc?text=consequatur', '2022-05-30 09:48:15'),
	(39, 'Error reiciendis nesciunt quia.', 'Dolore voluptates fugit at molestiae ullam maxime molestiae maxime ex natus delectus quae quia voluptas dolorum hic omnis sit natus ut nulla ex quasi amet perspiciatis sunt.', 36610, 'https://via.placeholder.com/640x480.png/0088dd?text=iusto', '2022-02-16 13:40:53'),
	(40, 'Vel consequatur est quaerat provident.', 'Amet autem officiis laudantium quam dolor iusto impedit placeat quia quo placeat reiciendis ea incidunt ut aut commodi.', 37682, 'https://via.placeholder.com/640x480.png/004455?text=placeat', '2021-11-24 20:51:29'),
	(41, 'Facilis ullam odio labore.', 'Impedit ipsam molestiae voluptatem qui sed doloremque quos molestiae sed vel dolorem voluptatum ea aut odio molestiae id voluptas id voluptas vel.', 51749, 'https://via.placeholder.com/640x480.png/00cccc?text=inventore', '2022-04-15 18:00:08'),
	(42, 'Et mollitia id similique.', 'Ut et qui est et ratione rerum sed provident doloribus dolor consequatur libero qui aut dolorem cum deleniti ipsam ducimus ducimus.', 64986, 'https://via.placeholder.com/640x480.png/006677?text=provident', '2021-08-23 17:20:36'),
	(43, 'Eligendi magnam ut perferendis.', 'Iure cupiditate id alias labore velit illum expedita qui sequi in officia est adipisci assumenda cumque consequatur nesciunt magnam eum repellat dignissimos non sed sed blanditiis laudantium.', 44729, 'https://via.placeholder.com/640x480.png/00ddee?text=voluptatem', '2021-10-19 17:32:06'),
	(44, 'Eius aut soluta incidunt delectus vel.', 'Autem iusto sunt dolorum molestiae necessitatibus sed architecto placeat error totam ab hic et qui amet pariatur et numquam error quas esse delectus.', 41002, 'https://via.placeholder.com/640x480.png/000033?text=quis', '2022-06-01 10:56:33'),
	(45, 'Vel inventore consequatur rem incidunt dolores natus.', 'Ullam ea et enim temporibus autem est et minima aut quisquam ut libero pariatur sapiente id expedita in voluptas quis quasi modi sint officiis laborum.', 39530, 'https://via.placeholder.com/640x480.png/008822?text=consectetur', '2022-01-13 07:48:13'),
	(46, 'Aut magni architecto.', 'Aut eius natus quae et voluptas nisi labore magni autem eveniet quia voluptatem voluptas libero nisi ratione illum.', 40000, 'https://via.placeholder.com/640x480.png/008800?text=sapiente', '2022-03-15 09:36:54'),
	(47, 'Iusto cum laborum tenetur.', 'Aspernatur et sed quaerat blanditiis consequatur non quasi libero voluptas illum at blanditiis deleniti quo exercitationem.', 34376, 'https://via.placeholder.com/640x480.png/0066aa?text=tempora', '2022-04-29 21:59:48'),
	(48, 'Expedita voluptatem qui.', 'Aut error tempore tempora atque alias delectus dolores rerum pariatur molestiae saepe corrupti ipsum.', 64868, 'https://via.placeholder.com/640x480.png/007722?text=architecto', '2022-06-18 10:12:43'),
	(49, 'Doloribus nulla ullam culpa quo.', 'Et esse maiores laborum saepe et aut totam suscipit deserunt cumque sed sit quasi eos.', 33924, 'https://via.placeholder.com/640x480.png/001133?text=excepturi', '2022-05-25 12:12:25'),
	(50, 'Et quo blanditiis voluptate quas.', 'Sint quo eos et nisi quidem dolor voluptas ut similique debitis doloribus doloribus reprehenderit qui dolorem non repellendus dolorem quis totam aut eius et omnis vel qui.', 37077, 'https://via.placeholder.com/640x480.png/004455?text=corrupti', '2022-03-12 07:34:22'),
	(51, 'Excepturi repellat enim culpa voluptate dolor exercitationem.', 'Qui quam et aut quasi ut et eum minima omnis enim velit quia repudiandae sint iure sequi earum consequuntur ex at et in non.', 52369, 'https://via.placeholder.com/640x480.png/00ff44?text=enim', '2022-05-03 11:09:03'),
	(52, 'Ipsam dolorum eaque molestiae quam dolor odio.', 'Vero est modi voluptate pariatur exercitationem quis inventore quis qui autem tempore velit.', 52591, 'https://via.placeholder.com/640x480.png/009922?text=voluptatibus', '2021-08-25 07:19:58'),
	(53, 'Voluptatibus eos nihil eum.', 'Reiciendis sit magni ipsum sit aperiam et libero nisi sint at quae error fuga totam iure ut atque porro sed hic.', 78426, 'https://via.placeholder.com/640x480.png/0055ee?text=aut', '2022-03-09 13:57:18'),
	(54, 'Provident molestias deserunt ipsa.', 'Ipsum corporis eaque dolor eius aut rerum dolorem voluptatem laborum sed sit nulla voluptas maxime quaerat est non soluta neque.', 68627, 'https://via.placeholder.com/640x480.png/00ddff?text=rerum', '2021-11-02 23:32:53'),
	(55, 'Occaecati est exercitationem sunt nam.', 'Quis ut voluptatem et veniam ut ea autem corrupti modi quo nulla consequatur sit est et ullam corporis maxime aut debitis ut reiciendis.', 51164, 'https://via.placeholder.com/640x480.png/007788?text=beatae', '2021-12-06 19:51:51'),
	(56, 'Quisquam minima eveniet et non id.', 'Et iusto eos necessitatibus quae et est consequatur adipisci sed mollitia et voluptatibus doloribus aspernatur ullam.', 44266, 'https://via.placeholder.com/640x480.png/0055ff?text=ab', '2022-01-10 08:05:56'),
	(57, 'Iure ratione et adipisci quis.', 'Sed natus dolore dolores aliquam possimus iusto quae minima aliquam eius voluptatibus aut.', 76103, 'https://via.placeholder.com/640x480.png/003322?text=consequuntur', '2022-03-01 05:22:40'),
	(58, 'Vitae blanditiis possimus aut.', 'Non quia animi voluptates provident similique officiis quas nihil aut ut cum sapiente eaque unde facere delectus excepturi repellat qui veritatis id qui nihil.', 41283, 'https://via.placeholder.com/640x480.png/003311?text=sint', '2022-01-23 05:54:38'),
	(59, 'Ratione tempore sed quo dolor.', 'Nobis perspiciatis dignissimos unde deleniti esse et voluptates doloremque et nemo odio omnis inventore placeat.', 64873, 'https://via.placeholder.com/640x480.png/008888?text=doloremque', '2022-04-29 18:07:34'),
	(60, 'Aut veritatis non voluptatum dolores dolores earum.', 'Exercitationem fugiat tempore suscipit distinctio optio libero vel aut autem eligendi non est assumenda iusto ipsa aut sunt amet officia facilis.', 33813, 'https://via.placeholder.com/640x480.png/0088cc?text=voluptas', '2021-11-29 21:30:39'),
	(61, 'Modi ipsum et reprehenderit.', 'Quibusdam est at eum asperiores quae voluptatem sapiente dolor consequatur cumque voluptatem dolore asperiores aut cum doloremque aut accusantium enim officia fugit.', 64956, 'https://via.placeholder.com/640x480.png/003300?text=dolor', '2022-04-21 14:21:32'),
	(62, 'Eum numquam at quasi ducimus quis ut.', 'Praesentium quis alias enim impedit omnis rerum et possimus qui architecto eum mollitia consequatur minus vero qui excepturi ex cupiditate expedita ex.', 48498, 'https://via.placeholder.com/640x480.png/001144?text=quo', '2022-02-11 18:36:05'),
	(63, 'Sunt quas non perferendis praesentium.', 'Expedita voluptate qui sequi similique suscipit totam nostrum ut magni ab illo aperiam dolorem dolorem provident doloremque aut odit officia beatae soluta aspernatur et labore.', 47880, 'https://via.placeholder.com/640x480.png/0033dd?text=occaecati', '2022-04-10 17:37:17'),
	(64, 'Corporis est adipisci rem aliquam possimus.', 'Ratione quidem recusandae recusandae dignissimos repudiandae fugiat aut sint facilis quod ut dolor molestiae inventore ullam officia laboriosam dolor sunt enim non facere.', 41395, 'https://via.placeholder.com/640x480.png/003388?text=ut', '2021-11-02 20:42:23'),
	(65, 'Sunt unde repellendus autem sit.', 'Nisi eligendi voluptatem nulla non quia autem officiis et molestiae quia veniam vero doloremque.', 41981, 'https://via.placeholder.com/640x480.png/00ee11?text=alias', '2022-03-14 21:09:14'),
	(66, 'Ipsum ut cum quis temporibus aliquid est.', 'Quia quia voluptas magnam neque labore odio tempore suscipit sapiente nulla iste velit placeat ut dolorum nesciunt voluptatibus non quae.', 38063, 'https://via.placeholder.com/640x480.png/003333?text=saepe', '2021-11-02 04:10:36'),
	(67, 'Illum necessitatibus id et ullam quibusdam exercitationem.', 'Dolor quaerat voluptatibus vel delectus in architecto aperiam ut facere et quisquam quis eius assumenda qui eum molestias dolor cum consequuntur ex et tempore nisi est.', 65150, 'https://via.placeholder.com/640x480.png/00aa99?text=aut', '2022-04-11 21:16:07'),
	(68, 'Ut aliquid et vero.', 'Aut voluptatibus amet veritatis harum labore molestiae eius velit quo velit officiis laboriosam.', 71339, 'https://via.placeholder.com/640x480.png/003300?text=assumenda', '2022-03-26 15:29:19'),
	(69, 'Sequi harum sapiente sunt commodi iure.', 'At nemo sed debitis et laudantium iusto quos molestias est libero architecto amet quia quod est eveniet.', 62097, 'https://via.placeholder.com/640x480.png/00ccee?text=iste', '2022-03-13 01:24:49'),
	(70, 'Eum ad ducimus et hic optio.', 'In voluptas ipsa et voluptas qui ut reprehenderit nesciunt quia dolore sed eligendi voluptas voluptatem esse impedit.', 64009, 'https://via.placeholder.com/640x480.png/0055bb?text=tenetur', '2022-03-16 11:29:13'),
	(71, 'Ratione qui sint et molestiae amet exercitationem.', 'Dicta ut quisquam eum quia modi aut excepturi tenetur architecto ullam aut aut.', 37955, 'https://via.placeholder.com/640x480.png/0077ff?text=sint', '2021-09-27 05:10:22'),
	(72, 'Praesentium ex voluptatibus qui sed.', 'Culpa praesentium vitae molestiae qui eos aliquid omnis beatae vero enim ut excepturi sit ad illum vitae illum aut voluptatem exercitationem facilis exercitationem numquam.', 31874, 'https://via.placeholder.com/640x480.png/0088aa?text=aspernatur', '2021-11-16 19:05:00'),
	(73, 'Est est omnis voluptatem.', 'Earum qui nihil et nobis impedit eveniet et laborum voluptatibus officiis dolorum voluptas soluta dolorem autem officia sed facere ipsam mollitia error asperiores fuga.', 57618, 'https://via.placeholder.com/640x480.png/00eecc?text=est', '2022-06-19 09:26:33'),
	(74, 'Aut eos sit saepe.', 'Beatae sapiente et et sunt nobis sunt blanditiis pariatur placeat vitae cumque nostrum repudiandae molestias voluptas officiis officiis sit dignissimos.', 73396, 'https://via.placeholder.com/640x480.png/0055aa?text=sed', '2021-08-28 11:08:15'),
	(75, 'Aut quis et laboriosam voluptate.', 'Repellat dolores voluptatum voluptate delectus ipsum sed explicabo minus reiciendis et rerum beatae cumque.', 60296, 'https://via.placeholder.com/640x480.png/00dd77?text=excepturi', '2022-04-06 03:40:30'),
	(76, 'Qui qui praesentium aut ut.', 'Eos atque quas cumque soluta enim assumenda ea minus beatae impedit eos esse voluptate.', 39490, 'https://via.placeholder.com/640x480.png/00bb55?text=sit', '2021-12-05 15:38:05'),
	(77, 'Temporibus doloremque ut ea et ea asperiores.', 'Illo labore illum vero autem est vel itaque sunt aliquid voluptas quasi amet sit quibusdam cum magnam.', 68284, 'https://via.placeholder.com/640x480.png/000022?text=ut', '2021-10-13 14:55:23'),
	(78, 'Consequuntur commodi ducimus dolorem sequi.', 'Dicta et eligendi vel magni rem nam quia et at qui adipisci dolor possimus distinctio ut ut nostrum quo harum similique assumenda.', 66607, 'https://via.placeholder.com/640x480.png/00bbbb?text=et', '2021-08-23 17:00:38'),
	(79, 'Quo voluptatem quia non unde.', 'Suscipit culpa nam et iste ullam eaque vero recusandae quos non voluptatem eos autem est voluptas dignissimos.', 71318, 'https://via.placeholder.com/640x480.png/003311?text=fugit', '2022-02-05 13:27:05'),
	(80, 'Velit aspernatur aperiam maxime.', 'Totam et et magnam ducimus sequi iste doloribus rerum rerum velit aliquid repellat a soluta quos et natus quidem aspernatur neque et sunt illo voluptatibus ad perspiciatis commodi.', 52574, 'https://via.placeholder.com/640x480.png/0077cc?text=velit', '2021-12-31 00:47:19'),
	(81, 'A sint distinctio aliquam.', 'Natus qui sit nemo sed voluptatibus suscipit at sed magnam ut illum nisi vero voluptatum neque sed ipsa enim.', 69568, 'https://via.placeholder.com/640x480.png/007700?text=amet', '2022-01-11 13:56:05'),
	(82, 'Iste consequatur explicabo expedita commodi saepe.', 'Qui odio nostrum consequatur esse quo natus et nobis enim quae necessitatibus corrupti sequi pariatur repudiandae accusamus reprehenderit asperiores.', 66129, 'https://via.placeholder.com/640x480.png/006644?text=dolor', '2022-02-09 03:25:04'),
	(83, 'In cum qui aut in.', 'Sit tenetur eos error sed unde corrupti et a sed ut et consequatur et aperiam iure quae rerum consequatur ut harum.', 30366, 'https://via.placeholder.com/640x480.png/00cc77?text=facilis', '2022-06-18 09:13:49'),
	(84, 'Architecto et est non dolorem.', 'Optio error est dolorem sit illum nisi architecto molestiae eos aut sequi debitis dolor doloremque deleniti accusantium quia ut consequatur sit eius nemo illo.', 53430, 'https://via.placeholder.com/640x480.png/001155?text=libero', '2021-10-09 13:17:02'),
	(85, 'Rerum error et.', 'Asperiores cum velit veritatis tenetur voluptate omnis repellendus iusto qui voluptas perspiciatis eligendi fugiat optio repudiandae dolorem saepe et at autem consequuntur voluptas quia dolor ut facilis.', 51191, 'https://via.placeholder.com/640x480.png/00dd88?text=asperiores', '2022-01-10 09:32:47'),
	(86, 'Et magni voluptatem ullam ut quam.', 'Iste accusamus ipsa rerum voluptas consequatur quo ut atque cupiditate dolores id sint quia id soluta voluptates enim corrupti dolorem.', 59428, 'https://via.placeholder.com/640x480.png/005522?text=dolor', '2021-09-01 18:57:14'),
	(87, 'Ipsam excepturi aliquam eum.', 'Eius aut et voluptates veniam dicta cumque doloribus numquam reprehenderit ad culpa suscipit sed occaecati.', 37567, 'https://via.placeholder.com/640x480.png/00dd00?text=quo', '2022-04-07 13:40:54'),
	(88, 'Eos sit delectus id minus et.', 'Et autem laudantium nihil ea quia commodi vero nemo voluptas minus animi ducimus in quia omnis beatae fuga cupiditate et in doloribus ratione.', 79081, 'https://via.placeholder.com/640x480.png/00ddff?text=ut', '2021-12-09 20:16:05'),
	(89, 'Est fuga sunt illum velit dolorem.', 'Voluptatibus quod est quibusdam quis dolores assumenda et id pariatur qui repellendus accusamus dignissimos nisi maiores et et ut error ut et quis placeat qui ducimus.', 31962, 'https://via.placeholder.com/640x480.png/002277?text=ut', '2021-10-10 00:42:55'),
	(90, 'Quasi quia ut amet provident consequatur.', 'Harum consequuntur consectetur incidunt voluptas voluptatem hic ducimus eligendi ducimus ipsa molestiae ducimus earum omnis velit ratione.', 42908, 'https://via.placeholder.com/640x480.png/00bbbb?text=eligendi', '2021-11-24 00:47:12'),
	(91, 'Unde quae aut repellendus autem ut similique.', 'Iure nam quae aut non necessitatibus provident commodi autem eveniet non eum vel et sunt perspiciatis cupiditate autem itaque debitis ut qui magni praesentium repellat non.', 37101, 'https://via.placeholder.com/640x480.png/00ee99?text=omnis', '2022-05-30 03:01:40'),
	(92, 'Ut architecto et minima tempora architecto.', 'In sed aut nemo rerum commodi tenetur nobis consequatur qui autem animi quia eligendi facere totam itaque sapiente illum unde recusandae repudiandae fuga quis dolor eum.', 30057, 'https://via.placeholder.com/640x480.png/004411?text=et', '2022-04-07 12:56:13'),
	(93, 'Et quas earum.', 'Sit minus libero voluptatem nihil iure adipisci veritatis nihil non molestiae asperiores exercitationem harum.', 64395, 'https://via.placeholder.com/640x480.png/0033ee?text=veniam', '2021-11-30 12:17:30'),
	(94, 'Quod dolor repudiandae quis sunt.', 'Facere ea reiciendis vero eum id et voluptas et nulla quos adipisci modi.', 33540, 'https://via.placeholder.com/640x480.png/003388?text=ut', '2021-10-22 03:22:32'),
	(95, 'Repudiandae rerum suscipit minus vel.', 'Quisquam eos cum voluptate amet repellendus eum ea amet ad aut cupiditate quis nulla dolores laborum nulla omnis ut.', 71389, 'https://via.placeholder.com/640x480.png/00ccff?text=et', '2022-01-20 02:08:25'),
	(96, 'Suscipit consequatur nisi consequatur rerum sit.', 'Totam ratione nostrum reiciendis quia a rerum culpa sit facere accusantium facilis qui sint quasi sint eum nobis ut quia perferendis doloremque velit fuga quos tempora.', 73803, 'https://via.placeholder.com/640x480.png/0022ff?text=ipsa', '2022-03-14 05:47:52'),
	(97, 'Dolorem dolor praesentium officiis quia ut vel.', 'Rerum autem error qui neque nesciunt aut necessitatibus natus perferendis recusandae eum illo consectetur quasi nemo aperiam itaque animi sint soluta autem ut laboriosam quod ex.', 68319, 'https://via.placeholder.com/640x480.png/00dddd?text=sunt', '2022-03-05 07:47:20'),
	(98, 'Esse dolores sit veniam.', 'Odio excepturi aut officia a vero commodi velit impedit alias quos non ab minus illo distinctio ipsam consequatur iusto iusto aspernatur incidunt et earum.', 37767, 'https://via.placeholder.com/640x480.png/00ccbb?text=corrupti', '2022-03-20 06:30:53'),
	(99, 'Error adipisci nesciunt quisquam.', 'Voluptas saepe et delectus qui debitis possimus cum quisquam aut id aliquam excepturi et inventore eveniet aut quisquam distinctio eveniet iure nesciunt.', 56669, 'https://via.placeholder.com/640x480.png/00dddd?text=dolorem', '2022-05-27 16:47:04'),
	(100, 'Molestiae voluptas ratione quis.', 'Voluptas sit qui est sint sed laboriosam velit animi iure aut quidem dolor et ullam cumque voluptatibus.', 73791, 'https://via.placeholder.com/640x480.png/000055?text=temporibus', '2021-11-26 03:25:37'),
	(101, 'San pham A', 'Mo ta san pham', 100000, 'https://via.placeholder.com/640x480.png/00ccbb?text=nulla', '2023-04-21 15:54:59'),
	(102, 'San pham A', 'Mo ta san pham', 100000, 'https://via.placeholder.com/640x480.png/00ccbb?text=nulla', '2023-04-22 21:29:39'),
	(103, 'San pham A', 'Mo ta san pham', 100000, 'https://via.placeholder.com/640x480.png/00ccbb?text=nulla', '2023-04-22 21:33:31');

-- Dumping structure for table web_service.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table web_service.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `is_admin`, `token`, `created_at`) VALUES
	(1, 'Customer Name', 'customer@gmail.com', '$2y$10$t5I.TKWEQnvzgl8tEnUsEe7TD7LcjFeaM9J3FnylAlKVUE7JGLaSW', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjEiLCJuYW1lIjoiQ3VzdG9tZXIgTmFtZSIsImVtYWlsIjoiY3VzdG9tZXJAZ21haWwuY29tIiwiaXNfYWRtaW4iOiIwIiwiY3JlYXRlZF9hdCI6IjIwMjMtMDQtMjEgMDg6MDE6MzgifQ.755DZu5YB8VTHH5JP2Ja7ZxRgTamBzkOB6Irk67e6TU', '2023-04-21 08:01:38'),
	(2, 'Admin Name', 'admin@gmail.com', '$2y$10$jWUDNCWOA6rw81RDGoew/.KVEXQmbp.z.c8LQ3btCbxYcAq8un6V.', 1, '', '2023-04-21 08:01:38'),
	(3, 'abv', 'customer1@gmail.com', '$2y$10$vHRDlhe3ued5Aunmwe3UVuKTxG55Uz2f3vuo4qTtRbeM2OkRvaWpS', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjMiLCJuYW1lIjoiYWJ2IiwiZW1haWwiOiJjdXN0b21lcjFAZ21haWwuY29tIiwiaXNfYWRtaW4iOiIwIiwiY3JlYXRlZF9hdCI6IjIwMjMtMDQtMjEgMTU6MzE6MDAifQ.yJpLOUpOoWhsBlCIo1W6FkTZnAnaMs5EVtw0hr_HUds', '2023-04-21 15:31:00'),
	(4, 'Nhat Tan Vu', 'nhattan@gmail.com', '$2y$10$avtlcNbEr1kgUK2Lub0uc.jtKW2rxGQSgB1zL7xKWH/bz1yhhbvOi', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjQiLCJuYW1lIjoiTmhhdCBUYW4gVnUiLCJlbWFpbCI6Im5oYXR0YW5AZ21haWwuY29tIiwiaXNfYWRtaW4iOiIwIiwiY3JlYXRlZF9hdCI6IjIwMjMtMDQtMjIgMjE6MjY6MzcifQ.XUHbIGUEOIao76l0RWLvV0zrxnsH3GiY5C9oVoX2l2Y', '2023-04-22 21:26:37'),
	(5, 'Nhat Tan Vu', 'nhattan123@gmail.com', '$2y$10$Fm0.YUJsxUixG7sAc7p7O.lv9HSwSXoC12nSS8nFLNK2fQc/AUbAO', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjUiLCJuYW1lIjoiTmhhdCBUYW4gVnUiLCJlbWFpbCI6Im5oYXR0YW4xMjNAZ21haWwuY29tIiwiaXNfYWRtaW4iOiIwIiwiY3JlYXRlZF9hdCI6IjIwMjMtMDQtMjIgMjE6MzE6MjAifQ.gpS4RQGW_CvDTkIEjWMQ7p4tiXcWF6zk9Fkp2INGjh8', '2023-04-22 21:31:20');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

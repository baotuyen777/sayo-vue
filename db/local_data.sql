-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
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

-- Dumping data for table sayo.categories: ~5 rows (approximately)
DELETE FROM `medias`;
INSERT INTO `medias` (`id`, `name`, `url`, `type`, `description`, `size`, `status`, `created_at`, `updated_at`) VALUES
	(1, '1', 'uploads/2023-08-12/3f115d4b4d8285dcdc93.jpg', NULL, NULL, NULL, 1, NULL, NULL),
	(2, '2', 'uploads/2023-08-12/33.jpg', NULL, NULL, NULL, 1, NULL, NULL);
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `code`, `parent_id`, `status`, `avatar_id`, `created_at`, `updated_at`) VALUES
	(1, 'Bất động sản', 'bds', 0, 1, NULL, NULL, NULL),
	(2, 'Đồ điện tử', 'do-dien-tu', 0, 1, NULL, NULL, NULL),
	(3, 'Đồ gia dụng', 'do-gia-dung', 0, 1, NULL, NULL, NULL),
	(4, 'Dịch vụ', 'dich-vu', 0, 1, NULL, NULL, NULL),
	(5, 'Khác', 'khac', 0, 1, NULL, NULL, NULL);

-- Dumping data for table sayo.departments: ~2 rows (approximately)
DELETE FROM `departments`;
INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Quản trị', NULL, NULL),
	(2, 'Nhân viên', NULL, NULL);
-- Dumping data for table sayo.users: ~3 rows (approximately)
DELETE FROM `users_status`;
INSERT INTO `users_status` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Hoạt động', NULL, NULL),
	(2, 'Tạm dừng', NULL, NULL);
DELETE FROM `users`;
INSERT INTO `users` (`id`, `avatar`, `username`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `login_at`, `change_password_at`, `created_at`, `updated_at`, `departments_id`, `status_id`, `role`) VALUES
	(1, NULL, 'admin', 'Admin', 'admin@gmail.com', NULL, '$2y$10$ta7VWu8nN3ZdHk4ey7BRo.zfTjOwWo8vB2HkZ45SQUZA315wlAdFO', NULL, NULL, NULL, NULL, NULL, 1, 1, 1),
	(2, NULL, 'nva', 'Nguyễn Văn A', 'nva@gmail.com', NULL, '$2y$10$HZKrJv38nxsYuk12uRt4XegBtYRa7uMnpibqWgtk7QVLTxDhVBide', NULL, NULL, NULL, NULL, NULL, 1, 1, 2),
	(3, NULL, 'shoptretho', 'Shop tre tho', 'stt@gmail.com', NULL, '$2y$10$/4v4X9xaNBtPm99IVhdJBOa656nxENhn2vRu.swxtaAWZ8a2x/fX6', NULL, NULL, NULL, NULL, NULL, 1, 1, 3);

-- Dumping data for table sayo.users_status: ~2 rows (approximately)


-- Dumping data for table sayo.failed_jobs: ~0 rows (approximately)
DELETE FROM `failed_jobs`;

-- Dumping data for table sayo.medias: ~2 rows (approximately)


-- Dumping data for table sayo.migrations: ~16 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(98, '2023_07_04_155143_create_posts_medias_table', 1),
	(804, '2014_10_12_000000_create_users_table', 2),
	(805, '2014_10_12_100000_create_password_reset_tokens_table', 2),
	(806, '2019_08_19_000000_create_failed_jobs_table', 2),
	(807, '2019_12_14_000001_create_personal_access_tokens_table', 2),
	(808, '2023_05_14_234034_create_users_status_table', 2),
	(809, '2023_05_14_234100_create_departments_table', 2),
	(810, '2023_05_14_235508_alter_users_table', 2),
	(811, '2023_05_16_082848_create_pdws_table', 2),
	(812, '2023_06_09_134446_create_settings_table', 2),
	(813, '2023_06_15_164158_create_medias_table', 2),
	(814, '2023_06_16_155746_create_categories_table', 2),
	(815, '2023_06_16_161237_create_posts_table', 2),
	(816, '2023_06_17_092145_create_products_table', 2),
	(817, '2023_06_25_075831_create_orders_table', 2),
	(818, '2023_07_04_155143_create_posts_gallery_table', 2);

-- Dumping data for table sayo.orders: ~9 rows (approximately)


-- Dumping data for table sayo.password_reset_tokens: ~0 rows (approximately)
DELETE FROM `password_reset_tokens`;

-- Dumping data for table sayo.pdws: ~8 rows (approximately)
DELETE FROM `pdws`;
INSERT INTO `pdws` (`id`, `code`, `name`, `level`, `status`, `parent_id`, `created_at`, `updated_at`) VALUES
	(1, 'hn', 'Hà Nội', 1, 1, 1, NULL, NULL),
	(2, 'hn-tx', 'Thanh Xuân', 2, 1, 1, NULL, NULL),
	(3, 'hn-dd', 'Đống Đa', 2, 1, 1, NULL, NULL),
	(4, 'hcm', 'TP. Hồ Chí Minh', 1, 1, 1, NULL, NULL),
	(5, 'hn-tx-txb', 'Thanh Xuân Bắc', 3, 1, 2, NULL, NULL),
	(6, 'hn-tx-txn', 'Thanh Xuân Nam', 3, 1, 2, NULL, NULL),
	(7, 'hn-tx-tv', 'Trung Văn', 3, 1, 2, NULL, NULL),
	(8, 'hn-tx-nc', 'Nhân Chính', 3, 1, 2, NULL, NULL);

-- Dumping data for table sayo.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;

-- Dumping data for table sayo.posts: ~9 rows (approximately)
DELETE FROM `posts`;
INSERT INTO `posts` (`id`, `name`, `code`, `content`, `status`, `price`, `address`, `ward_id`, `district_id`, `province_id`, `avatar_id`, `video_id`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Russel KilbackMr. Anibal Flatley VLucy WuckertDomingo Emmerich IIIMiss Ellie Streich III__1', '1692104916_1', 'value 1', 1, 1445016927, '0', 5, 2, 1, 1, NULL, 1, 1, NULL, NULL),
	(2, 'Jesse McCulloughMariela D\'Amore IVMs. Jaunita BaileyLitzy FaheyNolan Lockman__2', '1692104916_2', 'value 2', 1, 1811888982, '0', 5, 2, 1, 1, NULL, 1, 1, NULL, NULL),
	(3, 'Prof. Lorenz Raynor DDSIlene PriceFlavio JacobiNikko AltenwerthLiliana Gottlieb__3', '1692104916_3', 'value 3', 1, 747904136, '0', 5, 2, 1, 2, NULL, 1, 1, NULL, NULL),
	(4, 'Estell Legros MDDr. Benny CollierFlossie MurazikAndreanne GreenholtMargarita Watsica__4', '1692104916_4', 'value 4', 1, 416612115, '0', 5, 2, 1, 2, NULL, 1, 1, NULL, NULL),
	(5, 'Dr. Korey Langosh IIAurore MillsGianni BashirianMiss Bernita LangworthMiss Frida Hettinger PhD__5', '1692104916_5', 'value 5', 1, 1113336859, '0', 5, 2, 1, 2, NULL, 1, 1, NULL, NULL),
	(6, 'Madaline Schimmel PhDMiss Marge Schaden VImani SchadenLewis Lebsack IIIPhyllis Lubowitz__6', '1692104916_6', 'value 6', 1, 2224029388, '0', 5, 2, 1, 1, NULL, 1, 1, NULL, NULL),
	(7, 'Vada Koss IIIProf. Eddie Hoeger IIAngeline WunschEmie RolfsonDexter Hansen__7', '1692104916_7', 'value 7', 1, 917955494, '0', 5, 2, 1, 1, NULL, 1, 1, NULL, NULL),
	(8, 'Dr. Israel Mohr Jr.Rhoda Metz DDSJerrell HettingerProf. Mackenzie Gulgowski IIIMr. Hilbert Hilpert IV__8', '1692104916_8', 'value 8', 1, 1222999455, '0', 5, 2, 1, 2, NULL, 1, 1, NULL, NULL),
	(9, 'Colt ThompsonSallie CassinJairo Heaney IVDana Hayes IIMr. Joel Bogisich DVM__9', '1692104916_9', 'value 9', 1, 1869755888, '0', 5, 2, 1, 2, NULL, 1, 1, NULL, NULL);

-- Dumping data for table sayo.posts_gallery: ~0 rows (approximately)
DELETE FROM `posts_gallery`;
INSERT INTO `posts_gallery` (`id`, `posts_id`, `medias_id`, `type`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'gallery', NULL, NULL),
	(2, 1, 2, 'gallery', NULL, NULL);

-- Dumping data for table sayo.products: ~9 rows (approximately)
DELETE FROM `products`;
INSERT INTO `products` (`id`, `name`, `code`, `content`, `avatar`, `gallery`, `video`, `status`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'product 1', 'code 1', 'value 1', NULL, NULL, NULL, 1, 3, 1, NULL, NULL),
	(2, 'product 2', 'code 2', 'value 2', NULL, NULL, NULL, 1, 5, 1, NULL, NULL),
	(3, 'product 3', 'code 3', 'value 3', NULL, NULL, NULL, 1, 4, 1, NULL, NULL),
	(4, 'product 4', 'code 4', 'value 4', NULL, NULL, NULL, 1, 5, 1, NULL, NULL),
	(5, 'product 5', 'code 5', 'value 5', NULL, NULL, NULL, 1, 3, 1, NULL, NULL),
	(6, 'product 6', 'code 6', 'value 6', NULL, NULL, NULL, 1, 3, 1, NULL, NULL),
	(7, 'product 7', 'code 7', 'value 7', NULL, NULL, NULL, 1, 5, 1, NULL, NULL),
	(8, 'product 8', 'code 8', 'value 8', NULL, NULL, NULL, 1, 1, 1, NULL, NULL),
	(9, 'product 9', 'code 9', 'value 9', NULL, NULL, NULL, 1, 4, 1, NULL, NULL);

-- Dumping data for table sayo.settings: ~2 rows (approximately)
DELETE FROM `settings`;
INSERT INTO `settings` (`id`, `name`, `code`, `value`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'setting1', 'setting', 'value1', 1, NULL, NULL),
	(2, 'setting2', 'setting2', 'value2', 1, NULL, NULL);



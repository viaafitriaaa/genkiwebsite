-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jan 2026 pada 10.49
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genkifood`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bundles`
--

CREATE TABLE `bundles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `student_only` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bundles`
--

INSERT INTO `bundles` (`id`, `title`, `description`, `price`, `image`, `student_only`, `created_at`, `updated_at`) VALUES
(1, 'Bundling Ceria 1', 'Promo Bundling Ceria! Beli 1 Mac n Cheese + 1 Genki...', 30000, 'bundle_ceria1.jpg', 1, NULL, NULL),
(2, 'Bundling Happy 1', 'Promo Bundling Happy! Beli 1 Genki Choco + 1 Genki...', 35000, 'bundle_happy1.jpg', 1, NULL, NULL),
(3, 'Bundling Ceria 2', 'Promo Bundling Ceria! Beli 1 GF Lengkap Drumstik +...', 40000, 'bundle_ceria2.jpg', 1, NULL, NULL),
(4, 'Bundling Suka', 'Bundling Suka! Beli 1 GF Lengkap Drumstik + 1 Mac...', 38000, 'bundle_suka.jpg', 1, NULL, NULL),
(5, 'Bundling Ceria 3', 'Promo Bundling Ceria! Beli 1 Mac n Cheese + 1 Genki...', 30000, 'bundle_ceria3.jpg', 1, NULL, NULL),
(6, 'Bundling Happy 2', 'Promo Bundling Happy! Beli 1 Genki Choco + 1 Genki...', 35000, 'bundle_happy2.jpg', 1, NULL, '2025-12-22 01:10:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_05_150640_create_products_table', 1),
(5, '2025_12_05_150641_create_bundles_table', 1),
(6, '2025_12_05_150641_create_orders_table', 1),
(7, '2025_12_05_150642_create_order_items_table', 1),
(8, '2025_12_05_150642_create_payments_table', 1),
(9, '2025_12_14_000000_add_category_to_products_table', 1),
(10, '2025_12_14_000001_add_customer_info_to_orders_table', 1),
(11, '2025_12_14_000002_create_payment_logs_table', 1),
(12, '2025_12_14_000003_add_promo_fields_to_orders_table', 1),
(13, '2025_12_14_000004_create_promos_table', 1),
(14, '2025_12_20_121819_add_image_to_bundles_table', 1),
(15, '2025_12_20_123643_add_image_to_products_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL DEFAULT 0,
  `total_after_promo` int(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `is_promo` tinyint(1) NOT NULL DEFAULT 0,
  `promo_proof_path` varchar(255) DEFAULT NULL,
  `promo_verified_at` timestamp NULL DEFAULT NULL,
  `promo_discount_percent` int(10) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_city` varchar(255) DEFAULT NULL,
  `customer_postal_code` varchar(20) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `total`, `total_after_promo`, `status`, `is_promo`, `promo_proof_path`, `promo_verified_at`, `promo_discount_percent`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_city`, `customer_postal_code`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 25000, 0, 'pending', 0, NULL, NULL, NULL, 'viaa', 'via@gmail.com', '08765675654', 'purwokerto', NULL, NULL, NULL, '2025-12-20 10:51:14', '2025-12-20 10:51:14'),
(2, 25000, 0, 'pending', 0, NULL, NULL, NULL, 'viaa', 'via@gmail.com', '08765675654', 'purwokerto', NULL, NULL, NULL, '2025-12-20 10:51:53', '2025-12-20 10:51:53'),
(3, 19000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-20 23:42:21', '2025-12-20 23:42:21'),
(4, 18000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-20 23:47:07', '2025-12-20 23:47:07'),
(5, 19000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-20 23:56:01', '2025-12-20 23:56:01'),
(6, 15000, 0, 'pending', 1, 'promo_proofs/6OlxtxGnJLr6KPvJY79sXN855DNkWGkFxooGGlQa.jpg', '2025-12-21 10:32:02', 10, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-20 23:59:41', '2025-12-21 10:32:02'),
(7, 18000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 00:28:50', '2025-12-21 00:28:51'),
(8, 30000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 01:07:40', '2025-12-21 01:07:40'),
(9, 35000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 03:23:19', '2025-12-21 03:23:19'),
(10, 37000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 03:57:01', '2025-12-21 03:57:01'),
(11, 56000, 0, 'pending', 0, NULL, NULL, NULL, 'viaa', 'via@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 04:12:33', '2025-12-21 04:12:33'),
(12, 25000, 0, 'pending', 0, NULL, NULL, NULL, 'viaa', 'via@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 04:27:37', '2025-12-21 04:27:37'),
(13, 15000, 0, 'pending', 1, 'promo_proofs/CUW0eDJpf9PMybfF2lfr4RcdnA8CAs338ZGivWYP.jpg', '2025-12-21 05:03:12', 10, 'viaa', 'via@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 05:00:28', '2025-12-21 05:03:12'),
(14, 35000, 0, 'pending', 0, NULL, NULL, NULL, 'viaa', 'via@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 05:11:41', '2025-12-21 05:11:41'),
(15, 15000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 09:11:59', '2025-12-21 09:11:59'),
(16, 35000, 0, 'pending', 1, 'promo_proofs/BqTRDs5dnzQcbea72BXuUU6dh0MHCCBv3b9dfFT5.jpg', '2025-12-21 09:18:15', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 09:17:06', '2025-12-21 09:18:15'),
(17, 25000, 0, 'pending', 1, 'promo_proofs/kVPEzcjC21v3yaoFUL6D5wuvBQ32UoFyzIeqFlYK.png', '2025-12-21 09:37:39', 10, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 09:27:51', '2025-12-21 09:37:39'),
(18, 18000, 0, 'pending', 1, 'promo_proofs/5mSTeXnJII0HbhLM4ukolDIsZbI4cjih7SR0bBJE.png', '2025-12-21 09:48:56', 10, 'Via Fitria', 'via969@gmail.com', '0892722', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 09:39:11', '2025-12-21 09:48:56'),
(19, 24000, 0, 'pending', 1, 'promo_proofs/EsixsRneIxV8HCIYXRoap7fvcpW4wFGay8ArDsgy.jpg', '2025-12-21 10:49:41', 10, 'Via Fitria', 'viaachan@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 09:50:19', '2025-12-21 10:49:41'),
(20, 32000, 0, 'pending', 1, 'promo_proofs/7zv2Qw39ZoSJuJSpVvPNS923q0RkDrHi07yIm8EX.png', '2025-12-21 10:32:53', 10, 'Via Fitria', 'viapiw@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 10:20:27', '2025-12-21 10:32:53'),
(21, 24000, 0, 'pending', 1, 'promo_proofs/JC38ZWwy6m491D0IDbBzC8D6sAUeUrBQld5cbqWp.jpg', '2025-12-21 10:52:21', 10, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 10:51:51', '2025-12-21 10:52:21'),
(22, 35000, 0, 'pending', 1, 'promo_proofs/Xn1HVZlpmG8579dSuPApCLf8ciXMct57vLf3yZl2.png', '2025-12-21 10:58:26', 10, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 10:57:48', '2025-12-21 10:58:26'),
(23, 24000, 0, 'pending', 1, 'promo_proofs/tMgXCDFXCCiqjqNpDnfHFWtZCQY2OR2RULVF8bJ7.jpg', '2025-12-21 11:02:35', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 11:01:59', '2025-12-21 11:02:35'),
(24, 25000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 11:08:27', '2025-12-21 11:08:27'),
(25, 19000, 0, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-21 11:12:51', '2025-12-21 11:12:51'),
(26, 30400, 0, 'pending', 1, 'promo_proofs/uAmw54rpYVaTk1NWzPLja6SLuxyVEWxep2XZ5XPb.jpg', '2025-12-21 21:29:23', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 21:26:55', '2025-12-21 21:29:23'),
(27, 28000, 0, 'pending', 1, 'promo_proofs/ivtCyYJGj6LJiLxm9XA6dsVdI1y5rnK26z5tzrIw.jpg', '2025-12-21 21:32:54', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 21:32:19', '2025-12-21 21:32:54'),
(28, 32000, 0, 'pending', 1, 'promo_proofs/cjYLSTYVNDjvFIvUpzxJ07mdMnMpsxexmMpOQfS1.jpg', '2025-12-21 21:38:34', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 21:38:11', '2025-12-21 21:38:34'),
(29, 32000, 0, 'pending', 1, 'promo_proofs/df6sxUo7S9C91XbmOPw8xbez5RpZM5LVVGbCQx5P.jpg', '2025-12-21 21:45:31', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 21:45:02', '2025-12-21 21:45:31'),
(30, 32000, 0, 'pending', 1, 'promo_proofs/RN6z3P7iPJ6eOdPssPFVC9ZUxkivOeDJRLggVF6g.jpg', '2025-12-21 21:48:04', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 21:47:24', '2025-12-21 21:48:04'),
(31, 32000, 0, 'pending', 1, 'promo_proofs/0f7Wz7XlSoieLBcvZHk1AOKsgDgVZ1qvGZmgLmuZ.jpg', '2025-12-21 22:01:49', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 22:01:18', '2025-12-21 22:01:49'),
(32, 25000, 0, 'pending', 0, NULL, NULL, NULL, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 22:09:51', '2025-12-21 22:09:51'),
(33, 28000, 0, 'pending', 1, 'promo_proofs/uyU4P1vrcufeKgjzExIIjpWXkNeXzzB7bb24LjLD.jpg', '2025-12-21 22:11:25', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 22:10:53', '2025-12-21 22:11:25'),
(34, 24000, 0, 'pending', 1, 'promo_proofs/pqGFru4J1bprZhTxPwA7qs0V7Rcqj9TWxDSS6vKb.jpg', '2025-12-21 22:37:21', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 22:36:24', '2025-12-21 22:37:21'),
(35, 28000, 0, 'pending', 1, 'promo_proofs/BI265WUKd3S1ibWfYiZKeJPbBOYUILtkUSvJmugd.jpg', '2025-12-21 23:09:57', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 23:09:14', '2025-12-21 23:09:57'),
(36, 28000, 0, 'pending', 1, 'promo_proofs/n4GokhYXiRkHVAxmueeyj1z0w5rjcUo8JFbyetOi.jpg', '2025-12-21 23:32:21', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 23:31:37', '2025-12-21 23:32:21'),
(37, 20000, 0, 'pending', 1, 'promo_proofs/ANJW6VZd6DVpR2aTTe4sszOy7oA7f7OCkNDxbNja.png', '2025-12-21 23:43:55', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 23:43:24', '2025-12-21 23:43:55'),
(38, 28000, 0, 'pending', 1, 'promo_proofs/obffbYzrM4PjNIDDztOKNREAsGy1RalFL6xyVA7K.jpg', '2025-12-21 23:58:49', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-21 23:58:06', '2025-12-21 23:58:49'),
(39, 28000, 0, 'pending', 1, 'promo_proofs/PwtSI8OWwVViBGAhV8J2witU9zMW9C6hYXCweStw.jpg', '2025-12-22 00:09:56', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 00:08:18', '2025-12-22 00:09:56'),
(40, 28000, 0, 'pending', 1, 'promo_proofs/ipT0ULtVNFgQ4FtVPQrJ8cyakWzM2YGUiz6CbiBW.jpg', '2025-12-22 01:05:15', 10, 'viaa', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 01:03:41', '2025-12-22 01:05:15'),
(41, 28000, 0, 'pending', 1, 'promo_proofs/ZCYEjexuSLZiAzb6f8npDzq4zvuHiEAWSX7vu0m1.jpg', '2025-12-22 07:08:18', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 07:07:34', '2025-12-22 07:08:18'),
(42, 18000, 0, 'pending', 0, NULL, NULL, NULL, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 07:17:19', '2025-12-22 07:17:19'),
(43, 18000, 0, 'success', 0, NULL, NULL, NULL, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 07:20:03', '2025-12-22 07:20:40'),
(44, 28000, 0, 'success', 1, 'promo_proofs/GuRAhph4oWtUOGCprJ0SK14WxFczrZTuO01pkbPl.jpg', '2025-12-22 07:24:20', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 07:23:45', '2025-12-22 07:25:26'),
(45, 28000, 0, 'pending', 1, 'promo_proofs/HamfenJkkjJW0rjlYsggB1D2YZSCnPY6FZ3iyzfd.jpg', '2025-12-22 08:00:28', 10, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 08:00:00', '2025-12-22 08:00:28'),
(46, 16000, 0, 'pending', 1, 'promo_proofs/8g70E3m41uPEqCzNF4flEb3fAQyMI4Sl7FxoRBwn.jpg', '2025-12-22 08:33:39', 20, 'iahsoviah', 'iahsoviah@gmail.com', '08765675654', NULL, NULL, NULL, NULL, '2025-12-22 08:32:56', '2025-12-22 08:33:39'),
(47, 32000, 0, 'success', 1, 'promo_proofs/u90ZvW0wbdNAfg11g8uVhmgxHWmGioCkVfqWHbaA.jpg', '2025-12-22 21:16:15', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-22 21:15:30', '2025-12-22 21:17:36'),
(48, 32000, 0, 'success', 1, 'promo_proofs/cpzeVEf0rHoy0cMyoclMdMD8a3FSopw8ntzc2wzZ.jpg', '2025-12-22 22:00:05', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-22 21:45:16', '2025-12-22 22:01:28'),
(49, 28000, 0, 'success', 1, 'promo_proofs/74wTIiGVQ1plm39k0xGHahXwVhZ59iDq60cJlMHO.jpg', '2025-12-22 22:57:57', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-22 22:57:20', '2025-12-22 23:04:00'),
(50, 24000, 0, 'success', 1, 'promo_proofs/F4CFx6pr2J2dG6cJY29bRm70aLymg6gZVzEzaRY8.jpg', '2025-12-22 23:34:45', 10, 'Via Fitria', 'viapiw@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-22 23:34:03', '2025-12-22 23:35:25'),
(51, 18000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-22 23:37:54', '2025-12-22 23:38:21'),
(52, 17000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-23 00:00:27', '2025-12-23 00:01:09'),
(53, 19000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-23 00:03:46', '2025-12-23 00:09:06'),
(54, 19000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-23 00:11:01', '2025-12-23 00:11:53'),
(55, 18000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-23 00:17:09', '2025-12-23 00:17:53'),
(56, 20000, 0, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'ayun321@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-24 08:09:34', '2025-12-24 08:10:51'),
(57, 28000, 0, 'pending', 1, 'promo_proofs/S42oLnRMeId7j4ZgdrXjtuC2C5aZFE2RsMK9PuLl.jpg', '2025-12-25 06:42:24', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 06:41:26', '2025-12-25 06:42:24'),
(58, 32000, 0, 'pending', 1, 'promo_proofs/x9ZzugbTPxSM5ZZgSZGkRArdJIGLVyN77GEGmvs7.jpg', '2025-12-25 07:39:06', 10, 'Via Fitria', 'viapiw@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 07:00:45', '2025-12-25 07:39:06'),
(59, 35000, 28000, 'pending', 1, 'promo_proofs/GnxLroA3XoESsfFYzeZyiCaCqCHm86GyBOpiSKyy.png', '2025-12-25 07:53:42', 10, 'Via Fitria', 'via969@gmail.com', '0892722', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 07:41:54', '2025-12-25 07:53:42'),
(60, 80000, 64000, 'pending', 1, 'promo_proofs/RtPinq825tB5VBzlFhJCKMHhA9Ie8cn45w3OSPGU.jpg', '2025-12-25 08:11:34', 10, 'Via Fitria', 'via969@gmail.com', '0892722', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 08:11:05', '2025-12-25 08:11:34'),
(61, 20000, NULL, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '0892722', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 08:13:13', '2025-12-25 08:13:13'),
(62, 35000, NULL, 'pending', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 08:13:50', '2025-12-25 08:13:50'),
(63, 40000, 32000, 'success', 1, 'promo_proofs/KYUxUyK7qEbYBPUyRv1N3ldRKGa7bD6HGPJcocdK.jpg', '2025-12-25 08:18:39', 10, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 08:18:09', '2025-12-25 08:19:47'),
(64, 18000, NULL, 'success', 0, NULL, NULL, NULL, 'Via Fitria', 'via969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', NULL, NULL, '2025-12-25 08:40:48', '2025-12-25 08:41:21'),
(65, 35000, 28000, 'pending', 1, 'promo_proofs/7OeUV4wsq503ZQurU6UH0G7lJULVJEwtlyl2uqXz.jpg', '2025-12-28 01:39:13', 10, 'Via Fitria', 'viaf969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', '53123', NULL, '2025-12-28 01:37:30', '2025-12-28 01:39:13'),
(66, 35000, 28000, 'pending', 1, 'promo_proofs/gDBZTAXYgJvjMVEv3kVpqQtEfnTvZzX40FDkhSes.jpg', '2025-12-28 02:23:24', 10, 'Via Fitria', 'viaf969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', '53123', NULL, '2025-12-28 02:22:40', '2025-12-28 02:23:24'),
(67, 30000, 24000, 'pending', 1, 'promo_proofs/qC4zKQkOW8RYOUMhOgcXJsr68950oI9bBhS0kXv5.jpg', '2025-12-28 02:51:58', 10, 'Via Fitria', 'viaf969@gmail.com', '083150817840', 'Jl. Gunung Putri, Karangwangkal', 'Purwokerto', '53123', NULL, '2025-12-28 02:50:23', '2025-12-28 02:51:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bundle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `bundle_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 47, NULL, 1, 25000, '2025-12-20 10:51:14', '2025-12-20 10:51:14'),
(2, 2, 47, NULL, 1, 25000, '2025-12-20 10:51:53', '2025-12-20 10:51:53'),
(3, 3, 39, NULL, 1, 19000, '2025-12-20 23:42:21', '2025-12-20 23:42:21'),
(4, 4, 37, NULL, 1, 18000, '2025-12-20 23:47:07', '2025-12-20 23:47:07'),
(5, 5, 39, NULL, 1, 19000, '2025-12-20 23:56:01', '2025-12-20 23:56:01'),
(6, 6, 42, NULL, 1, 15000, '2025-12-20 23:59:41', '2025-12-20 23:59:41'),
(7, 7, 36, NULL, 1, 18000, '2025-12-21 00:28:50', '2025-12-21 00:28:50'),
(8, 8, NULL, 5, 1, 30000, '2025-12-21 01:07:40', '2025-12-21 01:07:40'),
(9, 9, NULL, 2, 1, 35000, '2025-12-21 03:23:19', '2025-12-21 03:23:19'),
(10, 10, 40, NULL, 1, 17000, '2025-12-21 03:57:01', '2025-12-21 03:57:01'),
(11, 10, 43, NULL, 1, 20000, '2025-12-21 03:57:01', '2025-12-21 03:57:01'),
(12, 11, 39, NULL, 1, 19000, '2025-12-21 04:12:33', '2025-12-21 04:12:33'),
(13, 11, 36, NULL, 1, 18000, '2025-12-21 04:12:33', '2025-12-21 04:12:33'),
(14, 11, 39, NULL, 1, 19000, '2025-12-21 04:12:33', '2025-12-21 04:12:33'),
(15, 12, 47, NULL, 1, 25000, '2025-12-21 04:27:37', '2025-12-21 04:27:37'),
(16, 13, 42, NULL, 1, 15000, '2025-12-21 05:00:28', '2025-12-21 05:00:28'),
(17, 14, NULL, 2, 1, 35000, '2025-12-21 05:11:41', '2025-12-21 05:11:41'),
(18, 15, 42, NULL, 1, 15000, '2025-12-21 09:11:59', '2025-12-21 09:11:59'),
(19, 16, NULL, 2, 1, 35000, '2025-12-21 09:17:06', '2025-12-21 09:17:06'),
(20, 17, 48, NULL, 1, 25000, '2025-12-21 09:27:51', '2025-12-21 09:27:51'),
(21, 18, 36, NULL, 1, 18000, '2025-12-21 09:39:11', '2025-12-21 09:39:11'),
(22, 19, NULL, 5, 1, 24000, '2025-12-21 09:50:19', '2025-12-21 10:49:41'),
(23, 20, 40, NULL, 1, 17000, '2025-12-21 10:20:27', '2025-12-21 10:20:27'),
(24, 20, 42, NULL, 1, 15000, '2025-12-21 10:20:27', '2025-12-21 10:20:27'),
(25, 21, NULL, 5, 1, 24000, '2025-12-21 10:51:51', '2025-12-21 10:52:21'),
(26, 22, NULL, 2, 1, 35000, '2025-12-21 10:57:48', '2025-12-21 10:57:48'),
(27, 23, NULL, 1, 1, 24000, '2025-12-21 11:01:59', '2025-12-21 11:02:35'),
(28, 24, 47, NULL, 1, 25000, '2025-12-21 11:08:27', '2025-12-21 11:08:27'),
(29, 25, 39, NULL, 1, 19000, '2025-12-21 11:12:51', '2025-12-21 11:12:51'),
(30, 26, NULL, 4, 1, 30400, '2025-12-21 21:26:55', '2025-12-21 21:29:23'),
(31, 27, NULL, 2, 1, 28000, '2025-12-21 21:32:19', '2025-12-21 21:32:54'),
(32, 28, NULL, 3, 1, 32000, '2025-12-21 21:38:11', '2025-12-21 21:38:34'),
(33, 29, NULL, 3, 1, 32000, '2025-12-21 21:45:02', '2025-12-21 21:45:31'),
(34, 30, NULL, 3, 1, 32000, '2025-12-21 21:47:24', '2025-12-21 21:48:04'),
(35, 31, NULL, 3, 1, 32000, '2025-12-21 22:01:18', '2025-12-21 22:01:49'),
(36, 32, 47, NULL, 1, 25000, '2025-12-21 22:09:51', '2025-12-21 22:09:51'),
(37, 33, NULL, 2, 1, 28000, '2025-12-21 22:10:53', '2025-12-21 22:11:25'),
(38, 34, NULL, 5, 1, 24000, '2025-12-21 22:36:24', '2025-12-21 22:37:21'),
(39, 35, NULL, 2, 1, 28000, '2025-12-21 23:09:14', '2025-12-21 23:09:57'),
(40, 36, NULL, 2, 1, 28000, '2025-12-21 23:31:37', '2025-12-21 23:32:21'),
(41, 37, 43, NULL, 1, 20000, '2025-12-21 23:43:24', '2025-12-21 23:43:24'),
(42, 38, NULL, 2, 1, 28000, '2025-12-21 23:58:06', '2025-12-21 23:58:49'),
(43, 39, NULL, 2, 1, 28000, '2025-12-22 00:08:18', '2025-12-22 00:09:56'),
(44, 40, NULL, 2, 1, 28000, '2025-12-22 01:03:41', '2025-12-22 01:05:15'),
(45, 41, NULL, 2, 1, 28000, '2025-12-22 07:07:34', '2025-12-22 07:08:18'),
(46, 42, 36, NULL, 1, 18000, '2025-12-22 07:17:19', '2025-12-22 07:17:19'),
(47, 43, 36, NULL, 1, 18000, '2025-12-22 07:20:03', '2025-12-22 07:20:03'),
(48, 44, NULL, 2, 1, 28000, '2025-12-22 07:23:45', '2025-12-22 07:24:20'),
(49, 45, NULL, 2, 1, 28000, '2025-12-22 08:00:00', '2025-12-22 08:00:28'),
(50, 46, 43, NULL, 1, 20000, '2025-12-22 08:32:56', '2025-12-22 08:32:56'),
(51, 47, NULL, 3, 1, 32000, '2025-12-22 21:15:30', '2025-12-22 21:16:15'),
(52, 48, NULL, 3, 1, 32000, '2025-12-22 21:45:16', '2025-12-22 22:00:05'),
(53, 49, NULL, 6, 1, 28000, '2025-12-22 22:57:20', '2025-12-22 22:57:57'),
(54, 50, NULL, 5, 1, 24000, '2025-12-22 23:34:03', '2025-12-22 23:34:45'),
(55, 51, 36, NULL, 1, 18000, '2025-12-22 23:37:54', '2025-12-22 23:37:54'),
(56, 52, 40, NULL, 1, 17000, '2025-12-23 00:00:28', '2025-12-23 00:00:28'),
(57, 53, 39, NULL, 1, 19000, '2025-12-23 00:03:46', '2025-12-23 00:03:46'),
(58, 54, 39, NULL, 1, 19000, '2025-12-23 00:11:01', '2025-12-23 00:11:01'),
(59, 55, 37, NULL, 1, 18000, '2025-12-23 00:17:09', '2025-12-23 00:17:09'),
(60, 56, 43, NULL, 1, 20000, '2025-12-24 08:09:34', '2025-12-24 08:09:34'),
(61, 57, NULL, 2, 1, 28000, '2025-12-25 06:41:26', '2025-12-25 06:42:24'),
(62, 58, NULL, 3, 1, 32000, '2025-12-25 07:00:45', '2025-12-25 07:04:11'),
(63, 59, NULL, 2, 1, 35000, '2025-12-25 07:41:54', '2025-12-25 07:41:54'),
(64, 60, NULL, 3, 1, 40000, '2025-12-25 08:11:05', '2025-12-25 08:11:05'),
(65, 60, NULL, 3, 1, 40000, '2025-12-25 08:11:05', '2025-12-25 08:11:05'),
(66, 61, 43, NULL, 1, 20000, '2025-12-25 08:13:13', '2025-12-25 08:13:13'),
(67, 62, NULL, 2, 1, 35000, '2025-12-25 08:13:50', '2025-12-25 08:13:50'),
(68, 63, NULL, 3, 1, 40000, '2025-12-25 08:18:09', '2025-12-25 08:18:09'),
(69, 64, 36, NULL, 1, 18000, '2025-12-25 08:40:48', '2025-12-25 08:40:48'),
(70, 65, NULL, 2, 1, 35000, '2025-12-28 01:37:31', '2025-12-28 01:37:31'),
(71, 66, NULL, 2, 1, 35000, '2025-12-28 02:22:40', '2025-12-28 02:22:40'),
(72, 67, NULL, 5, 1, 30000, '2025-12-28 02:50:23', '2025-12-28 02:50:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(255) NOT NULL,
  `qris_data` text DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'food',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `image`, `created_at`, `updated_at`) VALUES
(35, 'Genki Mango', 'Mango manis dan creamy yang bikin hari makin fresh!', 18000, 'smoothie', 'genki_mangga.jpeg', NULL, NULL),
(36, 'Genki Strawberry', 'Strawberry manis dan creamy yang bikin hari makin fresh!', 18000, 'smoothie', 'genki_strawberry.jpeg', NULL, NULL),
(37, 'Genki Avocado', 'Avocado manis dan creamy yang bikin hari makin fresh!', 18000, 'smoothie', 'genki_avocado.jpeg', NULL, NULL),
(38, 'Genki Durian', 'Durian manis dan creamy yang bikin hari makin fresh!', 20000, 'smoothie', 'genki_durian.jpeg', NULL, NULL),
(39, 'Genki Dragon Fruit', 'Dragon Fruit manis dan creamy yang bikin hari makin fresh!', 19000, 'smoothie', 'genki_dragon.jpeg', NULL, NULL),
(40, 'Genki Choco', 'Choco manis dan creamy yang bikin hari makin fresh!', 17000, 'smoothie', 'genki_choco.jpeg', NULL, NULL),
(41, 'GF-Frency Drumstick', 'Potongan drumstick renyah dengan saus keju dan mayo yang melimpah.', 23000, 'food', 'genki_frencydrumstick.jpeg', NULL, NULL),
(42, 'Mac n Cheese', 'Makaroni dengan saus keju dan mayo yang melimpah.', 15000, 'food', 'genki_macncheese.jpeg', NULL, NULL),
(43, 'GF-Hore', 'Menu spesial dengan saus keju dan mayo yang melimpah.', 20000, 'food', 'genki_hore.jpeg', NULL, NULL),
(44, 'GF-Cisy Wings', 'Sayap ayam renyah dengan saus keju dan mayo yang melimpah.', 23000, 'food', 'genki_cisyy.jpeg', NULL, NULL),
(45, 'French Fries', 'Kentang goreng renyah dengan saus keju dan mayo yang melimpah.', 15000, 'food', 'genki_kentang.jpeg', NULL, NULL),
(46, 'GF-Lengkap Drumstick', 'Paket lengkap drumstick dengan saus keju dan mayo yang melimpah.', 25000, 'food', 'genki_drumstick.jpeg', NULL, NULL),
(47, 'GF-Lengkap Wings', 'Paket lengkap wings dengan saus keju dan mayo yang melimpah.', 25000, 'food', 'genki_lengkapwings.jpeg', NULL, NULL),
(48, 'Chicken Wings', 'Sayap ayam dengan saus keju dan mayo yang melimpah.', 25000, 'food', 'genki_chickenwings.jpeg', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `promos`
--

INSERT INTO `promos` (`id`, `name`, `percent`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Promo Mahasiswa', 10, 1, '2025-12-21 08:41:14', '2025-12-21 21:51:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('s66JOTGNCXUci81zQLZIreg04lJphYjW6MJrWTza', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUFpSGluRnFtZDB4Znc1V2Rubmd5NGFJT1dhczdjV2M1SjY4bWRYNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoibWVudS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1766914256),
('ukBAvokn6b0VsVALeD0P2ECNqDDp7fiMDbFbhA8c', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRjNKVWlsdTNRN2Z0eGxpS1lFbDk2eEtMV21WelhKNnJuQTkwQ0I5MiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcmRlci82Ny9zdGF0dXMiO3M6NToicm91dGUiO3M6MTI6Im9yZGVyLnN0YXR1cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1766918148),
('xO9YVfyzqZmjkmeEDlHeNVVutZgNTisdcg30dNcc', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFJrM1JjZEh0ZmRtYnliSTZnVTNDZndwMG9XV3dXZk91M2haaWphYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMDoibWVudS5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1767387814);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(2, 'admin', '$2y$12$pKwNiGRYzOW29bYxWEkJAeSd7Ti6ldrzPaiVczTVUi3yQ1Yf58Kc6', '2025-12-21 08:32:04', '2025-12-21 08:32:04'),
(3, 'viachan', '$2y$12$fNN80e9LoRJxQ.pa.fjP0eSsJq1GE.Jr36COwKF2sMpcKtVJfp4Wm', '2025-12-21 01:42:35', '2025-12-21 01:42:35');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_bundle_id_foreign` (`bundle_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indeks untuk tabel `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_logs_order_id_index` (`order_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_bundle_id_foreign` FOREIGN KEY (`bundle_id`) REFERENCES `bundles` (`id`),
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

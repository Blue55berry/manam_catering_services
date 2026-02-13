-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 11:24 AM
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
-- Database: `manam_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@catering.com', '$2y$12$y9x5mCue3HjCeviXzhS.vO5I6lT15s0008uCWaVI8Qf8Z5zu2yh2y', NULL, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `event_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `guest_count` int(11) NOT NULL DEFAULT 1,
  `food_preference` varchar(255) NOT NULL,
  `dish_suggestions` text DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `selected_items` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `contact_number`, `country`, `event_id`, `event_type`, `event_date`, `guest_count`, `food_preference`, `dish_suggestions`, `special_requests`, `selected_items`, `status`, `created_at`, `updated_at`) VALUES
(1, 'abi prasath', 'abiprasath6@gmail.com', '9789660115', 'India', NULL, 'Wedding', '2026-03-16', 900, 'Vegetarian', NULL, 'sample', 'Paneer, Gobi 65, Sweet Potato, Sweet Corn', 'pending', '2026-02-10 07:58:45', '2026-02-10 07:58:45'),
(2, 'abi', 'abiprasath7@gmail.com', '9789660115', 'India', NULL, 'Wedding', '2026-04-15', 700, 'Vegetarian', NULL, 'test', 'Blooming Onion, Crispy Corn, Veg Pizza, Corn Kebabs, Main Course 1, Main Course 6', 'confirmed', '2026-02-10 08:40:39', '2026-02-10 08:41:35'),
(3, 'abi', 'abiprasath8@gmail.com', '9789660115', 'India', NULL, 'Celebration', '2026-04-15', 500, 'Vegetarian', NULL, 'test', 'Paneer, Blooming Onion, Crispy Corn, Sweet Corn, Corn Kebabs', 'confirmed', '2026-02-10 08:53:56', '2026-02-10 08:54:34'),
(4, 'abi', 'abiprasath6@gmail.com', '9789660115', 'India', NULL, 'Wedding', '2026-03-16', 400, 'Vegetarian', NULL, 'test', 'Paneer, Main Course 3, Main Course 4, Main Course 6', 'confirmed', '2026-02-10 09:38:41', '2026-02-10 09:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `food_preferences` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`food_preferences`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `state`, `pincode`, `guest_count`, `notes`, `food_preferences`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Abiprasath R', 'blueberryabi04@gmail.com', '978660115', '41/65 soosaiyapuram,rayapuram tiruppur', 'tiruppur', 'tamilnadu', '641601', NULL, 'sample', NULL, 1, '2026-02-10 09:32:06', '2026-02-10 09:32:06'),
(2, 'Abiprasath', 'abiprasath6@gmail.com', '978660115', 'test', 'tiruppur', 'tamilnadu', '641601', NULL, 'test', '[{\"category_id\":\"16\",\"name\":\"Grilled Veg Cheese Burger\"}]', 1, '2026-02-10 23:41:50', '2026-02-10 23:41:50'),
(3, 'Abi', 'abiprasath23@gmail.com', '9789660115', 'test', 'tiruppur', 'tamilnadu', '641601', 600, 'test', '[{\"category_id\":\"1\",\"name\":\"Onion Uthiri Pakoda\"}]', 1, '2026-02-11 00:52:42', '2026-02-11 00:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `category`, `image`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Grand Wedding Ceremony', 'wedding', 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1200', 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Traditional South Indian Wedding', 'wedding', 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?auto=format&fit=crop&q=80&w=1200', 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Royal Wedding Reception', 'wedding', 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=1200', 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Corporate Conference', 'corporate', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=1200', 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 'Birthday Celebration', 'celebration', 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?auto=format&fit=crop&q=80&w=1200', 1, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 'Anniversary Party', 'celebration', 'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&q=80&w=1200', 1, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(7, 'Family Gathering', 'gathering', 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=1200', 1, 7, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(8, 'Marriage Decoration', 'wedding', 'https://images.unsplash.com/photo-1478146896981-b80fe463b330?auto=format&fit=crop&q=80&w=1200', 1, 8, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(9, 'Business Seminar Catering', 'corporate', 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=1200', 1, 9, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(10, 'Wedding Feast Setup', 'wedding', 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&q=80&w=1200', 1, 10, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(11, 'Festival Celebration', 'celebration', 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?auto=format&fit=crop&q=80&w=1200', 1, 11, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(12, 'Social Buffet Event', 'gathering', 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&q=80&w=1200', 1, 12, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Question 1: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Question 2: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Question 3: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Question 4: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 'Question 5: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 'Question 6: What services do you offer?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 1, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `hero_banners`
--

CREATE TABLE `hero_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `button_text_1` varchar(255) DEFAULT NULL,
  `button_link_1` varchar(255) DEFAULT NULL,
  `button_text_2` varchar(255) DEFAULT NULL,
  `button_link_2` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_banners`
--

INSERT INTO `hero_banners` (`id`, `subtitle`, `title`, `description`, `button_text_1`, `button_link_1`, `button_text_2`, `button_link_2`, `image`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(2, 'Celebrate Your Events', 'Perfect Catering for Every Occasion', 'From weddings to corporate events, we bring the finest catering experience to your special moments.', 'Book an event', '/booking', 'Know More', '/about', 'assets/images/hero/hero-slide-2.png', 1, 2, '2026-02-10 05:12:36', '2026-02-11 04:45:51'),
(3, 'Premium Service', 'Excellence in Every Bite', 'Our expert chefs ensure every dish is a masterpiece, delivering unforgettable culinary experiences.', 'Book an Event', '/booking', 'Know More', '/about', 'assets/images/hero/hero-slide-3.jpg', 1, 3, '2026-02-10 05:12:36', '2026-02-11 04:46:19'),
(5, 'A timeless tradition served on a banana leaf', 'The Grand South Indian Feast', 'From steaming rice to flavorful curries and classic sweets, enjoy a complete South Indian meal that celebrates culture, balance, and authentic taste.', 'Book an Event', '/booking', 'Know More', '/about', 'uploads/hero/1770731131_hero-slide-1.png', 1, 1, '2026-02-10 08:15:31', '2026-02-11 04:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `menu_categories`
--

CREATE TABLE `menu_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_categories`
--

INSERT INTO `menu_categories` (`id`, `name`, `slug`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Evening Snacks', 'evening-snacks', 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Soup Varieties', 'soup-varieties', 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Fresh Juice Counter', 'fresh-juice-counter', 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Sweets & Desserts', 'sweets-desserts', 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 'Idly Varieties', 'idly-varieties', 1, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 'Biriyani & Pulao', 'biriyani-pulao', 1, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(7, 'Bread Varieties', 'bread-varieties', 1, 7, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(8, 'Salads', 'salads', 1, 8, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(9, 'Pasta', 'pasta', 1, 9, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(10, 'Pizza & Burgers', 'pizza-burgers', 1, 10, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(11, 'Dosa / Roast Varieties', 'dosa-roast-varieties', 1, 11, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(12, 'Ice Cream Varieties', 'ice-cream-varieties', 1, 12, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(13, 'Variety Rice', 'variety-rice', 1, 13, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(14, 'Fresh Fruit Juice Counter', 'fresh-fruit-juice-counter', 1, 1, '2026-02-10 22:57:21', '2026-02-11 01:01:43'),
(15, 'Sweets', 'sweets', 1, 1, '2026-02-10 23:00:27', '2026-02-11 01:02:21'),
(16, 'Pizza\'s & Burgers', 'pizzas-burgers', 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(17, 'Ice Cream', 'ice-cream', 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(18, 'Bread', 'bread', 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(21, 'veg', 'veg', 1, 14, '2026-02-11 01:12:30', '2026-02-11 01:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_imported` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `category_id`, `name`, `description`, `price`, `image`, `is_active`, `is_imported`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Paneer', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 70.00, 'assets/images/main/menu/01.png', 1, 0, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 1, 'Gobi 65', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 60.00, 'assets/images/main/menu/06.png', 1, 0, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 1, 'Sweet Potato', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/02.png', 1, 0, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 1, 'Paneer Tikka', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 80.00, 'assets/images/main/menu/07.png', 1, 0, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 1, 'Sabudana Tikki', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/03.png', 1, 0, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 1, 'Blooming Onion', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/08.png', 1, 0, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(7, 1, 'Crispy Corn', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/04.png', 1, 0, 7, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(8, 1, 'Sweet Corn', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/09.png', 1, 0, 8, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(9, 1, 'Veg Pizza', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/05.png', 1, 0, 9, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(10, 1, 'Corn Kebabs', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 20.00, 'assets/images/main/menu/10.png', 1, 0, 10, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(13, 2, 'Main Course 3', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 70.00, 'assets/images/main/menu/main-course/03.png', 1, 0, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(14, 2, 'Main Course 4', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 80.00, 'assets/images/main/menu/main-course/04.png', 1, 0, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(16, 2, 'Main Course 6', 'Consectetur adipiscing elit sed dwso eiusmod tempor incididunt ut labore.', 100.00, 'assets/images/main/menu/main-course/06.png', 1, 0, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(17, 3, 'lemon', 'test', 80.00, 'uploads/menu/1770782717_images (2).jpg', 1, 0, 0, '2026-02-10 22:35:19', '2026-02-10 22:35:19'),
(18, 1, 'Mysore Bonda', 'Soft fried dumplings made with urad dal batter', 39.99, 'uploads/menu/1770783760_mysore_bonda_under_2mb.jpg', 1, 1, 0, '2026-02-10 22:48:42', '2026-02-10 22:52:41'),
(19, 1, 'Onion Bajji', 'Crispy fritters made with sliced onions and gram flour', 29.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(20, 1, 'Chilli Bajji', 'Deep-fried green chillies coated in spicy batter', 29.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(21, 1, 'Plantain Bajji', 'Raw banana slices dipped in batter and fried', 39.50, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(22, 1, 'Potato Bajji', 'Thin potato slices fried in seasoned gram flour batter', 39.50, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(23, 1, 'Mini Veg Samosa', 'Mini samosas filled with spiced vegetable stuffing', 44.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(24, 1, 'Pulipu Vadai', 'Tangy and spicy fried lentil vadai', 29.50, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(25, 1, 'Pattanam Pakoda', 'Crunchy South Indian style mixed vegetable pakoda', 49.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(26, 1, 'Onion Uthiri Pakoda', 'Crispy and crumbly onion pakoda', 39.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(27, 1, 'Javarisi Bonda', 'Fried tapioca pearl dumplings with mild spices', 34.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(28, 1, 'Salem Thattu Vadai', 'Traditional Salem-style flat fried vadai', 49.50, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(29, 1, 'Madurai Special Paniyaram', 'Soft paniyarams made with fermented batter', 49.50, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(30, 1, 'Chat Items', 'Assorted Indian chaat with tangy chutneys', 59.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(31, 1, 'Cheese Cigar Roll', 'Crispy rolls stuffed with melted cheese', 69.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(32, 1, 'Bombay Pav Bhaji', 'Mumbai-style spiced mashed vegetables served with buttered pav', 79.99, NULL, 1, 1, 0, '2026-02-10 22:48:43', '2026-02-10 22:48:43'),
(33, 2, 'Special Mulligatwany Soup', 'Classic Anglo-Indian soup with lentils, vegetables, and mild spices', 89.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(34, 2, 'French Onion Soup', 'Slow-cooked caramelized onions in rich vegetable broth', 99.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(35, 2, 'Lemon Coriander Soup', 'Light and refreshing soup with lemon and fresh coriander', 79.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(36, 2, 'Kollu Soup', 'Healthy horse gram soup with traditional spices', 84.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(37, 2, 'Mushroom Butter Soup', 'Creamy mushroom soup enriched with butter', 94.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(38, 2, 'Creamy Broccoli Soup', 'Smooth and creamy broccoli-based soup', 89.50, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(39, 2, 'Veg Manchow Soup', 'Spicy Indo-Chinese soup with vegetables and garlic', 79.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(40, 2, 'Hot & Sour Veg Soup', 'Tangy and spicy soup loaded with vegetables', 79.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(41, 2, 'Tomato Basil Soup', 'Classic tomato soup infused with fresh basil', 74.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(42, 2, 'Murungai Saaru', 'Traditional drumstick leaf South Indian soup', 69.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(43, 2, 'Spl. Mudavaatukaal Soup', 'Special rich soup prepared with traditional spices', 109.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(44, 2, 'Uduppi Spl Bonda Soup', 'Udupi-style soup served with soft bonda pieces', 89.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(45, 2, 'Vazhaithandu Soup', 'Healthy banana stem soup with mild seasoning', 79.50, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(46, 2, 'Vegetable Clear Soup', 'Light clear soup with mixed vegetables', 69.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(47, 2, 'Sweet Corn Soup', 'Creamy soup made with tender sweet corn', 79.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(48, 2, 'Mushroom Chettinad Soup', 'Spicy Chettinad-style mushroom soup', 94.99, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(49, 2, 'Carrot Ginger Soup', 'Smooth carrot soup with a hint of ginger', 74.50, NULL, 1, 1, 0, '2026-02-10 22:55:23', '2026-02-10 22:55:23'),
(50, 14, 'Lemon Mint Cooler', 'Refreshing lemon drink blended with fresh mint', 49.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(51, 14, 'Fruit Punch', 'Mixed fruit juice with a sweet and tangy taste', 59.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(52, 14, 'Badham Nannari Sarbath', 'Cooling drink made with almond milk and nannari syrup', 69.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(53, 14, 'Nellikai Sarbath', 'Amla-based healthy sarbath with a tangy flavor', 54.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(54, 14, 'Avocado Banana Milkshake', 'Creamy milkshake with avocado and banana', 89.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(55, 14, 'Spl Red Guava Milkshake', 'Thick milkshake made from fresh red guava', 79.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(56, 14, 'Elaneer Milkshake', 'Tender coconut blended with chilled milk', 84.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(57, 14, 'Watermelon Juice', 'Freshly extracted watermelon juice', 44.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(58, 14, 'Pineapple Juice', 'Sweet and tangy pineapple juice', 49.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(59, 14, 'Sweet Lime Juice', 'Refreshing mosambi juice', 49.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(60, 14, 'Muskmelon Juice', 'Cool and refreshing muskmelon juice', 44.50, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(61, 14, 'Strawberry Grape Juice', 'Blend of strawberry and grape juices', 69.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(62, 14, 'Palakkad Special Pulpy Grape Juice', 'Thick pulpy grape juice in Palakkad style', 74.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(63, 14, 'Sugarcane Juice', 'Freshly crushed sugarcane juice', 39.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(64, 14, 'Coffee / Tea Stall', 'Freshly brewed coffee or tea', 29.99, NULL, 1, 1, 0, '2026-02-10 22:57:21', '2026-02-10 22:57:21'),
(65, 15, 'Rich White Chocolate Rasagulla Sticks', 'Soft rasagulla infused with rich white chocolate', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(66, 15, 'Rabadi Rasagulla', 'Classic rasagulla soaked in thick rabadi', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(67, 15, 'Classic Rasamalai', 'Traditional rasamalai in creamy milk', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(68, 15, 'Kesar Rasamalai', 'Saffron-flavoured rich rasamalai', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(69, 15, 'Mango Angoor Rasamalai', 'Mini rasamalai balls with mango flavour', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(70, 15, 'Rose Rasamalai', 'Rose-infused rasamalai with fragrant aroma', 119.50, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(71, 15, 'Munthiri Athipalam Cake', 'Cashew and fig based traditional cake', 149.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(72, 15, 'American Dry Fruit Cake', 'Rich cake loaded with dry fruits', 159.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(73, 15, 'Chocolate Cake', 'Soft chocolate sponge with cocoa richness', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(74, 15, 'Badham Cake', 'Almond-based traditional sweet cake', 149.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(75, 15, 'Carrot Mysorepak', 'Carrot flavoured soft mysorepak', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(76, 15, 'Classic Ghee Mysorepak', 'Traditional ghee-rich mysorepak', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(77, 15, 'Pista Mysorepak', 'Pistachio flavoured mysorepak', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(78, 15, 'Kaju Watermelon', 'Cashew sweet shaped with watermelon flavour', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(79, 15, 'Apple Donut', 'Soft donut with apple flavour', 79.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(80, 15, 'Pears Donut', 'Sweet donut infused with pear essence', 79.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(81, 15, 'Dragon Fruit Scones', 'Baked scones with dragon fruit', 89.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(82, 15, 'Agra Pan', 'Classic Agra-style sweet pan', 69.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(83, 15, 'Arcot Makkan Beda', 'Deep-fried Arcot special sweet', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(84, 15, 'Rabadi Malai Roll', 'Soft roll filled with rabadi malai', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(85, 15, 'Real Mango Roll', 'Roll sweet filled with mango pulp', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(86, 15, 'Real Pineapple Roll', 'Pineapple flavoured sweet roll', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(87, 15, 'Kaju Pista Roll', 'Cashew and pista rich roll', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(88, 15, 'Malai Sandwich', 'Soft layers sandwiched with malai', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(89, 15, 'Saffron Sandwich', 'Saffron flavoured creamy sandwich sweet', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(90, 15, 'Blue Berry Sandwich', 'Blueberry infused sandwich sweet', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(91, 15, 'Kaju Kathili', 'Classic cashew fudge sweet', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(92, 15, 'Badham Kathili', 'Almond rich kathili', 149.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(93, 15, 'Panagkarupatti Kaju Kathili', 'Palm jaggery cashew kathili', 159.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(94, 15, 'Basundhi', 'Thick reduced milk dessert', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(95, 15, 'Rabadi Bread Malpua', 'Bread malpua soaked in rabadi', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(96, 15, 'Mango Ice Ball', 'Frozen mango flavoured dessert', 79.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(97, 15, 'Dry Jamun', 'Dry-style gulab jamun', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(98, 15, 'Kova Gulab Jamun', 'Gulab jamun made with milk kova', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(99, 15, 'Cashew Paneer Jamun', 'Paneer jamun stuffed with cashew', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(100, 15, 'Rose Gulkand Jamun', 'Rose flavoured jamun with gulkand', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(101, 15, 'Nagpur Jamun', 'Nagpur-style special jamun', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(102, 15, 'Mango Angoor Jamun', 'Mini mango flavoured jamuns', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(103, 15, 'Panankarkandu Gothumai Halwa', 'Palm sugar wheat halwa', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(104, 15, 'Poosani Gulkand Halwa', 'Ash gourd halwa with gulkand', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(105, 15, 'Badham Halwa', 'Rich almond halwa', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(106, 15, 'Poosani Halwa', 'Traditional ash gourd halwa', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(107, 15, 'Carrot Halwa', 'Classic carrot halwa', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(108, 15, 'Thirunelveli Halwa', 'Famous Tirunelveli wheat halwa', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(109, 15, 'Dry Fruit Halwa', 'Halwa loaded with dry fruits', 149.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(110, 15, 'Thiruvaiyaru Spl Ashoka Halwa', 'Special Ashoka halwa from Thiruvaiyaru', 159.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(111, 15, 'Paruthipal Panangkarupati Halwa', 'Cottonseed milk palm jaggery halwa', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(112, 15, 'Ghee Gothumai Halwa', 'Ghee-rich wheat halwa', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(113, 15, 'Dragon Fruit Halwa', 'Exotic dragon fruit halwa', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(114, 15, 'Mascoth Halwa', 'Traditional Muslim-style halwa', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(115, 15, 'Karupatti Gothumai Halwa', 'Palm jaggery wheat halwa', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(116, 15, 'Rabadi Panneer Jilebi', 'Paneer jalebi soaked in rabadi', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(117, 15, 'Chettinadu Aadi Kummayam', 'Chettinad festival special sweet', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(118, 15, 'Fruit Kesari', 'Kesari mixed with fruits', 79.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(119, 15, 'Moongil Arisi Akkara Vadisal', 'Bamboo rice sweet pudding', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(120, 15, 'Sappota Kesari', 'Chikoo flavoured kesari', 89.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(121, 15, 'Mothi Ladoo', 'Soft pearl sugar ladoo', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(122, 15, 'Spl Balaji Ladoo', 'Temple-style special ladoo', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(123, 15, 'Paneer Rose Ladoo', 'Paneer ladoo with rose flavour', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(124, 15, 'Dry Fruit Ladoo', 'Ladoo loaded with dry fruits', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(125, 15, 'Ghee Badham Paruppu Oppittu', 'Ghee roasted almond obbattu', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(126, 15, 'Ghee Paruppu Oppittu', 'Traditional ghee obbattu', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(127, 15, 'Coconut Oppittu', 'Coconut filled obbattu', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(128, 15, 'Mothi Pak', 'Soft sugar-based sweet', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(129, 15, 'Unniyappam', 'Kerala-style sweet fritter', 79.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(130, 15, 'Sevvazhai Malpua', 'Red banana malpua', 89.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(131, 15, 'Strawberry Pal Kolukattai', 'Milk-based strawberry kozhukattai', 99.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(132, 15, 'Varagarisi Akkara Vadisal', 'Millet rice sweet pudding', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(133, 15, 'Jack Fruit Kesari', 'Kesari made with ripe jackfruit flavour', 89.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(134, 15, 'Malai Poli', 'Soft poli filled with rich malai', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(135, 15, 'Bread Malai Sandwich', 'Bread sandwich layered with sweet malai', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(136, 15, 'Kasa Kasa Halwa', 'Poppy seed halwa with rich texture', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(137, 15, 'Athipalam Halwa', 'Fig-based traditional halwa', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(138, 15, 'Dry Fruit Kala Jamun', 'Dark jamun loaded with dry fruits', 139.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(139, 15, 'Sapota Halwa', 'Chikoo based sweet halwa', 109.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(140, 15, 'Pista Poli', 'Poli stuffed with pista filling', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(141, 15, 'Kesar Lychee Delight', 'Lychee dessert infused with saffron', 149.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(142, 15, 'Strawberry Rasamalai', 'Rasamalai flavoured with strawberry', 129.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(143, 15, 'Kuda Milagai Halwa', 'Unique chilli-infused traditional halwa', 119.99, NULL, 1, 1, 0, '2026-02-10 23:00:27', '2026-02-10 23:00:27'),
(144, 5, 'Elaneer Idly', 'Soft idly infused with tender coconut flavour', 59.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(145, 5, 'Mini Ghee Podi Idly', 'Mini idlies tossed with ghee and podi', 69.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(146, 5, 'Mini Ghee Sambar Idly', 'Mini idlies soaked in ghee-rich sambar', 69.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(147, 5, 'Mini Pepper Idly', 'Mini idlies tempered with crushed pepper', 64.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(148, 5, 'Mini Masala Idly', 'Mini idlies tossed in spicy masala', 69.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(149, 5, 'Rava Idly', 'Soft idly made with rava and spices', 49.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(150, 5, 'Puthina Idly', 'Mint flavoured aromatic idly', 54.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(151, 5, 'Veg Idly', 'Vegetable mixed steamed idly', 49.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(152, 5, 'Kanchipuram Idly', 'Traditional spiced Kanchipuram style idly', 59.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(153, 5, 'Madurai Spl Kothukari Idly', 'Madurai-style idly with special kothukari mix', 79.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(154, 5, 'Mini Mushroom Pepper Idly', 'Mini idlies tossed with mushroom and pepper', 74.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(155, 5, 'Assorted Mini Mini Idly (Beetroot, Puthina, Ragi)', 'Colourful assorted mini idlies', 79.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(156, 5, 'Mini Thattu Idly', 'Small flat thick idly', 64.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(157, 5, 'Half Moon Thattu Idly', 'Half-moon shaped thick idly', 69.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(158, 5, 'Spl Nei Podi Thattu Idly', 'Thattu idly topped with ghee and podi', 79.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(159, 5, 'Ragi Idly', 'Healthy finger millet idly', 54.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(160, 5, 'Schezwan Fried Idly', 'Crispy fried idly tossed in schezwan sauce', 69.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(161, 5, 'Curry Leaf Idly', 'Idly tempered with curry leaves and spices', 64.99, NULL, 1, 1, 0, '2026-02-10 23:02:07', '2026-02-10 23:02:07'),
(162, 8, 'Farm Fresh Green Salad', 'Fresh garden greens tossed with light dressing', 79.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(163, 8, 'Fruits & Nut Salad', 'Seasonal fruits mixed with crunchy nuts', 89.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(164, 8, 'Rainbow Macaroni Salad', 'Colorful macaroni salad with veggies and dressing', 99.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(165, 8, 'Protein Peanut Chaat', 'High-protein peanut chaat with spices', 69.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(166, 8, 'Italian Summer Pasta Salad', 'Cold pasta salad with Italian herbs', 109.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(167, 8, 'Kimchi Salad', 'Tangy Korean-style fermented vegetable salad', 99.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(168, 8, 'Fruit Chaat', 'Indian-style mixed fruit chaat', 59.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(169, 8, 'Roasted Corn Salad', 'Roasted corn tossed with spices and veggies', 69.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(170, 8, 'Fresh Sprouts Salad', 'Healthy mixed sprouts with light seasoning', 64.99, NULL, 1, 1, 0, '2026-02-10 23:05:58', '2026-02-10 23:05:58'),
(171, 9, 'Baked Penne with Roasted Vegetable Pasta', 'Baked penne pasta with roasted seasonal vegetables', 129.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(172, 9, 'Vegetable Primavera', 'Pasta tossed with fresh vegetables and light sauce', 119.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(173, 9, 'Spaghetti Napolitano', 'Classic spaghetti in tomato-based Napolitano sauce', 109.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(174, 9, 'Spinach Lasagna', 'Layered lasagna with spinach and creamy sauce', 139.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(175, 9, 'Fettucine Alfredo', 'Creamy alfredo sauce tossed with fettucine pasta', 129.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(176, 9, 'Penne Carbonara', 'Rich carbonara sauce with penne pasta', 139.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(177, 9, 'Pasta Alla Norma', 'Italian pasta with eggplant and tomato sauce', 119.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(178, 9, 'Mac & Cheese', 'Classic macaroni pasta in cheesy sauce', 109.99, NULL, 1, 1, 0, '2026-02-10 23:07:12', '2026-02-10 23:07:12'),
(179, 16, 'Mini Zucchini Crust Pizza', 'Healthy mini pizza with zucchini crust and fresh toppings', 149.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(180, 16, 'Pizza Caprese', 'Classic pizza with tomato, mozzarella, and basil', 159.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(181, 16, 'Pesto & Spinach Pizza', 'Pizza topped with pesto sauce and fresh spinach', 169.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(182, 16, 'Falafel Burger', 'Crispy falafel patty served in a soft burger bun', 129.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(183, 16, 'Grilled Veg Cheese Burger', 'Grilled vegetable patty with melted cheese', 139.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(184, 16, 'Spicy Mexican Burger', 'Burger loaded with spicy Mexican flavours', 149.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(185, 16, 'Wood Fire Bread Pizza', 'Bread-based pizza cooked in wood fire style', 119.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(186, 16, 'Cheese & Chilly Toast', 'Toasted bread topped with cheese and green chillies', 89.99, NULL, 1, 1, 0, '2026-02-10 23:11:44', '2026-02-10 23:11:44'),
(187, 11, 'Onion Rava Roast', 'Crispy rava dosa topped with onions', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(188, 11, 'Cauliflower Roast', 'Roasted dosa topped with spiced cauliflower', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(189, 11, 'Mysore Masala Roast', 'Spicy Mysore-style masala dosa', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(190, 11, 'Poondu Podi Roast', 'Garlic podi flavoured crispy roast', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(191, 11, 'Kaalan Roast', 'Mushroom roast dosa with spices', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(192, 11, 'Beetroot Roast', 'Beetroot topped dosa with mild spices', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(193, 11, 'Curry Leaf Roast', 'Aromatic curry leaf flavoured roast', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(194, 11, 'Garlic Roast', 'Crispy garlic infused dosa', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(195, 11, 'Veg Three Cheese Omelette', 'Vegetable omelette loaded with three cheeses', 109.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(196, 11, 'Andhra Spl Pesarattu', 'Green gram dosa Andhra style', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(197, 11, 'Chinna Vengaya Uthappam', 'Small onion uthappam', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(198, 11, 'Podi Uthappam', 'Uthappam topped with spicy podi', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(199, 11, 'Mixed Veg Uthappam', 'Uthappam with mixed vegetables', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(200, 11, 'Madurai Spl Veg Keema Dosa', 'Madurai-style vegetable keema dosa', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(201, 11, 'Chettinadu Kaara Dosa', 'Spicy Chettinad flavoured dosa', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(202, 11, 'Cheese Capsicum Dosa', 'Dosa stuffed with cheese and capsicum', 104.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(203, 11, 'Set Dosa', 'Soft and fluffy set dosa', 69.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(204, 11, 'Millet Variety Dosa', 'Healthy dosa made with mixed millets', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(205, 11, 'Paneer Bhurji Dosa', 'Dosa filled with spiced paneer bhurji', 109.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(206, 11, 'Japanese Noodle Dosa', 'Fusion dosa with noodles filling', 119.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(207, 11, 'Udupi Neer Dosa', 'Thin soft rice dosa Udupi style', 74.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(208, 11, 'Mulbagal Dosa Karnataka Spl', 'Famous Mulbagal soft dosa', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(209, 11, 'Spl Butter Masala Dosa', 'Masala dosa topped with butter', 109.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(210, 11, 'Ragi Rava Dosa', 'Healthy ragi rava crispy dosa', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(211, 11, 'Kambu Cauliflower Masala Dosa', 'Pearl millet dosa with cauliflower masala', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(212, 11, 'Butter Gothumai Dosa', 'Wheat dosa enriched with butter', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(213, 11, '3 Paruppu Adai + Thool Vellam', 'Three lentil adai served with powdered jaggery', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(214, 11, 'Mundiri Pineapple Dosa + Thool Vellam', 'Cashew pineapple dosa with powdered jaggery', 104.99, NULL, 1, 1, 0, '2026-02-10 23:15:08', '2026-02-10 23:15:08'),
(215, 17, 'Vanilla Ice Cream', 'Classic vanilla flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(216, 17, 'Strawberry Ice Cream', 'Creamy strawberry flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(217, 17, 'Chocolate Ice Cream', 'Rich chocolate flavoured ice cream', 64.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(218, 17, 'Pineapple Ice Cream', 'Refreshing pineapple flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(219, 17, 'Mango Ice Cream', 'Seasonal mango flavoured ice cream', 64.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(220, 17, 'Honey Nuts Ice Cream', 'Ice cream mixed with honey and crunchy nuts', 74.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(221, 17, 'Spanish Delight Ice Cream', 'Spanish style rich creamy ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(222, 17, 'Almond Carnival Ice Cream', 'Almond-loaded creamy ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(223, 17, 'Spl Sandwich Ice Cream', 'Ice cream sandwiched between biscuits', 69.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(224, 17, 'Jack Fruit Ice Cream', 'Jackfruit flavoured traditional ice cream', 74.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(225, 17, 'Cookies & Cream Ice Cream', 'Vanilla ice cream with cookie chunks', 74.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(226, 17, 'Pan Beeda Ice Cream', 'Betel leaf flavoured fusion ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(227, 17, 'Panchamiratham Ice Cream', 'Temple-style panchamiratham flavoured ice cream', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(228, 17, 'Gulkandh Ice Cream', 'Rose gulkand infused ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(229, 17, 'Cassata Ice Cream', 'Layered cassata style ice cream', 69.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(230, 17, 'Sliced Abukatta Ice Cream', 'Avocado flavoured creamy ice cream', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(231, 17, 'Swiss Cake Ice Cream', 'Ice cream with swiss cake pieces', 79.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(232, 17, 'Fruit Delight Ice Cream', 'Mixed fruit flavoured ice cream', 69.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(233, 17, 'Tajmahal Ice Cream', 'Premium special Tajmahal ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(234, 17, 'Dry Fruit Special Ice Cream', 'Loaded with assorted dry fruits', 84.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(235, 17, 'Golden Perk Ice Cream', 'Crunchy perk mixed ice cream', 74.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(236, 17, 'Rasamalai Ice Cream', 'Fusion rasamalai flavoured ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(237, 17, 'Spl Lychica Polar Bear Ice Cream', 'Lychee flavoured Polar Bear special', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(238, 17, 'Real Chickoo Polar Bear Ice Cream', 'Chikoo flavoured Polar Bear ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(239, 17, 'Purple Punch Polar Bear Ice Cream', 'Grape-based Polar Bear ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(240, 17, 'Coffee Brazillia Polar Bear', 'Brazilian coffee flavoured ice cream', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(241, 17, 'Belgian Chocolate Polar Bear', 'Rich Belgian chocolate ice cream', 109.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(242, 17, 'Red Velvet Polar Bear Ice Cream', 'Red velvet cake flavoured ice cream', 104.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(243, 17, 'Spl Lotus Biscoff', 'Lotus Biscoff infused ice cream', 109.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(244, 17, 'Spl Bubble Tea Ice Cream', 'Bubble tea flavoured ice cream', 119.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(245, 17, 'Spl Death By Chocolate Polar Bear', 'Extra rich chocolate overloaded ice cream', 119.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(246, 17, 'Custard Apple Polar Bear Ice Cream', 'Custard apple flavoured ice cream', 99.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(247, 17, 'Jaggery Fruit Polar Bear Ice Cream', 'Palm jaggery fruit based ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(248, 17, 'Matka Kulfi Stick Ice Cream', 'Traditional matka kulfi stick', 69.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(249, 17, 'Roll Ice Cream', 'Freshly rolled ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(250, 17, 'Chocolate Fountain', 'Flowing chocolate fountain dessert', 149.99, NULL, 1, 1, 0, '2026-02-10 23:15:19', '2026-02-10 23:15:19'),
(251, 13, 'Kunguma Poo Kalkandu Saadham', 'Fragrant rice cooked with saffron flower and sugar candy', 89.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(252, 13, 'Maangai Saadham', 'Tangy raw mango flavoured rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(253, 13, 'Thengai Saadham', 'Coconut rice with tempered spices', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(254, 13, 'Puli Saadham', 'Traditional tamarind rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(255, 13, 'Elumitchai Saadham', 'Refreshing lemon rice', 74.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(256, 13, 'Vetrilai Vellai Poondu Saadham', 'Betel leaf and garlic flavoured rice', 84.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(257, 13, 'Pudhina Saadham', 'Mint flavoured aromatic rice', 74.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(258, 13, 'Malli Saadham', 'Coriander flavoured rice', 74.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(259, 13, 'Beetroot Saadham', 'Beetroot mixed rice with mild spices', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(260, 13, 'Carrot Saadham', 'Carrot flavoured seasoned rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(261, 13, 'Kuru Milagu Nei Saadham', 'Pepper and ghee flavoured rice', 89.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(262, 13, 'Vatha Kuzhambu Saadham', 'Rice served with spicy vatha kuzhambu', 89.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(263, 13, 'Sambar Saadham', 'Rice mixed with traditional sambar', 89.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(264, 13, 'Thakkali Saadham', 'Tomato flavoured rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(265, 13, 'Karuvepillai Saadham', 'Curry leaf infused rice', 74.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(266, 13, 'Thair Saadham', 'Cooling curd rice', 69.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(267, 13, 'Thengai Pal Saadham', 'Rice cooked in coconut milk', 84.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(268, 13, 'Poondu Saadham', 'Garlic flavoured rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(269, 13, 'Nellikai Saadham', 'Amla flavoured healthy rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(270, 13, 'Katharikkai Saadham', 'Brinjal flavoured rice', 79.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(271, 13, 'Kadhamba Saadham', 'Mixed vegetable traditional rice', 89.99, NULL, 1, 1, 0, '2026-02-10 23:18:45', '2026-02-10 23:18:45'),
(272, 18, 'Stone Phulka', 'Soft stone-cooked phulka', 24.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(273, 18, 'Ghee Phulka', 'Phulka brushed with pure ghee', 29.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(274, 18, 'Multigrain Phulka', 'Healthy multigrain wheat phulka', 34.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(275, 18, 'Romali Roti', 'Thin handkerchief-style roti', 39.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(276, 18, 'Wheat Romali Roti', 'Whole wheat romali roti', 44.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(277, 18, 'Arabic Kuboos', 'Soft Middle Eastern flat bread', 39.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(278, 18, 'Plain Roti', 'Classic whole wheat roti', 24.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(279, 18, 'Butter Roti', 'Roti topped with butter', 29.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(280, 18, 'Spl. Bajra Roti', 'Special pearl millet roti', 39.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(281, 18, 'Tandoori Roti', 'Clay-oven baked roti', 34.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(282, 18, 'Aloo Chappathi', 'Chapathi stuffed with spiced potato', 44.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(283, 18, 'Paneer Chappathi', 'Chapathi filled with paneer stuffing', 54.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(284, 18, 'Methi Chappathi', 'Chapathi flavoured with methi leaves', 39.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(285, 18, 'Paneer Chilly Chappathi', 'Spicy paneer chilli stuffed chapathi', 59.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(286, 18, 'Masala Aloo Kulcha', 'Kulcha stuffed with aloo masala', 59.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(287, 18, 'Paneer Methi Kulcha', 'Kulcha filled with paneer and methi', 64.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(288, 18, 'Afghani Naan', 'Soft Afghani-style naan', 69.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(289, 18, 'Plain Naan', 'Traditional tandoor baked naan', 49.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(290, 18, 'Butter Naan', 'Naan topped with butter', 54.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(291, 18, 'Garlic Naan', 'Naan flavoured with garlic', 59.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(292, 18, 'Cheese Naan', 'Naan stuffed with cheese', 69.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(293, 18, 'Elai Parotta', 'Banana leaf wrapped parotta', 44.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(294, 18, 'Malabar Parotta', 'Kerala-style layered parotta', 39.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(295, 18, 'Cheese Parotta', 'Parotta filled with cheese', 59.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(296, 18, 'Nool Parotta', 'Thread-style layered parotta', 49.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(297, 18, 'Coin Parotta', 'Small round parotta pieces', 54.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(298, 18, 'Bun Parotta', 'Soft bun-style parotta', 49.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(299, 18, 'Paneer Veg Kothu Parotta', 'Chopped parotta tossed with paneer and veggies', 89.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(300, 18, 'Chilly Parotta', 'Spicy chilli parotta', 69.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(301, 18, 'Wheat Chilli Parotta', 'Whole wheat spicy parotta', 74.99, NULL, 1, 1, 0, '2026-02-10 23:23:18', '2026-02-10 23:23:18'),
(302, 17, 'Vanilla Ice Cream', 'Classic vanilla flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(303, 17, 'Strawberry Ice Cream', 'Creamy strawberry flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(304, 17, 'Chocolate Ice Cream', 'Rich chocolate flavoured ice cream', 64.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(305, 17, 'Pineapple Ice Cream', 'Refreshing pineapple flavoured ice cream', 59.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(306, 17, 'Mango Ice Cream', 'Seasonal mango flavoured ice cream', 64.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(307, 17, 'Honey Nuts Ice Cream', 'Ice cream mixed with honey and crunchy nuts', 74.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(308, 17, 'Spanish Delight Ice Cream', 'Spanish style rich creamy ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(309, 17, 'Almond Carnival Ice Cream', 'Almond-loaded creamy ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(310, 17, 'Spl Sandwich Ice Cream', 'Ice cream sandwiched between biscuits', 69.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(311, 17, 'Jack Fruit Ice Cream', 'Jackfruit flavoured traditional ice cream', 74.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(312, 17, 'Cookies & Cream Ice Cream', 'Vanilla ice cream with cookie chunks', 74.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(313, 17, 'Pan Beeda Ice Cream', 'Betel leaf flavoured fusion ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(314, 17, 'Panchamiratham Ice Cream', 'Temple-style panchamiratham flavoured ice cream', 84.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(315, 17, 'Gulkandh Ice Cream', 'Rose gulkand infused ice cream', 79.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(316, 17, 'Cassata Ice Cream', 'Layered cassata style ice cream', 69.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(317, 17, 'Sliced Abukatta Ice Cream', 'Avocado flavoured creamy ice cream', 84.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(318, 17, 'Swiss Cake Ice Cream', 'Ice cream with swiss cake pieces', 79.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(319, 17, 'Fruit Delight Ice Cream', 'Mixed fruit flavoured ice cream', 69.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(320, 17, 'Tajmahal Ice Cream', 'Premium special Tajmahal ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(321, 17, 'Dry Fruit Special Ice Cream', 'Loaded with assorted dry fruits', 84.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(322, 17, 'Golden Perk Ice Cream', 'Crunchy perk mixed ice cream', 74.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(323, 17, 'Rasamalai Ice Cream', 'Fusion rasamalai flavoured ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(324, 17, 'Spl Lychica Polar Bear Ice Cream', 'Lychee flavoured Polar Bear special', 99.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(325, 17, 'Real Chickoo Polar Bear Ice Cream', 'Chikoo flavoured Polar Bear ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(326, 17, 'Purple Punch Polar Bear Ice Cream', 'Grape-based Polar Bear ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(327, 17, 'Coffee Brazillia Polar Bear', 'Brazilian coffee flavoured ice cream', 99.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(328, 17, 'Belgian Chocolate Polar Bear', 'Rich Belgian chocolate ice cream', 109.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(329, 17, 'Red Velvet Polar Bear Ice Cream', 'Red velvet cake flavoured ice cream', 104.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(330, 17, 'Spl Lotus Biscoff', 'Lotus Biscoff infused ice cream', 109.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(331, 17, 'Spl Bubble Tea Ice Cream', 'Bubble tea flavoured ice cream', 119.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(332, 17, 'Spl Death By Chocolate Polar Bear', 'Extra rich chocolate overloaded ice cream', 119.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(333, 17, 'Custard Apple Polar Bear Ice Cream', 'Custard apple flavoured ice cream', 99.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(334, 17, 'Jaggery Fruit Polar Bear Ice Cream', 'Palm jaggery fruit based ice cream', 94.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(335, 17, 'Matka Kulfi Stick Ice Cream', 'Traditional matka kulfi stick', 69.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(336, 17, 'Roll Ice Cream', 'Freshly rolled ice cream', 89.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21'),
(337, 17, 'Chocolate Fountain', 'Flowing chocolate fountain dessert', 149.99, NULL, 1, 1, 0, '2026-02-10 23:25:21', '2026-02-10 23:25:21');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_22_000001_create_admins_table', 1),
(6, '2026_01_22_000002_create_site_settings_table', 1),
(7, '2026_01_22_000003_create_hero_banners_table', 1),
(8, '2026_01_22_000004_create_services_table', 1),
(9, '2026_01_22_000005_create_popular_dishes_table', 1),
(10, '2026_01_22_000006_create_menu_categories_table', 1),
(11, '2026_01_22_000007_create_menu_items_table', 1),
(12, '2026_01_22_000008_create_stats_table', 1),
(13, '2026_01_22_000009_create_events_table', 1),
(14, '2026_01_22_000010_create_team_members_table', 1),
(15, '2026_01_22_000011_create_testimonials_table', 1),
(16, '2026_01_22_000012_create_faqs_table', 1),
(17, '2026_01_22_000013_create_bookings_table', 1),
(18, '2026_01_22_000014_create_contacts_table', 1),
(19, '2026_01_22_072543_add_is_imported_to_menu_items_table', 1),
(20, '2026_01_28_043611_create_orders_table', 1),
(21, '2026_01_28_043612_create_order_items_table', 1),
(22, '2026_01_28_051024_add_event_fields_to_orders_table', 1),
(23, '2026_01_28_051036_add_event_fields_to_orders_table', 1),
(24, '2026_01_31_171036_add_new_fields_to_bookings_table', 1),
(25, '2026_01_31_171827_add_food_preferences_to_bookings_table', 1),
(26, '2026_02_03_130534_add_selected_items_to_bookings_table', 1),
(27, '2026_02_09_045959_create_blogs_table', 1),
(28, '2026_02_09_050528_create_quotations_table', 1),
(29, '2026_02_09_053346_add_share_token_to_quotations_table', 1),
(30, '2026_02_10_075037_remove_non_veg_items', 1),
(31, '2026_02_10_135943_add_booking_id_to_quotations_table', 2),
(32, '2026_02_10_144721_create_customers_table', 3),
(33, '2026_02_11_050721_add_food_preferences_to_customers_table', 4),
(34, '2026_02_11_052352_add_details_to_customers_and_quotations', 5),
(35, '2026_02_11_055407_add_customer_id_column_to_quotations_table', 6),
(36, '2026_02_11_062200_add_guest_count_to_customers_v2', 7);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `event_type` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `food_requirements` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `menu_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popular_dishes`
--

CREATE TABLE `popular_dishes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popular_dishes`
--

INSERT INTO `popular_dishes` (`id`, `name`, `price`, `image`, `rating`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Delicious Item 1', 60.00, 'assets/images/main/dish/01.jpg', 3.5, 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Delicious Item 2', 70.00, 'assets/images/main/dish/02.jpg', 3.5, 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Delicious Item 3', 80.00, 'assets/images/main/dish/03.jpg', 3.5, 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Delicious Item 4', 90.00, 'assets/images/main/dish/04.jpg', 3.5, 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 'Delicious Item 5', 100.00, 'assets/images/main/dish/05.jpg', 3.5, 1, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 'Delicious Item 6', 110.00, 'assets/images/main/dish/06.jpg', 3.5, 1, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quotation_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` enum('draft','sent','accepted','rejected') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `booking_id`, `quotation_number`, `customer_name`, `customer_email`, `customer_phone`, `event_type`, `event_date`, `guest_count`, `items`, `subtotal`, `tax`, `discount`, `total`, `notes`, `status`, `created_at`, `updated_at`, `customer_id`) VALUES
(10, 4, 'QT-20260211-0001', 'abi', 'abiprasath6@gmail.com', '9789660115', 'Wedding', '2026-03-16', 400, '[{\"name\":\"Paneer\",\"quantity\":400,\"price\":70},{\"name\":\"Main Course 3\",\"quantity\":400,\"price\":70},{\"name\":\"Main Course 4\",\"quantity\":400,\"price\":80},{\"name\":\"Main Course 6\",\"quantity\":400,\"price\":100}]', 128000.00, 23040.00, 0.00, 151040.00, 'test', 'draft', '2026-02-11 04:18:33', '2026-02-11 04:18:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `icon`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Wedding Services', 'Make your wedding day perfect with our exceptional catering services and elegant presentation.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/wedding.svg', 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Corporate Catering', 'Professional catering solutions for your corporate events and business meetings.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/corporate.svg', 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Cocktail Reception', 'Elegant cocktail receptions with a variety of appetizers and beverages.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/cocktail.svg', 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Bento Catering', 'Individually portioned bento boxes perfect for any occasion and dietary preference.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/bento.svg', 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(5, 'Buffet Catering', 'All-you-can-eat buffet style catering with diverse menu options for large gatherings.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/buffet.svg', 1, 5, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(6, 'Sit-Down Catering', 'Formal sit-down dining experience with plated meals and professional table service.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/sit-down.svg', 1, 6, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(7, 'Home Delivery', 'Convenient home delivery service bringing quality catered meals to your doorstep.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/home.svg', 1, 7, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(8, 'Pub Party', 'Casual pub-style catering perfect for relaxed gatherings and social events.', 'https://kamleshyadav.com/html/catering/html/assets/images/main/service/pub.svg', 1, 8, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'Catering Service',
  `site_description` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `google_map_embed` text DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_description`, `phone`, `email`, `address`, `facebook_url`, `twitter_url`, `instagram_url`, `youtube_url`, `google_map_embed`, `footer_text`, `created_at`, `updated_at`) VALUES
(1, 'Manam Catering Service', 'Find out professional caterers in your city for your Dream Events.', '+91 9292 8484 000', 'info@manamcatering.com', 'Victoria Island Lagos Nigeria', '#', '#', '#', '#', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7929.383324299389!2d3.426551!3d6.433638!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf52931db51f1%3A0xebccb6fc0bd61e40!2s19%20Engineering%20Close%2C%20Victoria%20Island%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sin!4v1623326034824!5m2!1sen!2sin', '© 2026 Manam Catering Service. All Rights Reserved.', '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `title`, `value`, `icon`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Happy Customers', 786, 'https://kamleshyadav.com/html/catering/html/assets/images/main/c1.svg', 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Expert Chefs', 109, 'https://kamleshyadav.com/html/catering/html/assets/images/main/c2.svg', 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Years Of Experience', 23, 'https://kamleshyadav.com/html/catering/html/assets/images/main/c3.svg', 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Events Completed', 235, 'https://kamleshyadav.com/html/catering/html/assets/images/main/c4.svg', 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `image`, `facebook_url`, `twitter_url`, `instagram_url`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Jenny Disusa', 'Decoration Chef', 'assets/images/main/team/01.jpg', '#', '#', '#', 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Robart Parker', 'Executive Chef', 'assets/images/main/team/02.jpg', '#', '#', '#', 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Cathenna Sudh', 'Kitchen Porter', 'assets/images/main/team/03.jpg', '#', '#', '#', 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Apolline Deo', 'Head Chef', 'assets/images/main/team/04.jpg', '#', '#', '#', 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` decimal(2,1) NOT NULL DEFAULT 5.0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `image`, `message`, `rating`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(1, 'John Brown', 'BPO Manager', 'assets/images/main/team/01.jpg', 'The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary.', 3.5, 1, 1, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(2, 'Robart Parker', 'Executive Chef', 'assets/images/main/team/02.jpg', 'The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary.', 5.0, 1, 2, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(3, 'Apolline Deo', 'Kitchen Porter', 'assets/images/main/team/03.jpg', 'The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary.', 3.5, 1, 3, '2026-02-10 05:12:36', '2026-02-10 05:12:36'),
(4, 'Cathenna Sudh', 'Head Chef', 'assets/images/main/team/04.jpg', 'The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary.', 4.5, 1, 4, '2026-02-10 05:12:36', '2026-02-10 05:12:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_event_id_foreign` (`event_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_banners`
--
ALTER TABLE `hero_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_categories`
--
ALTER TABLE `menu_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_categories_slug_unique` (`slug`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_category_id_foreign` (`category_id`);

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
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_menu_item_id_foreign` (`menu_item_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `popular_dishes`
--
ALTER TABLE `popular_dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotations_quotation_number_unique` (`quotation_number`),
  ADD KEY `quotations_booking_id_foreign` (`booking_id`),
  ADD KEY `quotations_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hero_banners`
--
ALTER TABLE `hero_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_categories`
--
ALTER TABLE `menu_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `popular_dishes`
--
ALTER TABLE `popular_dishes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `menu_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quotations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

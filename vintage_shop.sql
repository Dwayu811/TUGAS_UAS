-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2026 at 11:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vintage_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Clothing'),
(2, 'Aksesories'),
(3, 'Collection ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `buyer_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Proses','Kirim','Selesai') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `new_price` decimal(10,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `kondisi` varchar(50) DEFAULT NULL,
  `status` enum('Active','Sold Out','Archived') DEFAULT 'Active',
  `is_promo` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `price`, `new_price`, `discount_percent`, `image`, `description`, `kondisi`, `status`, `is_promo`, `created_at`) VALUES
(1, 1, 1, 'yuhbj', 1000000.00, 1000000.00, 40, '1768271103_main_6965acff8a1a1.jpeg', 'wdfsqwerq', 'Mint (Like New)', 'Active', 1, '2026-01-13 02:25:03'),
(2, 1, 1, 'sdkv', 100000.00, 100000.00, 0, '1768290276_main_6965f7e44a213.jpeg', 'fsvs', 'Mint (Like New)', 'Active', 0, '2026-01-13 07:44:36'),
(3, 2, 3, 'Kaset Music Oasis', 100000.00, 100000.00, 0, '1768401795_main_6967ab8334609.jpg', 'Kaset Vintage ', 'Good (Vintage Condition)', 'Active', 0, '2026-01-14 14:43:15'),
(4, 3, 3, 'asdasdsad', 13123.00, 13123.00, 0, '1768418035_main_6967eaf3c067c.jpg', 'asd,', 'Excellent (Used)', 'Active', 0, '2026-01-14 19:13:55'),
(5, 4, 3, 'Dumbell 3KG', 200000.00, 200000.00, 0, '1768418337_main_6967ec21e3774.jpeg', 'Minus no box', 'Mint (Like New)', 'Active', 0, '2026-01-14 19:18:57');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_name`) VALUES
(1, 1, '1768271103_detail_0_6965acff8a954.jpeg'),
(2, 1, '1768271103_detail_1_6965acff8afee.jpeg'),
(3, 1, '1768271103_detail_2_6965acff8b56c.jpeg'),
(4, 1, '1768271103_detail_3_6965acff8bf40.jpeg'),
(5, 2, '1768290276_detail_0_6965f7e44df3f.jpeg'),
(6, 2, '1768290276_detail_1_6965f7e44e73a.jpeg'),
(7, 2, '1768290276_detail_2_6965f7e44fa0a.jpeg'),
(8, 4, '1768418035_detail_0_6967eaf3c0ddd.jpg'),
(9, 4, '1768418035_detail_1_6967eaf3c1958.jpg'),
(10, 4, '1768418035_detail_2_6967eaf3c249b.jpg'),
(11, 4, '1768418035_detail_3_6967eaf3c2f2f.jpg'),
(12, 5, '1768418337_detail_0_6967ec21e440f.jpeg'),
(13, 5, '1768418337_detail_1_6967ec21e4de1.jpeg'),
(14, 5, '1768418337_detail_2_6967ec21e62ea.jpeg'),
(15, 5, '1768418337_detail_3_6967ec21e7924.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `user_id`, `name`, `created_at`) VALUES
(1, 1, 'kidna1530', '2026-01-13 02:24:38'),
(2, 6, 'dickasc', '2026-01-14 14:31:49'),
(3, 8, 'Boi', '2026-01-14 19:11:44'),
(4, 9, 'Krisna', '2026-01-14 19:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'kidna1530', 'kidna15105@gmail.com', '$2y$10$RIIJxazs5HitpAzzMZOGEOErqC7iH6qFf8s9pdXSVwEm60Z4pfsj6', '2026-01-11 06:51:22'),
(4, 'piwpiw', 'lonelysugar13@gmail.com', '$2y$10$vC96QlJGhMRQvL26TLGle.YSt1rLe93OJPTiPkqIOXH3/Til0uJTK', '2026-01-12 05:41:10'),
(5, 'tes', 'tes@gmail.com', '$2y$10$vgFMeasNaeVON9kHlGJ3F..NA4ZtiPnjeyeEjaBOv5lXG/MP4/1ze', '2026-01-12 06:03:35'),
(6, 'dickasc', 'gdandika2023@gmail.com', '$2y$10$/AzsetuyH0CFh7sYYyL0iO4GCnM4sB/RlOWZ.zE5aN2EdVr17sdSK', '2026-01-12 09:45:43'),
(7, 'blek', 'andikasaputrakm@gmail.com', '$2y$10$4ErmGvNZdUsFVUUKttk66.UmX7kn7jnOX/BPwOuSiwnNy3G1QPKh2', '2026-01-12 09:56:07'),
(8, 'Boi', 'Boi@gmail.com', '$2y$10$Lf6Iet385WbkJc5T4ZN4TekfbdKSV4b5fWap.LRJ8h3YUGmNZgK36', '2026-01-14 19:08:29'),
(9, 'Krisna', 'Krisna@gmail.com', '$2y$10$KvOwGnIUb1bcfqkTtl.vWONxIGlWKW5rvqEoKwnab7lgNaDxdSTUy', '2026-01-14 19:17:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 07:03 AM
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
-- Database: `nguoi_dung`
--

-- --------------------------------------------------------

--
-- Table structure for table `san_phams`
--

CREATE TABLE `san_phams` (
  `id` int(11) NOT NULL,
  `danh_muc_id` int(11) NOT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `gia_ban` decimal(15,2) NOT NULL,
  `gia_nhap` decimal(15,2) NOT NULL,
  `gia_khuyen_mai` decimal(15,2) DEFAULT NULL,
  `so_luong` int(11) NOT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `trang_thai` enum('active','inactive') DEFAULT 'active',
  `ngay_nhap` date DEFAULT NULL,
  `luot_xem` int(11) DEFAULT 0,
  `mo_ta_chi_tiet` text DEFAULT NULL,
  `img_array` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `san_phams`
--

INSERT INTO `san_phams` (`id`, `danh_muc_id`, `ten_san_pham`, `mo_ta`, `gia_ban`, `gia_nhap`, `gia_khuyen_mai`, `so_luong`, `hinh_anh`, `trang_thai`, `ngay_nhap`, `luot_xem`, `mo_ta_chi_tiet`, `img_array`) VALUES
(1, 0, 'Sản phẩm Mẫu', 'Mô tả sản phẩm mẫu', 100000.00, 50000.00, 90000.00, 20, 'Screenshot 2024-11-05 165050.png', 'active', NULL, NULL, NULL, NULL),
(11, 1, '1xyz', '1', 1.00, 1.00, 1.00, 1, '1.png', 'active', NULL, NULL, NULL, NULL),
(12, 1, '12312', '', 2.00, 0.00, 0.00, 2, 'abc.png', '', '2024-11-13', 0, '', NULL),
(13, 2, 'ĐẠI ', '', 123123.00, 0.00, 0.00, 233, 'abc.png', 'active', '2024-11-13', 0, '', NULL),
(14, 1, 'dai', 'dai', 22.00, 2.00, 2.00, 2, '1.png', 'inactive', '2024-11-13', 0, NULL, '[]'),
(15, 1, 'dai', 'dai', 100.00, 1000.00, 10.00, 10, '1.png', 'active', '2024-11-13', 0, NULL, '[]'),
(16, 1, 'dai', 'dai', 10.00, 10.00, 10.00, 10, 'abc.png', 'active', '2024-11-13', 0, NULL, NULL),
(17, 1, 'lz', 'lz', 1.00, 1.00, 1.00, 1, '1.png', 'active', '2025-11-11', 0, NULL, NULL),
(18, 1, 'lzzzzzz', 'lzzzzzz', 100.00, 1000.00, 100.00, 10, '1.png', 'active', '2024-11-13', 0, NULL, NULL),
(19, 1, 'dai', 'dai', 100.00, 100.00, 10.00, 10, '1.png', 'inactive', '2024-11-13', 0, NULL, NULL),
(20, 1, 'ngu', 'ngu', 10.00, 10.00, 10.00, 10, '1.png', 'active', '2024-11-13', 0, NULL, NULL),
(21, 1, 'dai123', 'dai123', 10.00, 10.00, 10.00, 10, '1.png', 'active', '2024-11-13', 0, NULL, NULL),
(22, 1, 'dai1234', '1234', 19.00, 19.00, 19.00, 19, '', 'inactive', '2024-11-13', 0, NULL, NULL),
(23, 1, 'dai1234', '1234', 19.00, 19.00, 19.00, 19, '', 'active', '2024-11-14', 0, '', NULL),
(24, 1, 'test', 'test', 99.00, 9.00, 9.00, 9, '2.png', 'active', '2024-11-14', 0, '', NULL),
(25, 1, '113zyz', '113zyz', 10.00, 10.00, 10.00, 10, '', 'inactive', '2024-11-14', 0, '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `san_phams`
--
ALTER TABLE `san_phams`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `san_phams`
--
ALTER TABLE `san_phams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

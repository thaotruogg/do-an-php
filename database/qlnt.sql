-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2020 at 06:59 AM
-- Server version: 8.0.20
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlnt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cthddinhvu`
--

CREATE TABLE `cthddinhvu` (
  `Id` int NOT NULL,
  `IdHoaDonDichVu` int NOT NULL,
  `IdDichVu` int NOT NULL,
  `TongTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dichvu`
--

CREATE TABLE `dichvu` (
  `Id` int NOT NULL,
  `TenDichVu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dichvu`
--

INSERT INTO `dichvu` (`Id`, `TenDichVu`, `SoTien`) VALUES
(1, 'Điện', '3000'),
(2, 'Nước', '14000'),
(4, 'Internet', '110000');

-- --------------------------------------------------------

--
-- Table structure for table `hoadondichvu`
--

CREATE TABLE `hoadondichvu` (
  `Id` int NOT NULL,
  `IdPhong` int NOT NULL,
  `IdNguoiThue` int NOT NULL,
  `ThoiGian` datetime NOT NULL,
  `TienDien` decimal(10,0) NOT NULL,
  `TienNuoc` decimal(10,0) NOT NULL,
  `TienInternet` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hoadonthang`
--

CREATE TABLE `hoadonthang` (
  `Id` int NOT NULL,
  `IdPhong` int NOT NULL,
  `IdNguoiThue` int NOT NULL,
  `IdHdDichVu` int NOT NULL,
  `ThoiGian` datetime NOT NULL,
  `TongTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hopdong`
--

CREATE TABLE `hopdong` (
  `Id` int NOT NULL,
  `IdNguoiThue` int NOT NULL,
  `TenNguoiThue` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdPhong` int NOT NULL,
  `TenPhong` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoTienCoc` bigint NOT NULL,
  `NgayBatDau` date NOT NULL,
  `NgayKetThuc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hopdong`
--

INSERT INTO `hopdong` (`Id`, `IdNguoiThue`, `TenNguoiThue`, `IdPhong`, `TenPhong`, `SoTienCoc`, `NgayBatDau`, `NgayKetThuc`) VALUES
(7, 13, 'Trương Minh Thảo', 2, '201', 2000000, '2020-06-26', '2020-08-26');

-- --------------------------------------------------------

--
-- Table structure for table `nguoithue`
--

CREATE TABLE `nguoithue` (
  `Id` int NOT NULL,
  `TenNguoiThue` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDTNguoiThue` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `QueQuan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `CMND` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoithue`
--

INSERT INTO `nguoithue` (`Id`, `TenNguoiThue`, `SDTNguoiThue`, `QueQuan`, `CMND`) VALUES
(13, 'Trương Minh Thảo', '0387342288', 'Long An', '231023441');

-- --------------------------------------------------------

--
-- Table structure for table `phong`
--

CREATE TABLE `phong` (
  `Id` int NOT NULL,
  `TenPhong` varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdTang` int NOT NULL,
  `TenTang` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoDien` int NOT NULL,
  `SoNuoc` int NOT NULL,
  `SoTienThue` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phong`
--

INSERT INTO `phong` (`Id`, `TenPhong`, `IdTang`, `TenTang`, `SoDien`, `SoNuoc`, `SoTienThue`) VALUES
(1, '101', 1, 'Tầng 1', 100, 100, '2000000'),
(2, '201', 2, 'Tầng 2', 100, 200, '2000000'),
(3, '102', 1, 'Tầng 1', 444, 43, '2000000'),
(4, '202', 2, 'Tầng 2', 100, 100, '2000000'),
(5, '103', 1, 'Tầng 1', 400, 43, '3000000'),
(6, '104', 1, 'Tầng 1', 140, 5, '3400000');

-- --------------------------------------------------------

--
-- Table structure for table `tang`
--

CREATE TABLE `tang` (
  `Id` int NOT NULL,
  `TenTang` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tang`
--

INSERT INTO `tang` (`Id`, `TenTang`) VALUES
(1, 'Tầng 1'),
(2, 'Tầng 2'),
(3, 'Tầng 3'),
(4, 'Tầng 4');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `full_name`) VALUES
(3, 'admin', '0659c7992e268962384eb17fafe88364', 'Admin'),
(4, 'admin2', '0659c7992e268962384eb17fafe88364', 'Admin2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_cthd_dv` (`IdHoaDonDichVu`),
  ADD KEY `fk_cthd_dv1` (`IdDichVu`);

--
-- Indexes for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hddv_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hddv_phong` (`IdPhong`);

--
-- Indexes for table `hoadonthang`
--
ALTER TABLE `hoadonthang`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hoadonthang_hoadondichvu` (`IdHdDichVu`),
  ADD KEY `fk_hoadonthang_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hoadonthang_phong` (`IdPhong`);

--
-- Indexes for table `hopdong`
--
ALTER TABLE `hopdong`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hopdong_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hopdong_phong` (`IdPhong`);

--
-- Indexes for table `nguoithue`
--
ALTER TABLE `nguoithue`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_Phong_Tang` (`IdTang`);

--
-- Indexes for table `tang`
--
ALTER TABLE `tang`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `hoadonthang`
--
ALTER TABLE `hoadonthang`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `hopdong`
--
ALTER TABLE `hopdong`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nguoithue`
--
ALTER TABLE `nguoithue`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `phong`
--
ALTER TABLE `phong`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tang`
--
ALTER TABLE `tang`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  ADD CONSTRAINT `fk_cthd_dv1` FOREIGN KEY (`IdDichVu`) REFERENCES `dichvu` (`Id`),
  ADD CONSTRAINT `fk_cthd_hddv` FOREIGN KEY (`IdHoaDonDichVu`) REFERENCES `hoadondichvu` (`Id`);

--
-- Constraints for table `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD CONSTRAINT `fk_hddv_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hddv_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Constraints for table `hoadonthang`
--
ALTER TABLE `hoadonthang`
  ADD CONSTRAINT `fk_hoadonthang_hoadondichvu` FOREIGN KEY (`IdHdDichVu`) REFERENCES `hoadondichvu` (`Id`),
  ADD CONSTRAINT `fk_hoadonthang_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hoadonthang_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Constraints for table `hopdong`
--
ALTER TABLE `hopdong`
  ADD CONSTRAINT `fk_hopdong_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hopdong_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Constraints for table `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `fk_Phong_Tang` FOREIGN KEY (`IdTang`) REFERENCES `tang` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 17, 2019 lúc 08:41 AM
-- Phiên bản máy phục vụ: 10.1.37-MariaDB
-- Phiên bản PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlnt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cthddinhvu`
--

CREATE TABLE `cthddinhvu` (
  `Id` int(11) NOT NULL,
  `IdHoaDonDichVu` int(11) NOT NULL,
  `IdDichVu` int(11) NOT NULL,
  `TongTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dichvu`
--

CREATE TABLE `dichvu` (
  `Id` int(11) NOT NULL,
  `TenDichVu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dichvu`
--

INSERT INTO `dichvu` (`Id`, `TenDichVu`, `SoTien`) VALUES
(1, 'Điện', '3000'),
(2, 'Nước', '14000'),
(4, 'Internet', '110000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadondichvu`
--

CREATE TABLE `hoadondichvu` (
  `Id` int(10) NOT NULL,
  `IdPhong` int(10) NOT NULL,
  `IdNguoiThue` int(10) NOT NULL,
  `ThoiGian` datetime NOT NULL,
  `TienDien` decimal(10,0) NOT NULL,
  `TienNuoc` decimal(10,0) NOT NULL,
  `TienInternet` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadondichvu`
--

INSERT INTO `hoadondichvu` (`Id`, `IdPhong`, `IdNguoiThue`, `ThoiGian`, `TienDien`, `TienNuoc`, `TienInternet`) VALUES
(17, 3, 10, '2019-03-17 01:50:43', '264000', '1792000', '110000'),
(18, 3, 10, '2019-03-17 01:50:53', '132000', '-1358000', '110000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoadonthang`
--

CREATE TABLE `hoadonthang` (
  `Id` int(11) NOT NULL,
  `IdPhong` int(11) NOT NULL,
  `IdNguoiThue` int(11) NOT NULL,
  `IdHdDichVu` int(11) NOT NULL,
  `ThoiGian` datetime NOT NULL,
  `TongTien` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoadonthang`
--

INSERT INTO `hoadonthang` (`Id`, `IdPhong`, `IdNguoiThue`, `IdHdDichVu`, `ThoiGian`, `TongTien`) VALUES
(11, 3, 10, 18, '2019-03-17 13:50:53', '-1116000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hopdong`
--

CREATE TABLE `hopdong` (
  `Id` int(11) NOT NULL,
  `IdNguoiThue` int(11) NOT NULL,
  `TenNguoiThue` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdPhong` int(11) NOT NULL,
  `TenPhong` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoTienCoc` bigint(20) NOT NULL,
  `NgayBatDau` date NOT NULL,
  `NgayKetThuc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hopdong`
--

-- INSERT INTO `hopdong` (`Id`, `IdNguoiThue`, `TenNguoiThue`, `IdPhong`, `TenPhong`, `SoTienCoc`, `NgayBatDau`, `NgayKetThuc`) VALUES
-- (1, 1, 'Trần Đình Sơn', 1, '101', 2000000, '2019-03-16', '2019-03-23'),
-- (2, 2, 'Kiến Đình Khôi', 4, '202', 2000000, '2019-03-03', '2019-03-31'),
-- (4, 10, 'Nguyễn Thị Thu Hiền', 3, '102', 2000000, '2019-03-17', '2019-09-16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoithue`
--

CREATE TABLE `nguoithue` (
  `Id` int(11) NOT NULL,
  `TenNguoiThue` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDTNguoiThue` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `QueQuan` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CMND` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoithue`
--

-- INSERT INTO `nguoithue` (`Id`, `TenNguoiThue`, `SDTNguoiThue`, `QueQuan`, `CMND`) VALUES
-- (1, 'Hoàng Trần Trí', '0386492338', 'Tiềng Giang', '152171454'),
-- (2, 'Nguyễn Thị Kiều Thi', '0388855500', 'Bến Tre', '136252454'),
-- (3, 'Trương Minh Thảo', '034212313', 'Long An', '421312'),

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong`
--

CREATE TABLE `phong` (
  `Id` int(11) NOT NULL,
  `TenPhong` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdTang` int(11) NOT NULL,
  `TenTang` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SoDien` int(11) NOT NULL,
  `SoNuoc` int(11) NOT NULL,
  `SoTienThue` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phong`
--

INSERT INTO `phong` (`Id`, `TenPhong`, `IdTang`, `TenTang`, `SoDien`, `SoNuoc`, `SoTienThue`) VALUES
(1, '101', 1, 'Tầng 1', 100, 100, '2000000'),
(2, '201', 2, 'Tầng 2', 100, 200, '2000000'),
(3, '102', 1, 'Tầng 1', 444, 43, '2000000'),
(4, '202', 2, 'Tầng 2', 100, 100, '2000000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tang`
--

CREATE TABLE `tang` (
  `Id` int(11) NOT NULL,
  `TenTang` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tang`
--

INSERT INTO `tang` (`Id`, `TenTang`) VALUES
(1, 'Tầng 1'),
(2, 'Tầng 2'),
(3, 'Tầng 3'),
(4, 'Tầng 4');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_cthd_dv` (`IdHoaDonDichVu`),
  ADD KEY `fk_cthd_dv1` (`IdDichVu`);

--
-- Chỉ mục cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hddv_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hddv_phong` (`IdPhong`);

--
-- Chỉ mục cho bảng `hoadonthang`
--
ALTER TABLE `hoadonthang`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hoadonthang_hoadondichvu` (`IdHdDichVu`),
  ADD KEY `fk_hoadonthang_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hoadonthang_phong` (`IdPhong`);

--
-- Chỉ mục cho bảng `hopdong`
--
ALTER TABLE `hopdong`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_hopdong_nguoithue` (`IdNguoiThue`),
  ADD KEY `fk_hopdong_phong` (`IdPhong`);

--
-- Chỉ mục cho bảng `nguoithue`
--
ALTER TABLE `nguoithue`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `phong`
--
ALTER TABLE `phong`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_Phong_Tang` (`IdTang`);

--
-- Chỉ mục cho bảng `tang`
--
ALTER TABLE `tang`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `hoadonthang`
--
ALTER TABLE `hoadonthang`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `hopdong`
--
ALTER TABLE `hopdong`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `nguoithue`
--
ALTER TABLE `nguoithue`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `phong`
--
ALTER TABLE `phong`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tang`
--
ALTER TABLE `tang`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cthddinhvu`
--
ALTER TABLE `cthddinhvu`
  ADD CONSTRAINT `fk_cthd_dv1` FOREIGN KEY (`IdDichVu`) REFERENCES `dichvu` (`Id`),
  ADD CONSTRAINT `fk_cthd_hddv` FOREIGN KEY (`IdHoaDonDichVu`) REFERENCES `hoadondichvu` (`Id`);

--
-- Các ràng buộc cho bảng `hoadondichvu`
--
ALTER TABLE `hoadondichvu`
  ADD CONSTRAINT `fk_hddv_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hddv_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Các ràng buộc cho bảng `hoadonthang`
--
ALTER TABLE `hoadonthang`
  ADD CONSTRAINT `fk_hoadonthang_hoadondichvu` FOREIGN KEY (`IdHdDichVu`) REFERENCES `hoadondichvu` (`Id`),
  ADD CONSTRAINT `fk_hoadonthang_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hoadonthang_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Các ràng buộc cho bảng `hopdong`
--
ALTER TABLE `hopdong`
  ADD CONSTRAINT `fk_hopdong_nguoithue` FOREIGN KEY (`IdNguoiThue`) REFERENCES `nguoithue` (`Id`),
  ADD CONSTRAINT `fk_hopdong_phong` FOREIGN KEY (`IdPhong`) REFERENCES `phong` (`Id`);

--
-- Các ràng buộc cho bảng `phong`
--
ALTER TABLE `phong`
  ADD CONSTRAINT `fk_Phong_Tang` FOREIGN KEY (`IdTang`) REFERENCES `tang` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

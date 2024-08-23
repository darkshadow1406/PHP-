-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2023 lúc 07:02 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `ma_binhLuan` int(11) NOT NULL,
  `noiDung` text NOT NULL,
  `ma_thanhVien` int(11) NOT NULL,
  `ma_sanPham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai`
--

CREATE TABLE `loai` (
  `ma_loai` int(11) NOT NULL,
  `ten_loai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loai`
--

INSERT INTO `loai` (`ma_loai`, `ten_loai`) VALUES
(3, 'Thời trang nam'),
(4, 'Thời trang nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `ma_sanPham` int(11) NOT NULL,
  `ten_sanPham` varchar(255) NOT NULL,
  `anh` varchar(255) NOT NULL,
  `gia` double(10,2) NOT NULL,
  `gia_cu` double(10,2) NOT NULL,
  `mo_ta` text NOT NULL,
  `thuong_hieu` varchar(255) NOT NULL,
  `tinh_trang` varchar(255) NOT NULL,
  `ma_loai` int(11) NOT NULL,
  `luot_xem` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`ma_sanPham`, `ten_sanPham`, `anh`, `gia`, `gia_cu`, `mo_ta`, `thuong_hieu`, `tinh_trang`, `ma_loai`, `luot_xem`) VALUES
(1, 'Váy bèo bó dáng', 'apple-watch-se-2022.png', 320000.00, 330000.00, 'Váy bèo bó dáng sản phẩm cho phái nữ đẹp', 'Chic-Land', 'Còn hàng', 4, 0),
(85, 'Váy bèo bó dáng', 'apple-watch-se-2022.png', 320000.00, 330000.00, 'Váy bèo bó dáng sản phẩm cho phái nữ đẹp', 'Chic-Land', 'Còn hàng', 4, 2),
(86, 'Váy bèo bó dáng', 'apple-watch-se-2022.png', 320000.00, 330000.00, 'Váy bèo bó dáng sản phẩm cho phái nữ đẹp', 'Chic-Land', 'Còn hàng', 4, 0),
(87, 'Váy bèo bó dáng', 'apple-watch-se-2022.png', 320000.00, 330000.00, 'Váy bèo bó dáng sản phẩm cho phái nữ đẹp', 'Chic-Land', 'Còn hàng', 4, 0),
(88, 'Váy bèo bó dáng', 'apple-watch-se-2022.png', 320000.00, 330000.00, 'Váy bèo bó dáng sản phẩm cho phái nữ đẹp', 'Chic-Land', 'Còn hàng', 4, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhvien`
--

CREATE TABLE `thanhvien` (
  `ma_thanhVien` int(11) NOT NULL,
  `ten_thanhVien` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `quyen` int(11) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thanhvien`
--

INSERT INTO `thanhvien` (`ma_thanhVien`, `ten_thanhVien`, `Email`, `mat_khau`, `quyen`, `verification_code`) VALUES
(1, 'admin', 'damthanh@gmail.com', '$2y$10$HEWHxFDzlZHQdxGoL.5EXOSRMt1p3Pele1peOzJqCfQDtYaO.h27a', 1, '188076');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`ma_binhLuan`),
  ADD KEY `ten_thanhVien` (`ma_thanhVien`),
  ADD KEY `ma_sanPham` (`ma_sanPham`);

--
-- Chỉ mục cho bảng `loai`
--
ALTER TABLE `loai`
  ADD PRIMARY KEY (`ma_loai`);

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`ma_sanPham`),
  ADD KEY `ma_loai` (`ma_loai`);

--
-- Chỉ mục cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`ma_thanhVien`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `ma_binhLuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT cho bảng `loai`
--
ALTER TABLE `loai`
  MODIFY `ma_loai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `ma_sanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  MODIFY `ma_thanhVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`ma_thanhVien`) REFERENCES `thanhvien` (`ma_thanhVien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`ma_sanPham`) REFERENCES `sanpham` (`ma_sanPham`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`ma_loai`) REFERENCES `loai` (`ma_loai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

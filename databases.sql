-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2024 at 10:06 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

DROP TABLE IF EXISTS `markets`;
CREATE TABLE IF NOT EXISTS `markets`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL ,
  `city` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL ,
  `district` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL ,
  `address` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL , 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT=6 CHARSET=utf8mb4 COLLATE utf8mb4_turkish_ci;

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marketid` int(11) NOT NULL ,
  `title` varchar(100) NOT NULL,
  `stock` VARCHAR(100) NOT NULL,
  `normalprice` VARCHAR(100) NOT NULL,
  `discPrice` VARCHAR(100) NOT NULL,
  `expDate` date NOT NULL,
  `expDatePhoto` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT=31 CHARSET=utf8mb4 COLLATE utf8mb4_turkish_ci;

DROP TABLE IF EXISTS `consumers`;
CREATE TABLE IF NOT EXISTS `consumers` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_turkish_ci;
--
-- Dumping data for table ` `
--

-- 1111: password
INSERT INTO `markets` (`id`, `email`, `password`, `name`, `city`, `district`, `address`) VALUES
(1, 'sokmarket@gmail.com', '$2y$10$6GmjrNyJNSE2NVvatsdiDuJF9WRS8OwzL5FAEd/ft1KdAsYImI5JS', 'Şok Market', 'Ankara', 'Çankaya', 'Poyraz Mahallesi No:17'),
(2, 'a101@gmail.com', '$2y$10$6GmjrNyJNSE2NVvatsdiDuJF9WRS8OwzL5FAEd/ft1KdAsYImI5JS', 'A101', 'İzmir', 'Konak', 'Cevizli Mahallesi No:22'),
(3, 'migros@gmail.com', '$2y$10$6GmjrNyJNSE2NVvatsdiDuJF9WRS8OwzL5FAEd/ft1KdAsYImI5JS', 'Migros', 'Ankara', 'Çayyolu', 'Ekip Mahallesi No:9'),
(4, 'bimmarket@gmail.com', '$2y$10$6GmjrNyJNSE2NVvatsdiDuJF9WRS8OwzL5FAEd/ft1KdAsYImI5JS', 'Bim Market', 'Ankara', 'Çankaya', 'Nar Mahallesi No:33'),
(5, 'bilmarket@gmail.com', '$2y$10$6GmjrNyJNSE2NVvatsdiDuJF9WRS8OwzL5FAEd/ft1KdAsYImI5JS', ' BilMarket', 'İzmir', 'Karşıyaka', 'Deniz Mahallesi No:1');
COMMIT;

-- 2222: password
INSERT INTO `consumers` (`email`, `password`, `name`, `city`, `district`, `address`) VALUES
('nisademir@gmail.com', '$2y$10$TWJUXq8NIOwE/YLAwdkwGO3byTxhcwaquGpu8GZ//NmIqDSF.AXnG', 'Nisa Demir', 'İzmir', 'Konak', 'Bilkent Üniversitesi'),
('denizulu@gmail.com', '$2y$10$TWJUXq8NIOwE/YLAwdkwGO3byTxhcwaquGpu8GZ//NmIqDSF.AXnG', 'Deniz Ulu', 'Ankara', 'Çankaya', 'Ceviz Mahallesi'),
('ecemtekiner@gmail.com', '$2y$10$TWJUXq8NIOwE/YLAwdkwGO3byTxhcwaquGpu8GZ//NmIqDSF.AXnG', 'Ecem Tekiner', 'İzmir', 'Karşıyaka', 'Kiraz Mahallesi'),
('eneskaynakci@gmail.com', '$2y$10$TWJUXq8NIOwE/YLAwdkwGO3byTxhcwaquGpu8GZ//NmIqDSF.AXnG', 'Enes Kaynakçı', 'Ankara', 'Çayyolu', 'Gökkuşağı Mahallesi'),
('serkangenc@gmail.com', '$2y$10$TWJUXq8NIOwE/YLAwdkwGO3byTxhcwaquGpu8GZ//NmIqDSF.AXnG', ' Serkan Genç', 'İstanbul', 'Bebek', 'Tema Mahallesi');
COMMIT;

INSERT INTO `products` (`id`, `marketid`, `title`, `stock`, `normalprice`, `discPrice`, `expDate`, `expDatePhoto`)
VALUES
(1, 1, 'Kinder Bueno', '10', '20', '15', '2024-06-10', 'photo.jpg'),
(2, 1, 'Kinder Süt Dilimi', '30', '30', '25', '2024-05-05', 'photo.jpg'),
(3, 1, 'Eti Burçak', '5', '5', '3', '2024-05-20', 'photo.jpg'),
(4, 1, 'Mars', '20', '25', '20', '2024-06-15', 'photo.jpg'),
(5, 1, 'Snickers', '15', '20', '18', '2024-07-01', 'photo.jpg'),
(6, 1, 'Toblerone', '25', '30', '25', '2024-06-25', 'photo.jpg'),
(7, 1, 'KitKat', '10', '15', '12', '2024-05-12', 'photo.jpg'),
(8, 1, 'Milka Çikolata', '18', '20', '17', '2024-06-20', 'photo.jpg'),
(9, 1, 'Cadbury Dairy Milk', '22', '20', '18', '2024-05-08', 'photo.jpg'),
(10, 1, 'Ferrero Rocher', '28', '35', '30', '2024-06-30', 'photo.jpg'),
(11, 1, 'Godiva', '10', '40', '35', '2024-07-18', 'photo.jpg'),
(12, 1, 'Lindt', '12', '25', '22', '2024-05-12', 'photo.jpg'),
(13, 1, 'Tic Tac', '50', '5', '4', '2024-07-23', 'photo.jpg'),
(14, 2, 'Altoids', '40', '8', '6', '2024-05-08', 'photo.jpg'),
(15, 2, 'Haribo Gummi Bears', '30', '10', '8', '2024-07-02', 'photo.jpg'),
(16, 2, 'Twix', '25', '20', '18', '2024-06-18', 'photo.jpg'),
(17, 2, 'Reese Peanut Butter Cups', '20', '25', '22', '2024-07-15', 'photo.jpg'),
(18, 2, 'Ferrero Rondnoir', '15', '30', '25', '2024-05-22', 'photo.jpg'),
(19, 2, 'Skittles', '35', '12', '10', '2024-07-28', 'photo.jpg'),
(20, 2, 'M-M', '40', '15', '12', '2024-06-28', 'photo.jpg'),
(21, 2, 'Hershey Milk Chocolate', '30', '18', '15', '2024-07-30', 'photo.jpg'),
(22, 2, 'Ghirardelli Chocolate Squares', '18', '25', '20', '2024-06-23', 'photo.jpg'),
(23, 2, 'York Peppermint Patties', '20', '10', '8', '2024-05-06', 'photo.jpg'),
(24, 2, 'Hershey Kisses', '30', '12', '10', '2024-06-29', 'photo.jpg'),
(25, 2, 'Milky Way', '20', '22', '18', '2024-05-14', 'photo.jpg'),
(26, 2, 'Nestle Crunch', '25', '15', '12', '2024-06-26', 'photo.jpg'),
(27, 3, 'Almond Joy', '20', '20', '15', '2024-05-16', 'photo.jpg'),
(28, 3, 'Ritter Sport', '15', '18', '15', '2024-06-19', 'photo.jpg'),
(29, 3, 'Cadbury Flake', '10', '20', '18', '2024-07-25', 'photo.jpg'),
(30, 3, 'Cadbury Creme Egg', '8', '25', '20', '2024-05-11', 'photo.jpg'),
(31, 3, 'Kinder Bueno', '10', '20', '15', '2024-06-10', 'photo.jpg'),
(32, 3, 'Kinder Süt Dilimi', '30', '30', '25', '2024-07-05', 'photo.jpg'),
(33, 3, 'Eti Burçak', '5', '5', '3', '2024-07-20', 'photo.jpg'),
(34, 3, 'Mars', '20', '25', '20', '2024-06-15', 'photo.jpg'),
(35, 3, 'Snickers', '15', '20', '18', '2024-05-01', 'photo.jpg'),
(36, 3, 'Toblerone', '25', '30', '25', '2024-06-25', 'photo.jpg'),
(37, 3, 'KitKat', '10', '15', '12', '2024-07-12', 'photo.jpg'),
(38, 3, 'Milka Çikolata', '18', '20', '17', '2024-06-20', 'photo.jpg'),
(39, 3, 'Cadbury Dairy Milk', '22', '20', '18', '2024-05-08', 'photo.jpg'),
(40, 4, 'Ferrero Rocher', '28', '35', '30', '2024-06-30', 'photo.jpg'),
(41, 4, 'Godiva', '10', '40', '35', '2024-05-18', 'photo.jpg'),
(42, 4, 'Lindt', '12', '25', '22', '2024-06-12', 'photo.jpg'),
(43, 4, 'Tic Tac', '50', '5', '4', '2024-07-23', 'photo.jpg'),
(44, 4, 'Altoids', '40', '8', '6', '2024-05-08', 'photo.jpg'),
(45, 4, 'Haribo Gummi Bears', '30', '10', '8', '2024-07-02', 'photo.jpg'),
(46, 4, 'Twix', '25', '20', '18', '2024-06-18', 'photo.jpg'),
(47, 4, 'Reese Peanut Butter Cups', '20', '25', '22', '2024-05-15', 'photo.jpg'),
(48, 4, 'Ferrero Rondnoir', '15', '30', '25', '2024-06-22', 'photo.jpg'),
(49, 4, 'Skittles', '35', '12', '10', '2024-07-28', 'photo.jpg'),
(50, 4, 'M-M', '40', '15', '12', '2024-06-28', 'photo.jpg'),
(51, 4, 'Hershey Milk Chocolate', '30', '18', '15', '2024-07-30', 'photo.jpg'),
(52, 4, 'Ghirardelli Chocolate Squares', '18', '25', '20', '2024-06-23', 'photo.jpg'),
(53, 5, 'York Peppermint Patties', '20', '10', '8', '2024-05-06', 'photo.jpg'),
(54, 5, 'Hershey Kisses', '30', '12', '10', '2024-06-29', 'photo.jpg'),
(55, 5, 'Milky Way', '20', '22', '18', '2024-05-14', 'photo.jpg'),
(56, 5, 'Nestle Crunch', '25', '15', '12', '2024-06-26', 'photo.jpg'),
(57, 5, 'Almond Joy', '20', '20', '15', '2024-05-16', 'photo.jpg'),
(58, 5, 'Ritter Sport', '15', '18', '15', '2024-06-19', 'photo.jpg'),
(59, 5, 'Cadbury Flake', '10', '20', '18', '2024-07-25', 'photo.jpg'),
(60, 5, 'Cadbury Creme Egg', '8', '25', '20', '2024-07-11', 'photo.jpg'),
(61, 5, 'Ferrero Kinder Joy', '10', '20', '15', '2024-06-10', 'photo.jpg'),
(62, 5, 'Kinder Delice', '30', '30', '25', '2024-05-05', 'photo.jpg'),
(63, 5, 'Eti Puf', '5', '5', '3', '2024-07-20', 'photo.jpg'),
(64, 5, 'Bounty', '20', '25', '20', '2024-05-15', 'photo.jpg'),
(65, 5, 'Milkybar', '15', '20', '18', '2024-07-01', 'photo.jpg');
COMMIT;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

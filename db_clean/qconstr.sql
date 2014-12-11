-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2014 at 08:49 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qconstr`
--
CREATE DATABASE IF NOT EXISTS `qconstr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `qconstr`;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `cover_img` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `cover_img`) VALUES
(9, 'Empty Album', '1416749699_A9C9F474-D66C-4711-927C-CED518D917AC.jpg'),
(13, 'Bathrooms', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `album_images`
--

CREATE TABLE IF NOT EXISTS `album_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `album_images`
--

INSERT INTO `album_images` (`id`, `title`, `image`, `album_id`) VALUES
(15, '', '1416749684_21CE6CC8-1057-4F4C-82CA-CAE870C2C3ED.jpg', 9),
(16, '', '1416749699_A9C9F474-D66C-4711-927C-CED518D917AC.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `is_module` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `text`, `is_module`) VALUES
(1, 'New Article', '<p>Article ready for everything!!</p>', 0),
(2, 'About Us', '<h1>A word about us<br></h1><p><img src="http://localhost/qconstr/upload/2.png" width="268" height="177" data-mce-src="http://localhost/qconstr/upload/2.png" style="float: right; margin: 5px 10px 5px 10px;" data-mce-style="float: right; margin: 5px 10px 5px 10px;"><br data-mce-bogus="1"></p><p style="text-align: justify;" data-mce-style="text-align: justify;">Q Construction, owned and operated by Gary Quateman, is a design and build construction firm specializing in building and renovating luxury high-end residences throughout the Chicagoland area. We have a unique, integrated interior design capability provided by Garyâ€™s wife, Eva. Many clients have taken advantage of these in-house design services, as this has proven to be a cost effective approach to a designed based renovation. However, this does not mean that you canâ€™t bring your own architect and designer to the table. Our projects range from a small scale remodel of an in-town pied-a-terre to a full scale 7000 sq. foot vintage gut renovation.<br></p><p style="text-align: justify;" data-mce-style="text-align: justify;">We provide our clients distinctive, high-quality residential craftsmanship. Every aspect of your project is managed by Gary, ensuring the integrity of the design, as well as eliminating the hassles and headaches common in nearly every renovation thatâ€™s not professionally managed</p><p style="text-align: justify;" data-mce-style="text-align: justify;">Weâ€™ve worked in many of Chicagoâ€™s most prestigious condominiums, cooperatives and single family homes. Our mission is to provide our discriminating clientele with exceptional dependability, workmanship, value, and premiere customer service. With Q Construction, your project is professionally managed, completed on time, and within budget.</p>', 0),
(3, 'Contact us', '<h1>Feel free to contact us</h1><p><img src="http://localhost/qconstr/upload/2.png" width="300" height="198" data-mce-src="http://localhost/qconstr/upload/2.png" style="float: left;" data-mce-style="float: left;"></p><p><br></p><p><br data-mce-bogus="1"></p><p><br data-mce-bogus="1"></p><p><br data-mce-bogus="1"></p><p><br data-mce-bogus="1"></p><p><br data-mce-bogus="1"></p><p>Email:&nbsp;<br></p><p>Fax:</p><p>Mobile:</p>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `client_menu`
--

CREATE TABLE IF NOT EXISTS `client_menu` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(4) DEFAULT NULL,
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_static` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `client_menu`
--

INSERT INTO `client_menu` (`id`, `name`, `link`, `position`, `is_hidden`, `is_static`) VALUES
(1, 'Home', 'home', 1, 1, 1),
(2, 'About Us', 'aboutus', 3, 0, 0),
(3, 'Contact Us', 'contactus', 4, 0, 1),
(4, 'Project Gallery', 'projectgallery', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_content`
--

CREATE TABLE IF NOT EXISTS `page_content` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `page_id` int(12) NOT NULL,
  `elem_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `page_content`
--

INSERT INTO `page_content` (`id`, `page_id`, `elem_id`) VALUES
(1, 1, NULL),
(2, 2, NULL),
(3, 3, NULL),
(4, 4, NULL),
(5, 1, 1),
(6, 2, 2),
(7, 3, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

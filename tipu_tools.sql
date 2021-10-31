-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2021 at 04:05 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tipu_tools`
--

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE `tools` (
  `id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`id`, `title`, `description`, `link`) VALUES
(1, 'Instagram Photo/Video Downloader', 'Using this Tool, You can download any Video or Photo of Instagram with High Resolution', 'instagram-video-downloader/'),
(2, 'To Do - Boost Up Your Work', 'Do your daily work faster by Creating a daily To-Do list using our Tool', 'to-do'),
(3, 'Embed YouTube Video Responsivly', 'Using this tool you can embed any YouTUbe video to our Blog or Webiste.Our tool will be Generate a R', 'embed-youtube-video-responsively/'),
(4, 'Facebook Video Downloader', 'Using this tool, you can Easily Download Any Kind of Facebook Video with one click. No Ads.\r\n\r\n', 'http://tipusultan.pythonanywhere.com/'),
(5, 'Privacy Policy Page Generator', 'Using our this Tool, You can easily generate your privacy policy page with one click\r\n\r\n', 'privacy-policy-page-genarator'),
(6, 'YouTube Thumnail Downloader', 'Using this tool you can any YouTube Video Thumnail in Full HD Quality\r\n\r\n', 'youtube-thumnail-downloader/'),
(7, 'Gradient color code Generator', 'Generate or browse beautiful gradient color combinations for your designs.\r\n\r\n', 'gradient-color-code-generator/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tools`
--
ALTER TABLE `tools`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tools`
--
ALTER TABLE `tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

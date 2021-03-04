-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2018 at 10:34 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamelink`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversationID` int(11) NOT NULL,
  `title` varchar(75) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversationID`, `title`, `senderID`, `receiverID`) VALUES
(11, '', 26, 26),
(12, '', 26, 27);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `gameName` varchar(255) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `gameUsername` varchar(255) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `userId` int(11) NOT NULL,
  `addInfo` varchar(50) CHARACTER SET latin2 COLLATE latin2_croatian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `gameName`, `gameUsername`, `userId`, `addInfo`) VALUES
(39, 'Fortnite', 'GoldenDragonPC', 26, 'pc'),
(41, 'League of Legends', 'AntonioCroZgGNC', 26, 'eun1'),
(43, 'Fortnite', 'GoldenDragonPC', 26, 'xb1');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `conversationID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `message_title` varchar(50) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `message_text` text CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `conversationID`, `senderID`, `receiverID`, `message_title`, `message_text`, `time`) VALUES
(8, 12, 26, 27, '', 'Hey man!', '2018-05-26 13:18:14'),
(9, 12, 27, 26, '', 'Aloha mate!', '2018-05-26 13:20:55'),
(10, 12, 26, 27, '', 'How are you doing?', '2018-05-26 14:12:38'),
(11, 12, 27, 26, '', 'I&#39;m great, what about you?', '2018-05-26 14:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `email` varchar(50) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL,
  `displayName` varchar(50) CHARACTER SET latin2 COLLATE latin2_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `level`, `email`, `displayName`) VALUES
(26, 'antonio', '$2y$10$vOdQBxvNCS0U47lD9yQ71eeTF3dOMnNxXPyYQ4Jgp9OBeiEmu4lRW', 1, 'amnewmail@gmail.com', 'Antonio'),
(27, 'antonio2', '$2y$10$ZiI3TbI3cgCWZ/o8rOiLL.O.HiLK8CFyyV4E8114xuwrc4mjoDNSa', 1, 'amnewmail2@gmail.com', 'Antonio2'),
(28, 'antonio3', '$2y$10$IJulkTUTHCRKknA7Br1bpu/1xUKZySWhx5IivACw8yvJimw9oGX0y', 1, 'amnewmail3@gmail.com', 'Antonio3'),
(29, 'antonio4', '$2y$10$ZuC3gZ66Hg8sRl8SJQ1n3OHlo4uO.uV8eYKqWLPfSobQ3IlBN66TK', 1, 'amnewmail4@gmail.com', 'Antonio4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversationID`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `displayName` (`displayName`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

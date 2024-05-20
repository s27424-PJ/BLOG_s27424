-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 20, 2024 at 06:55 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `CommentID` int(11) NOT NULL,
  `PostID` int(11) NOT NULL,
  `CommentText` text NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `Username` varchar(255) DEFAULT NULL,
  `Avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `PostID`, `CommentText`, `DateAdded`, `Username`, `Avatar`) VALUES
(124, 35, 'TEst1', '2024-05-20 13:40:03', 'admin', NULL),
(125, 34, 'TEst2', '2024-05-20 13:40:06', 'admin', NULL),
(126, 33, 'Test3', '2024-05-20 13:40:13', 'guest', NULL),
(127, 35, 's', '2024-05-20 13:42:00', 'guest', NULL),
(128, 35, 'ds', '2024-05-20 13:58:48', 'arek', NULL),
(129, 34, 'sd', '2024-05-20 13:59:09', 'arek', NULL),
(130, 34, 's', '2024-05-20 13:59:15', 'arek', NULL),
(131, 34, 'd', '2024-05-20 13:59:19', 'arek', NULL),
(132, 34, 'fs\r\n', '2024-05-20 13:59:25', 'arek', NULL),
(137, 33, 'd', '2024-05-20 14:04:18', 'admin', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `PostID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `DatePublished` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`PostID`, `Title`, `Content`, `Image`, `DatePublished`, `UserID`) VALUES
(33, 'Test1', 'Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1Test1', '1.jpg', '2024-05-20 13:35:22', 5),
(34, 'Test2', 'Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2Test2', '2.jpg', '2024-05-20 13:35:40', 5),
(35, 'Test3', 'Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3Test3', '3.jpg', '2024-05-20 13:35:58', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Avatar` varchar(255) DEFAULT NULL,
  `UserType` enum('administrator','autor_bloga','użytkownik','guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Avatar`, `UserType`) VALUES
(4, 'author_user', '$2y$10$wEZ5Uw6TbID7R9mfpNjy/uKx4uV55kKHa26ktx7CWrKkrY8VrZmD.', 'avatars/2.jpg', 'autor_bloga'),
(5, 'admin', '$2y$10$wEZ5Uw6TbID7R9mfpNjy/uKx4uV55kKHa26ktx7CWrKkrY8VrZmD.', 'avatars/1.jpg', 'administrator'),
(14, 'arek', '$2y$10$TnH2FU7kw5RPqnPftcvSH.6FzG/VdCTnvPu3VVld8kXGbq0Nuv31.', 'avatars/arek_1.jpg', 'użytkownik');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `PostID` (`PostID`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`PostID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`PostID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

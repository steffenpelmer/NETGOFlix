-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Dez 2018 um 22:03
-- Server-Version: 10.1.34-MariaDB
-- PHP-Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `netgoflix`
--
CREATE DATABASE IF NOT EXISTS `netgoflix` DEFAULT CHARACTER SET latin1 COLLATE latin1_german1_ci;
USE `netgoflix`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `activuser`
--

CREATE TABLE `activuser` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `keyUser` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `activuser`
--

INSERT INTO `activuser` (`id`, `ip`, `keyUser`, `timestamp`) VALUES
(9, '::1', 2, 1545258869),
(10, '::1', 3, 1545259024),
(11, '::1', 2, 1545259040),
(12, '::1', 1, 1545259059),
(13, '::1', 2, 1545259185),
(14, '::1', 3, 1545259767),
(15, '::1', 1, 1545259771);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(0, 'Unbekannt'),
(1, 'Horror'),
(2, 'Drama'),
(3, 'Action'),
(4, 'Fantasy'),
(5, 'Komödie'),
(6, 'Liebes'),
(7, 'Science-Fiction'),
(8, 'Thriller'),
(9, 'Krieg'),
(10, 'Abenteuer'),
(11, 'Animation');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `year` int(11) DEFAULT NULL,
  `fsk` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `keyGenre1` int(11) DEFAULT NULL,
  `keyGenre2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `movies`
--

INSERT INTO `movies` (`id`, `name`, `year`, `fsk`, `rating`, `duration`, `keyGenre1`, `keyGenre2`) VALUES
(15, 'Es', 2017, 16, 7.4, 135, 1, 8),
(16, 'Shining', 1980, 16, 8.4, 146, 2, 1),
(17, 'Shaun of the Dead', 2004, 16, 7.9, 99, 5, 8),
(18, 'Kevin - Allein zu Haus', 1990, 12, 7.5, 135, 5, 8),
(19, 'Ralph reichts', 2012, 0, 7.7, 101, 11, 5),
(20, 'Deadpool 2', 2016, 16, 8, 108, 3, 8),
(21, 'The Dark Knight', 2008, 16, 9, 152, 3, 2),
(22, 'Inception', 2010, 12, 8.8, 148, 3, 4),
(23, 'Matrix', 1999, 16, 8.7, 136, 5, 7),
(24, 'The Avengers', 2012, 12, 8.1, 143, 3, 7),
(25, 'Forrest gump', 1994, 12, 8.8, 142, 2, 6),
(26, 'Der Soldat James Ryan', 1998, 16, 8.6, 169, 2, 9),
(27, 'Harry Potter und der Stein der Weisen', 2001, 6, 7.6, 152, 10, 4),
(28, 'Harry Potter und die Kammer des Schreckens', 2002, 6, 7.4, 181, 10, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `name`, `lastname`, `email`) VALUES
(1, 'Steffen', 'Pelmer', 'steffenpelmer@gmail.com'),
(2, 'Karl', 'Otto', 'karl.otto@netgo.de'),
(3, 'Hans', 'Dieter', 'hdieter@test.de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `usermovies`
--

CREATE TABLE `usermovies` (
  `id` int(11) NOT NULL,
  `keyMovie` int(11) NOT NULL,
  `keyUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `activuser`
--
ALTER TABLE `activuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keyUser` (`keyUser`);

--
-- Indizes für die Tabelle `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keyGenre1` (`keyGenre1`),
  ADD KEY `keyGenre2` (`keyGenre2`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `usermovies`
--
ALTER TABLE `usermovies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keyUser` (`keyUser`),
  ADD KEY `keyMovie` (`keyMovie`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `activuser`
--
ALTER TABLE `activuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `activuser`
--
ALTER TABLE `activuser`
  ADD CONSTRAINT `activuser_ibfk_1` FOREIGN KEY (`keyUser`) REFERENCES `user` (`id`);

--
-- Constraints der Tabelle `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`keyGenre1`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `movies_ibfk_2` FOREIGN KEY (`keyGenre2`) REFERENCES `genre` (`id`);

--
-- Constraints der Tabelle `usermovies`
--
ALTER TABLE `usermovies`
  ADD CONSTRAINT `usermovies_ibfk_1` FOREIGN KEY (`keyUser`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `usermovies_ibfk_2` FOREIGN KEY (`keyMovie`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

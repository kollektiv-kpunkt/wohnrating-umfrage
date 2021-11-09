-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 09. Nov 2021 um 14:03
-- Server-Version: 10.3.28-MariaDB
-- PHP-Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `pn44_umfrage`
--
CREATE DATABASE IF NOT EXISTS `pn44_umfrage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pn44_umfrage`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `partyhashes`
--

DROP TABLE IF EXISTS `partyhashes`;
CREATE TABLE `partyhashes` (
  `hash_ID` int(11) NOT NULL,
  `hash_party` text NOT NULL,
  `hash_code` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `politicians`
--

DROP TABLE IF EXISTS `politicians`;
CREATE TABLE `politicians` (
  `politician_ID` int(11) NOT NULL,
  `politician_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `politician_UUID` varchar(50) NOT NULL,
  `politician_info` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `partyhashes`
--
ALTER TABLE `partyhashes`
  ADD PRIMARY KEY (`hash_ID`);

--
-- Indizes für die Tabelle `politicians`
--
ALTER TABLE `politicians`
  ADD PRIMARY KEY (`politician_ID`),
  ADD UNIQUE KEY `politician_UUID` (`politician_UUID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `partyhashes`
--
ALTER TABLE `partyhashes`
  MODIFY `hash_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `politicians`
--
ALTER TABLE `politicians`
  MODIFY `politician_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

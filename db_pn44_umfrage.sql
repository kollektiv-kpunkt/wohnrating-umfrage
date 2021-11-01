-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 01. Nov 2021 um 13:36
-- Server-Version: 5.7.24
-- PHP-Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_pn44_umfrage`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `politicians`
--

CREATE TABLE `politicians` (
  `politician_ID` int(11) NOT NULL,
  `politician_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `politician_UUID` varchar(20) NOT NULL,
  `politician_info` json NOT NULL,
  `politician_answers` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `politicians`
--

INSERT INTO `politicians` (`politician_ID`, `politician_timestamp`, `politician_UUID`, `politician_info`, `politician_answers`) VALUES
(1, '2021-11-01 10:52:09', '11111111', '{\"ID\": 1234567890, \"name\": {\"fname\": \"Corine\", \"lname\": \"Mauch\"}, \"email\": \"corine@mauch.ch\", \"partei\": \"sp\", \"gemeinde\": 261, \"contactStatus\": 0}', '1');

--
-- Indizes der exportierten Tabellen
--

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
-- AUTO_INCREMENT für Tabelle `politicians`
--
ALTER TABLE `politicians`
  MODIFY `politician_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

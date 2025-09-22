-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 16 sep 2025 om 17:53
-- Serverversie: 5.7.36
-- PHP-versie: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `academietien`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `classId` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(255) NOT NULL,
  `classIsActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`classId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `studentId` int(11) NOT NULL AUTO_INCREMENT,
  `studentName` varchar(255) NOT NULL,
  `studentClass` int(11) NOT NULL,
  `studentNiveau` varchar(255) NOT NULL,
  `studentIsActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`studentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teacherhasunits`
--

DROP TABLE IF EXISTS `teacherhasunits`;
CREATE TABLE IF NOT EXISTS `teacherhasunits` (
  `teacherId` int(11) NOT NULL,
  `unitId` int(11) NOT NULL,
  PRIMARY KEY (`teacherId`,`unitId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `teacherId` int(11) NOT NULL AUTO_INCREMENT,
  `teacherName` varchar(255) NOT NULL,
  `teacherEmail` varchar(255) NOT NULL,
  `teacherPassword` varchar(255) NOT NULL,
  `teacherIsActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`teacherId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `teachers`
--

INSERT INTO `teachers` (`teacherId`, `teacherName`, `teacherEmail`, `teacherPassword`, `teacherIsActive`) VALUES
(1, 'Philip', 'philiphage2@gmail.com', '123456', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `unithasclasses`
--

DROP TABLE IF EXISTS `unithasclasses`;
CREATE TABLE IF NOT EXISTS `unithasclasses` (
  `unitId` int(11) NOT NULL,
  `classId` int(11) NOT NULL,
  PRIMARY KEY (`unitId`,`classId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `unitId` int(11) NOT NULL AUTO_INCREMENT,
  `unitName` varchar(255) NOT NULL,
  `unitIsActive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`unitId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `units`
--

INSERT INTO `units` (`unitId`, `unitName`, `unitIsActive`) VALUES
(1, '1', 1);
COMMIT;

CREATE TABLE IF NOT EXISTS `password_resets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `email` varchar(191) NOT NULL,
    `token` varchar(191) NOT NULL,
    `expires_at` datetime NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Set 19, 2015 alle 11:28
-- Versione del server: 5.5.44-0ubuntu0.14.04.1
-- Versione PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dmipreprints`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORI`
--

CREATE TABLE IF NOT EXISTS `AUTORI` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORI_BACKUP`
--

CREATE TABLE IF NOT EXISTS `AUTORI_BACKUP` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `DATA_ULTIMO_LANCIO`
--

CREATE TABLE IF NOT EXISTS `DATA_ULTIMO_LANCIO` (
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `DATA_ULTIMO_LANCIO`
--

INSERT INTO `DATA_ULTIMO_LANCIO` (`data`) VALUES
('2015-09-19 10:57');

-- --------------------------------------------------------

--
-- Struttura della tabella `PREPRINTS`
--

CREATE TABLE IF NOT EXISTS `PREPRINTS` (
  `uid` text COLLATE utf8_unicode_ci,
  `id_pubblicazione` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` longtext COLLATE utf8_unicode_ci,
  `data_pubblicazione` longtext COLLATE utf8_unicode_ci,
  `autori` longtext COLLATE utf8_unicode_ci,
  `referenze` longtext COLLATE utf8_unicode_ci,
  `commenti` longtext COLLATE utf8_unicode_ci,
  `categoria` longtext COLLATE utf8_unicode_ci,
  `abstract` longtext COLLATE utf8_unicode_ci,
  `Filename` longtext COLLATE utf8_unicode_ci,
  `checked` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `counter` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pubblicazione`),
  FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `PREPRINTS_ARCHIVIATI`
--

CREATE TABLE IF NOT EXISTS `PREPRINTS_ARCHIVIATI` (
  `uid` text COLLATE utf8_unicode_ci,
  `id_pubblicazione` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` longtext COLLATE utf8_unicode_ci,
  `data_pubblicazione` longtext COLLATE utf8_unicode_ci,
  `autori` longtext COLLATE utf8_unicode_ci,
  `referenze` longtext COLLATE utf8_unicode_ci,
  `commenti` longtext COLLATE utf8_unicode_ci,
  `categoria` longtext COLLATE utf8_unicode_ci,
  `abstract` longtext COLLATE utf8_unicode_ci,
  `Filename` longtext COLLATE utf8_unicode_ci,
  `checked` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `counter` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pubblicazione`),
  FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `sessione`
--

CREATE TABLE IF NOT EXISTS `sessione` (
  `attivo` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`attivo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `sessione`
--

INSERT INTO `sessione` (`attivo`) VALUES
('0');

-- --------------------------------------------------------

--
-- Struttura della tabella `sessione_data`
--

CREATE TABLE IF NOT EXISTS `sessione_data` (
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`data`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `sessione_data`
--

INSERT INTO `sessione_data` (`data`) VALUES
('20150919');

-- --------------------------------------------------------

--
-- Struttura della tabella `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

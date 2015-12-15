-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Creato il: Dic 15, 2015 alle 20:02
-- Versione del server: 5.6.27-0ubuntu1
-- Versione PHP: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dmipreprints`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `ACCOUNTS`
--

CREATE TABLE IF NOT EXISTS `ACCOUNTS` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cognome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `accesso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `registrazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verificato` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORI`
--

CREATE TABLE IF NOT EXISTS `AUTORI` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORI_BACKUP`
--

CREATE TABLE IF NOT EXISTS `AUTORI_BACKUP` (
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `DATA_ULTIMO_LANCIO`
--

CREATE TABLE IF NOT EXISTS `DATA_ULTIMO_LANCIO` (
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `DATA_ULTIMO_LANCIO`
--

INSERT INTO `DATA_ULTIMO_LANCIO` (`data`) VALUES
('2015-12-15 19:46');

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
  `counter` int(255) NOT NULL DEFAULT '0'
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
  `counter` int(255) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `sessione`
--

CREATE TABLE IF NOT EXISTS `sessione` (
  `attivo` varchar(1) COLLATE utf8_unicode_ci NOT NULL
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
  `data` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `sessione_data`
--

INSERT INTO `sessione_data` (`data`) VALUES
('20151215');

-- --------------------------------------------------------

--
-- Struttura della tabella `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `id` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `ACCOUNTS`
--
ALTER TABLE `ACCOUNTS`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `AUTORI`
--
ALTER TABLE `AUTORI`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `AUTORI_BACKUP`
--
ALTER TABLE `AUTORI_BACKUP`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `DATA_ULTIMO_LANCIO`
--
ALTER TABLE `DATA_ULTIMO_LANCIO`
  ADD PRIMARY KEY (`data`);

--
-- Indici per le tabelle `PREPRINTS`
--
ALTER TABLE `PREPRINTS`
  ADD PRIMARY KEY (`id_pubblicazione`),
  ADD FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`);

--
-- Indici per le tabelle `PREPRINTS_ARCHIVIATI`
--
ALTER TABLE `PREPRINTS_ARCHIVIATI`
  ADD PRIMARY KEY (`id_pubblicazione`),
  ADD FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`);

--
-- Indici per le tabelle `sessione`
--
ALTER TABLE `sessione`
  ADD PRIMARY KEY (`attivo`);

--
-- Indici per le tabelle `sessione_data`
--
ALTER TABLE `sessione_data`
  ADD PRIMARY KEY (`data`);

--
-- Indici per le tabelle `temp`
--
ALTER TABLE `temp`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

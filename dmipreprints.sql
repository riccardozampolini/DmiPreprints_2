-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
<<<<<<< HEAD
-- Generation Time: Mag 22, 2015 alle 11:18
=======
-- Generation Time: Mag 16, 2015 alle 23:19
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
-- Versione del server: 5.6.24-0ubuntu2
-- PHP Version: 5.6.4-4ubuntu6

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
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

<<<<<<< HEAD
--
-- Dump dei dati per la tabella `AUTORI`
--

INSERT INTO `AUTORI` (`nome`) VALUES
('BRUNO IANNAZZO'),
('GIANLUCA VINTI'),
('LAURA ANGELONI'),
('MASSIMO GIULIETTI');

=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
-- --------------------------------------------------------

--
-- Struttura della tabella `AUTORI_BACKUP`
--

CREATE TABLE IF NOT EXISTS `AUTORI_BACKUP` (
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

<<<<<<< HEAD
--
-- Dump dei dati per la tabella `AUTORI_BACKUP`
--

INSERT INTO `AUTORI_BACKUP` (`nome`) VALUES
('BRUNO IANNAZZO'),
('GIANLUCA VINTI'),
('LAURA ANGELONI'),
('MASSIMO GIULIETTI');

=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
-- --------------------------------------------------------

--
-- Struttura della tabella `DATA_ULTIMO_LANCIO`
--

CREATE TABLE IF NOT EXISTS `DATA_ULTIMO_LANCIO` (
  `data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `DATA_ULTIMO_LANCIO`
--

INSERT INTO `DATA_ULTIMO_LANCIO` (`data`) VALUES
<<<<<<< HEAD
('2015-05-22 11:16');
=======
('2015-05-16 23:14');
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a

-- --------------------------------------------------------

--
-- Struttura della tabella `PREPRINTS`
--

CREATE TABLE IF NOT EXISTS `PREPRINTS` (
<<<<<<< HEAD
  `uid` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
  `id_pubblicazione` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data_pubblicazione` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `autori` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `referenze` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `commenti` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `categoria` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `abstract` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
<<<<<<< HEAD
  `Filename` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
=======
  `Bin_data` longblob,
  `Filename` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Filesize` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Filetype` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
  `checked` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `PREPRINTS_ARCHIVIATI`
--

CREATE TABLE IF NOT EXISTS `PREPRINTS_ARCHIVIATI` (
<<<<<<< HEAD
  `uid` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
  `id_pubblicazione` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data_pubblicazione` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `autori` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `referenze` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `commenti` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `categoria` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `abstract` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
<<<<<<< HEAD
  `Filename` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `checked` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `PRINTS`
--

CREATE TABLE IF NOT EXISTS `PRINTS` (
  `uid` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `id_pubblicazione` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `titolo` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `data_pubblicazione` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `autori` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `referenze` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `commenti` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `categoria` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `abstract` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Filename` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
=======
  `Bin_data` longblob,
  `Filename` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Filesize` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `Filetype` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
  `checked` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `sessione`
--

CREATE TABLE IF NOT EXISTS `sessione` (
  `attivo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sessione_data`
--

INSERT INTO `sessione_data` (`data`) VALUES
<<<<<<< HEAD
('20150522');
=======
('20150516');
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a

-- --------------------------------------------------------

--
-- Struttura della tabella `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AUTORI`
--
ALTER TABLE `AUTORI`
 ADD PRIMARY KEY (`nome`);

--
-- Indexes for table `AUTORI_BACKUP`
--
ALTER TABLE `AUTORI_BACKUP`
 ADD PRIMARY KEY (`nome`);

--
-- Indexes for table `DATA_ULTIMO_LANCIO`
--
ALTER TABLE `DATA_ULTIMO_LANCIO`
 ADD PRIMARY KEY (`data`);

--
-- Indexes for table `PREPRINTS`
--
ALTER TABLE `PREPRINTS`
 ADD PRIMARY KEY (`id_pubblicazione`), ADD FULLTEXT KEY `titolo` (`titolo`), ADD FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`), ADD FULLTEXT KEY `data_pubblicazione` (`data_pubblicazione`), ADD FULLTEXT KEY `autori` (`autori`), ADD FULLTEXT KEY `autori_2` (`autori`), ADD FULLTEXT KEY `referenze` (`referenze`), ADD FULLTEXT KEY `commenti` (`commenti`), ADD FULLTEXT KEY `categoria` (`categoria`), ADD FULLTEXT KEY `abstract` (`abstract`), ADD FULLTEXT KEY `id_pubblicazione_2` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`);

--
-- Indexes for table `PREPRINTS_ARCHIVIATI`
--
ALTER TABLE `PREPRINTS_ARCHIVIATI`
 ADD PRIMARY KEY (`id_pubblicazione`), ADD FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`);

--
<<<<<<< HEAD
-- Indexes for table `PRINTS`
--
ALTER TABLE `PRINTS`
 ADD PRIMARY KEY (`id_pubblicazione`), ADD FULLTEXT KEY `id_pubblicazione` (`id_pubblicazione`,`titolo`,`data_pubblicazione`,`autori`,`referenze`,`commenti`,`categoria`,`abstract`);

--
=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
-- Indexes for table `sessione`
--
ALTER TABLE `sessione`
 ADD PRIMARY KEY (`attivo`);

--
-- Indexes for table `sessione_data`
--
ALTER TABLE `sessione_data`
 ADD PRIMARY KEY (`data`);

--
-- Indexes for table `temp`
--
ALTER TABLE `temp`
 ADD PRIMARY KEY (`id`);

<<<<<<< HEAD
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PRINTS`
--
ALTER TABLE `PRINTS`
AUTO_INCREMENT=3;
=======
>>>>>>> 9cac3c0f916efa1df43ac8735e569ea4ba074c9a
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

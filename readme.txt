Guida rapida:


CREARE CARTELLA dmipreprints, INSERIRE IL CONTENUTO PRESENTE SU GITHUB (OPPURE RINOMINARE CARTELLA DmiPreprints_2 IN dmipreprints) E ASSEGNARE I PERMESSI.


CREARE TABELLE ALL'INTERNO DEL DB "dmiprepreprints" CON LE SEGUENTI QUERY:
--------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `PREPRINTS` (
  `id_pubblicazione` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_pubblicazione` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `autori` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `referenze` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `commenti` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoria` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `abstract` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Bin_data` longblob,
  `Filename` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Filesize` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Filetype` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `checked` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pubblicazione`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `PREPRINTS_ARCHIVIATI` (
  `id_pubblicazione` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `titolo` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_pubblicazione` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `autori` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `referenze` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `commenti` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoria` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `abstract` varchar(10000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Bin_data` longblob,
  `Filename` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Filesize` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `Filetype` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `checked` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pubblicazione`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--------------------------------------------------------------------------------


UNA VOLTA APERTO TRAMITE BROWSER ENTRARE NELLA "RESERVED AREA" E EFFETTUARE IL LOGIN CON UN ACCOUNT AMMINISTRATORE. 


ENTRARE IN "arXiv panel"


TESTARE IL "Download", "Displays" e "View".

	View: 	  TI RIPORTA NELL'AREA DOVE PUOI AGGIUNGERE O RIMOUOVERE GLI AUTORI DI CUI TI SCARICHERA' I VARI PREPRINTS

	Download: SE FUNZIONA DOVREBBE SCARICARTI I PDF CHE TROVERAI IN: dmipreprints/arXiv/pdf_downloads E INSERISCE NELLA TABELLA 			  PREPRINTS DEL DB LE RELATIVE INFORMAZIONI. 
	
	Displays: DEVE VISUALIZZARE I PDF PRESENTI NELLA CARTELLA arXiv/pdf_downloads, TRAMITE LA SELEZIONE DELLE CHECKBOX E IL PULSANTE 			  ELIMINA DEVONO ESSERE RIMOSSI SIA I PDF DALLA CARTELLA CHE I RECORD DALLA TABELLA PREPRINTS
	
		  IL BOTTONE INSERT AGGIORNA I RECORD INSERENDO IL PDF(TRAMITE INSERT VERRANNO INSERITI TUTTI I PDF NON ELIMINATI)
		  
		  
		  










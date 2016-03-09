<?php

//file di configurazione
$base_url = "http://localhost/GITHUB/"; //indirizzo 
//configurazione smtp
$send_mail_host = "ssl://smtp.gmail.com"; //host 
$send_mail_port = "465"; //porta
$send_mail_auth = true; //autenticazione
$send_mail_user = "example@gmail.com"; //indirizzo email dal quale verranno mandate le mail
$send_mail_pw = "password"; //password dell'account
//mysql
$hostname_db = "localhost"; //indirizzo database
$db_monte = "dmipreprints"; //nome del database da utilizzare
$username_db = "root"; //l'username database
$password_db = "1234"; //password database
//percorsi cartelle
$copia = "./pdf/"; //cartella dei pdf per i preprint approvati
$basedir = "./upload_dmi/"; //cartella temporanea per upload pdf nella sezione dmi
$basedir2 = "./upload/"; //cartella temporanea per upload pdf nella sezione manual insert
$basedir3 = "./pdf_downloads/"; //cartella temporanea dei pdf per i preprint non approvati
$basedir4 = "./pdf_archived/"; //cartella dei pdf per i preprint archiviati
//ldap
$ldapoff = true; //disattivazione di ldap
$ldaphost = "localhost"; //indirizzo ldap
$ldapport = "389"; //porta ldap
//RADIUS
$ip_radius_server = "192.168.158.130"; //ip server radius
$shared_secret = "radius_secret"; //
//mod uid
$mod_uid = "rz690001"; //
?>

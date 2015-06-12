<?php

#mysql
global $hostname_db;
global $db_monte; //nome del database
global $username_db; //l'username
global $password_db; // password
$hostname_db = "localhost";
$db_monte = "dmipreprints"; //nome del database
$username_db = "root"; //l'username
$password_db = "1234";

#percorsi cartelle
global $copia;
global $basedir;
global $basedir2;
global $basedir3;
global $basedir4;
$copia = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/pdf/";
$basedir = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/upload_dmi/";
$basedir2 = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/upload/";
$basedir3 = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/pdf_downloads/";
$basedir4 = $_SERVER['DOCUMENT_ROOT'] . '/dmipreprints' . "/pdf_archived/";

#ldap
global $ldaphost;
global $ldapport;
$ldaphost = "localhost";
$ldapport = "389";

#RADIUS
global $ip_radius_server;
global $shared_secret;
$ip_radius_server = "192.168.158.130";
$shared_secret = "radius_secret";

#mod uid
global $mod_uid;
$mod_uid = "rz690001";
?>

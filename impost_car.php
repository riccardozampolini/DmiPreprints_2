<?php

$ini_array = parse_ini_file("/etc/dmipreprints/set.ini");

//mysql
$mysql_user = $ini_array['mysql_user']; 
$mysql_pass = $ini_array['mysql_pass'];
$mysql_addr = $ini_array['mysql_addr'];

//ldap
$ldaphost = $ini_array['ldap_host'];
$ldapport = $ini_array['ldap_port'];

//RADIUS
$ip_radius_server = $ini_array['radius_ip'];
$shared_secret = $ini_array['radius_secret'];

//mod uid
$mod_uid = $ini_array['uidMod'];

?>

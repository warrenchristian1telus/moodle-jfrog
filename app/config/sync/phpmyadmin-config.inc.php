<?php

/* Servers configuration */
$i = 0;

$cfg['blowfish_secret'] = 'h]C+{nqW$omNosTIkCwC$%z-LTcy%p6_j$|$Wv[mwngi~|e'; //What you want

// Allow any server
$cfg['AllowArbitraryServer'] = true;

//Checking Active DBMS Servers

//Check if MySQL and MariaDB with MariaDB on default port
$i++;
if($mariaFirst) $i++;
$cfg['Servers'][$i]['verbose'] = 'MySQL';
$cfg['Servers'][$i]['host'] = getenv('DB_HOST');
$cfg['Servers'][$i]['port'] = getenv('DB_PORT');
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = getenv('DB_USER');
$cfg['Servers'][$i]['password'] = getenv('DB_PASSWORD');

// Suppress Warning about pmadb tables
$cfg['PmaNoRelation_DisableWarning'] = true;

// To have PRIMARY & INDEX in table structure export
$cfg['Export']['sql_drop_table'] = true;
$cfg['Export']['sql_if_not_exists'] = true;

$cfg['MySQLManualBase'] = 'http://dev.mysql.com/doc/refman/5.7/en/';
/* End of servers configuration */

$cfg['Servers'] [$i] ['LoginCookieValidity'] = 9223372036854775805;
?>

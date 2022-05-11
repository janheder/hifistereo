<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
session_start();

// nacteni funkci
require('./funkce.php');
// pripojeni k db
require('./db_connect.php');
// dalsi superglobalni promenne z db
globalni_pr();

if($_SESSION['kosik'])
{
	$_SESSION['kosik'][intval($_GET['idp']).'|0|0'] = intval($_GET['pocet']);
	echo "OK";
}
else
{
	echo "Košík je prázdný";
}


?>

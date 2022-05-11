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

			
if($_GET['pocet_strankovani'])
{
  $_SESSION['pocet_strankovani'] = strip_tags($_GET['pocet_strankovani']);
}

header("Location: ".$_SERVER['HTTP_REFERER']);
exit();

?>



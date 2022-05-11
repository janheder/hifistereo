<?
require('./skripty/init.php');
$Stranka = new Stranka($_SESSION['menu_all']);
$Stranka->NactiStranku($_GET['p']);
// ukonceni spojeni
Mysql_close($spojeni);
?>

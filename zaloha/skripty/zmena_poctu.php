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

require('../tridy/kosik.php');


 if($_POST['prepocet'])
 {
	 // zmena poctu zbozi v kosiku
	 $Kosik2 = new Kosik($_SESSION['kosik'],__CENOVA_SKUPINA_SESS__,__SLEV_SK_SESS__);
	 $Kosik2->ZmenPocetVKosiku($_POST);
 }
			


header("Location: /kosik.html");
exit();	

?>
</body>
</html>

<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
// nacteni funkci
require('./funkce.php');
// pripojeni k db
require('./db_connect.php');
// dalsi superglobalni promenne z db
globalni_pr();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="cs" />
<style>

.obal
{
width: auto; 
padding: 10px; 
padding-top: 0px;
font-size: 12px; 
font-family: Arial, Tahoma, Verdana;
color: #626262;	
}

a:link, a:visited
{
color: #1B579F;
text-decoration: underline;
}

a:hover
{
color: #9B2B20;
text-decoration: underline;
}

.cara_seda
{
width: auto;
height: 1px;
font-size: 1px;
border-bottom: solid 1px #D5D5D5;	
}


.r
{
color: red;	
}

.inp
{
float: left;
width: 234px;
height: 28px;
padding-left: 8px;
padding-top: 3px;
color: #626262;
background-color: transparent;
background-image: url('/img/inp.png');
background-position: top left;
background-repeat: no-repeat;
border: 0;
}

</style>
</head>
<body>
<?

echo "<div class=\"obal\">";
echo "<div class='cara_seda'></div><br />";
 

if($_GET['v'])
{	
  
  $result = mysql_query("SELECT * FROM vyrobci WHERE vyrobce='".addslashes(base64_decode($_GET['v']))."'") or die(err(1));
  $row = mysql_fetch_object($result);
  

  echo stripslashes($row->popis);

}
else
{
echo 'Chybí parametry';
}




echo "</div>";
?>
</body>
</html>

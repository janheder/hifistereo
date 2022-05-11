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

a
{
color: #e01c2a;
text-decoration: underline;
}

a:hover
{
color: #006939;
text-decoration: underline;
}

h1
{
font-size: 35px;
color: #5b3605;
font-weight: bold;
text-shadow: 0px 1px 1px #eedbc0;
}

h2
{
font-size: 20px;
color: #464439;
font-weight: bold;
}

h3
{
font-size: 16px;
color: #006939;
font-weight: bold;
}

h4
{
font-size: 12px;
color: #000000;
font-weight: bold;
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
 
	echo __KONTAKT_THICKBOX__;

echo "<br /><div class='cara_seda'></div>";

echo "<div style=\"width: auto\">";


echo "<br />";


echo "<a href=\"#\" onclick=\"self.parent.tb_remove();\">zavřít okno</a>";


echo "</div>";	
echo "</div>";
?>
</body>
</html>

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
font-family: Tahoma, Verdana, Arial;
color: #353535;	
}



.cara_seda
{
width: auto;
height: 1px;
font-size: 1px;
border-bottom: solid 1px #D5D5D5;	
}


obal a:link, a:visited
{
color: #670016;
text-decoration: underline;
}

obal a:hover
{
color: #1F8069;
text-decoration: underline;
}

form, p
{
padding: 0px;
margin: 0px;
}

h1
{
width: auto;
color: #670016;
font-size: 25px; 
font-weight: normal;
}


h2
{
width: auto;
color: #000000;
font-size: 20px; 
font-weight: bold;
padding: 0px;
margin: 0px;
}

h3
{
width: auto;
color: #0A6046;
font-size: 16px; 
font-weight: bold;
padding: 0px;
margin: 0px;
}

h4
{
width: auto;
color: #670016;
font-size: 14px; 
font-weight: bold;
}

h5
{
width: auto;
color: #000000;
font-size: 12px; 
font-weight: bold;
}

</style>
</head>
<?
echo "<div class=\"obal\">";
//echo "<div class='cara_seda'></div>";

	$result = mysql_query("SELECT * FROM reklamni_okno3 WHERE aktivni=1 AND (datum_od<=UNIX_TIMESTAMP() AND datum_do>=UNIX_TIMESTAMP())") or die(err(1));
	 if(mysql_num_rows($result ))
	 {
		$row = MySQL_fetch_object($result);
		
		echo stripslashes($row->obsah);

	    
     }
	 
	 

// prave doslo ke zobrazeni banneru - ulozime cookies aby se nezobrazoval do dalsiho spusteni prohlizece
echo '<script type="text/javascript">';
echo 'document.cookie="banner='.time().'; path=/";';
echo '</script>';

echo "</div>";
mysql_Close($spojeni);
?>
</body>
</html>

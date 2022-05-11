<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
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

//var_dump($_GET);




     // formular
	 echo '<form id="prihlaseni" action="/prihlaseni.html" method="post" target="_parent" >';
	 echo '<table>
	 <tr><td style="width: 180px;">Uživatelské jméno <img src="/img/req.gif" /></td><td>';
	 echo '<input type="text" name="prihlaseni_uz_jm" value="" class="inp" /></td></tr>';
	 echo '<tr><td>Heslo <img src="/img/req.gif" /></td><td>';
	 echo '<input type="password" name="prihlaseni_heslo" value="" class="inp" /></td></tr>';
     echo '<tr><td colspan="2">&nbsp;</td></tr>';
	 echo '<tr><td></td><td>
	 <input type="hidden" name="prihlasit" value="'.md5(time()).'" />
	 <input type="image" name="submit" value="Odeslat" title="Odeslat" src="/img/odeslat.png" /></td></tr></table>';
	 echo '</form>';
	 
 
	

echo "<br /><div class='cara_seda'></div>";

echo "<div style=\"width: auto\">";


echo "<br />";


echo "<a href=\"#\" onclick=\"self.parent.tb_remove();\">zavřít okno</a>";


echo "</div>";	
echo "</div>";
?>
</body>
</html>

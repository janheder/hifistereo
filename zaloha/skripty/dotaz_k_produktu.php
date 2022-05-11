<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
// nacteni funkci
require('./funkce.php');
// pripojeni k db
require('./db_connect.php');
// dalsi superglobalni promenne z db
globalni_pr();
define("__URL__","http://".$_SERVER['SERVER_NAME']);
kontrola_ref();
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
width: 203px;
height: 32px;
line-height: 32px;
padding-left: 10px;
font-size: 11px;
color: #8b8b8b;
background-color: #4f4f4f;
border: 0px;
}

</style>
</head>
<body>
<?
echo "<div class=\"obal\">";
echo "<div class='cara_seda'></div><br />";

//var_dump($_GET);

if($_GET['idp'])
{
	
	$err = false;
	// zpracovani
	if($_POST['submit'])
	{
		
	
		// kontrola vyplneni
		if(!is_email($_POST['email']))
		{
		$err = "Vámi zadaný e-mail je nevalidní<br />";
		}

		if(!$_POST['jmeno'])
		{
		$err .= "Nevyplnili jste jméno<br />";
		}
		
		if(!$_POST['dotaz'])
		{
		$err .= "Nevyplnili jste dotaz<br />";
		}
		
		if($_POST['h'])
		{
		$err .= "Nekorektně vyplněný formulář<br />";
		}
    
	
		if(!$err)
		{ 
		 $headers .= "From:".strip_tags($_POST['email'])."\n";
		 $headers .= "Return-Path :".__EMAIL_1__."\n";
		 $headers .= "Reply-To :".strip_tags($_POST['email'])."\n";
		 $headers .= "MIME-Version: 1.0\n";
		 $headers .= "Content-type: text/plain; charset=utf-8\n";
		 $headers .= "Content-Transfer-Encoding: 8bit\n";
		 $headers .= "X-MSMail-Priority: High\n";
		 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion();
		 
		 $result = mysql_query("SELECT * FROM produkty WHERE id=".intval($_GET['idp'])." ") or die(err(1));
		 $row = mysql_fetch_object($result);

		 
		 $body = "Dotaz k produktu s názvem: ".stripslashes($row->nazev)."\nDotaz: ".strip_tags($_POST['dotaz'])."\n\n_______________________________________________\n\nTento e-mail byl zaslán uživatelem ".strip_tags($_POST['jmeno'])." s emailem: ".strip_tags($_POST['email'])." z internetového obchodu ".__URL__."\nIP adresa uživatele: ".getip();
		 
		  if(!mail(__EMAIL_1__, "Dotaz na produkt z ".__URL__, $body,$headers))
			  {
			  echo "<br /><span class=\"r\"><br />Chyba při odesílání e-mailu<br /></span>";
			  }
			  else
			  {
			   echo 'Váš dotaz byl v pořádku odeslán.<br /><br /><br /><br /><br /><br />';
			  }
		}
		else
		{  // vypis chyb
		  echo "<span class=\"r\">".$err."</span><br />";
		}
	
	
	}
	
	
 if(!$_POST['submit'] || ($_POST['submit'] && $err))
 {

     // formular
	 echo '<form id="dotaz" action="" method="post">';
	 echo '<b>Vaše jméno</b> <img src="/img/req.gif" /><br />';
	 echo '<input type="text" name="jmeno" value="'.strip_tags($_POST['jmeno']).'" style="width: 200px; padding: 3px; border: solid 1px #686868;" />';
	 echo '<div class="clear" style="height: 10px;"></div>';
	 echo '<b>Váš e-mail</b> <img src="/img/req.gif" /><br />';
	 echo '<input type="text" name="email" value="'.strip_tags($_POST['email']).'" style="width: 200px; padding: 3px; border: solid 1px #686868;" />';
	 echo '<div class="clear" style="height: 10px;"></div>';
	 echo '<b>Dotaz</b> <img src="/img/req.gif" /><br />';
	 echo '<textarea name="dotaz" style="width: 450px; height: 150px; padding: 3px; border: solid 1px #686868;"></textarea>
	 <input type="hidden" name="h" value="" />
	 <input type="hidden" name="submit" value="'.md5(time()).'" />
	 <br /><br /><input type="image" name="odeslat" src="/img/odeslat.png" title="Odeslat"  />';
	 echo '</form>';
	 
 }
	
}
else
{	
echo 'Chybí parametry';

}
echo "<br /><div class='cara_seda'></div>";

echo "<div style=\"width: auto\">";


echo "<br />";


echo "<a href=\"#\" onclick=\"self.parent.tb_remove();\">zavřít okno</a>";


echo "</div>";	
echo "</div>";
mysql_Close($spojeni);
?>
</body>
</html>

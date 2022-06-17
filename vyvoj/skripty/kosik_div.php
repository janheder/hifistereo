<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
// nacteni funkci
require('./funkce.php');
// pripojeni k db
require('./db_connect.php');
// dalsi superglobalni promenne z db
globalni_pr();
define("__URL2__","http://www.gramofony-desky.cz");

if($_SESSION['prihlaseni'])
    {  
	list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
	define("__CENOVA_SKUPINA_SESS__",$cenova_skupina_sess); 
	define("__SLEV_SK_SESS__",$sleva_sess);
    }
	else
	{
	define("__CENOVA_SKUPINA_SESS__","A"); 
	define("__SLEV_SK_SESS__",0); 
	}
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
.modal-buttons{
	width: auto;
    padding-top: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
}
.modal-buttons a{
	margin: 5px;
}

@media screen and (max-width: 620px){
	.obal
{
	display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.modal-description{
	display: none;
}

}

</style>
</head>
<body>
<?
echo "<div class=\"obal\">";

$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
 
  $result = mysql_query("SELECT P.id, P.nazev, P.id_dostupnost, P.kat_cislo, P.vyrobce, D.dostupnost, O.nazev AS ONAZ, P.$cena_db as CENA_DB, P.id_dph, DP.dph, P.sleva, P.platnost_slevy
  FROM produkty P 
  LEFT JOIN dostupnost D ON D.id=P.id_dostupnost
  LEFT JOIN obrazky O ON O.idp=P.id 
  LEFT JOIN dph DP ON DP.id=P.id_dph 
  WHERE P.id='".intval($_GET['id_zbozi'])."' AND O.typ=1 GROUP BY P.id") or die(err(1));
  $row = mysql_fetch_object($result);
  
  
    
	 
  
  
  if($row->sleva>0 && ($row->platnost_slevy>time())) 
    {

  	 $cena_s_dph = round(($row->CENA_DB) - ($row->CENA_DB/100*$row->sleva));
 
    
    }
	else
	{
	if(__SLEV_SK_SESS__)
	{

	$cena_s_dph = round(($row->CENA_DB) - ($row->CENA_DB/100 * __SLEV_SK_SESS__));
	}
	else
	{

	$cena_s_dph = round($row->CENA_DB);
	}

	}
  
  
  

echo '<div style="float: left; width: 220px; min-height: 100px; text-align: center;">';
echo '<img src="'.__URL2__.'/img_produkty/stredni/'.$row->ONAZ.'" />';
echo '</div>';
	
  
echo '<div style="float: right; width: 350px;">';  
echo '<div style="width: auto; height: 40px; line-height: 100%; font-size: 20px; padding-left: 15px; background-color: #ffffff">
<b style="font-size: 24px; color: #000000;">'.stripslashes($row->nazev).'</b></div>';
echo '<div class="modal-description"><div style="width: auto; line-height: 1.5; font-size: 14px; padding-left: 15px; background-color: #ffffff; border-bottom: solid 1px #efefef;">
<span style="color: #000000;">Katalogové číslo:</span> '.stripslashes($row->kat_cislo).'</div>';
echo '<div style="width: auto; height: 40px; line-height: 40px; font-size: 14px; padding-left: 15px; background-color: #ffffff; border-bottom: solid 1px #efefef;">
<span style="color: #000000;">Výrobce:</span> '.stripslashes($row->vyrobce).'</div>';

echo '<div style="width: auto; height: 40px; line-height: 40px; font-size: 14px; padding-left: 15px; background-color: #ffffff; border-bottom: solid 1px #efefef;">
<span style="color: #000000;">Dostupnost:</span> '.stripslashes($row->dostupnost).'</div>';
echo '<div style="width: auto; height: 40px; line-height: 40px; font-size: 14px; padding-left: 15px; background-color: #ffffff; border-bottom: solid 1px #efefef;">
<span style="color: #000000;">Cena:</span> 
<span style="font-size: 20px; font-weight: bold; color: #000000;">'.$cena_s_dph.' '.__MENA__.'</span></div>';
echo '</div></div>';



echo "<div class=\"modal-buttons\" style=\"width: auto; padding-top: 20px;\">";
echo "<a href=\"/kosik.html\" target=\"_parent\"><img src=\"/img/pokracovat3.png\" style=\"float: right; border: 0;\"></a>
<a href=\"#\" onclick=\"self.parent.tb_remove();\"><img src=\"/img/dk2.png\" style=\"float: left; border: 0;\"></a>";
echo "</div>";	




echo "</div>";
?>
</body>
</html>

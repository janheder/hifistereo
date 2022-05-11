<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
//ini_set('session.save_path', "./tmp_sess");
session_start();

// definice zakladnich superglobalnich promennych
define("__URL__","https://".$_SERVER['SERVER_NAME']);
define("__URL2__","https://www.gramofony-desky.cz");
define("__SECRET_KEY__","engPd028_W3dXT");
define("__SABLONKY_URL__","./sablonky/");
define("__ADMIN_EMAIL__","robert.hlobilek@w-software.com");
define("__TR_BG__"," onmouseover=\"this.style.background='#E5E5E6'\" onmouseout=\"this.style.background='#ffffff'\" ");
define("__TYP_CEN__",2); // 1 = bez DPH, 2 = s DPH
define("__DEBUG__",1);

if(!$_SESSION['typ_stromu'])
{
$_SESSION['typ_stromu'] = 'kategorie';
}

if(!$_GET['p'])
{
$_GET['p'] = 'uvod';
}

if(!isset($_GET['lang']) || !$_GET['lang'])
{
define("__LANG__","cz");
}
else
{
define("__LANG__",addslashes(strip_tags($_GET['lang'])));
}

// referer
if($_SERVER['HTTP_REFERER'])
{
 $server = "https://".$_SERVER['SERVER_NAME'];
 $referer = $_SERVER['HTTP_REFERER'];

	if(!ereg("^".$server, $referer))
	{
	 // prisel z jinych stranek - ulozime do sesny
	 $_SESSION["referer"] = strip_tags($referer);
	}
}


// nacteni funkci
require('./skripty/funkce.php');

// pripojeni k db
require('./skripty/db_connect.php');


// dalsi superglobalni promenne z db
globalni_pr();

$query_ro = MySQL_Query("SELECT sirka, vyska FROM reklamni_okno4");	
$row_ro = MySQL_fetch_object($query_ro);
define("__SIRKA_OKNA__",$row_ro->sirka);
define("__VYSKA_OKNA__",$row_ro->vyska);

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
	

// pocet aktivnich produktu	
$query_pa = MySQL_Query("SELECT id FROM produkty WHERE aktivni4=1") or die(err(1));
define("__POCET_PRODUKTU__",mysql_num_rows($query_pa));
	
	
// kosik
if($_GET['p']=='kosik')
{
  if($_POST['doprava'])
  {
	  $_SESSION['doprava'] = intval($_POST['doprava']);
  }
  if($_POST['platba'])
  {
	  $_SESSION['platba'] = intval($_POST['platba']);
  }
  if($_POST['dpd_pobocka'])
  {
	  $_SESSION['dpd_pobocka'] = intval($_POST['dpd_pobocka']);
  }
  if($_POST['KTMID'])
  {
	  $_SESSION['KTMID'] = strip_tags($_POST['KTMID']);
  }
  if($_POST['KTMname'])
  {
	  $_SESSION['KTMname'] = strip_tags($_POST['KTMname']);
  }
  if($_POST['KTMaddress'])
  {
	  $_SESSION['KTMaddress'] = strip_tags($_POST['KTMaddress']);
  }
  
  // gls
  if($_POST['gls_name'])
  {
	  $_SESSION['gls_name'] = strip_tags($_POST['gls_name']);
  }
  if($_POST['gls_address'])
  {
	  $_SESSION['gls_address'] = strip_tags($_POST['gls_address']);
  }
  if($_POST['gls_city'])
  {
	  $_SESSION['gls_city'] = strip_tags($_POST['gls_city']);
  }
  if($_POST['gls_zipcode'])
  {
	  $_SESSION['gls_zipcode'] = strip_tags($_POST['gls_zipcode']);
  }
  if($_POST['gls_id'])
  {
	  $_SESSION['gls_id'] = strip_tags($_POST['gls_id']);
  }
  
  
  
  
  if($_POST['poznamka']){$_SESSION['poznamka'] = strip_tags($_POST['poznamka']);}
}

if($_GET['p']=='registrace')
{
	if($_POST['souhlas_ou'])
    {
	  $_SESSION['souhlas_ou'] = strip_tags($_POST['souhlas_ou']);
    }
    
    if($_POST['nl'])
    {
	  $_SESSION['nl'] = strip_tags($_POST['nl']);
    }
}

if($_GET['p']=='bez-registrace')
{
	if($_POST['nl'])
    {
	  $_SESSION['nl'] = strip_tags($_POST['nl']);
    }
}
	

// Menu array 
$menu_db = array();
$query_menu = MySQL_Query("SELECT id, nadpis_menu, url, str FROM stranky4 WHERE aktivni=1 AND lang='".__LANG__."' AND typ=2 ORDER BY razeni, id") or die(err(1));
while($row_menu = mysql_fetch_object($query_menu))
{
$menu_db[$row_menu->str] = stripslashes($row_menu->nadpis_menu);
}

$menu_db_all = array();
$query_menu_all = MySQL_Query("SELECT id, nadpis, url, str FROM stranky4 WHERE aktivni=1 AND lang='".__LANG__."' ORDER BY razeni, id") or die(err(1));
while($row_menu_all = mysql_fetch_object($query_menu_all))
{
$menu_db_all[$row_menu_all->str] = stripslashes($row_menu_all->nadpis);
}

$menu_all = array_merge($menu_db_all, $arr_staticke_str); 


$_SESSION['menu_db'] = $menu_db;
$_SESSION['menu_all'] = $menu_all;
$_SESSION['arr_staty'] = $arr_staty;
$_SESSION['arr_razeni'] = $arr_razeni;
$_SESSION['otazky_as'] = $otazky_as;

// nacteni zakladnich trid + jejich inicializace
require('./tridy/stranky.php');
require('./tridy/sablonky.php');
require('./tridy/strom.php');
require('./tridy/menu.php');
require('./tridy/prihlaseni.php');
require('./tridy/kosik.php');
require('./tridy/seo.php');
//require('./tridy/ZboziKonverze.php');

$Strom = new Strom($_GET['p'],$_GET['skupina'],$_GET['podskupina'],$_GET['podskupina_2'],$_GET['vyr']);
$Strom->PrepniStrom($_GET['ts']);
?>

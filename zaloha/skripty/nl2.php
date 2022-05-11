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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="cs" />
<meta name="description" content="<? echo __TITLE__;?>" />
<meta name="pragma" content="no-cache" />
<meta name="MSSmartTagsPreventParsing" content="true" />
<meta http-equiv="imagetoolbar" content="no" />
<title><? echo __TITLE__;?></title>
<link rel="shortcut icon" href="<? echo __URL__;?>/favicon.ico" type="image/x-icon">
</head>
<body style="font-size: 12px;">
<?
if($_GET['id'])
{
 $result_nl = mysql_query("SELECT * FROM novinky_emailing_sk WHERE id='".intval($_GET['id'])."' ") or die(err(1));
 $row_nl = mysql_fetch_object($result_nl);
 echo stripslashes($row_nl->text);
}
else
{
echo 'Neboli predané potrebné parametre !!';
}
?>
</body>
<?
mysql_Close($spojeni);
?>
</html>

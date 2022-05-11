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

if($_SESSION['prihlaseni'])	
{
list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));

// pokud je IP adresa zakazana zobrazime text a ukoncime
$query_ip = MySQL_Query("SELECT * FROM zakazane_ip WHERE ip='".addslashes(getip())."' ") or die(err(1));
if(mysql_num_rows($query_ip))
{
 echo 'Z IP adresy '.strip_tags(getip()).' je vkládání příspěvků do diskuse zakázáno.';
 die();
}

// ulozeni do db
	if($_POST['text'])
	{
	MySQL_Query("INSERT INTO diskuse
	(id_produktu,id_zakaznik,predmet,jmeno,email,text,datum,ip,browser,aktivni)
	VALUES (
	'".intval($_POST['id_produktu'])."',
	'".intval($id_zak_sess)."',
	'".addslashes(strip_tags($_POST['predmet']))."',
	'".addslashes(strip_tags($_POST['jmeno']))."',
	'".addslashes(strip_tags($_POST['email']))."',
	'".addslashes(strip_tags($_POST['text']))."',
	UNIX_TIMESTAMP(),
	'".getip()."',
	'".addslashes(strip_tags($_SERVER["HTTP_USER_AGENT"]))."',
	1
	)") or die(err(2));


	// email
	 $headers = "From: komentare@spilepe.eu\n";
	 $headers .= "MIME-Version: 1.0\n";
	 $headers .= "Content-type: text/plain; charset=utf-8\n";
	 $headers .= "Content-Transfer-Encoding: 8bit\n";
	 $headers .= "X-MSMail-Priority: High\n";
	 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion();
	 
	 $body = "Komentář: ".strip_tags($_POST['text']);


	 mail(__EMAIL_1__, "Novy komentar na webu ".__URL__, $body,$headers);
	  

	Header('Location: '.$_SERVER['HTTP_REFERER'].'?diskuse=1#diskuse');
	}
	else
	{
	 echo 'Nezadali jste žádný text.';
	}

}
else
{
echo 'Nejste prihlaseni.';
}

mysql_Close($spojeni);
?>

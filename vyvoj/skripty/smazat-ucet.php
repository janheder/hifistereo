<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
setlocale(LC_ALL, 'cs_CZ.UTF-8');
//ini_set('session.save_path', "./tmp_sess");
session_start();


// nacteni funkci
require('./funkce.php');

// pripojeni k db
require('./db_connect.php');


// dalsi superglobalni promenne z db
globalni_pr();


define("__URL__","https://".$_SERVER['SERVER_NAME']);

  if($_SESSION['prihlaseni'])
  {
   
   list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));

    
   
    
    // zjistime jestli ma nejake objednavky
    $result_kontrola = mysql_query("SELECT id FROM objednavky WHERE id_zak='".intval($id_zak_sess)."'") or die(err(1));
	if(!mysql_num_rows($result_kontrola))
	{
		
	    MySQL_Query ("DELETE FROM zakaznici WHERE id='".intval($id_zak_sess)."' ") or die(err(5));
		MySQL_Query ("OPTIMIZE TABLE zakaznici") or die(err(6));
	}
	else
	{
		MySQL_Query ("UPDATE zakaznici SET
		aktivni=0
		WHERE id='".intval($id_zak_sess)."' ")
		or die(err(3));
	} 
	
	// musime ho odhlasit
	unset($_SESSION['prihlaseni']);
	
	echo 'Vas ucet byl kompletne vymazan z nasich databazi. Pokracovat na <a href="'.__URL__.'">homepage</a>.';
  
  }
  else
  {
	  echo 'Aktualne nejste prihlaseni. Pro smazani uctu se musíte nejdrive prihlasit';
  }
?>

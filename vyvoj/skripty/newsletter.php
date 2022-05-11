<?
$newsletter_t = '';

if($_POST['newsletter_email'] && ($_POST['prihlasit'] || $_POST['odhlasit']) )
{
 if(!is_email($_POST['newsletter_email']))
  {
	$newsletter_t = '<br /><span class="r">Zadali jste nekorektní e-mailovou adresu.</span>';	  
  }
  elseif(!$_POST['souhlas'])
  {
	$newsletter_t = '<br /><span class="r">Nesouhlasili jste s podmínkami zpracování osobních údajů.</span>';	  
  }
  else
  {
	if($_POST['prihlasit']) 
	{
	// ulozime emailovou adresu do databaze a vygenerujeme informacni email	s odkazem na vyrazeni z databaze
	
	// overime jestli jiz neni zaregistrovan
	$result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".sanitize(trim($_POST['newsletter_email']))."'") or die(err(1));
	if(mysql_num_rows($result_kontrola))
	{
	 $newsletter_t = "<br /><span class=\"r\"><br />E-mailová adresa ".sanitize($_POST['newsletter_email'])." se již v naší databázi nachází.</span>"; 
	}
	else
	{
	
	/*
	 MySQL_Query("INSERT INTO newsletter
	  (id,email,datum,ip,typ,aktivni)
	  VALUES ('',
	  '".sanitize(trim($_POST['newsletter_email']))."',
	  UNIX_TIMESTAMP(),
	  '".addslashes(getip())."',
	  '3',0)") or die(err(2));
	  
	  $id_new = mysql_insert_id();
	  
	  
	     $headers = "From:".__EMAIL_1__."\n";
		 $headers .= "Return-Path :".__EMAIL_1__."\n";
		 $headers .= "Reply-To :".__EMAIL_1__."\n";
		 $headers .= "MIME-Version: 1.0\n";
		 $headers .= "Content-type: text/plain; charset=utf-8\n";
		 $headers .= "Content-Transfer-Encoding: 8bit\n";
		 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion();
		 
		 $body = "Vážený návštěvníku,\nděkujeme za registraci vašeho e-mailu ".sanitize($_POST['newsletter_email'])." pro odběr našeho newsletteru z webu ".__URL__."\nPro dokončení registrace klikněte prosím zde na tento odkaz: ".__URL__."/newsletter.html?dokonceni=1&hx=".base64_encode(strip_tags($_POST['newsletter_email'])."|".$id_new)."\n\nPokud se budete chtít z odebírání newsletteru odhlásit, pak navštivte náš web ".__URL__." a v levém sloupci zadejte svou e-mailovou adresu a klikněte na tlačítko 'odhlásit' nebo klikněte na tento odkaz: ".__URL__."/newsletter.html?hash=".base64_encode(sanitize($_POST['newsletter_email'])."|".$id_new);
		 
		  if(!mail(sanitize($_POST['newsletter_email']), "Registrace newsletteru na ".__URL__, $body,$headers))
		  {
		  $newsletter_t = "<br /><span class=\"r\"><br />Chyba při odesílání e-mailu</span>";
		  }
		  else
		  {*/
		  $newsletter_t = "<br /><span class=\"r\">Uloženo. Vaše registrace newsletteru proběhla v pořádku a 
		  na e-mail <b>".sanitize($_POST['newsletter_email'])."</b> byl zaslán informační e-mail i s odkazem na potvrzení registrace případně na zrušení zasílání.</span>";
		 // }
	  }
	  
	}
	if($_POST['odhlasit']) 
	{
		MySQL_Query ("DELETE FROM newsletter WHERE email='".sanitize($_POST['newsletter_email'])."' LIMIT 1") or die(err(5));
		
		if(mysql_affected_rows())
		 {
			 $newsletter_t =  "<br /><span class=\"r\"><br />E-mailová adresa ".sanitize($_POST['newsletter_email'])." byla smazána z naší databáze.</span>"; 
		 }
		
        MySQL_Query ("OPTIMIZE TABLE newsletter") or die(err(6));
	}
	 
	  
  }	
}
elseif($_GET['hash'])
{
 // smazeme uzivatele ktery klikl na odkaz v info mailu
 list($eml,$idz) = explode("|",base64_decode($_GET['hash']));
 
       MySQL_Query ("DELETE FROM newsletter WHERE email='".addslashes($eml)."' AND id=".intval($idz)." LIMIT 1") or die(err(5));
		
		if(mysql_affected_rows())
		 {
			 $newsletter_t =  "<br /><span class=\"r\"><br />E-mailová adresa ".strip_tags($eml)." byla smazána z naší databáze.</span>"; 
		 }
		
        MySQL_Query ("OPTIMIZE TABLE newsletter") or die(err(6));
	
}
elseif($_GET['dokonceni']==1)
{
	// aktivujeme
	list($eml,$idz) = explode("|",base64_decode($_GET['hx']));	
	
	MySQL_Query ("UPDATE newsletter SET
	aktivni=1
	WHERE  email='".addslashes($eml)."' AND id=".intval($idz)." ") or die(err(3));
	
	$newsletter_t .= 'Registrace Vašeho emailu pro příjem newsletteru byla dokončena.';
		
}
else
{
 $newsletter_t =  '<br /><span class="r">Chybí parametry.</span>';	
}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Newsletter','html');
 $Sablonka->PridejDoSablonky('[obsah]',$newsletter_t,'html');
echo $Sablonka->GenerujSablonku('default');
?>

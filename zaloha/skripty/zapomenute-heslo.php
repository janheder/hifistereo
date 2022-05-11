<?
// zap. heslo

$zaslat_heslo = "<div style=\"width: 50%; margin-left: auto; margin-right: auto;\">
<form name=\"heslo\" method=\"post\" action=\"\" >
Pokud jste heslo zapomněli, můžeme Vám na Váš e-mail, který jste uvedli při registraci, zaslat nové vygenerované heslo.
<div class=\"clear\" style=\"height: 10px;\"></div>
<div class=\"form_text\">Zadejte svůj e-mail: <img src=\"/img/req.gif\" /></div><input type=\"text\" name=\"email_z\" value=\"\" class=\"form_inp\" />
<div class=\"clear\" style=\"height: 10px;\"></div>
<div class=\"clear\" style=\"height: 10px;\"></div>
<input type=\"submit\" name=\"submit\" value=\"Zaslat heslo\" title=\"Zaslat heslo\" class=\"submit_but\" />
</form></div>";  

if($_POST['email_z'])
{
		$err = false;
		// zpracovani

		// kontrola vyplneni
		if(!$_POST['email_z'])
		{
		$err .= "Nevyplnili jste e-mail<br />";
		}

		if($err)
		{
		$zaslat_heslo .= "<br /><br /><span class='r'>".$err."</span><br />";
		}
		else
		{
			kontrola_ref();

			$count = 8;
			$chars = 62;
			$return = "";
				for ($i=0; $i < $count; $i++) 
				{
				$rand = rand(0, $chars - 1);
				$return .= chr($rand + ($rand < 10 ? ord('0') : ($rand < 36 ? ord('a') - 10 : ord('A') - 36)));
				}




			// ulozeni do db

			$query_kontrola = MySQL_Query("UPDATE zakaznici SET
			heslo='".md5($return)."'
			WHERE eml='".addslashes($_POST['email_z'])."' AND uz_jm!='bez registrace' LIMIT 1") or die(err(3));

			if(mysql_affected_rows())
			{
			// odeslani emailu uzivateli

			$query_uz_jm = MySQL_Query("SELECT uz_jm FROM zakaznici WHERE  eml='".addslashes($_POST['email_z'])."' AND uz_jm!='bez registrace' LIMIT 1") or die(err(1));
			$row_uz_jm = mysql_fetch_object($query_uz_jm);

			 $headers = "From:".__EMAIL_1__."\n";
			 $headers .= "Return-Path :".__EMAIL_1__."\n";
			 $headers .= "Reply-To :".__EMAIL_1__."\n";
			 $headers .= "MIME-Version: 1.0\n";
			 $headers .= "Content-type: text/plain; charset=utf-8\n";
			 $headers .= "Content-Transfer-Encoding: 8bit\n";
			 $headers .= "X-MSMail-Priority: High\n";
			 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion();

			 $body = "Na webu ".__URL__." jste právě požádali o vygenerování nového hesla.\nVaše uživatelské jméno: ".$row_uz_jm->uz_jm."\nNové heslo: $return";

			 if(!mail(strip_tags($_POST['email_z']), "Nove heslo", $body,$headers))
			  {
			  $zaslat_heslo .= "<span class=\"r\"><br />Chyba při odesílání e-mailu<br /></span>";
			  exit();
			  }
			$zaslat_heslo .= "<br />Na adresu <b>".sanitize($_POST['email_z'])."</b> bylo právě odesláno nově vygenerované heslo.";	
			}
			else
			{
			$zaslat_heslo .= "<br /><span class=\"r\">Vámi zadané údaje nejsou správné!</span>";
			}

		}
}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Zapomenuté heslo','html');
 $Sablonka->PridejDoSablonky('[obsah]',$zaslat_heslo,'html');
echo $Sablonka->GenerujSablonku('default');
?>

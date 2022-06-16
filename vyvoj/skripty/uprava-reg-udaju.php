<?
$uprava_t = '';

if($_SESSION['prihlaseni'])
{
list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));

$err = false;
// zpracovani
if($_POST['pokracovat_1'])
{
// kontrola vyplneni
if(!is_email($_POST['eml']))
{
$err = "Vámi zadaný e-mail je nevalidní<br />";
}

if(!$_POST['jmeno'])
{
$err .= "Nevyplnili jste jméno<br />";
}

if(!$_POST['prijmeni'])
{
$err .= "Nevyplnili jste příjmení<br />";
}

if(!$_POST['uz_jm'])
{
$err .= "Nevyplnili jste uživatelské jméno<br />";
}

if(!$_POST['heslo'])
{
$err .= "Nevyplnili jste heslo<br />";
}

if($_POST['heslo']!=$_POST['heslo2'])
{
$err .= "Heslo a potvrzení hesla se neshodují<br />";
}

if(!$_POST['obec'])
{
$err .= "Nevyplnili jste obec<br />";
}

if(!$_POST['ulice'])
{
$err .= "Nevyplnili jste ulici<br />";
}


if(!$_POST['cislo'])
{
$err .= "Nevyplnili jste číslo popisné<br />";
}

if(!$_POST['psc'])
{
$err .= "Nevyplnili jste číslo PSČ<br />";
}








		if(!$err)
		{
		$ip_adr = getip();
		// kontakt /////////////////////////////////////////////////////////////////////

		MySQL_Query ("UPDATE zakaznici SET

		uz_jm='".addslashes($_POST['uz_jm'])."',
		heslo='".md5($_POST['heslo'])."',
		jmeno='".addslashes($_POST['jmeno'])."',
		prijmeni='".addslashes($_POST['prijmeni'])."',
		eml='".addslashes($_POST['eml'])."',
		obec='".addslashes($_POST['obec'])."',
		cislo='".addslashes($_POST['cislo'])."',
		ulice='".addslashes($_POST['ulice'])."',
		psc='".addslashes($_POST['psc'])."',
		stat='".intval($_POST['stat'])."',
		telefon='".addslashes($_POST['telefon'])."',
		reg_fak_ico='".addslashes($_POST['reg_fak_ico'])."',
		reg_fak_dic='".addslashes($_POST['reg_fak_dic'])."',
		reg_fak_nazev_firmy='".addslashes($_POST['reg_fak_nazev_firmy'])."',
		reg_fak_jmeno_prijmeni='".addslashes($_POST['reg_fak_jmeno_prijmeni'])."',
		reg_fak_obec='".addslashes($_POST['reg_fak_obec'])."',
		reg_fak_ulice='".addslashes($_POST['reg_fak_ulice'])."',
		reg_fak_cislo='".addslashes($_POST['reg_fak_cislo'])."',
		reg_fak_psc='".addslashes($_POST['reg_fak_psc'])."',
		reg_dod_jmeno_prijmeni='".addslashes($_POST['reg_dod_jmeno_prijmeni'])."',
		reg_dod_nazev_firmy='".addslashes($_POST['reg_dod_nazev_firmy'])."',
		reg_dod_obec='".addslashes($_POST['reg_dod_obec'])."',
		reg_dod_ulice='".addslashes($_POST['reg_dod_ulice'])."',
		reg_dod_cislo='".addslashes($_POST['reg_dod_cislo'])."',
		reg_dod_psc='".addslashes($_POST['reg_dod_psc'])."',
		reg_dod_stat='".intval($_POST['reg_dod_stat'])."',
		datum=UNIX_TIMESTAMP(),
		ip='$ip_adr',
		nl='".intval($_POST['nl'])."'
		WHERE uz_jm='".addslashes($uz_jm_sess)."' AND heslo='".addslashes($heslo_sess)."'")
		or die(err(3));
		
		
		
		if($_POST['nl']==1)
	    {
			$nl = 'ANO';
			// zkontrolujeme jestli je v newsletteru, pokud ne tak pridame
			$result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".addslashes(trim($_POST['eml']))."'") or die(err(1));
			if(!mysql_num_rows($result_kontrola))
			{
	
					 MySQL_Query("INSERT INTO newsletter
					  (id,email,datum,ip,typ,aktivni)
					  VALUES ('',
					  '".addslashes(trim($_POST['eml']))."',
					  UNIX_TIMESTAMP(),
					  '".addslashes(getip())."',
					  '2',
					  1
					  
					  )") or die(err(2));
		       
		    }
	    
		}
		else
		{
			$nl = 'NE';
			// smazeme z newsletteru
			MySQL_Query ("DELETE FROM newsletter WHERE email='".addslashes($_POST['eml'])."' ") or die(err(5));
			MySQL_Query ("OPTIMIZE TABLE newsletter") or die(err(6));
		}

		// odeslani emailu uzivateli s rekapitulaci zadanych udaju

		 $headers = "From:".__EMAIL_1__."\n";
		 $headers .= "Return-Path :".__EMAIL_1__."\n";
		 $headers .= "Reply-To :".__EMAIL_1__."\n";
		 $headers .= "MIME-Version: 1.0\n";
		 $headers .= "Content-type: text/plain; charset=utf-8\n";
		 $headers .= "Content-Transfer-Encoding: 8bit\n";
		 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion()."\n";
		// $headers .= "bcc:".__EMAIL_4__."\n"; // BCC
		 
		 $body = "Datum úpravy registrace: ".date("d.m.Y H:i:s")."\nJméno: ".strip_tags($_POST['jmeno'])."\nPříjmení: ".strip_tags($_POST['prijmeni'])."\nUž. jméno: ".strip_tags($_POST['uz_jm'])."\nHeslo: ".strip_tags($_POST['heslo'])."\nE-mail: ".strip_tags($_POST['eml'])."\nObec: ".strip_tags($_POST['obec'])."\nUlice: ".strip_tags($_POST['ulice'])." číslo: ".strip_tags($_POST['cislo'])."\nPSČ: ".strip_tags($_POST['psc'])."\nStát: ".strip_tags($_POST['stat'])."\nTelefon: ".strip_tags($_POST['telefon']);




		if($_POST['jina_fakturacni'])
		{
		 $body .= "\n\nFakturační adresa:\nIČO: ".strip_tags($_POST['reg_fak_ico'])."\nDIČ: ".strip_tags($_POST['reg_fak_dic'])."\nNázev firmy: ".strip_tags($_POST['reg_fak_nazev_firmy'])."\nJméno a příjmení: ".strip_tags($_POST['reg_fak_jmeno_prijmeni'])."\nObec: ".strip_tags($_POST['reg_fak_obec'])."\nUlice: ".strip_tags($_POST['reg_fak_ulice'])." číslo: ".strip_tags($_POST['reg_fak_cislo'])."\nPSČ: ".strip_tags($_POST['reg_fak_psc'])."\n\n";
		}

		if($_POST['jina_dodaci'])
		{
		 $body .= "\n\nDodací adresa:\nJméno a příjmení: ".strip_tags($_POST['reg_dod_jmeno_prijmeni'])."\nNázev firmy: ".strip_tags($_POST['reg_dod_nazev_firmy'])."\nObec: ".strip_tags($_POST['reg_dod_obec'])."\nUlice: ".strip_tags($_POST['reg_dod_ulice'])." číslo: ".strip_tags($_POST['reg_dod_cislo'])."\nPSČ: ".strip_tags($_POST['reg_dod_psc'])."\nStát: ".strip_tags($_POST['reg_dod_stat'])."\n\n";
		}


		 if(!mail(strip_tags($_POST['eml']), "Uprava registrace na ".__URL__, $body,$headers))
		  {
		  $uprava_t .= "<span class=\"r\"><br />Chyba při odesílání e-mailu<br /></span>";
		  }
		  else
		  {
		   $uprava_t .= "<br /><span class=\"r\">Uloženo.</span>";
		  }
		}
		else
		{  // vypis chyb
		$uprava_t .= "<br /><span class=\"r\">".$err."</span><br />";
		}
}

if(!$_POST['pokracovat_1'] || ($_POST['pokracovat_1'] && $err))
{

 
$query_kontrola = MySQL_Query("SELECT * FROM zakaznici WHERE uz_jm='".addslashes($uz_jm_sess)."' AND heslo='".addslashes($heslo_sess)."'") or die(err(1));
$row_kontrola  = MySQL_fetch_object($query_kontrola);
 
$uprava_t .= "<br /><br /><img src=\"/img/req2.png\" /> - takto označené položky musí být vyplněny.<br /><br />";



 
 $uprava_t .= "<form name=\"reg\" method=\"post\">
 <table class=\"noborder\" width=\"99%\" cellpadding=\"5\" cellspacing=\"1\" 
 style=\"margin-left: auto; margin-right: auto;\">";

  $uprava_t .= "<tr><td  ><div class=\"form_text\">Jméno </div><input type=\"text\" name=\"jmeno\" maxlength=\"60\"   value=\"".$row_kontrola->jmeno."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";
 
   $uprava_t .= "<tr><td  ><div class=\"form_text\">Příjmení</div><input type=\"text\" name=\"prijmeni\" maxlength=\"60\"   value=\"".$row_kontrola->prijmeni."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";
 
 
   $uprava_t .= "<tr><td  ><div class=\"form_text\">Uživatelské jméno</div><input type=\"text\" name=\"uz_jm\" maxlength=\"60\"   value=\"".$row_kontrola->uz_jm."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";

   $uprava_t .= "<tr><td  ><div class=\"form_text\">Heslo</div><input type=\"password\" name=\"heslo\" maxlength=\"60\"  value=\"\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" /> 
 </td></tr>";
 
    $uprava_t .= "<tr><td  ><div class=\"form_text\">Potvrzení hesla</div><input type=\"password\" name=\"heslo2\" maxlength=\"60\"   value=\"\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";


   $uprava_t .= "<tr><td w ><div class=\"form_text\">E-mail</div><input type=\"text\" name=\"eml\" maxlength=\"60\"  value=\"".$row_kontrola->eml."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";

   $uprava_t .= "<tr><td  ><div class=\"form_text\">Obec</div><input type=\"text\" name=\"obec\" maxlength=\"60\"  value=\"".$row_kontrola->obec."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" /> 
 </td></tr>
 <tr><td >
 <div class=\"form_text\">PSČ</div><input type=\"text\" name=\"psc\" maxlength=\"60\"   value=\"".$row_kontrola->psc."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";

   $uprava_t .= "<tr><td  ><div class=\"form_text\">Ulice</div><input type=\"text\" name=\"ulice\" maxlength=\"60\"  value=\"".$row_kontrola->ulice."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>
 <tr><td >
  <div class=\"form_text\">číslo</div><input type=\"text\" name=\"cislo\" maxlength=\"60\"   value=\"".$row_kontrola->cislo."\" class=\"form_inp\"/><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";

    $uprava_t .= "<tr><td ><div class=\"form_text\">Stát</div><select name=\"stat\" size=\"1\" style=\"float: left;
width: 350px;
height: 44px;
line-height: 44px;
padding-left: 20px;
font-size: 14px;
background-color: #ffffff;
border: solid 1px #dadada;\" >";
 foreach($_SESSION['arr_staty'] as $key_stat => $value_stat)
  {
   $uprava_t .= "<option value=\"".$key_stat."\" ";
   if($row_kontrola->stat==$key_stat) { $uprava_t .= " selected "; }
   $uprava_t .=  ">".$value_stat."</option>";
  }
 
 $uprava_t .=  "</select><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";



    $uprava_t .=  "<tr><td><div class=\"form_text\">Telefon</div><input type=\"text\" name=\"telefon\" maxlength=\"60\"   value=\"".$row_kontrola->telefon."\" class=\"form_inp\" /><img src=\"/img/req2.png\" style=\"margin-left: 10px;\" />
 </td></tr>";
$uprava_t .=  '<tr><td colspan="2">&nbsp;</td></tr>';

$uprava_t .=  '<tr><td colspan="2">
<a name="dod_adr"></a><div style="display: block; width: auto; padding: 5px; margin-bottom: 5px;" id="dod_adresa"><strong>Dodací adresa:</strong><br />
<table class="noborder" style="margin-left: auto; margin-right: auto;" width="100%">
<tr><td  width="29%"><div class="form_text">Jméno a příjmení:</div><input type="text" name="reg_dod_jmeno_prijmeni" maxlength="50"   
 value="'.$row_kontrola->reg_dod_jmeno_prijmeni.'" class="form_inp"/>
<tr><td ><div class="form_text">Název firmy:</div><input type="text" name="reg_dod_nazev_firmy" maxlength="50"   value="'.$row_kontrola->reg_dod_nazev_firmy.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Obec:</div><input type="text" name="reg_dod_obec" maxlength="50"   
value="'.$row_kontrola->reg_dod_obec.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Ulice:</div><input type="text" name="reg_dod_ulice" maxlength="50"   
 value="'.$row_kontrola->reg_dod_ulice.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Číslo popisné:</div><input type="text" name="reg_dod_cislo" maxlength="20"  
 value="'.$row_kontrola->reg_dod_cislo.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">PSČ:</div><input type="text" name="reg_dod_psc" maxlength="50"  
value="'.$row_kontrola->reg_dod_psc.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Stát:</div>';

$uprava_t .=  "<select name=\"reg_dod_stat\" size=\"1\" style=\"float: left;
width: 350px;
height: 44px;
line-height: 44px;
padding-left: 20px;
font-size: 14px;
background-color: #ffffff;
border: solid 1px #dadada;\" >";
 foreach($_SESSION['arr_staty'] as $key_stat => $value_stat)
  {
   $uprava_t .=  "<option value=\"".$key_stat."\" ";
   if($row_kontrola->reg_dod_stat==$key_stat) { $uprava_t .= " selected "; }
   $uprava_t .=  ">".$value_stat."</option>";
  }
 
 $uprava_t .=  "</select>";

$uprava_t .=  '</td></tr>
</table>
</div>
<a name="fak_adr"></a><div style="display: block; width: auto; padding: 5px;" id="fak_adresa"><strong>Fakturační adresa:</strong><br />Vyplňte pouze pokud nakupujete na firmu.
<table class="noborder" style="margin-left: auto; margin-right: auto;" width="100%">
<tr><td><div class="form_text">Jméno a příjmení:</div><input type="text" name="reg_fak_jmeno_prijmeni" maxlength="50"  value="'.$row_kontrola->reg_fak_jmeno_prijmeni.'"  class="form_inp"/></td></tr>

<tr><td ><div class="form_text">Název firmy:</div><input type="text" name="reg_fak_nazev_firmy" maxlength="50"  
  value="'.$row_kontrola->reg_fak_nazev_firmy.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">DIČ:</div><input type="text" name="reg_fak_dic" maxlength="50"   value="'.$row_kontrola->reg_fak_dic.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">IČO:</div><input type="text" name="reg_fak_ico" maxlength="50"   
value="'.$row_kontrola->reg_fak_ico.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Obec:</div><input type="text" name="reg_fak_obec" maxlength="50"   
 value="'.$row_kontrola->reg_fak_obec.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Ulice:</div><input type="text" name="reg_fak_ulice" maxlength="50"   
 value="'.$row_kontrola->reg_fak_ulice.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">Číslo popisné:</div><input type="text" name="reg_fak_cislo" maxlength="20" 
 value="'.$row_kontrola->reg_fak_cislo.'" class="form_inp"/></td></tr>
<tr><td ><div class="form_text">PSČ:</div><input type="text" name="reg_fak_psc" maxlength="50"  
value="'.$row_kontrola->reg_fak_psc.'" class="form_inp"/></td></tr>
</table>
</div>
</td></tr>';




$uprava_t .= '<tr><td colspan="2" ><div class="checkbox-field"><input name="nl"   type="checkbox" value="1" ';
                            
                            $result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".addslashes(trim($row_kontrola->eml))."'") or die(err(1));
							if(mysql_num_rows($result_kontrola))
							{
								$uprava_t .= ' checked ';
							}
                            
                            $uprava_t .= '> <label>'.__KOSIK_NL_TEXT__.'</label></div></td></tr>';




$uprava_t .= '<tr><td colspan="2" ><a href="/skripty/smazat-ucet.php" 
onClick="if(confirm(\'Opravdu chcete nenávratně smazat svůj účet?\'))
return true;
else return false;" style=\"font-size: 14px; font-weight: bold;">SMAZAT ÚČET</a> - Kompletně zrušit účet a smazat všechny mé data.</td></tr>';


$uprava_t .=  "<tr><td colspan=\"2\" align=\"center\">
<br />
<input type=\"hidden\" name=\"pokracovat_1\" value=\"Registrovat\" />
<input type=\"submit\" name=\"submit\" value=\"Odeslat\" title=\"Odeslat\" class=\"submit_but\" />
</td></tr>";
$uprava_t .=  "</table></form><br /><br />";

}

}
else
{
$uprava_t .=  '<br /><br />Nejste přihlášeni<br /><br /><br /><br /><br /><br />';
}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Úprava registračních údajů','html');
 $Sablonka->PridejDoSablonky('[obsah]',$uprava_t,'html');
echo $Sablonka->GenerujSablonku('default');
?>

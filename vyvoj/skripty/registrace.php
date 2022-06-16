<?
$registrace_t = '';
//$registrace_t .= '<img src="/img/pruchod_kosikem_krok_2.png" alt="4.krok ze 4" /><br /><br />';

$err = false;
// zpracovani
if($_POST['pokracovat_1'])
{
// kontrola vyplneni
if(!is_email($_POST['eml']))
{
$err .= "Vámi zadaný e-mail je nevalidní<br />";
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

if(!$_POST['telefon'])
{
$err .= "Nevyplnili jste telefon<br />";
}

if(!$_POST['souhlas_ou'])
{
$err .= "Nesouhlasili jste se zpracováním osobních údajů. Pokud nechcete souhlasit se zpracováním osobních údajů, pak proveďte objednávku bez registrace.<br />";
}

if($_POST['jina_dodaci'])
{
 if(!$_POST['reg_dod_jmeno_prijmeni'])
 {
  $err .= "Nevyplnili jste jméno a příjmení u dodací adresy<br />";
 }
 if(!$_POST['reg_dod_obec'])
 {
  $err .= "Nevyplnili jste obec u dodací adresy<br />";
 }
 if(!$_POST['reg_dod_ulice'])
 {
  $err .= "Nevyplnili jste ulici u dodací adresy<br />";
 }
 if(!$_POST['reg_dod_cislo'])
 {
  $err .= "Nevyplnili jste číslo u dodací adresy<br />";
 }
 if(!$_POST['reg_dod_psc'])
 {
  $err .= "Nevyplnili jste PSČ u dodací adresy<br />";
 }

}


if($_POST['jina_fakturacni'])
{
 if(!$_POST['reg_fak_nazev_firmy'])
 {
  $err .= "Nevyplnili jste název firmy u fakturační adresy<br />";
 }
 if(!$_POST['reg_fak_obec'])
 {
  $err .= "Nevyplnili jste obec u fakturační adresy<br />";
 }
 if(!$_POST['reg_fak_ulice'])
 {
  $err .= "Nevyplnili jste ulici u fakturační adresy<br />";
 }
 if(!$_POST['reg_fak_cislo'])
 {
  $err .= "Nevyplnili jste číslo u fakturační adresy<br />";
 }
 if(!$_POST['reg_fak_psc'])
 {
  $err .= "Nevyplnili jste PSČ u fakturační adresy<br />";
 }
 if(!$_POST['reg_fak_ico'])
 {
  $err .= "Nevyplnili jste IČO u fakturační adresy<br />";
 }
}


	//antispam
	if(!strip_tags($_POST['as_hlog_k']) || !strip_tags($_POST['as_hlog_v']))
	{
	$err .= "Nevyplnili jste kontrolní otázku<br />";
	}
	
	if(!array_key_exists(strip_tags($_POST['as_hlog_k']), $_SESSION['otazky_as']))
	{
	$err .= "Chybně vyplněná kontrolní otázka<br />";
	}
	
	foreach ($_SESSION['otazky_as'] as $key => $value)
	{
		if($key==strip_tags($_POST['as_hlog_k']) && $value!=strip_tags($_POST['as_hlog_v']))
		{
		$err .= "Chybně vyplněná kontrolní otázka<br />";
		}
	}
	
	
// kontrola uzivatele, jestli uz neni zaregistrovan (podle uz.jm)
$query_kontrola = MySQL_Query("SELECT id FROM zakaznici WHERE uz_jm='".addslashes($_POST['uz_jm'])."'") or die(err(1));
if(mysql_num_rows($query_kontrola))
{
$err .= "Uživatel s uživatelským jménem <b>".strip_tags($_POST['uz_jm'])."</b> je ji zaregistrován, vyberte prosím jiné.<br />";
}

if(!$err)
{
$ip_adr = getip();
// kontakt /////////////////////////////////////////////////////////////////////
MySQL_Query("INSERT INTO zakaznici
(id,uz_jm,heslo,jmeno,prijmeni,eml,obec,cislo,ulice,psc,stat,telefon,reg_fak_ico,reg_fak_dic,reg_fak_nazev_firmy,reg_fak_jmeno_prijmeni,reg_fak_obec,reg_fak_ulice,reg_fak_cislo,
reg_fak_psc,reg_dod_jmeno_prijmeni,reg_dod_nazev_firmy,reg_dod_obec,reg_dod_ulice,reg_dod_cislo,reg_dod_psc,reg_dod_stat,datum,aktivni,id_skupiny_slev,cenova_skupina,ip,eshop,nl,souhlas_ou)
VALUES ('',
'".addslashes(strip_tags($_POST['uz_jm']))."',
'".md5($_POST['heslo'])."',
'".addslashes(strip_tags($_POST['jmeno']))."',
'".addslashes(strip_tags($_POST['prijmeni']))."',
'".addslashes(strip_tags($_POST['eml']))."',
'".addslashes(strip_tags($_POST['obec']))."',
'".addslashes(strip_tags($_POST['cislo']))."',
'".addslashes(strip_tags($_POST['ulice']))."',
'".addslashes(strip_tags($_POST['psc']))."',
'".intval($_POST['stat'])."',
'".addslashes(strip_tags($_POST['telefon']))."',
'".addslashes(strip_tags($_POST['reg_fak_ico']))."',
'".addslashes(strip_tags($_POST['reg_fak_dic']))."',
'".addslashes(strip_tags($_POST['reg_fak_nazev_firmy']))."',
'".addslashes(strip_tags($_POST['reg_fak_jmeno_prijmeni']))."',
'".addslashes(strip_tags($_POST['reg_fak_obec']))."',
'".addslashes(strip_tags($_POST['reg_fak_ulice']))."',
'".addslashes(strip_tags($_POST['reg_fak_cislo']))."',
'".addslashes(strip_tags($_POST['reg_fak_psc']))."',
'".addslashes(strip_tags($_POST['reg_dod_jmeno_prijmeni']))."',
'".addslashes(strip_tags($_POST['reg_dod_nazev_firmy']))."',
'".addslashes(strip_tags($_POST['reg_dod_obec']))."',
'".addslashes(strip_tags($_POST['reg_dod_ulice']))."',
'".addslashes(strip_tags($_POST['reg_dod_cislo']))."',
'".addslashes(strip_tags($_POST['reg_dod_psc']))."',
'".intval($_POST['reg_dod_stat'])."',
UNIX_TIMESTAMP(),
'0',
'0',
'A',
'$ip_adr',3,
'".intval($_POST['nl'])."',
'".intval($_POST['souhlas_ou'])."'
)") or die(err(2));


$last_id = mysql_insert_id();

/*
// ulozime i do newsletteru
$result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".addslashes(trim($_POST['eml']))."'") or die(err(1));
	if(!mysql_num_rows($result_kontrola))
	{

	 MySQL_Query("INSERT INTO newsletter
	  (id,email,datum,ip,typ)
	  VALUES ('',
	  '".addslashes(trim($_POST['eml']))."',
	  UNIX_TIMESTAMP(),
	  '".addslashes(getip())."',
	  '1')") or die(err(2));
    }
*/


// ulozime i do newsletteru
if($_POST['nl'])
{
$result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".addslashes(trim($_POST['eml']))."'") or die(err(1));
	if(!mysql_num_rows($result_kontrola))
	{

	 MySQL_Query("INSERT INTO newsletter
	  (id,email,datum,ip,typ,aktivni)
	  VALUES ('',
	  '".addslashes(trim($_POST['eml']))."',
	  UNIX_TIMESTAMP(),
	  '".addslashes(getip())."',
	  '1',
	  1
	  )") or die(err(2));
    }
}



if($_POST['souhlas_ou']==1)
    {
		$souhlas = 'ANO';
	}
	else
	{
		$souhlas = 'NE';
	}
	
if($_POST['nl']==1)
    {
		$nl = 'ANO';
	}
	else
	{
		$nl = 'NE';
	}
// odeslani emailu uzivateli s rekapitulaci zadanych udaju

 $headers = "From:".__EMAIL_1__."\n";
 $headers .= "Return-Path :".__EMAIL_1__."\n";
 $headers .= "Reply-To :".__EMAIL_1__."\n";
 $headers .= "MIME-Version: 1.0\n";
 $headers .= "Content-type: text/plain; charset=utf-8\n";
 $headers .= "Content-Transfer-Encoding: 8bit\n";
 $headers .= "X-MSMail-Priority: High\n";
 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion()."\n";
 $headers .= "bcc:".__EMAIL_1__; // BCC
 
 $body = "Datum registrace: ".date("d.m.Y H:i:s")."\nJméno: ".strip_tags($_POST['jmeno'])."\nPříjmení: ".strip_tags($_POST['prijmeni'])."\nUž. jméno: ".strip_tags($_POST['uz_jm'])."\nHeslo: ".strip_tags($_POST['heslo'])."\nE-mail: ".strip_tags($_POST['eml'])."\nObec: ".strip_tags($_POST['obec'])."\nUlice: ".strip_tags($_POST['ulice'])." číslo: ".strip_tags($_POST['cislo'])."\nPSČ: ".strip_tags($_POST['psc'])."\nStát: ".strip_tags($_POST['stat'])."\nTelefon: ".strip_tags($_POST['telefon']);




if($_POST['jina_fakturacni'])
{
 $body .= "\n\nFakturační adresa:\nIČO: ".strip_tags($_POST['reg_fak_ico'])."\nDIČ: ".strip_tags($_POST['reg_fak_dic'])."\nNázev firmy: ".strip_tags($_POST['reg_fak_nazev_firmy'])."\nJméno a příjmení: ".strip_tags($_POST['reg_fak_jmeno_prijmeni'])."\nObec: ".strip_tags($_POST['reg_fak_obec'])."\nUlice: ".strip_tags($_POST['reg_fak_ulice'])." číslo: ".strip_tags($_POST['reg_fak_cislo'])."\nPSČ: ".strip_tags($_POST['reg_fak_psc'])."\n\n";
}

if($_POST['jina_dodaci'])
{
 $body .= "\n\nDodací adresa:\nJméno a příjmení: ".strip_tags($_POST['reg_dod_jmeno_prijmeni'])."\nNázev firmy: ".strip_tags($_POST['reg_dod_nazev_firmy'])."\nObec: ".strip_tags($_POST['reg_dod_obec'])."\nUlice: ".strip_tags($_POST['reg_dod_ulice'])." číslo: ".strip_tags($_POST['reg_dod_cislo'])."\nPSČ: ".strip_tags($_POST['reg_dod_psc'])."\nStát: ".strip_tags($_POST['reg_dod_stat'])."\n\n";
}


 $body .= "\n\n".strip_tags(__REGISTRACE_SOUHLAS_SE_ZPRAC_OS_UD__).": ".$souhlas;
 $body .= "\n\n".strip_tags(__KOSIK_NL_TEXT__).": ".$nl;

if(preg_match('/kosik.html/', $_POST['referer'],$match))
{
 // pokud prichazi z kosiku, tak neodesilame odkaz s aktivacnim linkem
}
else
{
  $body .= "\n\nPro aktivaci registrace je nutné kliknout na následující odkaz: ".__URL__."/registrace2.html?u=".base64_encode($_POST['uz_jm'])."&hash=".md5($_POST['heslo']);
}





 if(!mail(strip_tags($_POST['eml']), "Registrace na ".__URL__, $body,$headers))
  {
  $registrace_t = "<br /><span class=\"r\"><br />Chyba při odesílání e-mailu<br /><br /><br /><br /><br /><br /></span>";
  }
  else
  {
	  	$query_s = MySQL_Query("SELECT id, procento FROM skupiny_slev ORDER BY procento ASC LIMIT 1") or die(err(1));
	    $row_s = mysql_fetch_object($query_s);
	
		if(preg_match('/kosik.html/', $_POST['referer'],$match))
		{
			
			
			$_POST['prihlasit']  = time();
			$_POST['prihlaseni_uz_jm'] = strip_tags($_POST['uz_jm']);
			$_POST['prihlaseni_heslo'] = strip_tags($_POST['heslo']);
			
			// update aktivni=1
			MySQL_Query ("UPDATE zakaznici SET
    		   aktivni=1,
			   id_skupiny_slev='".$row_s->id."'
    		   WHERE id='".$last_id."'") or die(err(3));
			
			$Prihlaseni =  new Prihlaseni();
	        $prihlaseni_t =  $Prihlaseni->PrihlasUzivatele();
			
			
			 $registrace_t .= '<div class="div_kos_text">
				   Uloženo. Vaše registrace proběhla v pořádku a na e-mail <b>'.strip_tags($_POST['eml']).'</b> byla zaslána rekapitulace zadaných údajů. 
				   <br />
				  </div>';
		 $registrace_t .= '<div class="clear" style="height: 10px;"></div>';
		 
		 $registrace_t .= "<div style=\"text-align: center;\"><a href=\"/kosik.html?krok=3\">Pokračujte na souhrn objednávky, kde si zkontrolujte všechny údaje objednávky před jejím dokončením.</a></div>";
		}
	   else
		{
	
	
	
		 $registrace_t .= '<div class="div_kos_text">

				   Uloženo. Vaše registrace proběhla v pořádku a na e-mail <b>'.strip_tags($_POST['eml']).'</b> byla zaslána rekapitulace zadaných údajů. 
				   Registraci je nutno potvrdit klikem na odkaz v e-mailu, až pak je registrace aktivní a je možné se přihlásit.
				   </div>';
		 $registrace_t .= '<div class="clear" style="height: 10px;"></div>';
		 $registrace_t .= "<div style=\"text-align: center;\"><a href=\"/\"><img src=\"/img/pokracovat.png\" style=\"border: 0;\"></a></div>";
	   }
	


	$registrace_t .= "<br /><br /><br />";
  }
}
else
{  // vypis chyb
  $registrace_t = "<br /><span class=\"r\">".$err."</span><br />";
}
}

if(!$_POST['pokracovat_1'] || ($_POST['pokracovat_1'] && $err))
{
$query_s = MySQL_Query("SELECT procento FROM skupiny_slev ORDER BY procento ASC LIMIT 1") or die(err(1));
$row_s = mysql_fetch_object($query_s);


if(preg_match('/kosik.html/', $_SERVER['HTTP_REFERER'],$match))
{
		 
		 if($row_s->procento)
		 {
		 $registrace_t .= '<div class="div_kos_text">
				   <b>Registrovaný uživatel získává slevu ve výši '.$row_s->procento.'% na veškeré zboží, které není ve slevě.</b>
				   </div>';
		 }
}
else
{
		 $registrace_t .= '<div class="div_kos_text">';
		
			if($row_s->procento)
		     {
			 $registrace_t .= '<b>Registrovaný uživatel získává slevu ve výši '.$row_s->procento.'% na veškeré zboží, které není ve slevě.</b>';
		     }
				   
				   $registrace_t .= 'Po odeslání registrace Vám bude neprodleně doručen na e-mailovou adresu uvedenou v registračním formuláři aktivační e-mail.
				   <b>Registraci je nutno potvrdit klikem na odkaz v e-mailu</b>, až pak je registrace aktivní a je možné se přihlásit. 
				   Po úspěšném přihlášení jsou všechny ceny nabízeného zboží, které není ve slevě poníženy o výše uvedenou slevu.
				   </div>';
}


		 $registrace_t .= '<div class="clear" style="height: 10px;"></div>';
		 
		 $registrace_t .= "<br /><img src=\"/img/req.gif\" alt=\"\"/> - takto označené položky musí být vyplněny.<br />";

 $registrace_t .= "<br /><form id=\"reg\" method=\"post\" action=\"\" onsubmit=\"return validate_reg();\">
 <table border=\"0\" class=\"noborder\" style=\"width: 100%\" >";

  $registrace_t .= "<tr><td width=\"50%\" >Jméno <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"jmeno\" id=\"jmeno\" maxlength=\"60\"   value=\"".strip_tags($_POST['jmeno'])."\" class=\"form_inp\" /></td><td >Příjmení <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"prijmeni\" id=\"prijmeni\" maxlength=\"60\"   value=\"".strip_tags($_POST['prijmeni'])."\" class=\"form_inp\" /></td></tr>";
  
   $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  
  $registrace_t .= "<tr><td>Uživatelské jméno <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"uz_jm\" id=\"uz_jm\" maxlength=\"60\"   value=\"".strip_tags($_POST['uz_jm'])."\" class=\"form_inp\" /></td><td>Heslo <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"password\" name=\"heslo\" id=\"heslo\" maxlength=\"60\"   value=\"".strip_tags($_POST['heslo'])."\" class=\"form_inp\" /></td></tr>";
  
   $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
 
   $registrace_t .= "<tr><td  >&nbsp;
   </td><td >Potvrzení hesla <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"password\" name=\"heslo2\" id=\"heslo2\" maxlength=\"60\"   value=\"".strip_tags($_POST['heslo2'])."\" class=\"form_inp\" /></td></tr>";
   
   $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

   $registrace_t .= "<tr><td >Ulice <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"ulice\" id=\"ulice\" maxlength=\"60\"   value=\"".strip_tags($_POST['ulice'])."\" class=\"form_inp\" /></td><td >Číslo <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"cislo\" id=\"cislo\" maxlength=\"60\"   value=\"".strip_tags($_POST['cislo'])."\" class=\"form_inp\"/></td></tr>";
   
   $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";


   $registrace_t .= "<tr><td >Obec <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"obec\" id=\"obec\" maxlength=\"60\"  value=\"".strip_tags($_POST['obec'])."\" class=\"form_inp\" /></td><td >PSČ <img src=\"/img/req.gif\" alt=\"\" /><br /><input type=\"text\" name=\"psc\" id=\"psc\" maxlength=\"60\"   value=\"".strip_tags($_POST['psc'])."\" class=\"form_inp\" /></td></tr>";
   
   $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";


   $registrace_t .= "<tr><td >E-mail <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"eml\" id=\"eml\" maxlength=\"60\"   value=\"".strip_tags($_POST['eml'])."\" class=\"form_inp\" /></td>
   <td >Stát <img src=\"/img/req.gif\" alt=\"\"/><br /><select name=\"stat\" size=\"1\" style=\"float: left;
width: 350px;
height: 44px;
line-height: 44px;
padding-left: 20px;
font-size: 14px;
background-color: #ffffff;
border: solid 1px #dadada;\" >";
 foreach($_SESSION['arr_staty'] as $key_stat => $value_stat)
  {
   $registrace_t .= "<option value=\"".$key_stat."\" ";
   if($row3->stat==$key_stat) { $registrace_t .= " selected "; }
   $registrace_t .= ">".$value_stat."</option>";
  }
 
 $registrace_t .= "</select></td></tr>";
 
 $registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";




$registrace_t .= "<tr><td >Telefon <img src=\"/img/req.gif\" alt=\"\"/><br /><input type=\"text\" name=\"telefon\" id=\"telefon\" maxlength=\"60\"   value=\"".strip_tags($_POST['telefon'])."\" class=\"form_inp\" /></td><td >Antispam:<img src=\"/img/req.gif\" /><br />".antispam($_SESSION['otazky_as'])."</td></tr>";
 
$registrace_t .= '<tr><td colspan="2">&nbsp;</td></tr>';

$registrace_t .= "<tr><td colspan=\"2\" align=\"left\">
<a href=\"#dod_adr\"><input type=\"checkbox\" name=\"jina_dodaci\" value=\"1\" id=\"n3\" onclick=\"prn('dod_adresa')\" /> <label for=\"n3\" style=\"cursor: pointer; _cursor: hand;\">Jiná dodací adresa</label></a> 
<br />
<a href=\"#fak_adr\"><input type=\"checkbox\" name=\"jina_fakturacni\" value=\"1\" id=\"n4\" onclick=\"prn2('fak_adresa')\" /> <label for=\"n4\" style=\"cursor: pointer; _cursor: hand;\">Fakturační adresa</label></a> - vyplňujte pouze pokud nakupujete na firmu!</td></tr>";


$registrace_t .= '<tr><td colspan="2">
<a name="dod_adr"></a>
<div style="display: none; " id="dod_adresa">
<br /><br />
<strong>Dodací adresa:</strong><br />
<table class="noborder" style="width: 100%;">
<tr><td>Jméno a příjmení <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_dod_jmeno_prijmeni" maxlength="50"   class="form_inp" value="'.strip_tags($_POST['reg_dod_jmeno_prijmeni']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Název firmy<br /><input type="text" name="reg_dod_nazev_firmy" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_nazev_firmy']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Obec <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_dod_obec" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_obec']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Ulice <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_dod_ulice" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_ulice']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Číslo popisné <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_dod_cislo" maxlength="20"  class="form_inp" value="'.strip_tags($_POST['reg_dod_cislo']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >PSČ <img src="/img/req.gif" alt="" /><br /><br /><input type="text" name="reg_dod_psc" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_psc']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Stát <img src="/img/req.gif" alt=""/><br />';

$registrace_t .= "<select name=\"reg_dod_stat\" size=\"1\" style=\"float: left;
width: 350px;
height: 44px;
line-height: 44px;
padding-left: 20px;
font-size: 14px;
background-color: #ffffff;
border: solid 1px #dadada;\" >";
 foreach($_SESSION['arr_staty'] as $key_stat => $value_stat)
  {
   $registrace_t .= "<option value=\"".$key_stat."\" ";
   if($row3->reg_dod_stat==$key_stat) { $registrace_t .= " selected "; }
   $registrace_t .= ">".$value_stat."</option>";
  }
 
 $registrace_t .= "</select>";

$registrace_t .= '</td></tr>
</table></div>
</td>
</tr>
<tr><td colspan="2">
<a name="fak_adr"></a>
<div style="display: none; width: auto" id="fak_adresa">
<br /><br />
<strong>Fakturační adresa:</strong><br />Vyplňte pouze pokud nakupujete na firmu.<br />
<table class="noborder" style="width: 100%;">
<tr><td >Jméno a příjmení<br /><input type="text" name="reg_fak_jmeno_prijmeni" maxlength="50"  class="form_inp"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Název firmy <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_fak_nazev_firmy" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_nazev_firmy']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >DIČ<br /><input type="text" name="reg_fak_dic" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_dic']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >IČO <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_fak_ico" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_ico']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Obec <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_fak_obec" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_obec']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Ulice <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_fak_ulice" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_ulice']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >Číslo popisné <img src="/img/req.gif" alt="" /><br /><input type="text" name="reg_fak_cislo" maxlength="20"  class="form_inp" value="'.strip_tags($_POST['reg_fak_cislo']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td >PSČ <img src="/img/req.gif" alt=""/><br /><input type="text" name="reg_fak_psc" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_psc']).'"/></td></tr>
</table>
</div>
</td></tr>';
$registrace_t .= '<tr><td colspan="2" >&nbsp;</td></tr>';

$registrace_t .= '<tr><td colspan="2" ><div class="checkbox-field"><input class="form-check__input" type="checkbox" name="nl" value="1"> <label>'.__KOSIK_NL_TEXT__.'</label></div></td></tr>';

$registrace_t .= '<tr><td colspan="2" ><input class="form-check__input" type="checkbox" name="souhlas_ou" value="1" required> '.__REGISTRACE_SOUHLAS_SE_ZPRAC_OS_UD__.'</td></tr>';

$registrace_t .= "<tr><td colspan=\"2\" align=\"center\">
<br /><br />
<input type=\"hidden\" name=\"pokracovat_1\" value=\"Registrovat\" />";


// uprava - musime udrzet puvodni referer i po odeslani formulare
if($_POST['referer'])
{
$registrace_t .= "<input type=\"hidden\" name=\"referer\" value=\"".strip_tags($_POST['referer'])."\" />";
}
else
{
$registrace_t .= "<input type=\"hidden\" name=\"referer\" value=\"".strip_tags($_SERVER['HTTP_REFERER'])."\" />";
}


if(preg_match('/kosik.html/', $_SERVER['HTTP_REFERER'],$match))
{
$registrace_t .= "<input type=\"submit\" name=\"submit\" value=\"pokračovat v objednávce\" title=\"pokračovat v objednávce\" class=\"submit_but\" />";	
}
else
{
$registrace_t .= "<input type=\"submit\" name=\"submit\" value=\"Odeslat\" title=\"Odeslat\" class=\"submit_but\" />";	
}



$registrace_t .= "</td></tr>";
$registrace_t .= "</table></form><br /><br />";

}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Registrace','html');
 $Sablonka->PridejDoSablonky('[obsah]',$registrace_t,'html');
echo $Sablonka->GenerujSablonku('default');
?>

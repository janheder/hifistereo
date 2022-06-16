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



if(!$err)
{
$ip_adr = getip();
$heslo =  time().".".date("l");

// kontakt /////////////////////////////////////////////////////////////////////
MySQL_Query("INSERT INTO zakaznici
(id,uz_jm,heslo,jmeno,prijmeni,eml,obec,cislo,ulice,psc,stat,telefon,reg_fak_ico,reg_fak_dic,reg_fak_nazev_firmy,reg_fak_jmeno_prijmeni,reg_fak_obec,reg_fak_ulice,reg_fak_cislo,
reg_fak_psc,reg_dod_jmeno_prijmeni,reg_dod_nazev_firmy,reg_dod_obec,reg_dod_ulice,reg_dod_cislo,reg_dod_psc,reg_dod_stat,datum,aktivni,id_skupiny_slev,cenova_skupina,ip,eshop)
VALUES ('',
'bez registrace',
'".md5($heslo)."',
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
'1',
'',
'A',
'$ip_adr',3)") or die(err(2));

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
$result_kontrola = mysql_query("SELECT id FROM newsletter WHERE email='".addslashes(trim($_POST['eml']))."'") or die(err(1));
	if(!mysql_num_rows($result_kontrola))
	{
		
		if($_POST['nl']==1)
		{
			 MySQL_Query("INSERT INTO newsletter
			  (id,email,datum,ip,typ,aktivni)
			  VALUES ('',
			  '".addslashes(trim($_POST['eml']))."',
			  UNIX_TIMESTAMP(),
			  '".addslashes(getip())."',
			  '2',
			  '1'
			  )") or die(err(2));
			  
			  
       }
    }

// prihlaseni 

$_POST['prihlasit']  = time();
$_POST['prihlaseni_uz_jm'] = 'bez registrace';
$_POST['prihlaseni_heslo'] = strip_tags($heslo);

$Prihlaseni =  new Prihlaseni();
$registrace_t .= '<span class="r">'.$Prihlaseni->PrihlasUzivatele();

$registrace_t .= '<script>
window.location.href = "/kosik.html?krok=3";
</script>';

/*
$registrace_t .= '<br /> Pokračujte na souhrn objednávky, kde si zkontrolujte všechny údaje objednávky před jejím dokončením.</span>';
$registrace_t .= '<div class="clear" style="height: 10px;"></div>';
$registrace_t .= "<div style=\"text-align: center;\"><a href=\"/kosik.html?krok=3\">
		 <img src=\"/img/pokracovat.png\"  style=\"border: 0;\"></a><br /></div>";
*/


}
else
{  // vypis chyb
  $registrace_t .= "<br /><span class=\"r\">".$err."</span><br />";
}
}

if(!$_POST['pokracovat_1'] || ($_POST['pokracovat_1'] && $err))
{

$registrace_t .= "<br /><img src=\"/img/req.gif\" /> - takto označené položky musí být vyplněny.<br />";


 $registrace_t .= "<br /><form name=\"reg\" method=\"post\">
 <table border=\"0\" class=\"noborder\" style=\"width: 100%\" >";


  $registrace_t .= "<tr><td width=\"50%\" ><div class=\"form_text\">Jméno <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"jmeno\" maxlength=\"60\"   value=\"".strip_tags($_POST['jmeno'])."\" class=\"form_inp\" /></td><td >
  
  <div class=\"form_text\">Příjmení <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"prijmeni\" maxlength=\"60\"   value=\"".strip_tags($_POST['prijmeni'])."\" class=\"form_inp\" />
   </td></tr>";
  
$registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

   $registrace_t .= "<tr><td ><div class=\"form_text\">Ulice <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"ulice\" maxlength=\"60\"   value=\"".strip_tags($_POST['ulice'])."\" class=\"form_inp\" /></td><td >
  <div class=\"form_text\">Číslo <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"cislo\" maxlength=\"60\"   value=\"".strip_tags($_POST['cislo'])."\" class=\"form_inp\"/></td></tr>";

$registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
   $registrace_t .= "<tr><td ><div class=\"form_text\">Obec <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"obec\" maxlength=\"60\"  value=\"".strip_tags($_POST['obec'])."\" class=\"form_inp\" /></td><td >
  <div class=\"form_text\">PSČ <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"psc\" maxlength=\"60\"   value=\"".strip_tags($_POST['psc'])."\" class=\"form_inp\" /></td></tr>";
$registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

   $registrace_t .= "<tr><td ><div class=\"form_text\">E-mail <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"eml\" maxlength=\"60\"   value=\"".strip_tags($_POST['eml'])."\" class=\"form_inp\" /></td>
   <td ><div class=\"form_text\">Stát <img src=\"/img/req.gif\"/></div>
 <select name=\"stat\" size=\"1\" style=\"float: left;
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
 
 $registrace_t .= "</select>
 
 </td></tr>";


$registrace_t .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

$registrace_t .= "<tr><td ><div class=\"form_text\">Telefon <img src=\"/img/req.gif\"/></div><input type=\"text\" name=\"telefon\" maxlength=\"60\"   value=\"".strip_tags($_POST['telefon'])."\" class=\"form_inp\" /></td><td >
</td></tr>";
  
$registrace_t .= '<tr><td colspan="2">&nbsp;</td></tr>';

$registrace_t .= "<tr><td colspan=\"2\" align=\"left\">
<a href=\"#dod_adr\"><input type=\"checkbox\" name=\"jina_dodaci\" value=\"1\" id=\"n3\" onclick=\"prn('dod_adresa')\" /> <label for=\"n3\" style=\"cursor: pointer; _cursor: hand;\">Jiná dodací adresa</label></a> 
<br />
<a href=\"#fak_adr\"><input type=\"checkbox\" name=\"jina_fakturacni\" value=\"1\" id=\"n4\" onclick=\"prn2('fak_adresa')\" /> <label for=\"n4\" style=\"cursor: pointer; _cursor: hand;\">Fakturační adresa</label></a> - vyplňujte pouze pokud nakupujete na firmu!";


$registrace_t .= '<tr><td colspan="2">
<a name="dod_adr"></a>
<div style="display: none;  " id="dod_adresa">
<br /><br />
<strong>Dodací adresa:</strong><br />
<table class="noborder" style="width: 100%;">
<tr><td><div class="form_text">Jméno a příjmení <img src="/img/req.gif"/></div><input type="text" name="reg_dod_jmeno_prijmeni" maxlength="50"   class="form_inp" value="'.strip_tags($_POST['reg_dod_jmeno_prijmeni']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Název firmy</div><input type="text" name="reg_dod_nazev_firmy" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_nazev_firmy']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Obec <img src="/img/req.gif"/></div><input type="text" name="reg_dod_obec" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_obec']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Ulice <img src="/img/req.gif"/></div><input type="text" name="reg_dod_ulice" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_ulice']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Číslo popisné <img src="/img/req.gif"/></div><input type="text" name="reg_dod_cislo" maxlength="20"  class="form_inp" value="'.strip_tags($_POST['reg_dod_cislo']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">PSČ <img src="/img/req.gif"/></div><input type="text" name="reg_dod_psc" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_dod_psc']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Stát <img src="/img/req.gif"/></div>';

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
</table>
</div>
<a name="fak_adr"></a><div style="display: none; width: auto" id="fak_adresa">
<br /><br />
<strong>Fakturační adresa:</strong><br />Vyplňte pouze pokud nakupujete na firmu.
<table class="noborder" style="width: 100%;">
<tr><td ><div class="form_text">Jméno a příjmení</div><input type="text" name="reg_fak_jmeno_prijmeni" maxlength="50"  class="form_inp"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Název firmy <img src="/img/req.gif"/></div><input type="text" name="reg_fak_nazev_firmy" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_nazev_firmy']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">DIČ</div><input type="text" name="reg_fak_dic" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_dic']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">IČO <img src="/img/req.gif"/></div><input type="text" name="reg_fak_ico" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_ico']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Obec <img src="/img/req.gif"/></div><input type="text" name="reg_fak_obec" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_obec']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Ulice <img src="/img/req.gif"/></div><input type="text" name="reg_fak_ulice" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_ulice']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">Číslo popisné <img src="/img/req.gif"/></div><input type="text" name="reg_fak_cislo" maxlength="20"  class="form_inp" value="'.strip_tags($_POST['reg_fak_cislo']).'"/></td></tr>
<tr><td >&nbsp;</td><td>&nbsp;</td></tr>
<tr><td ><div class="form_text">PSČ <img src="/img/req.gif"/></div><input type="text" name="reg_fak_psc" maxlength="50"  class="form_inp" value="'.strip_tags($_POST['reg_fak_psc']).'"/></td></tr>
</table>
</div>
</td></tr>';

$registrace_t .= '<tr><td colspan="2" >&nbsp;</td></tr>';

$registrace_t .= '<tr><td colspan="2" ><div class="checkbox-field"><input class="form-check__input" type="checkbox" name="nl" value="1"> <label>'.__KOSIK_NL_TEXT__.'</label></div></td></tr>';
$registrace_t .= '<tr><td colspan="2" >&nbsp;</td></tr>';
$registrace_t .= '<tr><td colspan="2" >  '.__KOSIK_OSOBNI_UDAJE__.'</td></tr>';

$registrace_t .= "<tr><td colspan=\"2\" align=\"center\">
<br /><br />
<input type=\"hidden\" name=\"pokracovat_1\" value=\"Registrovat\" />
<input type=\"hidden\" name=\"prihlasit\" value=\"".md5(time())."\" />
<input type=\"hidden\" name=\"prihlaseni_uz_jm\" value=\"bez registrace\" />
<input type=\"hidden\" name=\"prihlaseni_heslo\" value=\"".time()."\" />
<input type=\"submit\" name=\"submit\" value=\"pokračovat v objednávce\" title=\"Odeslat\" class=\"submit_but\" />
</td></tr>";
$registrace_t .= "</table></form><br /><br />";

}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Nákup bez registrace','html');
 $Sablonka->PridejDoSablonky('[obsah]',$registrace_t,'html');
echo $Sablonka->GenerujSablonku('kosik');
?>

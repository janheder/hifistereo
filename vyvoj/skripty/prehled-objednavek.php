<?
$prehled_t = '';

if($_SESSION['prihlaseni'])	
{
list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));

$query_prihlaseni = MySQL_Query("SELECT * FROM zakaznici WHERE uz_jm='".addslashes($uz_jm_sess)."' AND heslo='".addslashes($heslo_sess)."' AND aktivni=1") or die(err(1));
$row_prihlaseni = mysql_fetch_object($query_prihlaseni);



$prehled_t .= "přihlášen je: <strong>".$jmeno_sess."</strong><br /><br />";
//smycka pro vypis objednavek
$prehled_t .= "<br /><table border=\"0\" width=\"100%\" class=\"tab_kosik\">";
$prehled_t .= "<tr>
<td valign=\"top\" style=\"padding: 4px;\"><b>&nbsp;&nbsp;&nbsp;id&nbsp;obj.</b></td>
<td valign=\"top\" style=\"padding: 4px;\"><b>položky</b></td>
<td valign=\"top\" style=\"padding: 4px;\"><b>ks</b></td>
<td valign=\"top\" style=\"padding: 4px;\"><b>cena&nbsp;s&nbsp;DPH</b></td>
<td valign=\"top\" style=\"padding: 4px;\"><b>datum</b></td>
<td valign=\"top\" style=\"padding: 4px;\"><b>stav</b></td></tr>";
$query_prehled_obj = MySQL_Query("SELECT * FROM objednavky WHERE id_zak = '".$row_prihlaseni->id."' ORDER BY id DESC") or die(err(1));
$i = 0;
while($row_prehled_obj = mysql_fetch_object($query_prehled_obj)){
	
        if($id_obj!=$row_prehled_obj->id_obj && $i>0){
        $prehled_t .= "<tr><td colspan=\"6\" style=\"padding: 4px;\">&nbsp;</td></tr>";	
        }


	 if($row_prehled_obj->doprava_cena==0){
	$row_prehled_obj->doprava_cena  = false;
	}
	
	if($id_obj==$row_prehled_obj->id_obj){
	//$row_prehled_obj->id_obj  = false;
	$row_prehled_obj->datum  = false;
	$row_prehled_obj->stav = false;
        $row_prehled_obj->doprava_zp = false;
	$row_prehled_obj->platba_zp = false;
        $row_prehled_obj->poznamka = false;
	}
	
	
	
$prehled_t .= "<tr><td valign=\"top\" style=\"padding: 4px;\">";
if ($row_prehled_obj->id_obj != $id_obj)
{ 
$prehled_t .= $row_prehled_obj->id_obj;
}
$prehled_t .= "</td><td style=\"padding: 4px;\">".$row_prehled_obj->polozky."</td>
<td style=\"padding: 4px;\">".$row_prehled_obj->ks."</td>
<td style=\"padding: 4px;\">".round(($row_prehled_obj->cena_ks_bez_dph * $row_prehled_obj->ks))." ".__MENA__."</td>
<td style=\"padding: 4px;\">";
if($row_prehled_obj->datum){
	$prehled_t .= date("d.m.Y",$row_prehled_obj->datum);
}
$prehled_t .= "</td><td style=\"padding: 4px;\">".$row_prehled_obj->stav."</td>";


$id_obj = $row_prehled_obj->id_obj;
$i++;
}

$prehled_t .= "</table>";

}
else
{
$prehled_t .= "Nejste přihlášeni, pro zobrazení historie objednávek je nutné se nejdříve přihlásit ve formuláři vpravo nahoře.";
}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Přehled objednávek','html');
 $Sablonka->PridejDoSablonky('[obsah]',$prehled_t,'html');
echo $Sablonka->GenerujSablonku('default');

?>

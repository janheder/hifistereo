<?
// stranka produkty
$vyhledavani2 = '';

if($_POST['vyhledavani'])
{
	
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme,P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph  
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce  
    WHERE (P.nazev LIKE '%".addslashes($_POST['vyhledavani'])."%' OR P.kat_cislo LIKE '%".addslashes($_POST['vyhledavani'])."%' 
	OR P.popis LIKE '%".addslashes($_POST['vyhledavani'])."%' ) 
	AND P.aktivni4=1 AND O.typ=1
	GROUP BY P.id
	ORDER BY P.cena_A ASC
	LIMIT 300") or die(err(1));

	$nx = 1;
	$pocet_vyhl = mysql_num_rows($query_n);

	if($pocet_vyhl)
        {

			$vyhledavani = 'Počet nalezených produktů na výraz <b>'.sanitize($_POST['vyhledavani']).'</b>: '.$pocet_vyhl.'<br /><br />';
			
			while($row_n = MySQL_fetch_object($query_n))
			  {
				$url = url_produktu($row_n->id,$row_n->id_kategorie);
				  
				  //obrazek
				  if(!$row_n->ONAZ)
					{
					$row_n->ONAZ = "neni.gif";
					}
				  
				  if($row_n->sleva>0 && ($row_n->platnost_slevy>time())) 
					{
						$sleva = $row_n->sleva;
					}
				  else
				   {
						$sleva = 0;
				   }	
				   
				   $nejprodavanejsi2 = nejprodavanejsi2(20);
				   
				   if(is_array($nejprodavanejsi2))
					{
					 if(in_array($row_n->id,$nejprodavanejsi2))
					  {
					  $nej = 1;
					  }
					  else
					  {
					  $nej = 0;
					  }
					}
					else
					{
					$nej = 0;
					}
				   

				  $vyhledavani2 .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
				  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,2);
				  

				$nx++;  
			  }
     }
	 else
	 {
	 $vyhledavani .= 'Žádný výsledek';
	 }
	
}
else
{
$vyhledavani .= 'Nezadali jste žádné slovo k vyhledávání!';
}

// ukoncime hlavni obal
	$vyhledavani .= '<div class="clear"></div>';
	$vyhledavani .= '</div>';
	$vyhledavani .= '<div class="clear" style="height: 40px;"></div>';
	$vyhledavani .= '<div class="holder4"><div class="product-grid">';

//var_dump($vyhledavani);

 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Vyhledávání','html');
 $Sablonka->PridejDoSablonky('[obsah]',$vyhledavani.$vyhledavani2,'html');
echo $Sablonka->GenerujSablonku('produkty');

?>

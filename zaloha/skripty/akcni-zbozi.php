<?
// akcni zbozi
$obsah_ab = ' ';

$limit = intval($_GET['limit']);
if(!$limit)
	   {
        $limit = 0;
        }

 if(!$_SESSION['pocet_strankovani']){$_SESSION['pocet_strankovani'] = __POCET_PRODUKTU_NAHLEDY__;} 
 
 
 if(__LANG__=='sk')
 {
 $sql_dph = 'id_dph_sk';
 }
 else
 {
 $sql_dph = 'id_dph';
 }

	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	$query_pocet = MySQL_Query("SELECT count(P.id) AS CID FROM produkty P WHERE P.aktivni=1 AND P.akce=1") or die(err(1));
	$row_pocet = MySQL_fetch_object($query_pocet);
	$pocet = $row_pocet->CID;
	
	
	// strankovani
	$obsah_ab .= '<div class="strankovani_kategorie">';
	$obsah_ab .= get_links3a($pocet,$limit);
	$obsah_ab .= '</div>';
	

	$obsah_ab .= '<div class="clear" style="height: 20px;"></div>';
	
	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
		P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
		FROM produkty P 
		LEFT JOIN obrazky O ON O.idp=P.id 
		LEFT JOIN dostupnost D ON D.id=P.id_dostupnost  
		LEFT JOIN dph DP ON DP.id=P.id_dph 
		LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce 
		WHERE P.aktivni=1  AND P.akce=1 AND O.typ=1 GROUP BY P.id ORDER BY P.datum DESC LIMIT $limit, ".intval($_SESSION['pocet_strankovani'])." ") or die(err(1));

	$nx = 1;
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
		   

		  
		  $obsah_ab .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
		$url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,2);
		
	
		  
		$nx++;  
	  }
	  
	// strankovani
	$obsah_ab .= '<div class="clear" style="height: 20px;"></div>';
	$obsah_ab .= '<div class="strankovani_kategorie">';
	$obsah_ab .= get_links3a($pocet,$limit);
	$obsah_ab .= '</div>';
	$obsah_ab .= '<div class="clear" style="height: 15px;"></div>';


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Akční zboží','html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_ab,'html');
echo $Sablonka->GenerujSablonku('default');
?>

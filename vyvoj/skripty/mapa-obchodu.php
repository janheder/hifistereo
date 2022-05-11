<?

$obsah_mapa = '';

		
		
// stranky
$query_stranky = MySQL_Query("SELECT * FROM stranky WHERE aktivni=1") or die(err(1));	
while($row_stranky= MySQL_fetch_object($query_stranky))
	{
	$obsah_mapa .= "&middot; <a href=\"".__URL__."/".$row_stranky->str.".html\" title=\"".stripslashes($row_stranky->nadpis)."\">".stripslashes($row_stranky->nadpis)."</a><br />";
	  if($row_stranky->str=='aktuality')
	  { 
		$query_ak = MySQL_Query("SELECT * FROM novinky WHERE aktivni=1") or die(err(1));	
		while($row_ak= MySQL_fetch_object($query_ak))
			{
				$obsah_mapa .= "&nbsp;&nbsp;&nbsp;&nbsp;&middot; <a href=\"".__URL__."/aktuality/".bez_diakritiky($row_ak->nadpis)."/".$row_ak->id.".html\" title=\"".stripslashes($row_ak->nadpis)."\">".stripslashes($row_ak->nadpis)."</a><br />";
			}
	  }
		
	}
	
	
$obsah_mapa .= "&middot; Produkty<br />";	
// zbozi
$query_skupiny = MySQL_Query("SELECT * FROM kategorie WHERE vnor=1 AND aktivni=1") or die(err(1));	
while($row_skupiny= MySQL_fetch_object($query_skupiny))
	{
	$obsah_mapa .= "&nbsp;&nbsp;&nbsp;&nbsp;&middot; <a href=\"".__URL__."/produkty/".$row_skupiny->str.".html\" title=\"".stripslashes($row_skupiny->nazev)."\">".stripslashes($row_skupiny->nazev)."</a><br />";
	
	
	 // produkty
			$query_produkty = MySQL_Query("SELECT P.id, P.str, P.nazev, P.id_kategorie
			FROM produkty P 
			WHERE P.aktivni=1 AND P.id_kategorie LIKE '%\"".$row_skupiny->id."\"%' ") or die(err(1));	
			
			while($row_produkty= MySQL_fetch_object($query_produkty))
			 {
			   $odkaz_n = url_produktu($row_produkty->id,$row_produkty->id_kategorie);
				 
			   $obsah_mapa .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&middot; 
			   <a href=\"".__URL__.$odkaz_n."\" title=\"".stripslashes($row_skupiny->nazev)." ".stripslashes($row_produkty->nazev)."\">".stripslashes($row_produkty->nazev)."</a><br />";	
			 }
	
	
	// podksupiny
	$query_podskupiny = MySQL_Query("SELECT * FROM kategorie WHERE vnor=2 AND id_nadrazeneho=".$row_skupiny->id." AND aktivni=1 ") or die(err(1));	
     while($row_podskupiny= MySQL_fetch_object($query_podskupiny))
	 {
			 $obsah_mapa .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&middot; <a href=\"".__URL__."/produkty/".$row_skupiny->str."/".$row_podskupiny->str.".html\" title=\"".stripslashes($row_skupiny->nazev)." ".stripslashes($row_produkty->nazev)." ".stripslashes($row_podskupiny->nazev)."\">".stripslashes($row_podskupiny->nazev)."</a><br />";	
			 
			 
			 // produkty
			$query_produkty = MySQL_Query("SELECT P.id, P.str, P.nazev, P.id_kategorie
			FROM produkty P 
			WHERE P.aktivni=1 AND P.id_kategorie LIKE '%\"".$row_podskupiny->id."\"%' ") or die(err(1));	
			
			while($row_produkty= MySQL_fetch_object($query_produkty))
			 {
			   $odkaz_n = url_produktu($row_produkty->id,$row_produkty->id_kategorie);
				 
			   $obsah_mapa .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&middot; 
			   <a href=\"".__URL__.$odkaz_n."\" title=\"".stripslashes($row_produkty->nazev)."\">".stripslashes($row_produkty->nazev)."</a><br />";	
			 }
			 
	  }
		
	}
	
	
	$obsah_mapa .= "&middot; Výrobci<br />";	
	
	$query_rh = MySQL_Query("SELECT str, vyrobce FROM vyrobci ORDER BY vyrobce") or die(err(1));
		while($row_rh = mysql_fetch_object($query_rh))
		{
			$obsah_mapa .= "<a href=\"".__URL__."/vyrobce/".$row_rh->str.".html\" title=\"".$row_rh->vyrobce."\">".$row_rh->vyrobce."</a><br />";
    	    
		}
	

 $Sablonka = new Sablonka();
 
 

 $Sablonka->PridejDoSablonky('[nadpis]','Mapa obchodu','html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_mapa,'html');
 echo $Sablonka->GenerujSablonku('default');

?>


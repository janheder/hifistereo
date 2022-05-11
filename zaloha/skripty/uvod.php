<?
// stranka uvod
 $Sablonka = new Sablonka();
 
 $query_str = MySQL_Query("SELECT nadpis, obsah FROM stranky4 WHERE id=14") or die(err(1));
 $row_str = MySQL_fetch_object($query_str);
 
 $uvod = $row_str->obsah;

 

		  
		  
//$Sablonka->PridejDoSablonky('[nadpis]',$row_str->nadpis,'html');
$Sablonka->PridejDoSablonky('[obsah]',$uvod,'html');
echo $Sablonka->GenerujSablonku('uvod');
?>

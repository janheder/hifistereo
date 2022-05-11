<?
// stranka aktuality
if($_GET['ida'])
{
// detail


$query_novinky = MySQL_Query("SELECT * FROM aktuality4 WHERE aktivni=1 AND id='".intval($_GET['ida'])."'") or die(err(1));
$row_novinky = MySQL_fetch_object($query_novinky);

 $a_nadpis = stripslashes($row_novinky->nadpis);
 
 $delka_nadpisu = strlen($row_novinky->nadpis);
 
 if($delka_nadpisu < 60)
			   {
				   $obsah_ak .= '<div class="ak_uvod_foto" style="margin-top: -70px;"><img src="'.__URL2__.'/prilohy/velke/'.$row_novinky->obr.'" alt="novinky" style="max-width: 96px;" /></div>';	
			   }
			   else
			   {
				   $obsah_ak .= '<div class="ak_uvod_foto" style="margin-top: -120px;"><img src="'.__URL2__.'/prilohy/velke/'.$row_novinky->obr.'" alt="novinky" style="max-width: 96px;" /></div>';	
			   }
 
 
 
 $obsah_ak .= '<div class="clear" style="height: 10px;"></div>';		
 $obsah_ak .= '<span style="color:#999999 ">Datum:</span> <b>'.date("d.m.Y",$row_novinky->datum).'</b>';			
 $obsah_ak .= '<div class="clear" style="height: 20px;"></div>'; 
 
 $obsah_ak .= stripslashes($row_novinky->perex);
 $obsah_ak .= '<div class="clear" style="height: 20px;"></div>';
 /*
  if($row_novinky->obr){$obsah_ak .='<img src="'.__URL2__.'/prilohy/'.$row_novinky->obr.'" alt="" />';}
	*/		
			 
 $obsah_ak .= '<div class="clear" style="height: 20px;"></div>';
 
 $obsah_ak .= stripslashes($row_novinky->text);
 
 if($row_novinky->autor || $row_novinky->zdroj)
 {
 $obsah_ak .= '<div class="autor_zdroj">';
  if($row_novinky->autor)
	{
		$obsah_ak .= '<span style="color:#999999 ">Autor:</span> <b>'.$row_novinky->autor.'</b>';
	}
	if($row_novinky->autor && $row_novinky->zdroj)
	{
	$obsah_ak .= ' / ';
	}
	if($row_novinky->zdroj)
	{
		$obsah_ak .= '<span style="color:#999999 ">Zdroj:</span> <b>'.$row_novinky->zdroj.'</b>';
	}
		
	$obsah_ak .= '</div>';
 }
 
 
 		  	// ke stazeni
	
	$query_prilohy = MySQL_Query("SELECT * FROM prilohy  WHERE id_psa='".$row_novinky->id."' AND typ=3 ORDER BY id ASC") or die(err(1));
	if(mysql_num_rows($query_prilohy))
	{
		
		$obsah_ak .= '<div class="clear" style="height: 20px;"></div>';
		$obsah_ak .= '<b>Ke stažení:</b>';
		
		$xp = 1;
		
		while($row_prilohy = MySQL_fetch_object($query_prilohy))
		{
			if($row_prilohy->nazev)
			{
			 $nazev_prilohy = stripslashes($row_prilohy->nazev);
		    }
		    else
		    {
			 $nazev_prilohy  = 'příloha '.$xp;
			 $xp++;
			}
			
			$obsah_ak .= '<div class="prilohy_det">
					<a href="'.__URL2__.'/prilohy/'.$row_prilohy->priloha.'">'.$nazev_prilohy.'</a>
					</div>';	
			$obsah_ak .= '<div class="clear" style="height: 10px;"></div>';
			
		}
		

	
	}
 

 
 
 // fotogalerie
		   if($row_novinky->fotogalerie)
		   {
				 $obsah_ak .= '<div class="clear" style="height: 15px;"></div>';
				 $obsah_ak .= '<div class="cara_carkovana"></div>';
				 $obsah_ak .= '<div class="clear" style="height: 15px;"></div>';
				 $obsah_ak .= '<h2>Fotogalerie:</h2><br />';
				 $obsah_ak .= '<div class="clear" style="height: 15px;"></div>';
				 $obsah_ak .= '<div class="fg">';
					$query_con_g2 = MySQL_Query("SELECT * from galerie WHERE id='".$row_novinky->fotogalerie."'");
					$row_con_g2 = MySQL_fetch_object($query_con_g2);

					
					$f = 1;
					$query_con_g3 = MySQL_Query("SELECT id, foto, rozmer_s, rozmer_v, velikost, autor, nazev, popis, cas, shlednuto from fotky 
					WHERE id_galerie='".$row_novinky->fotogalerie."' AND aktivni=1 ORDER BY id DESC") or die(err(1));
					while($row_con_g3 = MySQL_fetch_object($query_con_g3))
					{
					// shlednuto update
					MySQL_Query ("UPDATE fotky SET
					shlednuto=shlednuto+1
					WHERE id='".$row_con_g3->id."'")
					or die(err(3));
					 
					$obsah_ak .= '<a href="'.__URL2__.'/obr_velke/'.$row_con_g3->foto.'"  rel="foto_group" title="'.stripslashes($row_con_g3->nazev).'"><img src="'.__URL2__.'/obr_male/'.$row_con_g3->foto.'"
				   class="fotos" ';
				   if($f%5==0){ $obsah_ak .= ' style="margin-right: 0px;" ';}
				   $obsah_ak .= ' alt="'.stripslashes($row_con_g3->nazev).'" title="'.stripslashes($row_con_g3->nazev).'" /></a>';
					if($f%5==0)
					{
						$obsah_ak .= '<div class="clear"></div>';
					 }
					$f++;
					}
					$obsah_ak .= '<div class="clear"></div>';
				$obsah_ak .= '</div>';

		   
		   }
		   
		   
		   $obsah_ak .= '<div class="clear" style="height: 20px;"></div>';
		   
		   // tl. zpět
		     $obsah_ak .= '<div class="sub_dk" style="width: 270px;" onclick="javascript:history.back();">Zpět na výpis aktualit</div>';
		   


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]',$a_nadpis,'html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_ak,'html');
echo $Sablonka->GenerujSablonku('aktuality');

}
else
{
	
	

$obsah_ak = aktuality_zbytek();

 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Aktuality','html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_ak,'html');
echo $Sablonka->GenerujSablonku('aktuality');

}



?>

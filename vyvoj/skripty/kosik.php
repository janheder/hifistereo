<?

	$obsah_k = '';
	
	if($_SESSION['kosik'])
	{
	
		if($_SESSION['prihlaseni'])
		{
			list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
		}
		else
		{
			$id_zak_sess = '';
		}
		
		if(!$_GET['krok'])
		{
			$_GET['krok'] = 1;
		}
		
		if($_GET['krok']==2 && $_SESSION['prihlaseni'])
		{
			$_GET['krok'] = 3;
		}
    
		$Kosik3 = new Kosik($_SESSION['kosik'],__CENOVA_SKUPINA_SESS__,__SLEV_SK_SESS__);
	
		$obsah_k .= $Kosik3->Kroky(intval($_GET['krok']),$id_zak_sess);
	
	}
	else
	{
	//$obsah_k .= '<img src="/img/prazdny_kosik.png" alt="" style="margin-left: 70px;"/>';
	$obsah_k .= '<div style="width:auto; text-align: center; height: 80px; line-height: 80px; font-size: 30px; margin-top: 30px; color: #ffffff; 
	background-color: #FF3131;" id="kosik_p">Váš nákupní košík je prázdný</div>';
	
	// generujeme boxy kategorii
	
	$obsah_k .= '<div class="clear" style="height: 10px;"></div>';
	
	$obsah_k .= '<div style="width: 60%; text-align: center; margin-left: auto; margin-right: auto; height: 80px; line-height: 80px; font-size: 16px; 
	margin-top: 30px;" >Pro zahájení nákupu vyberte jednu z kategorií<br /></div>';
	
	$query_submenu = MySQL_Query("SELECT id,str,nazev, obr FROM kategorie WHERE vnor=1 AND aktivni=1 ORDER BY razeni,nazev") or die(err(1));
             if(mysql_num_rows($query_submenu))
              {    
				  
				$yy = 1;  
			    
                while($row_submenu = MySQL_fetch_object($query_submenu))
                {
					 $obsah_k .= "<div class=\"submenu_kat_box\"  onclick=\"self.location.href='/produkty/".$row_submenu->str.".html'\" ";
					 if($yy%5==0){$obsah_k .= " style=\"margin-right: 0px;\" "; }
					 $obsah_k .=" >
					 <div class=\"submenu_kat_box_obr\"><img src=\"".__URL2__."/prilohy/".$row_submenu->obr."\" alt=\"\" style=\"vertical-align: middle;\" /></div>
					 <div class=\"submenu_kat_box_text\">".stripslashes($row_submenu->nazev)."</div>
					 </div>";
					 
					 $yy++;
				}
			  }
	
	}


   if($_GET['krok']==3)
	{
		$nadpis = 'Souhrn objednávky';
	}
	else
	{
		$nadpis = 'Košík';
	}
	
   


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]',$nadpis,'html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_k,'html');
echo $Sablonka->GenerujSablonku('kosik');
?>

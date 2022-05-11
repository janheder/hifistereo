<?
// trida kosik pro praci s kosikem
class Kosik
{
public $obsah_kosiku; 
private $cenova_skupina_zakaznika;
private $slevova_skupina_zakaznika; 

	function __construct($obsah_kosiku,$cenova_skupina_zakaznika='A',$slevova_skupina_zakaznika)
	{
	 $this->obsah_kosiku = $obsah_kosiku;
	 $this->cenova_skupina_zakaznika = $cenova_skupina_zakaznika;
	 $this->slevova_skupina_zakaznika = $slevova_skupina_zakaznika;
	}
	
   public function VlozDoKosiku($id_zbozi,$pocet)
   {  
  	$this->id_zbozi = sanitize($id_zbozi);
  	$this->pocet = sanitize($pocet);
  	
  	if(!isset($this->pocet))
    {
  	$this->pocet = 1;
    }	
  	if($this->id_zbozi)
  	{
  		if(isset($this->obsah_kosiku[$this->id_zbozi]))
      {
  	  $_SESSION["kosik"][$this->id_zbozi] = $_SESSION["kosik"][$this->id_zbozi] + $this->pocet;	
  		}
  		else
      {
  	  $_SESSION["kosik"][$this->id_zbozi] = $this->pocet;
  		}
  	}
   }
  
   
   
   public function OdstranZKosiku($idz)
   {	
	   if($idz)
	   {
	   unset($_SESSION["kosik"][$idz]);
	   }
   }  
   
   
  public function ZmenPocetVKosiku($posty)
  {
   foreach ($posty as $index => $val) 
   {      
	   if($index)
     {
		   if(isset($this->obsah_kosiku[$index]))
       {
			   if($val==0 || !is_numeric($val{0}))
         {
			    unset($_SESSION["kosik"][$index]);
			   }
			   else
         {
			    $_SESSION["kosik"][$index] = sanitize($val);
			   }	
		   }
	   
	   }
    }	
	
  }
  
  
  public function ObsahKosiku()
  {
	if($this->obsah_kosiku)
  	{ 
    $this->pocet_ks = array_sum($this->obsah_kosiku);
    $cena_final = 0;
    $x = 0;
  	$klice = array_keys($this->obsah_kosiku);  	

  	
  	if($this->cenova_skupina_zakaznika)
     {
     $cena = 'cena_'.$this->cenova_skupina_zakaznika;
     }
     else
     {
     $cena = 'cena_A';  
     }
  	
  	
  		foreach($klice as $k => $v)
  		{
  		
  		list($zbozi,$varianta,$varianta2) = explode('|',$klice[$x]);
  		
  	    $result = mysql_query("SELECT P.id,P.sleva,P.platnost_slevy, P.$cena AS CENA_DB, D.dph FROM produkty P 
  	    LEFT JOIN dph D ON D.id=P.id_dph 
		WHERE P.id=".intval($zbozi)." ") or die(err(1));
  		$row = mysql_fetch_object($result);
  		
  		
  		
			   
			   $cena_p = $row->CENA_DB;  
			   $pocet_ks = $this->obsah_kosiku[$row->id."|".$varianta."|".$varianta2];
			   $name_z = $row->id."|".$varianta."|".$varianta2;

			  
			  
					//s DPH  
					if($row->sleva>0 && ($row->platnost_slevy>time())) 
					{//sleva
					$cena_final = $cena_final + ((($cena_p * $pocet_ks) - ($cena_p * $pocet_ks/100 * $row->sleva)));
					}
					else
					{  			        
					  if($this->slevova_skupina_zakaznika>0)
					  {
					  $cena_final = $cena_final + ((($cena_p * $pocet_ks) - ($cena_p  *$pocet_ks/100 * $this->slevova_skupina_zakaznika)));
					  }
					  else
					  {
					  $cena_final = $cena_final + ($cena_p * $pocet_ks);
					  }
					}

				   
		   
		$x++;
		}
		mysql_free_result($result);

	  $this->cena_kosiku = round($cena_final);
    }
  	else
  	{
  	$this->pocet_ks = 0;
  	$this->cena_kosiku = 0;
  	}
  	

	echo $this->pocet_ks;
	
	
   
   
   }   
  
  public function PodrobnyVypis()
  {  
    $this->pocet_ks = array_sum($this->obsah_kosiku);
    $cena_final = 0;
	$cena_puvodni = 0;
	$puvodni_cena_slevnenych_produktu = 0;
    $x = 0;
    $xx = 0;
    $id_zbozi_arr = '';
    
  	$klice = array_keys($this->obsah_kosiku);  	
  	
  	if($this->cenova_skupina_zakaznika)
     {
     $cena = 'cena_'.$this->cenova_skupina_zakaznika;
     }
     else
     {
     $cena = 'cena_A';  
     }
     
  	
  	$tabulka_kosik = '<form name="zmena_poctu" method="post" action="/skripty/zmena_poctu.php">
	<table cellspacing="0" cellpadding="0" style="width: 100%">
    <tr style="font-size: 15px; color: #1f1f1f;">
	<td style="width: 40%; height: 28px;">Produkt</td>
	<td style="width: 15%;">Dostupnost</td>
	<td style="width: 15%;">Počet</td>
	<td style="width: 15%;">Cena za kus</td>
	<td style="width: 15%;">Cena celkem</td>
	</tr>';
	

	
         
         // musime vyseparovat pole ID produktu jeste pred samotnou smyckou do niz pole budeme predavat v parametru pro js funkci
         // zmena prepoctu cen dynamicky javascriptem
         foreach($klice as $kz => $vz)
		 {
		  list($zbozi_z,$varianta_z,$varianta2_z) = explode('|',$klice[$xx]);	 
		  $id_zbozi_arr[] = $zbozi_z;
		  $xx++;
		 }
		 
		 $js_arr_z = "[";
		 $js_arr_z .=  implode(",",$id_zbozi_arr); 
		 $js_arr_z .= "]";
		 
		 
		 
		 
  	
		foreach($klice as $k => $v)
		{
			
		$cena_ks = '';
		list($zbozi,$varianta,$varianta2) = explode('|',$klice[$x]);
		
		
	
		$result = mysql_query("SELECT P.id, P.str, P.nazev, P.kat_cislo, P.sleva, P.$cena AS CENA_DB,
		P.platnost_slevy, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
		FROM produkty P 
		LEFT JOIN dph DP ON DP.id=P.id_dph 
		LEFT JOIN obrazky O ON O.idp=P.id 
		LEFT JOIN dostupnost D ON D.id=P.id_dostupnost  
		WHERE P.aktivni=1 AND O.typ=1 AND P.id=".intval($zbozi)." ") or die(err(1));
        $row = mysql_fetch_object($result);

        
        
		
		//obrazek
		  if(!$row->ONAZ)
		    {
		    $row->ONAZ = "neni.gif";
		    }
			
		  $url = url_produktu($row->id,$row->id_kategorie);	
		  

			$pocet_ks = $this->obsah_kosiku[$row->id."|".$varianta."|".$varianta2];
			$name_z = $row->id."|".$varianta."|".$varianta2;
       
      
   

		
      // cena za kus
      //s DPH  
  				if($row->sleva>0 && ($row->platnost_slevy>time())) 
  				{//sleva
  				$cena_ks = round(($row->CENA_DB - ($row->CENA_DB  /100 * $row->sleva)) );

  				}
  				else
  				{  			        
				  if($this->slevova_skupina_zakaznika>0)
				  {
				  $cena_ks = round(($row->CENA_DB - ($row->CENA_DB  /100 * $this->slevova_skupina_zakaznika)) );

				  }
				  else
				  {
				  $cena_ks = round($row->CENA_DB);

				  }
        	    }
				
				
	  $cena_final = $cena_final + ($cena_ks * $pocet_ks);	
			
			
           $tabulka_kosik .=  '<tr>
           <td colspan="5">
           <div class="kos_box1">
           <table style="width: 100%;" cellspacing="0" cellpadding="0">
           <tr>
           <td style="width: 40%;" ><div style="float: left; width: 84px; height: 84px; line-height: 84px; border: solid 1px #dadada; text-align: center; overflow: hidden; margin-right: 20px;"><img src="'.__URL2__.'/img_produkty/male/'.$row->ONAZ.'" style="width: 84px; vertical-align: middle;" /></div>
           <span style="font-size: 20px; font-weight: bold; color: #1f1f1f;">'.stripslashes($row->nazev).'</span><br /><span style="color: #777777; font-size: 14px;">Katalogové číslo: '.stripslashes($row->kat_cislo).'</span></td>';
                   

           
           $tabulka_kosik .= '<td style="width: 15%;">';
           if($row->dostupnost=='skladem')
           {
			   $tabulka_kosik .= '<img src="/img/fajka2.png" alt="skladem" style="vertical-align: middle;" /> <span style="font-size: 16px; color: #31C907;">'.$row->dostupnost.'</span>';
		   }
		   else
		   {
			   $tabulka_kosik .= '<span style="font-size: 16px; color: #4ba4ce;">'.$row->dostupnost.'</span>';
		   }
           $tabulka_kosik .= '</td>
           <td style="width: 15%;"><input type="text" size="3" name="'.$name_z.'" value="'.$pocet_ks.'" id="pocet_ks_'.$row->id.'" ';
           if($_GET['krok']!=1){$tabulka_kosik .= ' readonly ';}
           $tabulka_kosik .= ' class="input_detail2" />';
           
           if($_GET['krok']==1)
           {
           $tabulka_kosik .= '<img src="/img/tl_nahoru.png" alt="+" style="float: left; cursor: pointer;" onclick="pridej('.$row->id.','.$cena_ks.','.$js_arr_z.');" /><img src="/img/tl_dolu.png" alt="-" style="float: left; margin-top: 16px; margin-left: -23px; cursor: pointer;" onclick="uber('.$row->id.','.$cena_ks.','.$js_arr_z.');" />';
	       }
	       
            $tabulka_kosik .= ' <img src="/img/blank.gif" style="width: 10px; height: 25px;" />Ks</td>
           <td style="width: 15%;">&nbsp;&nbsp;<span style="color: #222222;">'.$cena_ks.' '.__MENA__.'</span></td>
           <td style="width: 15%;">&nbsp;&nbsp;<span style="font-weight: bold; color: #222222;" id="cena_row_'.$row->id.'">'.($cena_ks * $pocet_ks).'</span>
            <span style="font-weight: bold; color: #222222;">'.__MENA__.'</span>';
           
           if($_GET['krok']==1)
           {   
           $tabulka_kosik .= '<a href="/skripty/smazat_z_kosiku.php?idz='.$name_z.'&a=delete" title="smazat z košíku"><img src="/img/smazat.png" style="float: right; border: 0px;" /></a>';
	       }
           
           $tabulka_kosik .= '</td></tr>
           </table>
           </div>
           </td></tr>';
           
           
  


          
          
            
    
    $x++;  
    
   }
   
   
   $tabulka_kosik .= '</table></form><div id="idp_div" style="display: none;"></div>';
   

   
   // tlacitka
   if($_GET['krok']==1)
   {
	   
    // celkova cena
    

    
    $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>
    <div class="kos_celkem">
    <img src="/img/auto2.png" alt="doprava zdarma" style="float: left;" />
    <div style="float: left; margin-top: 0px;"><span style="font-size: 18px; color: #1f1f1f;  font-weight: bold;">Doprava zdarma</span><br />
    <span style="font-size: 18px; color: #1f1f1f; font-weight: 300;">nad '.__PAB_2__.' '.__MENA__.'</span></div>
    
    <div class="kos_celkem_in">Celkem: &nbsp;&nbsp;<span style="font-size: 34px; color: #1f1f1f;  font-weight: bold;" id="js_cena">'.$cena_final.'</span> 
    <span style="font-size: 34px; color: #1f1f1f; font-weight: bold;">'.__MENA__.'</span><br />
    <span style="font-size: 14px; color: #777777;">včetně DPH</span></div>';
   

   
   $tabulka_kosik .= '<div class="clear" style="height: 30px;"></div>';

   
   
          // doprava
   $tabulka_kosik .= '&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 28px; font-weight: bold; color: #FFD631;">1.</span> <span style="font-size: 24px; font-weight: 500; color: #1f1f1f;">ZVOLTE ZPŮSOB DOPRAVY</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>';
   
    	   // nejdrive musime zjistit zda se v kosiku nachazi pouze produkt s atributem specialni_doprava
    	   
    	   $special = 1;
    	   
    	   foreach($this->obsah_kosiku as $k_id => $k_poc)
    	   {
			   $idpr = intval($k_id);
			   $query_prk = MySQL_Query("SELECT specialni_doprava FROM produkty WHERE id=".$idpr."  ") or die(err(1));
			   $row_prk = mysql_fetch_object($query_prk);
			   if($row_prk->specialni_doprava!=1)
			   {
				   $special = 0;
			   }
			   
			   
	
		   }
		   
		   
		   if($special==1)
		   {
			   $sql_special = "  ";
		   }
		   else
		   {
			   $sql_special = " AND specialni_doprava=0 ";
		   }
		   
		   // upravy pro PPL partner a GLS
		   
            $from_ppl = false;
            $from_gls = false;
			
			if(strstr($_SERVER['HTTP_REFERER'],"pplbalik"))
			{
			  $from_ppl = true;
			}
			
			if(strstr($_SERVER['HTTP_REFERER'],"gls-czech.cz"))
			{
			  $from_gls = true;
			}
		   

    	   
    	   $query_doprava = MySQL_Query("SELECT * FROM doprava WHERE aktivni=1 ".$sql_special." ") or die(err(1));
			$tabulka_kosik .=  '<form name="pokladna_1" method="post" action="/kosik.html?krok=2" onsubmit="return validate_kosik1();" >
					<table  style="width: 95%; float: right; color: #1f1f1f;">';
						while($row_doprava = mysql_fetch_object($query_doprava)) 
						{	
							// pokud nakoupi zakaznik nad pozadovanou cenu vynulujeme ceny za dopravu a platbu
							if($cena_final > __PAB_2__)	
							{
								$row_doprava->cena = 0;
							}
							
							$js_arr = "['";
							$js_arr_unserialize = unserialize($row_doprava->platba_arr);
							$js_arr_unserialize_flip = array_flip($js_arr_unserialize);
							if($cena_final < 3000)
							{
							   // pokud je cena nizsi nez 3000 tak z pole plateb musime odstranit essox
							   unset($js_arr_unserialize_flip['4']);
							}
							
							$js_arr_unserialize = array_flip($js_arr_unserialize_flip);
							
							$js_arr .=  implode("','",$js_arr_unserialize); 
							$js_arr .= "']";
							
					$tabulka_kosik .= '<tr><td style="width: 95%; height: 30px;">
					<input type="radio" name="doprava" value="'.$row_doprava->id.'|'.$row_doprava->cena.'" id="d_'.$row_doprava->id.'" '; 
					if($row_doprava->id==$_SESSION['doprava']){ $tabulka_kosik .= ' checked ';}
					$tabulka_kosik .= " onclick=\"prepocitej_js_cenu2('".$cena_final."',".$js_arr_z.");disabluj_platbu(".$js_arr.");";
					
					// PPL point
						      if($row_doprava->id==7)
						      {
								  // pokud je zakaznik v tomto kroku prihlasen tam vygenerujeme do odkazu jeho adresu
								  if($_SESSION['prihlaseni'])
								  {
								     list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
								     
								      $query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($id_zak_sess)."'") or die(err(1));
									  $row_zakaznik = mysql_fetch_object($query_zakaznik);
								   
								      $ulice = $row_zakaznik->ulice;
									  $cislo = $row_zakaznik->cislo;
									  $psc = $row_zakaznik->psc;
							      }
							      else
							      {
									  $ulice = 'Podpuklí';
									  $cislo = '288';
									  $psc = '73801';
								  }
								 
								 $url_ppl_navrat = 'https://www.hifistereo.cz/kosik.html?sessid='.session_id().'&KTMID={0}&KTMaddress={1}&KTMname={2}';
								  
								  
								  
								$tabulka_kosik .= "navigateToUrl('https://www.pplbalik.cz/Main3.aspx?cls=KTMMap&CountryCode=CZ&KTMAddress=".$psc.",".$ulice." ".$cislo."&ReturnUrl=".urlencode($url_ppl_navrat)."');";  
							  }
							  
							  
							  // GLS
						      if($row_doprava->id==4)
						      {
								  // pokud je zakaznik v tomto kroku prihlasen tak vygenerujeme do odkazu jeho adresu
								  if($_SESSION['prihlaseni'])
								  {
								     list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
								     
								      $query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($id_zak_sess)."'") or die(err(1));
									  $row_zakaznik = mysql_fetch_object($query_zakaznik);
								   
								      $ulice = $row_zakaznik->ulice;
									  $mesto = $row_zakaznik->obec;

							      }
							      else
							      {
									  $ulice = 'Podpuklí';
									  $mesto = 'Frýdek-Místek';

								  }
	
								  
								$tabulka_kosik .= "navigateToUrl('https://help.gls-czech.cz/cs/maps?p=".$ulice.",".$mesto."&find=1&var=|doprava=4');";  
							  }
												  
												  
												  
							  if($row_doprava->id!=7)
						      {
								$tabulka_kosik .= "skryj_ppl('div_GPA3','".intval($id_zak_sess)."');";  
							  }
							  
							  if($row_doprava->id!=4)
						      {
								$tabulka_kosik .= "skryj_gls('div_GPA4','".intval($id_zak_sess)."');";  
							  }
					
					$tabulka_kosik .= "\" ";
					
					if($from_ppl && $row_doprava->id == 7)
							  {
							    $tabulka_kosik .= ' checked  ';
							  }
							  
					if($from_gls && $row_doprava->id == 4)
							  {
							    $tabulka_kosik .= ' checked  ';
							  }
					
					$tabulka_kosik .= ' /> 
					<label for="d_'.$row_doprava->id.'" style="cursor: pointer; _cursor: hand;">&nbsp;&nbsp;'.$row_doprava->text.'</label>';
					
					
					if($from_ppl && $row_doprava->id == 7)
					  {
						 
						  
						$tabulka_kosik .= '<div style="margin-left: 25px; padding: 10px; border: solid 1px red;" id="div_GPA3">PPL partner '.strip_tags($_GET['KTMname']).',<br />';
					    $tabulka_kosik .= strip_tags($_GET['KTMaddress']);
					    $tabulka_kosik .= '<input type="hidden" name="KTMID" value="'.strip_tags($_GET['KTMID']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="KTMname" value="'.strip_tags($_GET['KTMname']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="KTMaddress" value="'.strip_tags($_GET['KTMaddress']).'" />';
					    $tabulka_kosik .= '<div class="clear"></div></div><div class="clear"></div>';
				      }
				     else
				      {
						  $_SESSION['KTMID'] = '';
						  $_SESSION['KTMname'] = '';
						  $_SESSION['KTMaddress'] = '';
					  } 
					  
					  
					  if($from_gls && $row_doprava->id == 4)
					  {
						 
						  
						$tabulka_kosik .= '<div style="margin-left: 25px; padding: 10px; border: solid 1px red;" id="div_GPA4">GLS ParcelShop '.strip_tags($_GET['name']).',<br />';
					    $tabulka_kosik .= strip_tags($_GET['address']);
					    $tabulka_kosik .= '<br>'.strip_tags($_GET['city']);
					    $tabulka_kosik .= '<br>'.strip_tags($_GET['zipcode']);
					    $tabulka_kosik .= '<input type="hidden" name="gls_name" value="'.strip_tags($_GET['name']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="gls_address" value="'.strip_tags($_GET['address']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="gls_city" value="'.strip_tags($_GET['city']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="gls_zipcode" value="'.strip_tags($_GET['zipcode']).'" />';
					    $tabulka_kosik .= '<input type="hidden" name="gls_id" id="gls_id" value="'.strip_tags($_GET['id']).'" />';
					    $tabulka_kosik .= '<div class="clear"></div>
					    </div>
					    <div class="clear"></div>';
				      }
				      else
				      {
						  $_SESSION['gls_name'] = '';
						  $_SESSION['gls_address'] = '';
						  $_SESSION['gls_city'] = '';
						  $_SESSION['gls_zipcode'] = '';
						  $_SESSION['gls_id'] = '';
					  }
					
					
					// vygenerujeme selectbox s pobockami DPD
					/*if($row_doprava->id==4)
					{
					  $tabulka_kosik .= '<div id="dpd_sel_div" ';
					  if($_SESSION['doprava']==4){ $tabulka_kosik .= ' style="display: block;" ';}
					  else{ $tabulka_kosik .= ' style="display: none;" ';}
					  $tabulka_kosik .= ' >';
					
					  $tabulka_kosik .= '<div class="clear" style="height: 10px;"></div>';
						$tabulka_kosik .= '<select name="dpd_pobocka" id="dpd_pobocka">
						<option value=""> -- vyberte pobočku -- </option>';
						
						$query_dpd = MySQL_Query("SELECT * FROM dpd ORDER BY mesto, ulice") or die(err(1));
						while($row_dpd = mysql_fetch_object($query_dpd)) 
						{
						  $tabulka_kosik .= '<option value="'.$row_dpd->id_dpd.'" ';
						  if($row_dpd->id_dpd==$_SESSION['dpd_pobocka']){ $tabulka_kosik .= ' selected ';}
						  $tabulka_kosik .='> '.stripslashes($row_dpd->mesto).', '.stripslashes($row_dpd->ulice).' '.stripslashes($row_dpd->cislo).', '.stripslashes($row_dpd->nazev).' </option>';
						}
						
						
						$tabulka_kosik .='</select>'; 
						$tabulka_kosik .= '</div>';
						
					}*/
					
					
					
					$tabulka_kosik .= '</td>
					<td style="height: 30px;" ><b>'.$row_doprava->cena.' '.__MENA__.'</b></td></tr>';
					
					$tabulka_kosik .= '<tr><td colspan="2"><div class="cara"></div></td></tr>';
						}
						
						
				$tabulka_kosik .= '</table>';		  
				$tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>'; 
				
				
				
   
   // platba
   $tabulka_kosik .= '&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 28px; font-weight: bold; color: #FFD631;">2.</span> <span style="font-size: 24px; font-weight: 500; color: #1f1f1f;">ZVOLTE ZPŮSOB PLATBY</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>';
   
    	   $query_platba = MySQL_Query("SELECT * FROM platba WHERE aktivni=1  ") or die(err(1));
					$tabulka_kosik .=  '
					<table  style="width: 95%; float: right; color: #1f1f1f;" >';
						while($row_platba = mysql_fetch_object($query_platba)) 
						{	
							// pokud nakoupi zakaznik nad pozadovanou cenu vynulujeme ceny za dopravu a platbu
							if($cena_final > __PAB_2__)	
							{
								$row_platba->cena = 0;
							}
							
					
									if($row_platba->id==4)
									{
										
										if($cena_final > 3000)
										{
												
												 
												 $tabulka_kosik .= '<tr name="div_platba" id="div_'.$row_platba->id.'" '; 
									
												   if($row_platba->id==$_SESSION['platba'])
													{
														$tabulka_kosik .=' style="display: table-row; border-bottom: solid 1px #dadada;" ';
													}
													else
													{
														$tabulka_kosik .=' style="display: none;" ';
													}
												$tabulka_kosik .= '><td style="width: 1018px; height: 30px; border-bottom: solid 1px #dadada;">';
												
												$tabulka_kosik .=' 
									<input type="radio" name="platba" value="'.$row_platba->id.'|'.$row_platba->cena.'" id="p_'.$row_platba->id.'" '; 
									if($row_platba->id==$_SESSION['platba']){ $tabulka_kosik .= ' checked ';}
									$tabulka_kosik .= " onclick=\"prepocitej_js_cenu2('".$cena_final."',".$js_arr_z.");\" ";
									$tabulka_kosik .= ' /> 
									<label for="p_'.$row_platba->id.'" style="cursor: pointer; _cursor: hand;">&nbsp;&nbsp;'.$row_platba->text.'</label></td>
									<td  style="height: 30px; border-bottom: solid 1px #dadada;"><b>'.$row_platba->cena.' '.__MENA__.'</b></td></tr>';
								      }
												 
												
									}
									else
								    {
										$tabulka_kosik .= '<tr name="div_platba" id="div_'.$row_platba->id.'" '; 
									
									   if($row_platba->id==$_SESSION['platba'])
										{
											$tabulka_kosik .=' style="display: table-row; border-bottom: solid 1px #dadada;" ';
										}
										else
										{
											$tabulka_kosik .=' style="display: none;" ';
										}
									   $tabulka_kosik .= '><td style="width: 1018px; height: 30px; border-bottom: solid 1px #dadada;">';
								
										
										
										$tabulka_kosik .=' 
									<input type="radio" name="platba" value="'.$row_platba->id.'|'.$row_platba->cena.'" id="p_'.$row_platba->id.'" '; 
									if($row_platba->id==$_SESSION['platba']){ $tabulka_kosik .= ' checked ';}
									$tabulka_kosik .= " onclick=\"prepocitej_js_cenu2('".$cena_final."',".$js_arr_z.");\" ";
									$tabulka_kosik .= ' /> 
									<label for="p_'.$row_platba->id.'" style="cursor: pointer; _cursor: hand;">&nbsp;&nbsp;'.$row_platba->text.'</label></td>
									<td  style="height: 30px; border-bottom: solid 1px #dadada;"><b>'.$row_platba->cena.' '.__MENA__.'</b></td></tr>';
										
									}
					
					
						}
						
						
				$tabulka_kosik .= '</table>';		
				
				

				$tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>';		
    	   

    	   
    // poznamka
   $tabulka_kosik .= '&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 28px; font-weight: bold; color: #FFD631;">3.</span> <span style="font-size: 24px;  font-weight: 500; color: #1f1f1f;">POZNÁMKA</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>';	 
   $tabulka_kosik .= '<textarea name="poznamka" class="poznamka_kosik">'.strip_tags($_SESSION['poznamka']).'</textarea>';
   $tabulka_kosik .= '<div style="float: right; width: 500px;">Chcete nám sdělit ještě nějakou důležitou zprávu k vaší objednávce?<br />Využijte prosím, tohoto formuláře.
   <br /><br />Napsat do něj můžete také upřesňující informace o místě, kam máme Vaše zboží doručit (nejbližší orientační bod apod.)</div>';
   $tabulka_kosik .= '<div class="clear" style="height: 30px;"></div>';	 
   
    	   
   $tabulka_kosik .=  '<input type="button" class="sub_dk3"  title="pokračovat v nákupu" value="Pokračovat v nákupu"  style="float: left;" 
   onclick="self.location.href=\'/\'" />'; 	
   
   $tabulka_kosik .=  '<input type="submit" class="sub_dk2"   title="Pokračovat v objednávce" value="Pokračovat v objednávce"  style="float: right;" />';
   
   $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div></form></div>';
   

   }
   
   
   if($_GET['krok']==3)
   {
	   
	   
	   
	   list($platba_id,$platba_cena) = explode("|",$_POST['platba']);
	   list($doprava_id,$doprava_cena) = explode("|",$_POST['doprava']);
	   
	   // doprava
		$query_doprava = MySQL_Query("SELECT * FROM doprava WHERE id = '".intval($doprava_id)."'") or die(err(1));
		$row_doprava = mysql_fetch_object($query_doprava); 
		
		if($cena_final > __PAB_2__)	
		{
			$row_doprava->cena = 0;
		}
		
		// platba
		$query_platba = MySQL_Query("SELECT * FROM platba WHERE id = '".intval($platba_id)."'") or die(err(1));
		$row_platba = mysql_fetch_object($query_platba); 
		
		if($cena_final > __PAB_2__)	
		{
			$row_platba->cena = 0;
		}

    $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div>
    <div class="kos_celkem">
    <div style="float: left; margin-top: 0px;"><span style="font-size: 18px; color: #1f1f1f;  font-weight: 500;">Způsob platby:</span>
    <span style="font-size: 18px;"> '.$row_platba->text.' <b>'.$row_platba->cena.' '.__MENA__.'</b></span><br />
    <span style="font-size: 18px; color: #1f1f1f; font-weight: 500;">Způsob dopravy:</span>
    <span style="font-size: 18px; "> '.$row_doprava->text.' <b>'.$row_doprava->cena.' '.__MENA__.'</b></span>
     <br />
    </div>
    
    
    <div class="kos_celkem_in">Celkem: &nbsp;&nbsp;<span style="font-size: 34px; color: #1f1f1f; font-weight: bold;" id="js_cena">'.($cena_final + $row_platba->cena + $row_doprava->cena).'</span> 
    <span style="font-size: 34px; color: #1f1f1f;  font-weight: bold;">'.__MENA__.'</span><br />
    <span style="font-size: 14px; color: #777777;">včetně DPH</span></div>';
    
   
   
  
   
   $tabulka_kosik .= '<div class="clear" style="height: 10px;"></div>';
   
   
   list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
   
   $query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($id_zak_sess)."'") or die(err(1));
   $row_zakaznik = mysql_fetch_object($query_zakaznik);
   
   // rekapitulace 3 x box
   $tabulka_kosik .= '<div class="box_rek_kosik">';
   $tabulka_kosik .= '<span style="font-size: 24px; color: #FFD631; font-weight: bold;">1.</span> 
   <span style="font-size: 24px; color: #1f1f1f; font-weight: 500;">Osobní údaje</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 10px;"></div>
   <div class="cara"></div>
   <div class="clear" style="height: 10px;"></div>';
   $tabulka_kosik .= '<b>Jméno:</b> '.$row_zakaznik->jmeno.'<br />';
   $tabulka_kosik .= '<b>Příjmení:</b> '.$row_zakaznik->prijmeni.'<br />';
   $tabulka_kosik .= '<b>Ulice:</b> '.$row_zakaznik->ulice.'<br />';
   $tabulka_kosik .= '<b>Č.p.:</b> '.$row_zakaznik->cislo.'<br />';
   $tabulka_kosik .= '<b>Obec:</b> '.$row_zakaznik->obec.'<br />';
   $tabulka_kosik .= '<b>PSČ:</b> '.$row_zakaznik->psc.'<br />';
   $tabulka_kosik .= '<b>Stát:</b> '.$_SESSION['arr_staty'][$row_zakaznik->stat].'<br />';
   $tabulka_kosik .= '<b>E-mail:</b> '.$row_zakaznik->eml.'<br />';
   $tabulka_kosik .= '<b>Telefon:</b> '.$row_zakaznik->telefon.'<br />';
   
   if($_SESSION['dpd_pobocka'])
   {
	   $tabulka_kosik .= '<b>DPD ParcelShop:</b> ';
	   
	   $query_dpd = MySQL_Query("SELECT * FROM dpd WHERE id_dpd = '".intval($_SESSION['dpd_pobocka'])."'") or die(err(1));
       $row_dpd = mysql_fetch_object($query_dpd);
	   
	   $tabulka_kosik .= stripslashes($row_dpd->nazev).', '.stripslashes($row_dpd->ulice).' '.stripslashes($row_dpd->cislo).', '.stripslashes($row_dpd->mesto).', '.stripslashes($row_dpd->psc).'<br />';
   }
   
   
   $tabulka_kosik .= '</div>';
   
   $tabulka_kosik .= '<div class="box_rek_kosik">';
   $tabulka_kosik .= '<span style="font-size: 24px; color: #FFD631; font-weight: bold;">2.</span> 
   <span style="font-size: 24px; color: #1f1f1f;  font-weight: 500;">Fakturační adresa</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 10px;"></div>
   <div class="cara"></div>
   <div class="clear" style="height: 10px;"></div>';
   if($row_zakaznik->reg_fak_ico || $row_zakaznik->reg_fak_jmeno_prijmeni || $row_zakaznik->reg_fak_nazev_firmy)
	{
		list($fak_jm,$fak_pr) = explode(" ",$row_zakaznik->reg_fak_jmeno_prijmeni);
		
   $tabulka_kosik .= '<b>Jméno:</b> '.$fak_jm.'<br />';
   $tabulka_kosik .= '<b>Příjmení:</b> '.$fak_pr.'<br />';
   $tabulka_kosik .= '<b>Název firmy:</b> '.$row_zakaznik->reg_fak_nazev_firmy.'<br />';
   $tabulka_kosik .= '<b>IČ:</b> '.$row_zakaznik->reg_fak_ico.'<br />';
   $tabulka_kosik .= '<b>DIČ:</b> '.$row_zakaznik->reg_fak_dic.'<br />';
   $tabulka_kosik .= '<b>Ulice:</b> '.$row_zakaznik->reg_fak_ulice.'<br />';
   $tabulka_kosik .= '<b>Č.p.:</b> '.$row_zakaznik->	reg_fak_cislo.'<br />';
   $tabulka_kosik .= '<b>Obec:</b> '.$row_zakaznik->reg_fak_obec.'<br />';
   $tabulka_kosik .= '<b>PSČ:</b> '.$row_zakaznik->reg_fak_psc.'<br />';
   $tabulka_kosik .= '<b>E-mail:</b> '.$row_zakaznik->eml.'<br />';
   $tabulka_kosik .= '<b>Telefon:</b> '.$row_zakaznik->telefon.'<br />';
	
	}
	else
	{
   $tabulka_kosik .= '<b>Jméno:</b> '.$row_zakaznik->jmeno.'<br />';
   $tabulka_kosik .= '<b>Příjmení:</b> '.$row_zakaznik->prijmeni.'<br />';
   $tabulka_kosik .= '<b>Ulice:</b> '.$row_zakaznik->ulice.'<br />';
   $tabulka_kosik .= '<b>Č.p.:</b> '.$row_zakaznik->cislo.'<br />';
   $tabulka_kosik .= '<b>Obec:</b> '.$row_zakaznik->obec.'<br />';
   $tabulka_kosik .= '<b>PSČ:</b> '.$row_zakaznik->psc.'<br />';
   $tabulka_kosik .= '<b>Stát:</b> '.$_SESSION['arr_staty'][$row_zakaznik->stat].'<br />';
   $tabulka_kosik .= '<b>E-mail:</b> '.$row_zakaznik->eml.'<br />';
   $tabulka_kosik .= '<b>Telefon:</b> '.$row_zakaznik->telefon.'<br />';
	}

   $tabulka_kosik .= '</div>';
   
   
   
   $tabulka_kosik .= '<div class="box_rek_kosik" style="margin-right: 0px;">';
   $tabulka_kosik .= '<span style="font-size: 24px; color: #FFD631; font-weight: bold;">3.</span> 
   <span style="font-size: 24px; color: #1f1f1f; font-weight: 500;">Dodací adresa</span>';
   $tabulka_kosik .= '<div class="clear" style="height: 10px;"></div>
   <div class="cara"></div>
   <div class="clear" style="height: 10px;"></div>';
   if($_SESSION['KTMID'])
   {
	   $tabulka_kosik .= '<b>PPL partner: <br />'.$_SESSION['KTMname'].'</b><br />';
	   $tabulka_kosik .=  $_SESSION['KTMaddress'];
   }
   elseif($_SESSION['gls_name'] && $row_doprava->id==4)
   {
		 $tabulka_kosik .= '<b>GLS ParcelShop</b><br />'.strip_tags($_SESSION['gls_name']);
		 $tabulka_kosik .= '<br />'.strip_tags($_SESSION['gls_address']);
		 $tabulka_kosik .= '<br />'.strip_tags($_SESSION['gls_city']);
		 $tabulka_kosik .= '<br />'.strip_tags($_SESSION['gls_zipcode']);
   }		
   elseif($row_zakaznik->reg_dod_obec)
   {
	   	
	list($dod_jm,$dod_pr) = explode(" ",$row_zakaznik->reg_dod_jmeno_prijmeni);
		
   $tabulka_kosik .= '<b>Jméno:</b> '.$dod_jm.'<br />';
   $tabulka_kosik .= '<b>Příjmení:</b> '.$dod_pr.'<br />';
   $tabulka_kosik .= '<b>Název firmy:</b> '.$row_zakaznik->reg_dod_nazev_firmy.'<br />';
   $tabulka_kosik .= '<b>Ulice:</b> '.$row_zakaznik->reg_dod_ulice.'<br />';
   $tabulka_kosik .= '<b>Č.p.:</b> '.$row_zakaznik->	reg_dod_cislo.'<br />';
   $tabulka_kosik .= '<b>Obec:</b> '.$row_zakaznik->reg_dod_obec.'<br />';
   $tabulka_kosik .= '<b>PSČ:</b> '.$row_zakaznik->reg_dod_psc.'<br />';
   $tabulka_kosik .= '<b>Stát:</b> '.$_SESSION['arr_staty'][$row_zakaznik->reg_dod_stat].'<br />';
   $tabulka_kosik .= '<b>E-mail:</b> '.$row_zakaznik->eml.'<br />';
   $tabulka_kosik .= '<b>Telefon:</b> '.$row_zakaznik->telefon.'<br />';
	}
	else
	{
		$tabulka_kosik .= ' Stejná jako fakturační';
	}
   
   $tabulka_kosik .= '</div>';
   
   
   $tabulka_kosik .= '<div class="clear" style="height: 20px;"></div> <form name="pokladna_1" method="post" action="/kosik.html?krok=4" >  <input class="form-check__input" type="checkbox" name="nesouhlas_heureka" value="1"> '.__KOSIK_HEUREKA_TEXT__.' <br />
   
   <input name="souhlas" id="osobni-udaje" type="checkbox" value="1" required>
                            <span>'.__KOSIK_SOUHLAS_OBCH_PODM__.'</span><br />';
   
   
   }
   

   $this->cena_final = $cena_final;
   
   return $tabulka_kosik;
   
 }
 
  public function Kroky($krok=1,$id_zak_sess)
  {
   // obsah vracime returnem do sablony	  
   // kroky 1 - 4 = pruchod kosikem az po odeslani objednavky
   // 1 - prehled kosiku s moznosti zmeny poctu kusu ci smazani
   // 2 - prihlaseni nebo registrace pokud user neni prihlaseny 
   // 3 - rekapitulace objednavky + zobrazeni kosiku + dodaci popripade fakturacni adresy +  vyber dopravy + vyber platby
   // 4 - odeslani objednavky
  
  $ret = '';
  
     if($krok==1)
     {

      $ret .= Kosik::PodrobnyVypis();
     }
     elseif($krok==2)
     {

     
    

	   
	          // neni prihlasen
	   $ret .= '<div class="div_kos_text">
				   <b>Nejste přihlášen/a</b>
				   <br /><br />
				   Pokud jste zaregistrovaným uživatelem, prosím <a href="/prihlaseni.html">přihlaste se zde</a>.
       <br />Pokud nejste registrovaným uživatelem, můžete se 
       <a href="/registrace.html" title="Registrace">zaregistrovat</a> 
       nebo pokračovat <a href="/bez-registrace.html">bez registrace vyplněním údajů pro dodání</a>.</div><div class="clear" style="height: 10px;"></div>';
	
	   
	   
	   $ret .= '<div style="width: auto; text-align: center">
	   <input type="button" name="but1" value="NÁKUP BEZ REGISTRACE" title="NÁKUP BEZ REGISTRACE" class="submit_but" onclick="self.location.href=\'/bez-registrace.html\'" />&nbsp;&nbsp;&nbsp;&nbsp;
	   <input type="button" name="but2" value="NÁKUP S REGISTRACÍ" title="NÁKUP S REGISTRACÍ" class="submit_but" onclick="self.location.href=\'/registrace.html\'" />
	   </div>';
       

       
       
     }
     elseif($krok==3)
     {
		 
		 
		 // uprava
		 if($_SESSION['doprava'])
		  {
			  $_POST['doprava'] = intval($_SESSION['doprava']);
		  }
		  if($_SESSION['platba'])
		  {
			  $_POST['platba'] = intval($_SESSION['platba']);
		  }
		  
		  if($_SESSION['dpd_pobocka'])
		  {
			  $_POST['dpd_pobocka'] = intval($_SESSION['dpd_pobocka']);
		  }
		  
		  if($_SESSION['poznamka'])
		  {
			  $_POST['poznamka'] = strip_tags($_SESSION['poznamka']);
		  }
		 

		 if(!$_POST['doprava'])
		 {
		  $ret .= '<span class="r">Nevybrali jste způsob dopravy!<br/>Vraťte se prosím <a href="/kosik.html?krok=1">zpět</a> a proveďte výběr.<br />
		  Klikněte opakovaně na vybraný typ dopravy, aby se Vám vygenerovala příslušná nabídka plateb pro danou volbu dopravy a vhodný typ platby označte.';
		 }
		 elseif(!$_POST['platba'])
		 {
		  $ret .= '<span class="r">Nevybrali jste způsob platby!<br/>Vraťte se prosím <a href="/kosik.html?krok=1">zpět</a> a proveďte výběr.';
		 }
		 elseif(!$_SESSION['prihlaseni'])
		 {
		  $ret .= '<span class="r">Vlivem dlouhodobé nečinnosti jste byl/a z bezpečnostních důvodů odhlášen/a. Přihlaste se prosím znovu.';
		 }
		
		 else
		 {

		
				   
				   
				   $ret .= Kosik::PodrobnyVypis();
				   $ret .=  '
				    <input type="hidden" name="doprava" value="'.$_POST['doprava'].'" /> 
					<input type="hidden" name="platba" value="'.$_POST['platba'].'" />
					<input type="hidden" name="dpd_pobocka" value="'.$_POST['dpd_pobocka'].'" />
					<input type="hidden" name="poznamka" value="'.strip_tags($_POST['poznamka']).'" />';
	
			 
			
		  
    	  $ret .= '<div class="clear" style="height: 10px;"></div>';
		  $ret .= '<br />';
		  
		  
		    	   
		  $ret .=  '<input type="button" class="sub_dk3"  title="pokračovat v nákupu" value="Pokračovat v nákupu"  style="float: left;" 
					onclick="self.location.href=\'/\'" />'; 	
   
		  $ret .=  '<input type="submit" class="sub_dk2"   title="Odeslat objednávku" value="Odeslat objednávku"  style="float: right;" />';

		  $ret .=  '</form>'; 	
		  
		  
		 }
     
     }
     elseif($krok==4)
     {
		 $noret = Kosik::PodrobnyVypis();
		 
		 
		
		 if(!$_POST['doprava'])
		 {
		  $ret .= '<span class="r">Nevybrali jste způsob dopravy!<br/>Vraťte se prosím <a href="/kosik.html?krok=1">zpět</a> a proveďte výběr.';
		 }
		 elseif(!$_POST['platba'])
		 {
		  $ret .= '<span class="r">Nevybrali jste způsob platby!<br/>Vraťte se prosím <a href="/kosik.html?krok=1">zpět</a> a proveďte výběr.';
		 }
		 elseif(!$_POST['souhlas'])
		 {
		  $ret .= '<span class="r">Nesouhlasili jste s obchodními podmínkami.<br/>Vraťte se prosím <a href="/kosik.html?krok=1">zpět</a>.';
		 }
		 else
		 {
		  // ulozeni objednavky
		   if($_SESSION["kosik"])
		   {
			   if($_SESSION['prihlaseni'])
			   {
			    list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
			    
			    
			    list($platba_id,$platba_cena) = explode("|",$_POST['platba']);
	            list($doprava_id,$doprava_cena) = explode("|",$_POST['doprava']);
				
				// doprava
				$query_doprava = MySQL_Query("SELECT * FROM doprava WHERE id = '".intval($doprava_id)."'") or die(err(1));
				$row_doprava = mysql_fetch_object($query_doprava); 
				
				
				// platba
				$query_platba = MySQL_Query("SELECT * FROM platba WHERE id = '".intval($platba_id)."'") or die(err(1));
				$row_platba = mysql_fetch_object($query_platba); 
				
				
				if($row_platba->karta==1)
				 {
				  $platba_karta_text = 'Nedokončený pokus o platbu kartou';	
				 }	
				 
				
				/*if($_POST['dpd_pobocka'] && $doprava_id!=4)
				{
					// pokud nevybere DPD ParcelShop ale vybere pobocku v selectboxu
					$_POST['dpd_pobocka'] = '';
				}*/
				
				if($_SESSION['gls_name'] && $doprava_id!=4)
				{
					// pokud nevybere GLS ParcelShop  
					$_SESSION['gls_name'] = '';
					$_SESSION['gls_address'] = '';
					$_SESSION['gls_city'] = '';
					$_SESSION['gls_zipcode'] = '';
					$_SESSION['gls_id'] = '';
				}
				
				
				
				if($_SESSION['KTMID'] && $doprava_id!=7)
				{
					// pokud nevybere PPL partner
					$_SESSION['KTMID'] = '';
					$_SESSION['KTMname'] = '';
					$_SESSION['KTMaddress'] = '';
				}


				$query_s = MySQL_Query("SELECT max(id_obj) AS MAXI FROM objednavky") or die(err(1));
				$row_s = mysql_fetch_object($query_s);
				
				$text_obj = '';
					
					if(!$row_s->MAXI)
					{
					 $posledni_id = "00001";
					 $id_obj = date("Y").$posledni_id;
					}
					else
					{
						// kazdy rok zacneme od 0001
						$rok_posledni_obj =  substr($row_s->MAXI,0,4);
							if($rok_posledni_obj!=date("Y"))
							{
							 // zmena roku
							 // zaciname od 0001
							 $posledni_id = "00001";
							 $id_obj = date("Y").$posledni_id;
								
							}
							else
							{
							$posledni_id = substr($row_s->MAXI,4,5);
							$posledni_id2 = ($posledni_id+1);
							$delka = strlen($posledni_id2);
								if($delka<5)
								{
								 for ($i = $delka; $i <= 4; $i++) 
								  {
								   $posledni_id2 = "0".$posledni_id2;
								  }
								}
							$id_obj = date("Y").$posledni_id2;
								
							}	
					

					}
					
					
					if($this->cena_final  > __PAB_2__)
					{
					$row_doprava->cena = 0;
					$row_platba->cena = 0;
					}  
					$klice = array_keys($_SESSION['kosik']);
					$i = 0;	
					
					$produkty2_heureka = '';
					$produkty_heureka = '';
					
					
					
					    // inicializace zboží.cz
					   /* $zbozi_s = new ZboziKonverze(119597, "ruqMBvvEWAkKI7/Qp/Szn9mhbbdsbgsN");
					
					    // testovací režim
					    //$zbozi->useSandbox(true);
					
					    // nastavení informací o objednávce
					    $zbozi_s->setOrder(array(
					        "deliveryType" => $row_doprava->text,
					        "deliveryDate" => date("Y-m-d"),
					        "deliveryPrice" => $row_doprava->cena,
					        "email" => $row_zakaznik->eml,
					        "orderId" => $id_obj,
					        "otherCosts" => $row_platba->cena,
					        "paymentType" => $row_platba->text,
					        "totalPrice" => round($this->cena_final + $row_doprava->cena + $row_platba->cena)  
					    ));*/
					    


					
					foreach($klice as $k => $v)
						{
							
							list($zbozi,$varianta,$varianta2) = explode('|',$klice[$i]);
	
							$cena_db = 'cena_'.addslashes($this->cenova_skupina_zakaznika);
							
		
							$result_obj = mysql_query("SELECT P.id, P.str, P.nazev, P.sleva, P.kat_cislo, P.ks_skladem, P.$cena_db AS CENA_DB,  
							P.platnost_slevy, P.sleva, P.id_kategorie, D.dostupnost, DP.dph
							FROM produkty P 
							LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
							LEFT JOIN dph DP ON DP.id=P.id_dph 
							WHERE P.id=".intval($zbozi)." ") or die(err(1));
							$row_obj = mysql_fetch_object($result_obj); 
							
							

						  
							$cena = '';
							$pocet_ks = $_SESSION['kosik'][$row_obj->id."|".$varianta."|".$varianta2];
							$nazev_do_db = stripslashes($row_obj->nazev); 
	
							
							if($row_obj->sleva>0 && ($row_obj->platnost_slevy>time())) 
							{//sleva
							$cena_ks = round(($row_obj->CENA_DB - ($row_obj->CENA_DB  /100 * $row_obj->sleva)));

							}
							else
							{  			        
							  if($this->slevova_skupina_zakaznika>0)
							  {
							  $cena_ks = round(($row_obj->CENA_DB - ($row_obj->CENA_DB  /100 * $this->slevova_skupina_zakaznika)));
		
							  }
							  else
							  {
							  $cena_ks = round($row_obj->CENA_DB);
		
							  }
							}
							
							$text_obj .= "<tr><td>".stripslashes($row_obj->nazev)."</td>";
							$text_obj .= "<td>".$pocet_ks."</td>";
							$text_obj .= "<td>".round($cena_ks)." ".__MENA__." </td>";	       
							$text_obj .= "<td>".intval($row_obj->dph)."%</td>"; 
							$text_obj .= "<td>".round($pocet_ks*$cena_ks)." ".__MENA__." </td>";  
							$text_obj .=  "</tr>";	
							
							if($_SESSION['KTMID'])
							{
							    $ppl_sql_adr = addslashes($_SESSION['KTMname'])."; ".addslashes($_SESSION['KTMaddress']);
							}
							else
							{
								$ppl_sql_adr = '';
							}
							
									
							MySQL_Query ("INSERT INTO objednavky
							(id_obj,id_zak,polozky,id_zbozi,cislo_zbozi,ks,cena_ks_bez_dph,dph,mena,celkova_cena,poznamka,doprava_id,doprava_zp,doprava_cena,platba_zp,platba_cena,platba_id,
							datum,stav,ip,useragent,referer,kurz_euro,vaha,card,procento_slev,dpd_pobocka,eshop,ppl_pobocka,ppl_pobocka_id,souhlas_obch_pod,nesouhlas_heureka,gls_pobocka_id,gls_pobocka)
							VALUES ('".$id_obj."',
							'".intval($id_zak_sess)."',
							'".$nazev_do_db."',
							'".$row_obj->id."',
							'".$row_obj->kat_cislo."',
							'".$pocet_ks."',
							'".$cena_ks."',
							'".$row_obj->dph."',
							'Kč',
							'".($this->cena_final + $row_doprava->cena + $row_platba->cena)."',
							'".addslashes(strip_tags($_POST['poznamka']))."',
							'".$row_doprava->id."',
							'".$row_doprava->text."',
							'".$row_doprava->cena."',
							'".$row_platba->text."',
							'".$row_platba->cena."',
							'".$row_platba->id."',
							UNIX_TIMESTAMP(),
							'objednávka přijata',
							'".getip()."',
							'".addslashes($_SERVER["HTTP_USER_AGENT"])."',
							'".addslashes($_SESSION["referer"])."',
							'".__KURZ_EURO__."',
							'".__BALIKOBOT_DEFAULT_VAHA__."',
							'".$platba_karta_text."',
							'".intval($sleva_sess)."',
							'".intval($_POST['dpd_pobocka'])."',
							4,
							'".$ppl_sql_adr."',
							'".addslashes($_SESSION['KTMID'])."',
							'".intval($_POST['souhlas'])."',
							'".intval($_POST['nesouhlas_heureka'])."',
							'".intval($_SESSION['gls_id'])."',
							'".addslashes($_SESSION['gls_name'])."<br>".addslashes($_SESSION['gls_address'])."<br>".addslashes($_SESSION['gls_city'])."<br>".addslashes($_SESSION['gls_zipcode'])."'
							)")  or die(err(2));

							// update prodano
								MySQL_Query ("UPDATE produkty SET
								ks_skladem=ks_skladem - ".$pocet_ks."
								WHERE id='".intval($row_obj->id)."'")
								or die(err(3));		
								
								
									// kontrola poctu kusu
									if( ($row_obj->ks_skladem - $pocet_ks)<1)
									{
									$produkty_arr[] = 'Produkt '.$nazev_do_db.' s katalogovým číslem: '.$row_obj->kat_cislo.' je na skladě v počtu '.($row_obj->ks_skladem - $pocet_ks).' ks';		
									}
									
									$produkty2_heureka .= "&produkt[]=".urlencode(stripslashes($nazev_do_db));
									$produkty_heureka[] =  $nazev_do_db."|".$cena_ks."|".$pocet_ks;		

		
								// přidáni zakoupené položky zboží.cz
								/*
							    $zbozi_s->addCartItem(array(
							        "itemId" => $row_obj->id,
							        "productName" => $nazev_do_db,
							        "quantity" => $pocet_ks,
							        "unitPrice" => $cena_ks,
							    ));*/
							
							
							$i++;
						
						}
						
						
						
						 // odeslání na zboží.cz
					     //$zbozi_s->send();
						
						
								
						// odeslani rekapitulace
						$query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($id_zak_sess)."'") or die(err(1));
						$row_zakaznik = mysql_fetch_object($query_zakaznik); 


						$zakaznik = "<br>Objednávku na ".__URL__." učinil:<br>
										Jméno a příjmení: <b>".$row_zakaznik->jmeno." ".$row_zakaznik->prijmeni."</b><br>
										Ulice: <b>".$row_zakaznik->ulice." ".$row_zakaznik->cislo."</b><br>
										Obec: <b>".$row_zakaznik->obec."</b><br>
										PSČ: <b>".$row_zakaznik->psc."</b><br>";
										if($row_zakaznik->telefon)
										{
										$zakaznik .= "Telefon: <b>".$row_zakaznik->telefon."</b><br>";
										}
										$zakaznik .= "<br />";

						if($row_zakaznik->reg_fak_ico)
						{
						// fakturacni adresa
						$zakaznik .= "<br /><b>Fakturační adresa:</b><br>firma: ".stripslashes($row_zakaznik->reg_fak_nazev_firmy)."<br>
						IČ: ".stripslashes($row_zakaznik->reg_fak_ico)."<br>DIČ: ".stripslashes($row_zakaznik->reg_fak_dic)."<br>
						".stripslashes($row_zakaznik->reg_fak_ulice)." ".stripslashes($row_zakaznik->reg_fak_cislo)."<br>".stripslashes($row_zakaznik->reg_fak_obec)."<br>".
						stripslashes($row_zakaznik->reg_fak_psc);
						}     
						
						/*if($_POST["dpd_pobocka"])
						{
							// DPD
							$query_dpd = MySQL_Query("SELECT * FROM dpd WHERE id_dpd = '".intval($_POST['dpd_pobocka'])."'") or die(err(1));
							$row_dpd = mysql_fetch_object($query_dpd);
	   
	   
							$zakaznik .= "<b>Dodací adresa - DPD ParcelShop:</b> ".stripslashes($row_dpd->nazev).", ".stripslashes($row_dpd->ulice)." ".stripslashes($row_dpd->cislo).", ".stripslashes($row_dpd->mesto).", ".$row_dpd->psc."<br />";
						}*/
						
						if($_SESSION["KTMID"])
						{
							// PPL partner
							
							$zakaznik .= "<b>Dodací adresa - PPL partner:</b> ".strip_tags($_SESSION["KTMname"]).", ".strip_tags($_SESSION["KTMaddress"])."<br />";
						}
						
						if($_SESSION["gls_id"])
						{
	   
							$zakaznik .= "<b>Dodací adresa - GLS ParcelShop:</b> ".strip_tags($_SESSION['gls_name']).", ".strip_tags($_SESSION['gls_address']).", ".strip_tags($_SESSION['gls_city']).", ".strip_tags($_SESSION['gls_zipcode'])."<br />";
						}

						if($row_zakaznik->reg_dod_obec)
						{
						// dodaci adresa
						$zakaznik .= "<br /><b>Dodací adresa:</b><br>".stripslashes($row_zakaznik->reg_dod_jmeno_prijmeni)." ".stripslashes($row_zakaznik->reg_dod_nazev_firmy)."<br>
						".stripslashes($row_zakaznik->reg_dod_ulice)." ".stripslashes($row_zakaznik->reg_dod_cislo)."<br>".stripslashes($row_zakaznik->reg_dod_obec)."<br>".
						stripslashes($row_zakaznik->reg_dod_psc);
						}              
							
						$body_email = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
						<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"cs\" lang=\"cs\">
						<head>
						<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
						<meta http-equiv=\"Content-Language\" content=\"cs\" />
						<meta name=\"pragma\" content=\"no-cache\" />
						<meta name=\"MSSmartTagsPreventParsing\" content=\"true\" />
						<meta http-equiv=\"imagetoolbar\" content=\"no\" />
								<title>Objednávka</title>
								</head>
								<body>
								".$zakaznik."
								  <br>
									   <br><table border=\"1\" style=\"width: 90%; border: solid 1px #bcbcbc; border-collapse: collapse; font-size:12px;\" cellpadding=\"4\" >
									   <tr style=\"background: #DEDBDB\"><td><b>Název zboží</b></td>
									   <td><b>Počet ks</b></td>
									   <td><b>Cena za kus s DPH</b></td>
									   <td><b>DPH</b></td>
									   <td><b>Cena celkem s DPH</b></td>
									   </tr>".$text_obj;
									   
										   if($uz_jm_sess!='bez registrace')
											{
											 $body_email .= "<tr><td colspan=\"4\">Aktuálně nakupujete se slevami</td><td align=\"right\">".$sleva_sess."%</td></tr>";
											}
									   
									   
									   $body_email .= "<tr><td colspan=\"4\"><strong>Celková cena:</strong></td><td align=\"right\">
									   <span style=\"color: red; font-weight: bold\">".round($this->cena_final)." ".__MENA__."</span></td></tr>";


						// doprava
						$body_email .= "<tr style=\"background: #DEDBDB\"><td colspan=\"5\">Způsob dopravy</td></tr>
						<tr><td colspan=\"4\">".$row_doprava->text."</td><td>";
						$body_email .= $row_doprava->cena." ".__MENA__;
						$body_email .= "</td></tr>";
						
						//platba
						$body_email .= "<tr style=\"background: #DEDBDB\"><td colspan=\"5\">Způsob platby</td></tr>
						<tr><td colspan=\"4\">".$row_platba->text."</td><td>";
						$body_email .= $row_platba->cena." ".__MENA__;
						$body_email .= "</td></tr>";
						
						$body_email .= "<tr><td colspan=\"4\"><strong>Celková cena zboží včetně poštovného</strong></td>
						<td align=\"right\"><span style=\"color: red; font-weight: bold\">";
						$body_email .=	($this->cena_final + $row_doprava->cena + $row_platba->cena)." ".__MENA__."</span></td></tr></table>";



						// proforma faktura - platba na ucet 
						if($row_platba->prevodem == 1)
						{
						$body_email .="<br /><span style=\"color: red; font weight: bold;\">Vybrali jste úhradu převodem. Uhraďte prosím
						celkovou částku (<b>".($this->cena_final + $row_doprava->cena + $row_platba->cena)." ".__MENA__."</b>) na náš účet <b>";

							$body_email .= __UCET__;
							
						$body_email .= "</b>  
						Jako variabilní symbol uveďte číslo objednávky (<b>".$id_obj."</b>). 
						Pokud máte možnost zadat i zprávu pro příjemce, uveďte prosím text \"úhrada objednávky\" a číslo objednávky.<br />
						Zboží bude expedováno až po připsání celé částky na náš účet.</span><br />";
						}
						
						
						if($_SESSION['nl']==1)
						{
							$body_email .= "<br />".__KOSIK_NL_TEXT__.": ANO";	
						}
						else
						{
							$body_email .= "<br />".__KOSIK_NL_TEXT__.": NE";	
						}
						
						if($_POST['souhlas']==1)
						{
							$body_email .= "<br />".__KOSIK_SOUHLAS_OBCH_PODM__.": ANO";	
						}
						else
						{
							$body_email .= "<br />".__KOSIK_SOUHLAS_OBCH_PODM__.": NE";	
						}
						
						if($_SESSION['souhlas_ou']==1)
						{
							$body_email .= "<br />".__REGISTRACE_SOUHLAS_SE_ZPRAC_OS_UD__.": ANO";	
						}
						
						if($_POST['nesouhlas_heureka']==1)
						{
							$body_email .= "<br />Nesouhlas se zasláním mého emailu na Heureku: ANO";	
						}
						else
						{
							$body_email .= "<br />Nesouhlas se zasláním mého emailu na Heureku: NE";	
						}


						$body_email .= "<br /><br />Přehled a stav svých objednávek můžete v případě registrace sledovat na  
						<a href=\"".__URL__."/prehled-objednavek.html\">".__URL__."/prehled-objednavek.html</a>";		       
						$body_email .=  "<br /><br />Poznámka: ".strip_tags($_POST['poznamka'])."<br><br>";
						$body_email .= nl2br(__KONTAKTY_PATICKA__)."</body></html>";

						$from_email = __EMAIL_1__;	

						$headers = "From: ".$from_email."\n";
						$headers .= "Return-Path :".$from_email."\n";
						$headers .= "Reply-To :".$from_email."\n";
						$headers .= "MIME-Version: 1.0\n";
						$headers .= "Content-type: text/html; charset=utf-8\n";
						$headers .= "Content-Transfer-Encoding: 8bit\n";
						$headers .= "X-Mailer: Powered by PHP /".phpversion()."\n";
						$headers .= "Bcc: ".$from_email;
						
						
						
	 if($row_platba->karta==1)
	 {
	 // platba kartou
	 require_once("./tridy/class_signature.php");
	 $sign = new CSignature("./__certifikaty_2020/gpwebpay-pvk.key",__HESLO_KLIC__,"./__certifikaty_2020/gpe.signing_prod.pem"); 
	 
	 $cena_celkem_karta = round(($this->cena_final + $row_doprava->cena + $row_platba->cena) * 100);
	 
	 $digest_podpis = __MERCHANTNUMBER__.'|CREATE_ORDER|'.$id_obj.'|'.$cena_celkem_karta.'|203|1|'.__URL__.'/ok.html';
	 $digest_podpis2 = $sign->sign($digest_podpis);
	
	
	 $ret .= 'Vybrali jste platbu online kartou. Nyní prosím klikněte na tlačítko "Zaplatit online kartou" a budete přesměrování na platební rozhraní banky.
	 <br /><br />
	 <input type="submit" name="SSL" value="Zaplatit online kartou" class="tlacitko" 
	onclick="self.location.href=\'https://3dsecure.gpwebpay.com/pgw/order.do?MERCHANTNUMBER='.__MERCHANTNUMBER__.'&OPERATION=CREATE_ORDER&ORDERNUMBER='.$id_obj.'&AMOUNT='.$cena_celkem_karta.'&CURRENCY=203&DEPOSITFLAG=1&URL='.__URL__.'/ok.html&DIGEST='.urlencode($digest_podpis2).'\'" />';
	
	
	 }
	 else
	 {						

		// odeslani mailu zakaznikovi	
		if(mail($row_zakaznik->eml, "Potvrzeni objednavky c.".$id_obj." z ".__URL__,$body_email,$headers))
		{
			
		   $ret .= '<div class="clear" style="height: 10px;"></div>';
		   
		   
						   
						   
			   // essox
				if($row_platba->essox==1)
				{
				$ret .= '<b style="color: red;">Pro dokončení objednávky je nutné ještě vyplnit žádost o spotřebitelský úvěr Essox.
			Pokračujte prosím kliknutím na toto tlačítko</b><br />';
			// naprostá změna generování parametrů pro essox
			
			  $datum_essox = date('YmdHis');
			  $HashKey = sha1(__ESSOX_USERNAME__.'#'.__ESSOX_CODE__.'#'.round($this->cena_final + $row_doprava->cena + $row_platba->cena).'#'.$datum_essox);
			  $XML_DATA = '<FinitServiceRequest>
				<Version>1.0</Version>
				<ServiceName>NewContract</ServiceName>
				<BaseParameters>
					<UserName>'.__ESSOX_USERNAME__.'</UserName>
					<Price>'.round($this->cena_final + $row_doprava->cena + $row_platba->cena).'</Price>
					<Timestamp>'.date('YmdHis').'</Timestamp>
					<HashKey>'.$HashKey.'</HashKey>
				</BaseParameters>
				<ExtendedParameters>	
					<CallbackURL>http://www.hifistereo.cz/essox.html</CallbackURL>
					<CallbackType>GET</CallbackType>
					<OrderId>'.$id_obj.'</OrderId>
					<CustomerId>'.$row_zakaznik->id.'</CustomerId>
					<TransactionId>'.$id_obj.'</TransactionId>			
				</ExtendedParameters>
			</FinitServiceRequest>';
			
			$ret .= "<br /><a href=\"".__ESSOX_URL__."/?ESXCode=5&ESXAuth=".base64_encode($XML_DATA)."\"><img src=\"/img/obr_tl_essox.png\" style=\"border: 0px;\" /></a>";
			
			
			//$ret .= "<br /><a href=\"".getEssoxLiteUrl(round($this->cena_final + $row_doprava->cena + $row_platba->cena))."\"><img src=\"/img/obr_tl_essox.png\" style=\"border: 0px;\" /></a>";
			
				
				}
				else
				{
				
				$ret .= '<div style="width: auto; text-align: center; padding: 30px; color: #ffffff; background-color: #31C907;">
						   <b>Objednávka byla úspěšně odeslána.</b>
						   </div>
						   
						   <div class="clear" style="height: 10px;"></div>
						   
	<div style="width: auto; padding: 20px; text-align: center; color: #1f1f1f; font-size: 20px;">
	Rekapitulace objednávky a platební pokyny byly zaslány na Váš e-mail.
	
	
						 				  
						    <br /><br />
						    <input type="button" class="sub_dk3"  title="pokračovat v nákupu" value="Pokračovat v nákupu"  style="float: left;" 
							onclick="self.location.href=\'/\'" />
						   </div>';
						   $ret .= '<div class="clear" style="height: 10px;"></div>';
				
				}
	
	
	
						   
						   // certifikat spokojenosti - Heureka
						   //pro CZ verzi	
						   if($_POST['nesouhlas_heureka']!=1)
						   {
						   $url_heureka = "http://www.heureka.cz/direct/dotaznik/objednavka.php?id=629bd2f9c45d8d471c383a5b22ccb654&email=".$row_zakaznik->eml.$produkty2_heureka;
						   file_get_contents($url_heureka);	
					       }
								
						// vygenerovani JS kodu pro google analytics
						  $ret .= google_analytics_obj($id_obj,$row_zakaznik->id);	
								
								
					/*
					$ret .= "<script type=\"text/javascript\">
					var _hrq = _hrq || [];
					    _hrq.push(['setKey', 'A6927E329C48F6341B2970388E274FF2']);
					    _hrq.push(['setOrderId', '".$id_obj."']);";
					    
					    foreach($produkty_heureka as $heu_key=>$heu_val)
					    {
						list($heu_nazev,$heu_cena,$heu_ks) = explode("|",$heu_val);	
						$ret .= "_hrq.push(['addProduct', '".$heu_nazev."', '".$heu_cena."', '".$heu_ks."']);";
						}
					    
					   $ret .= " _hrq.push(['trackOrder']);
					
					(function() {
					    var ho = document.createElement('script'); ho.type = 'text/javascript'; ho.async = true;
					    ho.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.heureka.cz/direct/js/ext/1-roi-async.js';
					    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ho, s);
					})();
					</script>";
					
					
					   // vygenerovani JS kodu pro google analytics
						$ret .= google_analytics_obj($id_obj,$row_zakaznik->id);
*/

						}
						else
						{
						$ret .=  "<br />Chyba při odesílání objednávky!<br />";
						}
						
						
						$ret .=  '<!-- Měřicí kód Sklik.cz -->
						<iframe width="119" height="22" frameborder="0" scrolling="no" src="//c.imedia.cz/checkConversion?c=100025131&color=ffffff&v="></iframe>';
						/*
						$ret .=  '<script>
						  (function(w,d,s,u,n,k,c,t){w.ZboziConversionObject=n;w[n]=w[n]||function(){
						    (w[n].q=w[n].q||[]).push(arguments)};w[n].key=k;c=d.createElement(s);
						    t=d.getElementsByTagName(s)[0];c.async=1;c.src=u;t.parentNode.insertBefore(c,t)
						  })(window,document,"script","https://www.zbozi.cz/conversion/js/conv.js","zbozi","119597");
						
						   zbozi("setOrder",{
						      "orderId": "'.$id_obj.'",
						      "totalPrice": "'.round($this->cena_final + $row_doprava->cena + $row_platba->cena).'"
						   });
						   zbozi("send");
						</script>';*/
						
						
						unset($_SESSION["kosik"]);
						unset($_SESSION['doprava']);	
						unset($_SESSION['platba']);
						unset($_SESSION['poznamka']);	
						unset($_SESSION['souhlas_ou']);		
						unset($_SESSION['nl']);
						
						unset($_SESSION['gls_name']);
						unset($_SESSION['gls_address']);
						unset($_SESSION['gls_city']);
						unset($_SESSION['gls_zipcode']);
						unset($_SESSION['gls_id']);
	  
				}
			   
			   }
			   else
			   {
			   $ret .= '<span class="r">Vlivem dlouhodobé nečinnosti jste byli z bezpečnostních důvodů odhlášeni. Přihlaste se prosím znovu vpravo nahoře.</span>';
			   }
		   
		   }
		   else
		   {
		    $ret .= '<span class="r">Váš nákupní košík je prázdný. Vlivem dlouhodobé nečinnosti skončila platnost sešny.</span>';
		   }
		  
		  
		 }
     
     }

     else
     {
     die('Chybné volání!');
     }
	 
	 return $ret;
   }
}
?> 

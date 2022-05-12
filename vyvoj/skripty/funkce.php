<?
// sada zakladnich funkci
function globalni_pr()
{
$query_nastaveni = MySQL_Query("SELECT str,obsah FROM obecne_nastaveni4")  or die(err(1));
	while($row_nastaveni = mysql_fetch_object($query_nastaveni))
	{
          define("__".$row_nastaveni->str."__",$row_nastaveni->obsah);  
	}
}

function today()
{
$today = strftime(" %A %e. %B %Y");
return $today;
}

// navratove kody pro platbu kartou
$prcode_arr = array
(
1=>'Pole příliš dlouhé',
2=>'Pole příliš krátké',
3=>'Chybný obsah pole',
4=>'Pole je prázdné',
5=>'Chybí povinné pole',
11=>'Neznámý obchodník',
14=>'Duplikátní číslo objednávky',
15=>'Objekt nenalezen',
17=>'Částka k úhradě překročila autorizovanou částku',
18=>'Součet kreditovaných částek překročil uhrazenou částku',
20=>'Objekt není ve stavu odpovídajícím této operaci',
25=>'Uživatel není oprávněn k provedení operace',
26=>'Technický problém při spojení s autorizačním centrem',
27=>'Chybný typ objednávky',
28=>'Zamítnuto v 3D',
30=>'Zamítnuto v autorizačním centru',
31=>'Chybný podpis',
35=>'Expirovaná session',
50=>'Držitel karty zrušil platbu',
200=>'Žádost o doplňující informace',
1000=>'Technický problém'
);

 
$srcode_arr = array
(
1=>'ORDERNUMBER',
2=>'MERCHANTNUMBER',
6=>'AMOUNT',
7=>'CURRENCY',
8=>'DEPOSITFLAG',
10=>'MERORDERNUM',
11=>'CREDITNUMBER',
12=>'OPERATION',
18=>'BATCH',
22=>'ORDER',
24=>'URL',
25=>'MD',
26=>'DESC',
34=>'DIGEST',
3000=>'Neověřeno v 3D. Vydavatel karty není zapojen do 3D nebo karta nebyla aktivována. Kontaktujte vydavatele karty.',
3001=>'Držitel karty ověřen.',
3002=>'Neověřeno v 3D. Vydavatel karty nebo karta není zapojena do 3D. Kontaktujte vydavatele karty.',
3004=>'Neověřeno v 3D. Vydavatel karty není zapojen do 3D nebo karta nebyla aktivována. Kontaktujte vydavatele karty.',
3005=>'Zamítnuto v 3D.Technický problém při ověření držitele karty. Kontaktujte vydavatele karty.',
3006=>'Zamítnuto v 3D. Technický problém při ověřenídržitele karty.',
3007=>'Zamítnuto v 3D. Technický problém v systému zúčtující banky. Kontaktujte obchodníka.',
3008=>'Zamítnuto v 3D. Použit nepodporovaný karetní produkt. Kontaktujte vydavatele karty.',
1001=>'Zamitnuto v autorizacnim centru, karta blokovana',
1002=>'Zamitnuto v autorizacnim centru, autorizace zamítnuta',
1003=>'Zamitnuto v autorizacnim centru, problem karty',
1004=>'Zamitnuto v autorizacnim centru, technicky problem',
1005=>'Zamitnuto v autorizacnim centru, Problem uctu'
);


function bez_diakritiky($s)
{
$a = array("á","ä","č","ď","é","ě","ë","í","ň","ó","ö","ř","š","ť","ú","ů","ü","ý","ž","Á","Ä","Č","Ď","É","Ě","Ë","Í","Ň","Ó","Ö","Ř","Š","Ť","Ú","Ů","Ü","Ý","Ž",";","?","!",".",",","/",":","\\","\"","<",">"," ","'","--","%");
$b = array("a","a","c","d","e","e","e","i","n","o","o","r","s","t","u","u","u","y","z","A","A","C","D","E","E","E","I","N","O","O","R","S","T","U","U","U","Y","Z","","","","","","","","","","","","-","","-","");
$sb = strtolower(str_replace($a, $b, $s));
return  str_replace('--','-',$sb); 
}

function db_connect($db_host='localhost' , $dbuser , $dbpasswd, $db)
{

	@$spojeni_db = mysql_Connect($db_host , $dbuser , $dbpasswd);
		if(!$spojeni_db)
		{
		  die(err(4));
			//return FALSE;
		}
		else
		{		 
		MySQL_Select_DB($db);
		mysql_query("SET character_set_results=UTF8");
		mysql_query("SET character_set_connection=UTF8");
		mysql_query("SET character_set_client=UTF8");
		mysql_query("SET NAMES 'UTF8'");
		return $spojeni_db;
	    }


}


if(strstr($_SERVER['HTTP_USER_AGENT'],"MSIE"))
{
	define(__IE__,1);
}
else
{
    define(__IE__,0);
}


if(strstr($_SERVER['HTTP_USER_AGENT'],"MSIE 9.0"))
{
	define(__IE9__,1);
}
else
{
    define(__IE9__,0);
}

if(strstr($_SERVER['HTTP_USER_AGENT'],"WebKit"))
{
	define(__CHROME__,1);
}
else
{
    define(__CHROME__,0);
}




function admin_email($e)
{
 return '<br /><br /><small> v případě potřeby se obraťte na: <a href="mailto:'.$e.'?subject=Error_'.__URL__.$_SERVER['REQUEST_URI'].'">'.$e.'</a></small>';	
}



function sanitize($s)
{
	if(is_numeric($s))
	{ 
	 $san = intval($s);	// cele cislo
	}
	elseif(is_float($s))
	{
	 $san = floatval($s);	// des. cislo
	}
	elseif(is_array($s))
	{   $s2 = array();
	      foreach ($s as $key => $value)
               {
                $s2[$key] = sanitize($value);
               }

	 $san = $s2;	// pole
        }
	else
	{
	 $san = addslashes(strip_tags($s));	// retezec	
	}

return $san;
}


function array_add( $array1, $array2 )
{
	foreach( $array2 AS $key => $value )
	{
	   while( array_key_exists( $key, $array1 ) )
	   $key .= "_";
	   $array1[ $key ] = $value;
	}

return $array1;
}


// ostatni stranky 
$arr_staticke_str = array
(
'vyhledavani'=>'Vyhledávání',
'rozsirene-vyhledavani'=>'Rozšířené vyhledávání',
'kosik'=>'Košík',
'mapa-obchodu'=>'Mapa obchodu',
'objednavka'=>'Objednávka',
'registrace'=>'Registrace',
'registrace2'=>'Dokončení registrace',
'bez-registrace'=>'Bez registrace',
'prihlaseni'=>'Přihlášení',
'zapomenute-heslo'=>'Zapomenuté heslo',
'prehled-objednavek'=>'Přehled objednávek',
'uprava-reg-udaju'=>'Úprava registračních údajů',
'aktuality'=>'Aktuality',
'poradna'=>'Poradna',
'akcni-zbozi'=>'Akční zboží',
'doporucujeme'=>'Doporučujeme',
'novinky'=>'Novinky',
'nejprodavanejsi'=>'Nejprodávanější',
'slovnik-pojmu'=>'Slovník pojmů',
'caste-dotazy'=>'Časté dotazy',
'newsletter'=>'Newsletter'
);

$arr_staty = array
(
1=>'ČESKÁ REPUBLIKA',
2=>'SLOVENSKO'
);


// pole řazení - podkategorie
$arr_razeni = array
(
'nejnavštěvovanějších'=>'navstevnost',
'ceny'=>'cena_A',
'názvu'=>'nazev',
'výrobce'=>'vyrobce',
'datumu'=>'datum'
);


function odkazy($p,$menu)
{

  foreach ($menu as $key => $value) 
  {

      echo "<a href=\"".__URL__."/".$key.".html\" title=\"".$value."\">".$value."</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    
  }

}

function top_menu_kat($p)
{
	$query_k = MySQL_Query("SELECT id, str, nazev, id_produkt FROM kategorie WHERE aktivni4=1 AND vnor=1 ORDER BY razeni ASC ");
	$x = 1;
	 while($row_k = MySQL_fetch_object($query_k))
	   {
	     echo '<div  class="menu_kat_in" onmouseover="this.className=\'menu_kat_in_aktiv\';zobraz_submenu(\'sub_'.$x.'\',\'tlacitko_'.$x.'\',\'menu_kat_in_aktiv\');" 
		onmouseout="this.className=\'hmenu\';skryj_submenu(\'sub_'.$x.'\',\'tlacitko_'.$x.'\',\'menu_kat_in\');"  id="tlacitko_'.$x.'" 
	     onclick="self.location.href=\'/produkty/'.$row_k->str.'.html\'" ';
	     
	     // prvni ma jiny padding
	     if($x==1){echo ' style="padding-left: 5px;" ';}
	     
	     echo '>'.stripslashes($row_k->nazev).'</div>';
	     
	     
	     // divy se submenu + obrázek produktu přiřazený kategorii
	
            
			$query_submenu = MySQL_Query("SELECT id, str, nazev FROM kategorie WHERE vnor=2 AND aktivni4=1 AND id_nadrazeneho=".$row_k->id." ORDER BY razeni");
			if(mysql_num_rows($query_submenu))
			{

				 echo '<div class="top_submenu"  id="sub_'.$x.'" onmouseover="zobraz_submenu(\'sub_'.$x.'\',\'tlacitko_'.$x.'\',\'menu_kat_in_aktiv\');" 
				onmouseout="skryj_submenu(\'sub_'.$x.'\',\'tlacitko_'.$x.'\',\'menu_kat_in\');">';
				
				// leva strana
				echo '<div class="top_submenu_leva">';
				
				while($row_submenu = MySQL_fetch_object($query_submenu))
				{
				  
				  echo '<div class="smf" onclick="self.location.href=\'/produkty/'.$row_k->str.'/'.$row_submenu->str.'.html\'"><img src="/img/kolo_o.png" alt="" /> '.$row_submenu->nazev.'</div>';
				}
				
				echo '</div>';
				
				// prava strana - produkt
				echo '<div class="top_submenu_prava">';
				
				if($row_k->id_produkt)
				{
				
					$sleva_sess = __SLEV_SK_SESS__;
					$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
					$query_pr = MySQL_Query("SELECT P.id, P.str, P.nazev, P.id_kategorie, P.$cena_db AS CENA_DB, P.cena_imaginarni, P.sleva, P.platnost_slevy, O.nazev AS OBRAZEK
					FROM produkty P
					LEFT JOIN obrazky O ON O.idp=P.id
					WHERE P.id=".intval($row_k->id_produkt)." AND O.typ=1 GROUP BY P.id");
					$row_pr = MySQL_fetch_object($query_pr);
			
					
					$url_pr = url_produktu($row_pr->id,$row_pr->id_kategorie);
					if($row_pr->sleva>0 && ($row_pr->platnost_slevy>time())) 
					{
					 $cena_s_dph = round(($row_pr->CENA_DB) - ($row_pr->CENA_DB/100*$row_pr->sleva));
					}
					else
					{
					  if($sleva_sess)
					  {
					  $cena_s_dph = round(($row_pr->CENA_DB) - ($row_pr->CENA_DB/100 * $sleva_sess));
					  }
					  else
					  {
					  $cena_s_dph = round($row_pr->CENA_DB);
					  }
					}
							
					echo '<div class="top_submenu_prava_obr"><img src="'.__URL2__.'/img_produkty/velke/'.$row_pr->OBRAZEK.'" style="width: 270px;" alt="" /></div>';
					echo '<div class="top_submenu_prava_texty">
							<div class="clear" style="height: 15px;"></div>
							<div class="top_submenu_prava_texty_nadpis">'.stripslashes($row_pr->nazev).'</div>
							<div class="clear" style="height: 30px;"></div>';
							
							if($row_pr->cena_imaginarni > 0)
							{
								echo '<span class="cena_preskrtla">'.$row_pr->cena_imaginarni.' '.__MENA__.'</span>';
							}
							else
							{
								echo '&nbsp;';
							}
							
							echo '<div class="clear" style="height: 5px;"></div>';
							echo '<span class="cena_pr">'.$cena_s_dph.' '.__MENA__.'</span>';
							echo '<div class="clear" style="height: 20px;"></div>';
							echo '<div class="top_submenu_prava_tlacitko" onclick="self.location.href=\''.$url_pr.'\'" >Detail produktu</div>';
							
							
						  echo '</div>';
				}
				
				echo '</div>';
				
				
				echo '</div>';
		    }
	     
	     
	     $x++;
	   }
	
}


function bannery_uvod()
{
	$sleva_sess = __SLEV_SK_SESS__;
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	$query_tk = MySQL_Query("SELECT id, nazev, obr_banner4_text, kat_cislo, id_kategorie,	obr_banner4, $cena_db AS CENA_DB, cena_imaginarni, sleva, platnost_slevy FROM produkty WHERE na_uvod4=1");
	$x = 1;
	 while($row_tk = MySQL_fetch_object($query_tk))
	   {

			
			$url = url_produktu($row_tk->id,$row_tk->id_kategorie);
			
			if($row_tk->sleva>0 && ($row_tk->platnost_slevy>time())) 
			{
			 $cena_s_dph = round(($row_tk->CENA_DB) - ($row_tk->CENA_DB/100*$row_tk->sleva));
			}
			else
			{
			  if($sleva_sess)
			  {
			  $cena_s_dph = round(($row_tk->CENA_DB) - ($row_tk->CENA_DB/100 * $sleva_sess));
			  }
			  else
			  {
			  $cena_s_dph = round($row_tk->CENA_DB);
			  }
			}	
			
			
			echo '<li>
			<div class="slider_uvodka_box" onclick="self.location.href=\''.$url.'\'" 
			style="background-image: url(\''.__URL2__.'/prilohy/'.$row_tk->obr_banner4.'\');background-position: top left;background-repeat: no-repeat;">
			<div class="slider_uvodka_box_nadpis">'.stripslashes($row_tk->nazev).'</div>
			<div class="slider_uvodka_box_text">'.stripslashes($row_tk->obr_banner4_text).'</div>';
			
			// sleva
			if($row_tk->cena_imaginarni > 0)
	        {
			 //vypocitame slevu v %
			  $jp = $row_tk->cena_imaginarni / 100;
			  $dp = $row_tk->cena_imaginarni - $cena_s_dph;
			  $tp = ceil($dp / $jp);
			
				echo '<div class="clear" style="height: 50px;"></div>';
				echo '<div class="slider_uvodka_box_ceny_tl">';
				echo '<div class="slider_uvodka_box_sleva_cena">'.number_format($row_tk->cena_imaginarni, 0, '.', ' ').' '.__MENA__.'</div>';
				echo '<div class="slider_uvodka_box_cena">'.number_format($cena_s_dph, 0, '.', ' ').' '.__MENA__.'</div>';
				echo '<div class="top_submenu_prava_tlacitko2">Detail produktu</div>';
				echo '<div class="clear"></div>';
				echo '</div>';
				

				
			}
			else
			{
				echo '<div class="clear" style="height: 50px;"></div>';
				echo '<div class="slider_uvodka_box_ceny_tl">';
				echo '<div class="slider_uvodka_box_cena">'.number_format($cena_s_dph, 0, '.', ' ').' '.__MENA__.'</div>';
				echo '<div class="top_submenu_prava_tlacitko2">Detail produktu</div>';
				echo '<div class="clear"></div>';
				echo '</div>';
			}
			
			

			
			echo '</div>
			</li>';
			
			$x++;

	   }

}


function vypis_kategorii_pata()
{
	$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE aktivni=1 AND vnor=1 ORDER BY razeni");
	 while($row_k = MySQL_fetch_object($query_k))
	   {
		   echo '<a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a><br />';
	   }
}


function odkazy_spodek()
{
	if(!strstr($_SERVER['HTTP_USER_AGENT'],"W3C_Validator"))
			    {
					$query_odkazy = MySQL_Query("SELECT text FROM odkazy4") or die(err(1));
					$row_odkazy = MySQL_fetch_object($query_odkazy);
					echo stripslashes($row_odkazy->text);
		        }
}

function aktuality_zbytek()
{   
	
	$limit = intval($_GET['limit']);
	if(!$limit)
	   {
        $limit = 0;
        }

  if(!$_SESSION['pocet_strankovani']){$_SESSION['pocet_strankovani'] = __POCET_PRODUKTU_NAHLEDY__;} 
  
    $query_pocet = MySQL_Query("SELECT count(id) AS CID FROM aktuality4 WHERE aktivni=1") or die(err(1));
	$row_pocet = MySQL_fetch_object($query_pocet);
	$pocet = $row_pocet->CID;
 
 
 
     $ak = '';
     
     
     // strankovani
	$ak .= '<div class="strankovani_kategorie">';
	$ak .= get_links3a($pocet,$limit);
	$ak .= '</div>';
	

	$ak .= '<div class="clear" style="height: 20px;"></div>';
     
	 $i = 1;
     $query_ak = MySQL_Query("SELECT id, nadpis, datum, perex, obr FROM aktuality4 WHERE aktivni=1 ORDER BY id DESC LIMIT $limit, ".intval($_SESSION['pocet_strankovani'])." ");
	 while($row_ak = MySQL_fetch_object($query_ak))
	   {
	    $ak .= '<div class="aktuality_box_in2">';
	    

			$ak .= '<div class="ak_uvod_obr2">';
			 if($row_ak->obr){$ak .='<img src="'.__URL2__.'/prilohy/male/'.$row_ak->obr.'" alt="" style="width: 99px; vertical-align: middle;" />';}
			 else{$ak .='<img src="/img/neni2.jpg" alt="" style="vertical-align: middle;" />';}
			
			$ak .='</div><div class="ak_uvod_nadpis_obal2"><h3><a href="/aktuality/'.bez_diakritiky($row_ak->nadpis).'/'.$row_ak->id.'.html">'.stripslashes($row_ak->nadpis).'</a></h3>
			<div class="clear" style="height: 10px;"></div>'.stripslashes($row_ak->perex).'<div class="clear" style="height: 10px;"></div>
			<a href="/aktuality/'.bez_diakritiky($row_ak->nadpis).'/'.$row_ak->id.'.html">Celý článek &raquo;</a>
			<div class="clear"></div>
			</div></div>';
			
			$ak .= '<div class="clear" style="height: 20px;"></div>';
			$ak .= '<div class="cara"></div>';
			$ak .= '<div class="clear" style="height: 20px;"></div>';
		
	    
		

		$i++;
	   }
	   
	   // strankovani
	$ak .= '<div class="clear" style="height: 20px;"></div>';
	$ak .= '<div class="strankovani_kategorie">';
	$ak .= get_links3a($pocet,$limit);
	$ak .= '</div>';
	$ak .= '<div class="clear" style="height: 15px;"></div>';
	   
	   return $ak;
		
} 

function aktuality_uvod($x)
{   
     $ak = '';
     
	 $i = 1;
     $query_ak = MySQL_Query("SELECT id, nadpis, datum, perex, obr FROM aktuality4 WHERE aktivni=1 AND na_uvod=1 ORDER BY id DESC LIMIT $x");
	 while($row_ak = MySQL_fetch_object($query_ak))
	   {
		   if(!$row_ak->obr)
		   {
			   $row_ak->obr = 'akhifi4.jpg';
		   }
		   
	        $ak .= '<div class="aktuality_box_in">';
			$ak .= '<div class="ak_uvod_foto"><img src="'.__URL2__.'/prilohy/male/'.$row_ak->obr.'" alt="novinky" style="max-width: 96px;" /></div>';

			
			$ak .='<div class="ak_uvod_nadpis_text">
			<div class="ak_uvod_nadpis"><a href="/aktuality/'.bez_diakritiky($row_ak->nadpis).'/'.$row_ak->id.'.html">'.stripslashes($row_ak->nadpis).'</a></div>
			<div class="clear"></div>
			<div class="ak_uvod_text">'.stripslashes($row_ak->perex).'</div>
			</div>
			</div>';
			
		
	    
		

		$i++;
	   }
	   //$ak .= '<div class="clear" style="height: 56px;"></div>';
	   //$ak .= '<div class="top_submenu_prava_tlacitko" style="margin-left: auto; margin-right: auto;" onclick="self.location.href=\'/aktuality.html\'" >ARCHIV AKTUALIT</div>';
	   
	   return $ak;
		
}   

 




function aktuality_podstranky($x)
{   
     $ak = '';
     
	 $i = 1;
     $query_ak = MySQL_Query("SELECT id, nadpis, datum, perex FROM aktuality4 WHERE aktivni=1 AND na_uvod=1 ORDER BY id DESC LIMIT $x");
	 while($row_ak = MySQL_fetch_object($query_ak))
	   {
	    $ak .= '<div class="aktuality_box_in2" ';
	    if($i%2==0){$ak .= ' style="margin-left: 50px;" ';}
	    $ak .='>';
		$ak .=  '<div class="ak_uvod_datum"><div class="clear" style="height: 10px;"></div>
		<b>'.date('d.m.',$row_ak->datum).'</b><br />'.date('Y',$row_ak->datum).'</div>';
		
		$ak .=  '<div class="ak_uvod_nadpis"><a href="/aktuality/'.bez_diakritiky($row_ak->nadpis).'/'.$row_ak->id.'.html">'.stripslashes($row_ak->nadpis).'</a>
		<div class="clear" style="height: 5px;"></div>'.stripslashes($row_ak->perex).'
		</div>';
		$ak .=  '</div>';
		$i++;
	   }
	   
	   return $ak;
		
} 




		   	   
		   

function kontrola_ref()
{
$server = "https://".$_SERVER['SERVER_NAME'];
$referer = $_SERVER['HTTP_REFERER'];

	if(!ereg("^".$server, $referer))
	{
	 die ("spatny referer<br />originalni stranky jsou na <a href=\"".__URL__."\">".__URL__."</a>");
	}
}


function getip() {
    if ($_SERVER) 
	 {
        if ( $_SERVER[HTTP_X_FORWARDED_FOR] ) {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif ( $_SERVER["HTTP_CLIENT_IP"] ) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }

     } 
	 else 
	 {
        if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
            $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
        } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
            $realip = getenv( 'HTTP_CLIENT_IP' );
        } else {
            $realip = getenv( 'REMOTE_ADDR' );
        }
     }

    return $realip;
}


function is_email($autor_eml) 
{
    $autor_eml = strtolower($autor_eml);

    if (strlen($autor_eml) < 6)
    {
        return false;
      }
    if (strpos($autor_eml, "@") != strrpos($autor_eml, "@"))
    {
        return false;
      }
    if ((strpos($autor_eml, "@") < 1) || (strpos($autor_eml, "@") > (strlen($autor_eml) - 4)))
    {
        return false;
      }
    if (strrpos($autor_eml, ".") < strpos($autor_eml, "@"))
    {
        return false;
      }
    if (strstr($autor_eml, " "))
    {
        return false;
    }
    if (((strlen($autor_eml) - strrpos($autor_eml, ".") - 1) < 2) || ((strlen($autor_eml) - strrpos($autor_eml, ".") - 1) > 4))
    {
        return false;
      }
    return true;
}


function err($e)
{
// chybove hlasky
switch ($e)
{
case 1:
   $hlaska = "Nepodařilo se vybrat data z databáze";
   break;
case 2:
   $hlaska = "Nepodařilo se uložit záznam";
   break;
case 3:
   $hlaska = "Nepodařilo se updatovat záznam";
   break;
case 4:
   $hlaska = "Nepodařilo se připojit k databázi";
   break;
case 5:
   $hlaska = "Nepodařilo se smazat záznam";
   break;   
case 6:
   $hlaska = "Nepodařilo se optimalizovat tabulku";
   break; 
default:
   $hlaska = "Nespecifikovaná chyba";
}

if(__DEBUG__==1)
 {
 return $hlaska." <b>".mysql_error()."</b>"; 
 }
else
 {
  return $hlaska; 
 }

}


function cut_text($text,$delka)
{
$t_array = explode(" ",$text);
$pocet_array = count($t_array);

	for ($i = 0; $i <= $pocet_array; $i++) 
	{
	   $c_text .= $t_array[$i]." ";
	   if(strlen($c_text)>=$delka){break;}
	}

return $c_text."...";
}

function cut_text2($text,$delka)
{
	$pocet_znaku = mb_strlen($text,'UTF-8');
	if($delka<$pocet_znaku)
	{
		$c_text = substr($text, 0, $delka); 
		if(!preg_match('//u', $c_text)) 
		{
		/* Odstraníme poslední půlznak */
		$c_text = preg_replace('/[\xc0-\xfd][\x80-\xbf]*$/', '', $c_text);
		} 
	}
	else
	{
	$c_text = $text;
	}
	
	return $c_text;
}




function kontrola_form($pole,$needle,$haystack)
{
	global $err2;
	foreach ($pole as $key => $value) 
	{
		if(empty($_POST[$value])){
			 echo "Není vyplněněna hodnota <strong>".str_replace($needle, $haystack, $value)."</strong><br />";
			 $err2 = true;
		}
	}
}



function get_links($pocet,$limit)
{
$ret = '';	
$ret .= '<div class="str_in">';

	for ($px=0;$px<ceil($pocet/50);$px++)
	{
	echo "<a href=\"".__URL__."/vyhledavani.html?limit=".$limit2."&vyhledavani=".$_POST['vyhledavani']."\">";
	if($limit==$limit2) {echo "<strong class=\"navlink\">";}
	echo $px+1;
	if($limit==$limit2) {echo "</strong>";}
	echo "</a> ";
	$limit2 = $limit2+50;
	}
}

function get_links3a($pocet,$limit)
{
// nove strankovani


if(!$_SESSION['pocet_strankovani'])
	{
		$kolik = __POCET_PRODUKTU_NAHLEDY__;
	}
	else
	{
		$kolik = intval($_SESSION['pocet_strankovani']);
	}

//$kolik = 20;
// pocet - celkovy pocet zaznamu v db
// ps = pocet stranek 
// ps2 = aktualni stranka 

$ret = '';

	$ps = ceil($pocet / $kolik);
	if(!$_GET['strana'])
	{
	$ps2=1;
	}
	else
	{
	$ps2 = intval($_GET['strana']);
	}

	$leva = intval(max(1,$ps2-5));
	$prava = intval(min($ps,$ps2+5));
	$leva_pocet = $ps2 - $leva;
	$prava_pocet = $prava - $ps2;

	if ( $leva_pocet + $prava_pocet != 10 )
	{
		if ( $leva_pocet < 5 )
			$prava = min($ps, $prava + ( 5 - $leva_pocet ));

		if ( $prava_pocet < 5 )
			$leva = max(1, $leva - ( 5 - $prava_pocet ));
	}
	
	// vyrobci
	$vyr = '';
	if($_GET['vyrobci'])
	{
		
	  foreach($_GET['vyrobci'] as $v_k => $v_v)
	  {
	    $vyr .= '&vyrobci[]='.$v_v;
	  }
	  
	}


	if($leva>1)
	{
	$ret .=  "<a href=\"?strana=1&amp;limit=0&amp;radit_jak=".strip_tags($_GET['radit_jak'])."&amp;radit_dle=".strip_tags($_GET['radit_dle']).$vyr."&amp;akce=".intval($_GET['akce'])."&amp;novinka=".intval($_GET['novinka'])."&amp;doporucujeme=".intval($_GET['doporucujeme'])."&amp;cena_od=".intval($_GET['cena_od'])."&amp;cena_do=".intval($_GET['cena_do'])."\">";
	$ret .=  "1";
	$ret .=  "</a> ... ";
	}

	for ($px=$leva;$px<=$prava;$px++)
	{

		if($px==$ps2) 
		{
		$ret .=  " <span style=\"color: #222222;
text-decoration: none;
padding-left: 10px;
padding-right: 10px;
padding-top: 4px;
padding-bottom: 4px;
background-color: #FFD631;\">".$px."</span>";
		if($px<$prava){$ret .=  '&nbsp;';}
		}
		else
		{
	    $ret .=  "<a href=\"?strana=".$px."&amp;limit=".(($px-1)*$kolik)."&amp;radit_jak=".strip_tags($_GET['radit_jak'])."&amp;radit_dle=".strip_tags($_GET['radit_dle']).$vyr."&amp;akce=".intval($_GET['akce'])."&amp;novinka=".intval($_GET['novinka'])."&amp;doporucujeme=".intval($_GET['doporucujeme'])."&amp;cena_od=".intval($_GET['cena_od'])."&amp;cena_do=".intval($_GET['cena_do'])."\">";
		$ret .=  $px;
		$ret .=  "</a>";
		//$ret .=  "&nbsp;";
		if($px<$prava){$ret .=  '&nbsp;';}
		}
	
		$limit2 = $px*$kolik;
	}

	if($prava<$ps)
	{
	$ret .=  " ... <a href=\"?strana=".$ps."&amp;limit=".(($ps-1)*$kolik)."&amp;radit_jak=".strip_tags($_GET['radit_jak'])."&amp;radit_dle=".strip_tags($_GET['radit_dle']).$vyr."&amp;akce=".intval($_GET['akce'])."&amp;novinka=".intval($_GET['novinka'])."&amp;doporucujeme=".intval($_GET['doporucujeme'])."&amp;cena_od=".intval($_GET['cena_od'])."&amp;cena_do=".intval($_GET['cena_do'])."\">";
	$ret .=  $ps;
	$ret .=  "</a>";
	}
	

  
  return $ret;

// konec

}




function asc2bin ($ascii)
{
 while ( strlen($ascii) > 0 )
 {
   $byte = ""; $i = 0;
   $byte = substr($ascii, 0, 1);
   while ( $byte != chr($i) ) { $i++; }
   $byte = base_convert($i, 10, 2);
   $byte = str_repeat("0", (8 - strlen($byte)) ) . $byte;
   $ascii = substr($ascii, 1);
   $binary = "$binary$byte";
 }
 return $binary;
}


function bin2asc ($binary)
{
  $i = 0;
  while ( strlen($binary) > 3 )
  {
   $byte[$i] = substr($binary, 0, 8);
   $byte[$i] = base_convert($byte[$i], 2, 10);
   $byte[$i] = chr($byte[$i]);
   $binary = substr($binary, 8);
   $ascii = "$ascii$byte[$i]";
  }
  return $ascii;
} 

function aktuality($x)
{
$query_novinky = MySQL_Query("SELECT * FROM aktuality WHERE aktivni=1 ORDER BY datum DESC, id DESC LIMIT $x") or die(err(1));
$obsah = '';
$x = 1;
 while ($row_novinky = MySQL_fetch_object($query_novinky))
 {
 $obsah .= '<h2 class="aktuality_nadpis_odkaz">
 <div class="ak_uvod_datum3"><div class="clear" style="height: 6px;"></div><b>'.date('d.m.',$row_novinky->datum).'</b><br />'.date('Y',$row_novinky->datum).'</div>
 <a href="/aktuality/'.bez_diakritiky($row_novinky->nadpis).'/'.$row_novinky->id.'.html">'.stripslashes($row_novinky->nadpis).'</a></h2>';
 $obsah .= '<div class="clear" style="height: 20px;"></div>';
 $obsah .= stripslashes($row_novinky->perex);
 $obsah .= '<div class="clear" style="height: 20px;"></div>';
 $obsah .= '<div class="cara"></div>';
 $obsah .= '<div class="clear" style="height: 35px;"></div>';


 
 $x++;

 }
 return $obsah;
}


function nejprodavanejsi2($x=20)
{
// vraci pole ID 20ti nejprodavanejsich produktu
  $query_o = MySQL_Query("SELECT count(O.id_zbozi) AS countProduct, O.id_zbozi
  FROM objednavky O
  LEFT JOIN produkty P ON P.id=O.id_zbozi
  WHERE P.aktivni4=1 GROUP BY O.id_zbozi ORDER BY countProduct DESC LIMIT ".intval($x)." ") or die(err(1));
  while($row_o = MySQL_fetch_object($query_o))
  {
  $pole_nej[]= $row_o->id_zbozi;
  }
  if(is_array($pole_nej))
  {
  return $pole_nej;
  }
  else
  {
  return false;
  }
}



function nejprodavanejsi3($id_kat,$limit,$id_p)
{
// vraci pole ID 20ti nejprodavanejsich produktu
  $query_o = MySQL_Query("SELECT count(O.id_zbozi) AS countProduct, O.id_zbozi
  FROM objednavky O
  LEFT JOIN produkty P ON P.id=O.id_zbozi
  WHERE P.aktivni4=1 AND P.id!=".$id_p." AND P.id_kategorie LIKE '%\"".$id_kat."\"%' 
  GROUP BY O.id_zbozi 
  ORDER BY countProduct DESC LIMIT ".intval($limit)." ") or die(err(1));
  while($row_o = MySQL_fetch_object($query_o))
  {
  $pole_nej[]= $row_o->id_zbozi;
  }
  if(is_array($pole_nej))
  {
  return $pole_nej;
  }
  else
  {
  return false;
  }
}



function url_produktu($id_p,$id_k)
{
	
$ret = '';
// produkt
$query_p = MySQL_Query("SELECT str FROM produkty WHERE id='".intval($id_p)."'") or die(err(1));
$row_p = MySQL_fetch_object($query_p);

// id kategorie je pole - z duvodu moznosti zarazeni produktu do vice kategorii
$id_k2 = unserialize($id_k);

$query_v = MySQL_Query("SELECT vnor FROM kategorie WHERE id='".intval($id_k2[0])."' ") or die(err(1));
$row_v = MySQL_fetch_object($query_v);
$vnor = $row_v->vnor;



if($vnor==1)
{
  $query_s1 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($id_k2[0])."'") or die(err(1));
  $row_s1 = MySQL_fetch_object($query_s1);
  $ret = '/produkty/'.$row_s1->str.'/'.$row_p->str.'/'.$id_p.'.html';   
  
}

if($vnor==2)
{
     $query_s2 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($id_k2[0])."'") or die(err(1));
     $row_s2 = MySQL_fetch_object($query_s2);
  
     $query_s1 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($row_s2->id_nadrazeneho)."'") or die(err(1));
     $row_s1 = MySQL_fetch_object($query_s1);
	 
	 $ret = '/produkty/'.$row_s1->str.'/'.$row_s2->str.'/'.$row_p->str.'/'.$id_p.'.html';  

}

if($vnor==3)
{
     $query_s3 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($id_k2[0])."'") or die(err(1));
     $row_s3 = MySQL_fetch_object($query_s3);
	 
     $query_s2 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($row_s3->id_nadrazeneho)."'") or die(err(1));
     $row_s2 = MySQL_fetch_object($query_s2);
  
     $query_s1 = MySQL_Query("SELECT str, id_nadrazeneho, vnor, id FROM kategorie WHERE id='".intval($row_s2->id_nadrazeneho)."'") or die(err(1));
     $row_s1 = MySQL_fetch_object($query_s1);
	 
	 $ret = '/produkty/'.$row_s1->str.'/'.$row_s2->str.'/'.$row_s3->str.'/'.$row_p->str.'/'.$id_p.'.html';  
}	
	

return $ret;	
}



function vrat_sql_kat($idk,$vnor)
{
  if($vnor==1)
	{ 
	  $query_s1 = MySQL_Query("SELECT id FROM kategorie WHERE vnor=2 AND id_nadrazeneho='".intval($idk)."'") or die(err(1));
      while($row_s1 = MySQL_fetch_object($query_s1))
	  {
	  $s1_arr[] = $row_s1->id;
	  }
	  
	  $query_s2 = MySQL_Query("SELECT id FROM kategorie WHERE vnor=3 AND id_nadrazeneho='".intval($row_s1->id)."'") or die(err(1));
      while($row_s2 = MySQL_fetch_object($query_s2))
	   {
		 $s2_arr[] = $row_s2->id;   
	   }
	 
	  $sql = " ( P.id_kategorie LIKE '%\"".$idk."\"%' " ;
	  
		  if(count($s1_arr)>0)
		  {
		    foreach($s1_arr as $k_s1 => $v_s1)
			  {
				  $sql .= "  OR P.id_kategorie LIKE '%\"".$v_s1."\"%'  "; 
			  }
		  }
		  
		  if(count($s2_arr)>0)
		  {
		    foreach($s2_arr as $k_s2 => $v_s2)
			  {
				  $sql .= "  OR P.id_kategorie LIKE '%\"".$v_s2."\"%'  "; 
			  } 
		  }
		  
	  $sql .= " ) ";
	}
  if($vnor==2)
	{
	  $query_s1 = MySQL_Query("SELECT id FROM kategorie WHERE vnor=3 AND id_nadrazeneho='".intval($idk)."'") or die(err(1));
      while($row_s1 = MySQL_fetch_object($query_s1))
	  {
	  $s1_arr[] = $row_s1->id;
	  }
	  
	  $sql = " ( P.id_kategorie LIKE '%\"".$idk."\"%' ";
	  
	  if(count($s1_arr)>0)
		  {
		    foreach($s1_arr as $k_s1 => $v_s1)
			  {
				  $sql .= "  OR P.id_kategorie LIKE '%\"".$v_s1."\"%'  "; 
			  }
		  }
		  
	   $sql .= " ) ";    
	}
  if($vnor==3)
	{	  
	  $sql = " P.id_kategorie LIKE '%\"".$idk."\"%' ";     
	}


return $sql;	
}



function nahled_produktu($id,$nazev,$cena,$cena_imaginarni,$dph,$sleva,$foto,$popis,$url,$dostupnost,$akce,$novinka,$doporucujeme,$nejprodavanejsi,$vyrobce,$sleva_sess,$x,$typ)
{

  
    if($sleva) 
  	{
  	 $cena_s_dph = round(($cena) - ($cena/100*$sleva));
  	}
  	else
  	{
  	  if($sleva_sess)
  	  {
  	  $cena_s_dph = round(($cena) - ($cena/100 * $sleva_sess));
  	  }
  	  else
  	  {
  	  $cena_s_dph = round($cena);

  	  }

  	}


 $nahodne_id = rand(1,100000);
 $nahledy = '';	
 
 

 $nahledy .= '<div class="nahledy_produktu" onclick="self.location.href=\''.$url.'\'" ';
 
 if($x%3==0)
 {
	 $nahledy .='  style="margin-right: 0px;" ';
 }
 $nahledy .='>';
 

 
  if($cena_s_dph >= __PAB_2__){$nahledy .= '<img src="/img/dz.png" alt="doprava zdarma" title="doprava zdarma" style="position: absolute; z-index: 5; margin-top: 0px; margin-left: 230px;"   />';}
  elseif($akce==1){$nahledy .= '<img src="/img/akce.png" alt="akce" title="akce" style="position: absolute; z-index: 5; margin-top: 0px; margin-left: 230px;"   />';}
  elseif($novinka==1){$nahledy .= '<img src="/img/novinka.png" alt="novinka" title="novinka" style="position: absolute; z-index: 5; margin-top: 0px; margin-left: 230px;"  />';}
  elseif($doporucujeme==1){$nahledy .= '<img src="/img/doporucujeme.png" alt="doporučujeme" title="doporučujeme" style="position: absolute; z-index: 5; margin-top: 0px; margin-left: 230px;"  />';}
 				 
  $nahledy .= '<div class="nahledy_produktu_popis" id="nahledy_produktu_popis_'.$nahodne_id.'" onmouseover="zobraz_nahled(\'nahledy_produktu_popis_'.$nahodne_id.'\');" onmouseout="skryj_nahled(\'nahledy_produktu_popis_'.$nahodne_id.'\');">'.$popis.'</div>';				 
			 
 $nahledy .= '<div class="nahledy_produktu_foto_obal" onmouseover="zobraz_nahled(\'nahledy_produktu_popis_'.$nahodne_id.'\');" onmouseout="skryj_nahled(\'nahledy_produktu_popis_'.$nahodne_id.'\');"><a href="'.$url.'"  title="'.$nazev.'"><img src="'.__URL2__.'/img_produkty/velke/'.$foto.'" 
 alt="'.$nazev.'" title="'.$nazev.'" style="width: 339px;" /></a></div>';
 $nahledy .= '<div class="clear" style="height: 15px;"></div>';
 $nahledy .= '<div class="nahledy_produktu_nazev"><a href="'.$url.'"  title="'.$nazev.'">'.$nazev.'</a></div>';
 $nahledy .= '<div class="clear" style="height: 15px;"></div>';
 
  
 $nahledy .= '<div class="nahledy_produktu_ceny">';
 $nahledy .= '<div class="nahledy_produktu_cena">'.$cena_s_dph.' '.__MENA__.'';
 if($cena_imaginarni>0)
 {
	  $nahledy .= '<br /><span class="seda_pres">'.round($cena_imaginarni).' '.__MENA__.'</span>';
 }
 $nahledy .='</div>';
 $nahledy .='<div class="nahledy_dk">
 <form id="do_kosiku_'.$id.'" method="post" action=""><p>
				 <input type="hidden" name="id_zbozi" value="'.$id.'" />
				 <input type="hidden" name="pocet" value="1" />
				 <input type="submit" name="objednat" value="Do košíku"  title="do košíku" class="sub_dk" />
				 </p></form></div>';
 $nahledy .='</div>';
 
 $nahledy .= '<div class="clear" style="height: 15px;"></div>';
 $nahledy .= '<div class="cara"></div>';
 $nahledy .= '<div class="clear" style="height: 15px;"></div>';
 
 
 
 

 $nahledy .= '<div class="nahledy_produktu_dostupnost">Dostupnost: ';
 if($dostupnost=='skladem')
 {
	 $nahledy .= '<span class="dost1">'.$dostupnost.'</span>';
 }
 else
 {
	 $nahledy .= '<span class="dost2">'.$dostupnost.'</span>';
 }
 $nahledy .='</div>';
 
 


 
 
 
 
 

 
 $nahledy .= '</div>';
 
 if($x%3==0){$nahledy .='<div class="clear" ></div>';}
 


 return $nahledy; 
}


function akce_uvod($x)
{
	$return = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph   
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce  
    WHERE P.aktivni4=1 AND P.akce=1 AND O.typ=1 GROUP BY P.id ORDER BY RAND() LIMIT $x") or die(err(1));

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
		   

			$nej = 0;
			
		   
		   
					   
					   
			$return .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
			  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,3);
		  
		  
		  
		$nx++;  
	  }
	  
	 
	  
	
	return $return;
	  
}


function novinky_uvod($x)
{

	$return = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	

	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph   
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce 
    WHERE P.aktivni4=1 AND P.novinka=1 AND O.typ=1 GROUP BY P.id ORDER BY RAND() LIMIT $x") or die(err(1));

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
		   

			$nej = 0;
			
		   

					   
			$return .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
			  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,5);
		  
		  
		  
		$nx++;  
	  }
	  
	 
	  
	
	return $return;
	  
	  
	  
}


function doporucujeme_uvod($x)
{

	$return = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	

	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph   
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce 
    WHERE P.aktivni4=1 AND P.doporucujeme=1 AND O.typ=1 GROUP BY P.id ORDER BY RAND() LIMIT $x") or die(err(1));

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
		   

			$nej = 0;
			
		   
             
					   
					   
				$return .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
			  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,4);
		  
		  
		  
		$nx++;  
	  }
	  
	 
	  
	
	return $return;
	  
}

function nejprodavanejsi_aktuality($pocet)
{
	
	$nejprodavanejsi = nejprodavanejsi2($pocet);
	
	if(count($nejprodavanejsi) > 0)
	{
	
	
	$return = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	

	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph   
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce 
    WHERE P.aktivni4=1 AND P.id IN(".implode(",",$nejprodavanejsi).") AND O.typ=1 GROUP BY P.id  ") or die(err(1));

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
		   

			$nej = 0;
			
		   
             
					   
					   
				$return .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
			  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,4);
		  
		  
		  
		$nx++;  
	  }
    }
	  
	 
	  
	
	return $return;
	
}

function nejprodavanejsi_kat($idk,$pocet)
{
	$return = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	$id_arr = nejprodavanejsi3($idk,$pocet,0);


	if($id_arr)
	{

	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
    P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
	FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id 
	LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
	LEFT JOIN dph DP ON DP.id=P.id_dph   
	LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce  
    WHERE P.aktivni4=1 AND P.id IN(".implode(",",$id_arr).") AND O.typ=1 GROUP BY P.id") or die(err(1));

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
		   

			$nej = 0;
			
			
			if($sleva) 
		  	{
		  	 $cena_s_dph = round(($row_n->CENA_DB) - ($row_n->CENA_DB/100*$sleva));
		  	}
		  	else
		  	{
		  	  if(__SLEV_SK_SESS__)
		  	  {
		  	  $cena_s_dph = round(($row_n->CENA_DB) - ($row_n->CENA_DB/100 * __SLEV_SK_SESS__));
		  	  }
		  	  else
		  	  {
		  	  $cena_s_dph = round($row_n->CENA_DB);
		
		  	  }
		
		  	}
			
		   
		   $return .= '<div class="box_nejprodavanejsi" onclick="self.location.href=\''.$url.'\'" ';
		     if($nx%2==0){ $return .= ' style="margin-right: 0px;" ';}
		   $return .= ' >';
		   $return .= '<div class="box_nejprodavanejsi_cislo1">'.$nx.'</div>';
		   $return .= '<div class="box_nejprodavanejsi_foto"><img src="'.__URL2__.'/img_produkty/stredni/'.$row_n->ONAZ.'" style="width: 80px; vertical-align: middle;" alt="" /></div>';
		   
		   $return .= '<div class="box_nejprodavanejsi_obal_text">';
			 $return .= '<div class="box_nejprodavanejsi_nazev"><a href="'.$url.'"  title="'.stripslashes($row_n->nazev).'">'.stripslashes($row_n->nazev).'</a></div>';
			 $return .= '<div class="clear" style="height: 10px;"></div>';
			 $return .= '<div class="nahledy_produktu_cena">'.$cena_s_dph.' '.__MENA__.'</div>';
			 

			$return .='</div>';
		   
		   
		   $return .= '</div>';
		   
		    if($nx%2==0){ $return .= ' <div class="clear" style="height: 20px;"></div>';}
					   

		  
		  
		$nx++;  
	  }
     }
	  
	 
	  
	
	return $return;
	  
}




function detail_produtku($id_p)
{ 
	$ret_pr = '';
	$cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	
	$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.popis_detail4, P.$cena_db AS CENA_DB, P.sleva, P.cena_imaginarni, P.kat_cislo, P.vyrobce, P.zaruka,  
				P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, 
				P.id_kategorie, P.prislusenstvi_id, O.nazev AS ONAZ, D.dostupnost, D.dtext
				FROM produkty P 
				LEFT JOIN obrazky O ON O.idp=P.id 
				LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
				WHERE P.aktivni4=1  AND P.id=".intval($id_p)." AND O.typ=1  ") or die(err(1));
	
	$row_n = MySQL_fetch_object($query_n);
	
	
	
	if(!$row_n->ONAZ)
		{
		$row_n->ONAZ = "neni.gif";
		}
		

		$sleva_sess = __SLEV_SK_SESS__;
		   


		    if($row_n->sleva>0 && ($row_n->platnost_slevy>time())) 
			{
			 $cena_s_dph = round(($row_n->CENA_DB) - ($row_n->CENA_DB/100*$row_n->sleva));
			}
			else
			{
			  if($sleva_sess)
			  {
			  $cena_s_dph = round(($row_n->CENA_DB) - ($row_n->CENA_DB/100 * $sleva_sess));
			  }
			  else
			  {
			  $cena_s_dph = round($row_n->CENA_DB);
			  }
			}	
					
	// fotky		
	
		
    $ret_pr .= '<div class="detail-produktu"><div class="detail_foto">';
    
     if($cena_s_dph >= __PAB_2__){$ret_pr .= '<img src="/img/dz.png" alt="doprava zdarma" title="doprava zdarma" style="position: absolute; z-index: 5; margin-top: 20px; margin-left: 20px;"   />';}
     elseif($row_n->akce==1){$ret_pr .= '<img src="/img/akce.png" alt="akce" title="akce" style="position: absolute; z-index: 5; margin-top: 20px; margin-left: 20px;"   />';}
     elseif($row_n->novinka==1){$ret_pr .= '<img src="/img/novinka.png" alt="novinka" title="novinka" style="position: absolute; z-index: 5; margin-top: 20px; margin-left: 20px;"  />';}
     elseif($row_n->doporucujeme==1){$ret_pr .= '<img src="/img/doporucujeme.png" alt="doporučujeme" title="doporučujeme" style="position: absolute; z-index: 5; margin-top: 20px; margin-left: 20px;"  />';}
    
    $ret_pr .= '<div style="width: 558px; min-height: 558px;  margin-top: 8px; margin-left: 10px; text-align: center; overflow: hidden; background-color: #ffffff;"><a href="'.__URL2__.'/img_produkty/nejvetsi/'.$row_n->ONAZ.'" title="'.stripslashes($row_n->nazev).'" rel="foto_group"><img src="'.__URL2__.'/img_produkty/nejvetsi/'.$row_n->ONAZ.'" 
	 title="'.stripslashes($row_n->nazev).'" alt="'.stripslashes($row_n->nazev).'" style="width: 558px; vertical-align: middle; " /></a></div>';
	 
	 $ret_pr .= '<div class="clear" style="height: 10px;"></div>';
	 
	 	// dalsi doplnkove obrazky
	$query_do = MySQL_Query("SELECT * FROM obrazky WHERE idp='".intval($id_p)."' AND typ=0 ") or die(err(1));
	$pocet_do = mysql_num_rows($query_do);
	if($pocet_do)
		{  $ret_pr .= '<div class="clear" style="height: 10px;"></div>';

			while($row_do = MySQL_fetch_object($query_do))
				{
			    $ret_pr .= '<div class="foto_male"><a href="'.__URL2__.'/img_produkty/nejvetsi/'.$row_do->nazev.'" title="'.stripslashes($row_do->popis).'" rel="foto_group"><img src="'.__URL2__.'/img_produkty/stredni/'.$row_do->nazev.'" 
				title="'.stripslashes($row_do->popis).'" alt="'.stripslashes($row_do->popis).'" style="width: 130px; vertical-align: middle;" /></a></div>';
				}
			
		}
    
     $ret_pr .= '<div class="clear"></div>';
	 
	 $ret_pr .='</div>';
	 
	 
	 // pravy
	 
	 $ret_pr .= '<div class="detail_box_pravy_obal">
	 <div class="detail_box_pravy_obal_in" >
	 <div class="clear" style="height: 10px;"></div>
	 <h1>'.stripslashes($row_n->nazev).'</h1>
	 <div class="clear" style="height: 10px;"></div>
	 <div style="float: left;"><span class="seda">Katalogové číslo:</span> <b>'.$row_n->kat_cislo.'</b></div>
	 <div style="float: left; margin-left: 30px;"><span class="seda">Výrobce:</span> <b>'.$row_n->vyrobce.'</b></div>
	 <div class="clear" style="height: 20px;"></div>
	 '.stripslashes($row_n->popis).'
	 <div class="clear" style="height: 5px;"></div>
	 <div style="text-align: right;"><a href="#popis">Více informací</a></div>
	 </div>';
	 
	 $ret_pr .= '<div class="cara"></div>';
	 $ret_pr .= '<div class="det_box_sklad">
	 <div style="height: 20px; line-height: 20px; margin-top: 15px; float: left;">';
	 if($row_n->dostupnost=='skladem')
	  {
		 $ret_pr .= '<img src="/img/fajka2.png" style="vertical-align: middle;" alt="" /> <span style="color: #31c907;"><b>Skladem</b></span> '; 
	  }
	  else
	  {
		  $ret_pr .= $row_n->dostupnost; 
	  }
	 $ret_pr .= '</div>
	 <div style="height: 20px; line-height: 20px; margin-top: 15px; margin-right: 20px; float: right;">'.stripslashes($row_n->dtext).'</div>
	 </div>';
	 

	 $ret_pr .= '<div class="detail_box_pravy_obal_cerny" >
	 <div class="clear" style="height: 38px;"></div>';
	 
	 
	 

	  if($row_n->cena_imaginarni > 0)
	  {
		 //vypocitame slevu v %
		  $jp = $row_n->cena_imaginarni / 100;
		  $dp = $row_n->cena_imaginarni - $cena_s_dph;
		  $tp = round($dp / $jp,2);
		  
		   $ret_pr .= '<div style="height: 20px; line-height: 20px; font-size: 20px; float: left;">Původní cena</div>';
		   $ret_pr .= '<div style="height: 20px; line-height: 20px; font-size: 20px; float: right; text-decoration: line-through;">'.$row_n->cena_imaginarni.' '.__MENA__.'</div>';
		   $ret_pr .= '<div class="clear" style="height: 10px;"></div>';
		   $ret_pr .= '<div style="height: 20px; line-height: 20px; font-size: 20px; float: left;">Akční cena s DPH <span style="color:#32C907">(-'.$tp.'%)</span></div>';
		   $ret_pr .= '<div style="height: 20px; line-height: 20px; float: right; font-size: 32px; font-weight: bold; color: #31c907;">'.$cena_s_dph.' '.__MENA__.'</div>';


		
	  }
	  else
	  {
		  $ret_pr .= '<div class="clear" style="height: 30px;"></div>';
		  $ret_pr .= '<div style="height: 20px; line-height: 20px; font-size: 20px; float: left;">Cena s DPH</div>';
		  $ret_pr .= '<div style="height: 20px; line-height: 20px; float: right; font-size: 32px; font-weight: bold; color: #31c907;">'.$cena_s_dph.' '.__MENA__.'</div>';

	  }
	       
	       
	
	 $ret_pr .= '
	 <div class="clear" style="height: 20px;"></div>';
	 
	 
	 // essox
	  
	  $ret_pr .= '<div style="float: left; border: solid 1px #dedede;"><a href="/essox.html"><img src="/img/essox_box2.png" alt="essox"  /></a></div>';
	 

		  $ret_pr .= '<form id="do_kosiku_'.$row_n->id.'" method="post" action="" style="float: right; margin-top: 30px;" ><p>
				 <input type="hidden" name="id_zbozi" value="'.$row_n->id.'" />
				 <input type="text" name="pocet" value="1" class="input_detail" id="pocet_ks_'.$row_n->id.'" /><img src="/img/tl_nahoru.png" alt="+" style="position: absolute; margin-left: 0px; 
				 margin-top: 11px; cursor: pointer;" onclick="pridej2(\'pocet_ks_'.$row_n->id.'\');" /><img src="/img/tl_dolu.png" alt="-" style="position: absolute; margin-top: 24px; margin-left: 0px; cursor: pointer;" onclick="uber2(\'pocet_ks_'.$row_n->id.'\');" /> <img src="/img/blank.gif" style="width: 10px; height: 25px;" alt=""  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ks &nbsp;&nbsp;&nbsp;
				 <input type="submit" name="objednat" value="Do košíku"  title="do košíku" class="sub_dk" /></p>
				 </form>';
	  
	  
	  $ret_pr .= '<div class="clear" style="height: 20px;"></div>';
	  
	  
	  	 // kalkulacka essox
if($cena_s_dph >= 3000)
{
 	if(!strstr($_SERVER['HTTP_USER_AGENT'],"W3C_Validator"))
    {
 	
  $datum_essox = date('YmdHis');
  $HashKey = sha1(__ESSOX_USERNAME__.'#'.__ESSOX_CODE__.'#'.round($cena_s_dph).'#'.$datum_essox);
  $XML_DATA = '<FinitServiceRequest>
	<Version>1.0</Version>
	<ServiceName>Calculation</ServiceName>
	<BaseParameters>
		<UserName>'.__ESSOX_USERNAME__.'</UserName>
		<Price>'.round($cena_s_dph).'</Price>
		<Timestamp>'.date('YmdHis').'</Timestamp>
		<HashKey>'.$HashKey.'</HashKey>
	</BaseParameters>
</FinitServiceRequest>';	
	
  $ret_pr .= '<div class="clear" style="height: 20px;"></div>';
  $ret_pr .= '<div style=" clear: both; width: auto; text-align: right;">';
  $ret_pr .= '<b style="font-size: 14px; color: red">10 x '.round($cena_s_dph / 10).' Kč + '.round($cena_s_dph / 10).' Kč</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $ret_pr .= '<a onclick="window.open(\''.__ESSOX_URL__.'/?ESXCode=5&ESXAuth='.base64_encode($XML_DATA).'\', \'_blank\', \'toolbar=0,resizable=1, status=1, width=700, height=650\');" style="cursor: pointer;">Kalkulačka splátek</a>';
  $ret_pr .= '</div>';
   }
   
   	  $ret_pr .= '<div class="clear" style="height: 20px;"></div>';
}

	 
	 // konec cerna
	 $ret_pr .= '</div>';
	 // konec pravy
	 $ret_pr .= '</div></div>';
	 

	  	
	  
	  
	 
	 

	 
	 $ret_pr .= '<div class="clear" style="height: 30px;"></div>';
	 
	 
	 
	 
	 
	 
	$ret_pr .= '<div style="width: auto; background-color: #ffffff; padding: 0px; margin: 0px; text-align: left; border: solid 1px #dedede;">';
	
	// zalozky
	
	$ret_pr .= '<a name="popis"></a><div class="ps_top" >
		<div id="det_tlacitko_1" ';
		if($_GET['diskuse'])
		{
			$ret_pr .=' class="box_a2" ';
		}
		else
		{
			$ret_pr .=' class="box_a2_h" ';
		}
		
		$ret_pr .=' onclick="detail_popis();" >POPIS PRODUKTU</div>
		<div class="box_a2" id="det_tlacitko_2" onclick="detail_parametry();" >TECHNICKÉ PARAMETRY</div>
		<div ';
		if($_GET['diskuse'])
		{
			$ret_pr .=' class="box_a2_h" ';
		}
		else
		{
			$ret_pr .=' class="box_a2" ';
		}
		
		$ret_pr .=' id="det_tlacitko_3" onclick="detail_prilohy();" style="width: 393px; border-right: 0px;">PŘÍLOHY PRODUKTU</div>
	</div>';
	
	
	$ret_pr .= '<div class="clear" style="height: 10px;"></div>';
	
	
	// popis
	$ret_pr .= '<div class="boxy_detail" id="d_popis" ';
	 if($_GET['diskuse'])
		{
			$ret_pr .=' style="display: none; color: #1f1f1f;" ';
		}
	 else
		{
			$ret_pr .=' style="display: block; color: #1f1f1f;" ';
		}	
	$ret_pr .= ' >';
	$ret_pr .= stripslashes($row_n->popis_detail4);
	$ret_pr .= '</div>';
	
	
	
	// parametry
	$ret_pr .= '<div class="boxy_detail" id="d_parametry" >';
	$query_tech_par = MySQL_Query("SELECT * FROM tech_par  WHERE id_p='".$row_n->id."' AND aktivni=1 ORDER BY id ASC") or die(err(1));
	if(mysql_num_rows($query_tech_par))
	{

	 $ret_pr .= '<div class="clear" style="height: 10px;"></div>';
	 $ret_pr .= '<table class="tab_kosik" style="width: 100%;" cellpadding="0" cellspacing="5">';
	 $ret_pr .= '<tr><td style="width: 250px; height: 28px; line-height: 28px; font-height: bold; color: #ffffff; 
	 background-color: #222222;">&nbsp;&nbsp;<b>Parametr</b></td>
	 <td style="height: 28px; line-height: 28px; font-height: bold; color: #ffffff; background-color: #222222;">&nbsp;&nbsp;<b>Hodnota</b></td></tr>';
		
		$tx = 1;
		
		while($row_tech_par = MySQL_fetch_object($query_tech_par))
		{
		$ret_pr .= '<tr><td ';
			if($tx%2==0){$ret_pr .= ' style="background-color: #f5f5f5;" ';}
		$ret_pr .= '>&nbsp;&nbsp;&nbsp;'.stripslashes($row_tech_par->nazev).'</td><td ';
			if($tx%2==0){$ret_pr .= ' style="background-color: #f5f5f5;" ';}
		$ret_pr .= '>&nbsp;&nbsp;&nbsp;'.stripslashes($row_tech_par->hodnota).'</td></tr>';	
		$tx++;
		}
		
		
	$ret_pr .= '</table>';
	}
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div>';
	
	$ret_pr .= '</div>';
	
	
	// ke stazeni
	$ret_pr .= '<div class="boxy_detail" id="d_diskuze" >';

	
	// ke stazeni
	
	$query_prilohy = MySQL_Query("SELECT * FROM prilohy  WHERE id_psa='".$row_n->id."' AND typ=1 ORDER BY id ASC") or die(err(1));
	if(mysql_num_rows($query_prilohy))
	{
		

		
		while($row_prilohy = MySQL_fetch_object($query_prilohy))
		{
			
					$ret_pr .= '<div class="prilohy_det">
					<a href="/prilohy/'.$row_prilohy->priloha.'">'.stripslashes($row_prilohy->nazev).'</a>
					</div>';	
					$ret_pr .= '<div class="clear" style="height: 10px;"></div>';
				
			
		}
		

	
	}
	else
	{
		$ret_pr .= '<div style="text-align: center;">Tento produkt neobsahuje přílohy.</div>';
	}
	
				
				
				
				
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div>';
	
	$ret_pr .= '</div>';
	
	
	

	
	// konec bílá 
	$ret_pr .= '</div>';
	
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div>';
	
	
	if($row_n->prislusenstvi_id)
	{
	// doporucene prislusenstvi
	
	$ret_pr .= '<div class="aktuality_foot_nadpis2">DOPORUČENÉ PŘÍSLUŠENSTVÍ</div>';
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div>';


	
				$query_n3 = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, 
				P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
				FROM produkty P 
				LEFT JOIN obrazky O ON O.idp=P.id 
				LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
				LEFT JOIN dph DP ON DP.id=P.id_dph  
				WHERE P.aktivni4=1 AND P.id IN(".implode(",",unserialize($row_n->prislusenstvi_id)).") AND O.typ=1 GROUP BY P.id LIMIT 6") or die(err(1));

				$nx3 = 1;
				while($row_n3 = MySQL_fetch_object($query_n3))
				  {
					  $url3 = url_produktu($row_n3->id,$row_n3->id_kategorie);
					  
					  
					  if($row_n3->sleva>0 && ($row_n3->platnost_slevy>time())) 
						{
							$sleva3 = $row_n3->sleva;
						}
					  else
					   {
					        $sleva3 = 0;
					   }
					   
					  
					  if($row_n3->sleva>0 && ($row_n3->platnost_slevy>time())) 
						{
	
						 $cena_s_dph = round(($row_n3->CENA_DB) - ($row_n3->CENA_DB/100*$row_n3->sleva));

						}
						else
						{
						  if($sleva_sess)
						  {

						  $cena_s_dph = round(($row_n3->CENA_DB) - ($row_n3->CENA_DB/100 * $sleva_sess));
						  }
						  else
						  {

						  $cena_s_dph = round($row_n3->CENA_DB);
						  }

						}
						
						
						
						$ret_pr .= '<div class="nahled_obal_dp" onclick="self.location.href=\''.$url3.'\'" ';
						if($nx3%3==0){ $ret_pr .= ' style="margin-right: 0px;" ';}
						$ret_pr .= '>';
						$ret_pr .= '<div class="nahled_obal_dp_foto"><img src="'.__URL2__.'/img_produkty/stredni/'.$row_n3->ONAZ.'" style="width: 118px;" alt="" /></div>';
						$ret_pr .= '<div class="nahled_obal_dp_text">
						<div class="nahled_obal_dp_nadpis">'.stripslashes($row_n3->nazev).'</div>
						<div class="nahled_obal_dp_cena">'.$cena_s_dph.' '.__MENA__;
						
						/* if($row_n3->cena_imaginarni>0)
							 {
								  $ret_pr .= '&nbsp;&nbsp;&nbsp<span class="seda_pres">'.round($row_n3->cena_imaginarni).' '.__MENA__.'</span>';
							 }*/
													
						
						$ret_pr .= '</div>
						</div>';
						$ret_pr .= '</div>';
						
						
						
	

					  
					  
					  $nx3++;
				  
				  }
			  }
	
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div>';
	
	$ret_pr .= '<div class="aktuality_foot_nadpis2">OBDOBNÉ PRODUKTY</div>';
	
	$ret_pr .= '<div class="clear" style="height: 20px;"></div><div class="product-grid">';
	   // obdobné produkty
   	$id_kat = unserialize($row_n->id_kategorie);
	
	
	$query_n4 = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.sleva, P.cena_imaginarni,
				P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
				FROM produkty P 
				LEFT JOIN obrazky O ON O.idp=P.id 
				LEFT JOIN dostupnost D ON D.id=P.id_dostupnost 
				LEFT JOIN dph DP ON DP.id=P.id_dph  
				WHERE P.aktivni4=1  AND P.id_kategorie LIKE '%\"".$id_kat[0]."\"%'  AND P.id!=".$row_n->id." AND O.typ=1 GROUP BY P.id ORDER BY RAND() LIMIT 6") or die(err(1));

				$nx4 = 1;
				while($row_n4 = MySQL_fetch_object($query_n4))
				  {
					  $url4 = url_produktu($row_n4->id,$row_n4->id_kategorie);
					  
					
					   
					   if($row_n4->sleva>0 && ($row_n4->platnost_slevy>time())) 
						{
							$sleva4 = $row_n4->sleva;
						}
					  else
					   {
					        $sleva4 = 0;
					   }
		   
					  
						$nej = 0;
						
					  
					  //obrazek
					  if(!$row_n4->ONAZ)
						{
						$row_n4->ONAZ = "neni.gif";
						}
					  
					   if($row_n4->sleva>0 && ($row_n4->platnost_slevy>time())) 
						{

						 $cena_s_dph = round(($row_n4->CENA_DB) - ($row_n4->CENA_DB/100*$row_n4->sleva));

						}
						else
						{
						  if($sleva_sess)
						  {

						  $cena_s_dph = round(($row_n4->CENA_DB) - ($row_n4->CENA_DB/100 * $sleva_sess));
						  }
						  else
						  {
		
						  $cena_s_dph = round($row_n4->CENA_DB);
						  }
					
						}		
						
						
						
						
						
						
						$ret_pr .= nahled_produktu($row_n4->id,stripslashes($row_n4->nazev),$row_n4->CENA_DB,$row_n4->cena_imaginarni,$row_n4->dph,$sleva4,$row_n4->ONAZ,stripslashes($row_n4->popis),
			          $url4,$row_n4->dostupnost,$row_n4->akce,$row_n4->novinka,$row_n4->doporucujeme,$nej4,$row_n4->vyrobce,__SLEV_SK_SESS__,$nx4,1);
						
						

					  
					$nx4++;  
				  }
				  
				  
				  
				  
				  
				  $ret_pr .= '</div>"';
				  
				  
				  
	
	
	
	return $ret_pr;
}


function hodnoceni_zakazniku($hvezdy,$pocet)
{
	$ret = '';
	
   for ($i = 1; $i <= $hvezdy; $i++) 
   {
     $ret .= '<img src="/img/hvezda.png" alt="" style="margin-right: 3px;" />';
   }
   
    $ret .= '&nbsp;&nbsp;('.$pocet.')';
   
   return $ret;
}



function kategorie_produktu()
{
	$ret_kat = '';
	$where = '';
	
	// nejdrive zjistime kde se nachazime = zanoreni
	 if($_GET['podskupina_2'])
	 {
	  $query_n = MySQL_Query("SELECT id, str, popis_kratky4 FROM kategorie WHERE str='".addslashes($_GET['podskupina_2'])."' AND aktivni=1 AND vnor=3 ") or die(err(1));
	  $row_n = MySQL_fetch_object($query_n);
	 }
	 elseif($_GET['podskupina'])
	 {
	  $query_n = MySQL_Query("SELECT id, str, popis_kratky4 FROM kategorie WHERE str='".addslashes($_GET['podskupina'])."' AND aktivni=1 AND vnor=2 ") or die(err(1));
	  $row_n = MySQL_fetch_object($query_n);
	 }
	 else
	 {
	  $query_n = MySQL_Query("SELECT id, str, popis_kratky4 FROM kategorie WHERE str='".addslashes($_GET['skupina'])."' AND aktivni=1 AND vnor=1 ") or die(err(1));
	  $row_n = MySQL_fetch_object($query_n);
	 }
	 
	$where_vyr = " WHERE P.aktivni4=1 AND P.id_kategorie LIKE '%\"".$row_n->id."\"%'  ";
	 

   // div pro nadpis a popis

	
	if($row_n->popis_kratky4 && $row_n->popis_kratky4!='<br />')
	{
	 $ret_kat .= '<div class="vice_kat" onclick="zobraz_popis_kat();">Více o kategorii <img src="/img/sipka_dolu2.png" style="vertical-align: middle;" alt="" /></div>';
	 $ret_kat .= '<div class="text_kategorie" style="display: none;" id="text_kategorie" >';
	 $ret_kat .= stripslashes($row_n->popis_kratky4);
	 $ret_kat .= '</div>';

	}
	
	
	$ret_kat .= '<div class="clear" style="height: 20px;"></div><div class="submenu-wrap">';
	
	
	// zobrazime tlacitka podkategorii
	if($_GET['podskupina'])
	{
	   $query_submenu = MySQL_Query("SELECT id,str,nazev, obr FROM kategorie WHERE vnor=3 AND id_nadrazeneho='".$row_n->id."' AND aktivni=1 ORDER BY razeni,nazev") or die(err(1));
             if(mysql_num_rows($query_submenu))
              {    
				  
				$yy = 1;  
			    
                while($row_submenu = MySQL_fetch_object($query_submenu))
                {
					 $ret_kat .= "<div class=\"submenu_kat_box\"  onclick=\"self.location.href='/produkty/".$_GET['skupina']."/".$_GET['podskupina']."/".$row_submenu->str.".html'\" ";
					 if($yy%5==0){$ret_kat .= " style=\"margin-right: 0px;\" "; }
					 $ret_kat .=" >
					 <div class=\"submenu_kat_box_obr\"><img src=\"".__URL2__."/prilohy/".$row_submenu->obr."\" alt=\"\" style=\"width: 58px;\" /></div>
					 <div class=\"submenu_kat_box_text\">".stripslashes($row_submenu->nazev)."</div>
					 </div>";
					 
					 $yy++;
				}
			  }
	
	}
	else
	{
		$query_submenu = MySQL_Query("SELECT id,str,nazev, obr FROM kategorie WHERE vnor=2 AND id_nadrazeneho='".$row_n->id."' AND aktivni=1 ORDER BY razeni,nazev") or die(err(1));
             if(mysql_num_rows($query_submenu))
              {    
				  
				$yy = 1;  
			    
                while($row_submenu = MySQL_fetch_object($query_submenu))
                {
					 $ret_kat .= "<div class=\"submenu_kat_box\"  onclick=\"self.location.href='/produkty/".$row_n->str."/".$row_submenu->str.".html'\" ";
					 if($yy%5==0){$ret_kat .= " style=\"margin-right: 0px;\" "; }
					 $ret_kat .=" >
					 <div class=\"submenu_kat_box_obr\"><img src=\"".__URL2__."/prilohy/".$row_submenu->obr."\" alt=\"\" style=\"width: 58px;\" /></div>
					 <div class=\"submenu_kat_box_text\">".stripslashes($row_submenu->nazev)."</div>
					 </div>";
					 
					 $yy++;
				}
			  }
	}
	
	
	// ukoncime hlavni obal
	$ret_kat .= '</div><div class="clear"></div>';
	$ret_kat .= '</div>';
	$ret_kat .= '<div class="holder4">';
	
	
		$ret_kat .= '<div class="clear" style="height: 20px;"></div>
		<div class="aktuality_foot_nadpis">NEJPRODÁVANĚJŠÍ ZBOŽÍ</div>
		<div class="cara2"></div>
		<div class="clear" style="height: 20px;"></div>';
	


	
	// nejprodavanejsi z dane kategorie
	
	$ret_kat .= '<div class="box_nadpisy_adn">';
	$ret_kat .= nejprodavanejsi_kat($row_n->id,4);
	$ret_kat .= '</div>';
	
	$ret_kat .= '<div class="clear" style="height: 30px;"></div>';
	
	
	
	
	
	
	
	// filtr
	$ret_kat .= '<form id="filtr" method="get" action="">';
	$ret_kat .= '<div class="kat_filtr">';
	

	
	// priznaky
	$ret_kat .=  '<input type="checkbox" name="novinka" value="1" ';
		if($_GET['novinka']==1)
		{
			$ret_kat .= ' checked '; 
			$where .=  ' AND P.novinka=1 ';	
		}
	  $ret_kat .= ' /> Novinka';
	  $ret_kat .= '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="akce" value="1" ';
	  if($_GET['akce']==1)
	  { 
		  $ret_kat .= ' checked '; 
		  $where .=  ' AND P.akce=1 ';	  
		}
	  $ret_kat .= ' /> Akční zboží';
	  $ret_kat .= '&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="doporucujeme" value="1" ';
	  if($_GET['doporucujeme']==1)
	  {
		  $ret_kat .= ' checked '; 
		  $where .=  ' AND P.doporucujeme=1 ';	  
		  }
	  $ret_kat .= ' /> Doporučujeme';
	  
	  $ret_kat .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:zobraz_vyrobce();">+ Vybrat výrobce</a>';
	  
	 
	$ret_kat .= '<input type="submit" name="submit" value="Filtrovat" title="FILTROVAT" class="submit_but2" />
	</div>';
	
	
	
	// div s vyrobci
		
		if($_GET['vyrobci'])
		  {
			$vyrobci_array = array_flip($_GET['vyrobci']);
			$where .= " AND  P.vyrobce IN ('" . implode("','", array_keys($vyrobci_array)) . "')  ";
		 }
	
		$ret_kat .= '<div class="box_vyrobci" id="box_vyrobci" style="display: none;"><div class="clear" style="height: 10px;"></div>';  
		$query_skupina_vyr = MySQL_Query("SELECT P.id, P.vyrobce FROM produkty P ".$where_vyr."  GROUP BY P.vyrobce") or die(err(1));
	    $n = 1;
	    	// vypis vyrobcu
			while($row_skupina_vyr = MySQL_fetch_object($query_skupina_vyr))
			{
				$ret_kat .= "<div class=\"plovouci_vyrobce\"><input type=\"checkbox\" name=\"vyrobci[]\" value=\"".$row_skupina_vyr->vyrobce."\"";
				if($_GET['vyrobci'])
				{
				if(array_key_exists($row_skupina_vyr->vyrobce, array_flip($_GET['vyrobci']))){$ret_kat .= " checked ";}
				}
				$ret_kat .= " id=\"n".$n."\" />&nbsp;".$row_skupina_vyr->vyrobce."</div>";
				$n++; 
			}
			
			$ret_kat .= '<div class="clear" ></div>';

		$ret_kat .= '</div>';  
		
		
		
	
	
	 $ret_kat .=  '<div style="float: left; margin-top: 10px;">Řadit podle: ';
	  
	  $ret_kat .=  '<select name="radit_dle" size="1" style="padding: 3px; background-color: #ffffff; border: solid 1px #dedede; font-size: 14px;">';
	  $ret_kat .=  '<option value=""> -- vyberte -- </option>';

       foreach ($_SESSION['arr_razeni'] as $key => $value) 
       {
	       if($value==$_GET['radit_dle'])
	       {
		      $ret_kat .=  '<option value="'.$value.'" selected>'.$key.'</option>';
	       }
	       else
	       {
		       $ret_kat .=  '<option value="'.$value.'">'.$key.'</option>';;
	       }
       }	
	
	  $ret_kat .= '</select></div>';
	
	
	
	
   	$ret_kat .= '<div style="float: right; text-align: right; margin-top: 10px; width: 400px;">';
	
	
	$limit = intval($_GET['limit']);
	if(!$limit)
	   {
        $limit = 0;
        }
        
     if(!$_SESSION['pocet_strankovani']){$_SESSION['pocet_strankovani'] = __POCET_PRODUKTU_NAHLEDY__;}       
        

	
	$query_pocet = MySQL_Query("SELECT count(P.id) AS CID FROM produkty P 
	LEFT JOIN obrazky O ON O.idp=P.id  
	WHERE P.aktivni4=1 ".$where." AND O.typ=1 AND P.id_kategorie LIKE '%\"".$row_n->id."\"%'  ") or die(err(1));
	$row_pocet = MySQL_fetch_object($query_pocet);
	$pocet = $row_pocet->CID;
	
	 $pocet_stranek = ceil($pocet / $_SESSION['pocet_strankovani']);
	
	$ret_kat .= 'Stránka '; 
	if(!$limit)
		{
			$ret_kat .= ' 1 z '.$pocet_stranek;
		}
	else
		{
		    $ret_kat .= $limit.' z '.$pocet_stranek;
		}	
	$ret_kat .= '</div>';
	
	$ret_kat .= '<div class="clear" style="height: 2px;"></div>';

	$ret_kat .= '<div class="strankovani_kategorie">';
	$ret_kat .= get_links3a($pocet,$limit);
	$ret_kat .= '</div>';

	

    $ret_kat .= '</form>';
    
    

	

	$ret_kat .= '<div class="clear" style="height: 20px;"></div>';
	
	
	

	 
	 $cena_db = 'cena_'.addslashes(__CENOVA_SKUPINA_SESS__);
	 if($row_n->id)
	 {
		 $id_kat = $row_n->id;
	 
		 // razeni
		if($_GET['radit_dle'] && !$_GET['radit_jak'])
		{
		$order_by = " ORDER BY P.".addslashes($_GET['radit_dle'])."";
		}
		elseif($_GET['radit_jak'] && !$_GET['radit_dle'])
		{
		$order_by = " ORDER BY P.datum ".addslashes($_GET['radit_dle'])."";
		}
		elseif($_GET['radit_dle'] && $_GET['radit_jak'])
		{
		$order_by = " ORDER BY P.".addslashes($_GET['radit_dle'])." ".addslashes($_GET['radit_jak'])."";
		}
		else
		{
		$order_by = " ORDER BY P.datum DESC ";
		}
		
		$limit = intval($_GET['limit']);
		if(!$limit)
			   {
				$limit = 0;
				}
	
		$query_n = MySQL_Query("SELECT P.id, P.str, P.nazev, P.popis, P.$cena_db as CENA_DB, P.cena_imaginarni, P.sleva, P.vyrobce,
		P.platnost_slevy, P.novinka, P.akce, P.doporucujeme, P.id_kategorie, O.nazev AS ONAZ, D.dostupnost, DP.dph
		FROM produkty P 
		LEFT JOIN obrazky O ON O.idp=P.id 
		LEFT JOIN dostupnost D ON D.id=P.id_dostupnost  
		LEFT JOIN dph DP ON DP.id=P.id_dph 
		LEFT JOIN vyrobci V ON V.vyrobce=P.vyrobce  
		WHERE P.aktivni4=1  ".$where." AND P.id_kategorie LIKE '%\"".$id_kat."\"%'  AND O.typ=1 GROUP BY P.id ".$order_by." LIMIT $limit, ".intval($_SESSION['pocet_strankovani'])." ") or die(err(1));

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
			   
			   
			  $ret_kat .= nahled_produktu($row_n->id,stripslashes($row_n->nazev),$row_n->CENA_DB,$row_n->cena_imaginarni,$row_n->dph,$sleva,$row_n->ONAZ,stripslashes($row_n->popis),
			  $url,$row_n->dostupnost,$row_n->akce,$row_n->novinka,$row_n->doporucujeme,$nej,$row_n->vyrobce,__SLEV_SK_SESS__,$nx,2);
			  
			  
			  
			  
			$nx++;  
		  }
      }
	  
	  if(!$pocet)
	  {
	   $ret_kat .= '<br /><br /><br />&nbsp;&nbsp;&nbsp;<b>Tato kategorie neobsahuje žádné produkty.</b>';
	  }
	  
	  	 	// strankovani
	$ret_kat .= '<div class="clear" style="height: 15px;"></div>';
	$ret_kat .= '<div class="strankovani_kategorie">';
	$ret_kat .= get_links3a($pocet,$limit);
	$ret_kat .= '</div>';
	$ret_kat .= '<div class="clear" style="height: 15px;"></div>'; 
	 
	 return $ret_kat;


}




function prepocet_euro($k)
{
if($k>0)
 {
  $prepocet = round(($k/__KURZ_EURO__),2);
 }
 else
 {
 $prepocet = '';
 }	

return $prepocet;
}




function sklonovani($p)
{
if($p==1)
 {
  return 'produkt';	 
 }	
elseif($p>1 && $p<5)
 {
  return 'produkty';	 
 } 
else
 {
 return 'produktů';	
 }
}

function sklonovani2($p)
{
if($p==1)
 {
  return 'zákazník';	 
 }	
elseif($p>1 && $p<5)
 {
  return 'zákazníci';	 
 } 
else
 {
 return 'zákazníků';	
 }
}




function reklamni_okno($p)
{
$result = mysql_query("SELECT id, nazev, zobrazit FROM reklamni_okno4 WHERE aktivni=1 AND (datum_od<=UNIX_TIMESTAMP() AND datum_do>=UNIX_TIMESTAMP()) ") or die(err(1));
	 if(mysql_num_rows($result ))
	 {
		$row = MySQL_fetch_object($result);
		// zjistime jestli uz se dnes uzivateli okno zobrazilo
		// pokud ne, tak zobrazime
		if(!$_COOKIE['banner'])
		{
	      if($row->zobrazit==1 && $p=='uvod')
		   {
			   // zobrazime pouze na uvodce
			   echo " onload=\"tb_show('".stripslashes($row->nazev)."','".__URL__."/skripty/reklamni_okno.php?KeepThis=true&amp;TB_iframe=true&amp;height=".__VYSKA_OKNA__."&amp;width=".__SIRKA_OKNA__."','okno');\" "; 
		   }
		   if($row->zobrazit==2)
		   {
		      // zobrazime vsude
			  echo " onload=\"tb_show('".stripslashes($row->nazev)."','".__URL__."/skripty/reklamni_okno.php?KeepThis=true&amp;TB_iframe=true&amp;height=".__VYSKA_OKNA__."&amp;width=".__SIRKA_OKNA__."','okno');\" "; 
		   }
		   
	    }
     }
}




function getEssoxLiteUrl($price)
{


		$seed = time().rand();
        $hash = sha1(__ESSOX_USERNAME__.'#'.__ESSOX_CODE__.'#'.$price.'#'.$seed);
		return __ESSOX_URL__.'/Login.aspx?a='.__ESSOX_USERNAME__.'&b='.$price.'&c='.$seed.'&d='.$hash;
		

}


function google_analytics_obj($id_obj,$id_zak)
{
$text_obj = '';

$query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($id_zak)."'") or die(err(1));
$row_zakaznik = mysql_fetch_object($query_zakaznik); 

$query_obj = MySQL_Query("SELECT celkova_cena, doprava_cena FROM objednavky WHERE id_obj = '".intval($id_obj)."' LIMIT 1") or die(err(1));
$row_obj = mysql_fetch_object($query_obj); 


$text_obj .= "<script type=\"text/plain\" data-cookiecategory=\"performance\">
ga('require', 'ecommerce')\n;
  
ga('ecommerce:addTransaction', {
  'id': '".$id_obj."',
  'affiliation': 'Hifistereo.cz',
  'revenue': '".str_replace(',','.',$row_obj->celkova_cena)."',
  'shipping': '".str_replace(',','.',$row_obj->doprava_cena)."',
  'tax': '1.21',
  'currency': 'CZK' 
});\n\n";


 // smycka s produkty z objednavky
   
   $query_obj2 = MySQL_Query("SELECT * FROM objednavky WHERE id_obj = '".intval($id_obj)."' ORDER BY id") or die(err(1));
   while($row_obj2 = mysql_fetch_object($query_obj2))
   {
	   
	   // zjistime kategorii produktu
	    $query_obj3 = MySQL_Query("SELECT id_kategorie FROM produkty WHERE id = '".intval($row_obj2->id_zbozi)."' ") or die(err(1));
        $row_obj3 = mysql_fetch_object($query_obj3);
        
        if($row_obj3->id_kategorie)
        {
			$id_kat_arr = unserialize($row_obj3->id_kategorie);
			
			$query_obj4 = MySQL_Query("SELECT nazev FROM kategorie WHERE id = '".intval($id_kat_arr[0])."' ") or die(err(1));
            $row_obj4 = mysql_fetch_object($query_obj4);
		}
	   
	$text_obj .= "ga('ecommerce:addItem', {
    'id': '".$id_obj."',
    'name': '".stripslashes($row_obj2->polozky)."',
    'sku': '".$row_obj2->cislo_zbozi."',
    'category': '".stripslashes($row_obj4->nazev)."',
    'price': '".round($row_obj2->cena_ks_bez_dph * ($row_obj2->dph/100+1))."',
    'quantity': '".$row_obj2->ks."',
    'currency': 'CZK' 
  });\n";

   }


$text_obj .= "ga('ecommerce:send');";

$text_obj .= "</script>";	


return $text_obj;
}


$otazky_as = array(
'Kolik je dva plus dva'=>'4',
'Kolik je tři plus šest'=>'9',
'Kolik je pět mínus dva'=>'3',
'Kolik je deset plus deset'=>'20',
'Kolik je osm mínus čtyři'=>'4',
'Kolik je šest plus šest'=>'12',
'Kolik je jedna plus dva'=>'3',
'Kolik je dva plus tři'=>'5',
'Kolik je tři plus čtyři'=>'7'
);




function antispam($otazky_as)
{
$rand_key = array_rand ($otazky_as);
$inputy = "<input type=\"hidden\" name=\"as_hlog_k\" value=\"".$rand_key."\" />".$rand_key." <input type=\"text\" 
name=\"as_hlog_v\" id=\"as_hlog_v\" class=\"form_inp\" value=\"vepište číslici\" onfocus=\"if (this.value=='vepište číslici'){this.value='';}\"
	onblur=\"if (this.value==''){this.value='vepište číslici';}\" style=\"width: 100px;\" />";
	
return $inputy;
}


function eval_buffer($string) 
{
   ob_start();
   eval("$string[2];");
   $return = ob_get_contents();
   ob_end_clean();
   return $return;
}

function eval_print_buffer($string) 
{
   ob_start();
   eval("print $string[2];");
   $return = ob_get_contents();
   ob_end_clean();
   return $return;
}

function eval_html($string) 
{
   $string = preg_replace_callback("/(<\?=)(.*?)\?>/si","eval_print_buffer",$string);
   return preg_replace_callback("/(<\?php|<\?)(.*?)\?>/si","eval_buffer",$string);
}  
?>

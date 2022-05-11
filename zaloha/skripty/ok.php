<?

$obsah_ak = '<div class="container">
        <div class="print-area">
          <article class="post"> ';



if($_GET['OPERATION'] && $_GET['ORDERNUMBER'] && $_GET['PRCODE']==0 && $_GET['SRCODE']==0 && $_GET['RESULTTEXT'] && $_GET['DIGEST'])
{
	
	// overime DIGEST

	 $data = $_GET['OPERATION']."|".$_GET['ORDERNUMBER']."|".$_GET['PRCODE']."|".$_GET['SRCODE']."|".$_GET['RESULTTEXT'];
	 
	 require_once("./tridy/class_signature.php");
	 $sign = new CSignature("./__certifikaty_2020/gpwebpay-pvk.key",__HESLO_KLIC__,"./__certifikaty_2020/gpe.signing_prod.pem"); //pubkey.pem
	 $vysledek = $sign->verify($data,$_GET['DIGEST']);
	 
	
	 
	 if($vysledek)
	 {
		 
		 // vse je OK, odesleme email a zmenime stav v objednavkach
		 
		 
		  
		 // kontrolujeme datum
		    $query_datum = MySQL_Query("SELECT datum FROM objednavky WHERE id_obj = '".intval($_GET['ORDERNUMBER'])."' LIMIT 1 ") or die(err(1));
			$row_datum = mysql_fetch_object($query_datum);
			
			if(($row_datum->datum + 3600) < time())
			{
				// skrip je volan znovu za hodinu a vice od realizace objednavky - roboti
				exit();
			}
			
			
		    MySQL_Query ("UPDATE objednavky SET
			stav='Úspěšná platba kartou',
			card='Úspěšná platba kartou'
			WHERE id_obj='".intval($_GET['ORDERNUMBER'])."'")
			or die(err(3));

			// odeslani emailu
			$query = MySQL_Query("SELECT id_zak, doprava_id, platba_id, ppl_pobocka_id, ppl_pobocka FROM objednavky WHERE id_obj = '".intval($_GET['ORDERNUMBER'])."' LIMIT 1") or die(err(1));
			$order = mysql_fetch_object($query);
			
			// zakaznik
			$query_zakaznik = MySQL_Query("SELECT * FROM zakaznici WHERE id = '".intval($order->id_zak)."'") or die(err(1));
			$row_zakaznik = mysql_fetch_object($query_zakaznik); 

			// doprava
			$query_doprava = MySQL_Query("SELECT * FROM doprava WHERE id = '".intval($order->doprava_id)."'") or die(err(1));
			$row_doprava = mysql_fetch_object($query_doprava); 
			
			// platba - doplnit
			$query_platba = MySQL_Query("SELECT * FROM platba WHERE id = '".intval($order->platba_id)."'") or die(err(1));
			$row_platba = mysql_fetch_object($query_platba); 
			
			$cena_zbozi = 0;
			$produkty2_heureka = '';
			$produkty_heureka = array();
			
			$query_obj = MySQL_Query("SELECT * FROM objednavky WHERE id_obj = '".intval($_GET['ORDERNUMBER'])."' ORDER BY id") or die(err(1));
			while($row_obj = mysql_fetch_object($query_obj)) 
			{
			
			$text_obj .= "<tr><td>".$row_obj->polozky."</td>
			<td>". $row_obj->ks ."</td>";
			$text_obj .= "<td>".$row_obj->cena_ks_bez_dph." ".__MENA__." </td>";
			$text_obj .= "<td>".(1 * $row_obj->dph)."%</td>";
			$text_obj .=  "<td>".round(($row_obj->cena_ks_bez_dph*$row_obj->ks))." ".__MENA__." </td>";  
			$text_obj .=  "</tr>";
             
			$cena_zbozi =  $cena_zbozi + ($row_obj->cena_ks_bez_dph * $row_obj->ks) ;

			$celkova_cena =  $row_obj->celkova_cena;
	
			$poznamka =  $row_obj->poznamka;
			$doprava_cena = $row_obj->doprava_cena;
			$platba_cena = $row_obj->platba_cena;
			$souhlas_obch_pod = $row_obj->souhlas_obch_pod;
			$nesouhlas_heureka = $row_obj->nesouhlas_heureka;
			
			$produkty2_heureka .= "&produkt[]=".urlencode(stripslashes($row_obj->polozky));
			$produkty_heureka[] =  stripslashes($row_obj->polozky)."|".$row_obj->cena_ks_bez_dph."|".$row_obj->ks;		
			
			}
			
			
			$zakaznik = "<br><br>Objednávku na ".__URL__." učinil:<br>
		Jméno a příjmení: <b>".$row_zakaznik->jmeno." ".$row_zakaznik->prijmeni."</b><br>
                Ulice: <b>".$row_zakaznik->ulice." ".$row_zakaznik->cislo."</b><br>
                Obec: <b>".$row_zakaznik->obec."</b><br>
                PSČ: <b>".$row_zakaznik->psc."</b><br>
				Stát: <b>".$_SESSION['arr_staty'][$row_zakaznik->stat]."</b><br>";
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
		
		/*if($_SESSION["gls_id"])
		{
	
			$zakaznik .= "<b>Dodací adresa - GLS ParcelShop:</b> ".strip_tags($_SESSION['gls_name']).", ".strip_tags($_SESSION['gls_address']).", ".strip_tags($_SESSION['gls_city']).", ".strip_tags($_SESSION['gls_zipcode'])."<br />";
		}*/
		
		if($order->ppl_pobocka_id)
		{
			// PPL partner
			
			$zakaznik .= "<b>Dodací adresa - PPL partner:</b> ".$order->ppl_pobocka."<br />";
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
          <br><br>Rekapitulace objednávky:
		       <br><table border=\"1\" style=\"width: 90%; border: solid 1px #bcbcbc; border-collapse: collapse;font-size:12px;\" >
		       <tr style=\"background: #DEDBDB\"><td><b>Název zboží</b></td>
		       <td><b>Počet ks</b></td>
		       <td><b>Cena za kus s DPH</b></td>
		       <td><b>DPH</b></td>
		       <td><b>Cena celkem s DPH</b></td></tr>".
		       $text_obj
		       ."
		       <tr><td colspan=\"4\"><strong>Celková cena:</strong></td><td align=\"right\">
		       <span style=\"color: red; font-weight: bold\">".round($cena_zbozi)." ".__MENA__."</span></td></tr>";


				// doprava
				$body_email .= "<tr style=\"background: #DEDBDB\"><td colspan=\"5\">Způsob dopravy</td></tr>
				<tr><td colspan=\"4\">".$row_doprava->text."</td><td>";
				$body_email .= $doprava_cena." ".__MENA__;
				$body_email .= "</td></tr>";
				
				
				// platba
				$body_email .= "<tr style=\"background: #DEDBDB\"><td colspan=\"5\">Způsob platby</td></tr>
				<tr><td colspan=\"4\">".$row_platba->text."</td><td>";
				$body_email .= $platba_cena." ".__MENA__;
				$body_email .= "</td></tr>";



				$body_email .= "<tr><td colspan=\"4\"><strong>Celková cena zboží včetně poštovného</strong></td>
				<td align=\"right\"><span style=\"color: red; font-weight: bold\">";	
				$body_email .=	round($celkova_cena);


					
				$body_email .=  "  ".__MENA__."</span></td></tr></table>";





				$body_email .= "<br /><br />Přehled a stav svých objednávek můžete v případě registrace sledovat na  <a href=\"".__URL__."/prehled-objednavek.html\">".__URL__."/prehled-objednavek.html</a>";
							   
							   
				$body_email .=  "<br /><br />Poznámka: ".strip_tags($poznamka)."<br><br>";


				        if($_SESSION['nl']==1)
						{
							$body_email .= "<br />".__KOSIK_NL_TEXT__.": ANO";	
						}
						else
						{
							$body_email .= "<br />".__KOSIK_NL_TEXT__.": NE";	
						}
						
						if($_SESSION['souhlas_ou']==1)
						{
							$body_email .= "<br />".__REGISTRACE_SOUHLAS_SE_ZPRAC_OS_UD__.": ANO";	
						}
						
						
						if($souhlas_obch_pod==1)
						{
							$body_email .= "<br />".__KOSIK_SOUHLAS_OBCH_PODM__.": ANO";	
						}
						else
						{
							$body_email .= "<br />".__KOSIK_SOUHLAS_OBCH_PODM__.": NE";	
						}
		
						if($nesouhlas_heureka==1)
						{
							$body_email .= "<br />".__KOSIK_HEUREKA_TEXT__.": ANO";	
						}
						else
						{
							$body_email .= "<br />".__KOSIK_HEUREKA_TEXT__.": NE";	
						}


						$body_email .= "<br /><br />Přehled a stav svých objednávek můžete v případě registrace sledovat na  
						<a href=\"".__URL__."/prehled-objednavek.html\">".__URL__."/prehled-objednavek.html</a>";		       
						 
						$body_email .= nl2br(__KONTAKTY_PATICKA__)."</body></html>";

						
						
						$from_email = __EMAIL_1__;	

				$headers = "From: ".$from_email."\n";
				$headers .= "Return-Path :".$from_email."\n";
				$headers .= "Reply-To :".$from_email."\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=utf-8\n";
				$headers .= "Content-Transfer-Encoding: 8bit\n";
				$headers .= "X-Mailer: Powered by w-shop / PHP /".phpversion()."\n";
				$headers .= "Bcc: ".$from_email ;
			
			
			
			if(!mail($row_zakaznik->eml, "Potvrzeni objednavky c.".intval($_GET['ORDERNUMBER']),$body_email,$headers))
            {
			$obsah_ak .= "<br />Chyba při odesílání objednávky!<br />";
			}
			
			
		 
		 
		 
	 $obsah_ak .= "<b>Platební příkaz byl bankou v pořádku přijat.<br />Děkujeme za nákup.</b>";
	 $obsah_ak .= "<br /><br />";
	 
	 $obsah_ak .= "<br />Vaše objednávka byla v pořádku uložena a na Váš email <strong>".strip_tags($row_zakaznik->eml)."</strong> byla odeslána rekapitulace objednávky.<br />
		O dalším průběhu zpracování Vaši objednávky Vás budeme informovat.<br /><div style='text-align: center'>Děkujeme za nákup.";	
		$obsah_ak .= "<br /><br />
		<input type='submit' name='submit' class='tlacitka_bg2' value='pokračovat' onclick=\"self.location.href='/'\" />
		</a></div><br /><br />";
		
		
		
						 // certifikat spokojenosti - Heureka
						   //pro CZ verzi	
						   if($nesouhlas_heureka!==1)
						   {
						     $url_heureka = "http://www.heureka.cz/direct/dotaznik/objednavka.php?id=629bd2f9c45d8d471c383a5b22ccb654&email=".$row_zakaznik->eml.$produkty2_heureka;
						     file_get_contents($url_heureka);	
						   }
						   
						   
						   // vygenerovani JS kodu pro google analytics
						  $obsah_ak .= google_analytics_obj($_GET['ORDERNUMBER'],$row_zakaznik->id);	
						   
						   /*
						   $obsah_ak .= "<script type=\"text/javascript\">
								var _hrq = _hrq || [];
							    _hrq.push(['setKey', 'A6927E329C48F6341B2970388E274FF2']);
							    _hrq.push(['setOrderId', '".intval($_GET['ORDERNUMBER'])."']);";
							    
							    foreach($produkty_heureka as $heu_key=>$heu_val)
							    {
								list($heu_nazev,$heu_cena,$heu_ks) = explode("|",$heu_val);	
								$obsah_ak .= "_hrq.push(['addProduct', '".$heu_nazev."', '".$heu_cena."', '".$heu_ks."']);";
								}
							    
							   $obsah_ak .= " _hrq.push(['trackOrder']);
							
							(function() {
							    var ho = document.createElement('script'); ho.type = 'text/javascript'; ho.async = true;
							    ho.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.heureka.cz/direct/js/ext/1-roi-async.js';
							    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ho, s);
							})();
							</script>";
					*/
		
						$obsah_ak .=  '<!-- Měřicí kód Sklik.cz -->
						<iframe width="119" height="22" frameborder="0" scrolling="no" src="//c.imedia.cz/checkConversion?c=100025131&color=ffffff&v="></iframe>';
						/*
						$obsah_ak .=  '<script>
						  (function(w,d,s,u,n,k,c,t){w.ZboziConversionObject=n;w[n]=w[n]||function(){
						    (w[n].q=w[n].q||[]).push(arguments)};w[n].key=k;c=d.createElement(s);
						    t=d.getElementsByTagName(s)[0];c.async=1;c.src=u;t.parentNode.insertBefore(c,t)
						  })(window,document,"script","https://www.zbozi.cz/conversion/js/conv.js","zbozi","119597");
						
						   zbozi("setOrder",{
						      "orderId": "'.$id_obj.'",
						      "totalPrice": "'.round($celkova_cena).'"
						   });
						   zbozi("send");
						</script>';
						*/
						
						
						//$obsah_ak .= google_analytics_obj(intval($_GET['ORDERNUMBER']),$row_zakaznik->id);
	 
						unset($_SESSION['kosik']);
						unset($_SESSION['doprava']);	
						unset($_SESSION['platba']);
						unset($_SESSION['poznamka']);	
				
						
						unset($_SESSION['jmeno']);	
						unset($_SESSION['prijmeni']);	
	
						unset($_SESSION['eml']);	
		
						unset($_SESSION['telefon']);	
						unset($_SESSION['uz_jm']);
						unset($_SESSION['heslo']);
						unset($_SESSION['heslo2']);
						unset($_SESSION['chci_registraci']);
						unset($_SESSION['jina_dodaci']);
						
					
						unset($_SESSION['reg_fak_nazev_firmy']);
						unset($_SESSION['reg_fak_ico']);
						unset($_SESSION['reg_fak_dic']);
						unset($_SESSION['reg_fak_ulice']);
						unset($_SESSION['reg_fak_cislo']);
						unset($_SESSION['reg_fak_obec']);
						unset($_SESSION['reg_fak_psc']);
						unset($_SESSION['reg_fak_stat']);
						unset($_SESSION['reg_fak_jmeno']);
						unset($_SESSION['reg_fak_prijmeni']);
						
						unset($_SESSION['reg_dod_jmeno']);
						unset($_SESSION['reg_dod_prijmeni']);
						unset($_SESSION['reg_dod_nazev_firmy']);
						unset($_SESSION['reg_dod_ulice']);
						unset($_SESSION['reg_dod_cislo']);
						unset($_SESSION['reg_dod_obec']);
						unset($_SESSION['reg_dod_psc']);
						unset($_SESSION['reg_dod_stat']);	
						
						unset($_SESSION['newsletter']);
						unset($_SESSION['souhlas']);
						
						unset($_SESSION['souhlas_ou']);
						unset($_SESSION['nesouhlas_heureka']);
						unset($_SESSION['nl']);
						
						
	 }
	 else
	 {
	  $obsah_ak .= '<span class="r">Platební příkaz NEBYL bankou přijat. Zkuste projít znovu všemi kroky košíkem a platbu zopakovat.</span>';
	 }	

	

	
}
elseif($_GET['PRCODE']!=0)
{

 $obsah_ak .= '<span class="r">Platba se nezdařila. Zkuste projít znovu všemi kroky košíkem a platbu zopakovat. Případně vyberte jiný typ platby.<br />'.$_SESSION['prcode_arr'][intval($_GET['PRCODE'])].'</span>';	
 $obsah_ak .= '<br /><span class="r">'.$_SESSION['srcode_arr'][intval($_GET['SRCODE'])].'</span>';	
}
else
{
 $obsah_ak .= 'Chybí parametry';
}




$obsah_ak .= '</article></div></div>';







 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Dokončení objednávky','html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah_ak,'html');
echo $Sablonka->GenerujSablonku('default');
?>

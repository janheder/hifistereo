<?
// poradna
$poradna_t = ' ';



// ulozeni do db
 $err = false;
 if($_POST['pokracovat_d'])
	{
		
		// pokud je IP adresa zakazana zobrazime text a ukoncime
		$query_ip = MySQL_Query("SELECT * FROM zakazane_ip WHERE ip='".addslashes(getip())."' ") or die(err(1));
		if(mysql_num_rows($query_ip))
		{
		 $poradna_t .=  'Z IP adresy '.getip().' je vkládání příspěvků do diskuse zakázáno.';
		 die();
		}
		
		
		
		       if(!$_POST['jmeno'])
				{
				$err .= "Nevyplnili jste jméno<br />";
				}
				
				if(!$_POST['email'])
				{
				$err .= "Nevyplnili jste email<br />";
				}
				
				if(!is_email($_POST['email']))
				{
				$err .= "Váš email má chybnou syntaxi<br />";
				}
				
				if(!$_POST['predmet'])
				{
				$err .= "Nevyplnili jste předmět<br />";
				}
				
				if(!$_POST['dotaz'])
				{
				$err .= "Nevyplnili jste dotaz<br />";
				}
				
				if(!$_POST['souhlas'])
				{
				$err .= "Nesouhlasili jste se zpracováním osobních údajů<br />";
				}
				
				//antispam
				if(!strip_tags($_POST['as_hlog_k']) || !strip_tags($_POST['as_hlog_v']))
				{
				$err .= "Nevyplnili jste kontrolní otázku<br />";
				}
				
				if(!array_key_exists(strip_tags($_POST['as_hlog_k']), $_SESSION['otazky_as'] ))
				{
				$err .= "Chybně vyplněná kontrolní otázka<br />";
				}
				
				foreach ($_SESSION['otazky_as']  as $key => $value)
				{
					if($key==strip_tags($_POST['as_hlog_k']) && $value!=strip_tags($_POST['as_hlog_v']))
					{
					$err .= "Chybně vyplněná kontrolní otázka<br />";
					}
				}
				
				
				
				
				if(!$err)
				{
				$ip_adr = getip();
				
				
				MySQL_Query("INSERT INTO poradna
				(nadpis,text,jmeno,email,ip,datum,aktivni,souhlas)
				VALUES (
				'".addslashes(strip_tags($_POST['predmet']))."',
				'".addslashes(strip_tags($_POST['dotaz']))."',
				'".addslashes(strip_tags($_POST['jmeno']))."',
				'".addslashes(strip_tags($_POST['email']))."',
				'".getip()."',
				UNIX_TIMESTAMP(),
				1,
				".intval($_POST['souhlas'])."
				)") or die(err(2));
				
				
				 $headers = "From: poradna@hifistereo.cz\n";
				 $headers .= "MIME-Version: 1.0\n";
				 $headers .= "Content-type: text/plain; charset=utf-8\n";
				 $headers .= "Content-Transfer-Encoding: 8bit\n";
				 $headers .= "X-Mailer: w-shop powered by PHP / ".phpversion();
				 
				 $body = "Jméno: ".strip_tags($_POST['jmeno'])."\nEmail: ".strip_tags($_POST['email'])."\nPředmět: ".strip_tags($_POST['predmet'])."\nDotaz: ".strip_tags($_POST['dotaz']);
			
			
			     if(!mail(__EMAIL_1__, "Novy dotaz na webu ".__URL__, $body,$headers))
				  {
				  $poradna_t .= "<br /><span class=\"r\"><br />Chyba při odesílání e-mailu<br /></span>";
				  }
				  else
				  {
					  
					$poradna_t .= "<br /><span class=\"r\">Váš dotaz byl odeslán.<br /><br /></span>";
					
				
				  }
			
			    
			    
			    }
			    else
			    {
					 // vypis chyb
				  $poradna_t .=  "<br /><span class=\"r\">".$err."</span><br /><br />";
				}
		
		
		
		
	}


$query_con_g5_pocet = MySQL_Query("SELECT P.id FROM poradna P WHERE P.aktivni=1 AND P.typ=0 ");
$pocet_p = mysql_num_rows($query_con_g5_pocet);

		

		// limit
		$limit = intval($_GET['limit']);
		if(!$limit)
	    {
        $limit = 0;
        }


	    $query_con_g5 = MySQL_Query("SELECT P.* FROM poradna P  WHERE P.aktivni=1 AND P.typ=0 ORDER BY P.datum DESC LIMIT $limit, 30");
		$counter = 1;
		$poradna_t .= '<input type="button" class="sub_dk2"  title="položit dotaz" value="+ Položit dotaz"  style="float: left;" 
							onclick="self.location.href=\'#formular\'" />';
		$poradna_t .= '<div class="str1" style="float: right;">';
		$poradna_t .= get_links3a($pocet_p,$limit);
		$poradna_t .= '</div>';
		
		$poradna_t .= '<div class="clear" style="height: 30px;"></div>';
		
		
		while($row_con_g5 = MySQL_fetch_object($query_con_g5))
		{
		  $poradna_t .= '<div class="otazka_obal">
		  
		  <span style="font-size: 20px; color: #999999">Otázka: </span><span style="font-size: 20px; color: #222222">'.stripslashes($row_con_g5->nadpis).'</span> 
		  <div class="clear" style="height: 10px;"></div>
		  <span style="font-size: 14px; color: #999999">Autor: </span><span style="font-size: 14px; color: #222222">'.stripslashes($row_con_g5->jmeno).'&nbsp;&nbsp;&nbsp;&nbsp;
		  <span style="font-size: 14px; color: #999999">Datum: </span><span style="font-size: 14px; color: #222222">'.date("d.m.Y",$row_con_g5->datum).'</span>
		  <div class="clear" style="height: 10px;"></div>
		  '.stripslashes($row_con_g5->text);

			// odpoved
			$query_con_g6 = MySQL_Query("SELECT P.* FROM poradna P  WHERE P.aktivni=1 AND P.typ=1 AND P.reakce_na_id=".$row_con_g5->id." ORDER BY P.datum DESC ");
						 if(mysql_num_rows($query_con_g6 ))
						 { 
							 
							 $poradna_t .= '<div class="clear" style="height: 10px;"></div>
							 <div class="odpoved_obal">';
							 
							 while($row_con_g6 = MySQL_fetch_object($query_con_g6))
								{ 
						$poradna_t .= '<span style="font-size: 20px; color: #999999">Odpověď: </span><span style="font-size: 20px; color: #222222">'.stripslashes($row_con_g6->nadpis).'</span> 
						  <div class="clear" style="height: 10px;"></div>
						  <span style="font-size: 14px; color: #999999">Autor: </span><span style="font-size: 14px; color: #222222">'.stripslashes($row_con_g6->jmeno).'&nbsp;&nbsp;&nbsp;&nbsp;
						  <span style="font-size: 14px; color: #999999">Datum: </span><span style="font-size: 14px; color: #222222">'.date("d.m.Y",$row_con_g6->datum).'</span>
						  <div class="clear" style="height: 10px;"></div>
						  '.stripslashes($row_con_g6->text);

					         }
					         
					         $poradna_t .= '</div>';
					         
					         
					      }



		   $poradna_t .= '<div class="clear" style="height: 30px;"></div>
		  <div class="cara" ></div>
		  <div class="clear" style="height: 30px;"></div>';
		  
		  
		  $poradna_t .= '</div>';
		  

		
		}
		
		
		
		$poradna_t .= '<a name="formular"></a>';
		$poradna_t .= '<div class="clear" style="height: 30px;"></div>';
		
		$poradna_t .= "<br /><h3>ZEPTEJTE SE NÁS:</h3><br />";

		

		$poradna_t .= '<form id="vzkaz" method="post" action="" onsubmit="return validate_poradna();">
		<table width="100%" border="0">
		    <tr>
				<td style="width: 50%">
					<input type="text" class="form_inp" id="jmeno" name="jmeno" value="Jméno" onfocus="if (this.value==\'Jméno\'){this.value=\'\';}"
					onblur="if (this.value==\'\'){this.value=\'Jméno\';}" />
				</td>
				<td style="width: 50%">
					<input type="text" class="form_inp" id="email" name="email" value="Email" onfocus="if (this.value==\'Email\'){this.value=\'\';}"
					onblur="if (this.value==\'\'){this.value=\'Email\';}"  />
				</td>
			 </tr>
			 <tr>
				<td colspan="2" style="height: 10px;"></td>
			</tr>	
			 <tr>
				<td>
					<input type="text" class="form_inp" id="predmet" name="predmet" value="Předmět" onfocus="if (this.value==\'Předmět\'){this.value=\'\';}"
					onblur="if (this.value==\'\'){this.value=\'Předmět\';}" />
				</td>
				<td>
					'.antispam($_SESSION['otazky_as']).'
				</td>
			 </tr>
			 <tr>
				<td colspan="2" style="height: 10px;"></td>
			</tr>	
			 <tr>
				<td colspan="2">
				<textarea name="dotaz" id="dotaz" class="poznamka_kosik" style="width: 700px; margin-left: 0px;" onfocus="if (this.value==\'Dotaz\'){this.value=\'\';}"
					onblur="if (this.value==\'\'){this.value=\'Dotaz\';}">Dotaz</textarea>
				</td>
			 </tr>	
			 <tr>
				<td colspan="2" style="height: 10px;"></td>
			</tr>
			
			<tr>
				<td colspan="2">
				
   <input name="souhlas" id="osobni-udaje" type="checkbox"   value="1">
                            <span>'.__PORADNA_SOUHLAS_SE_ZPRAC_OS_UD__.'</span>

				</td>
			 </tr>
			
			<tr>
				<td colspan="2" style="height: 10px;"></td>
			</tr>
			<tr>
				<td colspan="2" >
				<input type="submit" class="sub_dk2" name="pokracovat_d"  title="Odeslat dotaz" value="Odeslat dotaz"  style="float: right; margin-right: 10px;" />
				</td>
			</tr>
			</table></form>';
		

 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Poradna','html');
 $Sablonka->PridejDoSablonky('[obsah]',$poradna_t,'html');
echo $Sablonka->GenerujSablonku('aktuality');
?>

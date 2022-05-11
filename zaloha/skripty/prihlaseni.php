<?
// prihlaseni
     $prihlaseni_form = '<form id="prihlaseni" action="/prihlaseni.html" method="post" >';
	 $prihlaseni_form .= '<table class="noborder" style="margin-left: auto; margin-right: auto;">
	 <tr><td><div class="form_text">Uživatelské jméno <img src="/img/req.gif" /></div><input type="text" name="prihlaseni_uz_jm" value="" class="form_inp" /> </td></tr>';
	 $prihlaseni_form .= '<tr><td><div class="form_text">Heslo <img src="/img/req.gif" /></div><input type="password" name="prihlaseni_heslo" value="" class="form_inp" /> </td></tr>';
     $prihlaseni_form .= '<tr><td>&nbsp;</td></tr>';
	 $prihlaseni_form .= '<tr><td>
	 <input type="hidden" name="prihlasit" value="'.md5(time()).'" />
	 <input type="hidden" name="referer" value="'.$_SERVER['HTTP_REFERER'].'" />
	 <input type="submit" name="submit" value="Odeslat" title="Odeslat heslo" class="submit_but" />
	 <br /><br /><a href="/zapomenute-heslo.html">Zapomenuté heslo</a>
	 </td></tr></table>';
	 $prihlaseni_form .= '</form>';

if($_POST['prihlasit'])
{
	
	$Prihlaseni =  new Prihlaseni();
	$prihlaseni_t = '<span class="r">'.$Prihlaseni->PrihlasUzivatele();
	
    $prihlaseni_t .= '</span><div class="clear" style="height: 20px;"></div>';
	
	if(!$_SESSION['prihlaseni'])
	{
		$prihlaseni_t .= $prihlaseni_form;
	}
	else
	{
	  	
		 list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
		 
		 $prihlaseni_t .= '<div class="div_kos_text">
				   <b>Přihlášení proběhlo v pořádku.</b>
				   <br /><br />
				   <b>Vaše aktuální sleva  je ve výši '.$sleva_sess.'% na veškeré zboží, které není ve slevě.</b> Cena zboží je již ponížena o toto %. 
				   O celkové slevě jste informováni v košíku. </div>';
		 $prihlaseni_t .= '<div class="clear" style="height: 10px;"></div>';
		
		if(preg_match('/kosik.html/', $_POST['referer'],$match))
		{
			$prihlaseni_t .= '<div style="text-align: center;"><input type="button" name="but1" value="POKRAČOVAT" title="POKRAČOVAT" class="submit_but" onclick="self.location.href=\'/kosik.html?krok=3\'" /></div>';
		}
	    else
		{
			$prihlaseni_t .= '<div style="text-align: center;"><input type="button" name="but1" value="POKRAČOVAT" title="POKRAČOVAT" class="submit_but" onclick="self.location.href=\'/\'" /></div>';
		}	
		

	}
}
else
{
	 $prihlaseni_t .= $prihlaseni_form;
	 
}


 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Přihlášení','html');
 $Sablonka->PridejDoSablonky('[obsah]',$prihlaseni_t,'html');
echo $Sablonka->GenerujSablonku('default');
?>

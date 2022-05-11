<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="cs" />
<meta name="description" content="<?
$Seo_description = new Seo($_SESSION['menu_all'],$_GET['p']);
$Seo_description->GenerujDescription();
?>" /> 
<meta name="keywords" content="<?
$Seo_keywords = new Seo($_SESSION['menu_all'],$_GET['p']);
$Seo_keywords->GenerujKeywords();
?>" lang="cs" />
<meta name="author" content="eline.cz" />
<meta name="robots" content="index,follow,snippet,archive" />
<meta name="MSSmartTagsPreventParsing" content="true" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<meta http-equiv="imagetoolbar" content="no" />
<title><? 
$Seo_title = new Seo($_SESSION['menu_all'],$_GET['p']);
$Seo_title->GenerujTitle();
?></title>
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=latin-ext" rel="stylesheet" /> 
<style type="text/css" media="screen">
@import url("/css/thickbox.css");
@import url("/css/jquery.fancybox-1.3.2.css");
@import url("/css/jquery.bxslider.css");
@import url("/css/default.css");
</style>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/thickbox.js"></script>
<script type="text/javascript" src="/js/jquery.fancybox-1.3.2.js"></script>
<script type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="/css/cookieconsent.css">
    <script type="text/javascript" src="/js/cookieconsent.js" defer></script>
    <script type="text/javascript" src="/js/cookieconsent-init.js" defer></script>
	<script type="text/plain" data-cookiecategory="tracking">

/* <![CDATA[ */

var seznam_retargeting_id = 40631;

/* ]]> */

</script>

<script type="text/plain" data-cookiecategory="tracking" src="//c.imedia.cz/js/retargeting.js"></script>
<script type="text/javascript">
<!--
		$(document).ready(function() {
			$("a[rel=foto_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
		});
//-->
</script >
<script type="text/javascript">
<!--

$(document).ready(function(){
  $('.bxslider').bxSlider({
     mode: 'fade',
     infiniteLoop: true,
     auto: true,
     captions: true,
     speed: 800
  });
});
//-->
</script>
<script type="text/plain" data-cookiecategory="performance">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-85677502-1', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body <?
// zobrazeni kose by ajax
if($_POST['id_zbozi'] && $_POST['pocet'])
{
  echo " onload=\"tb_show('Zboží bylo vloženo do košíku','/skripty/kosik_div.php?id_zbozi=".intval($_POST['id_zbozi'])."&pocet=".intval($_POST['pocet'])."&varianta=".intval($_POST['varianta'])."&varianta2=".intval($_POST['varianta2'])."&KeepThis=true&TB_iframe=true&height=300&width=600','okno');\" ";
  
}
// reklamni okno
reklamni_okno($_GET['p']);  
?>>
<div class="poradna_box" ><a href="/poradna.html"><img src="/img/poradna.png" alt="poradna"/></a></div>
<div class="top_pruh" id="top">
		<div class="top_pruh_in">
			<div class="top_pruh_in_menu">
			<?
			odkazy($_GET['p'],$_SESSION['menu_db']);
			?>
			</div>
			<div class="top_pruh_in_tel"><img src="/img/tel.png" alt="tel" style="vertical-align: middle;" /> <? echo __TELEFON_TOP__;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/img/eml.png" 
			alt="email" style="vertical-align: middle;"  /> <a href=""><? echo __EMAIL_1__;?></a></div>
		</div>
</div>


<div class="top_pruh2">
	<div class="top_pruh2_in">
		<div class="top_pruh2_logo"><a href="/" title="<? echo __TITLE_LOGA__;?>"><img src="/img/logo.png" alt="logo" /></a><h1><? echo __TITLE_LOGA__;?></h1></div>
		<div class="top_pruh2_text">ŠPIČKOVÁ HUDEBNÍ TECHNIKA<br />PRO VŠECHNY FAJNŠMEKRY</div>
		
		<div class="top_pruh2_kosik" onclick="self.location.href='/kosik.html'">
		    <div class="top_kosik_pocet">
			<? 
			if($_POST['id_zbozi'] && $_POST['pocet'])
			 {
				// vlozeni zbozi do kosiku	
				$Kosik2 = new Kosik($_SESSION['kosik'],__CENOVA_SKUPINA_SESS__,__SLEV_SK_SESS__);
				$Kosik2->VlozDoKosiku(intval($_POST['id_zbozi'])."|".intval($_POST['varianta'])."|".intval($_POST['varianta2']),intval($_POST['pocet']));
			 }
			 
			 $Kosik = new Kosik($_SESSION['kosik'],__CENOVA_SKUPINA_SESS__,__SLEV_SK_SESS__);
			 $Kosik->ObsahKosiku();
			?>
			</div>
			<div class="clear" style="height: 32px;"></div>KOŠÍK
		</div>
		
		
		<div class="top_pruh2_prihlas" id="top_prihlas" 
		<?
		  if($_SESSION['prihlaseni'])
			{ 
				echo " onmouseover=\"zobraz_prihlas();\" onmouseout=\"skryj_prihlas();\" ><div class=\"clear\" style=\"height: 78px;\"></div>UŽIVATEL";
					

			}
			else
			{
				echo  " onmouseover=\"zobraz_prihlas();\" onmouseout=\"skryj_prihlas();\" ><div class=\"clear\" style=\"height: 78px;\"></div>UŽIVATEL";
			}
		?>
		</div>
		<div class="prihlas_okno" style="display: none;" id="prihlas_okno" onmouseover="zobraz_prihlas();" onmouseout="skryj_prihlas();">
			<?
			 if($_SESSION['prihlaseni'])
			 { 
				 list($uz_jm_sess,$heslo_sess,$jmeno_sess,$id_zak_sess,$cenova_skupina_sess,$sleva_sess) = explode("|",base64_decode($_SESSION['prihlaseni']));
				 
				 echo '<div class="clear" style="height: 40px;"></div>';
				 echo '<div class="top_prihlas_okno_jmeno">'.strip_tags($jmeno_sess).'</div>';
				 echo '<div class="clear" style="height: 20px;"></div>';
				 echo '<a href="/prehled-objednavek.html">Historie objednávek</a><br />';
				 echo '<a href="/uprava-reg-udaju.html">Úprava údajů</a><br />';
				 echo '<a href="/skripty/odhlasit.php">Odhlásit se</a><br />';
			 
			 }
			 else
			 {
				 echo '<div class="clear" style="height: 30px;"></div>';
				 echo '<a href="/prihlaseni.html">Přihlášení</a><br />';
				 echo '<a href="/registrace.html">Registrace</a><br />';
				 echo '<a href="/zapomenute-heslo.html">Zapomenuté heslo</a><br /><br />';
			 }
			?>
		</div>
		
		
		<div class="top_pruh2_vyhl" id="top_vyhl" onmouseover="zobraz_vyhl();" onmouseout="skryj_vyhl();" ><div class="clear" style="height: 78px;"></div>HLEDAT
		</div>
		<div class="vyhl_okno" style="display: none;" id="vyhl_okno" onmouseover="zobraz_vyhl();" onmouseout="skryj_vyhl();">
			<div class="clear" style="height: 8px;"></div>
			<form id="vyhl" method="post" action="/vyhledavani.html">
			<p>
				<?
				if(!strstr($_SERVER['HTTP_USER_AGENT'],"W3C_Validator"))
			    {
				
				echo '<input type="text" name="vyhledavani" value="zadejte hledaný výraz" onfocus="if (this.value==\'zadejte hledaný výraz\'){this.value=\'\';}" 
				onblur="if (this.value==\'\'){this.value=\'zadejte hledaný výraz\';}" class="input_vyhledavani" autocomplete="off" /><input type="submit" name="submit" 
				title="Hledat" value="Hledat" class="sub_vyhledavani"  />';
			    }
			   ?>
			</p>
		   </form>
		</div>
		
	</div>	
</div>	



<div class="top_menu_kat_obal" >
	<div class="top_menu_kat_in">
		<?
			top_menu_kat($_GET['p']);
		?>
	</div>
</div>	






<div class="obal_sedy">
	<?
	if($_GET['idp'])
	{
		// zcela odlisne formatovani stranky pro detail
		 echo '<div class="clear" style="height: 20px;"></div>
		 <div class="holder">';
		 echo '<div class="drobinka">';
			
			// drobinka
			$Seo_drobinka = new Seo($_SESSION['menu_all'],$_GET['p']);
			$Seo_drobinka->GenerujDrobinku();
			
		echo '</div>';
		echo '<div class="clear" style="height: 20px;"></div>';

		
	}
	else
	{
		echo '<div class="clear" style="height: 40px;"></div>
	    <div class="holder2">';
	    echo '<div class="drobinka">';
			
			// drobinka
			$Seo_drobinka = new Seo($_SESSION['menu_all'],$_GET['p']);
			$Seo_drobinka->GenerujDrobinku();
			
		echo '</div>
		<div class="clear" style="height: 40px;"></div>
		<h1>[nadpis]</h1>
		<div class="clear" style="height: 20px;"></div>';
	}
	?>
		
		[obsah]
			
	
		<div class="clear" style="height: 15px;"></div>
	</div>	
	<div class="clear" style="height: 40px;"></div>
</div>	


<div class="obal_bily">
	<div class="holder">
		<div class="clear" style="height: 60px;"></div>
		<div class="aktuality_foot_nadpis">AKTUALITY</div>
		<div class="aktuality_foot_archiv"><a href="/aktuality.html">Archiv aktualit</a></div>


		<div class="clear" style="height: 45px;"></div>
		<div class="aktuality_box_in-wrap">
		<?
		 echo aktuality_uvod(3);
		?>
		</div>
		<div class="clear" style="height: 45px;"></div>
		<div class="infobox_pata-wrap">
			<div class="infobox_pata"><div class="clear" style="height: 30px;"></div><img src="/img/auto.png" style="float: left;" alt="" />DOPRAVA ZDARMA<br />nad <b><? echo __PAB_2__." ".__MENA__;?></b></div>
			<div class="infobox_pata"><div class="clear" style="height: 30px;"></div><img src="/img/kosik3.png" style="float: left;" alt="" /><b><? echo __POCET_PRODUKTU__;?> PRODUKTŮ</b><br />SKLADEM</div>
			<div class="infobox_pata"><div class="clear" style="height: 30px;"></div><img src="/img/balik.png" style="float: left;" alt="" /><b>DÁREK K OBJEDNÁVCE</b><br />NAD <? echo __CENA_DAREK__." ".__MENA__;?></div>
			<div class="infobox_pata" style="margin-right: 0px;"><div class="clear" style="height: 30px;"></div><img src="/img/hvezda.png" style="float: left;" alt="" /><b><? echo __POCET_VYDEJNICH_MIST__;?> VÝDEJNÍCH MÍST</b><br />PO CELÉ ČR</div>
		</div>
	
		<div class="clear" style="height: 58px;"></div>
	</div>
</div>		

	

<div class="pata_obal">
	
		<div class="nl">
			<div class="holder">
			
				<div class="nl_leva">
					Novinky na Váš email
				</div>
				<div class="nl_prava">
					<form id="neewsletter_f" method="post" action="/newsletter.html">
					<p>
					<input type="text" name="newsletter_email" value="@" class="inp_n" />
					<input type="submit" name="prihlasit" value="Odebírat" title="Odebírat" class="inp_s1" />
					</p>
					 <p><div class="clear" style="height: 10px;"></div><input class="form-check__input" type="checkbox" name="souhlas" value="1" required=""> <? echo __TEXT_POD_OKNEM_NL__;?></p>
					</form>
				</div>	
			</div>
		</div>
		
		
		
	<div class="holder">
		<div class="clear" style="height: 60px;"></div>
		<div class="pata_box1">
			<span class="p_nadpisy">NAVIGACE</span>
			<div class="clear" style="height: 20px;"></div>
			<?
			// vypis kategorii prvni urovne
			vypis_kategorii_pata();
			?>
		</div>	
		<div class="pata_box1">
			<span class="p_nadpisy">DŮLEŽITÉ ODKAZY</span>
			<div class="clear" style="height: 20px;"></div>
			<a href="/o-nas.html">O společnosti</a><br />
			<a href="/obchodni-podminky.html">Obchodní podmínky</a><br />
			<a href="/reklamacni-rad.html">Reklamační řád</a><br />
			<a href="/jak-nakupovat.html">Jak nakupovat</a><br />
			<a href="/doprava-zdarma.html">Doprava zdarma</a><br />
			<a href="/ochrana-osobnich-udaju.html">Ochrana osobních údajů</a><br />
			<a href="/castedotazy.html">Časté dotazy</a><br />
			<a href="/nakup-na-splatky-essox.html">Nákup na splátky ESSOX</a><br />
			<a href="/kontakty.html">Kontakty</a><br />
			<a href="/cookies.html">Cookies</a><br />
		</div>	

		<div class="pata_box2">
			<span class="p_nadpisy">KONTAKTNÍ INFORMACE</span>
			<div class="clear" style="height: 34px;"></div>
			<b>Sdružení House Of Music</b><br />
			Podpuklí 288<br />
			Frýdek-Místek<br />
			738 01
			<br /><br />
			<img src="/img/tel_b.png" alt="telefon" style="vertical-align: middle;" /> (+420) 777 888 042<br />
			<img src="/img/eml_b.png" alt="email" style="vertical-align: middle;" /> <a href="mailto:info@hi-fisystemy.cz">info@hi-fisystemy.cz</a>
			<br /><br /><a href="/kontakty.html">Více kontaktů</a>
		</div>
		
		<div class="clear" style="height: 17px;"></div>
		<div class="pata_odkazy">
		<?
		odkazy_spodek();
		?>
		</div>
		<div class="pata_nahoru"></div>
	</div>
	
</div>	
<div id="top-link-block" >
    <a href="#top" onclick="$('html,body').animate({scrollTop:0},'slow');return false;">
      <img src="/img/nahoru.png" alt="nahoru"  />
    </a>
</div>
<script type="text/javascript">


$(window).scroll(function() {
    var height = $(window).scrollTop();

    if(height  > 250) {
        $('#top-link-block').css( "display", "block" );
    }
    else
    {
		$('#top-link-block').css( "display", "none" );
	}
});

</script>
</body>
</html>

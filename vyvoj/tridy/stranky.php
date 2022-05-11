<?
// dle podminek a parametru z URL nacte danou stranku
class Stranka
{
	public $p; // nazev stranky z URL
	private $menu; // pole stranek z db
	
	function __construct($menu)
	{
	 $this->menu = $menu;
	}

	public function NactiStranku($p)
	{
	 $this->page = sanitize($p);
	 
	 
	  if($this->page)
	  { 
		 if(file_exists("./skripty/".$this->page.".php"))
		 {
		  include_once("./skripty/".$this->page.".php");
		  // navyseni poctu zobrazeni
		  MySQL_Query ("UPDATE stranky4 SET precteno=precteno+1 WHERE str='".$this->page."' AND lang='".__LANG__."'") or die(err(3));
		 }
		 elseif (array_key_exists($p,$this->menu))
         {
          $query_str = MySQL_Query("SELECT id, nadpis, obsah, fotogalerie FROM stranky4 WHERE str='".$this->page."' AND lang='".__LANG__."'") or die(err(1));
          $row_str = MySQL_fetch_object($query_str);
		  //echo $row_str->obsah;
		  
		  $text = stripslashes($row_str->obsah);
		  
		  
		  	// ke stazeni
	
			$query_prilohy = MySQL_Query("SELECT * FROM prilohy  WHERE id_psa='".$row_str->id."' AND typ=2 ORDER BY id ASC") or die(err(1));
			if(mysql_num_rows($query_prilohy))
			{
				
				$text .= '<div class="clear" style="height: 20px;"></div>';
				$text .= '<h3>Ke stažení:</h3>';
				$text .= '<div class="clear" style="height: 10px;"></div>';
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
			
					$text .= '<div class="prilohy_det">
					<a href="'.__URL2__.'/prilohy/'.$row_prilohy->priloha.'">'.$nazev_prilohy.'</a>
					</div>';	
					$text .= '<div class="clear" style="height: 10px;"></div>';
				}
				

			
			}
		  
		  
		  // fotogalerie
		   if($row_str->fotogalerie)
		   {
				 $text .= '<div class="clear" style="height: 15px;"></div>';
				 $text .= '<div class="clear" style="height: 15px;"></div>';
				 $text .= '<h2>Fotogalerie:</h2><br /><br />';
				 $text .= '<div class="fg">';
					$query_con_g2 = MySQL_Query("SELECT * FROM galerie WHERE id='".$row_str->fotogalerie."'");
					$row_con_g2 = MySQL_fetch_object($query_con_g2);

					
					$f = 1;
					$query_con_g3 = MySQL_Query("SELECT id, foto, rozmer_s, rozmer_v, velikost, autor, nazev, popis, cas, shlednuto from fotky 
					WHERE id_galerie='".$row_str->fotogalerie."' AND aktivni=1 ORDER BY id DESC") or die(err(1));
					while($row_con_g3 = MySQL_fetch_object($query_con_g3))
					{
					// shlednuto update
					MySQL_Query ("UPDATE fotky SET
					shlednuto=shlednuto+1
					WHERE id='".$row_con_g3->id."'")
					or die(err(3));
					 
					$text .= '<a href="'.__URL2__.'/obr_velke/'.$row_con_g3->foto.'"  rel="foto_group" title="'.stripslashes($row_con_g3->nazev).'"><img src="'.__URL2__.'/obr_male/'.$row_con_g3->foto.'"
				   class="fotos" ';
				   if($f%7==0){ $text .= ' style="margin-right: 0px;" ';}
				   $text .= ' alt="'.stripslashes($row_con_g3->nazev).'" title="'.stripslashes($row_con_g3->nazev).'" /></a>';
					if($f%7==0)
					{
						$text .= '<div class="clear"></div>';
					 }
					$f++;
					}
					$text .= '<div class="clear"></div>';
				$text .= '</div>';

		   
		   }
		   
		  
		  
		  
		  
		     $Sablonka = new Sablonka();		  
			 $Sablonka->PridejDoSablonky('[nadpis]',$row_str->nadpis,'html');
			 $Sablonka->PridejDoSablonky('[obsah]',$text,'html');
			echo $Sablonka->GenerujSablonku('default');
		  
		  
          // navyseni poctu zobrazeni
          MySQL_Query ("UPDATE stranky4 SET precteno=precteno+1 WHERE str='".$this->page."' AND lang='".__LANG__."'") or die(err(3));
	     }
    	 else
	     {
		       $Sablonka = new Sablonka();
			   $Sablonka->PridejDoSablonky('[kod]','Stránka s názvem '.$this->page.' se na serveru nenachází.<br />Zkuste přejít na <a href="'.__URL__.'">úvodní stránku webu</a> a odtud pokračovat dál.','html');
			   $Sablonka->PridejDoSablonky('[kod2]',admin_email(__EMAIL_1__),'html'); 
		       echo $Sablonka->GenerujSablonku('error'); 
			   exit();   
				 
	     }  
	   }	
	 }

}
?>

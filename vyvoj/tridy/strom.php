<?
// trida strom generuje menu kategorii ve trech urovnich zanoreni
// metoda PrepniStrom prepina zobrazeni stromu kategorii a vyrobcu
class Strom
{
private $p; // aktualni stranka
private $skupina; 
private $podskupina; 
private $podskupina_2; 
private $vyrobce; 
public $typ_stromu; // typ ze sesny
public $ts; // typ z getu

	function __construct($p,$skupina,$podskupina,$podskupina_2,$vyrobce)
	{
	 $this->page = sanitize($p);
	 $this->skupina = sanitize($skupina);
	 $this->podskupina = sanitize($podskupina);
	 $this->podskupina_2 = sanitize($podskupina_2);
	 $this->vyrobce = sanitize($vyrobce);

	}
	
	public function GenerujStrom()
	{ 
     if($_SESSION['typ_stromu'] == "vyrobci")
  		{
  		$this->StromFirmy();
  		}
  		else
  		{
  		$this->StromKategorie();
  		}
  
   }
  
  public function PrepniStrom($ts)
  {
    if($ts)
    {
     $this->ts = strip_tags($ts);
     $_SESSION['typ_stromu'] = $this->ts;
    }
    else
    {
     $this->ts = strip_tags($_SESSION['typ_stromu']);
    }
    
  }
  
  private function StromFirmy()
  {
    echo '<ul>';
    $query_sf = MySQL_Query("SELECT vyrobce, str FROM vyrobci ORDER BY vyrobce") or die(err(1));
		  while($row_sf = mysql_fetch_object($query_sf))
		  {
       if(urldecode($this->vyrobce)==$row_sf->vyrobce)
    	  {
         echo '<li class="aktiv">'.$row_sf->vyrobce.'</li>';	
    	  }
    	 else
    	  {
         echo '<li><a href="'.__URL__.'/vyrobce/'.$row_sf->str.'.html" title="'.stripslashes($row_sf->vyrobce).'">'.stripslashes($row_sf->vyrobce).'</a></li>';
    	  }
		  }
     echo '</ul>';	
  
  }
  
  private function StromKategorie()
  {
   $query_menu = MySQL_Query("SELECT id,str,nazev,ikona FROM kategorie WHERE aktivni3=1 AND vnor=1 ORDER BY razeni") or die(err(1));
    echo '<ul>';
    $z = 1;
      while($row_menu = MySQL_fetch_object($query_menu))
      {
			if($row_menu->str==$this->skupina)
            {
			echo '<li class="aktiv" id="tlacitko_'.$z.'" onmouseover="zobraz_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'aktiv\');" 
		    onmouseout="skryj_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'aktiv\');"><img src="/prilohy/'.$row_menu->ikona.'" alt="" style="margin-left: 10px;" /><a href="/produkty/'.$row_menu->str.'.html">';
	        echo stripslashes($row_menu->nazev);
	        echo '</a>';
	        echo '</li>';
			}
			else
			{
			echo '<li id="tlacitko_'.$z.'" onmouseover="zobraz_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'aktiv\');" 
		    onmouseout="skryj_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'\');"><img src="/prilohy/'.$row_menu->ikona.'" alt="" style="margin-left: 10px;"  /><a href="/produkty/'.$row_menu->str.'.html">';
	        echo stripslashes($row_menu->nazev);
	        echo '</a>';
	        echo '</li>';
			}
			
			// generujeme js submenu
			
			
			  $query_submenu = MySQL_Query("SELECT id,str,nazev,ikona FROM kategorie WHERE vnor=2 AND id_nadrazeneho='".$row_menu->id."' AND aktivni3=1 ORDER BY razeni,nazev") or die(err(1));
             if(mysql_num_rows($query_submenu))
              {    
			    echo '<div class="submenu_ls" id="sub_'.$z.'"  onmouseover="zobraz_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'aktiv\');" 
		    onmouseout="skryj_submenu(\'sub_'.$z.'\',\'tlacitko_'.$z.'\',\'\');">';
                while($row_submenu = MySQL_fetch_object($query_submenu))
                {
					echo '<div class="in_box_submenu" onclick="self.location.href=\'/produkty/'.$row_menu->str.'/'.$row_submenu->str.'.html\'">
					<div class="clear" style="height: 5px;"></div>
					<div style="width: auto; height: 46px; text-align: center;"><img src="/prilohy/'.$row_submenu->ikona.'" alt="" style="float: none;" /></div>
					'.stripslashes($row_submenu->nazev).'
					</div>';
				}
				
			    echo '</div>';	
			  }
			
			


        
        ///////////////////////////////////////// submenu
	
/*
        if($row_menu->str == $this->skupina)
        {
			
        $query_submenu = MySQL_Query("SELECT id,str,nazev FROM kategorie WHERE vnor=2 AND id_nadrazeneho='".$row_menu->id."' AND aktivni=1 ORDER BY razeni,nazev") or die(err(1));
        if(mysql_num_rows($query_submenu))
         { 
			 
         while($row_submenu = MySQL_fetch_object($query_submenu))
          { 
			     
            if($row_menu->str==$this->skupina && $this->podskupina==$row_submenu->str )
            {
            echo '<li class="submenu_aktiv" ><a href="'.__URL__.'/produkty/'.$row_menu->str.'/'.$row_submenu->str.'.html" 
            title="'.stripslashes($row_submenu->nazev).'">'.stripslashes($row_submenu->nazev);
            echo '</a></li>';	
            }
            else
            {
            echo '<li class="submenu" ><a href="'.__URL__.'/produkty/'.$row_menu->str.'/'.$row_submenu->str.'.html" 
            title="'.stripslashes($row_submenu->nazev).'">'.stripslashes($row_submenu->nazev);
            echo '</a></li>';	
            }

            

        $z++;
          }
          
           // zakonceni oble rohy dole
           //echo '<li class="submenu_rohy" ></li>';	
          
         }
        }*/
      /////////////////////////////////////// konec submenu
      
       $z++;
     }
     //echo '</ul>';
  
  }
  

}
?> 

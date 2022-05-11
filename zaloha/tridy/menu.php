<?
// trida menu generuje menu statickych stranek
class Menu
{
private $p; // aktualni stranka
public $menu; // pole z db

	function __construct($p,$menu)
	{
	 $this->page = sanitize($p);
	 $this->menu = $menu;
	}
	
	public function GenerujMenu()
	{
		$x = 0;
		echo "<ul>";
		foreach ($this->menu as $key => $value) 
		{
			
			list($nadpis,$url_ext) = explode('|',$value);
			
			if($key==$this->page)
			{
			 echo '<li class="aktiv" ';
			  if($x<1){echo ' style="margin-left: 0px;" ';}
			 echo '>'.$nadpis.'</li>';
			}
			else
			{
				if($url_ext)
				{
				 echo '<li><a href="'.$url_ext.'" title="'.$nadpis.'">'.$nadpis.'</a></li>';
				}
				else
				{
				 echo '<li ';
				   if($x<1){echo ' style="margin-left: 0px;" ';}
				 echo '><a href="'.__URL__.'/'.$key.'.html" title="'.$nadpis.'">'.$nadpis.'</a></li>';
				}
				
			
			}
			
			$x++;
		}
		echo "</ul>";
		
		
		return true;
	}


}
?> 

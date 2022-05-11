<?
// trida seo generuje seo parametry pro title, keywords, description a drobinku
class Seo
{
private $p; // aktualni stranka
public $stranky; // pole z db

	function __construct($stranky,$p)
	{
	 $this->page = sanitize($p);
	 $this->stranky = $stranky;

	}
	
	public function GenerujDrobinku()
	{
		
		echo '<a href="/">Domů</a>  ';
		
		if($this->page=='produkty')
		{
		//jelikoz produkt muze byt zarazen ve vice kategoriich tak nemuzeme pouzit funkci na generovani URL, ktere predavame jen ID produktu
		$url_arr = explode('/',$_SERVER['REDIRECT_URL']);
		
		
			 if($_GET['skupina'] && $_GET['podskupina'] && $_GET['podskupina_2'] && $_GET['idp'])
			 {
				$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo ' &gt; <a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a>';
				
				$query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2") or die(err(1));
				$row_k2 = mysql_fetch_object($query_k2);
				echo '  &gt; <a href="/produkty/'.$row_k->str.'/'.$row_k2->str.'.html">'.stripslashes($row_k2->nazev).'</a>';
				
				$query_k3 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3") or die(err(1));
				$row_k3 = mysql_fetch_object($query_k3);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'/'.$row_k3->str.'.html">'.stripslashes($row_k3->nazev).'</a>';
				
				$query_p = MySQL_Query("SELECT id, str, nazev FROM produkty WHERE id='".sanitize($_GET['idp'])."' ") or die(err(1));
				$row_p = mysql_fetch_object($query_p);
				echo '  &gt; '.stripslashes($row_p->nazev);
			 
			 }
			 elseif($_GET['skupina'] && $_GET['podskupina'] && $_GET['idp'])
			 {
				$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a>';
				
				$query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2") or die(err(1));
				$row_k2 = mysql_fetch_object($query_k2);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'/'.$row_k2->str.'.html">'.stripslashes($row_k2->nazev).'</a>';
				
				$query_p = MySQL_Query("SELECT id, str, nazev FROM produkty WHERE id='".sanitize($_GET['idp'])."' ") or die(err(1));
				$row_p = mysql_fetch_object($query_p);
				echo '  &gt; '.stripslashes($row_p->nazev);
			 
			 }
			 elseif($_GET['skupina'] && $_GET['idp'])
			 {
				$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a>';
				
				$query_p = MySQL_Query("SELECT id, str, nazev FROM produkty WHERE id='".sanitize($_GET['idp'])."' ") or die(err(1));
				$row_p = mysql_fetch_object($query_p);
				echo '  &gt;  '.stripslashes($row_p->nazev);
			 
			 }
			 elseif($_GET['skupina'] && $_GET['podskupina'] && $_GET['podskupina_2'])
			 {
				$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a>';
				
				$query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2") or die(err(1));
				$row_k2 = mysql_fetch_object($query_k2);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'/'.$row_k2->str.'.html">'.stripslashes($row_k2->nazev).'</a>';
				
				$query_k3 = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3") or die(err(1));
				$row_k3 = mysql_fetch_object($query_k3);
				echo '  &gt;  '.stripslashes($row_k3->nazev);
			 
			 }
			 elseif($_GET['skupina'] && $_GET['podskupina'])
			 {
				$query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo '  &gt;  <a href="/produkty/'.$row_k->str.'.html">'.stripslashes($row_k->nazev).'</a>';
				
				$query_k2 = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2") or die(err(1));
				$row_k2 = mysql_fetch_object($query_k2);
				echo '  &gt;  '.stripslashes($row_k2->nazev);
				
				
			 
			 }
			 elseif($_GET['skupina'])
			 {
				$query_k = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
				$row_k = mysql_fetch_object($query_k);
				echo '  &gt;  '.stripslashes($row_k->nazev);
			 }
			 else
			 {
			  echo ' ';
			 }
			 
		
		}
		elseif($this->page=='aktuality' && $_GET['ida'])
		{
		   $query_ak = MySQL_Query("SELECT nadpis FROM aktuality4 WHERE id='".sanitize($_GET['ida'])."' ") or die(err(1));
		   $row_ak = mysql_fetch_object($query_ak);
		   echo '  &gt;  <a href="/aktuality.html">Aktuality</a>  &gt;  '.stripslashes($row_ak->nadpis);
		}
		elseif($this->page=='poradna' && $_GET['ida'])
		{
		   $query_ak = MySQL_Query("SELECT nadpis FROM poradna WHERE id='".sanitize($_GET['ida'])."' ") or die(err(1));
		   $row_ak = mysql_fetch_object($query_ak);
		   echo '  &gt;  <a href="/poradna.html">Poradna</a>  &gt;  '.stripslashes($row_ak->nadpis);
		}
		else
		{
			foreach ($this->stranky as $key => $value) 
			{
				if($this->page==$key)
				{
				  echo ' &gt; '.stripslashes($value);
			    }

			}
	    }
		
		
		
	}
	
	public function GenerujTitle()
	{
		
		if($this->page=='produkty')
		{
			if($_GET['idp'])
			 {
			  // detail produktu
			    $menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM produkty WHERE id='".sanitize($_GET['idp'])."'");
				$row_seo = MySQL_fetch_object($menu_seo);
				
				  if($row_seo->title4)
				   {
					echo stripslashes($row_seo->title4);
				   }
				   else
				   {
				   echo stripslashes($row_seo->nazev).' | ';
				   
						$query_k = MySQL_Query("SELECT id, nazev, id_nadrazeneho FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						$row_k = mysql_fetch_object($query_k);
						echo stripslashes($row_k->nazev).' | ';
						
						if($_GET['podskupina'])
						{
							$query_k2 = MySQL_Query("SELECT id, nazev, id_nadrazeneho 
							FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id." ") or die(err(1));
							$row_k2 = mysql_fetch_object($query_k2);
							echo stripslashes($row_k2->nazev).' | ';
						}
						
						if($_GET['podskupina_2'])
						{
							$query_k3 = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3 AND id_nadrazeneho=".$row_k2->id."") or die(err(1));
							$row_k3 = mysql_fetch_object($query_k3);
							echo stripslashes($row_k3->nazev).' | ';
						}
				    
				   echo __TITLE__;
				   }
			  
			 }
			 else
			 {
			 // kategorie
			 
				 if($_GET['skupina'] && $_GET['podskupina'] && $_GET['podskupina_2'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->title4)
					   {
						echo stripslashes($row_seo->title4);
					   }
					   else
					   {
					     $query_k = MySQL_Query("SELECT id, str, nazev, id_nadrazeneho FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).' | ';
						 
						 $query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id."") or die(err(1));
						 $row_k2 = mysql_fetch_object($query_k2);
						 echo stripslashes($row_k2->nazev).' | ';
						 
						 
						 echo stripslashes($row_seo->nazev).' | ';
						 echo __TITLE__;
					   
					   }

				 
				 }
				 elseif($_GET['skupina'] && $_GET['podskupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->title4)
					   {
						echo stripslashes($row_seo->title4);
					   }
					   else
					   {
						 $query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).' | ';
						 echo stripslashes($row_seo->nazev).' | ';
						 echo __TITLE__;
					   
					   }
	
				 
				 }
				 elseif($_GET['skupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1");
					$row_seo = MySQL_fetch_object($menu_seo);
					
 					   if($row_seo->title4)
					   {
						echo stripslashes($row_seo->title4);
					   }
					   else
					   {
						echo stripslashes($row_seo->nazev).' | ';
						echo __TITLE__;
				       }
				 }
				 else
				 {
				  echo ' ';
				 }
			  
			 
			 }
		 
		}
		elseif($this->page=='aktuality' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM aktuality4 WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->title)
		   {
		    echo stripslashes($row_seo->title);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).' | aktuality | '.__TITLE__;
		   }
		 
		}
		elseif($this->page=='poradna' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM poradna WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->title)
		   {
		    echo stripslashes($row_seo->title);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).' | poradna | '.__TITLE__;
		   }
		 
		}
		else
		{
		 // ostatni staticke stranky
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM stranky4 WHERE str='".$this->page."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		
		   if($row_seo->title)
		   {
		    echo stripslashes($row_seo->title);
		   }
		   else
		   {
				foreach ($this->stranky as $key => $value) 
				{
					if($this->page==$key)
					{
					  echo stripslashes($value);
					}

				}
			
			echo ' | '.__TITLE__;
		   }
		}
		
	}
	
	
	
	
	public function GenerujKeywords()
	{
		
		if($this->page=='produkty')
		{
			if($_GET['idp'])
			 {
			  // detail produktu
			    $menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM produkty WHERE id='".sanitize($_GET['idp'])."'");
				$row_seo = MySQL_fetch_object($menu_seo);
				
				  if($row_seo->keywords4)
				   {
					echo stripslashes($row_seo->keywords4);
				   }
				   else
				   {
				   echo stripslashes($row_seo->nazev).', ';
				   
						$query_k = MySQL_Query("SELECT id, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						$row_k = mysql_fetch_object($query_k);
						echo stripslashes($row_k->nazev).', ';
						
						if($_GET['podskupina'])
						{
							$query_k2 = MySQL_Query("SELECT id, nazev, id_nadrazeneho 
							FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id." ") or die(err(1));
							$row_k2 = mysql_fetch_object($query_k2);
							echo stripslashes($row_k2->nazev).', ';
						}
						
						if($_GET['podskupina_2'])
						{
							$query_k3 = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3 AND id_nadrazeneho=".$row_k2->id."") or die(err(1));
							$row_k3 = mysql_fetch_object($query_k3);
							echo stripslashes($row_k3->nazev).', ';
						}
				    
				   echo __KEYWORDS__;
				   }
			  
			 }
			 else
			 {
			 // kategorie
			 
				 if($_GET['skupina'] && $_GET['podskupina'] && $_GET['podskupina_2'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->keywords4)
					   {
						echo stripslashes($row_seo->keywords4);
					   }
					   else
					   {
					     $query_k = MySQL_Query("SELECT id, str, nazev, id_nadrazeneho FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).', ';
						 
						 $query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id."") or die(err(1));
						 $row_k2 = mysql_fetch_object($query_k2);
						 echo stripslashes($row_k2->nazev).', ';
						 
						 
						 echo stripslashes($row_seo->nazev).', ';
						 echo __KEYWORDS__;
					   
					   }

				 
				 }
				 elseif($_GET['skupina'] && $_GET['podskupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title, keywords, description FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->keywords)
					   {
						echo stripslashes($row_seo->keywords);
					   }
					   else
					   {
						 $query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).', ';
						 echo stripslashes($row_seo->nazev).', ';
						 echo __KEYWORDS__;
					   
					   }
	
				 
				 }
				 elseif($_GET['skupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1");
					$row_seo = MySQL_fetch_object($menu_seo);
					
 					   if($row_seo->keywords4)
					   {
						echo stripslashes($row_seo->keywords4);
					   }
					   else
					   {
						echo stripslashes($row_seo->nazev).' | ';
						echo __KEYWORDS__;
				       }
				 }
				 else
				 {
				  echo ' ';
				 }
			  
			 
			 }
		 
		}
		elseif($this->page=='aktuality' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM aktuality4 WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->keywords)
		   {
		    echo stripslashes($row_seo->keywords);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).', '.__KEYWORDS__;
		   }
		 
		}
		elseif($this->page=='poradna' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM poradna WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->keywords)
		   {
		    echo stripslashes($row_seo->keywords);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).', '.__KEYWORDS__;
		   }
		 
		}
		else
		{
		 // ostatni staticke stranky
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM stranky4 WHERE str='".$this->page."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		
		   if($row_seo->keywords)
		   {
		    echo stripslashes($row_seo->keywords);
		   }
		   else
		   {
				foreach ($this->stranky as $key => $value) 
				{
					if($this->page==$key)
					{
					  echo stripslashes($value);
					}

				}
			
			echo ', '.__KEYWORDS__;
		   }
		}
		
	}
	
	
	
	
	public function GenerujDescription()
	{
		
		if($this->page=='produkty')
		{
			if($_GET['idp'])
			 {
			  // detail produktu
			    $menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM produkty WHERE id='".sanitize($_GET['idp'])."'");
				$row_seo = MySQL_fetch_object($menu_seo);
				
				  if($row_seo->description4)
				   {
					echo stripslashes($row_seo->description4);
				   }
				   else
				   {
				   echo stripslashes($row_seo->nazev).', ';
				   
						$query_k = MySQL_Query("SELECT id, nazev, id_nadrazeneho FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						$row_k = mysql_fetch_object($query_k);
						echo stripslashes($row_k->nazev).', ';
						
						if($_GET['podskupina'])
						{
							$query_k2 = MySQL_Query("SELECT id, nazev, id_nadrazeneho 
							FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id." ") or die(err(1));
							$row_k2 = mysql_fetch_object($query_k2);
							echo stripslashes($row_k2->nazev).', ';
						}
						
						if($_GET['podskupina_2'])
						{
							$query_k3 = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3 AND id_nadrazeneho=".$row_k2->id."") or die(err(1));
							$row_k3 = mysql_fetch_object($query_k3);
							echo stripslashes($row_k3->nazev).', ';
						}
				    
				   echo __DESCRIPTION__;
				   }
			  
			 }
			 else
			 {
			 // kategorie
			 
				 if($_GET['skupina'] && $_GET['podskupina'] && $_GET['podskupina_2'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['podskupina_2'])."' AND vnor=3");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->description4)
					   {
						echo stripslashes($row_seo->description4);
					   }
					   else
					   {
					     $query_k = MySQL_Query("SELECT id ,str, nazev, id_nadrazeneho FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).', ';
						 
						 $query_k2 = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2 AND id_nadrazeneho=".$row_k->id."") or die(err(1));
						 $row_k2 = mysql_fetch_object($query_k2);
						 echo stripslashes($row_k2->nazev).', ';
						 
						 
						 echo stripslashes($row_seo->nazev).', ';
						 echo __DESCRIPTION__;
					   
					   }

				 
				 }
				 elseif($_GET['skupina'] && $_GET['podskupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['podskupina'])."' AND vnor=2");
					$row_seo = MySQL_fetch_object($menu_seo);
					
					   if($row_seo->description4)
					   {
						echo stripslashes($row_seo->description4);
					   }
					   else
					   {
						 $query_k = MySQL_Query("SELECT str, nazev FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1") or die(err(1));
						 $row_k = mysql_fetch_object($query_k);
						 echo stripslashes($row_k->nazev).', ';
						 echo stripslashes($row_seo->nazev).', ';
						 echo __DESCRIPTION__;
					   
					   }
	
				 
				 }
				 elseif($_GET['skupina'])
				 {
					$menu_seo = MySQL_Query("SELECT nazev, title4, keywords4, description4 FROM kategorie WHERE str='".sanitize($_GET['skupina'])."' AND vnor=1");
					$row_seo = MySQL_fetch_object($menu_seo);
					
 					   if($row_seo->description4)
					   {
						echo stripslashes($row_seo->description4);
					   }
					   else
					   {
						echo stripslashes($row_seo->nazev).' | ';
						echo __DESCRIPTION__;
				       }
				 }
				 else
				 {
				  echo ' ';
				 }
			  
			 
			 }
		 
		}
		elseif($this->page=='aktuality' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM aktuality4 WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->description)
		   {
		    echo stripslashes($row_seo->description);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).', '.__DESCRIPTION__;
		   }
		 
		}
		elseif($this->page=='poradna' && $_GET['ida'])
		{
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM poradna WHERE id='".sanitize($_GET['ida'])."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		 
		 if($row_seo->description)
		   {
		    echo stripslashes($row_seo->description);
		   }
		   else
		   {
		   echo stripslashes($row_seo->nadpis).', '.__DESCRIPTION__;
		   }
		 
		}
		else
		{
		 // ostatni staticke stranky
		 $menu_seo = MySQL_Query("SELECT nadpis, title, keywords, description FROM stranky4 WHERE str='".$this->page."'");
		 $row_seo = MySQL_fetch_object($menu_seo);
		
		   if($row_seo->description)
		   {
		    echo stripslashes($row_seo->description);
		   }
		   else
		   {
				foreach ($this->stranky as $key => $value) 
				{
					if($this->page==$key)
					{
					  echo stripslashes($value);
					}

				}
			
			echo ', '.__TITLE__;
		   }
		}
		
	}


}
?> 

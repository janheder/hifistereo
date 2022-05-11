<?
$registrace_t = '';

		// zaktivneni registrace a prideleni nejnizsi slevy
		if($_GET['u'] && $_GET['hash'])
		{
		$result_r = mysql_query("SELECT * FROM zakaznici WHERE uz_jm='".addslashes(base64_decode($_GET['u']))."' AND heslo='".addslashes($_GET['hash'])."'") or die(err(1));
		$row_r = mysql_fetch_object($result_r);
		if(mysql_num_rows($result_r))
		  {
		   // update uctu
    		   $result_s = mysql_query("SELECT * FROM skupiny_slev ORDER BY procento ASC LIMIT 1") or die(err(1));
    		   $row_s = mysql_fetch_object($result_s); 
    		   
    		   MySQL_Query ("UPDATE zakaznici SET
    		   aktivni=1,
			   id_skupiny_slev='".$row_s->id."'
    		   WHERE id='".$row_r->id."'") or die(err(3));
    		
    		
			
			
		 $registrace_t .= '<div class="div_kos_text">
				   <b>Vaše registrace je aktivní.</b>
				   <br /><br />
				   Můžete se přihlásit <a href="/prihlaseni.html">zde</a>.<br />';
				   
				  if($row_s->procento)
		          {
				   $registrace_t .= 'Zároveň jste získali slevu '.$row_s->procento.' % na veškeré zboží, které není ve slevě.';
			      }
				  $registrace_t .= '</div>';
		 $registrace_t .= '<div class="clear" style="height: 10px;"></div>';
			
			
		   
		  }
		  else
		  {
		  $registrace_t = "Údaje nesouhlasí!";
		  }
		
		}
		else
		{
		$registrace_t = "Chybí parametry!";
		}



 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]','Dokončení registrace','html');
 $Sablonka->PridejDoSablonky('[obsah]',$registrace_t,'html');
echo $Sablonka->GenerujSablonku('default');
?>

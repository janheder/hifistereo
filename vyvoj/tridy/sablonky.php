<?
// trida sablonky nacte zadanou sablonku a v ni nahradi text uvozeny do [] promennou z pole s klicem se stejnym nazvem
// promenne zadavame v parametru - klic / hodnota
// v sablonce muzeme pouzivat PHP kod
// sablonky jsou v adresari sablonky, lze zmenit pomoci superglobalni promenne __SABLONKY_URL__
// typ = html nebo txt (u txt volame nl2br)
class Sablonka
{

public $promenne_arr; // promenne k nahrazeni
public $vygenerovany_kod;  //vygenerovany kod
private $key; // klice k pridani nebo odstraneni
private $value; // hodnoty k pridani
private $nazev_sablonky; // nazev sablonky, pokud neni nalezena, pouzije se default a je vypsana chybova hlaska
private $typ;

	function __construct()
	{
	 $this->promenne_arr = array();
	 $this->vygenerovany_kod = '';
	}

	public function PridejDoSablonky($key,$value,$typ)
	{

		if($key && $value)
		{
		  if($typ=='txt')
		   {
			  $this->promenne_arr[$key] = nl2br($value);
		   }
		   else
		   {
			  $this->promenne_arr[$key] = $value;
		   }
		}
		else
		{
		 //die('chybne predane parametry');	
		   $Sablonka = new Sablonka();
		   $Sablonka->PridejDoSablonky('[kod]','Tato stránka se na webu '.__URL__.' nenachází','html');
		   $Sablonka->PridejDoSablonky('[kod2]',admin_email(__EMAIL_1__),'html');
		   //die('sablonka s nazvem '.$nazev_sablonky.' se v adresari '.__SABLONKY_URL__.' nenachazi');   
		   echo $Sablonka->GenerujSablonku('error'); 
		   exit(); 
		}

		return true;
	}
	
	public function OdstranZeSablonky($key)
	{
		if($key)
		{
		  foreach($this->promenne_arr as $k=>$v)
		  {
			  if($k==$key)
			  {
			   unset($this->promenne_arr[$k]);
			  }
		  }
		}
		else
		{
		 die('chybne predane parametry');	
		}

		return true;
		
	}
	
	public function GenerujSablonku($nazev_sablonky)
	{
			
		 if(file_exists(__SABLONKY_URL__.$nazev_sablonky.'.php'))
		 {
		  $obsah = file_get_contents(__SABLONKY_URL__.$nazev_sablonky.'.php'); 
		  
			   if(is_array($this->promenne_arr))
			   {
				  $a = array_keys($this->promenne_arr);
				  $b = array_values($this->promenne_arr);
				  $this->vygenerovany_kod =  str_replace($a, $b, $obsah);
 
			   }
			   else
			   {
				//die('predane parametry nejsou pole');   
				$this->vygenerovany_kod = $obsah;
			   }
			  

		  
		 }
		 else
		 { 
			   $Sablonka = new Sablonka();
			   $Sablonka->PridejDoSablonky('[kod]','Šablonka s názvem '.$nazev_sablonky.' se v adresáři '.__SABLONKY_URL__.' nenachází','html');
			   $Sablonka->PridejDoSablonky('[kod2]',admin_email(__EMAIL_1__),'html');
		       //die('sablonka s nazvem '.$nazev_sablonky.' se v adresari '.__SABLONKY_URL__.' nenachazi');   
		       echo $Sablonka->GenerujSablonku('error'); 
			   exit();   
	      }
		  
	 return eval_html($this->vygenerovany_kod);	
	}


}
 
?> 

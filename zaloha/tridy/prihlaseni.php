<?
class Prihlaseni
{	
/*	function __construct()
	{
	 
	}
*/
	public function PrihlasUzivatele()
	{
	 
	   if(isset($_POST['prihlasit']) && $_POST['prihlasit']!='')
	   {
		  if($_POST['prihlaseni_uz_jm'] && $_POST['prihlaseni_heslo'])
		   {
			// kontrola uzivatele
			  $query_kontrola = MySQL_Query("SELECT * FROM zakaznici WHERE uz_jm='".sanitize($_POST['prihlaseni_uz_jm'])."' 
				AND heslo=MD5('".sanitize($_POST['prihlaseni_heslo'])."') AND aktivni=1") or die(err(1));
			  $row_kontrola  = MySQL_fetch_object($query_kontrola);
			  if(mysql_num_rows($query_kontrola))
			  {	
				if($row_kontrola->id_skupiny_slev)
				{
				$query_sleva = MySQL_Query("SELECT * FROM skupiny_slev WHERE id=".$row_kontrola->id_skupiny_slev."") or die(err(1));
				$row_sleva  = MySQL_fetch_object($query_sleva);
				$sleva = $row_sleva->procento;
				}
				else
				{
				$sleva = 0;
				}
				



			  $prihlaseni_sess = base64_encode($_POST['prihlaseni_uz_jm']."|".md5($_POST['prihlaseni_heslo'])."|".$row_kontrola->jmeno." ".$row_kontrola->prijmeni."|".
			  $row_kontrola->id."|".$row_kontrola->cenova_skupina."|".$sleva);
			  $_SESSION['prihlaseni'] = $prihlaseni_sess;
			  return ' ';
			  }
			  else
			  {
			  return 'Zadané údaje nesouhlasí! Pokud si nepamatujete své heslo, můžete si ho nechat zaslat na svou e-mailovou adresu <a href="/zapomenute-heslo.html">zde</a>';
			  }
		   }
		   else
		   {
			return 'Nebylo zadáno uživatelské jméno a heslo!';
		   }
	   }
	 }
	
}
?>

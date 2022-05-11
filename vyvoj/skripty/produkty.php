<?
// stranka produkty
if($_GET['idp'])
{
 $query_n = MySQL_Query("SELECT P.nazev FROM produkty P WHERE P.aktivni=1 AND P.id='".intval($_GET['idp'])."' ") or die(err(1));
 $row_n = MySQL_fetch_object($query_n);
 $nadpis = stripslashes($row_n->nazev);
 $obsah = detail_produtku($_GET['idp']);
 
 MySQL_Query ("UPDATE produkty SET
navstevnost = navstevnost+1
WHERE id='".intval($_GET['idp'])."'")
or die(err(3));
}
elseif($_GET['skupina'])
{
 if($_GET['podskupina_2'])
 {
  $query_n = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".addslashes($_GET['podskupina_2'])."' AND aktivni=1 AND vnor=3 ") or die(err(1));
  $row_n = MySQL_fetch_object($query_n);
  $nadpis = stripslashes($row_n->nazev);

 }
 elseif($_GET['podskupina'])
 {
  $query_n = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".addslashes($_GET['podskupina'])."' AND aktivni=1 AND vnor=2 ") or die(err(1));
  $row_n = MySQL_fetch_object($query_n);
  $nadpis = stripslashes($row_n->nazev);
 }
 else
 {
  $query_n = MySQL_Query("SELECT nazev FROM kategorie WHERE str='".addslashes($_GET['skupina'])."' AND aktivni=1 AND vnor=1 ") or die(err(1));
  $row_n = MySQL_fetch_object($query_n);
  $nadpis = stripslashes($row_n->nazev);
 }
 $obsah = kategorie_produktu();
}
else
{
 $nadpis = 'Chyba';
 $obsah = 'Chybí parametry';
}

 $Sablonka = new Sablonka();
 $Sablonka->PridejDoSablonky('[nadpis]',$nadpis,'html');
 $Sablonka->PridejDoSablonky('[obsah]',$obsah,'html');
echo $Sablonka->GenerujSablonku('produkty');
?>

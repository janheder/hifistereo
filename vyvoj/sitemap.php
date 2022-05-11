<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-type: text/xml; charset: utf-8");
require("./skripty/funkce.php");
require("./skripty/db_connect.php");
globalni_pr();
define("__URL__","http://".$_SERVER['SERVER_NAME']);
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
            
$menu_res = MySQL_Query("SELECT nadpis, str FROM stranky WHERE mapa=1 ORDER BY id");
while($row_menu = MySQL_fetch_object($menu_res))
{
// staticke stranky	
echo '<url>
  <loc>'.__URL__.'/'.$row_menu->str.'.html</loc>
  <changefreq>weekly</changefreq>
  <priority>0.80</priority>
</url>';
}


echo '<url>
  <loc>'.__URL__.'/akcni-zbozi.html</loc>
  <changefreq>weekly</changefreq>
  <priority>0.80</priority>
</url>';

echo '<url>
  <loc>'.__URL__.'/doporucujeme.html</loc>
  <changefreq>weekly</changefreq>
  <priority>0.80</priority>
</url>';

echo '<url>
  <loc>'.__URL__.'/novinky.html</loc>
  <changefreq>weekly</changefreq>
  <priority>0.80</priority>
</url>';

echo '<url>
  <loc>'.__URL__.'/nejprodavanejsi.html</loc>
  <changefreq>weekly</changefreq>
  <priority>0.80</priority>
</url>';


// produkty + kategorie
$query_skupiny = MySQL_Query("SELECT * FROM kategorie WHERE aktivni=1 AND vnor=1") or die(err(1));	
while($row_skupiny= MySQL_fetch_object($query_skupiny))
	{
	// skupiny	
  echo '<url>
   <loc>'.__URL__.'/produkty/'.$row_skupiny->str.'.html</loc>
   <changefreq>weekly</changefreq>
   <priority>0.80</priority>
  </url>';	

	
	// podskupiny
	$query_podskupiny = MySQL_Query("SELECT * FROM kategorie WHERE aktivni=1 AND vnor=2 AND id_nadrazeneho=".$row_skupiny->id."") or die(err(1));	
    while($row_podskupiny= MySQL_fetch_object($query_podskupiny))
	 {
  echo '<url>
   <loc>'.__URL__.'/produkty/'.$row_skupiny->str.'/'.$row_podskupiny->str.'.html</loc>
   <changefreq>weekly</changefreq>
   <priority>0.80</priority>
  </url>';		 	 
	 
	 
	   	// podskupiny2
		$query_podskupiny2 = MySQL_Query("SELECT * FROM kategorie WHERE aktivni=1 AND vnor=3 AND id_nadrazeneho=".$row_podskupiny->id."") or die(err(1));	
		while($row_podskupiny2= MySQL_fetch_object($query_podskupiny2))
		 {
	  echo '<url>
	   <loc>'.__URL__.'/produkty/'.$row_skupiny->str.'/'.$row_podskupiny->str.'/'.$row_podskupiny2->str.'.html</loc>
	   <changefreq>weekly</changefreq>
	   <priority>0.80</priority>
	  </url>';		 	 

	    }
		
	}
}
	
// vyrobci
$query_vyr = MySQL_Query("SELECT str FROM vyrobci") or die(err(1));	
while($row_vyr = MySQL_fetch_object($query_vyr))
	{
  echo '<url>
   <loc>'.__URL__.'/vyrobce/'.$row_vyr->str.'.html</loc>
   <changefreq>weekly</changefreq>
   <priority>0.80</priority>
  </url>';	
    }
	
	// produkty
	$query_n = MySQL_Query("SELECT P.id, P.id_kategorie
	FROM produkty P WHERE P.aktivni=1 ORDER BY id DESC") or die(err(1));
   while($row_n = MySQL_fetch_object($query_n))
   {
    $odkaz_n = url_produktu($row_n->id,$row_n->id_kategorie);
    echo '<url>
   <loc>'.__URL__.$odkaz_n.'</loc>
   <changefreq>weekly</changefreq>
   <priority>0.80</priority>
  </url>';	
   
   }

            
echo '</urlset>';            
?>

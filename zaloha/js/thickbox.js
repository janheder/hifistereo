/*
 * Thickbox 3.1 - One Box To Rule Them All.
 * By Cody Lindley (http://www.codylindley.com)
 * Copyright (c) 2007 cody lindley
 * Licensed under the MIT License: http://www.opensource.org/licenses/mit-license.php
*/

/*
var prednacist = ["/img/tl_dole_1h.png", "/img/tl_dole_2h.png","/img/tl_dole_3h.png","/img/tl_dole_4h.png","/img/tl_dole_5h.png","/img/tl_dole_6h.png","/img/nase_vyhody_box3.png","/img/tl_kat1_h.png","/img/tl_kat2_h.png","/img/tl_kat3_h.png","/img/tl_kat4_h.png","/img/tl_kat5_h.png","/img/tl_kat6_h.png"]; 
 
for(var p=0;p<prednacist.length;p++) { 
  tmp = prednacist[p]; 
  prednacist[p] = new Image(); 
  prednacist[p].src = tmp;   
}  
*/



function validate_poradna()
{
	
	if(document.getElementById('jmeno').value=='' || document.getElementById('jmeno').value=='Jméno')
	{
	  alert("Jméno musíte vyplnit");
	  document.getElementById('jmeno').focus();
	  return false;
	}
	else if(document.getElementById('email').value=='' || document.getElementById('email').value=='Email')
	{
	  alert("E-mail musíte vyplnit");
	  document.getElementById('email').focus();
	  return false;
	}
	else if(document.getElementById('predmet').value=='' || document.getElementById('predmet').value=='Předmět')
	{
	  alert("Předmět musíte vyplnit");
	  document.getElementById('predmet').focus();
	  return false;
	}
	else if(document.getElementById('dotaz').value=='' || document.getElementById('dotaz').value=='Dotaz')
	{
	  alert("Dotaz musíte vyplnit");
	  document.getElementById('dotaz').focus();
	  return false;
	}
	else if(document.getElementById('as_hlog_v').value=='' || document.getElementById('as_hlog_v').value=='vepište číslici')
	{
	  alert("Antispam musíte vyplnit");
	  document.getElementById('as_hlog_v').focus();
	  return false;
	}
	 else
	  return true;

}

function zobraz_vyhl()
{

	document.getElementById('vyhl_okno').style.display = 'block';
	document.getElementById('top_vyhl').className = 'top_pruh2_vyhl_h';
}

function skryj_vyhl()
{
	for (i = 1; i <= 100000; i++)
	  {
	  var y = 100000-i;
	  }
	  
	  document.getElementById('vyhl_okno').style.display = 'none';
	  document.getElementById('top_vyhl').className = 'top_pruh2_vyhl';
	
}

function zobraz_prihlas()
{

	document.getElementById('prihlas_okno').style.display = 'block';
	document.getElementById('top_prihlas').className = 'top_pruh2_prihlas_h';
}

function skryj_prihlas()
{
	for (i = 1; i <= 100000; i++)
	  {
	  var y = 100000-i;
	  }
	  
	  document.getElementById('prihlas_okno').style.display = 'none';
	  document.getElementById('top_prihlas').className = 'top_pruh2_prihlas';
	
}


function zobraz_submenu(d,t,c)
{
	//var pozicex=document.getElementById(t).offsetLeft;
	//var pozicey=document.getElementById(t).offsetTop;
	
	//var pozice_holder=document.getElementById('menu_kat').offsetLeft;
	
	//alert(pozice_holder);
	
	var x = 0;
	var y = 50;

    if(document.getElementById(d)!=null)
    {
	document.getElementById(d).style.display = 'block';
	}
	document.getElementById(t).className = c;
}


function skryj_submenu(d,t,c)
{
	for (i = 1; i <= 100000; i++)
	  {
	  var y = 100000-i;
	  }
	  
	  if(document.getElementById(d)!=null)
	  {
	  document.getElementById(d).style.display = 'none';
      }
	  document.getElementById(t).className = c;
}

function zobraz_nahled(id)
{

	document.getElementById(id).style.display = 'block';
	
}

function skryj_nahled(id)
{

	document.getElementById(id).style.display = 'none';
	
}


function disabluj_platbu(jsArray)
{
	var radios = document.getElementsByName("div_platba");
	for (var i=0, iLen=radios.length; i<iLen; i++) 
	{
	  radios[i].style.display = 'none';
	} 

	
 var index2;
 for (index2 = 0; index2 < jsArray.length; ++index2) 
 {

    document.getElementById("div_"+jsArray[index2]).style.display = 'table-row';
 }
	

}


function navigateToUrl(url) 
{
    
    
    var a = document.createElement("a");
    if(!a.click) //for IE
    {
         window.location = url;
         return;
    }
    a.setAttribute("href", url);
    a.style.display = "none";
    document.body.appendChild(a);
    a.click();
}


function redirect(r)
{
    window.location = r;
}
 
  
function presmeruj_ppl(url)
{
	
	if(url)
	{
		window.location.href=url;
	}
}


function skryj_ppl(d,idz)
{
	if(document.body.contains(document.getElementById(d)))
	 {
		 document.getElementById(d).style.display = 'none';
	 }
	

}

function skryj_gls(d,idz)
{
	 if(document.body.contains(document.getElementById(d)))
	 {
	  document.getElementById(d).style.display = 'none';
	  //alert('GLS');
     }
	

}


function prepocitej_js_cenu2(a,arr_id)
{
	// a = cena zbozi Kč
	 var cena_platba = 0;
	 var cena_doprava = 0;

	
	var radios = document.getElementsByName("platba");
	for (var i=0, iLen=radios.length; i<iLen; i++) 
	{
	  if(radios[i].checked == true)
	  {
		 var cena_platba_list = radios[i].value;
		 var cena_platbax = cena_platba_list.split("|"); 
		 var cena_platba = cena_platbax[1];
	  }
	}
	

	
	var radios2 = document.getElementsByName("doprava");
	for (var i=0, iLen=radios2.length; i<iLen; i++) 
	{
	  if(radios2[i].checked == true)
	  {
		 var cena_doprava_list = radios2[i].value;
		 var cena_dopravax = cena_doprava_list.split("|"); 
		 var cena_doprava = cena_dopravax[1];
		 var id_doprava = cena_dopravax[0];
	  }
	}
	
	
	// uprava pro zobrazeni selectboxu pri vyberu DPD ParcelShop
	/*if(id_doprava == 4)
	{
		
		document.getElementById('dpd_sel_div').style.display = 'block';
	}
	else
	{   
		document.getElementById('dpd_sel_div').style.display = 'none';
	}*/
	

    //var cena_zbozi = document.getElementById("js_cena").innerHTML;
    
     var index2;
	 var cena_celkem = 0;
	 for (index2 = 0; index2 < arr_id.length; ++index2) 
	 {
	    cena = document.getElementById("cena_row_"+arr_id[index2]).innerHTML;
	    cena_celkem = cena_celkem + parseInt(cena);
	    
	 }
    
	var soucet_cz = (parseInt(cena_celkem) + parseInt(cena_platba) + parseInt(cena_doprava));

	
	document.getElementById('js_cena').innerHTML = soucet_cz;
}  




// AJAX


function processRequest(s)
{
  if (httpRequest.readyState == 4)
  {
    if(httpRequest.status == 200)
    {
      var sel = document.getElementById(s);
      sel.innerHTML = httpRequest.responseText;
    }
    else
    {
        alert("Chyba pri nacitani stranky"+ httpRequest.status +":"+ httpRequest.statusText);
    }
  }
}

function zmen_pocet_v_kosiku(idp,pocet)
{

     
     if (idp != 0)
     {
        if (window.ActiveXObject)
        {
          httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
        }
        else
        {
          httpRequest = new XMLHttpRequest();
        }
	    httpRequest.open("GET", "/skripty/ajax_zmena_poctu.php?idp="+idp+"&pocet="+pocet);
        httpRequest.onreadystatechange= function () {processRequest("idp_div"); };
        httpRequest.send(null);

      }
      else
      {

        document.getElementById("idp_div").innerHTML = "";
        
      }
}

function pridej(idp,cena_ks,arr_id)
{
	var pocet = document.getElementById('pocet_ks_'+idp).value;
	var pocet_novy = (parseInt(pocet)+1);
	document.getElementById('pocet_ks_'+idp).value = pocet_novy;
	document.getElementById('cena_row_'+idp).innerHTML = (pocet_novy * cena_ks);
	

	
	 var index2;
	 var cena_celkem = 0;
	 for (index2 = 0; index2 < arr_id.length; ++index2) 
	 {
	    cena = document.getElementById("cena_row_"+arr_id[index2]).innerHTML;
	    cena_celkem = cena_celkem + parseInt(cena);
	    
	 }
	 
	 document.getElementById('js_cena').innerHTML = cena_celkem;
	 
	 // zde musime zmenit pocet v sesne kosik
	 
	 zmen_pocet_v_kosiku(idp,pocet_novy);
		

}

function pridej2(idp)
{
	var pocet = document.getElementById(idp).value;
	var pocet_novy = (parseInt(pocet)+1);
	document.getElementById(idp).value = pocet_novy;

		

}

function uber(idp,cena_ks,arr_id)
{
	var pocet = document.getElementById('pocet_ks_'+idp).value;
	var novy_pocet = (parseInt(pocet)-1);
	if(novy_pocet<1)
	{
		novy_pocet = 1;
	}
	document.getElementById('pocet_ks_'+idp).value = novy_pocet;
	document.getElementById('cena_row_'+idp).innerHTML = (novy_pocet * cena_ks);
	
	 var index2;
	 var cena_celkem = 0;
	 for (index2 = 0; index2 < arr_id.length; ++index2) 
	 {
	    cena = document.getElementById("cena_row_"+arr_id[index2]).innerHTML;
	    cena_celkem = cena_celkem + parseInt(cena);
	    
	 }
	 
	 document.getElementById('js_cena').innerHTML = cena_celkem;
	 
	 // zde musime zmenit pocet v sesne kosik
	 
	 zmen_pocet_v_kosiku(idp,novy_pocet);

}

function uber2(idp)
{
	var pocet = document.getElementById(idp).value;
	var novy_pocet = (parseInt(pocet)-1);
	if(novy_pocet<1)
	{
		novy_pocet = 1;
	}
	document.getElementById(idp).value = novy_pocet;
	

}


function uvodka_akce()
{
	
document.getElementById('ba').className='box_a_h';
document.getElementById('bd').className='box_a';
document.getElementById('bn').className='box_a';


document.getElementById('u_akce').style.display='block';
document.getElementById('u_novinky').style.display='none';
document.getElementById('u_doporucujeme').style.display='none';

}

function uvodka_novinky()
{
	
document.getElementById('ba').className='box_a';
document.getElementById('bd').className='box_a';
document.getElementById('bn').className='box_a_h';

document.getElementById('u_akce').style.display='none';
document.getElementById('u_novinky').style.display='block';
document.getElementById('u_doporucujeme').style.display='none';

}

function uvodka_doporucujeme()
{
	
document.getElementById('ba').className='box_a';
document.getElementById('bd').className='box_a_h';
document.getElementById('bn').className='box_a';

document.getElementById('u_akce').style.display='none';
document.getElementById('u_novinky').style.display='none';
document.getElementById('u_doporucujeme').style.display='block';

}



function validate_kosik1()
{
   
   var doprava_delka = document.forms["pokladna_1"]["doprava"].length;
   var doprava = false;

    for (i = 0; i < doprava_delka; ++ i)
    {
        if (document.forms["pokladna_1"]["doprava"][i].checked)
        {
			 doprava = true;
		}
    }
    
   var platba_delka = document.forms["pokladna_1"]["platba"].length;
   var platba = false;

    for (i = 0; i < platba_delka; ++ i)
    {
        if (document.forms["pokladna_1"]["platba"][i].checked)
        {
			 platba = true;
		}
    }
    
    

   

   if(doprava==false)
	{
	  alert("Nevybrali jste způsob dopravy");
	  return false;
	}
	else if(document.getElementById('d_4').checked == true && document.getElementById('gls_id').value=='')
	{
	  alert("Nevybrali jste pobočku GLS ParcelShop");
	  return false;
	}
	else if(platba==false)
	{
	  alert("Nevybrali jste způsob platby");
	  return false;
	}
	
	

	 
	 else
	  return true;

}



function detail_popis()
{
document.getElementById('det_tlacitko_1').className='box_a2_h';
document.getElementById('det_tlacitko_2').className='box_a2';
document.getElementById('det_tlacitko_3').className='box_a2';


document.getElementById('d_popis').style.display='block';
document.getElementById('d_parametry').style.display='none';
document.getElementById('d_diskuze').style.display='none';

}


function detail_parametry()
{
	
document.getElementById('det_tlacitko_1').className='box_a2';
document.getElementById('det_tlacitko_2').className='box_a2_h';
document.getElementById('det_tlacitko_3').className='box_a2';



document.getElementById('d_popis').style.display='none';
document.getElementById('d_parametry').style.display='block';
document.getElementById('d_diskuze').style.display='none';

}


function detail_prilohy()
{
document.getElementById('det_tlacitko_1').className='box_a2';
document.getElementById('det_tlacitko_2').className='box_a2';
document.getElementById('det_tlacitko_3').className='box_a2_h';


document.getElementById('d_popis').style.display='none';
document.getElementById('d_parametry').style.display='none';
document.getElementById('d_diskuze').style.display='block';

}





function hover(hobr)
  {
    document.menu.src="/img/"+hobr;
  }
  
  
function presmeruj_pocet()
{
var d = document.getElementById("pocet_strankovani").value;	
self.location.href='/skripty/prepni-pocet.php?pocet_strankovani='+d;
}

function zobraz_vyrobce()
{
	if(document.getElementById('box_vyrobci').style.display=='block')
	{
	document.getElementById('box_vyrobci').style.display = 'none';
	}
	else
	{
	document.getElementById('box_vyrobci').style.display = 'block';
	}
}  


function prepni_produkty(id_box,id_tl)
{
 document.getElementById('tl_akce').className = "tl_n";
 document.getElementById('tl_novinky').className = "tl_n";
 document.getElementById('tl_doporucujeme').className = "tl_n";
 
 document.getElementById(id_tl).className = "tl_ak";
 
 document.getElementById('akce_box').style.display = 'none';
 document.getElementById('nove_box').style.display = 'none';
 document.getElementById('doporucujeme_box').style.display = 'none';
 document.getElementById(id_box).style.display = 'block';
	
}




function zobraz_kosik()
{
  
	document.getElementById('subkosik').style.display = 'block';

}

function skryjkosik()
{
	for (i = 1; i <= 100000; i++)
	  {
	  var y = 100000-i;
	  }
	  
	  
	  document.getElementById('subkosik').style.display = 'none';

}

function zobraz_submenu2(d,id_tl,cla)
{
  
	document.getElementById(d).style.display = 'block';
	document.getElementById(id_tl).className = cla;

}


function skryj_submenu2(d,id_tl,cla)
{
	for (i = 1; i <= 100000; i++)
	  {
	  var y = 100000-i;
	  }
	  
	  document.getElementById('sub_1').style.display = 'none';
	  document.getElementById('sub_2').style.display = 'none';
	  document.getElementById('sub_3').style.display = 'none';
	  document.getElementById('sub_4').style.display = 'none';
	  document.getElementById('sub_5').style.display = 'none';
	  document.getElementById('sub_6').style.display = 'none';
	  //document.getElementById(d).style.display = 'none';
	  document.getElementById(id_tl).className = cla;

}


function zobraz_popis_kat()
{
    if(document.getElementById('text_kategorie').style.display == 'block')
    {
		document.getElementById('text_kategorie').style.display = 'none';
	}
	else
	{
		document.getElementById('text_kategorie').style.display = 'block';
	}
    	
}


function zobraz_popis(id)
{
 
    document.getElementById(id).style.display = 'block';	
}

function skryj_popis(id)
{
 
    document.getElementById(id).style.display = 'none';	
}
 
  
function prepocitej_js_cenu(a,b)
{
	// a = cena zbozi Kč
	// b = cena doprava Kč

	
	var soucet_cz = (parseInt(a) + parseInt(b));

	
	
	document.getElementById('js_cena').innerHTML = soucet_cz+' Kč';
}  





function zobraz_cenu(sleva)
{
var e = document.getElementById("sel_box_varianta");
var cena = e.options[e.selectedIndex].text;
var pc_id = document.getElementById("sel_box_varianta").value; //e.options[e.selectedIndex].value;

var cena2 = cena.split(" | ");


if(sleva > 0)
{
	// vypocitame slevu
	//alert(parseInt(cena2[1]));
	

	
  //var sleva_vypocet = Math.round(parseInt(cena2[1]) + ((parseInt(cena2[1]) / 100 * parseInt(sleva)) * 1.21));
  var puvodni_cena = document.getElementById("puvodni_cena_input_"+pc_id).value;
  
  
  document.getElementById('detail_produktu_cena').innerHTML = '<div class="clear" style="height: 10px;"></div>' + cena2[1] + '<br /><span class="cena_preskrtnuta">' + puvodni_cena + ' Kč</span>';
}
else
{
  document.getElementById('detail_produktu_cena').innerHTML = cena2[1];
}


}


function kontrola2()
{
var zatrzeno = false;
for(var i = 0; i < document.pokladna_1.doprava.length; i++)
{
  if(document.pokladna_1.doprava[i].checked) 
  zatrzeno = true;
}

if(zatrzeno!=true)
{
 window.alert("Nevybrali jste způsob dopravy");
return false;
}
else 
	{
	return true;

	}
}  
		  
		  
var jeVidet = false;
var jeVidet2 = false;

function prn(d)
{
document.getElementById(d).style.display = (jeVidet ? 'none' : 'block');
  jeVidet = (jeVidet ? false : true);
}

function prn2(d)
{
document.getElementById(d).style.display = (jeVidet2 ? 'none' : 'block');
  jeVidet2 = (jeVidet2 ? false : true);
}

function validate_reg()
{
if(document.getElementById('jmeno').value == "")
	{
         alert('Nevyplnili jste jméno');
         document.getElementById('jmeno').focus();
         return false;
        }
else if(document.getElementById('prijmeni').value == "")
	{
         alert('Nevyplnili jste příjmení');
         document.getElementById('prijmeni').focus();
         return false;
        }
else if(document.getElementById('uz_jm').value == "")
	{
         alert('Nevyplnili jste uživatelské jméno');
         document.getElementById('uz_jm').focus();
         return false;
        }
else if(document.getElementById('heslo').value == "")
	{
         alert('Nevyplnili jste uživatelské jméno');
         document.getElementById('heslo').focus();
         return false;
        }
else if(document.getElementById('heslo').value != document.getElementById('heslo2').value)
	{
         alert('Heslo a kontrola hesla se neshodují');
         document.getElementById('heslo').focus();
         return false;
        }
else if(document.getElementById('ulice').value == "")
	{
         alert('Nevyplnili jste ulici');
         document.getElementById('ulice').focus();
         return false;
        }
else if(document.getElementById('cislo').value == "")
	{
         alert('Nevyplnili jste číslo popisné');
         document.getElementById('cislo').focus();
         return false;
        }
else if(document.getElementById('obec').value == "")
	{
         alert('Nevyplnili jste obec');
         document.getElementById('obec').focus();
         return false;
        }
else if(document.getElementById('psc').value == "")
	{
         alert('Nevyplnili jste PSČ');
         document.getElementById('psc').focus();
         return false;
        }
else if(document.getElementById('eml').value == "")
	{
         alert('Nevyplnili jste emailovou adresu');
         document.getElementById('eml').focus();
         return false;
        } 
else if(document.getElementById('telefon').value == "")
	{
         alert('Nevyplnili jste telefon');
         document.getElementById('telefon').focus();
         return false;
        }
else if (window.RegExp)

    {

        re = new RegExp("^[^@]+@[^.]+\..+$");

        if (!re.test(document.getElementById('eml').value))

        {

            alert("Zadaná adresa není správnou adresou elektronické pošty!");
            document.getElementById('eml').focus();
            return false;

        }

    }
else 
{
return true;
}
}
	
		  
var tb_pathToImage = "/img/loadingAnimation.gif";


//on page load call tb_init
$(document).ready(function(){   
	tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
	imgLoader = new Image();// preload image
	imgLoader.src = tb_pathToImage;
});

//add thickbox to href & area elements that have a class of .thickbox
function tb_init(domChunk){
	$(domChunk).click(function(){
	var t = this.title || this.name || null;
	var a = this.href || this.alt;
	var g = this.rel || false;
	tb_show(t,a,g);
	this.blur();
	return false;
	});
}

function tb_show(caption, url, imageGroup) {//function called when the user clicks on a thickbox link

	try {
		if (typeof document.body.style.maxHeight === "undefined") {//if IE 6
			$("body","html").css({height: "100%", width: "100%"});
			$("html").css("overflow","hidden");
			if (document.getElementById("TB_HideSelect") === null) {//iframe to hide select elements in ie6
				$("body").append("<iframe id='TB_HideSelect'></iframe><div id='TB_overlay'></div><div id='TB_window'></div>");
				$("#TB_overlay").click(tb_remove);
			}
		}else{//all others
			if(document.getElementById("TB_overlay") === null){
				$("body").append("<div id='TB_overlay'></div><div id='TB_window'></div>");
				$("#TB_overlay").click(tb_remove);
			}
		}
		
		if(tb_detectMacXFF()){
			$("#TB_overlay").addClass("TB_overlayMacFFBGHack");//use png overlay so hide flash
		}else{
			$("#TB_overlay").addClass("TB_overlayBG");//use background and opacity
		}
		
		if(caption===null){caption="";}
		$("body").append("<div id='TB_load'><img src='"+imgLoader.src+"' /></div>");//add loader to the page
		$('#TB_load').show();//show loader
		
		var baseURL;
	   if(url.indexOf("?")!==-1){ //ff there is a query string involved
			baseURL = url.substr(0, url.indexOf("?"));
	   }else{ 
	   		baseURL = url;
	   }
	   
	   var urlString = /\.jpg$|\.jpeg$|\.png$|\.gif$|\.bmp$/;
	   var urlType = baseURL.toLowerCase().match(urlString);

		if(urlType == '.jpg' || urlType == '.jpeg' || urlType == '.png' || urlType == '.gif' || urlType == '.bmp'){//code to show images
				
			TB_PrevCaption = "";
			TB_PrevURL = "";
			TB_PrevHTML = "";
			TB_NextCaption = "";
			TB_NextURL = "";
			TB_NextHTML = "";
			TB_imageCount = "";
			TB_FoundURL = false;
			if(imageGroup){
				TB_TempArray = $("a[@rel="+imageGroup+"]").get();
				for (TB_Counter = 0; ((TB_Counter < TB_TempArray.length) && (TB_NextHTML === "")); TB_Counter++) {
					var urlTypeTemp = TB_TempArray[TB_Counter].href.toLowerCase().match(urlString);
						if (!(TB_TempArray[TB_Counter].href == url)) {						
							if (TB_FoundURL) {
								TB_NextCaption = TB_TempArray[TB_Counter].title;
								TB_NextURL = TB_TempArray[TB_Counter].href;
								TB_NextHTML = "<span id='TB_next'>&nbsp;&nbsp;<a href='#'>Next &gt;</a></span>";
							} else {
								TB_PrevCaption = TB_TempArray[TB_Counter].title;
								TB_PrevURL = TB_TempArray[TB_Counter].href;
								TB_PrevHTML = "<span id='TB_prev'>&nbsp;&nbsp;<a href='#'>&lt; Prev</a></span>";
							}
						} else {
							TB_FoundURL = true;
							TB_imageCount = "Image " + (TB_Counter + 1) +" of "+ (TB_TempArray.length);											
						}
				}
			}

			imgPreloader = new Image();
			imgPreloader.onload = function(){		
			imgPreloader.onload = null;
				
			// Resizing large images - orginal by Christian Montoya edited by me.
			var pagesize = tb_getPageSize();
			var x = pagesize[0] - 150;
			var y = pagesize[1] - 150;
			var imageWidth = imgPreloader.width;
			var imageHeight = imgPreloader.height;
			if (imageWidth > x) {
				imageHeight = imageHeight * (x / imageWidth); 
				imageWidth = x; 
				if (imageHeight > y) { 
					imageWidth = imageWidth * (y / imageHeight); 
					imageHeight = y; 
				}
			} else if (imageHeight > y) { 
				imageWidth = imageWidth * (y / imageHeight); 
				imageHeight = y; 
				if (imageWidth > x) { 
					imageHeight = imageHeight * (x / imageWidth); 
					imageWidth = x;
				}
			}
			// End Resizing
			
			TB_WIDTH = imageWidth + 30;
			TB_HEIGHT = imageHeight + 60;
			$("#TB_window").append("<a href='' id='TB_ImageOff' title='Zavřít'><img id='TB_Image' src='"+url+"' width='"+imageWidth+"' height='"+imageHeight+"' alt='"+caption+"'/></a>" + "<div id='TB_caption'>"+caption+"<div id='TB_secondLine'>" + TB_imageCount + TB_PrevHTML + TB_NextHTML + "</div></div><div id='TB_closeWindow'><a href='#' id='TB_closeWindowButton' title='Zavřít'><img src='/img/zavrit.png' style='border:0;'/></a></div>"); 		
			
			$("#TB_closeWindowButton").click(tb_remove);
			
			if (!(TB_PrevHTML === "")) {
				function goPrev(){
					if($(document).unbind("click",goPrev)){$(document).unbind("click",goPrev);}
					$("#TB_window").remove();
					$("body").append("<div id='TB_window'></div>");
					tb_show(TB_PrevCaption, TB_PrevURL, imageGroup);
					return false;	
				}
				$("#TB_prev").click(goPrev);
			}
			
			if (!(TB_NextHTML === "")) {		
				function goNext(){
					$("#TB_window").remove();
					$("body").append("<div id='TB_window'></div>");
					tb_show(TB_NextCaption, TB_NextURL, imageGroup);				
					return false;	
				}
				$("#TB_next").click(goNext);
				
			}

			document.onkeydown = function(e){ 	
				if (e == null) { // ie
					keycode = event.keyCode;
				} else { // mozilla
					keycode = e.which;
				}
				if(keycode == 27){ // close
					tb_remove();
				} else if(keycode == 190){ // display previous image
					if(!(TB_NextHTML == "")){
						document.onkeydown = "";
						goNext();
					}
				} else if(keycode == 188){ // display next image
					if(!(TB_PrevHTML == "")){
						document.onkeydown = "";
						goPrev();
					}
				}	
			};
			
			tb_position();
			$("#TB_load").remove();
			$("#TB_ImageOff").click(tb_remove);
			$("#TB_window").css({display:"block"}); //for safari using css instead of show
			};
			
			imgPreloader.src = url;
		}else{//code to show html
			
			var queryString = url.replace(/^[^\?]+\??/,'');
			var params = tb_parseQuery( queryString );

			TB_WIDTH = (params['width']*1) + 30 || 630; //defaults to 630 if no paramaters were added to URL
			TB_HEIGHT = (params['height']*1) + 40 || 440; //defaults to 440 if no paramaters were added to URL
			ajaxContentW = TB_WIDTH - 30;
			ajaxContentH = TB_HEIGHT - 45;
			
			if(url.indexOf('TB_iframe') != -1){// either iframe or ajax window		
					urlNoQuery = url.split('TB_');
					$("#TB_iframeContent").remove();
					if(params['modal'] != "true"){//iframe no modal
						$("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>"+caption+"</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton' title='Zavřít'><img src='/img/zavrit.png' style='border:0;'/></a></div></div><iframe frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent"+Math.round(Math.random()*1000)+"' onload='tb_showIframe()' style='width:"+(ajaxContentW + 29)+"px;height:"+(ajaxContentH + 17)+"px;' > </iframe>");
					}else{//iframe modal
					$("#TB_overlay").unbind();
						$("#TB_window").append("<iframe frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent"+Math.round(Math.random()*1000)+"' onload='tb_showIframe()' style='width:"+(ajaxContentW + 29)+"px;height:"+(ajaxContentH + 17)+"px;'> </iframe>");
					}
			}else{// not an iframe, ajax
					if($("#TB_window").css("display") != "block"){
						if(params['modal'] != "true"){//ajax no modal
						$("#TB_window").append("<div id='TB_title'><div id='TB_ajaxWindowTitle'>"+caption+"</div><div id='TB_closeAjaxWindow'><a href='#' id='TB_closeWindowButton'><img src='/img/zavrit.png' style='border:0;'/></a></div></div><div id='TB_ajaxContent' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px'></div>");
						}else{//ajax modal
						$("#TB_overlay").unbind();
						$("#TB_window").append("<div id='TB_ajaxContent' class='TB_modal' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px;'></div>");	
						}
					}else{//this means the window is already up, we are just loading new content via ajax
						$("#TB_ajaxContent")[0].style.width = ajaxContentW +"px";
						$("#TB_ajaxContent")[0].style.height = ajaxContentH +"px";
						$("#TB_ajaxContent")[0].scrollTop = 0;
						$("#TB_ajaxWindowTitle").html(caption);
					}
			}
					
			$("#TB_closeWindowButton").click(tb_remove);
			
				if(url.indexOf('TB_inline') != -1){	
					$("#TB_ajaxContent").append($('#' + params['inlineId']).children());
					$("#TB_window").unload(function () {
						$('#' + params['inlineId']).append( $("#TB_ajaxContent").children() ); // move elements back when you're finished
					});
					tb_position();
					$("#TB_load").remove();
					$("#TB_window").css({display:"block"}); 
				}else if(url.indexOf('TB_iframe') != -1){
					tb_position();
					if($.browser.safari){//safari needs help because it will not fire iframe onload
						$("#TB_load").remove();
						$("#TB_window").css({display:"block"});
					}
				}else{
					$("#TB_ajaxContent").load(url += "&random=" + (new Date().getTime()),function(){//to do a post change this load method
						tb_position();
						$("#TB_load").remove();
						tb_init("#TB_ajaxContent a.thickbox");
						$("#TB_window").css({display:"block"});
					});
				}
			
		}

		if(!params['modal']){
			document.onkeyup = function(e){ 	
				if (e == null) { // ie
					keycode = event.keyCode;
				} else { // mozilla
					keycode = e.which;
				}
				if(keycode == 27){ // close
					tb_remove();
				}	
			};
		}
		
	} catch(e) {
		//nothing here
	}
}

//helper functions below
function tb_showIframe(){
	$("#TB_load").remove();
	$("#TB_window").css({display:"block"});
}

function tb_remove() {
 	$("#TB_imageOff").unbind("click");
	$("#TB_closeWindowButton").unbind("click");
	$("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').trigger("unload").unbind().remove();});
	$("#TB_load").remove();
	if (typeof document.body.style.maxHeight == "undefined") {//if IE 6
		$("body","html").css({height: "auto", width: "auto"});
		$("html").css("overflow","");
	}
	document.onkeydown = "";
	document.onkeyup = "";
	return false;
}

function tb_position() {
$("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
	if ( !(jQuery.browser.msie && jQuery.browser.version < 7)) { // take away IE6
		$("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
	}
}

function tb_parseQuery ( query ) {
   var Params = {};
   if ( ! query ) {return Params;}// return empty object
   var Pairs = query.split(/[;&]/);
   for ( var i = 0; i < Pairs.length; i++ ) {
      var KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) {continue;}
      var key = unescape( KeyVal[0] );
      var val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      Params[key] = val;
   }
   return Params;
}

function tb_getPageSize(){
	var de = document.documentElement;
	var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
	arrayPageSize = [w,h];
	return arrayPageSize;
}

function tb_detectMacXFF() {
  var userAgent = navigator.userAgent.toLowerCase();
  if (userAgent.indexOf('mac') != -1 && userAgent.indexOf('firefox')!=-1) {
    return true;
  }
}



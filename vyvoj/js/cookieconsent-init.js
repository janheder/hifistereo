// https://github.com/orestbida/cookieconsent

window.addEventListener('load', function () {

    var cookieconsent = initCookieConsent();
    cookieconsent.run({
        current_lang : 'cs',
        page_scripts: true,
        
        autorun : true,                             
        delay : 0,
        autoclear_cookies : true,
        force_consent: true,
        gui_options: {
          consent_modal : {
              layout : 'cloud',               // box/cloud/bar 
              position : 'middle center',     // bottom/top + left/right/center
              transition: 'slide'             // zoom/slide
          },
          settings_modal : {
              layout : 'box',                 // box/bar
              transition: 'slide',            // zoom/slide
            }
        },
        
        onAccept: function(cookies){                
        if(cookieconsent.allowedCategory('necessary')){
            var dataLayer = window.dataLayer || [];
            dataLayer.push({
            event:"CookieConsent",
            consentType:"necessary"
          });
        }
        
        
        if(cookieconsent.allowedCategory('tracking')){
            var dataLayer = window.dataLayer || [];
            dataLayer.push({
            event:"CookieConsent",
            consentType:"tracking"
          });
        }
        
        if(cookieconsent.allowedCategory('performance')){
            var dataLayer = window.dataLayer || [];
            dataLayer.push({
            event:"CookieConsent",
            consentType:"performance"
          });
        }
        
        
    },
  
        languages : {
               'cs' : {
                consent_modal : {
                    title :  "Informace o cookies",
                    description : 'Používáme cookies, abychom Vám umožnili pohodlné prohlížení webu a díky analýze provozu webu neustále zlepšovali jeho funkce, výkon a použitelnost. <a target="_blank" href="/cookies.html">Více informací</a>',
                    
                    secondary_btn: {
                        text : 'Nastavení',
                        role : 'settings'   //'settings' or 'accept_necessary'
                    },
                    primary_btn: {
                        text: 'Souhlasím',
                        role: 'accept_all'  //'accept_selected' or 'accept_all'
                    }
                },
                settings_modal : {
                    title : 'Nastavení­ cookies',
                    save_settings_btn : "Potvrdit volby",
                    accept_all_btn : "Povolit vše",
                    close_btn_label: "Zavřít",  
                    cookie_table_headers : [
                        {col1: "Cookie" }, 
                        {col2: "Popis" }, 
                        {col3: "Trvání­" }, 
                    ],
                    blocks : [
                        {
                            title : "Používáme cookies",
                            description: 'Používáme cookies, abychom Vám umožnili pohodlné prohlížení webu a díky analýze provozu webu neustále zlepšovali jeho funkce, výkon a použitelnost',
                        },{
                            title : "Nezbytné Cookies",
                            description: 'Tyto cookies jsou potřeba, aby web fungoval správně.',
                            toggle : {
                                value : 'necessary',
                                enabled : true,
                                readonly: true
                            },
                            cookie_table: [
                                {
                                    col1: 'cc_cookie',
                                    col2: 'Vaše nastavení cookies z tohoto dialogu',
                                    col3: '',
                                },
                                {
                                    col1: 'PHPSESSID',
                                    col2: 'Cookie generovaný aplikacemi založenými na jazyce PHP a jde o identifikátor používaný k udržování proměnných relací uživatelů. Slouží například k udržování přihlášeného stavu uživatele mezi stránkami.',
                      
                                    col3: 'Do ukončení relace',
                                },
                                {
                                    col1: 'lang',
                                    col2: 'Detekce jazykové verze webu',
                                    col3: '',
                                }
                            ]
                        },{
                            title : "Analytické cookies",
                            description: 'Pomáhají nám pochopit, jak web používáte. S jejich pomocí ho můžeme zlepšovat.',
                            toggle : {
                                value : 'performance',
                                enabled : false,
                                readonly: false
                            },
                            cookie_table: [
                            {
                                col1: '_ga/_ga*, _gid',
                                col2: 'Google Analytics - ukládá a počítá počet zobrazení­ stránek a chování webu.',
                                col3: '1 den až 2 roky',
                            },
                            {
                                col1: '_gcl_au',
                                col2: 'Google Tag Manager - propojení konverzí',
                                col3: '3 měsíce',
                            },
                            {
                                col1: '__utma, __utmb, __utmc, __utmt, __utmz',
                                col2: 'Google Analytics - ukládá a počítá počet zobrazení­ stránek a chování­ webu.',
                                col3: '1 den až 2 roky'
                            },
                        ]
                        },{
                            title : "Marketingové cookies",
                            description: 'Díky těmto cookies vám můžeme zobrazovat relevantní obsah a reklamy, které pro vás mohou být zajímavé a užitečné.',
                            toggle : {
                                value : 'tracking',
                                enabled : false,
                                readonly: false
                            },
                          cookie_table: [
                            {
                                col1: 'sid',
                                col2: 'Sklik - slouží k uložení jedinečného ID, které identifikuje zařízení návštěvníka.',
                                col3: '1 měsíc',
                            },
                            {
                                col1: 'NID',
                                col2: 'Google - jedinečné ID, pomocí kterého si Google pamatuje vaše nastavení a další informace, např. váš preferovaný jazyk, kolik výsledků vyhledávání chcete zobrazovat na jedné stránce (např. 10 nebo 20) a zda chcete mít zapnutý filtr Bezpečné vyhledávání Google.',
                                col3: '',
                            },
                            {
                                col1: '_ga',
                                col2: 'Google Analytics - jedinečná identifikace sloužící pro generování statických dat o používání webové stránky.',
                                col3: '2 roky',
                            },
                            {
                                col1: 'test_cookie',
                                col2: 'Google - slouží k testování, zda prohlížeč podporuje cookies.',
                                col3: '15 minut',
                            },
                            {
                                col1: '_gat*',
                                col2: 'Google Analytics - používá se pro regulaci rychlosti zasílání požadavků.',
                                col3: '15 minut',
                            },
                            {
                                col1: '_gcl_au',
                                col2: 'Google - zjišťování reklamní efektivity napříč weby (Google AdSense).',
                                col3: '3 měsíce',
                            },
                            {
                                col1: 'CONSENT',
                                col2: 'Google - Analytical, Tracking 3d-parties.',
                                col3: '6 měsíců',
                            },
                            {
                                col1: 'DV',
                                col2: 'Google - ukládá informace o chování na stránce a sleduje reklamy před navštívením stránky k účelům následného využítí pro reklamu.',
                                col3: '7 minut',
                            },
                            {
                                col1: '_gid',
                                col2: 'Google Analytics - jedinečná identifikace sloužící pro generování statických dat o používání webové stránky.',
                                col3: '1 den',
                            },
                            {
                                col1: '1P_JAR',
                                col2: 'Používány pro shromažďování statistik o webových stránkách a sledovaní převodních sazeb.',
                                col3: '1 měsíc',
                            },
                            {
                                col1: 'IDE',
                                col2: 'Google - slouží k uložení informací pro remarketing.',
                                col3: '1 rok',
                            },
                            {
                                col1: 'OGPC',
                                col2: 'Cookie společnosti Google slouží k doručování reklam, které jsou pro vás a vaše zájmy relevantnější.',
                                col3: '2 měsíce',
                            }
                        ]
                        }
                    ]
                }
            }
            
        }
    });
    
    if(!cookieconsent.validCookie('cc_cookie')){
          var dataLayer = window.dataLayer || [];
            dataLayer.push({
            event:"CookieConsent",
            consentType:"empty"
    });
    
    
    }



        if (window.location.href.indexOf("cookies") != -1 )
        {
            var showCookies = document.createElement('button');
            showCookies.textContent = 'Změnit nastavení cookies';
            showCookies.className = "btn-cookie";
            showCookies.addEventListener( 'click', function(){
                var cookieconsent = initCookieConsent(); cookieconsent.showSettings();
            });

            document.body.appendChild(showCookies);
        }



});



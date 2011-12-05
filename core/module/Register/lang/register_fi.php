<?php
$lang = array(
	'pt_register' => 'Rekisteröidy sivulle '.GWF_SITENAME,

	'title_register' => 'Rekisteröidy',

	'th_username' => 'Käyttäjänimi',
	'th_password' => 'Salasana',
	'th_email' => 'Sähköpostiosoite',
	'th_birthdate' => 'Syntymäpäivä',
	'th_countryid' => 'Maa',
	'th_tos' => 'Hyväksyn <br/>Käyttöehdot',
	'th_tos2' => 'Hyväksyn <br/><a href="%s">Käyttöehdot</a>',
	'th_register' => 'Rekisteröidy',

	'btn_register' => 'Rekisteröidy',
	

	'err_register' => 'Rekisteröintiprosessin aikana tapahtui virhe.',
	'err_name_invalid' => 'Valitsemasi käyttäjänimi on virheellinen.',
	'err_name_taken' => 'Käyttäjänimi on jo käytössä.',
	'err_country' => 'Valitsemasi käyttäjänimi on virheellinen.',
	'err_pass_weak' => 'Salasanasi on liian heikko. Lisäksi, <b>Älä käytä uudelleen tärkeitä salasanoja</b>.',
	'err_token' => 'Aktivointikoodisi on virheellinen. Ehkä olet jo aktivoinut itsesi.',
	'err_email_invalid' => 'Sähköpostiosoitteesi on virheellinen.',
	'err_email_taken' => 'Sähköpostiosoitteesi on jo käytössä.',
	'err_activate' => 'Aktivoinnin aikana tapahtui virhe.',
		
	'msg_activated' => 'Tunnuksesi on nyt aktivoitu. Ole hyvä ja yritä kirjautua sisään.',
	'msg_registered' => 'Kiitos rekisteröitymisestä.',

	'regmail_subject' => 'Rekisteröinti sivustolla '.GWF_SITENAME,
	'regmail_body' => 
		'Tervehdys, %s<br/>'.
		'<br/>'.
		'Kiitos rekisteröitymisestäsi sivustolle '.GWF_SITENAME.'.<br/>'.
		'Suorittaaksesi rekisteröitymisesi loppuun sinun täytyy ensin aktivoida tunnuksesi vierailemalla allaolevassa linkissä.<br/>'.
		'Jos et rekisteröitynyt sivustolle '.GWF_SITENAME.', ole hyvä ja jätä tämä viesti huomiotta tai ota meihin yhteyttä: '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Terveisin,<br/>'.
		GWF_SITENAME.'-tiimi.',
	'err_tos' => 'Sinun täytyy hyväksyä Loppukäyttäjänä lisenssisopimus (EULA).',

	'regmail_ptbody' => 
		'Kirjautumistietosi ovat:<br/><b>'.
		'Käyttäjänimi: %s<br/>'.
		'Salasana: %s<br/>'.
		'</b><br/>'.
		'Olisi hyvä idea poistaa tämä sähköpostiviesti ja varastoida salasana jonnekkin muualle.<br/>'.
		'Me emme varastoi salasanaasi suojaamattomana, eikä sinunkaan tulisi tehdä niin.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Automaattinen sisäänkirjautuminen aktivoinnin jälkeen',	
	'cfg_captcha' => 'Captchan käyttö rekisteröidyttäessä',
	'cfg_country_select' => 'Näytä maavalikko',
	'cfg_email_activation' => 'Sähköpostirekisteröinti',
	'cfg_email_twice' => 'Salli saman sähköpostiosoitteen käyttö kahdesti?',
	'cfg_force_tos' => 'Näytä pakotettu TOS (käyttöehdot)',
	'cfg_ip_usetime' => 'IP-aikakatkaisu multirekisteröinnille',
	'cfg_min_age' => 'Vähimmäisikä / Syntymäpäivän valitsin',
	'cfg_plaintextpass' => 'Lähetä salasana sähköpostiin luettavassa muodossa',
	'cfg_activation_pp' => 'Aktivointien määrä/Adminsivu',
	'cfg_ua_threshold' => 'Rekisteröinnin viimeistelyn aikaraja',

	'err_birthdate' => 'Syntymäaikasi on virheellinen.',
	'err_minage' => 'Olemme pahoillamme, mutta olet liian nuori rekisteröityäksesi. Sinun tulisi olla vähintään %s vuotta vanha.',
	'err_ip_timeout' => 'Joku on hiljattain rekisteröinyt tunnuksen tästä IP-osoitteesta.',
	'th_token' => 'Koodi',
	'th_timestamp' => 'Rekisteröintiaika',
	'th_ip' => 'Rekisteröinnin IP-osoite',
	'tt_username' => 'Käyttäjänimen tulee alkaa kirjaimella.'.PHP_EOL.'Se saa sisältää ainoastaan kirjaimia, numeroita ja alaviivoja. Pituuden tulee olla 3 - %s merkkiä.', 
	'tt_email' => 'Voimassaoleva sähköpostiosoite vaaditaan rekisteröintiin.',

	'info_no_cookie' => 'Selaimesi ei tue keksejä (Cookies) tai ei salli niitä sivustolla '.GWF_SITENAME.', mutta keksejä tarvitaan sisäänkirjautumiseen.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Aktivointiohjeet sisältävä sähköpostiviesti on lähetetty sähköpostiosoitteeseesi.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Tunnista maa aina automaattisesti',
	
	# v2.03 (Links)
	'btn_login' => 'Kirjaudu sisään',
	'btn_recovery' => 'Salasanan palautus',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>
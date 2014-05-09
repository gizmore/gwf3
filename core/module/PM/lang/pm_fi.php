<?php

$lang = array(
	'hello' => 'Tervehdys, %s',
	'sel_username' => 'Valitse käyttäjänimi',
	'sel_folder' => 'Valitse kansio',

	# Info
	'pt_guest' => GWF_SITENAME.' Vieraiden yksityisviestit',
	'pi_guest' => GWF_SITENAME.'-sivuilla on myös mahdollista lähettää yksityisviesti kirjautumatta sisään, mutta silloin sinuun ei voida ottaa yhteyttä. Näin voit kuitenkin raportoida bugin nopeasti.',
	'pi_trashcan' => 'Tämä on roskakorisi. Et voi oikeasti poistaa viestejä, mutta voit palauttaa ne',
	
	# Buttons
	'btn_ignore' => 'Laita %s sivuutuslistallesi',
	'btn_ignore2' => 'Sivuuta (jätä huomiotta)',
	'btn_save' => 'Tallenna asetukset',
	'btn_create' => 'Uusi yksityisviesti',
	'btn_preview' => 'Esikatselu',
	'btn_send' => 'Lähetä yksityisviesti',
	'btn_delete' => 'Poista',
	'btn_restore' => 'Palauta',
	'btn_edit' => 'Muokkaa',
	'btn_autofolder' => 'Laita automaattisiin kansioihin',
	'btn_reply' => 'Vastaa',
	'btn_quote' => 'Lainaa',
	'btn_options' => 'Yksityisviestien asetukset',
	'btn_search' => 'Haku',
	'btn_trashcan' => 'Roskakorisi',
	'btn_auto_folder' => 'Järjestä yksityisviestit automaattisesti',

	# Errors
	'err_pm' => 'Yksityisviestiä ei ole.',
	'err_perm_read' => 'Sinulla ei ole valtuuksia lukea tätä yksityisviestiä.',
	'err_perm_write' => 'Sinulla ei ole valtuuksia muokata tätä yksityisviestiä.',
	'err_no_title' => 'Unohdit antaa yksityisviestille otsikon.',
	'err_title_len' => 'Otsikkosi on liian pitkä. Merkkien enimmäismäärä on %s.',
	'err_no_msg' => 'Unohdit kirjoittaa viestin.',
	'err_sig_len' => 'Allekirjoituksesi on liian pitkä. Merkkien enimmäismäärä on %s.',
	'err_msg_len' => 'Viestisi on liian pitkä. Merkkien enimmäismäärä on %s.',
	'err_user_no_ppm' => 'Tämä käyttäjä ei tahdo julkisia yksityiviestejä.',
	'err_no_mail' => 'Tunnuksellasi ei ole hyväksyttyä sähköpostiosoitetta.',
	'err_pmoaf' => 'Automaattisten kansioiden arvo ei kelpaa.',
	'err_limit' => 'Saavutit yksityisviestin enimmäismäärän tälle päivälle. Voit lähettää enintään %s yksityisviestiä seuraavan ajan sisällä: %s.',
	'err_ignored' => '%s on laittanut sinut sivuutuslistalleen.<br/>%s',
	'err_delete' => 'Viestiäsi poistettaessa tapahtui virhe.',
	'err_folder_exists' => 'Kansio on jo olemassa.',
	'err_folder_len' => 'Kansion nimen pituuden tulee olla 1 - %s merkkiä.',
	'err_del_twice' => 'Olet jo poistanut tämän yksityisviestin.',
	'err_folder' => 'Tuntematon kansio.',
	'err_pm_read' => 'Yksityisviesti on jo luettu, joten et voi enää muokata sitä.',

	# Messages
	'msg_sent' => 'Yksityisviestisi on lähetetty onnistuneesti. Voit vielä muokata sitä ennen kuin se luetaan.',
	'msg_ignored' => 'Olet laittanut käyttäjän %s sivuutuslistallesi.',
	'msg_unignored' => 'Poistit käyttäjän %s sivuutuslistaltasi.',
	'msg_changed' => 'Asetuksiasi on muutettu.',
	'msg_deleted' => 'Poistettiin onnistuneesti %s yksityisviestiä.',
	'msg_moved' => 'Siirrettiin onnistuneesti %s yksityisviestiä.',
	'msg_edited' => 'Yksityisviestiäsi on muokattu.',
	'msg_restored' => 'Palautettiin onnistuneesti %s yksityisviestiä.',
	'msg_auto_folder_off' => 'Et ole kytkenyt automaattisia kansioita päälle. Yksityisviesti on merkitty luetuksi.',
	'msg_auto_folder_none' => 'Tältä käyttäjältä/ tälle käyttäjälle on vain %s viestiä. Mitään ei siirretty. Yksityisviesti on merkitty luetuksi.',
	'msg_auto_folder_created' => 'Luotiin kansio %s.',
	'msg_auto_folder_moved' => 'Siirrettiin %s viesti(ä) kansioon %s. Yksityisviesti(t) merkitty luetu(i)ksi.',
	'msg_auto_folder_done' => 'Automaattiset kansiot tehty.',


	# Titles
	'ft_create' => 'Kirjoita %s:lle uusi yksityisviesti',
	'ft_preview' => 'Esikatselu',
	'ft_options' => 'Yksityisviestiasetuksesi',
	'ft_ignore' => 'Laita joku sivuutuslistallesi',
	'ft_new_pm' => 'Kirjoita uusi yksityisviesti',
	'ft_reply' => 'Vastaa %s:lle',
	'ft_edit' => 'Muokkaa yksityisviestiäsi',
	'ft_quicksearch' => 'Pikahaku',
	'ft_advsearch' => 'Tarkempi haku',

	# Tooltips
	'tt_pmo_auto_folder' => 'Jos yksittäinen käyttäjä lähettää sinulle tämän määrän yksityisviestejä, hänen viestinsä sijoitetaan automaattisesti omaan kansioon.',
	
	# Table Headers
	'th_pmo_options&1' => 'Sähköposti-ilmoitus uusista yksityisviesteistä',
	'th_pmo_options&2' => 'Salli vieraiden lähettää minulle yksityisviestejä',
	'th_pmo_auto_folder' => 'Luo käyttäjäkansio n yksityisviestin jälkeen',
	'th_pmo_signature' => 'Yksityisviestin allekirjoituksesi',

	'th_pm_options&1' => 'Uusi',
	'th_actions' => ' ',
	'th_user_name' => 'Käyttäjänimi',
	'th_pmf_name' => 'Kansio',
	'th_pmf_count' => 'Määrä',
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'Kenelle',
	'th_pm_from' => 'Keneltä',
//	'th_pm_to_folder' => 'Kansioon',
//	'th_pm_from_folder' => 'Kansiosta',
	'th_pm_date' => 'Päiväys',
	'th_pm_title' => 'Otsikko',
	'th_pm_message' => 'Viesti',
//	'th_pm_options' => 'Asetukset',

	# Welcome PM
	'wpm_title' => 'Tervetuloa sivustolle '.GWF_SITENAME,
	'wpm_message' => 
		'Hyvä %s'.PHP_EOL.
		PHP_EOL.
		'Tervetuloa sivustolle '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Toivottavasti pidät sivuistamme ja viihdyt täällä.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Uusi yksityisviesti käyttäjältä %s',
	'mail_body' =>
		'Tervehdys, %s'.PHP_EOL.
		PHP_EOL.
		'Sinulle on uusi yksityisviesti sivustolla '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'Käyttäjältä: %s'.PHP_EOL.
		'Otsikko: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Voit nopeasti:'.PHP_EOL.
		'Automaattikansioida viestin:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Poistaa viestin:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Terveisin,'.PHP_EOL.
		GWF_SITENAME.' Robotti'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Vieraiden täytyy käyttää Captchaa?',
	'cfg_pm_causes_mail' => 'Salli sähköposti-ilmoitus yksityisviestistä?',
	'cfg_pm_for_guests' => 'Salli vieraiden yksityisviestit?',
	'cfg_pm_welcome' => 'Lähetä tervetuliaisviesti?',
	'cfg_pm_limit' => 'Yksityisviestin enimmäismäärä aikarajan sisällä',
	'cfg_pm_maxfolders' => 'Kansioiden enimmäismäärä/käyttäjä',
	'cfg_pm_msg_len' => 'Viestin enimmäispituus',
	'cfg_pm_per_page' => 'Yksityisviestejä/sivu',
	'cfg_pm_sig_len' => 'Allekirjoituksen enimmäispituus',
	'cfg_pm_title_len' => 'Otsikon enimmäispituus',
	'cfg_pm_bot_uid' => 'Tervetuloa yksityisviestin lähettäjä ID',
	'cfg_pm_sent' => 'Yksityisviestilaskuri',
	'cfg_pm_mail_sender' => 'Sähköpostiviesti yksityisviestin lähettäjälle',
	'cfg_pm_re' => 'Korosta otsikkoa',
	'cfg_pm_limit_timeout' => 'Yksityisviestirajan aikakatkaisu',
	'cfg_pm_fname_len' => 'Kansion nimen enimmäispituus',
	
	# v2.01
	'err_ignore_admin' => 'Et voi lisätä Adminia sivuutuslistallesi.',
	'btn_new_folder' => 'Uusi kansio',
		
	# v2.02
	'msg_mail_sent' => 'Sähköpostiviesti lähetetty käyttäjälle %s sisältäen alkuperäisen viestisi.',
		
	# v2.03 SEO
	'pt_pm' => 'Lähetä yksityisviesti',
		
	# v2.04 fixes
	'ft_new_folder' => 'Luo uusi kansio',

	# v2.05 (prev+next)
	'btn_prev' => 'Edellinen viesti',
	'btn_next' => 'Seuraava viesti',

	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'Toinen käyttäjä on poistanut tämän yksityisviestin.',
	'gwf_pm_read' => 'Toinen käyttäjä on lukenut tämän yksityisviestin.',
	'gwf_pm_unread' => 'Toinen käyttäjä ei ole lukenut yksityisviestiäsi.',
	'gwf_pm_old' => 'Olet lukenut tämän yksityisviestin.',
	'gwf_pm_new' => 'Uusi yksityisviesti.',
	'err_bot' => 'Bottien viestit kielletty.',

	# v2.07 (fixes)
	'err_ignore_self' => 'Et voi lisätä itseäsi sivuutuslistalle.',
	'err_folder_perm' => 'Tämä kansio ei ole sinun.',
	'msg_folder_deleted' => 'Kansio %s ja %s viesti(ä) siirrettiin roskakoriin.',
	'cfg_pm_delete' => 'Hyväksy yksityisviestin poisto?',
	'ft_empty' => 'Tyhjennä roskakorisi',
	'msg_empty' => 'Roskakorisi (%s messages) on tyhjennetty.<br/>%s viesti(ä) on poistettu tietokannasta.<br/>%s viestiä ovat edelleen käytössä toisella käyttäjällä, eikä niitä poistettu.',
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
	# monnino fixes
	'cfg_pm_limit_per_level' => 'PM limit per level',
	'cfg_pm_own_bot' => 'PM own bot',
	'th_reason' => 'Reason',
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);

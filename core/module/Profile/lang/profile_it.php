<?php

$lang = array(
	# Page Titles
	'pt_profile' => 'Profilo di %s',
	'pt_settings' => 'Impostazioni del profilo',

	# Meta Tags
	'mt_profile' => 'Profilo di %s, '.GWF_SITENAME.', %s, Profilo',
	'mt_settings' => GWF_SITENAME.', Profilo, Impostazioni, Modifica, Contatto, Data',

	# Meta Description
	'md_profile' => 'Profilo di %s su'.GWF_SITENAME.'.',
	'md_settings' => 'Le tue impostazioni di profile su '.GWF_SITENAME.'.',

	# Info
	'pi_help' =>
	'Per caricare un avatar, utilizza le impostazioni dell\'account principale.<br/>'.
	'Per aggiungere una firma ai post del forum, utilizza le impostazioni del forum.<br/>'.
	'I PM e gli altri moduli hanno la loro pagina di impostazioni.<br/>'.
	'<b>Tutte le informazioni del profilo sono pubbliche, quindi si consiglia di non utilizzare informazioni che non si vuole rendere pubbliche</b>.<br/>'.
	'Per nascondere l\'indirizzo E-Mail, si assicuri di aver controllato anche la relativa opzione globale nelle impostazioni dell\'account.<br/>'.
	'E\' inoltre possibile nascondere il proprio profilo agli utenti non registrati e ai motori di ricerca.',

	# Errors
	'err_hidden' => 'Il profile dell\'utente è nascosto.',
	'err_firstname' => 'Il nome è invalido. Lunghezza massima: %s caratteri.',
	'err_lastname' => 'Il cognome è invalido. Lunghezza massima: %s caratteri.',
	'err_street' => 'La via è invalida. Lunghezza massima: %s caratteri.',
	'err_zip' => 'Il CAP è invalido. Lunghezza massima: %s caratteri.',
	'err_city' => 'La città è invalida. Lunghezza massima: %s caratteri.',
	'err_tel' => 'Il numero di telefono è invalido. Lunghezza massima: 24 caratteri, sono ammessi solo numeri e spazi.',
	'err_mobile' => 'Il numero di cellulare è invalido.',
	'err_icq' => 'Account ICQ-UIN invalido. Lunghezza massima: 16 numeri.',
	'err_msn' => 'Account MSN invalido.',
	'err_jabber' => 'Account Jabber invalido.',
	'err_skype' => 'Nome Skype invalido. Lunghezza massima: %s caratteri.',
	'err_yahoo' => 'Account Yahoo! invalido. Lunghezza massima: %s caratteri.',
	'err_aim' => 'Account AIM invalido. Lunghezza massima: %s caratteri.',
	'err_about_me' => 'Il testo fornito in &quot;A proposito di me&quot; è invalido. Lunghezza massima: %s caratteri.',
	'err_website' => 'Il sito fornito non esiste o sembra irraggiungibile.',

	# Messages
	'msg_edited' => 'Il suo profilo è stato modificato.',

	# Headers
	'th_user_name' => 'Nome utente',
	'th_user_level' => 'Livello',
	'th_user_avatar' => 'Avatar ',
	'th_gender' => 'Sesso',
	'th_firstname' => 'Nome',
	'th_lastname' => 'Cognome',
	'th_street' => 'Via',
	'th_zip' => 'CAP',
	'th_city' => 'Città',
	'th_website' => 'Sito',
	'th_tel' => 'Telefono',
	'th_mobile' => 'Cellulare',
	'th_icq' => 'ICQ ',
	'th_msn' => 'MSN ',
	'th_jabber' => 'Jabber ',
	'th_skype' => 'Skype ',
	'th_yahoo' => 'Yahoo! ',
	'th_aim' => 'AIM ',
	'th_about_me' => 'A proposito di te',
	'th_hidemail' => 'Nascondi indirizzo E-Mail?',
	'th_hidden' => 'Nascondi il profilo agli utenti non registrati?',
	'th_level_all' => 'Livello Minimo per Tutto',
	'th_level_contact' => 'Livello Minimo per Contatto',
	'th_hidecountry' => 'Nascondi la nazionalità?',
	'th_registered' => 'Data di registrazione',
	'th_last_active' => 'Ultima attività',
	'th_views' => 'Visualizzazioni del profilo',

	# Form Titles
	'ft_settings' => 'Modifica il profilo',

	# Tooltips
	'tt_level_all' => 'Livello minimo necessario per visualizzare il profilo',
	'tt_level_contact' => 'Livello minimo per poter visualizzare l\'area contatti',

	# Buttons
	'btn_edit' => 'Salva profilo',

	# Admin Config
	'cfg_prof_hide' => 'Permetti oscuramento profilo?',
	'cfg_prof_max_about' => 'Lunghezza massima per &quot;A proposito di me&quot;',

	# V2.01 (Hide Guests)
	'th_hideguest' => 'Nascondi agli utenti non registrati?',

	# v2.02 (fixes)
	'err_level_all' => 'Il livello minimo necessario per visualizzare il suo profilo è invalido.',
	'err_level_contact' => 'Il livello minimo necessario per visualizzare la sua area contatti è invalido.',

	# v2.03 (fixes2)
	'title_about_me' => 'A proposito di %s',

	# v2.04 (ext. profile)
	'th_user_country' => 'Nazione',
	'btn_pm' => 'PM ',

	# v2.05 (more fixes)
	'at_mailto' => 'Invia un\'E-Mail a %s',
	'th_email' => 'E-Mail',

	# v2.06 (birthday)
	'th_age' => 'Età',
	'th_birthdate' => 'Data di nascita',

	# v2.07 (IRC+Robots)
	'th_irc' => 'IRC ',
	'th_hiderobot' => 'Nascondi ai web crawlers?',
	'tt_hiderobot' => 'Selezioni questa opzione se non vuole che il suo profilo venga indicizzato dai web crawlers.',
	'err_no_spiders' => 'Questo profilo non verrà visualizzato dai web crawlers.',
	
	# monnino fixes
	'cfg_prof_level_gb' => 'Livello minimo per creare un guestbook nel profilo',
		
	# monnino fixes
	'cfg_prof_level_gb' => 'Minimum level to create a guestbook in the profile',

	# v2.08 (POI)
	'ph_places' => 'Points of Interest',
	'msg_white_added' => 'Successfully added %s to your POI whitelist.',
	'msg_white_removed' => 'Successfully removed %s user(s) from your POI whitelist.',
	'msg_pois_cleared' => 'All your Point of Interest data has been cleared.',
	'msg_white_cleared' => 'Your whitelist has been wiped.',
	'err_poi_read_perm' => 'You are not allowed to see POI.',
	'err_poi_exceed' => 'You cannot add more POI yet.',
	'err_self_whitelist' => 'You cannot whitelist yourself.',
	'prompt_rename' => 'Please enter a description.',
	'prompt_delete' => 'Do you want to remove this Point of Interest?',
	'th_poi_score' => 'Minimum user level to see your POI',
	'tt_poi_score' => 'You can hide your Points of Interest from users whose user level is too low.',
	'th_poi_white' => 'Use <a href="%s">whitelist</a> for POI',
	'tt_poi_white' => 'Instead of level based restrictions use your own POI whitelist.',
	'ft_add_whitelist' => 'Add a user to your whitelist',
	'ft_clear_pois' => 'Remove all POI you have created or clear the whitelist.',
	'th_date_added' => 'added on',
	'btn_clear_pois' => 'Clear POI data',
	'btn_clear_white' => 'Clear whitelist',
	'btn_add_whitelist' => 'Add user',
	'btn_rem_whitelist' => 'Remove user',
	'poi_info' => 'This page shows POI submitted by users.<br/>You are allowed to add %s/%s Points Of Interest.<br/>You can protect your POI by either <a href="%s">requirering a minimum userlevel</a>, or by using a <a href="%s">personal whitelist</a>.<br/>By default your POI are public.',
	'poi_usage' => 'Usage',
	'poi_usage_data' => array(
		'Click on an umarked location to add a new POI.',
		'A double click on your own POI deletes them.',
		'A click on your own POI allows to rename it.',
		'Adding sensitive information about others is not acceptable.',
	),
	'poi_helper' => 'Places Application',
	'btn_poi_init' => 'Start Places',
	'btn_poi_init_sensor' => 'Start Places with my current location',
	'ph_poi_jump' => 'Jump to an address',
	'err_poi_jump' => 'The address could not been found.',
	'poi_privacy_t' => 'Privacy gotchas',
	'poi_privacy' => 'I bet some are worried about privacy and refuse to use this page.<br/>Your requested map sections currently occur in Apache and GWF log files.<br/>Google probably records your requests as well.<br/>This server does not intentionally store any information on your personal location.<br/>GWF log files are removed from the server regularly and the Apache logs could connect IPs with your requests.<br/>The POI database only stores the POI submitted by users.',
	'poi_stats_t' => 'POI Statistics',
	'poi_stats' => 'There are a total of %s POI in the database of which %s are visible to you.',
);

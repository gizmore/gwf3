<?php

$lang = array(
	# Page Titles
	'pt_profile' => '%sn Profiili',
	'pt_settings' => 'Profiilin asetukset',

	# Meta Tags
	'mt_profile' => '%sn profiili, '.GWF_SITENAME.', %s, Profiili',
	'mt_settings' => GWF_SITENAME.', Profiili, Asetukset, Muokkaa, Ota yhteyttä, Data',

	# Meta Description
	'md_profile' => '%sn profiili on '.GWF_SITENAME.'.',
	'md_settings' => 'Profiilisi asetukset '.GWF_SITENAME.'.',

	# Info
	'pi_help' =>
		'Ladataksesti avatarin, käytä päätunnusta.<br/>'.
		'Lisätäksesi allekirjoitukset foorumiin, käytä foorumin asetuksia.<br/>'.
		'Yksityisviesteillä ja muilla moduuleilla on oma, erillinen sivu asetuksille.<br/>'.
		'<b>Kaikki profiilin asetukset ovat näkyvillä julkisesti, joten älä kerro liikaa itsestäsi</b>.<br/>'.
		'Jos piilotat sähköpostisi, tarkista myös tunnuksesi asetukset, sillä siellä on myös globaalin sähköpostin astukset.<br/>'.
		'Voit piilottaa profiilisi vierailta ja hakukoneilta.',

	# Errors
	'err_hidden' => 'Käyttäjän profiili on piilotettu.',
	'err_firstname' => 'Etunimesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_lastname' => 'Sukunimesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_street' => 'Lähiosoitteesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_zip' => 'Postinumerosi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_city' => 'Sinun kaupunkisi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_tel' => 'Puhelinumerosi on liian pitkä. Enimmäispituus: 24 numeroa tai välilyöntiä.',
	'err_mobile' => 'Puhelinnumerosi on epäkelpo.',
	'err_icq' => 'ICQ-UIN-tunnuksesi on liian pitkä. Enimmäispituus: 16 numeroa.',
	'err_msn' => 'MSN-tunnuksesi on epäkelpo.',
	'err_jabber' => 'Jabber-tunnuksesi on epäkelpo.',
	'err_skype' => 'Skype-nimesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_yahoo' => 'Yahoo!-tunnuksesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_aim' => 'AIM-tunnuksesi on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_about_me' => 'Sinun &quot;Tietoja minusta&quot; on liian pitkä. Enimmäispituus: %s merkkiä.',
	'err_website' => 'Websivusi ei ole käytettävissä tai ole olemassa.',

	# Messages
	'msg_edited' => 'Profiiliasi muokattiin.',

	# Headers
	'th_user_name' => 'Käyttäjänimi',
	'th_user_level' => 'Taso',
	'th_user_avatar' => 'Avatar',
	'th_gender' => 'Sukupuoli',
	'th_firstname' => 'Etunimi',
	'th_lastname' => 'Sukunimi',
	'th_street' => 'Osoite',
	'th_zip' => 'Postinumero',
	'th_city' => 'Kaupunki',
	'th_website' => 'Kotisivu',
	'th_tel' => 'Kotipuhelin',
	'th_mobile' => 'Matkapuhelin',
	'th_icq' => 'ICQ-tunnus',
	'th_msn' => 'MSN-tunnus',
	'th_jabber' => 'Jabber-tunnus',
	'th_skype' => 'Skype-tunnus',
	'th_yahoo' => 'Yahoo!-tunnus',
	'th_aim' => 'AIM-tunnus',
	'th_about_me' => 'Tietoa sinusta',
	'th_hidemail' => 'Piilosta sähköposti profiilissa?',
	'th_hidden' => 'Piilota profiili viereilta?',
	'th_level_all' => 'Vähimmäiskäyttäjätaso',
	'th_level_contact' => 'Vähimmäistaso yhteydenottoon',
	'th_hidecountry' => 'Piilota maasi?',
	'th_registered' => 'Liittymispäivä',
	'th_last_active' => 'Viimeksi paikalla',
	'th_views' => 'Vierailuja profiilissa',

	# Form Titles
	'ft_settings' => 'Muokkaa profiiliasi',

	# Tooltips
	'tt_level_all' => 'Pienin taso jolla tunnuksesi näkee',
	'tt_level_contact' => 'Pienin taso jolla yhteystietosi näkee',

	# Buttons
	'btn_edit' => 'Tallenna profiili',

	# Admin Config
	'cfg_prof_hide' => 'Salli profiilien piilottaminen?',
	'cfg_prof_max_about' => 'Suurin sallitty pituus &quot;Tietoja minusta&quot;',

	# V2.01 (Hide Guests)
	'th_hideguest' => 'Piilota vierailta?',

	# v2.02 (fixes)
	'err_level_all' => 'Pienin käyttäjätaso jolla profiilisi näkee on epäkelpo.',
	'err_level_contact' => 'Pienin käyttäjätaso jolla yhteystietosi näkee on epäkelpo.',

	# v2.03 (fixes2)
	'title_about_me' => 'Tietoja %s',

	# v2.04 (ext. profile)
	'th_user_country' => 'Maa',
	'btn_pm' => 'Yksityisviesti',

	# v2.05 (more fixes)
	'at_mailto' => 'Send a mail to %s',
	'th_email' => 'EMail',

	# v2.06 (birthday)
	'th_age' => 'Age',
	'th_birthdate' => 'Birthdate',

	# v2.07 (IRC+Robots)
	'th_irc' => 'IRC',
	'th_hiderobot' => 'Hide from web crawlers?',
	'tt_hiderobot' => 'Checkmark this if you don\'t want your profile get indexed by search engines.',
	'err_no_spiders' => 'This profile can not be watched by web crawlers.',

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
	'poi_info' => 'This page shows POI entered by the users.<br/>You are allowed to add %s/%s Points Of Interest.<br/>You can protect your POI by either <a href="%s">requirering a minimum userlevel</a>, or by using a <a href="%s">personal whitelist</a>.<br/>By default your POI are public.',
	'poi_usage' => 'Usage',
	'poi_usage_data' => array(
		'A click on an empty space adds a new POI.',
		'A doubleclick on your own POI deletes them.',
		'A click on your own POI renames them.',
		'Please do not add the homes of other users by any means.',
	),
);

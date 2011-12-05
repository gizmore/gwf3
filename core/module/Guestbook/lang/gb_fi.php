<?php

$lang = array(

	# Default GB Name
	'default_title' => GWF_SITENAME.' Vieraskirja',
	'default_descr' => 'The '.GWF_SITENAME.' Vieraskirja',

	# Errors
	'err_gb' => 'Vieraskirjaa ei ole.',
	'err_gbm' => 'Vieraskirjamerkintää ei ole.',
	'err_gbm_username' => 'Käyttäjänimesi on virheellinen. Käyttäjänimen pituuden tulee olla %s - %s merkkiä pitkä.',
	'err_gbm_message' => 'Viestisi on virheellinen. Viestin pituuden tulee olla %s - %s merkkiä pitkä.',
	'err_gbm_url' => 'Web-sivustosi ei ole tavoitettavissa tai URL on virheellinen.',
	'err_gbm_email' => 'Sähköpostiosoitteesi näyttää virheelliseltä.',
	'err_gb_title' => 'Otsikkosi on virheellinen. Otsikon tulee olla %s - %s merkkiä pitkä.',
	'err_gb_descr' => 'Kuvauksesi on virheellinen. Kuvauksen tulee olla %s - %s merkkiä pitkä.',

	# Messages
	'msg_signed' => 'Kirjoitit onnistuneesti vieraskirjaan.',
	'msg_signed_mod' => 'Kirjoitit onnistuneesti vieraskirjaan, mutta merkintäsi täytyy hyväksyä ennen kuin se tulee näkyviin.',
	'msg_gb_edited' => 'Vieraskirjaa on muokattu.',
	'msg_gbm_edited' => 'Vieraskirjamerkintää on muokattu.',
	'msg_gbm_mod_0' => 'Vieraskirjamerkintä on nyt näkyvillä.',
	'msg_gbm_mod_1' => 'Vieraskirjamerkintä on moderointijonossa.',
	'msg_gbm_pub_0' => 'Vieraskirjamerkintä ei näy vieraille.',
	'msg_gbm_pub_1' => 'Vieraskirjamerkintä näkyy vieraille.',

	# Headers
	'th_gbm_username' => 'Nimimerkkisi',
	'th_gbm_email' => 'Sähköpostiosoitteesi',
	'th_gbm_url' => 'Web-sivustosi',
	'th_gbm_message' => 'Viestisi',
	'th_opt_public' => 'Julkinen viesti?',
	'th_opt_toggle' => 'Salli julkiseksi merkitseminen?',
	'th_gb_title' => 'Otsikko',
	'th_gb_locked' => 'Lukittu?',
	'th_gb_moderated' => 'Moderoitu?',
	'th_gb_guest_view' => 'Julkinen katselu?',
	'th_gb_guest_sign' => 'Vierasmerkintä?',
	'th_gb_bbcode' => 'Salli BB-koodi?',
	'th_gb_urls' => 'Salli käyttäjän URL?',
	'th_gb_smiles' => 'Salli hymiöt?',
	'th_gb_emails' => 'Salli käyttäjän sähköposti?',
	'th_gb_descr' => 'Kuvaus',
	'th_gb_nesting' => 'Pesintä sallittu?',

	# Tooltips
	'tt_gbm_email' => 'Sähköpostisi näytetään kaikille, jos laitat sen!',
	'tt_gb_locked' => 'Merkitse ottaaksesi vieraskirjan väliaikaisesti pois käytöstä',

	# Titles
	'ft_sign' => 'Kirjoita %s',
	'ft_edit_gb' => 'Muokkaa vieraskirjaasi',
	'ft_edit_entry' => 'Muokkaa vieraskirjamerkintää',

	# Buttons
	'btn_sign' => 'Kirjoita %s',
	'btn_edit_gb' => 'Muokkaa vieraskirjaa',
	'btn_edit_entry' => 'Muokkaa merkintää',
	'btn_public_hide' => 'Piilota tämä merkintä vierailta',
	'btn_public_show' => 'Näytä tämä merkintä julkisesti',
	'btn_moderate_no' => 'Hyväksy tämä merkintä näytettäväksi',
	'btn_moderate_yes' => 'Piilota ja laita tämä viesti moderointijonoon',
	'btn_replyto' => 'Vastaa viestiin %s',

	# Admin Config
	'cfg_gb_allow_email' => 'Salli ja näytä sähköpostiosoitteet?',
	'cfg_gb_allow_url' => 'Salli ja näytä Web-sivustot?',
	'cfg_gb_allow_guest' => 'Salli vieraiden merkinnät?',
	'cfg_gb_captcha' => 'Täytääkö vieraiden käyttää Captchaa?',
	'cfg_gb_ipp' => 'Merkinnät/sivu',
	'cfg_gb_max_msglen' => 'Viestin enimmäispituus',
	'cfg_gb_max_ulen' => 'Vierailijan nimen enimmäispituus',
	'cfg_gb_max_titlelen' => 'Vieraskirjan otsikon enimmäispituus',
	'cfg_gb_max_descrlen' => 'Vieraskirjan kuvauksen enimmäispituus',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Vieraskirjan luomiseen vaadittava vähimmäistaso',
	'mails_signed' => GWF_SITENAME.': Vieraskirjaan kirjoitettu',
	'mailb_signed' => 
		'Hyvö %s'.PHP_EOL.
		PHP_EOL.
		'%s vieraskirjaan tehtiin merkintä käyttäjän toimesta: %s (%s)'.PHP_EOL.
		'Viesti:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Voit automaattisesti näyttää tämän merkinnän vierailemalla osoitteessa:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	# v2.02 Mail on Sign
	'th_mailonsign' => 'Sähköposti-ilmoitus uudesta merkinnästä?',
	'mails2_signed' => GWF_SITENAME.': Vieraskirjaan kirjoitettu',
	'mailb2_signed' => 
		'Hyvä %s'.PHP_EOL.
		PHP_EOL.
		'%s vieraskirjaan tehtiin merkintä käyttäjän toimesta: %s (%s)'.PHP_EOL.
		'Viesti:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	# v2.03 (Delete entry)
	'btn_del_entry' => 'Poista merkintä',
	'msg_e_deleted' => 'Merkintä poistettu.',

	# v2.04 (finish)
	'cfg_gb_menu' => 'Näytä valikossa?',
	'cfg_gb_nesting' => 'Salli nesting?',
	'cfg_gb_submenu' => 'Näytä alivalikossa?',
	'err_locked' => 'Vieraskirja on tällä hetkellä lukittu.',

	# v2.05 (showmail)
	'th_opt_showmail' => 'Show EMail to public?',
);

?>
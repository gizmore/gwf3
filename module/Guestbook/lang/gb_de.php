<?php

$lang = array(

	# Default GB Name
	'default_title' => GWF_SITENAME.' Gästebuch',
	'default_descr' => 'Das '.GWF_SITENAME.' Gästebuch',

	# Errors
	'err_gb' => 'Das Gästebuch existiert nicht.',
	'err_gbm' => 'Der Eintrag existiert nicht.',
	'err_gbm_username' => 'Der Nickname ist ungültig und muss zwischen %1% und %2% Zeichen lang sein.',
	'err_gbm_message' => 'Ihre Nachricht ist zu kurz oder zu lang. (%1% bis %2% Zeichen).',
	'err_gbm_url' => 'Ihre Webseite ist nicht erreichbar oder die URL ist ungültig.',
	'err_gbm_email' => 'Ihre EMail ist nicht gültig.',
	'err_gb_title' => 'Der Gästebuchtitel ist ungültig und muss zwischen %1% und %2% Zeichen lang sein.',
	'err_gb_descr' => 'Der Beschreibung ist ungültig und muss zwischen %1% und %2% Zeichen lang sein.',

	# Messages
	'msg_signed' => 'Sie haben erfolgreich einen Eintrag in das Gästebuch verfasst.',
	'msg_signed_mod' => 'Sie haben erfolgreich einen Eintrag in das Gästebuch verfasst. Der Eintrag muss genehmigt werden bevor er angezeigt wird.',
	'msg_gb_edited' => 'Das Gästebuch wurde editiert.',
	'msg_gbm_edited' => 'Der Gästebucheintrag wurde bearbeitet.',
	'msg_gbm_mod_0' => 'Der Gästebucheintrag wird nun angezeigt.',
	'msg_gbm_mod_1' => 'Der Gästebucheintrag wurde als &quot;zu moderieren&quot; markiert.',
	'msg_gbm_pub_0' => 'Der Gästebucheintrag ist nun für Gäste unsichtbar.',
	'msg_gbm_pub_1' => 'Der Gästebucheintrag ist nun für Gäste sichtbar.',

	# Headers
	'th_gbm_username' => 'Ihr Nickname',
	'th_gbm_email' => 'Ihre EMail',
	'th_gbm_url' => 'Ihre Webseite',
	'th_gbm_message' => 'Ihre Nachricht',
	'th_opt_public' => 'Nachricht Öffentlich?',
	'th_opt_toggle' => 'Änderung von &quot;Öffentlich&quot; zulassen?',
	'th_gb_title' => 'Titel',
	'th_gb_locked' => 'Geschlossen?',
	'th_gb_moderated' => 'Moderieren?',
	'th_gb_guest_view' => 'Öffentlich sichtbar?',
	'th_gb_guest_sign' => 'Gäste können zeichnen?',
	'th_gb_bbcode' => 'BBCode erlauben?',
	'th_gb_urls' => 'Benutzer Webseite erlauben?',
	'th_gb_smiles' => 'Smileys erlauben?',
	'th_gb_emails' => 'Benutzer EMails erlauben?',
	'th_gb_descr' => 'Beschreibung',
	'th_gb_nesting' => 'Nesting erlauben?',

	# Tooltips
	'tt_gbm_email' => 'Ihre EMail ist öffentlich sichtbar, falls sie eine angeben.',
	'tt_gb_locked' => 'Häkchen setzen um das Gästebuch vorübergehend zu deaktivieren.',

	# Titles
	'ft_sign' => '%1% zeichnen',
	'ft_edit_gb' => 'Gästebuch bearbeiten',
	'ft_edit_entry' => 'Gästebucheintrag bearbeiten',

	# Buttons
	'btn_sign' => '%1% zeichnen',
	'btn_edit_gb' => 'Gästebuch bearbeiten',
	'btn_edit_entry' => 'Gästebucheintrag bearbeiten',
	'btn_public_hide' => 'Eintrag vor Gästen verstecken',
	'btn_public_show' => 'Eintrag für Gäste anzeigen',
	'btn_moderate_no' => 'Eintrag anzeigen',
	'btn_moderate_yes' => 'Eintrag verstecken',
	'btn_replyto' => 'Auf %1% antworten',

	# Admin Config
	'cfg_gb_allow_email' => 'Benutzer EMails erlauben?',
	'cfg_gb_allow_url' => 'Benutzer Websites erlauben?',
	'cfg_gb_allow_guest' => 'Gäste dürfen zeichnen?',
	'cfg_gb_captcha' => 'Captcha für Gäste?',
	'cfg_gb_ipp' => 'Einträge pro Seite',
	'cfg_gb_max_msglen' => 'Max. Nachrichtenlänge',
	'cfg_gb_max_ulen' => 'Max. Niknamen-Länge',
	'cfg_gb_max_titlelen' => 'Max. Gästebuch-Title-Länge',
	'cfg_gb_max_descrlen' => 'Max. Gästebuch-Beschreibung-Länge',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Mindest Level um ein Gästebuch zu erzeugen',
	'mails_signed' => GWF_SITENAME.': Gästebuch gezeichnet',
	'mailb_signed' => 
		'Liebes Team'.PHP_EOL.
		PHP_EOL.
		'Das %1% Gästebuch wurde von %2% gezeichnet (%3)'.PHP_EOL.
		'Nachricht:'.PHP_EOL.
		'%4%'.PHP_EOL.
		PHP_EOL.
		'Sie können diesen Eintrag durch aufrufen des folgenden Links anzeigen lassen:'.PHP_EOL.
		'%5%'.PHP_EOL,

	# v2.02 Mail on Sign
	'th_mailonsign' => 'E-Mail bei neuem Eintrag?',
	'mails2_signed' => GWF_SITENAME.': Gästebucheintrag',
	'mailb2_signed' => 
		'Lieber %1%'.PHP_EOL.
		PHP_EOL.
		'Ein neuer Eintrag in das %2% Gästebuch wurde verfasst.'.
		'Von: %3% (%4%)'.PHP_EOL.
		'Nachricht:'.PHP_EOL.
		'%5%'.PHP_EOL,
		
	# v2.03 (Delete entry)
	'btn_del_entry' => 'Eintrag Löschen',
	'msg_e_deleted' => 'Der Eintrag wurde gelöscht.',
		
	# v2.04 (finish)
	'cfg_gb_menu' => 'Im Menu anzeigen?',
	'cfg_gb_nesting' => 'Nesting erlauben?',
	'cfg_gb_submenu' => 'Im Untermenu anzeigen?',
	'err_locked' => 'Dieses Gästebuch ist zur Zeit deaktiviert.',

	# v2.05 (showmail)
	'th_opt_showmail' => 'EMail öffentlich anzeigen?',
		
);

?>
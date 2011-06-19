<?php

$lang = array(

	# Titles
	'form_title' => 'Konto Einstellungen',
	'chmail_title' => 'Geben sie ihre neue EMail Addresse an',

	# Headers
	'th_username' => 'Ihr Benutzername',
	'th_email' => 'Kontakt EMail',
	'th_demo' => 'Demographische Optionen - Diese k√∂nnen sie nur einmal alle %1% √§ndern.',
	'th_countryid' => 'Land',	
	'th_langid' => 'Muttersprache',	
	'th_langid2' => '1. Fremdsprache',
	'th_birthdate' => 'Ihr Geburtsdatum',
	'th_gender' => 'Ihr Geschlecht',
	'th_flags' => 'Optionen - √Ñnderungen sind jederzeit m√∂glich',
	'th_adult' => 'M√∂chten sie Inhalt f√ºr Erwachsene?',
	'th_online' => 'Ihren Online Status verstecken?',
	'th_show_email' => 'EMail addresse √∂ffentlich sichtbar?',
	'th_avatar' => 'Ihr Benutzerbild',
	'th_approvemail' => '<b>Ihre EMail ist<br/>nicht best√§tigt</b>',
	'th_email_new' => 'Ihre neue EMail Addresse',
	'th_email_re' => 'EMail Addresse wiederholen',

	# Buttons
	'btn_submit' => '√Ñnderungen √ºbernehmen',
	'btn_approvemail' => 'EMail best√§tigen',
	'btn_changemail' => 'Neue EMail festlegen',
	'btn_drop_avatar' => 'Benutzerbild l√∂schen',

	# Errors
	'err_token' => 'Ung√ºltiges Token.',
	'err_email_retype' => 'Sie m√ºssen Ihre EMail korrekt wiederholen.',
	'err_delete_avatar' => 'Ein Fehler ist beim L√∂schen Ihres Avatars aufgetreten.',
	'err_no_mail_to_approve' => 'Sie haben keine EMail zum best√§tigen angegeben.',
	'err_already_approved' => 'Ihre EMail Addresse ist bereits best√§tigt.',
	'err_no_image' => 'Ihre hochgeladene Datei ist kein Bild, oder zu klein.',
	'err_demo_wait' => 'Sie haben Ihre demographischen Einstellungen erst k√ºrzlich ge√§ndert. Bitte warten sie %1%.',
	'err_birthdate' => 'Ihr Geburts-Datum ist ung√ºltig.',

	# Messages
	'msg_mail_changed' => 'Ihre EMail Addresse wurde ge√§ndert und lautet nun <b>%1%</b>.',
	'msg_deleted_avatar' => 'Ihr Benutzerbild wurde gel√∂scht.',
	'msg_avatar_saved' => 'Ihr neues Benutzerbild wurde gespeichert.',
	'msg_demo_changed' => 'Ihre demographischen Einstellungen wurden erfolgreich ge√§ndert.',
	'msg_mail_sent' => 'Wir haben Ihnen eine EMail gesendet um die √Ñnderungen vorzunehmen. Bitte folgen sie den Anweisungen dort.',
	'msg_show_email_on' => 'Ihre EMail ist nun √∂ffentlich sichtbar.',
	'msg_show_email_off' => 'Ihre EMail ist nun versteckt.',
	'msg_adult_on' => 'Sie k√∂nnen nun Inhalt f√ºr Erwachsene sehen.',
	'msg_adult_off' => 'Inhalt f√ºr Erwachsene wurde deaktiviert.',
	'msg_online_on' => 'Ihr Online-Status ist nun unsichtbar.',
	'msg_online_off' => 'Ihr Online-Status ist nun sichtbar.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatar Max. Breite',
	'cfg_avatar_max_y' => 'Avatar Max. H√∂he',
	'cfg_avatar_min_x' => 'Avatar Min. Breite',
	'cfg_avatar_min_y' => 'Avatar Min. H√∂he',
	'cfg_adult_age' => 'Mindest-Alter f√ºr Erwachsenen-Inhalt',
	'cfg_demo_changetime' => 'Demographische √Ñnderung Interval',
	'cfg_mail_sender' => 'Absender f√ºr Konto √Ñnderungen',
	'cfg_show_adult' => 'Webseite hat Inhalt f. Erwachsene?',
	'cfg_show_gender' => 'Geschlechts-Auswahl anzeigen?',
	'cfg_use_email' => 'Best√§tigte EMail f√ºr √§nderungen erforderlich?',
	'cfg_show_avatar' => 'Benutzerbilder erlauben?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': EMail √§ndern',
	'chmaila_body' => 
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt ihre EMail auf '.GWF_SITENAME.' zu √§ndern.'.PHP_EOL.
		'Um die √Ñnderung abzuschliessen, folgen sie bitten dem Link unterhalb dieses Textes.'.PHP_EOL.
		'Falls sie die √Ñnderung nicht selbst beantragt haben sollten, k√∂nnen sie diese Mail ignorieren, oder uns dar√ºber informieren.'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Freundliche Gr√º√üe'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': EMail best√§tigen',
	'chmailb_body' => 
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Um diese EMail als ihre Kontakt-Addresse zu verwenden, m√ºssen sie dies noch best√§tigen indem sie den folgenden Link aufrufen:'.PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Freundliche Gr√º√üe'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Demographische Einstellungen',
	'chdemo_body' =>
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt ihre demographischen Einstellungen festzulegen oder zu √§ndern.'.PHP_EOL.
		'Dies k√∂nnen sie nur einmal alle %2% ausf√ºhren, also stellen sie bitte sicher, da√ü Ihre Angaben korrekt sind bevor sie fortfahren.'.PHP_EOL.
		PHP_EOL.
		'Geschlecht: %3%'.PHP_EOL.
		'Land: %4%'.PHP_EOL.
		'Muttersprache: %5%'.PHP_EOL.
		'Fremdsprache: %6%'.PHP_EOL.
		'Geburtstag: %7%'.PHP_EOL.
		PHP_EOL.
		'Wenn sie diese Einstellungen √ºbernehmen m√∂chten, rufen Sie bitte den folgenden Link auf:'.PHP_EOL.
		'%8%'.
		PHP_EOL.
		'Freundliche Gr√º√üe'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',

	# New Flags 
	'th_allow_email' => 'Anderen Erlauben ihnen eine EMail zu senden',
	'msg_allow_email_on' => 'Ihnen kann nun √ºber diese Webseite eine EMail gesendet werden, ohne ihre Addresse zu offenbaren.',
	'msg_allow_email_off' => 'EMail kontakt wurde f√ºr Ihr Konto deaktiviert.',
		
	'th_show_bday' => 'Ihren Geburtstag anzeigen?',
	'msg_show_bday_on' => 'Ihr Geburtstag wird nun Mitgliedern bekannt gegeben, welche dies m√∂chten.',
	'msg_show_bday_off' => 'Ihr Geburtstag ist nun versteckt.',
		
	'th_show_obday' => 'Andere Geburtstage anzeigen',
	'msg_show_obday_on' => 'Sie werden von nun an √ºber Geburtstage informiert.',
	'msg_show_obday_off' => 'Sie werden nun nicht mehr √ºber Geburtstage informiert.',

	# v2.02 Account Deletion
	'pt_accrm' => 'Konto L√∂schen',
	'mt_accrm' => 'Ihr Konto auf '.GWF_SITENAME.' l√∂schen.',
	'pi_accrm' =>
		'Sie m√∂chten ihr Konto auf '.GWF_SITENAME.' l√∂schen.<br/>'.
		'Das ist schade. Ihr Konto wird nicht vollst√§ndig gel√∂scht, aber alle Verweise werden entfernt und Ihr Konto ist danach unbrauchbar.<br/>'.
		'Alle Verkn√ºpfungen und Verweise zu Ihrem Konto werden als Gast angezeigt, dies kann nicht r√ºckg√§ngig gemacht werden.<br/>'.
		'Bevor sie Ihr Konto entg√ºltig l√∂schen, k√∂nnen Sie uns eine Nachricht hinterlassen, falls sie mit uns unzufrieden waren.<br/>',
	'th_accrm_note' => 'Notiz',
	'btn_accrm' => 'Konto L√∂schen',
	'msg_accrm' => 'Ihr Konto wurde als gel√∂scht markiert. Alle Verweise wurden gel√∂scht.<br/>Sie wurden aus dem System ausgeloggt.',
	'ms_accrm' => GWF_SITENAME.': %1% Konto gel√∂scht',
	'mb_accrm' =>
		'Liebes Team'.PHP_EOL.
		''.PHP_EOL.
		'Der Benutzer %1% hat soeben sein Konto gel√∂scht und diese Nachricht hinterlassen (kann leer sein):'.PHP_EOL.PHP_EOL.
		'%2%',
		

	# v2.03 Email Options
	'th_email_fmt' => 'Bevorzugtes EMail Format',
	'email_fmt_text' => 'Text',
	'email_fmt_html' => 'HTML',
	'err_email_fmt' => 'Bitte w‰hlen Sie ein g¸ltiges EMail Format.',
	'msg_email_fmt_0' => 'Sie werden EMails jetzt im HTML Format erhalten.',
	'msg_email_fmt_4096' => 'Sie werden EMails jetzt im Text Format erhalten.',
	'ft_gpg' => 'PGP/GPG Verschl¸sselung einrichten',
	'th_gpg_key' => 'Laden Sie ihren ˆffentlichen Schl¸ssel hoch',
	'th_gpg_key2' => 'Oder f¸gen Sie ihn hier ein',
	'tt_gpg_key' => 'Wenn Sie einen PGP Schl¸ssel einstellen werden alle zu Ihnen gesendete EMails mit Ihrem ˆffentlichen Schl¸ssel verschl¸sselt',
	'tt_gpg_key2' => 'F¸gen Sie hier ihren ˆffentlichen Schl¸ssel ein oder Laden Sie ihn als Datei hoch.',
	'btn_setup_gpg' => 'Schl¸ssel hochladeen',
	'btn_remove_gpg' => 'Schl¸ssel entfernen',
	'err_gpg_setup' => 'F¸gen Sie hier ihren ˆffentlichen Schl¸ssel ein oder Laden Sie ihn als Datei hoch.',
	'err_gpg_key' => 'Ihr ˆffentlicher Schl¸ssel scheint ung¸ltig zu sein.',
	'err_gpg_token' => 'Ihre GPG Signatur passt nicht zu unseren Daten.',
	'err_no_gpg_key' => 'Der Benutzer %1% hat noch keinen ˆffentlichen Schl¸ssel angegeben.',
	'err_no_mail' => 'Sie haben keine best‰tigte EMail Addresse.',
	'err_gpg_del' => 'Sie haben keinen best‰tigten GPG Schl¸ssel zum Lˆschen.',
	'err_gpg_fine' => 'Sie haben schon einen GPG Schl¸ssel. Bitte lˆschen Sie diesen zuerst.',
	'msg_gpg_del' => 'Ihr GPG Schl¸ssel wurde erfolgreich gelˆscht.',
	'msg_setup_gpg' => 'Ihr GPG Schl¸ssel wurde gespeichert und wird ab jetzt verwendet.',
	'mails_gpg' => GWF_SITENAME.': GPG Verschl¸sselung einrichten',
	'mailb_gpg' =>
		'Sehr geehrte(r) %1%,'.PHP_EOL.
		PHP_EOL.
		'Sie wollen die GPG Verschl¸sselung f¸r EMails dieser Seite aktivieren.'.PHP_EOL.
		'Klicken Sie zur Aktivierung auf den folgenden Link:'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Mit freundlichen Gr¸ﬂen'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%1%">Passwort ‰ndern</a>',
	'err_gpg_raw' => GWF_SITENAME.' unterst¸tzt nur ASCII formatierte GPG Schl¸ssel.',
	# v2.05 (fixes)
	'btn_delete' => 'Account lˆschen',
	'err_email_invalid' => 'Ihre EMail scheint ung¸ltig zu sein.',

	# v3.00 (fixes3)
	'err_email_taken' => 'Diese EMail Addresse wird bereits von einem anderen Benutzer genutzt.',
);
?>

<?php

$lang = array(

	# Titles
	'form_title' => 'Konto Einstellungen',
	'chmail_title' => 'Geben sie ihre neue EMail Address an',

	# Headers
	'th_username' => 'Ihr Benutzername',
	'th_email' => 'Kontakt EMail',
	'th_demo' => 'Demographische Optionen - Diese können sie nur einmal alle %1% ändern.',
	'th_countryid' => 'Land',	
	'th_langid' => 'Muttersprache',	
	'th_langid2' => '1. Fremdsprache',
	'th_birthdate' => 'Ihr Geburtsdatum',
	'th_gender' => 'Ihr Geschlecht',
	'th_flags' => 'Optionen - Änderungen sind jederzeit möglich',
	'th_adult' => 'Möchten sie Inhalt für Erwachsene?',
	'th_online' => 'Ihren Online Status verstecken?',
	'th_show_email' => 'EMail addresse öffentlich sichtbar?',
	'th_avatar' => 'Ihr Benutzerbild',
	'th_approvemail' => '<b>Ihre EMail ist<br/>nicht bestätigt</b>',
	'th_email_new' => 'Ihre neue EMail Addresse',
	'th_email_re' => 'EMail Addresse wiederholen',

	# Buttons
	'btn_submit' => 'Änderungen übernehmen',
	'btn_approvemail' => 'EMail bestätigen',
	'btn_changemail' => 'Neue EMail festlegen',
	'btn_drop_avatar' => 'Benutzerbild löschen',

	# Errors
	'err_token' => 'Ungültiges Token.',
	'err_email_retype' => 'Sie müssen Ihre EMail korrekt wiederholen.',
	'err_delete_avatar' => 'Ein Fehler ist beim Löschen Ihres Avatars aufgetreten.',
	'err_no_mail_to_approve' => 'Sie haben keine EMail zum bestätigen angegeben.',
	'err_already_approved' => 'Ihre EMail Addresse ist bereits bestätigt.',
	'err_no_image' => 'Ihre hochgeladene Datei ist kein Bild, oder zu klein.',
	'err_demo_wait' => 'Sie haben Ihre demographischen Einstellungen erst kürzlich geändert. Bitte warten sie %1%.',
	'err_birthdate' => 'Ihr Geburts-Datum ist ungültig.',

	# Messages
	'msg_mail_changed' => 'Ihre EMail Addresse wurde geändert und lautet nun <b>%1%</b>.',
	'msg_deleted_avatar' => 'Ihr Benutzerbild wurde gelöscht.',
	'msg_avatar_saved' => 'Ihr neues Benutzerbild wurde gespeichert.',
	'msg_demo_changed' => 'Ihre demographischen Einstellungen wurden erfolgreich geändert.',
	'msg_mail_sent' => 'Wir haben Ihnen eine EMail gesendet um die Änderungen vorzunehmen. Bitte folgen sie den Anweisungen dort.',
	'msg_show_email_on' => 'Ihre EMail ist nun öffentlich sichtbar.',
	'msg_show_email_off' => 'Ihre EMail ist nun versteckt.',
	'msg_adult_on' => 'Sie können nun Inhalt für Erwachsene sehen.',
	'msg_adult_off' => 'Inhalt für Erwachsene wurde deaktiviert.',
	'msg_online_on' => 'Ihr Online-Status ist nun unsichtbar.',
	'msg_online_off' => 'Ihr Online-Status ist nun sichtbar.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatar Max. Breite',
	'cfg_avatar_max_y' => 'Avatar Max. Höhe',
	'cfg_avatar_min_x' => 'Avatar Min. Breite',
	'cfg_avatar_min_y' => 'Avatar Min. Höhe',
	'cfg_adult_age' => 'Mindest-Alter für Erwachsenen-Inhalt',
	'cfg_demo_changetime' => 'Demographische Änderung Interval',
	'cfg_mail_sender' => 'Absender für Konto Änderungen',
	'cfg_show_adult' => 'Webseite hat Inhalt f. Erwachsene?',
	'cfg_show_gender' => 'Geschlechts-Auswahl anzeigen?',
	'cfg_use_email' => 'Bestätigte EMail für änderungen erforderlich?',
	'cfg_show_avatar' => 'Benutzerbilder erlauben?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': EMail ändern',
	'chmaila_body' => 
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt ihre EMail auf '.GWF_SITENAME.' zu ändern.'.PHP_EOL.
		'Um die Änderung abzuschliessen, folgen sie bitten dem Link unterhalb dieses Textes.'.PHP_EOL.
		'Falls sie die Änderung nicht selbst beantragt haben sollten, können sie diese Mail ignorieren, oder uns darüber informieren.'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': EMail bestätigen',
	'chmailb_body' => 
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Um diese EMail als ihre Kontakt-Addresse zu verwenden, müssen sie dies noch bestätigen indem sie den folgenden Link aufrufen:'.PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Demographische Einstellungen',
	'chdemo_body' =>
		'Liebe/Lieber %1%,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt ihre demographischen Einstellungen festzulegen oder zu ändern.'.PHP_EOL.
		'Dies können sie nur einmal alle %2% ausführen, also stellen sie bitte sicher, daß Ihre Angaben korrekt sind bevor sie fortfahren.'.PHP_EOL.
		PHP_EOL.
		'Geschlecht: %3%'.PHP_EOL.
		'Land: %4%'.PHP_EOL.
		'Muttersprache: %5%'.PHP_EOL.
		'Fremdsprache: %6%'.PHP_EOL.
		'Geburtstag: %7%'.PHP_EOL.
		PHP_EOL.
		'Wenn sie diese Einstellungen übernehmen möchten, rufen Sie bitte den folgenden Link auf:'.PHP_EOL.
		'%8%'.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',

	# New Flags 
	'th_allow_email' => 'Anderen Erlauben ihnen eine EMail zu senden',
	'msg_allow_email_on' => 'Ihnen kann nun über diese Webseite eine EMail gesendet werden, ohne ihre Addresse zu offenbaren.',
	'msg_allow_email_off' => 'EMail kontakt wurde für Ihr Konto deaktiviert.',
		
	'th_show_bday' => 'Ihren Geburtstag anzeigen?',
	'msg_show_bday_on' => 'Ihr Geburtstag wird nun Mitgliedern bekannt gegeben, welche dies möchten.',
	'msg_show_bday_off' => 'Ihr Geburtstag ist nun versteckt.',
		
	'th_show_obday' => 'Andere Geburtstage anzeigen',
	'msg_show_obday_on' => 'Sie werden von nun an über Geburtstage informiert.',
	'msg_show_obday_off' => 'Sie werden nun nicht mehr über Geburtstage informiert.',

	# v2.02 Account Deletion
	'pt_accrm' => 'Konto Löschen',
	'mt_accrm' => 'Ihr Konto auf '.GWF_SITENAME.' löschen.',
	'pi_accrm' =>
		'Sie möchten ihr Konto auf '.GWF_SITENAME.' löschen.<br/>'.
		'Das ist schade. Ihr Konto wird nicht vollständig gelöscht, aber alle Verweise werden entfernt und Ihr Konto ist danach unbrauchbar.<br/>'.
		'Alle Verknüpfungen und Verweise zu Ihrem Konto werden als Gast angezeigt, dies kann nicht rückgängig gemacht werden.<br/>'.
		'Bevor sie Ihr Konto entgültig löschen, können Sie uns eine Nachricht hinterlassen, falls sie mit uns unzufrieden waren.<br/>',
	'th_accrm_note' => 'Notiz',
	'btn_accrm' => 'Konto Löschen',
	'msg_accrm' => 'Ihr Konto wurde als gelöscht markiert. Alle Verweise wurden gelöscht.<br/>Sie wurden aus dem System ausgeloggt.',
	'ms_accrm' => GWF_SITENAME.': %1% Konto gelöscht',
	'mb_accrm' =>
		'Liebes Team'.PHP_EOL.
		''.PHP_EOL.
		'Der Benutzer %1% hat soeben sein Konto gelöscht und diese Nachricht hinterlassen (kann leer sein):'.PHP_EOL.PHP_EOL.
		'%2%',
		

	# v2.03 Email Options
	'th_email_fmt' => 'Preferred EMail Format',
	'email_fmt_text' => 'Plain Text',
	'email_fmt_html' => 'Simple HTML',
	'err_email_fmt' => 'Please select a valid EMail Format.',
	'msg_email_fmt_0' => 'You will now receive emails in simple html format.',
	'msg_email_fmt_4096' => 'You will now receive emails in plain text format.',
	'ft_gpg' => 'Setup PGP/GPG Encryption',
	'th_gpg_key' => 'Upload your public key',
	'th_gpg_key2' => 'Or paste it here',
	'tt_gpg_key' => 'When you have set a pgp key all the emails sent to you by the scripts are encrypted with your public key',
	'tt_gpg_key2' => 'Either paste your public key here, or upload your public key file.',
	'btn_setup_gpg' => 'Upload Key',
	'btn_remove_gpg' => 'Remove Key',
	'err_gpg_setup' => 'Either upload a file which contains your public key or paste your public key in the text area.',
	'err_gpg_key' => 'Your public key seems invalid.',
	'err_gpg_token' => 'Your gpg fingerprint token does not match our records.',
	'err_no_gpg_key' => 'The user %1% did not submit a public key yet.',
	'err_no_mail' => 'You don`t have an approved main contact email address.',
	'err_gpg_del' => 'You don`t have a validated GPG key to delete.',
	'err_gpg_fine' => 'You already have a GPG key. Please delete it first.',
	'msg_gpg_del' => 'Your GPG key has been deleted successfully.',
	'msg_setup_gpg' => 'Your GPG has been stored and is in use now.',
	'mails_gpg' => GWF_SITENAME.': Setup GPG Encryption',
	'mailb_gpg' =>
		'Dear %1%,'.PHP_EOL.
		PHP_EOL.
		'You have decided to turn on gpg encryption for emails sent by this robot.'.PHP_EOL.
		'To do so, follow the link below:'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%1%">Change your password</a>',
	'err_gpg_raw' => GWF_SITENAME.' does only support ascii armor format for your public GPG key.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',

);
?>

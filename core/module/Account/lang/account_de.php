<?php

$lang = array(

	# Titles
	'form_title' => 'Konto Einstellungen',
	'chmail_title' => 'Geben sie ihre neue EMail Adresse an',

	# Headers
	'th_username' => 'Ihr Nickname',
	'th_email' => 'Kontakt EMail',
	'th_demo' => 'Demographische Optionen - Diese können sie nur einmal alle %s ändern.',
	'th_countryid' => 'Land',	
	'th_langid' => 'Muttersprache',	
	'th_langid2' => '1. Fremdsprache',
	'th_birthdate' => 'Ihr Geburtsdatum',
	'th_gender' => 'Ihr Geschlecht',
	'th_flags' => 'Optionen - Änderungen sind jederzeit möglich',
	'th_adult' => 'Möchten sie Inhalt für Erwachsene?',
	'th_online' => 'Ihren Online Status verstecken?',
	'th_show_email' => 'EMail Adresse öffentlich sichtbar?',
	'th_avatar' => 'Ihr Benutzerbild',
	'th_approvemail' => '<b>Ihre EMail ist<br/>nicht bestätigt</b>',
	'th_email_new' => 'Ihre neue EMail Adresse',
	'th_email_re' => 'EMail Adresse wiederholen',

	# Buttons
	'btn_submit' => 'Änderungen übernehmen',
	'btn_approvemail' => 'EMail bestätigen',
	'btn_changemail' => 'Neue EMail festlegen',
	'btn_drop_avatar' => 'Benutzerbild löschen',

	# Errors
	'err_token' => 'Ungültiges Token.',
	'err_email_retype' => 'Sie müssen Ihre EMail korrekt wiederholen.',
	'err_delete_avatar' => 'Beim Löschen Ihres Benutzerbildes ist ein Fehler aufgetreten.',
	'err_no_mail_to_approve' => 'Sie haben keine EMail zum Bestätigen angegeben.',
	'err_already_approved' => 'Ihre EMail Adresse ist bereits bestätigt.',
	'err_no_image' => 'Datei ist kein Bild, oder zu klein.',
	'err_demo_wait' => 'Sie haben Ihre demographischen Einstellungen erst kürzlich geändert. Bitte warten sie %s.',
	'err_birthdate' => 'Ihr Geburtsdatum ist ungültig.',

	# Messages
	'msg_mail_changed' => 'Ihre EMail Adresse wurde geändert und lautet nun <b>%s</b>.',
	'msg_deleted_avatar' => 'Ihr Benutzerbild wurde gelöscht.',
	'msg_avatar_saved' => 'Ihr neues Benutzerbild wurde gespeichert.',
	'msg_demo_changed' => 'Ihre demographischen Einstellungen wurden erfolgreich geändert.',
	'msg_mail_sent' => 'Wir haben Ihnen eine EMail gesendet um die Änderungen vorzunehmen. Bitte folgen sie den Anweisungen dort.',
	'msg_show_email_on' => 'Ihre EMail ist nun öffentlich sichtbar.',
	'msg_show_email_off' => 'Ihre EMail ist nun versteckt.',
	'msg_adult_on' => 'Sie können nun Inhalte für Erwachsene sehen.',
	'msg_adult_off' => 'Inhalte für Erwachsene wurde deaktiviert.',
	'msg_online_on' => 'Ihr Online-Status ist nun unsichtbar.',
	'msg_online_off' => 'Ihr Online-Status ist nun sichtbar.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatar Max. Breite',
	'cfg_avatar_max_y' => 'Avatar Max. Höhe',
	'cfg_avatar_min_x' => 'Avatar Min. Breite',
	'cfg_avatar_min_y' => 'Avatar Min. Höhe',
	'cfg_adult_age' => 'Mindestalter für Erwachsenen-Inhalt',
	'cfg_demo_changetime' => 'Demographische Änderung Intervall',
	'cfg_mail_sender' => 'Absender für Kontoänderungen',
	'cfg_show_adult' => 'Webseite hat Inhalt f. Erwachsene?',
	'cfg_show_gender' => 'Geschlechts-Auswahl anzeigen?',
	'cfg_use_email' => 'Bestätigte EMail für Änderungen erforderlich?',
	'cfg_show_avatar' => 'Benutzerbilder erlauben?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': EMail ändern',
	'chmaila_body' => 
		'Liebe/Lieber %s,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt Ihre EMail auf '.GWF_SITENAME.' zu ändern.'.PHP_EOL.
		'Um die Änderung abzuschließen, folgen sie bitte dem Link unterhalb dieses Textes.'.PHP_EOL.
		'Falls sie die Änderung nicht selbst beantragt haben sollten, können sie diese Mail ignorieren, oder uns darüber informieren.'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': EMail bestätigen',
	'chmailb_body' => 
		'Liebe/Lieber %s,'.PHP_EOL.
		PHP_EOL.
		'Um diese EMail als ihre Kontakt-Adresse zu verwenden, müssen sie dies noch bestätigen indem sie den folgenden Link aufrufen:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Demographische Einstellungen',
	'chdemo_body' =>
		'Liebe/Lieber %s,'.PHP_EOL.
		PHP_EOL.
		'Sie haben angefragt ihre demographischen Einstellungen festzulegen oder zu ändern.'.PHP_EOL.
		'Dies können sie nur einmal alle %s ausführen, also stellen Sie bitte sicher, dass Ihre Angaben korrekt sind bevor sie fortfahren.'.PHP_EOL.
		PHP_EOL.
		'Geschlecht: %s'.PHP_EOL.
		'Land: %s'.PHP_EOL.
		'Muttersprache: %s'.PHP_EOL.
		'Fremdsprache: %s'.PHP_EOL.
		'Geburtstag: %s'.PHP_EOL.
		PHP_EOL.
		'Wenn Sie diese Einstellungen übernehmen möchten, rufen Sie bitte den folgenden Link auf:'.PHP_EOL.
		'%s'.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',

	# New Flags 
	'th_allow_email' => 'Anderen Erlauben ihnen eine EMail zu senden',
	'msg_allow_email_on' => 'Ihnen kann nun über diese Webseite eine EMail gesendet werden, ohne ihre Adresse zu offenbaren.',
	'msg_allow_email_off' => 'EMail Kontakt wurde für Ihr Konto deaktiviert.',
		
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
		'Bevor sie Ihr Konto endgültig löschen, können Sie uns eine Nachricht hinterlassen, falls sie mit uns unzufrieden waren.<br/>',
	'th_accrm_note' => 'Notiz',
	'btn_accrm' => 'Konto Löschen',
	'msg_accrm' => 'Ihr Konto wurde als gelöscht markiert. Alle Verweise wurden gelöscht.<br/>Sie wurden aus dem System ausgeloggt.',
	'ms_accrm' => GWF_SITENAME.': %s Konto gelöscht',
	'mb_accrm' =>
		'Liebes Team'.PHP_EOL.
		''.PHP_EOL.
		'Der Benutzer %s hat soeben sein Konto gelöscht und diese Nachricht hinterlassen (kann leer sein):'.PHP_EOL.PHP_EOL.
		'%s',
		

	# v2.03 Email Options
	'th_email_fmt' => 'Bevorzugtes EMail Format',
	'email_fmt_text' => 'Text',
	'email_fmt_html' => 'Einfaches HTML',
	'err_email_fmt' => 'Bitte wählen Sie ein gültiges EMail Format.',
	'msg_email_fmt_0' => 'Sie werden in Zukunft EMail im HTML Format erhalten.',
	'msg_email_fmt_4096' => 'Sie werden in Zukunft EMail im Text Format erhalten.',
	'ft_gpg' => 'PGP/GPG Verschlüsselung einrichten',
	'th_gpg_key' => 'Laden Sie ihren öffentlichen Schlüssel hoch',
	'th_gpg_key2' => 'Oder fügen Sie ihn hier ein',
	'tt_gpg_key' => 'Wenn Sie einen PGP Schlüssel gesetzt haben werden alle zukünftigen EMails an Sie verschlüsselt gesendet.',
	'tt_gpg_key2' => 'Fügen Sie Ihren öffentlichen Schlüssel hier ein oder laden Sie ihn als Datei hoch.',
	'btn_setup_gpg' => 'Schlüssel hochladen',
	'btn_remove_gpg' => 'Schlüssel löschen',
	'err_gpg_setup' => 'Sie müssen einen Schlüssel angeben.',
	'err_gpg_key' => 'Ihr Schlüssel scheint ungültig zu sein.',
	'err_gpg_token' => 'Ihr GPG Fingerabdruck passt nicht zu unseren Aufzeichnungen.',
	'err_no_gpg_key' => 'Der Benutzer %s hat noch keinen öffentlichen Schlüssel angegeben.',
	'err_no_mail' => 'Sie haben keine bestätigte Haupt-EMail-Adresse.',
	'err_gpg_del' => 'Sie haben keinen bestätigten GPG Schlüssel der gelöscht werden könnte.',
	'err_gpg_fine' => 'Sie haben bereits einen GPG Schlüssel. Bitte löschen Sie diesen zuerst.',
	'msg_gpg_del' => 'Ihr GPG Schlüssel wurde erfolgreich gelöscht.',
	'msg_setup_gpg' => 'Ihr GPG Schlüssel wurde gespeichert und ab jetzt verwendet.',
	'mails_gpg' => GWF_SITENAME.': GPG Verschlüsselung einrichten',
	'mailb_gpg' =>
		'Liebe/Lieber %s,'.PHP_EOL.
		PHP_EOL.
		'Sie wollen die GPG Verschlüsselung für unsere EMails aktivieren.'.PHP_EOL.
		'Klicken Sie zum Bestätigen auf den folgenden Link:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Freundliche Grüße'.PHP_EOL.
		'Das '.GWF_SITENAME.' Team',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%s">Passwort ändern</a>',
	'err_gpg_raw' => GWF_SITENAME.' unterstützt nur das ASCII Armor Format für GPG Schlüssel.',
	# v2.05 (fixes)
	'btn_delete' => 'Account löschen',
	'err_email_invalid' => 'Ihre EMail scheint ungültig zu sein.',

	# v3.00 (fixes3)
	'err_email_taken' => 'Diese EMail wird bereits von einem anderen Profil benutzt.',
);
?>

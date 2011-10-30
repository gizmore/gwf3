<?php
$lang = array(
	# Page Titles
	'pt_list' => 'Download Bereich',
	'mt_list' => 'Download Bereich, Downloads, Exklusive Downloads, '.GWF_SITENAME,
	'md_list' => 'Exklusive Downloads auf '.GWF_SITENAME.'.',

	# Page Info
	'pi_add' => 'Am besten laden Sie zuerst Ihre Datei hoch. Diese wird dann in Ihrer Session gespeichert. Danach können Sie weiterhin Optionen ändern.<br/>Die maximale Dateigröße beträgt %1$s.',

	# Form Titles
	'ft_add' => 'Eine Datei hochladen',
	'ft_edit' => 'Download bearbeiten',
	'ft_token' => 'Geben sie ihren Download-Code ein',

	# Errors
	'err_file' => 'Sie müssen eine Datei hochladen.',
	'err_filename' => 'Der Dateiname ist ungültig. Die maximale Namenslänge beträgt %1$s Zeichen.',
	'err_level' => 'Der Benutzer-Level muss >= 0 sein.',
	'err_descr' => 'Die Beschreibung muss zwischen 0 und %1$s Zeichen lang sein.',
	'err_price' => 'Der Preis muss zwischen %1$s und %2$s betragen.',
	'err_dlid' => 'Der Download wurde nicht gefunden.',
	'err_token' => 'Ihr Download-Code ist ungültig.',

	# Messages
	'prompt_download' => 'Wählen sie OK um die Datei herunter zu laden.',
	'msg_uploaded' => 'Ihre Datei wurde erfolgreich hochgeladen.',
	'msg_edited' => 'Der Download wurde erfolgreich bearbeitet.',
	'msg_deleted' => 'Der Download wurde erfolgreich gelöscht.',

	# Table Headers
	'th_dl_filename' => 'Dateiname',
	'th_file' => 'Datei',
	'th_dl_id' => 'ID ',
	'th_dl_gid' => 'Benötigte Gruppe',
	'th_dl_level' => 'Benötigter Level',
	'th_dl_descr' => 'Beschreibung',
	'th_dl_price' => 'Preis',
	'th_dl_count' => 'Zugriffe',
	'th_dl_size' => 'Dateigröße',
	'th_user_name' => 'Verantwortlich',
	'th_adult' => 'Erwachseneninhalt',
	'th_huname' => 'Uploader verstecken?',
	'th_vs_avg' => 'Bewerten',
	'th_dl_expires' => 'Verfällt am',
	'th_dl_expiretime' => 'Download ist gültig für',
	'th_paid_download' => 'Sie müssen eine Zahlung leisten um diese Datei herunterzuladen.',
	'th_token' => 'Download Code',

	# Buttons
	'btn_add' => 'Hinzufügen',
	'btn_edit' => 'Editieren',
	'btn_delete' => 'Löschen',
	'btn_upload' => 'Hochladen',
	'btn_download' => 'Downloaden',
	'btn_remove' => 'Entfernen',

	# Admin config
	'cfg_anon_downld' => 'Gast Downloads erlauben',
	'cfg_anon_upload' => 'Gast Uploads erlauben',
	'cfg_user_upload' => 'User Uploads erlauben',
	'cfg_dl_gvotes' => 'Gast Votings erlauben',	
	'cfg_dl_gcaptcha' => 'Upload Captcha für Gäste',	
	'cfg_dl_descr_max' => 'Max. Länge der Beschreibung',
	'cfg_dl_descr_min' => 'Min. Länge der Beschreibung',
	'cfg_dl_ipp' => 'Downloads pro Seite',
	'cfg_dl_maxvote' => 'Max. Votescore',
	'cfg_dl_minvote' => 'Min. Votescore',

	# Order
	'order_title' => 'Download-Code für %1$s (Code: %2$s)',
	'order_descr' => 'Erworbenes Download-Token für %1$s. Gültig für %2$s. Code: %3$s',
	'msg_purchased' => 'Wir haben ihre Zahlung erhalten und ein Download-Code wurde erzeugt.<br/>Ihr Code lautet \'%1$s\' und ist für %2$s gültig.<br/><b>Schreiben Sie Ihren Code auf, falls Sie kein Konto auf '.GWF_SITENAME.' haben!</b><br/>Ansonsten loggen Sie sich bitte ein und <a href="%3$s">rufen den Download-Link auf</a>.',

	# v2.01 (+col)
	'th_purchases' => 'Käufe',

	# v2.02 Expire + finish ;P
	'err_dl_expire' => 'Die Vorhaltezeit muss zwischen 0 Sekunden und 5 Jahren betragen.',
	'th_dl_expire' => 'Download läuft ab nach',
	'tt_dl_expire' => 'Vorhaltezeit als zeitlicher Ausdruck. Zum Beispiel 5s oder 1 month 3 days.',
	'th_dl_guest_view' => 'Für Gäste sichtbar?',
	'tt_dl_guest_view' => 'Können Gäste den Download sehen?',
	'th_dl_guest_down' => 'Gast Download?',
	'tt_dl_guest_down' => 'Können Gäste den Download herunterladen?',
	'ft_reup' => 'Datei neu hochladen',
	'order_descr2' => 'Erworbener Download-Code für %1$s. Code: %2$s.',
	'msg_purchased2' => 'Wir haben ihre Zahlung erhalten und ein Download-Code wurde erzeugt.<br/>Ihr Code lautet \'%1$s\'.<br/><b>Schreiben Sie Ihren Code auf, falls Sie kein Konto auf '.GWF_SITENAME.' haben!</b><br/>Ansonsten loggen Sie sich bitte ein und <a href="%2$s">rufen den Download-Link auf</a>.',
	'err_group' => 'Sie müssen sich in der Benutzergruppe &quot;%1$s&quot; befinden, um diese Datei herunterzuladen.',
	'err_level' => 'Sie benötigen einen Benutzerlevel von %1$s, um diese Datei herunterzuladen.',
	'err_guest' => 'Gäste dürfen diese Datei nicht herunterladen.',
	'err_adult' => 'Dieser Inhalt ist für Erwachsene.',

	'th_dl_date' => 'Datum',

	# GWF3v1.1
	'cfg_dl_min_level' => 'Minimum userlevel for an upload',
	'cfg_dl_moderated' => 'Require moderators to unlock uploads?',
	'cfg_dl_moderators' => 'Usergroup for upload moderators.',
	'th_enabled' => 'Enabled?',
	'err_disabled' => 'This download isn\'t enabled yet.',
	'msg_enabled' => 'The download has been enabled.',
	'msg_uploaded_mod' => 'Your file has been uploaded successfully, but has to be reviewed before it is released.',

	'mod_mail_subj' => GWF_SITENAME.': Upload Moderation',
	'mod_mail_body' =>
		'Dear %1$s'.PHP_EOL.
		PHP_EOL.
		'There has been a new file uploaded to '.GWF_SITENAME.' which requires moderation.'.PHP_EOL.
		PHP_EOL.
		'From: %2$s'.PHP_EOL.
		'File: %3$s (%4$s)'.PHP_EOL.
		'Mime: %5$s'.PHP_EOL.
		'Size: %6$s'.PHP_EOL.
		'Desc: %7$s'.PHP_EOL.
		PHP_EOL.
		'You can download the file here:'.PHP_EOL.
		'%8$s'.PHP_EOL.
		PHP_EOL.
		'You can allow the download here:'.PHP_EOL.
		'%9$s'.PHP_EOL.
		PHP_EOL.
		'You can delete the download here:'.PHP_EOL.
		'%10$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' script!',
);
?>
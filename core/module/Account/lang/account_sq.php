<?php
$lang = array(
	# Titles
	'form_title' => 'Account Settings',
	'chmail_title' => 'Jepuni atyre të reja adresë të tyre',

	# Headers
	'th_username' => 'Emri juaj',
	'th_email' => 'Kontakt Email',
	'th_demo' => 'Demografike Options - Kjo mund të ndryshojë vetëm një herë në çdo %1 herë.',
	'th_countryid' => 'Vend',	
	'th_langid' => 'Gjuha amtare',	
	'th_langid2' => '1. Gjuhë e huaj',
	'th_birthdate' => 'Data juaj e lindjes',
	'th_gender' => 'Seksi juaj',
	'th_flags' => 'Mundësitë e zgjedhjes - janë subjekt i ndryshimit',
	'th_adult' => 'Doni te rritur?',
	'th_online' => 'Fshih statusin tuaj online?',
	'th_show_email' => 'Email addresse publikisht të dukshme?',
	'th_avatar' => 'Shiko juaj',
	'th_approvemail' => '<b>Emaili juaj <br/>nuk është konfirmuar </b>',
	'th_email_new' => 'Adresa juaj e Email të reja',
	'th_email_re' => 'Email Adresa përsëri',

	# Buttons
	'btn_submit' => 'Apliko ndryshimet',
	'btn_approvemail' => 'Konfirmo Email',
	'btn_changemail' => 'Email të reja Set',
	'btn_drop_avatar' => 'Shiko Fshije',

	# Errors
	'err_token' => 'Shenjë e pavlefshme.',
	'err_email_retype' => 'Ju duhet të përsëris email-it tuaj të saktë.',
	'err_delete_avatar' => 'Ndesha në një gabim gjatë fshirjes avatar tuaj.',
	'err_no_mail_to_approve' => 'Ju keni specifikuar asnjë email për të konfirmuar.',
	'err_already_approved' => 'Adresa juaj e emailit është e konfirmuar tashmë.',
	'err_no_image' => 'Skedari juaj ngarkuar nuk është një foto, apo shumë e vogël.',
	'err_demo_wait' => 'Ju keni ndryshuar parametrat e juaj demografike kohët e fundit. Ju lutem prisni %s.',
	'err_birthdate' => 'data juaj e lindjes është i pavlefshëm.',

	# Messages
	'msg_mail_changed' => 'Adresa juaj e emailit ka ndryshuar dhe tani lexon <b>%s</b>.',
	'msg_deleted_avatar' => 'Avatar juaj është fshirë.',
	'msg_avatar_saved' => 'Avatar juaj i ri është ruajtur.',
	'msg_demo_changed' => 'Parametrat e demografike u ndryshuan me sukses.',
	'msg_mail_sent' => 'Ne kemi dërguar një email për të bërë ndryshime. Ju lutem ndiqni udhëzimet atje.',
	'msg_show_email_on' => 'Emaili juaj tani është e dukshme publikisht.',
	'msg_show_email_off' => 'Emaili juaj është e fshehur tani.',
	'msg_adult_on' => 'Ju tani mund të shikojnë përmbajtjen e të rritur.',
	'msg_adult_off' => 'Përmbajtje për të rritur ka qenë me aftësi të kufizuara.',
	'msg_online_on' => 'Statusi juaj online tani është e padukshme.',
	'msg_online_off' => 'Statusi juaj online tani është i dukshëm.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatar Gjerësia Max.',
	'cfg_avatar_max_y' => 'Avatar lartësi Max.',
	'cfg_avatar_min_x' => 'Avatar Gjerësia Min.',
	'cfg_avatar_min_y' => 'Lartësia minimale Avatar',
	'cfg_adult_age' => 'Moshën minimale për të rritur përmbajtjen e',
	'cfg_demo_changetime' => 'Intervali demografike Ndryshimi',
	'cfg_mail_sender' => 'Sender llogari për ndryshime',
	'cfg_show_adult' => 'Website ka përmbajtje për të rriturit?',
	'cfg_show_gender' => 'Shih-përzgjedhje seksi?',
	'cfg_use_email' => 'Email konfirmoi për ndryshimet e nevojshme?',
	'cfg_show_avatar' => 'Avataret të lejuar?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Ndrysho Email',
	'chmaila_body' => 
		'Të nderuar %s,'.PHP_EOL.
		PHP_EOL.
		'Ju keni kerkuar te adresën e tyre '.GWF_SITENAME.' ndryshim.'.PHP_EOL.
		'Për të përfunduar të ndryshuar, ndiqni lidhjen e mëposhtme për të kërkuar këtë tekst.'.PHP_EOL.
		'Nëse ata ndryshojnë veten e tyre nuk duhet të ketë aplikuar, ata mund të injorojë këtë email, apo na tregoni rreth tij.'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Te mire'.PHP_EOL.
		''.GWF_SITENAME.' Teami',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Konfirmo Email',
	'chmailb_body' => 
		'Të nderuar %s,'.PHP_EOL.
		PHP_EOL.
		'Për të përdorur këtë adresë email-it si kontakt i tyre, ata ende duhet të konfirmojë këtë duke vizituar lidhjen e mëposhtme:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Te mire'.PHP_EOL.
		GWF_SITENAME.' Teami',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Cilësimet e demografike',
	'chdemo_body' =>
		'Të nderuar %s,'.PHP_EOL.
		PHP_EOL.
		'Ju keni kërkuar të përcaktojë parametrat e tyre demografik, ose ndryshoni ato.'.PHP_EOL.
		'Kjo ata mund të drejtuar vetëm një herë në çdo %2, në mënyrë që ata të siguruar që të dhënat tuaja janë të sakta para se të vazhdoni.'.PHP_EOL.
		PHP_EOL.
		'Seksi: %s'.PHP_EOL.
		'Vend: %s'.PHP_EOL.
		'Gjuha amtare: %s'.PHP_EOL.
		'Gjuhë e huaj: %s'.PHP_EOL.
		'Ditëlindje: %s'.PHP_EOL.
		PHP_EOL.
		'Nëse ata duan të aplikojnë këto rregullime, ju lutemi telefononi në lidhjen e mëposhtme:'.PHP_EOL.
		'%s'.
		PHP_EOL.
		'Te mire'.PHP_EOL.
		''.GWF_SITENAME.' Teami',

	# New Flags 
	'th_allow_email' => 'Të tjerë të lejojë që ata të dërgoni një email',
	'msg_allow_email_on' => 'Ju tani mund të dërgohet një email përmes kësaj faqe interneti pa zbuluar adresën e tyre.',
	'msg_allow_email_off' => 'Email këtë kontakt ka qenë i paaftë për llogarinë tuaj.',
		
	'th_show_bday' => 'tregojnë juaj ditëlindjen?',
	'msg_show_bday_on' => 'ditëlindjen e juaj tani do të anëtarëve njoftoi se do të donte.',
	'msg_show_bday_off' => 'ditëlindjen e juaj është e fshehur tani.',
		
	'th_show_obday' => 'ditëlindje të tjera',
	'msg_show_obday_on' => 'Ju do të informohen për ditëlindje nga tani e tutje.',
	'msg_show_obday_off' => 'Ata tani janë jo më shumë të informuar për ditëlindje.',

	# v2.02 Account Deletion
	'pt_accrm' => 'Fshije Account',
	'mt_accrm' => 'Llogaria juaj '.GWF_SITENAME.' fshij.',
	'pi_accrm' =>
		'Ata duan llogarinë e tyre të '.GWF_SITENAME.' fshije.<br/>'.
		'Ky është një turp. Llogaria juaj nuk është i fshi plotësisht, por të gjitha referencat janë larguar dhe llogarinë tuaj është pastaj papërdorshme.<br/>'.
		'Të gjitha lidhjet dhe referencat në llogarinë tuaj në një mysafir i menjëhershëm, kjo nuk mund të zhbëhet.<br/>'.
		'Para se të fshij llogarinë tuaj përfundimtar, ju mund të lënë një mesazh në qoftë se ata ishin të pakënaqur me ne.<br/>',
	'th_accrm_note' => 'Shënim',
	'btn_accrm' => 'Fshije Account',
	'msg_accrm' => 'Llogaria juaj është shënuar si të grisur. Të gjitha referencat ishin të fshihet.<br/>Ata ishin të çregjistrohesh nga sistemi.',
	'ms_accrm' => GWF_SITENAME.': %s Account te fishiur',
	'mb_accrm' =>
		'Liebes Team'.PHP_EOL.
		''.PHP_EOL.
		'Perdoruesi %s ka fshirë vetëm llogarinë e tij dhe e la kete mesazh (mund të jetë bosh):'.PHP_EOL.PHP_EOL.
		'%s',

		
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
	'err_no_gpg_key' => 'The user %s did not submit a public key yet.',
	'err_no_mail' => 'You don`t have an approved main contact email address.',
	'err_gpg_del' => 'You don`t have a validated GPG key to delete.',
	'err_gpg_fine' => 'You already have a GPG key. Please delete it first.',
	'msg_gpg_del' => 'Your GPG key has been deleted successfully.',
	'msg_setup_gpg' => 'Your GPG has been stored and is in use now.',
	'mails_gpg' => GWF_SITENAME.': Setup GPG Encryption',
	'mailb_gpg' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'You have decided to turn on gpg encryption for emails sent by this robot.'.PHP_EOL.
		'To do so, follow the link below:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%s">Change your password</a>',
	'err_gpg_raw' => GWF_SITENAME.' does only support ascii armor format for your public GPG key.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',
	# v3.00 (fixes3)
	'err_email_taken' => 'This email address is already in use.',
	# v3.01 (record IPs)
	'btn_record_enable' => 'IP Recording',
	'mail_signature' => GWF_SITENAME.' Security Robot',
	'mails_record_disabled' => GWF_SITENAME.': IP Recording',
	'mailv_record_disabled' => 'IP recording has been disabled for your account.',
	'mails_record_alert' => GWF_SITENAME.': Security Alert',
	'mailv_record_alert' => 'There has been access to your account via an unknown UserAgent or an unknown/suspicious IP.',
	'mailb_record_alert' =>
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'UserAgent: %s'.PHP_EOL.
		'IP address: %s'.PHP_EOL.
		'Hostname: %s'.PHP_EOL.
		PHP_EOL.
		'You can ignore this Email safely or maybe you like to review all IPs:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The %s'.PHP_EOL,
	# 4 Checkboxes
	'th_record_ips' => 'Monitor <a href="%s">IP access</a>',
	'tt_record_ips' => 'Record access to your account by IP so you can review it. Entries cannot be deleted!',
	'msg_record_ips_on' => 'All unique IP Addresses using your account are now lieftime recorded. This is your last change to quit. You can of course pause recording anytime.',
	'msg_record_ips_off' => 'You have disabled IP recording for your account.',
	#
	'th_alert_uas' => 'Alert on UA change',
	'tt_alert_uas' => 'Sends you an email when your UserAgent changes. (recommended)',
	'msg_alert_uas_on' => 'Security Alert Email will be sent when your User Agent changes. Recording needs to be enabled.',
	'msg_alert_uas_off' => 'User Agent changes are now ignored.',
	#
	'th_alert_ips' => 'Alert on IP change',
	'tt_alert_ips' => 'Sends you an email when ´your´ IP changes. (recommended)',
	'msg_alert_ips_on' => 'Security Alert Email will be sent when your IP changes. Recording needs to be enabled.',
	'msg_alert_ips_off' => 'IP changes are now ignored.',
	#	
	'th_alert_isps' => 'Alert on ISP change',
	'tt_alert_isps' => 'Sends you an email when your ISP / hostname changes. (not recommended)',
	'msg_alert_isps_on' => 'Security Alert Email will be sent when your hostname changes significantly. Recording needs to be enabled.',
	'msg_alert_isps_off' => 'ISP/hostname changes are now ignored.',

	'th_date' => 'Date',
	'th_ua' => 'UserAgent',
	'th_ip' => 'IP Address',
	'th_isp' => 'Hostname',
);

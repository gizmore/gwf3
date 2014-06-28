<?php
$lang = array(

	# Titles
	'form_title' => 'Kasutaja seaded',
	'chmail_title' => 'Kirjuta enda uus e-mail',

	# Headers
	'th_username' => 'Sinu kasutajanimi',
	'th_email' => 'Kontaktmeil',
	'th_demo' => 'Demograafilised seaded - Saad neid muuta ainult korra %s jooksul.',
	'th_countryid' => 'Riik',	
	'th_langid' => 'Emakeel',	
	'th_langid2' => 'Muu võõrkeel, mida oskad',
	'th_birthdate' => 'Sünnipäev',
	'th_gender' => 'Sugu',
	'th_flags' => 'Seaded - saad neid hiljem muuta',
	'th_adult' => 'Soovid näha täiskasvanutele mõeldud sisu?',
	'th_online' => 'Kas soovid teistele näidata, kui oled online?',
	'th_show_email' => 'Kas soovid, et teised näeksid su e-maili?',
	'th_avatar' => 'Sinu avatar',
	'th_approvemail' => '<b>Sinu e-mail ei ole<br/>heakskiidetud</b>',
	'th_email_new' => 'Sinu uus Email',
	'th_email_re' => 'Kirjuta uuesti Email',

	# Buttons
	'btn_submit' => 'Salvestamise võimalused',
	'btn_approvemail' => 'Kinnita EMail',
	'btn_changemail' => 'Muuda Email',
	'btn_drop_avatar' => 'Kustuta avatar',

	# Errors
	'err_token' => 'Vigaselt võetud',
	'err_email_retype' => 'Pead uuesti kirjutama oma e-maili',
	'err_delete_avatar' => 'Viga avastatud eemaldades su avatari',
	'err_no_mail_to_approve' => 'Sa pole oma e-maili kirjutanud',
	'err_already_approved' => 'Su e-mail on juba heakskiidetud.',
	'err_no_image' => 'Sinu üleslaaditud fail pole pilt, või on liiga väike',
	'err_demo_wait' => 'Sa muutsid oma demograafilisi seadeid hiljuti. Palun oota %s.',
	'err_birthdate' => 'Su sünnipäev on vigane',

	# Messages
	'msg_mail_changed' => 'Sinu kontaktmeil peab olema muudetud <b>%s</b>.',
	'msg_deleted_avatar' => 'Sinu avatari pilt on eemaldatud',
	'msg_avatar_saved' => 'Sinu uus avatar on salvestatud.',
	'msg_demo_changed' => 'Sinu demograafilised uuendused on muudetud.',
	'msg_mail_sent' => 'Saatsime sulle meili et oma muudatusi salvestada. Palun järgi sealseid instruktsioone.',
	'msg_show_email_on' => 'Sinu Email on nüüd teistele näha.',
	'msg_show_email_off' => 'Sinu Emaili pole enam teistele näha.',
	'msg_adult_on' => 'Sinu kasutaja saab nüüd täiskasvanutele mõeldud sisu näha.',
	'msg_adult_off' => 'Sinu kasutaja ei saa näha täiskasvanutele mõeldud sisu.',
	'msg_online_on' => 'Sinu online-staatust pole enam näha teistele',
	'msg_online_off' => 'Sinu online-staatust on võimalik ka teistel näha.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatari maksimum laius',
	'cfg_avatar_max_y' => 'Avatari maksimum kõrgus',
	'cfg_avatar_min_x' => 'Avatari miinimum laius',
	'cfg_avatar_min_y' => 'Avatari miinimum kõrgus',
	'cfg_adult_age' => 'Miinimum vanus täiskasvanute sisu vaatamiseks',
	'cfg_demo_changetime' => 'Demograafilise muudatuse time-out',
	'cfg_mail_sender' => 'Kasutaja muudatuse emaili-saatja',
	'cfg_show_adult' => 'Sait omab täiskasvanute sisu?',
	'cfg_show_gender' => 'Kas näidata sugu valimise võimalust?',
	'cfg_use_email' => 'Nõuda emaili, et muuta seadeid?',
	'cfg_show_avatar' => 'Näidata avatari üleslaadimist?',

############################
# --- EMAIL SIIA ALLA --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Muuda oma EMail',
	'chmaila_body' => 
		'Austatud %s,'.PHP_EOL.
		PHP_EOL.
		'Sa avaldasid soovi muuta oma e-mail '.GWF_SITENAME.'.'.PHP_EOL.
		'Et seda teha, pead sa vajutama järgneval lingil.'.PHP_EOL.
		'Juhul kui sa ei soovinud oma maili muuta, võid seda meili ignoreerida või meile teada anda.'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Parimate soovidega,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Kinnita oma Email',
	'chmailb_body' => 
		'Austatud %s,'.PHP_EOL.
		PHP_EOL.
		'Et kasutada seda meili kui oma põhilist meili, pead selle kinnitama vajutades alloleval lingil:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Parimate soovidega'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Muuda demograafilisi seadeid',
	'chdemo_body' =>
		'Dear %s'.PHP_EOL.
		PHP_EOL.
		'Oled avaldanud soovi häälestada või muuta oma demograafilisi seadeid.'.PHP_EOL.
		'Sa saad teha seda ainult %s jooksul, seega palun ole kindel, et info on õige, enne kui jätkad.'.PHP_EOL.
		PHP_EOL.
		'Sugu: %s'.PHP_EOL.
		'Riik: %s'.PHP_EOL.
		'Emakeel: %s'.PHP_EOL.
		'Muu võõrkeel, mida oskad: %s'.PHP_EOL.
		'Sünnikuupäev: %s'.PHP_EOL.
		PHP_EOL.
		'Kui soovid neid seadistusi jätta, vajuta järgneval lingil:'.PHP_EOL.
		'%s'.
		PHP_EOL.
		'Parimate soovidega'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',

	# New Flags 
	'th_allow_email' => 'Luba teistel endale Emaile saata',
	'msg_allow_email_on' => 'Teised kasutajad saavad nüüd saata sulle emaili ilma seda rikkumata.',
	'msg_allow_email_off' => 'EMail kontakt välja lülitatud.',
		
	'th_show_bday' => 'Näita teistele oma sünnipäeva',
	'msg_show_bday_on' => 'Sinu sünnipäev on nüüd näha teistele.',
	'msg_show_bday_off' => 'Sinu sünnipäeva pole enam näha.',
		
	'th_show_obday' => 'Näita teiste kasutajate sünnipäevi',
	'msg_show_obday_on' => 'Sa saad nüüd näha teiste sünnipäevi.',
	'msg_show_obday_off' => 'Sa ei saa näha teiste sünnipäevi enam.',
		
	# v2.02 Account Deletion
	'pt_accrm' => 'Kustuta oma kasutaja',
	'mt_accrm' => 'Kustuta oma kasutaja lehelt '.GWF_SITENAME,
	'pi_accrm' =>
		'Tundub, et Sa soovid oma kasutaja kustutada '.GWF_SITENAME.'.<br/>'.
		'Meil on kurb seda kuulda, muide Su kasutajat ei kaotata, vaid blokeeritakse.<br/>'.
		'Kõik lingid ja profiilid sellele kasutajale muutuvad kasutamatuks või "külalise" nimele. See on pöördumatu..<br/>'.
		'Enne kui oma kasutaja blokeerid, soovid ehk meile midagi öelda või põhjendada oma kasutaja kustutamist .<br/>',
	'th_accrm_note' => 'Märge',
	'btn_accrm' => 'Kustuta kasutaja',
	'msg_accrm' => 'Sinu kasutaja on märgitud kustutatuks ja kõik viited peaksid olema kustutatud.<br/>Oled välja logitud',
	'ms_accrm' => GWF_SITENAME.': %s kasutaja kustutamine',
	'mb_accrm' =>
		'Austatud staff'.PHP_EOL.
		''.PHP_EOL.
		'Kasutaja %s kustutas just oma kasutaja ja jättis selle teate (may_be_empty):'.PHP_EOL.PHP_EOL.
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

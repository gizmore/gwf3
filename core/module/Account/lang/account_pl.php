<?php
$lang = array(
	# Titles
	'form_title' => 'Ustawienia konta',
	'chmail_title' => 'Wprowadź nowy email',

	# Headers
	'th_username' => 'Twoja nazwa użytkownika',
	'th_email' => 'Email kontaktowy',
	'th_demo' => 'Ustawienia główne - Możesz je zmienić tylko raz na %s.',
	'th_countryid' => 'Kraj',	
	'th_langid' => 'Język główny',	
	'th_langid2' => 'Język dodatkowy',
	'th_birthdate' => 'Data urodzin',
	'th_gender' => 'Twoja płeć',
	'th_flags' => 'Opcje - Możesz przełączać je w locie',
	'th_adult' => 'Czy chcesz widzieć zawartość tylko dla dorosłych?',
	'th_online' => 'Ukryć twój status zalogowania?',
	'th_show_email' => 'Pokaż email innym użytkownikom?',
	'th_avatar' => 'Twój awatar',
	'th_approvemail' => '<b>Twój email jest<br/>nie zatwierdzony</b>',
	'th_email_new' => 'Twój nowy email',
	'th_email_re' => 'Powtórz email',

	# Buttons
	'btn_submit' => 'Zapisz ustawienia',
	'btn_approvemail' => 'Zatwierdź email',
	'btn_changemail' => 'Ustaw nowy email',
	'btn_drop_avatar' => 'Usuń awatara',

	# Errors
	'err_token' => 'Niewłaściwy token.',
	'err_email_retype' => 'Podane adresy email nie są takie same.',
	'err_delete_avatar' => 'Wystąpił błąd podczas usuwania awatara.',
	'err_no_mail_to_approve' => 'Nie masz ustawionego emaila do zatwierdzenia.',
	'err_already_approved' => 'Twój email jest już zatwierdzony.',
	'err_no_image' => 'Wysłany przez ciebie plik nie jest obrazem lub jest za mały.',
	'err_demo_wait' => 'Już zmieniłeś(aś) swoje główne ustawienia. Odczekaj %s.',
	'err_birthdate' => 'Twoja data urodzin jest niepoprawna.',

	# Messages
	'msg_mail_changed' => 'Twój email kontaktowy został zmieniony na <b>%s</b>.',
	'msg_deleted_avatar' => 'Twój awatar został usunięty.',
	'msg_avatar_saved' => 'Twój nowy awatar został zapisany.',
	'msg_demo_changed' => 'Twoje ustawienia główne zostały zmienione.',
	'msg_mail_sent' => 'Wysłałliśmy email w celu potwierdzenia zmian - w nim znajdują sie dalsze instrukcje.',
	'msg_show_email_on' => 'Twoj email bedzie widoczny dla innych użytkowników.',
	'msg_show_email_off' => 'Twój email bedzie ukryty przed innymi użytkownikami.',
	'msg_adult_on' => 'Twoje konto umożliwia przeglądanie zawartości tylko dla dorosłych.',
	'msg_adult_off' => 'Zawartość dla dorosłych będzie dla ciebie ukryta.',
	'msg_online_on' => 'Twój status zalogowania jest ukryty.',
	'msg_online_off' => 'Twój status zalogowania jest jawny.',

	# Admin Config
	'cfg_avatar_max_x' => 'Maksymalna szerokość obrazka',
	'cfg_avatar_max_y' => 'Maksymalna wysokość obrazka',
	'cfg_avatar_min_x' => 'Minimalna szerokość obrazka',
	'cfg_avatar_min_y' => 'Minimalna wysokość obrazka',
	'cfg_adult_age' => 'Minimalny wiek umożliwiający przeglądanie zawartości dla dorosłych',
	'cfg_demo_changetime' => 'Opóźnienie zmiany ustawień głównych',
	'cfg_mail_sender' => 'Nadawaca emaili potwerdzających',
	'cfg_show_adult' => 'Strona zawiera materiały dla dorosłych?',
	'cfg_show_gender' => 'Pokazać wybraną płeć?',
	'cfg_use_email' => 'Wymagać emaila do zmiany ustawień konta?',
	'cfg_show_avatar' => 'Pokazać przesłany awatar?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Zmień adres email.',
	'chmaila_body' => 
		'Drogi %s,'.PHP_EOL.
		PHP_EOL.
		'Zażądałeś zmiany adresu email na stronie '.GWF_SITENAME.','.PHP_EOL.
		'aby to zrobić musisz odwiedzieć poniższy adres URL.'.PHP_EOL.
		'Jeśli nie żądałeś zmiany adresu email możesz zignorować tą wiadomość lub poinformować nas o tym.'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Pozdrawia'.PHP_EOL.
		'Ekipa '.GWF_SITENAME,
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Potwierdź swój adres email',
	'chmailb_body' => 
		'Drogi %s,'.PHP_EOL.
		PHP_EOL.
		
		'Aby używać tego adresu email jako głównego adresu kontaktowego musisz potiwerdzić go odwiedzając poniższy adres URL:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Pozdrawia'.PHP_EOL.
		'Ekipa '.GWF_SITENAME,
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Zmień ustawienia główne',
	'chdemo_body' =>
		'Drogi %s'.PHP_EOL.
		PHP_EOL.
		'Zażądałeś zmiany swoich ustawień głównych.'.PHP_EOL.
		'Możesz to zrobić tylko raz w ciągu %s, więc przed kontynuacją sprawdź czy informacje są poprawne.'.PHP_EOL.
		PHP_EOL.
		'Płeć: %s'.PHP_EOL.
		'Kraj: %s'.PHP_EOL.
		'Główny język: %s'.PHP_EOL.
		'Dodatkowy język: %s'.PHP_EOL.
		'Data urodzin: %s'.PHP_EOL.
		PHP_EOL.
		'Jeśli chcesz zachować te ustawienia, wejdź na poniższy adres URL:'.PHP_EOL.
		'%s'.
		PHP_EOL.
		'Pozdrawia'.PHP_EOL.
		'Ekipa '.GWF_SITENAME,

	# New Flags 
	'th_allow_email' => 'Pozwól ludziom pisać do mnie',
	'msg_allow_email_on' => 'Inni mogą teraz wysyłać ci wiadomości bez znajomości twojego adresu email.',
	'msg_allow_email_off' => 'Kontakt emailowy wyłączony.',
		
	'th_show_bday' => 'Show your birthday',
	'msg_show_bday_on' => 'Your birthday is now announced to members who like that feature.',
	'msg_show_bday_off' => 'Your birthday is not announced anymore.',
		
	'th_show_obday' => 'Show other birthdays',
	'msg_show_obday_on' => 'You will now see other peoples birthdays.',
	'msg_show_obday_off' => 'You ignore birthday announces now.',

	# v2.02 Account Deletion
	'pt_accrm' => 'Delete your Account',
	'mt_accrm' => 'Delete your account on '.GWF_SITENAME,
	'pi_accrm' =>
		'It seems like you want to delete your account on '.GWF_SITENAME.'.<br/>'.
		'We are sad to hear that, also your account will not be deleted, just disabled.<br/>'.
		'All links to this username, profiles, etc, will become unusable or renamed to guest. This is irreversible.<br/>'.
		'Before you continue to disable your account, you may leave us a note with the reason(s) for your deletion.<br/>',
	'th_accrm_note' => 'Note',
	'btn_accrm' => 'Delete Account',
	'msg_accrm' => 'Your account got marked as deleted and all references should got deleted.<br/>You got logged out.',
	'ms_accrm' => GWF_SITENAME.': %s account deletion',
	'mb_accrm' =>
		'Dear Staff'.PHP_EOL.
		''.PHP_EOL.
		'The user %s has just deleted his account and left this note (may_be_empty):'.PHP_EOL.PHP_EOL.
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

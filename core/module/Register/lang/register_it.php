<?php
$lang = array(
		'pt_register' => 'Registrati su '.GWF_SITENAME,

		'title_register' => 'Registrati',

		'th_username' => 'Nome Utente',
		'th_password' => 'Password',
		'th_email' => 'E-Mail',
		'th_birthdate' => 'Data di nascita',
		'th_countryid' => 'Nazione',
		'th_tos' => 'Accetto le condizioni',
		'th_tos2' => 'Accetto le <a href="%s">condizioni</a>',
		'th_register' => 'Registrati',

		'btn_register' => 'Registrati',

		'err_register' => 'Durante la registrazione è apparso un errore.',
		'err_name_invalid' => 'Il nome utente non è valido.',
		'err_name_taken' => 'Il nome utente scelto è gia assegnato.',
		'err_country' => 'La nazione scelta non è valida.',
		'err_pass_weak' => 'La password scelta è troppo corta. Tip: <b>Scegli una password unica, non usarla per altri siti</b>.',
		'err_token' => 'Il codice di attivazione non è valido. Probabilmente sei già stato attivato.',
		'err_email_invalid' => 'L\'E-Mail fornita non è valida.',
		'err_email_taken' => 'La Vostra E-Mail è già stata utilizzata da un altro utente.',
		'err_activate' => 'C\'è stato un errore nella registrazione.',

		'msg_activated' => 'L\'account è stato attivato con successo. E\' ora possibile effettuale l\'accesso.',
		'msg_registered' => 'Grazie per esserti registrato.',

		'regmail_subject' => 'Registrato su '.GWF_SITENAME,
		'regmail_body' =>
		'Ciao %s<br/>'.
		'<br/>'.
		'Ti ringraziamo per esserti registrato a '.GWF_SITENAME.'.<br/>'.
		'Per completare la registrazione, devi prima attivare il tuo account, visitando il link sottostante.<br/>'.
		'Nel caso in cui non ti fossi registrato a '.GWF_SITENAME.' ti preghiamo di ignorare questa E-Mail e/o segnalarci il tutto su '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Cordiali saluti,<br/>'.
		'Il team di '.GWF_SITENAME,

		'err_tos' => 'Devi accettare i Termini di Servizio.',

		'regmail_ptbody' =>
		'Le tue credenziali di accesso sono:<br/><b>'.
		'Nome utente: %s<br/>'.
		'Password: %s<br/>'.
		'</b><br/>'.
		'Ti consigliamo di salvare la tua password e cancellare questa E-Mail.<br/>'.
		'Per ragioni di sicurezza, non dovresti mai lasciare la tua password in chiaro.<br/>'.
		'Per quanto detto, su questo sito le password sono criptate.<br/>'.
		'<br/>',
		#TODO: 
		### Admin Config ###
		'cfg_auto_login' => 'AutoLogin after Activation',
		'cfg_captcha' => 'Captcha for Register',
		'cfg_country_select' => 'Show country select',
		'cfg_email_activation' => 'Email registration',
		'cfg_email_twice' => 'Register same email twice?',
		'cfg_force_tos' => 'Show a forced TOS',
		'cfg_ip_usetime' => 'IP timeout for multi-register',
		'cfg_min_age' => 'Minimum age / Birthday selector',
		'cfg_plaintextpass' => 'Send Password to email in Plaintext',
		'cfg_activation_pp' => 'Activations per Admin Page',
		'cfg_ua_threshold' => 'Timeout for completing registration',

		'err_birthdate' => 'Ihr Geburtstag ist ungültig.',
		'err_minage' => 'Sie sind nicht alt genug um sich auf '.GWF_SITENAME.' zu registrieren. Sie müssen mindestens %s Jahre alt sein.',
		'err_ip_timeout' => 'Mit dieser IP wurde erst kürzlich ein Konto erstellt.',
		'th_token' => 'Token',
		'th_timestamp' => 'Anmelde-Datum',
		'th_ip' => 'Anmelde IP',
		'tt_username' => 'Der Nickname muss mit einem Buchstaben beginnen.'.PHP_EOL.'Er darf nur Zahlen, Buchtstaben und _ enthalten. Erlaubte Länge: 3 - %s Zeichen.',
		'tt_email' => 'Eine gültige EMail ist für die Anmeldung erforderlich.',

		'info_no_cookie' => 'Ihr Browser unterstützt keine cookies, oder erlaubt diese nicht. Zum einloggen werden diese aber benötigt.',

		# v2.01 (fixes)
		'msg_mail_sent' => 'An EMail with instructions to activate your account has been sent to you.',

		# v2.02 (Detect Country)
		'cfg_reg_detect_country' => 'Always auto-detect country',

		# v2.03 (Links)
		'btn_login' => 'Login',
		'btn_recovery' => 'Password recovery',
		# v2.04 (Fixes)
		'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
		# v2.05 (Blacklist)
		'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>

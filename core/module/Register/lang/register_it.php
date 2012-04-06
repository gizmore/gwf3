<?php
$lang = array(
		'pt_register' => 'Registrazione su '.GWF_SITENAME,

		'title_register' => 'Registrazione',

		'th_username' => 'Nome utente',
		'th_password' => 'Password ',
		'th_email' => 'Indirizzo E-Mail',
		'th_birthdate' => 'Data di nascita',
		'th_countryid' => 'Nazione',
		'th_tos' => 'Accetto le condizioni',
		'th_tos2' => 'Accetto le <a href="%s">condizioni</a>',
		'th_register' => 'Registrati',

		'btn_register' => 'Registrati',

		'err_register' => 'Durante la registrazione si è verificato un errore.',
		'err_name_invalid' => 'Il nome utente non è valido.',
		'err_name_taken' => 'Il nome utente scelto è gia stato scelto.',
		'err_country' => 'La nazione scelta non è valida.',
		'err_pass_weak' => 'La password scelta è troppo corta. <b>Consigliamo di scegliere una password complessa e di non usarla per altri siti</b>.',
		'err_token' => 'Il codice di attivazione non è valido. Probabilmente l\'account è già stato attivato.',
		'err_email_invalid' => 'L\'indirizzo E-Mail fornita non è valida.',
		'err_email_taken' => 'L\'indirizzo E-Mail fornita è già stata utilizzata da un altro utente.',
		'err_activate' => 'Si è verificato un errore nella registrazione.',

		'msg_activated' => 'L\'account è stato attivato con successo. E\' ora possibile effettuale l\'accesso.',
		'msg_registered' => 'Grazie per essersi registrato.',

		'regmail_subject' => 'Registrazione su '.GWF_SITENAME,
		'regmail_body' =>
		'Salve %s<br/>'.
		'<br/>'.
		'La ringraziamo per essersi registrata a '.GWF_SITENAME.'.<br/>'.
		'Per completare la registrazione, deve prima attivare il suo account, visitando il link sottostante.<br/>'.
		'Nel caso in cui non si fosse registrato a '.GWF_SITENAME.' la preghiamo di ignorare questa E-Mail e/o segnalarci il tutto con una E-Mail a '.GWF_SUPPORT_EMAIL.'.<br/>'.
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
		'Le consigliamo di salvare la sua password e cancellare questa E-Mail.<br/>'.
		'Per ragioni di sicurezza, non dovrebbe mai lasciare la sua password in chiaro.<br/>'.
		'Per quanto detto, su questo sito le password vengono criptate.<br/>'.
		'<br/>',

		### Admin Config ###
		'cfg_auto_login' => 'Login automatico dopo l\'attivazione',
		'cfg_captcha' => 'Captcha per la registrazione',
		'cfg_country_select' => 'Mostra menù per selezionare la nazionalità',
		'cfg_email_activation' => 'Registrazione tramite E-Mail',
		'cfg_email_twice' => 'Consenti di utilizzare lo stesso indirizzo E-Mail per account diversi?',
		'cfg_force_tos' => 'Costringi a leggere le condizioni di utilizzo',
		'cfg_ip_usetime' => 'Tempo massimo per registrazioni multiple dalle stesso IP',
		'cfg_min_age' => 'Età minima / Data di nascita',
		'cfg_plaintextpass' => 'Invia la password via E-Mail in chiaro',
		'cfg_activation_pp' => 'Attivazioni per Admin Page',
		'cfg_ua_threshold' => 'Imponi un tempo massimo per l\'attivazione dell\'account',
		'cfg_reg_toslink' => 'Link al TOS',

		'err_birthdate' => 'La data di nascita non è valida.',
		'err_minage' => 'Ci scusiamo, ma non ha l\'età necessaria per iscriversi al sito. Per registrarsi al sito, l\'età minima è %s anni.',
		'err_ip_timeout' => 'Qualcuno si è recentemente iscritto al sito da questo IP. Per questioni di sicurezza, non è possibile registrare più account consecutivamente dallo stesso IP. La preghiamo di attendere qualche istante e riprovare.',
		'th_token' => 'Token ',
		'th_timestamp' => 'Ora di registrazione',
		'th_ip' => 'Reg IP ',
		'tt_username' => 'Il nome utente deve iniziare con una lettera.'.PHP_EOL.'Può contenere solo lettere, numeri e l\'underscore e deve può avere una lunghezza compresa tra 3 e %s caratteri.',
		'tt_email' => 'Per registrarsi è necessario un indirizzo E-Mail valido.',

		'info_no_cookie' => 'Il suo Browser non supporta i cookies o non permette a '.GWF_SITENAME.' di utilizzarli, ma questi sono necessari per effettuare il login.',

		# v2.01 (fixes)
		'msg_mail_sent' => 'Un\'E-Mail con le istruzioni per l\'attivazione è stata inviata al suo indirizzo.',

		# v2.02 (Detect Country)
		'cfg_reg_detect_country' => 'Riconosci in automatico la nazione di appartenenza',

		# v2.03 (Links)
		'btn_login' => 'Login ',
		'btn_recovery' => 'Recupero Password',
		# v2.04 (Fixes)
		'tt_password' => 'Non ci sono restrizioni per quanto riguarda la password. Consigliamo di scegliere una password complessa (ad esempio una frase) e di non usarla per altri siti.',
		# v2.05 (Blacklist)
		'err_domain_banned' => 'Il suo E-Mail provider è sulla nostra blacklist.',

);
?>

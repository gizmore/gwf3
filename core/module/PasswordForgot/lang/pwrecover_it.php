<?php

$lang = array(

	'msg_sent_mail' => 'Le abbiamo inviato una E-Mail a %s. La preghiamo di seguire le informazioni in essa contenute.',
	'err_not_found' => 'Utente non trovato. La preghiamo di inserire il suo indirizzo E-Mail oppure il suo nome utente.',
	'err_not_same_user' => 'Utente non trovato. La preghiamo di inserire il suo indirizzo oppure il suo nome utente.', # same message! no spoiled connection from uname=>email
	'err_no_mail' => 'Siamo spiacenti, ma non ha un indirizzo E-Mail collegato al suo account. :(',
	'err_pass_retype' => 'La password non coincide con quella riscritta sotto.',
	'msg_pass_changed' => 'La sua password è stata cambiata.',

	'pt_request' => 'Richiedi una nuova password',
	'pt_change' => 'Cambia password',
	
	'info_request' => 'Qui può richiedere una nuova password per il suo account.<br/>Deve semplicemente inserire il suo nome utente <b>oppure</b> il suo indirizzo E-Mail, e le invieremo delle ulteriori informazioni al suo indirizzo E-Mail.',
	'info_change' => 'Può inserire una nuov apassword per il suo account, %s.',

	'title_request' => 'Richiedi una nuova password',
	'title_change' => 'Imposta una nuova password',

	'btn_request' => 'Richiedi',
	'btn_change' => 'Cambia',

	'th_username' => 'Nome utente',
	'th_email' => 'E-Mail',
	'th_password' => 'Nuova password',
	'th_password2' => 'Ridigitala',

	# The email (beware %s is twice. It`s an email. thats correct!)
	'mail_subj' => GWF_SITENAME.': Cambia password',
	'mail_body' => 
		'Caro %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Lei ha richiesto una nuova password su '.GWF_SITENAME.'.<br/>'.PHP_EOL.
		'Per fare ciò, visiti il link sottostante.<br/>'.PHP_EOL.
		'Se non ha richiesto un cambiamento della password, ignori questa E-Mail e/o ci contatti a <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Cordiali saluti,<br/>'.PHP_EOL.
		'Il team di '.GWF_SITENAME.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'La sua password è troppo debole. Deve essere lunga almeno %s caratteri.',
		
	#monnino fixes
	'cfg_captcha' => 'Usa Captcha',
	'cfg_mail_sender' => 'Mittente E-Mail',
);

?>
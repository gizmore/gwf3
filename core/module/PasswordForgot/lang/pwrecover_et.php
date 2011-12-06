<?php

$lang = array(

	'msg_sent_mail' => 'Me saatsime emaili %s. Palun järgi sealseid instruktsioone.',
	'err_not_found' => 'Kasutajat ei leitud. Palun kinnita oma kasutajanimi või email.',
	'err_not_same_user' => 'Kasutajat ei leitud. Palun kinnita oma kasutajanimi või email .', # same message! no spoiled connection from uname=>email
	'err_no_mail' => 'Meil on kahju, aga sul pole emaili kinnitatud kasutajale. :(',
	'err_pass_retype' => 'Sinu teine salasõna ei lähe esimesega kokku.',
	'msg_pass_changed' => 'Sinu parool on muudetud.',

	'pt_request' => 'Nõua uut parooli',
	'pt_change' => 'Muuda parooli',
	
	'info_request' => 'Siin saad nõuda uut parooli enda kasutajale.<br/>Lihtsalt kinnita oma kasutajanimi <b>või</b> email, ja me saadame edasised õpetused su emailile.',
	'info_change' => 'Sa saad nüüd sisestada parooli enda kasutajale, %s.',

	'title_request' => 'Nõua uut parooli',
	'title_change' => 'Pane uus parool',

	'btn_request' => 'Nõue',
	'btn_change' => 'Muudatus',

	'th_username' => 'Kasutajanimi',
	'th_email' => 'Email',
	'th_password' => 'Uus Parool',
	'th_password2' => 'Kirjuta uuesti',

	# The email
	'mail_subj' => GWF_SITENAME.': Muuda parooli',
	'mail_body' => 
		'Dear %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Sa avaldasid soovi oma parooli muuta '.GWF_SITENAME.'.<br/>'.PHP_EOL.
		'Et seda teha, pead külastama alljärgnevat linki.<br/>'.PHP_EOL.
		'Kui sa ei avaldanud soovi, ignoreeri seda emaili või kontakteeru meiega: <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Parimate soovidega,<br/>'.PHP_EOL.
		GWF_SITENAME.' Tiim'.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'Your password is too weak. Minimum are %s chars.',
);

?>
<?php

$lang = array(

	'msg_sent_mail' => 'Olemme lähettäneet sähköpostiviestin osoitteeseen %s. Ole hyvä ja seuraa viestin ohjeita.',
	'err_not_found' => 'Käyttäjää ei löytynyt. Ole hyvä ja anna joko sähköpostiosoitteesi tai käyttäjänimesi.',
	'err_not_same_user' => 'Käyttäjää ei löytynyt. Ole hyvä ja anna joko sähköpostiosoitteesi tai käyttäjänimesi.', # same message! no spoiled connection from uname=>email
	'err_no_mail' => 'Olemme pahoillamme, mutta käyttäjätunnukseesi ei ole yhdistetty sähköpostiosoitetta. :(',
	'err_pass_retype' => 'Uudelleenkirjoittamasi salasana ei täsmää.',
	'msg_pass_changed' => 'Salasanasi on vaihdettu.',

	'pt_request' => 'Pyydä uutta salasanaa',
	'pt_change' => 'Vaihda salasanaasi',
	
	'info_request' => 'Täällä voit pyytää tunnuksellesi uutta salasanaa.<br/>Anna vain käyttäjätunnuksesi <b>tai</b> tai sähköpostiosoitteesi, ja me lähetämme sähköpostiisi lisäohjeita.',
	'info_change' => 'Voit nyt antaa uuden salasanan tunnuksellesi %s.',

	'title_request' => 'Pyydä uutta salasanaa',
	'title_change' => 'Aseta uusi salasana',

	'btn_request' => 'Pyydä',
	'btn_change' => 'Muuta',

	'th_username' => 'Käyttäjänimi',
	'th_email' => 'Sähköpostiosoite',
	'th_password' => 'Uusi salasana',
	'th_password2' => 'Uudelleenkirjoita se',

	# The email
	'mail_subj' => GWF_SITENAME.': Salasanan vaihto',
	'mail_body' => 
		'Hyvä %1$s,<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Olet pyytänyt salasanasi vaihtoa sivustolla '.GWF_SITENAME.'.<br/>'.PHP_EOL.
		'Vaihtaaksesi salasanasi, vieraile allaolevassa linkissä.<br/>'.PHP_EOL.
		'Jos et pyytänyt salasanasi vaihtoa, jätä tämä viesti huomiotta tai ota meihin yhteyttä: <a href="mailto:%2$s">%2$s</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'%3$s<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Terveisin<br/>'.PHP_EOL.
		GWF_SITENAME.'-tiimi'.PHP_EOL,

	# v2.01 (fixes)
	'err_weak_pass' => 'Salasanasi on liian lyhyt. Tarvitset vähintään %s merkkiä.',
);

?>
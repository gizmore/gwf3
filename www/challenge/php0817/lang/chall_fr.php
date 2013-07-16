<?php
$lang = array(
	'title' => 'PHP-0817',
	'info' =>
		'J\'ai écrit un autre système d\'intégration pour mes pages web dynamiques, mais il semble être vulnérable à la faille LFI.<br/>'.
		'Voici le code:<br/>'.
		'%1$s<br/>'.
		'Votre mission est d\'inclure <a href="%2$s">solution.php</a>.<br/>'.
		'Voici le script en action: <a href="%3$s">News</a>, <a href="%4$s">Forum</a>, <a href="%5$s">Guestbook</a>.<br/>'.
		'<br/>'.
		'Bonne chance!<br/>',

	'msg_solved' => 'Bien joué, trop facile... Savez-vous pourquoi c\'est possible ?',
	'err_security' => 'Parce que le code est sacrément vulnérable, les points et les slash ne sont pas autorisés dans votre entrée.',
);

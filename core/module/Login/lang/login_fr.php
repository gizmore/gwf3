<?php
/** BY awe **/

$lang = array(

	'pt_login' => 'Se connecter à '.GWF_SITENAME,
	'title_login' => 'Connexion',
	
	'th_username' => 'Pseudo',
	'th_password' => 'Mot de Passe',
	'th_login' => 'Se connecter',
	'btn_login' => 'Se connecter',
	'btn_register' => 'Register',
	'btn_recovery' => 'Recovery',

	'err_login' => 'Utilisateur Inconnu',
	'err_login2' => 'Mauvais Password. Il vous reste %s essais avant d\'être bloqué pour %s.',
	'err_blocked' => 'Merci d\'attendre %s avant une nouvelle tentative.',

	'welcome' => 
		'Bienvenue sur '.GWF_SITENAME.', %s.<br/><br/>'.
		'Nous espérons que vous appréciez notre site et que vous vous amusez en naviguant.<br/>'.
		'Si vous avez des questions, n\'hésitez pas à nous contacter!',

	'welcome_back' => 
		'Bon retour sur '.GWF_SITENAME.', %s.<br/><br/>'.
		'Votre dernière activité était le %s avec l\'IP: %s.',

	'logout_info' => 'Vous êtes à présent déconnecté.',

	# Admin Config
	'cfg_captcha' => 'Utiliser un Captcha?',	
	'cfg_max_tries' => 'Maximum tentatives Login',	
	'cfg_try_exceed' => 'pendant cette Durée',

	'info_no_cookie' => 'Votre Naviguateur ne supporte pas les cookies ou ne les accepte pas pour '.GWF_SITENAME.', mais les cookies sont nécessaires pour la connexion.',
	
	'th_bind_ip' => 'Restreindre la session à cette IP',
	'tt_bind_ip' => 'Une mesure de sécurité pour prévenir le vol de cookie.',

	'err_failures' => 'Il y a eu %s erreurs de connexion, vous êtes peut être sujet d\'une tentative d\'attaque ratée ou en cours de préparation.',
	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Cleanup user failures after login?',
	'cfg_lf_cleanup_t' => 'Cleanup old failures after time',

	# v2.00 (login history)
	'msg_last_login' => 'Your last login was %s from %s (%s).<br/>You can also <a href="%s">review your login history here</a>.',
	'th_loghis_time' => 'Date',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %s from this IP: %s / %s',

	# v2.02 (email alerts)
	'alert_subj' => GWF_SITENAME.': Login failures',
	'alert_body' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'There was a failed login attempt from this IP: %s.'.PHP_EOL.
		PHP_EOL.
		'We just let you know.'.PHP_EOL.
		PHP_EOL.
		'Sincerely,'.
		PHP_EOL.
		'The '.GWF_SITENAME.' script',

	# monnino fixes
	'cfg_send_alerts' => 'Send alerts',
	'err_already_logged_in' => 'You are already logged in.',
);
?>

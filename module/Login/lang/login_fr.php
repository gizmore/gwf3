<?php
/** BY awe **/

$lang = array(

	'pt_login' => 'Se connecter à '.GWF_SITENAME,
	'title_login' => 'Connexion',
	
	'th_username' => 'Pseudo',
	'th_password' => 'Mot de Passe',
	'th_login' => 'Se connecter',
	'btn_login' => 'Se connecter',

	'err_login' => 'Utilisateur Inconnu',
	'err_login2' => 'Mauvais Password. Il vous reste %1% essais avant d\'être bloqué pour %2%.',
	'err_blocked' => 'Merci d\'attendre %1% avant une nouvelle tentative.',

	'welcome' => 
		'Bienvenue sur '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Nous espérons que vous appréciez notre site et que vous vous amusez en naviguant.<br/>'.
		'Si vous avez des questions, n\'hésitez pas à nous contacter!',

	'welcome_back' => 
		'Bon retour sur '.GWF_SITENAME.', %1%.<br/><br/>'.
		'Votre dernière activité était le %2% avec l\'IP: %3%.',

	'logout_info' => 'Vous êtes à présent déconnecté.',

	# Admin Config
	'cfg_captcha' => 'Utiliser un Captcha?',	
	'cfg_max_tries' => 'Maximum tentatives Login',	
	'cfg_try_exceed' => 'pendant cette Durée',

	'info_no_cookie' => 'Votre Naviguateur ne supporte pas les cookies ou ne les accepte pas pour '.GWF_SITENAME.', mais les cookies sont nécessaires pour la connexion.',
	
	'th_bind_ip' => 'Restreindre la session à cette IP',
	'tt_bind_ip' => 'Une mesure de sécurité pour prévenir le vol de cookie.',

	'err_failures' => 'Il y a eu %1% erreurs de connexion, vous êtes peut être sujet d\'une tentative d\'attaque ratée ou en cours de préparation.',
	# v1.01 (login failures)
	'cfg_lf_cleanup_i' => 'Cleanup user failures after login?',
	'cfg_lf_cleanup_t' => 'Cleanup old failures after time',

	# v2.00 (login history)
	'msg_last_login' => 'Your last login was %1% from %2% (%3%).<br/>You can also <a href="%4%">review your login history here</a>.',
	'th_loghis_time' => 'Date',
	'th_loghis_ip' => 'IP',
	'th_hostname' => 'Hostname',

	# v2.01 (clear hist)
	'ft_clear' => 'Clear login history',
	'btn_clear' => 'Clear',
	'msg_cleared' => 'Your login history has been cleared.',
	'info_cleared' => 'Your login history was last cleared at %1% from this IP: %2% / %3%',
);
?>

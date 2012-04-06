<?php
/** BY awe **/

$lang = array(
	'pt_register' => 'S\'enregistrer sur '.GWF_SITENAME,

	'title_register' => 'Enregistrer',

	'th_username' => 'Pseudo',
	'th_password' => 'Pass',
	'th_email' => 'Email ',
	'th_birthdate' => 'Naissance',
	'th_countryid' => 'Pays',
	'th_tos' => 'J\'accepte les <br/>Termes d\'Utilisation',
	'th_tos2' => 'J\'accepte les <br/><a href="%s">Termes d\'Utilisation</a>',
	'th_register' => 'Enregistrer',

	'btn_register' => 'Enregistrer',
	

	'err_register' => 'Une erreur s\'est produite pendant la procédure d\'enregistrement.',
	'err_name_invalid' => 'Votre choix de pseudo est invalide.',
	'err_name_taken' => 'Votre choix de pseudo est utilisé.',
	'err_country' => 'Votre pays est invalide.',
	'err_pass_weak' => 'Votre mot de passe est trop faible. Aussi, <b>ne réutilisez PAS de mots de passe importants</b>.',
	'err_token' => 'Votre code d\'activation est invalide. Votre compte peut être déjà activé.',
	'err_email_invalid' => 'Votre email est invalide.',
	'err_email_taken' => 'Votre email est déjà pris.',
	'err_activate' => 'Une erreur s\'est produit pendant l\'activation.',
		
	'msg_activated' => 'Votre compte est maintenant activé. Merci d\'essayer de vous connecter.',
	'msg_registered' => 'Merci de vous êtes enregistré.',

	'regmail_subject' => 'Enregistrement sur '.GWF_SITENAME,
	'regmail_body' => 
		'Bonjour %s<br/>'.
		'<br/>'.
		'Merci pour votre enregistrement sur '.GWF_SITENAME.'.<br/>'.
		'Pour compléter votre enregistrement, vous devez d\'abord activer votre compte, en visitant le lien suivant.<br/>'.
		'Si vous ne vous êtes pas enregistré sur '.GWF_SITENAME.', merci d\'ignorer ce mail, ou contactez nous à '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Cordialement,<br/>'.
		'L\'équipe '.GWF_SITENAME,
	'err_tos' => 'Vous devez être d\'accord avec l\'EULA.',

	'regmail_ptbody' => 
		'Vos identifiants de connexion sont:<br/><b>'.
		'Username: %s<br/>'.
		'Password: %s<br/>'.
		'</b><br/>'.
		'Vous devriez détruire cet email et sauvegarder le mot de passe autrepart.<br/>'.
		'Nous ne stockons pas votre mot de passe en clair, vous ne devriez pas le faire non plus.<br/>'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'AutoLogin après Activation',	
	'cfg_captcha' => 'Captcha pour Enregistrement',
	'cfg_country_select' => 'Afficher la sélection de pays',
	'cfg_email_activation' => 'Enregistrement Email',
	'cfg_email_twice' => 'Enregistrer le même email en double?',
	'cfg_force_tos' => 'Afficher un TOS forcé',
	'cfg_ip_usetime' => 'IP Temps de repos pour multi-enregistrement',
	'cfg_min_age' => 'Age minimum / Sélecteur de Naissance',
	'cfg_plaintextpass' => 'Envoyer le Password par email en clair',
	'cfg_activation_pp' => 'Activations par Admin Page',
	'cfg_ua_threshold' => 'Temps de repos pour compléter l\'enregistrement',

	'err_birthdate' => 'Votre date de naissance est invalide.',
	'err_minage' => 'Nous sommes désolés, mais vous n\'êtes pas assez âgé pour vous enregistrer. Vous devez avoir au moins %s ans.',
	'err_ip_timeout' => 'Quelqu\'un a récemment enregistré un compte avec cette IP.',
	'th_token' => 'Token ',
	'th_timestamp' => 'Date d\'enregistrement',
	'th_ip' => 'Enregistrer l\'IP',
	'tt_username' => 'Le nom d\'utilisateur doit commencer avec la lettre.'.PHP_EOL.'Il doit contenir seulement des lettres, chiffres et l\'underscore. Length has to be 3 - %s chars.', 
	'tt_email' => 'Un EMail valide est nécessaire pour s\'enregistrer.',

	'info_no_cookie' => 'Votre navigateur ne supporte pas les cookies ou ne les autorise pas pour '.GWF_SITENAME.', mais les cookies sont nécessaires pour se connecter.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Un EMail contenant les instructions pour activer votre compte vous a été envoyé.',

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
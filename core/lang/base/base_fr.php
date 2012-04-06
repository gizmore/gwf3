<?php
$lang = array(
	'ERR_DATABASE' => 'Erreur de base de donnée fichier %s ligne %s.',
	'ERR_FILE_NOT_FOUND' => 'Fichier non trouvé: %s',
	'ERR_MODULE_DISABLED' => 'Le module %s est actuellement désactivé.',
	'ERR_LOGIN_REQUIRED' => 'Vous devez être connecté pour cette fonction.',
	'ERR_NO_PERMISSION' => 'Permission refusée.',
	'ERR_WRONG_CAPTCHA' => 'Vous devez taper les lettres de l\'image correctement.',
	'ERR_MODULE_MISSING' => 'Module %s ne peut être trouvé.',
	'ERR_COOKIES_REQUIRED' => 'Votre session a Expiré ou vous devez activer les cookies dans votre naviguateur.<br/>Tentez de rafraîchir la page, merci.',
	'ERR_UNKNOWN_USER' => 'L\'Utilisateur est inconnu.',
	'ERR_UNKNOWN_GROUP' => 'Le Groupe est inconnu.',
	'ERR_UNKNOWN_COUNTRY' => 'Le Pays est inconnu.',
	'ERR_UNKNOWN_LANGUAGE' => 'Cette Langue est inconnue.',
	'ERR_METHOD_MISSING' => 'Méthode non reconnue: %s dans le Module %s.',
	'ERR_GENERAL' => 'Erreur non définie dans %s Ligne %s.',
	'ERR_WRITE_FILE' => 'Impossible d\'écrire le fichier: %s.',
	'ERR_CLASS_NOT_FOUND' => 'Classe Inconnue: %s.',
	'ERR_MISSING_VAR' => 'Variable HTTP POST manquante: %s.',
	'ERR_MISSING_UPLOAD' => 'Vous devez envoyer un fichier.',
	'ERR_MAIL_SENT' => 'Une erreur est survenue pendant l\'envoi de l\'email.',
	'ERR_CSRF' => 'Le formulaire saisi est invalide. Vous avez certainement tenté un double post, ou votre session a expiré entre temps.',
	'ERR_HOOK' => 'Un hook a retourné faux: %s.',
	'ERR_PARAMETER' => 'Argument invalide dans %s ligne %s. Argument de fonction %s invalide.',
	'ERR_DEPENDENCY' => 'Dépendance non résolue: core/module/%s/method/%s demande le Module %s v%s.',
	'ERR_SEARCH_TERM' => 'Le terme cherché doit avoir %s - %s caractères de long.',
	'ERR_SEARCH_NO_MATCH' => 'Votre recherche de &quot;%s&quot; n\'a trouvé aucune correspondance.',
	'ERR_POST_VAR' => 'Variable POST non attendue: %s.',
	'ERR_DANGEROUS_UPLOAD' => 'Your uploaded file contains &quot;&lt;?&quot; which is considered dangerous and denied.',

	# GWF_Time
	'unit_sec_s' => 's',
	'unit_min_s' => 'm',
	'unit_hour_s' => 'h',
	'unit_day_s' => 'd',
	'unit_month_s' => 'M',
	'unit_year_s' => 'y',

	'M1' => 'Janvier',
	'M2' => 'Février',
	'M3' => 'Mars',
	'M4' => 'Avril',
	'M5' => 'Mai',
	'M6' => 'Juin',
	'M7' => 'Juillet',
	'M8' => 'Août',
	'M9' => 'Septembre',
	'M10' => 'Octobre',
	'M11' => 'Novembre',
	'M12' => 'Décembre',

	'm1' => 'Jan',
	'm2' => 'Feb',
	'm3' => 'Mar',
	'm4' => 'Apr',
	'm5' => 'Mai',
	'm6' => 'Jun',
	'm7' => 'Jul',
	'm8' => 'Aug',
	'm9' => 'Sep',
	'm10' => 'Oct',
	'm11' => 'Nov',
	'm12' => 'Dec',

	'D0' => 'Dimanche',
	'D1' => 'Lundi',
	'D2' => 'Mardi',
	'D3' => 'Mercredi',
	'D4' => 'Jeudi',
	'D5' => 'Vendredi',
	'D6' => 'Samedi',

	'd0' => 'Dim',
	'd1' => 'Lun',
	'd2' => 'Mar',
	'd3' => 'Mer',
	'd4' => 'Jeu',
	'd5' => 'Ven',
	'd6' => 'Sam',

	'ago_s' => 'il y a %s secondes',
	'ago_m' => 'il y a %s minutes',
	'ago_h' => 'il y a %s heures',
	'ago_d' => 'il y a %s jours',

	###
	### TODO: GWF_DateFormat, is problematic, because en != en [us/gb]
	###
	### Here you have to specify how a default dateformats looks for different languages.
	### You have the following substitutes:
	### Year:   Y=1990, y=90
	### Month:  m=01,   n=1,  M=January, N=Jan
	### Day:    d=01,   j=1,  l=Tuesday, D=Tue
	### Hour:   H:23    h=11
	### Minute: i:59
	### Second: s:59
	'df4' => 'Y', # 2009
	'df6' => 'M Y', # January 2009
	'df8' => 'D, M j, Y', # Tue, January 9, 2009
	'df10' => 'M d, Y - H:00', # January 09, 2009 - 23:00
	'df12' => 'M d, Y - H:i',  # January 09, 2009 - 23:59
	'df14' => 'M d, Y - H:i:s',# January 09, 2009 - 23:59:59
	
	'datecache' => array(
		array('Jan','Feb','Mar','Apr','Mai','Jun','Jul','Aug','Sep','Oct','Nov','Dec'),
		array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'),
		array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam'),
		array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'),
		array(4=>'Y', 6=>'M Y', 8=>'D, M j, Y', 10=>'M d, Y - H:00', 12=>'M d, Y - H:i', 14=>'M d, Y - H:i:s'),
	),

	# GWF_Form
	'th_captcha1' => '<a href="http://fr.wikipedia.org/wiki/Captcha">Captcha</a>', #<br/>Cliquez sur l\'image pour recharger',
	'th_captcha2' => 'Ecrivez les 5 lettres de l\'image Captcha',
	'tt_password' => 'Les mots de passe doivent faire au moins 8 caractères de long.',
	'tt_captcha1' => 'Cliquez sur l\'image captcha pour en demander une nouvelle.',
	'tt_captcha2' => 'Retapez l\'image pour prouvez que vous êtes humain.',

	# GWF_Category
	'no_category' => 'Toutes les Catégories',
	'sel_category' => 'Sélectionner une Catégorie',

	# GWF_Language
	'sel_language' => 'Sélectionner une langue',
	'unknown_lang' => 'Langue Inconnue',

	# GWF_Country
	'sel_country' => 'Selectionner un Pays',
	'unknown_country' => 'Pays Inconnu',
	'alt_flag' => '%s',

	# GWF_User#gender
	'gender_male' => 'Mâle',
	'gender_female' => 'Femme',
	'gender_no_gender' => 'Sexe Inconnu',

	# GWF_User#avatar
	'alt_avatar' => 'Avatar de %s',

	# GWF_Group
	'sel_group' => 'Sélectionner un Groupe d\'Utilisateurs',

	# Date select
	'sel_year' => 'Année',
	'sel_month' => 'Mois',
	'sel_day' => 'Jour',
	'sel_older' => 'Plus âgé que',
	'sel_younger' => 'Plus jeune que',

	### General Bits! ###
	'guest' => 'Invité',
	'unknown' => 'Inconnu',
	'never' => 'Jamais',
	'search' => 'Chercher',
	'term' => 'Terme',
	'by' => 'par',
	'and' => 'et',

	'alt_flag' => '%s Flag',

	# v2.01 (copyright)
	'copy' => '&copy; %s '.GWF_SITENAME.'. All rights reserved.',
	'copygwf' => GWF_SITENAME.' is using <a href="http://gwf.gizmore.org">GWF</a>, the BSD-Like Website Framework.',

	# v2.02 (recaptcha+required_fields)
	'form_required' => '%s means required.',

	# v2.03 BBCode
	'bbhelp_b' => 'bold',
	'bbhelp_i' => 'italic',
	'bbhelp_u' => 'underlined',
	'bbhelp_code' => 'Code goes here',
	'bbhelp_quote' => 'The text here is a quote',
	'bbhelp_url' => 'Link text',
	'bbhelp_email' => 'Text for email link',
	'bbhelp_noparse' => 'Disable bb-decoding here.',
	'bbhelp_level' => 'Text that needs a minimum userlevel to be viewable.',
	'bbhelp_spoiler' => 'Invisible text that is shown with a click.',

	# v2.04 BBCode3
	'quote_from' => 'Quote from %s',
	'code' => 'code',
	'for' => 'for',

	# 2.05 Bits
	'yes' => 'Oui',
	'no' => 'Non',

	# 2.06 spoiler
	'bbspoiler_info' => 'Click for spoiler',

	# 3.00 Filesize
	'filesize' => array('B','KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'YB', 'ZB'),
	'err_bb_level' => 'You need a userlevel of %s to see this content.',
);

?>

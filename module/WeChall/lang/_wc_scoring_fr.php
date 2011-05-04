<?php
$lang = array(
	# Scoring Faq
	'pt_scorefaq' => '[WeChall] Faq des Scores',
	'mt_scorefaq' => 'WeChall FAQ des Scores Expliquée.',
	'scoring_faqt' => 'Le Système de Points sur WeChall',
	'scoring_faq' => 
		'Cette page décrit le système de points (score) adopté par WeChall.<br/>'.
		'<br/>'.
		'Actuellement, chaque site a un certain nombre de points qui dépend de trois facteurs:<br/>'.
		'<br/>'.
		'1. Les points de base pour le site.<br/>'.
		'2. Le nombre de challenges sur ce site.<br/>'.
		'3. Comment nos utilisateurs se débrouillent sur ce site.<br/>'.
		'<br/>'.
		'Exemple:<br/>'.
		'Le nombre de points de base de Electrica est de 10000 (valeur par défaut, ajustable par les administrateurs).<br/>'.
		'Puisqu\'il a 44 épreuves, un score de 25 * 44 = 1100 est ajouté à cela pour obtenir 11100.'.
		'En moyenne nos utilisateurs complètent 42% sur ce site.<br/>'.
		'Le nombre de points pour ce site devient base+base-moyenne*base, soit<br/>'.
		'11100 + 11100 - 4662 = 17538 points.<br/>'.
		'Donc plus un site est difficile plus il générera de points.<br/>'.
		'<br/>'.
		'Le nombre de points d\'un site détermine combien de points de classement sur WeChall vous aurez.<br/>'.
		'<br/>'.
		'Exemple:<br/>'.
		'Imaginez que Peter a 30000 points sur HackQuest, sur un maximum de 100000 points.<br/>'.
		'Cela signifie que Peter a résolu 30% de Hackquest.<br/>'.
		'Ce pourcentage est ajusté avec la formule (p*p/100) qui donne davantage de valeur aux plus grands pourcentages, comparativement aux pourentages faibles.<br/>'.
		'Il obtient donc 9% (30*30/100) des points de HackQuest sur WeChall.<br/>'.
		'HackQuest a actuellement un score de 19698, donc Peter aura 1773 points de classement.<br/>'.
		'<br/>'.
		'Les administrateurs peuvent ajuster manuellement le score de base pour chaque site.<br/>'.
		'Il se peut qu\'un site ayant des épreuves moins nombreuses et moins difficilies obtienne un nombre de points plus élevé que celui d\'un site ayant de nombreuses épreuves difficiles.<br/>'.
		'<br/>'.
		'N\'hésitez pas à poser des questions sur le <a href="%1%">forum</a> si quelque chose ne vous paraît pas clair.',
);
?>
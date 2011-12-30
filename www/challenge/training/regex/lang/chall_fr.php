<?php
# (thx SN4K37)
$lang = array(
	'title' => 'Regex Training Challenge (Level %1$s)',

	'err_wrong' => 'Votre réponse est fausse, ou bien il y a une réponse plus courte au problème.',
	'err_no_match' => 'Votre pattern ne correspondrait pas &quot;%1$s&quot;.',
	'err_matching' => 'Votre pattern correspondrait à &quot;%1$s&quot;, mais il ne devrait pas correspondre à ça.',
	'err_capturing' => 'Votre pattern capturerait une chaîne, mais ce n\'est pas demandé. Please use a non capturing group.',
	'err_not_capturing' => 'Votre pattern ne capture pas la chaîne recherchée corectement.',
	'err_too_long' => 'Votre pattern est plus long que la solution de référence: %1$s caractères.',

	'msg_next_level' => 'Correcte. Allons voir si vous pouvez monter avec un pattern pour le problème suivant.',
	'msg_solved' => 'Bien joué, c\'est assez pour une toute première leçon sur les expressions régulières. Mission accomplie.',
	
	# Levels
	'info_1' =>
		'Votre objectif dans ce challenge is d\'apprendre la syntaxe des regex.<br/>'.PHP_EOL.
		'Les expressions régulières sont des outils puissants dans votre voie de maître de la programmation, donc vous vous serez capable de résoudre ce challenge, pour finir!<br/>'.PHP_EOL.
		'La solution à toutes les tâches est toujours le pattern d\'expression régulière le plus court possible.<br/>'.PHP_EOL.
		'Notez aussi que vous devez soumettre aussi le délimiteur dans les paterns. Exemple d\'un pattern: <b>/joe/i</b>. Le délimiteur doit être <b>/</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Votre première leçon est simple: submit the regular expression the matches an empty string, et seulement une chaîne vide.<br/>',

	'info_2' => 
		'Assez simple. Votre tâche suivante est de soumettre une expression régulière qui sera seulement égale à la chaîne \'wechall\' sans les guillemets.',

	'info_3' => 
		'Ok, la correspondance entre les chaînes n\'est pas le but principal des expressions régulières.<br/>'.PHP_EOL.
		'Votre tâche suivante est de soumettre un expression qui contient un nom de fichier valide pour les images.<br/>'.PHP_EOL.
		'Votre pattern doit correspondre à toutes les images avec le nom wechall.ext ou wechall4.ext et une extension d\'image valide.<br/>'.PHP_EOL.
		'Les extensions d\'images valides sont .jpg, .gif, .tiff, .bmp and .png.<br/>'.PHP_EOL.
		'Voici quelques exemples de noms de fichiers valides: wechall4.tiff, wechall.png, wechall4.jpg, wechall.bmp',

	'info_4' =>
		'C\'est bien d\'avoir des images valides désormais. Mais pouvez-vous aussi capturer le nom du fichier sans l\'extension?<br/>'.PHP_EOL.
		'Pour exemple: wechall4.jpg doit maintenant capturer/retourner wechall4 dans votre pattern.',

	'info_5' => 
		'Vous le faites bien! Votre tâche suivante est de faire correspondre toutes les URLs valides http et https, mais uniquement brutes.<br/>'.PHP_EOL.
		'Un exemple pour une URL valide is https://abc.de ou http://abc.foobar/blub<br/>'.PHP_EOL.
		'Conseil: Il y a un caractère que vous pouvez exclure à coup sûr du pattern.',
);
?>
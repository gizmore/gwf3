<?php
$lang = array(
	'title' => 'PHP - Local File Inclusion',
	'info' =>
		'Votre mission est d'exploiter ce code, lequel a évidemment une :<a href="http://en.wikipedia.org/wiki/Local_File_Inclusion">faille LFI</a>:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1$s</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Il y a beaucoup de choses importantes dans <a href="%2$s">../solution.php</a>, alors s\'il vous plaît vous pourriez inclure et exécuter ce fichier pour nous.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Voici quelques exemples de ce script en action (dans la boîte ci-dessous):<br/>'.PHP_EOL.
		'<a href="%5$s">%5$s</a><br/>'.PHP_EOL.
		'<a href="%6$s">%6$s</a><br/>'.PHP_EOL.
		'<a href="%7$s">%7$s</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Pour les besoins de débogage, vous pouvez accéder au <a href="%3$s">code source entier</a>, ainsi qu\'à sa <a href="%4$s">version surlignée</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'Le script vulnérable en action',
	'err_basedir' => 'Ce dossier n\'est pas une partie du challenge.',
	'credits' => 'Merci à %1$s pour ces alpha tests, sa motivation et ses brillantes idées!',
	'msg_solved' => 'Bien joué. Si vous trouvez une faille de type local file inclusion, généralement la boîte peut se pirater en quelques minutes.',
);
?>
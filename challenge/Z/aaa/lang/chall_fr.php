<?php
$lang = array(
	'thanks' => 'Mes remerciements vont à %1% et %2% pour avoir beta-testé le challenge.',
	'index_info' =>
		'Vous jouez le rôle d\'un hacker secret. Comme toujours.<br/>'.
		'Votre boulot est le suivant:<br/>'.
		'<br/>'.
		'La VSA (Very Secret Agency) a suivi un politique de sécurité très stricte depuis des années, il est impossible de pénétrer leur réseau.<br/>'.
		'Malheureusement, c\'est ce que votre chef veut de vous.<br/>'.
		'Après un peu de social ingeneering vous avez obtenu que la VSA veut commander quelques programmes simple de SoftMicro, société de développement de logiciels.<br/>'.
		'SoftMicro est un ancien partenaire de la VSA, et il a mis en place beaucoup de backdoors à la VSA dans le but d\'une opération commerciale appelée "Doors".<br/>'.
		'Le logiciel de SoftMicro est globalement merdique,mais leur réseau est très bien défendu - merci aux multiples attaques contre le réseau de SoftMicro.<br/>'.
		'Mais la VSA n\'accepte aucun code venant de SoftMicro direcement, parce qu\'elle a embauché une compagnie appelée Anderson pour vérifier chaque morceau de code qui est utilisé à la VSA.<br/>'.
		'Le plan est de détourner la communication entre Andersen et SoftMicro, pour que vous puissiez analyser le programme, et cela après qu\'Anderson ait vérifié le programme, vous détournerez le donc le trafic, et échangerez le programme contre le vôtre machiavélique, et le boulot est fait.<br/>'.
		'<br/>'.
		'Le plan est bon, mais peut-être que tout ne se déroulera pas comme prévu.<br/>'.
		'<br/><br/>'.
		'Votre tâche première est de détourner la communication entre le réseau d\'Anderson et de Softmicro.<br/>'.   
		'<br/>'.
		'Ici sont les informations que vous avez déjà recueillies:<br/>'.
		'Le réseau de SoftMicro est 207.46.197.0  <br/>'.
		'Votre IP publique est 17.149.160.49 <br/>'.
		'<br/>'.
		'La page d\'accueil d\'Anderson est <a href="%1%">Anderson</a><br/>'.
		'<br/>'.
		'Dans votre progression sur le challenge, vous obtiendrez six morceaux de code secret, qui sont la preuve que vous avez résolu le challenge.<br/>'.
		'So, don\'t forget to write down those secret code pieces.<br/>',
		'Donc n\'oubliez pas d\'écrire ces morceaux de code.<br/>',

	# router.php
	'err_router' => 'Invalid username/password.',
	'cfg_cmd' => 'Config command',
	'router_info' =>
		'Identification réussie.<br/>'.
		'Vous pouvez configurer votre router ici, la syntaxe est la même quand pour les *NIX boxes.<br/><br/>'.
		'Exemple: route add -net x.x.x.x netmask 255.255.255.0 gw x.x.x.x<br/><br/>',

	# upload_md5.php
	'upload_info' =>
		'Votre tâche suivante est de créer deux éxecutables, pour lesquels les md5sum sont identiques.<br/>'.
		'Le premier exécutable doit être envoyé à Anderson pour l\'analyse du logiciel et le second doit être envoyé à la VSA dans la deuxième partie de votre mission.<br/>'.
		'<br/>'.
		'Le premier program doit afficher<br/>'. 
		'<i>"Hello VSA employee"</i><br/>'.
		'Et votre second programme, le mephistophélique, doit afficher<br/>'. 
		'<i>"I am a super VIRUS, game over."</i><br/>'.
		'<br/><br/>'.
		'Ce script vérifié si les deux exécutables différents font comme prévu, et si le md5sum est égal pour eux.<br/>'.
		'<br/>'.
		'As SoftMicro\'s developers are in late to finish their job, maybe you can find the collision before they want it to send to Anderson.<br/>'.
		'Comme les développeurs de SoftMicro sont en retard pour finir leur travail, peut-être que vous pouvez trouver la collision avant qu\'ils veulent l\'envoyer à Anderson.<br/>'.
		'<br/>'.
		'Note: Le script valide uniquement si le bon fichier contient la bonne chaîne de caractères, et le mauvais la diabolique, et si md5sum est différents du sha1sum.<br/>'.
		'Sur mon modeste PC ça m\'a pris 8 heures pour trouver une collision, mais il y a une voie plus courte et plus rapide...<br/>',
	'hidden_hint' => 'Indice caché: recherchez à propos des collisions de md5.',

	# upload_md5_file.php
	'err_file_size' => 'Votre fichier est trop gros.<br/>',
	'err_upload_fail' => 'Le fichier ne peut être chargé!<br/>',
	'err_wrong' => 'Erreur: Les fichiers ne sont pas différents.<br/>',
	'err_md5' => 'Erreur: Les md5sums ne sont pas égaux.<br/>',
	'err_upload_grbge' => 'Erreur: Les fichiers ne font pas ce qu\'ils devraient faire.<br/>',
	'msg_uploaded_collision' =>
		'Bon boulo.<br/>'.
		'2nd morceau de la chaîne secrète: %1%<br/>'.
		'<br/>'.
		'Votre travail continue ici:<br/>'.
		'<a href="%2%">Fingerprinting</a>',
);
?>

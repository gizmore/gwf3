<?php

$lang = array(
	'info' => '
Bonjour, imaginez la situation suivante.<br/>
Il y a un canal IRC sur irc.wechall.net nommé #wechall.<br/>
<br/>
Lorsque le serveur reçoit un message à transmettre, il l\'envoit à chacune des personnes présentes dans le canal (l\'expéditeur inclus).<br/>
Lorsqu\'à chaque minute une personne s\'inscrit et dit bonjour,<br/>
combien de messages &quot;bonjour&quot; au total sont envoyés dans ce canal après 0xfffbadc0ded minutes ?<br/>
Une fois inscrit, personne ne quitte le canal ; il y a donc 0xfffbadc0ded personnes à la fin ;)<br/>
<br/>
Voici un exemple sur une durée de 3 minutes :<br/>
Le canal est initialement vide et 0 message a été envoyé.<br/>
La 1ère personne s\'inscrit, dit bonjour, le serveur envoie le message à 1 personne.<br/>
La 2e personne s\'inscrit, dit bonjour, le serveur envoie le message à 2 personnes.<br/>
La 3e personne s\'inscrit, dit bonjour, le serveur envoie le message à 3 personnes.<br/>
<br/>
<br/>
Minute #1: 2 messages sont envoyés<br/>
Minute #2: 3 messages sont envoyés<br/>
Minute #3: 4 messages sont envoyés<br/>
En additionnant ceux-ci pour une durée de 3 minutes, on obtient que 9 messages ont été envoyés par le serveur.<br/>
<br/>
Notes à propos de la conversion d\'unités : 0xfffbadc0ded est la représentation hexadécimale qui se convertie en base 10 en 17\'591\'026\'060\'781 (C\'est environ 20 billion de minutes).<br/>
Veuillez soumettre votre solution dans le système décimale (base 10).
',

);

?>
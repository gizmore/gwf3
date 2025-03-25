<?php
$lang = array(
    'title' => 'Gizmore Encryption',
    'info' =>
        'J\'ai créé un chiffrement symétrique pour ajouter une couche de sécurité à l\'obfuscation de mes projets.<br/>'.PHP_EOL.
        'Pouvez-vous m\'aider et vérifier si c\'est facilement cassable, même si la clé est secrète ?<br/>'.PHP_EOL.
        '<br/>'.PHP_EOL.
        'Vous pouvez aussi <a href="%1$s">voir l algorithme</a>, ainsi que la <a href="%2$s">version surlignée</a>.<br/>'.PHP_EOL.
        '<br/>'.PHP_EOL.
        'Pour prouver que c\'est facilement cassable, vous devez déchiffrer le message suivant.<br/>'.PHP_EOL.
        'L\'ensemble du texte est lisible en français.<br/>'.PHP_EOL.
        'Il n\'y a pas de saut de ligne, mais la ponctuation est correcte.<br/>'.PHP_EOL.
        'Il y a un mot qui n\'existe pas : la solution aléatoire, sous forme de 12 caractères hexadécimaux en majuscules.<br/>'.PHP_EOL.
        '<br/>'.PHP_EOL.
        '<pre style="%3$s">'.PHP_EOL.
        '%4$s'.PHP_EOL.
        '</pre>'.PHP_EOL.
        'Vous pouvez aussi <a href="%5$s">télécharger le texte chiffré sous forme de fichier</a>.<br/>'.PHP_EOL.
        '<br/>'.PHP_EOL.
        'Indice supplémentaire : la clé secrète fait 11 caractères, et contient seulement [a-zA-Z].<br/>'.PHP_EOL.
        'Merci à %6$s et %7$s pour leurs tests et retours sur le challenge.<br/>'.PHP_EOL,
 
    'message' => 'Bonjour, il paraît que vous êtes capable de lire ce texte. C\'est étonnant ! Ce serait bien si vous pouviez laisser un message dans le forum des solutions, nous disant comment vous l\'avez résolu. Oh, j ai oublié de vous donner le mot de passe : %1$s. Dans le cas ou vous essayez encore et que vous n\'avez pas de chance, vous avez peut-être besoin de plus de texte chiffré, donc ce texte est là pour ça. Merci à grimmjowbo pour la traduction.',

    'title_src' => 'Code source de <b>&quot;%1$s&quot;</b>',
);
?>

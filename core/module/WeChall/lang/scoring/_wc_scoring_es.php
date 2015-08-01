<?php
$lang = array(
	# Scoring Faq
	'pt_scorefaq' => '[WeChall] Preguntas frecuentes sobre la puntuación',
	'mt_scorefaq' => 'Preguntas frecuentes sobre la puntuación en WeChall explicadas.',
	'scoring_faqt' => 'Puntuación en WeChall',
	'scoring_faq' => 
		'Esta página describe la puntuación en WeChall.<br/>'.
		'<br/>'.
		'Actualmente, cada sitio contiene ciertas puntuaciones que dependen de tres factores::<br/>'.
		'<br/>'.
		'1. La puntuación base para el sitio.<br/>'.
		'2. El número de retos que contiene.<br/>'.
		'3. Qué tan bien nuestros usuarios participan en él.<br/>'.
		'<br/>'.
		'Ejemplo:<br/>'.
		'La puntuación base de Electrica es 10000 (valor por defecto, ajustable por los administradores).<br/>'.
		'Ya que el sitio contiene 44 retos entonces una puntuación de 25 * 44 = 1100 es agregada para obtener un total de 11100.'.
		'En promedio nuestros usuarios han completado un 45%% del sitio.<br/>'.
		'La puntuación para ese sitio se convierte entonces en base + base - promedio * base, o<br/>'.
		'11100 + 11100 - 4662 = 17538 puntos.<br/>'.
		'Así que mientras más difícil es el sitio más puntos generará.<br/>'.
		'<br/>'.
		'La puntuación de un sitio determina cuánta puntuación en WeChall obtendrás.<br/>'.
		'<br/>'.
		'Ejemplo:<br/>'.
		'Imagina que Peter obtiene 30000 puntos en HackQuest, de un máximo de 100000 puntos..<br/>'.
		'Esto significa que Peter ha resuelto el 30%% de HackQuest.<br/>'.
		'El porcentaje p es ajustado con la fórmula pow(p, 1 + 100 / 97) lo cual hace que porcentajes mayores valgan relativamente más que porcentajes menores. El 100 es un factor ajustable por los administradores, y el 97 es el número de retos en HackQuest.<br/>'.
		'Es así como en WeChall él obtiene 9%% (pow(30%%, 2.03)) de la puntuación de HackQuest.<br/>'.
		'HackQuest actualmente tiene una puntuación de 19698, así que Peter obtiene 1708 de puntuación en WeChall.<br/>'.
		'<br/>'.
		'Los administradores pueden ajustar manualmente la puntuación base de los sitios.<br/>'.
		'Es posible que un sitio con menos retos o más fáciles obtenga una puntuación menor que un sitio con muchos retos difíciles.<br/>'.
		'<br/>'.
		'No dudes en preguntar en el <a href="%s">foro</a> si algo de esto no es claro para ti.',
);
?>

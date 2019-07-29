<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Find out who TuB is.',
		'tub' => 'We met TuB on slayradio. He is one of the founders of #c64clubberlin (in real, not the freenode channel).',
	),
	'de' => array(
		'help' => 'Nutze %CMD%. Finde heraus wer TuB ist.',
		'tub' => 'Wir haben TuB durch slayradio kennengelernt. Er ist einer der Gründer von #c64clubberlin. (In echt, nicht der freenode Kanal)',
	),
);
return Dog::getPlugin()->rply('tub');

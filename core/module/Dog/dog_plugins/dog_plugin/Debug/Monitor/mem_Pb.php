<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Print memory usage statistics.',
		'usage' => 'Currently there are %s in use. Max memory peak was %s.'
	),
	'de' => array(
		'help' => 'Nutze: %CMD%. Gibt Statistiken über die Speichernutzung aus.',
		'usage' => 'Zur Zeit werden %s Speicher verwendet. Die maximale Auslastung betrug %s.'
	),
);
Dog::getPlugin()->rply('usage',
	array(
		GWF_Upload::humanFilesize(memory_get_usage(true), '1000'),
		GWF_Upload::humanFilesize(memory_get_peak_usage(true), '1000')
	)
);
?>

<?php
$lang = array(
	'title' => 'PHP - Local File Inclusion',
	'info' =>
		'Sinun tehtäväsi on hyödyntää tätä koodia, joka on ilmeisesti <a href="http://en.wikipedia.org/wiki/Local_File_Inclusion">LFI heikkous</a>:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1$s</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'On paljon tärkeää tavaraa <a href="%2$s">../solution.php</a>, joten liitä mukaan ja suorittaa tämän tiedoston meille.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Seuraavassa on muutamia esimerkkejä skriptin toiminnassa(laatikossa alhaalla):<br/>'.PHP_EOL.
		'<a href="%5$s">%5$s</a><br/>'.PHP_EOL.
		'<a href="%6$s">%6$s</a><br/>'.PHP_EOL.
		'<a href="%7$s">%7$s</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Virheenjäljitykseen varten, voit tarkastella<a href="%3$s">koko lähdekoodia</a>, kuten myös<a href="%4$s">Korostettua versiota</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'Haavoittuvia skripti toiminnassa',
	'err_basedir' => 'Tämä hakemisto ei ole osa haastetta.',
	'credits' => 'Kiitos lähteä %1$s hänen alfa-testausvaiheessa, suuria ajatuksia ja motivaatiota!',
	'msg_solved' => 'Hyvin tehty. Jos löydät paikallisen tiedoston osallisuutta yleensä laatikko voi saada murtautunut muutamassa minuutissa.',
);
?>
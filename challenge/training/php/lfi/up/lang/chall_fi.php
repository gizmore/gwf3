<?php
$lang = array(
	'title' => 'Local File Inclusion',
	'info' =>
		'Sinun tehtäväsi on hyödyntää tätä koodia, joka on ilmeisesti <a href="http://en.wikipedia.org/wiki/Local_File_Inclusion">LFI heikkous</a>:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1%</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'On paljon tärkeää tavaraa <a href="%2%">../solution.php</a>, joten liitä mukaan ja suorittaa tämän tiedoston meille.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Seuraavassa on muutamia esimerkkejä skriptin toiminnassa(laatikossa alhaalla):<br/>'.PHP_EOL.
		'<a href="%5%">%5%</a><br/>'.PHP_EOL.
		'<a href="%6%">%6%</a><br/>'.PHP_EOL.
		'<a href="%7%">%7%</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Virheenjäljitykseen varten, voit tarkastella<a href="%3%">koko lähdekoodia</a>, kuten myös<a href="%4%">Korostettua versiota</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'Haavoittuvia skripti toiminnassa',
	'err_basedir' => 'Tämä hakemisto ei ole osa haastetta.',
	'credits' => 'Kiitos lähteä %1% hänen alfa-testausvaiheessa, suuria ajatuksia ja motivaatiota!',
	'msg_solved' => 'Hyvin tehty. Jos löydät paikallisen tiedoston osallisuutta yleensä laatikko voi saada murtautunut muutamassa minuutissa.',
);
?>
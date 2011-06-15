<?php
$lang = array(
	'title' => 'Regex harjoitus haaste (Taso %1%)',

	'err_wrong' => 'Sinun vastauksesi on väärä, tai kysymykseen löytyy lyhyempikin ratkaisu.',
	'err_no_match' => 'Sinun kaavasi ei vastaa&quot;%1%&quot;a.',
	'err_matching' => 'Sinun kaavasi vastaa&quot;%1%&quot;, Vaikkasen ei kuuluisi vastata sitä.',
	'err_capturing' => 'Sinun kaavasi kyllä kaappasi jonon, mutta sitä ei tässä tilanteessa kaivattu. Käytä kaappaamatonta koodiryhmää.',
	'err_not_capturing' => 'Sinun kaavasi ei vangitse haluttua merkkijonoa oikein.',
	'err_too_long' => 'Sinun kaavasi on pidempi kuin suositeltu ratkaisu, %1%:llä merkillä.',

	'msg_next_level' => 'Oikein, katsotaan löydätkö oikean ratkaisun myös seuraavaan ongelmaan.',
	'msg_solved' => 'Hyvin tehty, tämä riittää hyvin ensimmäiseksi oppitunniksi säännöllisiä lausekkeita. Tehtävä suoritettu.',
	
	# Levels
	'info_1' =>
		'Sinun tavoitteesi tässä haasteessa on oppia regex syntaksi.<br/>'.PHP_EOL.
		'Regular Expression:it ovat tehokas väline matkalla ohjelmoinnin hallitsemiseen, joten sinun pitäisi pystyä ratkaisemaanovat tehokas väline matkalla master ohjelmointi, joten sinun pitäisi pystyä ratkaisemaan tämän haasteen ainakin tämän haasteen!<br/>'.PHP_EOL.
		'Ratkaisu jokaiseen tehtävään on aina lyhin mahdollinen Regular Expression kaava.<br/>'.PHP_EOL.
		'Huomaa myös, että sinulla on esittää erottimia ja kuvioita myös. Esimerkki Kaava: <b>/joe/i</b>. Erottimen täytyy olla: <b>/</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Ensimmäinen oppitunti on helppoa: lähetä säännöllinen lauseke vastaa tyhjää merkkijonoa, ja vain tyhjä merkkijono.<br/>',

	'info_2' => 
		'Helppo riitä. Seuraava tehtävä on antaa säännöllinen lauseke, joka vastaa vain merkkijonon \'wechall\' ilman lainausmerkkejä.',

	'info_3' => 
		'Ok, yhteensovitus staattinen merkkijonoja ei päätavoite säännöllisiä lausekkeita.<br/>'.PHP_EOL.
		'Seuraava tehtävä on esittää lauseke, joka vastaa voimassa filenames tietynlaisia kuvia.<br/>'.PHP_EOL.
		'Teidän malli on ottelun kaikki kuvat nimi wechall.ext tai wechall4.ext ja kelvollinen kuva laajennus.<br/>'.PHP_EOL.
		'Voimmassa olevat tiedoston päätteet are .jpg, .gif, .tiff, .bmp and .png.<br/>'.PHP_EOL.
		'Tässä muutamia esimerkkejä voimassaolevista tiedostonimistä: wechall4.tiff, wechall.png, wechall4.jpg, wechall.bmp',

	'info_4' =>
		'On mukavaa, että meillä on voimassa kuvia nyt, mutta voisitko kaapata tiedostonimi myös ilman laajennusta?<br/>'.PHP_EOL.
		'Esimerkiksi: wechall4.jpg pitäisi kaapata/palauttaa wechall4 sinun malli nyt.',

	'info_5' => 
		'Olet hyvin. Seuraava tehtävä on vastata kaikkiin voimassa http ja https URL, mutta vain karkeasti.<br/>'.PHP_EOL.
		'Esimerkki kelvollinen URL-osoite on https://abc.de tai http://abc.foobar/blub<br/>'.PHP_EOL.
		'Vihje: On yksi char voit varmasti jättää pois kaavastasi.',
);
?>
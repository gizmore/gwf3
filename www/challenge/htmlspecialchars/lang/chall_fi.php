<?php
$lang = array(
	'title' => 'Tehtäväsi...',
	'info' => 
		'On hyödyntää tätä koodi riviä, joka on altis XSS:lle:'.PHP_EOL.
		'[code=PHP title=htmlspecialchars.php]%1$s[/code]'.PHP_EOL.
		'[url=%2$s]Common::getPost[/url] vain hakee merkkijonon [url=%3$s]$_POST muuttujat[/url], jotka koskevat [url=%4$s]stripslashes()[/url], siinä tapauksessa, että [url=%5$s]magic_quotes_gpc()[/url] ovat mahdollistettu.'.PHP_EOL.
		'Voit ohittaa [url=%2$s]Common::getPost[/url] kokonaan, korvaat $_POST[\'input\'], Olettaen että [url=%5$s]magic_quotes_gpc()[/url] on estetty.'.PHP_EOL.
		PHP_EOL.
		'Syötelaatikon alla on koodin syöte, testataksesi hyökkäyksiäsi.'.PHP_EOL.
		'Sinä kuitenkin epäonnistut jokatapauksessa, koska käytin [url=%6$s]htmlspecialchars()[/url] estääkseni XSS:n.'.PHP_EOL.
		PHP_EOL.
		'[i]Gizmore - March, 23th 2009[/i]',
		
	'input_title' => 'Input box',
	'input_info' =>
		'<form action="" method="post">'.PHP_EOL.
		'<div>%2$s</div>'.PHP_EOL.
		'<div>Input: <input type="text" name="input" size="60" value="%1$s" /></div>'.PHP_EOL.
		'<div><input type="submit" name="exploit" value="Exploit It" /></div>'.PHP_EOL.
		'</form>'.PHP_EOL,
	
	'output_title' => 'Your output',
	'click_me' => 'Click me',
	'output_info' =>
		'Here is the output of your input:<br/>'.PHP_EOL.
		'Use the form above, to exploit the link.<br/>'.PHP_EOL.
		PHP_EOL.
		'%1$s',
		
	'solve_note' => 'Your solution is the same line of code, but with an easy fix for it.',
		
	'fun_msg_1' => 'Yeah! olet korjannut sen!',
	'fun_msg_2' => 'No, seriously, maybe alter the line of code before pressing submit.',
	'msg_close' => 'Sinä näytät olevan hyvin lähellä :)',
	'err_wrong' => 'Ei, ratkaisu vaikuttaa väärältä. Kokeile jotakin helpompaa tapaa korjata se.',
);
?>

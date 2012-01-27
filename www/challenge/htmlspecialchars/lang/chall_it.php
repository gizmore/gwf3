<?php
$lang = array(
	'title' => 'La tua missione...',
	'info' => 
		'E\' quella di sfruttare questa linea di codice, che è vulnerabile a XSS:'.PHP_EOL.
		'[code=PHP title=htmlspecialchars.php]%1$s[/code]'.PHP_EOL.
		'[url=%2$s]Common::getPost[/url] recupera una stringa dalle [url=%3$s]variabili $_POST[/url] e applica [url=%4$s]stripslashes()[/url], nel caso in cui [url=%5$s]magic_quotes_gpc()[/url] fosse attivato.'.PHP_EOL.
		'uoi ignorare [url=%2$s]Common::getPost[/url] completamente, rimpiazzandolo con by $_POST[\'input\'], e assumere che [url=%5$s]magic_quotes_gpc()[/url] sia disattivato.'.PHP_EOL.
		PHP_EOL.
		'Qui sotto la casella di input viene riportato l\'output dello script, per testare i tuoi attacchi.'.PHP_EOL.
		'Fallirai lo stesso, poichè ho utilizzato [url=%6$s]htmlspecialchars()[/url] per prevenire un attacco XSS.'.PHP_EOL.
		PHP_EOL.
		'[i]Gizmore - March, 23th 2009[/i]',
		
	'input_title' => 'Casella di input',
	'input_info' =>
		'<form action="" method="post">'.PHP_EOL.
		'<div>%2$s</div>'.PHP_EOL.
		'<div>Input: <input type="text" name="input" size="60" value="%1$s" /></div>'.PHP_EOL.
		'<div><input type="submit" name="exploit" value="Sfruttalo" /></div>'.PHP_EOL.
		'</form>'.PHP_EOL,
	
	'output_title' => 'Il tuo output',
	'click_me' => 'Cliccami',
	'output_info' =>
		'Qui c\'è l\'output del tuo input:<br/>'.PHP_EOL.
		'Usa il form sovrastante per sfruttare il link.<br/>'.PHP_EOL.
		PHP_EOL.
		'%1$s',
		
	'solve_note' => 'La tua soluzione è la stessa linea di codice, ma con un semplice rimedio per prevenire l\'attacco.',
		
	'fun_msg_1' => 'Si! L\'hai aggiustata!',
	'fun_msg_2' => 'No, veramente, fai qualche modifca al codice prima  di cliccare invio.',
	'msg_close' => 'Sembri molto vicino :)',
	'err_wrong' => 'No, la soluzione sembra sbagliata. Prova qualche rimedio più semplice.',
);
?>

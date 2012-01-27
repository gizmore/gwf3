<?php
$lang = array(
	'title' => 'Your mission...',
	'info' => 
		'Is to exploit this line of code, which is vulnerable to XSS:'.PHP_EOL.
		'[code=PHP title=htmlspecialchars.php]%1$s[/code]'.PHP_EOL.
		'[url=%2$s]Common::getPost[/url] only fetches a string from the [url=%3$s]$_POST variables[/url] and applies [url=%4$s]stripslashes()[/url], in case [url=%5$s]magic_quotes_gpc()[/url] are enabled.'.PHP_EOL.
		'You can ignore [url=%2$s]Common::getPost[/url] completely, replace it by $_POST[\'input\'], and assume [url=%5$s]magic_quotes_gpc()[/url] are disabled.'.PHP_EOL.
		PHP_EOL.
		'Below the input box is the output of the script, to test your attacks.'.PHP_EOL.
		'You will fail anyway, because I used [url=%6$s]htmlspecialchars()[/url] to prevent XSS.'.PHP_EOL.
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
		
	'fun_msg_1' => 'Yeah! you fixed it!',
	'fun_msg_2' => 'No, seriously, maybe alter the line of code before pressing submit.',
	'msg_close' => 'You seem to be very close :)',
	'err_wrong' => 'No, your solution seems wrong. Try some easier way to fix it.',
);
?>

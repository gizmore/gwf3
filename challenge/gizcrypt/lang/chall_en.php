<?php
$lang = array(
	'title' => 'Gizmore Encryption',
	'info' =>
		'I created an symmetric encryption to add a layer of security or obfuscation to my projects.<br/>'.PHP_EOL.
		'Can you help me and find out if it`s easily broken, even when the key is secret?<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'You can <a href="%1%">take a look at the algorithm</a>, also as <a href="%2%">highlighted version</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'To prove that it`s easily broken, you have to decipher the following message.<br/>'.PHP_EOL.
		'The whole plaintext is readable and in the current language.<br/>'.PHP_EOL.
		'There are no line breaks, but correct punctuation.<br/>'.PHP_EOL.
		'There is one word that does not exist: your random solution, which is 12 random chars in uppercase HEX.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<pre style="%3%">'.PHP_EOL.
		'%4%'.PHP_EOL.
		'</pre>'.PHP_EOL.
		'You can also <a href="%5%">download the ciphertext as a file</a>.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Additional hint: The secret key is 11 chars long, and contains only a-zA-Z.<br/>'.PHP_EOL.
		'Thanks go out to %6% and %7% for their feedback and testing the challenge.<br/>'.PHP_EOL,
		
	'message' => 'Hello, It seems like you are able to read this text. This is amazing! It would be cool if you can leave a message in the solution forums, telling us how you solved it. Oh, i almost forgot to tell you the password: %1%. In case you are still trying and have no luck, you maybe need some more ciphertext. This is the end of the message.',

	'title_src' => 'Sourcecode of <b>&quot;%1%&quot;</b>',
);
?>
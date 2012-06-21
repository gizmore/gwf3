<?php
$lang = array(
	'title' => 'The Crash',
	'info' =>
		'My system harddisk crashed and i have lost the password to all my encrypted harddisks.<br/>'.PHP_EOL.
		'The only thing i got is a file encrypted with AES256, where i am sure i am using the same password.<br/>'.PHP_EOL.
		'The algorithm i have used to encrpyt the file was something like <i>%s</i>.<br/>'.PHP_EOL.
		'Can you help me to recover my password please?<br/>'.PHP_EOL.
		'Oh, i am quite sure i chose 8 random lowercase letters as the password. I guess this will help you a lot :)<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Note: The password is <b>bound to your username</b> (or session in case you are not logged in) and the plaintext was some php script i wrote. You can <a href="%s" title="The ciphertext">download the ciphertext here</a>.<br/>'.PHP_EOL.
		'The final solution to this challenge is the 8 letter random password followed by an underscore and the md5sum of the decrypted file. Example: abcdefgh_12345678901234567890123456789012.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good luck!<br/>'.PHP_EOL,
		'gizmore'.PHP_EOL,
)
?>

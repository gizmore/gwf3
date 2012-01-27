<?php
$lang = array(
	'title' => 'Bacon Returns',
	'info' =>
		'Mr. <a href="%1$s">Bacon</a> is back and wants to challenge you again.<br/>'.
		'This time it is way harder to decode. I have changed the encoder after researching the baconian chiffre on the interwebs.<br/>'.
		'<br/>'.
		'Note one: We still use a full 26 character encoding.<br/>'.
		'Note two: X means space as a word separator.<br/>'.
		'Note three: Your solution is again random and bound to your session.',

	'msg_title' => 'The Message',
	'message' =>
		'Bacon\'s cipher or the Baconian cipher is a method of steganography (a method of hiding a secret message as opposed to a true cipher) devised by Francis Bacon. A message is concealed in the presentation of text, rather than its content.'.PHP_EOL.
		'To encode a message, each letter of the plaintext is replaced by a group of five of the letters \'A\' or \'B\'. This replacement is done according to the alphabet of the Baconian cipher, shown below.'.PHP_EOL.
		'Note: A second version of Bacon\'s cipher uses a unique code for each letter. In other words, I and J each has its own pattern.'.PHP_EOL.
		'The writer must make use of two different typefaces for this cipher. After preparing a false message with the same number of letters as all of the As and Bs in the real, secret message, two typefaces are chosen, one to represent As and the other Bs. Then each letter of the false message must be presented in the appropriate typeface, according to whether it stands for an A or a B.'.PHP_EOL.
		'To decode the message, the reverse method is applied. Each \'typeface 1\' letter in the false message is replaced with an A and each \'typeface 2\' letter is replaced with a B. The Baconian alphabet is then used to recover the original message.'.PHP_EOL.
		'Any method of writing the message that allows two distinct representations for each character can be used for the Bacon Cipher. Bacon himself prepared a Biliteral Alphabet[2] for handwritten capital and small letters with each having two alternative forms, one to be used as A and the other as B. This was published as an illustrated plate in his De Augmentis Scientiarum (The Advancement of Learning).'.PHP_EOL.
		'Because any message of the right length can be used to carry the encoding, the secret message is effectively hidden in plain sight. The false message can be on any topic and thus can distract a person seeking to find the real message.',

	'hidden' => 'You can read the hidden message so I will tell you the solution which is twelve random letters %1$s',
);
?>
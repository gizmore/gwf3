<?php
$lang = array(
	'title' => 'Britcoin',
	'subtitle' => 'Input, Computation, Output',
	'hint' => 'Your initial block data differs when you change your language -.-',
	'err_nonce_fmt' => 'Invalid nonce. It has to be 32 chars uppercase HEX.',
	'msg_nice_nonce' => 'Nice Nonce, but difficulty not matched.',
	'info' =>
		'gizmore, sabretooth and dloser lost all their money they had invested into cryptocurrencies.<br/>'.PHP_EOL.
		'In a rush, dloser asks gizmore to create their own cryptocoin.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'But before we even start we wonder about the underlying cryptographic prove of work algorithm.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Your job is to hash a hash with a nonce to produce a valid prove of work, according to the <a href="%s">specs</a><br/>.'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Before i forget; This is your session´s initial Block data:<br/>'.PHP_EOL.
		'%s'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'And this is the computed nonce zero for comparison:<br/><b>%s</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Your pow hash has to start with %s.<br/>'.PHP_EOL.
		'Your nonce is your answer, uppercase 32 hex digits.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good luck!<br/>'.PHP_EOL.
		'gizmore',
	# @translators: Feel free to replace this fake json with greetings to your friends and other players.
    # @translators: IMPORTANT is to keep the %s data somewhere (sessid)
	'payload' => '{"initial_trust":null,"transactions":[{"from":null,"to":"%s","amt":1,"note":"Mining success"}, {"from":null,"to":"livinskull","amt":1},{"from":null,"to":"sabretooth","amt":1},{"from":"livinskull","to":"sabretooth","amt":0.000000001,"note":"Fraction check"}]}',
);


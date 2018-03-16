<?php
$lang = array(
	'title' => 'Britcoin',
	'subtitle' => 'Reading and Performing',
	'hint' => 'Your initial block data differs when you change your language -.-',
	'err_nounce_fmt' => 'Invalid nounce. It has to be 32 chars uppercase HEX.',
	'msg_nice_nounce' => 'Nice Nounce, but difficulty not matched.',
	'info' =>
		'gizmore unlimited(tm) and sabrefilms(rg) have invested into various crypto coins. (storyline-joke!)<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Now we want to place our own coin at the market, but before we even start we wonder about the underlying cryptographic prove of work algorithm.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Your job is to hash a hash with a nounce to produce a valid prove of work, according to the <a href="%s">specs</a><br/>.'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Before i forget; This is your session´s initial Block data:<br/>'.PHP_EOL.
		'%s'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'And this is the computed nounce zero for comparison:<br/><b>%s</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Your pow hash has to start with %s.<br/>'.PHP_EOL.
		'Your nounce is your answer, uppercase 32 hex digits.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Good luck!<br/>'.PHP_EOL.
		'gizmore',
	# @translators: Feel free to replace this fake json with greetings to your friends and other players.
    # @translators: IMPORTANT is to keep the %s data somewhere (sessid)
	'payload' => '{initial_trust:null,transactions:[{"from":null,"to":"%s","amt":1,note:"Mining success"}, {"from":null,"to":"livinskull",amt:1},{"from":null,to:"sabretooth",amt:1},{from:"livinskull",to:"sabretooth","amt":0.000000001,"note":"Fraction check"}]}',
);


<?php
$lang = array(
	'title' => 'PHP-0817',
	'info' =>
		'I have written another include system for my dynamic webpages, but it seems to be vulnerable to LFI.<br/>'.
		'Here is the code:<br/>'.
		'%1%<br/>'.
		'Your mission is to include <a href="%2%">solution.php</a>.<br/>'.
		'Here is the script in action: <a href="%3%">News</a>, <a href="%4%">Forum</a>, <a href="%5%">Guestbook</a>.<br/>'.
		'<br/>'.
		'Good Luck!<br/>',

	'msg_solved' => 'Well done, too easy... Do you know why this is possible?',
	'err_security' => 'Because the code is damn vulnerable, dot and slash are not allowed in your input.',
);
?>
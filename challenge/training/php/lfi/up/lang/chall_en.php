<?php
$lang = array(
	'title' => 'Local File Inclusion',
	'info' =>
		'Your mission is to exploit this code, which has obviously an <a href="http://en.wikipedia.org/wiki/Local_File_Inclusion">LFI vulnerability</a>:<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'<code>%1%</code><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'There is a lot of important stuff in <a href="%2%">../solution.php</a>, so please include and execute this file for us.<br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Here are a few examples of the script in action (in the box below):<br/>'.PHP_EOL.
		'<a href="%5%">%5%</a><br/>'.PHP_EOL.
		'<a href="%6%">%6%</a><br/>'.PHP_EOL.
		'<a href="%7%">%7%</a><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'For debugging purposes, you may look at the <a href="%3%">whole source</a> again, also as <a href="%4%">highlighted version</a>.<br/>'.PHP_EOL.
		'',

	'example_title' => 'The vulnerable script in action',
	'err_basedir' => 'This directory is not part of the challenge.',
	'credits' => 'Thanks go out to %1% for his alpha testing, great thoughts and motivation!',
	'msg_solved' => 'Well done. If you find a local file inclusion, usually the box can get hacked into within minutes.',
);
?>
<?php
$lang = array(
	'title' => 'Training: WWW-Rewrites',
	'info' =>
		'In WWW-Basics you learned how to setup an http server.<br/>'.
		'Now the task is a bit more challenging:<br/>'.
		'The challenge will request a random file from your server, with the sheme %1$s[0-9]+_mul_[0-9]+.html<br/>'.
		'Your server has to respond to the request with the result of number1*number2.<br/>'.
		'<br/>'.
		'Example request: %1$s1000_mul_20.html<br/>'.
		'Correct response: 20000<br/>'.
		'<br/>'.
		'Enjoy!',

	'btn_go' => 'I have set it up. Please check my server.',
	'err_file_not_found' => 'Your webserver seems to be unreachable.',
	'err_wrong' => 'Your served content (%3$s bytes)<br/>%1$s<br/>differs from the wanted (%4$s bytes)<br/>%2$s<br/>Please fix that!',
);
?>
<?php
$lang = array(
	'title' => 'Regex Training Challenge (Level %1$s)',

	'err_wrong' => 'Your answer is wrong, or there is a shorter solution to the problem.',
	'err_no_match' => 'Your pattern would not match &quot;%1$s&quot;.',
	'err_matching' => 'Your pattern would match &quot;%1$s&quot;, but it should not match it.',
	'err_capturing' => 'Your pattern would capture a string, but this is not wanted. Please use a non capturing group.',
	'err_not_capturing' => 'Your pattern does not capture the wanted string correctly.',
	'err_too_long' => 'Your pattern is longer than the reference solution with %1$s chars.',

	'msg_next_level' => 'Correct, let`s see if you can come up with a pattern for the next problem.',
	'msg_solved' => 'Well done, this is enough for a very first lesson of regular expressions. Mission accomplished.',
	
	# Levels
	'info_1' =>
		'Your objective in this challenge is to learn the regex syntax.<br/>'.PHP_EOL.
		'Regular Expressions are a powerful tool in your way to master programming, so you should be able to solve this challenge, at least!<br/>'.PHP_EOL.
		'The solution to every task is always the shortest regular expression pattern possible.<br/>'.PHP_EOL.
		'Also note that you have to submit delimiters in the patterns too. Example pattern: <b>/joe/i</b>. The delimiter has to be <b>/</b><br/>'.PHP_EOL.
		'<br/>'.PHP_EOL.
		'Your first lesson is easy: submit the regular expression the matches an empty string, and only an empty string.<br/>',

	'info_2' => 
		'Easy enough. Your next task is to submit a regular expression that matches only the string \'wechall\' without quotes.',

	'info_3' => 
		'Ok, matching static strings is not the main goal of regular expressions.<br/>'.PHP_EOL.
		'Your next task is to submit an expression that matches valid filenames for certain images.<br/>'.PHP_EOL.
		'Your pattern shall match all images with the name wechall.ext or wechall4.ext and a valid image extension.<br/>'.PHP_EOL.
		'Valid imgage extensions are .jpg, .gif, .tiff, .bmp and .png.<br/>'.PHP_EOL.
		'Here are some examples for valid filenames: wechall4.tiff, wechall.png, wechall4.jpg, wechall.bmp',

	'info_4' =>
		'It is nice that we have valid images now, but could you please capture the filename, without extension, too?<br/>'.PHP_EOL.
		'As an example: wechall4.jpg should capture/return wechall4 in your pattern now.',

	'info_5' => 
		'You are doing well. Your next task is to match all valid http and https URLs, but only roughly.<br/>'.PHP_EOL.
		'An example for a valid url is https://abc.de or http://abc.foobar/blub<br/>'.PHP_EOL.
		'Hint: There is one char you can surely exclude from the pattern.',
);
?>
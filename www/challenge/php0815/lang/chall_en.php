<?php

$lang = array(
	'title' => 'PHP 0815 Challenge',
	'info' => 
	'I have <a href="%1$s">this script</a> and its prone to sql injection.<br/>Your mission is to provide me with a fix.<br/>'.
	'The solution is the fix with the least effort (The shortest way to fix at some logic position), and guarantee the script does still work.<br/>'.
	'if you think <i>&quot;urldecode()&quot;</i> will fix the script you simply enter it as solution.<br/>'.
	'The solution has to contain all chars that you need to type.<br/>'.
	'Feel Free to discuss it in the forums, its kinda training challenge :)',

	'08151' => 'Good job, you typecasted $show to an integer value. The real world solution is (int) or intval() or even settype()',
	'08152' => 'Correct, You got the official recommended solution, But: You can cast to integer with only 2 chars!',
	'08153' => 'If you try to modify in_array() you are on a good track. Sadly it stops the script from working :(',
	'08154' => 'You can go shorter!',

	'0815_solved' => 'Congrats, wasn\'t too hard, was it?<br/>Your lesson learned is to <b>typecast stuff properly!</b>',

	'08155' => 'Funny solution. It would work but cost you 6 chars. You can do better!',

	'08156' => 'Interesting idea. It would indeed kinda work, but the shortest solution is only 2 chars.',
);

?>

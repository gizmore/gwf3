<?php

$lang = array(
	'title' => 'PHP 0815 skrypt',

	'Mam <a href="%1%">skrypt</a>, który jest podatny na SQL Injection.<br/>'.
	'Twoim zadaniem jest wskazanie sposobu na jego naprawę.<br/>'.
	'Rozwiązaniem jest najktórsza zmiana, gwarantująca, że skrypt nadal będzie działać.<br/>'.
	'Jeśli myślisz, że <i>&quot;urldecode()&quot;</i> naprawi problem, po prostu wpisz to jako rozwiązanie.<br/>'.
	'Jest to rodzaj treningowego zadania, nie krępuj się rozmawiać o nim na forum. :)',

	'08151' => 'Good job, you typecasted $show to an integer value. The real world solution is (int) or intval() or even settype()',
	'08152' => 'Correct, You got the official recommended solution, But: You can cast to integer with only 2 chars!',
	'08153' => 'If you try to modify in_array() you are on a good track. Sadly it stops the script from working :(',
	'08154' => 'You can go shorter!',

	'0815_solved' => 'Congrats, wasn\'t too hard, was it?<br/>Your lesson learned is to <b>typecast stuff properly!</b>',

	'08155' => 'Funny solution. It would work but cost you 6 chars. You can do better!',
	'08156' => 'Interesting idea. It would indeed kinda work, but the shortest solution is only 2 chars.',
);

?>

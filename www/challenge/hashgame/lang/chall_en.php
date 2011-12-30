<?php
$lang = array(
	'title' => 'WeChall Hashing Game',
	'info' => 
		'Welcome to the WeChall Hashing Game.<br/>'.
		'Your mission is to crack 2 lists of hahes.<br/>'.
		'The <a href="%1$s">first list</a> is using the <a href="%2$s">WC3 hashing algorithm</a>, which uses some fixed salt md5.<br/>'.
		'The <a href="%3$s">second list</a> is using the <a href="%4$s">WC4 hashing algorithm</a>, which uses salted sha1.<br/>'.
		'<br/>'.
		'The solution is the 2 longest plaintexts of each list, concatinated with a comma.<br/>'.
		'Example solution: wordfrom1,wordfrom1,wordfrom2,wordfrom2.<br/>'.
		'<br/>'.
		'The goal of this challenge is to demonstrate the advantage of the new algo over the old.<br/>'.
		'Note: All passwords are lowercase and real english words from a dictionary.<br/>'.
		'Some thanks go to %5$s, for encouraging me to change WC4 hashing algorithms.<br/>'.
		'<br/>'.
		'Happy cracking!',

	'tt_list_wc3' => 'List of WC3 hashes. (<a href="%1$s">WC3 Algo</a>)',
	'tt_list_wc4' => 'List of WC4 hashes. (<a href="%1$s">WC4 Algo</a>)',

	'err_answer_count' => 'You have to submit 4 words, but you have submitted %1$s.',
	'err_some_good' => 'You got %1$s of 4 words correctly. Try again!',
	'err_answer_count_high' => 'I will only use 4 of your %1$s words.',
);
?>
<?php
$lang = array(
	'title' => 'The Travelling Customer',
	'info' =>
		'In this programming challenge you need to solve the following problem:<br/>'.
		'You are represented a pricelist, an itemamount and a sum, as well as the stock parameter.<br/>'.
		'Your job is to select <i>itemamount</i> items which will result in the sum.<br/>'.
		'You may not select more items than <i>stock</i> from each type.<br/>'.
		'<br/>'.
		'Example:<br/>'.
		'Chips=4<br/>'.
		'Eggs=2<br/>'.
		'<br/>'.
		'Items=5<br/>'.
		'Sum=14<br/>'.
		'Stock=3<br/>'.
		'Level=1<br/>'.
		'<br/>'.
		'An accepted answer would be: 2Chips3Eggs<br/>'.
		'<br/>'.
		'Visit <a href="%1%">%1%</a> to request a new problem.<br/>'.
		'Send your answers to <a href="%2%">%2%?answer=[answer]</a> with the format NItemnameNItemname.<br/>'.
		'You need to solve %3% problems and your timelimit for each problem is %4% seconds.<br/>'.
		'<br/>'.
		'Good Luck!',

	'err_item' => 'Unknown Item: %1%',
	'err_price' => 'Your total price is %1% but you need %2%.',
	'err_item_count' => 'Your response uses %1% known items but you need %2%.',
	'err_reset' => 'You restart at level 1.',
	'err_timout' => 'You needed %1% seconds but you only have %2%.',
	'err_item_num' => 'Your submitted amount for item %1% is invalid. It has to be >= 1.',
	'err_item_stock' => 'You want to purchase %1% %2%`s, but there are only %3% %2%`s available.',
	'err_no_prob' => 'You did not request a problem. It might be that you did not send your cookie correctly.',
	'err_format' => 'Your input format is invalid. Try ?answer=3Chicken4Coke.',
	'err_timeout' => 'Your timelimit for one problem is %2% seconds, but you needed %1% seconds.',
	'msg_next_level' => 'Correct. You are now on level %1%.',
	'msg_solved' => 'Correct. You have solved the challenge.',

	'credits_title' => 'Credits',
	'credits_body' => 'Thanks go out to XKCD, the author of %1%.<br/>The comics there are a great inspiration.',
);
?>
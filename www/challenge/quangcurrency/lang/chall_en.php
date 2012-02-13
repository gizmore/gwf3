<?php
$lang = array(
	# Main Page
	'err_login' => 'You need to login to try this challenge.',
	'title' => 'Description',
	'info' =>
		'Your mission is to <a href="%1$s">purchase</a> 10 items, but you have not enough money to do so.<br/>'.
		'When clicking <a href="%2$s">this link</a> you will get 1 cent for clicking it, but you can only click 50 times.<br/>'.
		'When clicking <a href="%3$s">this link</a> your stats will reset.<br/>'.
		'Navigate <a href="%4$s">here to see your stats</a>.<br/><br/>'.
		'Good luck.', #<br/><br/>'.
		#'<i>Note: Do not change the userid. The userid is needed because I could not call session_start() for this challenge.<br/>The userid is your wechall userid, so in theory you can check out other user`s stats or play with their accounts.</i> (will get fixed)' FIXME,

	# Reset
	'reset_info' => 'Your stats have been reset. Try again!',

	# Stats
	'stats_title' => 'Your stats',
	'stats_info' =>
		'Money in account: %1$s<br/>'.
		'Total clicks made: %2$s<br/>'.
		'Items purchased: %3$s',

	# Buy
	'err_money' => 'You do not have enough money in your account.',
	'msg_buy' => 'Thank you for your purchase. You now have %1$s items in your stock.',
	'msg_solved' => 'What the hack?! How did you get 10 items?!<br/>Anyway ... you solved the challenge and your stats got reset.',

	# Click
	'err_max_clicks' => 'You reached the maximum of %1$s clicks. Please reset your stats.',
	'msg_click_1' => 'Validating your click...',
	'msg_click_2' => 'Limits for today ok...',
	'msg_click_3' => 'Checking timeout...',
	'msg_clicked' => 'Thank you for your click. We rewarded you %1$s credit(s)!',

);
?>
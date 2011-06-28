<?php
$lang = array(
	'info_comments' => '<br/><a href="%1%">%2% comments ...</a>',

	'err_message' => 'Your message has to be between %1% and %2% characters in length.',
	'err_comment' => 'This comment does not exist.',
	'err_comments' => 'These comments do not exist.',
	'err_disabled' => 'The comments here are currently disabled.',
	'err_hashcode' => 'Permission denied.',
	'err_email' => 'Your email looks invalid.',
	'err_www' => 'Your website looks invalid.',
	'err_username' => 'Your username ist invalid and has to be %1% to %2% chars in length.',

	'msg_commented' => 'Your comment has been added.',
	'msg_commented_mod' => 'Your comment has been added, but has to be approved before it is shown.',
	'msg_hide' => 'The comment is now hidden.',
	'msg_visible' => 'The comment is now visible.',
	'msg_deleted' => 'The comment has been deleted.',
	'msg_edited' => 'The comment has been edited.',

	'ft_reply' => 'Leave a comment',
	'btn_reply' => 'Send',

	'btn_hide' => 'Hide',
	'btn_show' => 'Show',

	'ft_edit_cmt' => 'Edit comment',
	'ft_edit_cmts' => 'Edit comment thread',

	'btn_edit' => 'Edit',

	'th_message' => 'Your message',
	'th_www' => 'Your website',
	'th_email' => 'Your email',
	'th_username' => 'Your nickname',
	'th_showmail' => 'Show email to public',

	# Moderation #
	'subj_mod' => GWF_SITENAME.': New comment',
	'body_mod' =>
		'Hello %1%, '.PHP_EOL.
		PHP_EOL.
		'There has been posted a new comment on '.GWF_SITENAME.'.'.PHP_EOL.
		'From: %2%'.PHP_EOL.
		'Mail: %3%'.PHP_EOL.
		'WWW: %4%'.PHP_EOL.
		'Msg:'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		'You can quickly approve the comment: <a href="%6%">%6%</a>'.PHP_EOL.
		PHP_EOL.
		'Or you can quickly delete it: <a href="%7%">%7%</a>'.PHP_EOL.
		PHP_EOL.
		'Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' script',
		
	# Notice #
	'subj_cmt' => GWF_SITENAME.': New comment',
	'body_mod' =>
		'Hello %1%, '.PHP_EOL.
		PHP_EOL.
		'There has been posted a new comment on '.GWF_SITENAME.'.'.PHP_EOL.
		'From: %2%'.PHP_EOL.
		'Mail: %3%'.PHP_EOL.
		'WWW: %4%'.PHP_EOL.
		'Msg:'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		'You can quickly delete it, if desired: <a href="%6%">%6%</a>'.PHP_EOL.
		PHP_EOL.
		'Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' script',
		
);
?>
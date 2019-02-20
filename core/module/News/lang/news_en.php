<?php

$lang = array(
	
	# Messages
	'msg_news_added' => 'The news item has been added successfully.',
	'msg_translated' => 'You translated the news item \'%s\' to %s. Well done.',
	'msg_edited' => 'The news item \'%s\' in %s has been edited.',
	'msg_hidden_1' => 'The News item is now hidden.',
	'msg_hidden_0' => 'The News item is now visible.',
	'msg_mailme_1' => 'The News item has been put into mail queue.',
	'msg_mailme_0' => 'The News item got removed from mail queue.',
	'msg_signed' => 'You signed the newsletter.',
	'msg_unsigned' => 'You unsubscribed from the newsletter.',
	'msg_changed_type' => 'You changed the format of your newsletter subscription.',
	'msg_changed_lang' => 'You changed the preferred language of your newsletter subscription.',

	# Errors
	'err_email' => 'Your email is invalid.',
	'err_news' => 'This news item is unknown.',
	'err_title_too_short' => 'Your title is too short.',
	'err_msg_too_short' => 'Your message is too short.',
	'err_langtrans' => 'This language is not supported.',
	'err_lang_src' => 'The source language is unknown.',
	'err_lang_dest' => 'The destination language is unknown.',
	'err_equal_translang' => 'The source and destination language are equal (Both %s).',
	'err_type' => 'The newsletter format is invalid.',
	'err_unsign' => 'An error occurred.',


	# Main
	'title' => 'News',
	'pt_news' => 'News from %s',
	'mt_news' => 'News, '.GWF_SITENAME.', %s',
	'md_news' => GWF_SITENAME.' News, page %s of %s.',

	# Table Headers
	'th_email' => 'Your email',
	'th_type' => 'Newsletter format',
	'th_langid' => 'Newsletter language',
	'th_category' => 'Category',
	'th_title' => 'Title',
	'th_message' => 'Message',
	'th_date' => 'Date',
	'th_userid' => 'User',
	'th_catid' => 'Category',
	'th_newsletter' => 'Send a newsletter<br/>Please check and do preview(s)!',

	# Preview
	'btn_preview_text' => 'The Text Version',
	'btn_preview_html' => 'The HTML Version',
	'preview_info' => 'You can access the previews of the newsletter here:<br/>%s and %s.',

	# Show 
	'unknown_user' => 'Unknown User',
	'title_no_news' => '----',
	'msg_no_news' => 'There are no news in this category yet.',

	# Newsletter
	'newsletter_title' => GWF_SITENAME.': News',
	'anrede' => 'Dear %s',
	'newsletter_wrap' =>
		'%s, '.PHP_EOL.
		PHP_EOL.
		'You signed up for the '.GWF_SITENAME.' newsletter and there are some news for you.'.PHP_EOL.
		'To unsubscribe from the newsletter visit the link below:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'The news article is listed below:'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL,

	# Types
	'type_none' => 'Choose Format',
	'type_text' => 'Plain Text',
	'type_html' => 'Simple HTML',
		
	# Sign
	'sign_title' => 'Subscribe to the newsletter',
	'sign_info_login' => 'You are not logged in, so we can not detect if you subscribed to the newsletter yet.',
	'sign_info_none' => 'You did not subscribe to the newsletter yet.',
	'sign_info_html' => 'You already subscribed to the newsletter in simple html format.',
	'sign_info_text' => 'You already subscribed to the newsletter in plain text format.',
	'ft_sign' => 'Subscribe to the Newsletter',
	'btn_sign' => 'Subscribe Newsletter',
	'btn_unsign' => 'UnSubscribe Newsletter',
		
	# Edit
	'ft_edit' => 'Edit News Item (in %s)',
	'btn_edit' => 'Edit',
	'btn_translate' => 'Translate',
	'th_transid' => 'Translation',
	'th_mail_me' => 'Send this as newsletter',
	'th_hidden' => 'Hidden?',

	# Add
	'ft_add' => 'Add News Item',
	'btn_add' => 'Add News',
	'btn_preview' => 'Preview (First!)',
		
	# Admin Config
	'cfg_newsletter_guests' => 'Allow newsletter signup for guests',
	'cfg_news_per_adminpage' => 'News per admin page',
	'cfg_news_per_box' => 'News per inline-box',
	'cfg_news_per_page' => 'News per news page',
	'cfg_newsletter_mail' => 'Newsletter mail sender',
	'cfg_newsletter_sleep' => 'Sleep N millis after each mail',
	'cfg_news_per_feed' => 'News per feed page',
	
	# RSS2 Feed
	'rss_title' => GWF_SITENAME.' News Feed',
		
	# V2.03 (News + Forum)
	'cfg_news_in_forum' => 'Post news in forum',
	'board_lang_descr' => 'News in %s',
	'btn_admin_section' => 'Admin section',
	'th_hidden' => 'Hidden',
	'th_visible' => 'Visible',
	'btn_forum' => 'Discuss in forum',
		
	# V3.00 (fixes)
	'rss_img_title' => GWF_SITENAME.' Logo',
	'cfg_news_comments' => 'Enable comments',
		
	# monnino fixes
	'btn_news' => 'News',
	'btn_build_forum' => 'Create News Boards',
);

?>

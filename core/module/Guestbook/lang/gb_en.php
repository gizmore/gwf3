<?php

$lang = array(

	# Default GB Name
	'default_title' => GWF_SITENAME.' Guestbook',
	'default_descr' => 'The '.GWF_SITENAME.' Guestbook',

	# Errors
	'err_gb' => 'The guestbook does not exist.',
	'err_gbm' => 'The guestbook entry does not exist.',
	'err_gbm_username' => 'Your username is invalid. It has to be %1% to %2% chars long.',
	'err_gbm_message' => 'Your message is invalid. It has to be %1% to %2% chars long.',
	'err_gbm_url' => 'Your Website is not reachable or the URL is invalid.',
	'err_gbm_email' => 'Your EMail looks invalid.',
	'err_gb_title' => 'Your Title is invalid. It has to be %1% to %2% chars long.',
	'err_gb_descr' => 'Your Description is invalid. It has to be %1% to %2% chars long.',

	# Messages
	'msg_signed' => 'You successfully signed the Guestbook.',
	'msg_signed_mod' => 'You signed the Guestbook, but your entry has to get approved before it gets shown.',
	'msg_gb_edited' => 'The Guestbook has been edited.',
	'msg_gbm_edited' => 'The Guestbook Entry has been edited.',
	'msg_gbm_mod_0' => 'The Guestbook Entry is now shown.',
	'msg_gbm_mod_1' => 'The Guestbook Entry is now in moderation queue.',
	'msg_gbm_pub_0' => 'The Guestbook Entry is now invisble to guests.',
	'msg_gbm_pub_1' => 'The Guestbook Entry is now visible to guests.',

	# Headers
	'th_gbm_username' => 'Your Nickname',
	'th_gbm_email' => 'Your EMail',
	'th_gbm_url' => 'Your Website',
	'th_gbm_message' => 'Your Message',
	'th_opt_public' => 'Is Message Public?',
	'th_opt_toggle' => 'Allow to toggle Public Flag?',
	'th_gb_title' => 'Title',
	'th_gb_locked' => 'Locked?',
	'th_gb_moderated' => 'Moderated?',
	'th_gb_guest_view' => 'Public View?',
	'th_gb_guest_sign' => 'Guest Signing?',
	'th_gb_bbcode' => 'Allow BBCode?',
	'th_gb_urls' => 'Allow User URL?',
	'th_gb_smiles' => 'Allow Smileys?',
	'th_gb_emails' => 'Allow User EMail?',
	'th_gb_descr' => 'Description',
	'th_gb_nesting' => 'Nesting Allowed?',

	# Tooltips
	'tt_gbm_email' => 'Your EMail is shown to everyone if you specify one!',
	'tt_gb_locked' => 'Checkmark to disable the guestbook temporarily.',

	# Titles
	'ft_sign' => 'Sign %1%',
	'ft_edit_gb' => 'Edit Your Guestbook',
	'ft_edit_entry' => 'Edit a Guestbook entry',

	# Buttons
	'btn_sign' => 'Sign %1%',
	'btn_edit_gb' => 'Edit Guestbook',
	'btn_edit_entry' => 'Edit Entry',
	'btn_public_hide' => 'Hide this entry from guests',
	'btn_public_show' => 'Show this entry to the public',
	'btn_moderate_no' => 'Approve this entry to be shown',
	'btn_moderate_yes' => 'Hide this post and put it into moderation queue',
	'btn_replyto' => 'Reply to %1%',

	# Admin Config
	'cfg_gb_allow_email' => 'Allow and Show EMails?',
	'cfg_gb_allow_url' => 'Allow and Show Websites?',
	'cfg_gb_allow_guest' => 'Allow Guest entries?',
	'cfg_gb_captcha' => 'Captcha for Guests?',
	'cfg_gb_ipp' => 'Entries Per Page',
	'cfg_gb_max_msglen' => 'Max. Message Length',
	'cfg_gb_max_ulen' => 'Max. Guest Name Length',
	'cfg_gb_max_titlelen' => 'Max. Guestbook Title Length',
	'cfg_gb_max_descrlen' => 'Max. Guestbook Description Length',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Min Level to create a guestbook',
	'mails_signed' => GWF_SITENAME.': Guestbook signed',
	'mailb_signed' => 
		'Dear %1%'.PHP_EOL.
		PHP_EOL.
		'The %2% guestbook got signed by %3% (%4%)'.PHP_EOL.
		'Message:'.PHP_EOL.
		'%5%'.PHP_EOL.
		PHP_EOL.
		'You can automagically show this entry by visiting:'.PHP_EOL.
		'%6%'.PHP_EOL,
		
	# v2.02 Mail on Sign
	'th_mailonsign' => 'EMail on new entry?',
	'mails2_signed' => GWF_SITENAME.': Guestbook signed',
	'mailb2_signed' => 
		'Dear %1%'.PHP_EOL.
		PHP_EOL.
		'The %2% guestbook got signed by %3% (%4%)'.PHP_EOL.
		'Message:'.PHP_EOL.
		'%5%'.PHP_EOL,
		
	# v2.03 (Delete entry)
	'btn_del_entry' => 'Delete entry',
	'msg_e_deleted' => 'The entry got deleted.',

	# v2.04 (finish)
	'cfg_gb_menu' => 'Show in menu?',
	'cfg_gb_nesting' => 'Allow nesting?',
	'cfg_gb_submenu' => 'Show in submenu?',
	'err_locked' => 'This guestbook is currently locked.',
	
	# v2.05 (showmail)
	'th_opt_showmail' => 'Show EMail to public?',
);

?>
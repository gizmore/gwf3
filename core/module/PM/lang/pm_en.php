<?php
$lang = array(
	'hello' => 'Hello %s',
	'sel_username' => 'Choose Username',
	'sel_folder' => 'Choose Folder',

	# Info
	'pt_guest' => GWF_SITENAME.' Guest PM',
	'pi_guest' => 'On '.GWF_SITENAME.' it is also possible to PM someone without being logged in, but it is not possible to contact you back. However, it can be used to report a bug quickly.',
	'pi_trashcan' => 'This is your Trashcan, you can not really delete messages, but you can restore them.',
	
	# Buttons
	'btn_ignore' => 'Put %s on your Ignore List',
	'btn_ignore2' => 'Ignore',
	'btn_save' => 'Save Options',
	'btn_create' => 'New PM',
	'btn_preview' => 'Preview',
	'btn_send' => 'Send PM',
	'btn_delete' => 'Delete',
	'btn_restore' => 'Restore',
	'btn_edit' => 'Edit',
	'btn_autofolder' => 'Put into Auto Folders',
	'btn_reply' => 'Reply',
	'btn_quote' => 'Quote',
	'btn_options' => 'PM Options',
	'btn_search' => 'Search',
	'btn_trashcan' => 'Your Trashcan',
	'btn_auto_folder' => 'Auto Fold PMs',

	# Errors
	'err_pm' => 'The PM does not exist.',
	'err_perm_read' => 'You are not allowed to read this pm.',
	'err_perm_write' => 'You are not allowed to edit this pm.',
	'err_no_title' => 'You forgot the PM title.',
	'err_title_len' => 'Your title is too long. Max %s chars are allowed.',
	'err_no_msg' => 'You forgot your message.',
	'err_sig_len' => 'Your signature is too long. Max %s chars are allowed.',
	'err_msg_len' => 'Your message is too long. Max %s chars are allowed.',
	'err_user_no_ppm' => 'This User does not want public PMs.',
	'err_no_mail' => 'You do not have an approved EMail associated with your account.',
	'err_pmoaf' => 'The value for auto-folders is not valid.',
	'err_limit' => 'You reached your PM limit for today. You can send max %s PMs within %s.',
	'err_ignored' => '%s has put you on his ignore list:<br/>%s',
	'err_delete' => 'An error occured while deleting your messages.',
	'err_folder_exists' => 'The Folder already exists.',
	'err_folder_len' => 'The FolderName`s length has to be 1 - %s chars.',
	'err_del_twice' => 'You already have deleted this PM.',
	'err_folder' => 'The Folder is unknown.',
	'err_pm_read' => 'Your PM has been read already, so you can not edit it anymore.',

	# Messages
	'msg_sent' => 'Your PM has been successfully sent. You can still edit it, until it has been read.',
	'msg_ignored' => 'You put %s on you ignore list.',
	'msg_unignored' => 'You removed %s from you ignore list.',
	'msg_changed' => 'Your options have been changed.',
	'msg_deleted' => 'Successfully deleted %s PMs.',
	'msg_moved' => 'Successfully moved %s PMs.',
	'msg_edited' => 'Your PM has been edited.',
	'msg_restored' => 'Successfully restored %s PMs.',
	'msg_auto_folder_off' => 'You do not have Auto-Folders enabled. The PM has been marked as read.',
	'msg_auto_folder_none' => 'There are only %s messages from/to this user. Nothing moved. The PM has been marked as read.',
	'msg_auto_folder_created' => 'Created the folder %s.',
	'msg_auto_folder_moved' => 'Moved %s message(s) to folder %s. The PM(s) have been marked as read.',
	'msg_auto_folder_done' => 'Auto-Folders done.',


	# Titles
	'ft_create' => 'Write %s a new PM',
	'ft_preview' => 'Preview',
	'ft_options' => 'Your PM Options',
	'ft_ignore' => 'Put Someone onto Your Ignore List',
	'ft_new_pm' => 'Write a new PM',
	'ft_reply' => 'Reply to %s',
	'ft_edit' => 'Edit your PM',
	'ft_quicksearch' => 'Quicksearch',
	'ft_advsearch' => 'Advanced Search',

	# Tooltips
	'tt_pmo_auto_folder' => 'If a single user sends you this amount of private messages, his messages get put into an own folder automatically.',
	
	# Table Headers
	'th_pmo_options&1' => 'EMail me on new PMs',
	'th_pmo_options&2' => 'Allow Guests to PM me',
	'th_pmo_auto_folder' => 'Create User Folders after n PMs',
	'th_pmo_signature' => 'Your PM Signature',

	'th_pm_options&1' => 'New',
	'th_actions' => ' ',
	'th_user_name' => 'Username',
	'th_pmf_name' => 'Folder',
	'th_pmf_count' => 'Count',
	'th_pm_id' => 'ID',
	'th_pm_to' => 'To',
	'th_pm_from' => 'From',
//	'th_pm_to_folder' => 'To Folder',
//	'th_pm_from_folder' => 'From Folder',
	'th_pm_date' => 'Date',
	'th_pm_title' => 'Title',
	'th_pm_message' => 'Message',
//	'th_pm_options' => 'Options',

	# Welcome PM
	'wpm_title' => 'Welcome to '.GWF_SITENAME,
	'wpm_message' => 
		'Dear %s'.PHP_EOL.
		PHP_EOL.
		'Welcome to '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'We hope you like our site and have fun with it.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': New PM from %s',
	'mail_body' =>
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'There is a new PM for you on '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'From: %s'.PHP_EOL.
		'Title: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'You can quickly:'.PHP_EOL.
		'Auto-Folder The Message:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Delete the message:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' Robot'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Use Captcha for Guests?',
	'cfg_pm_causes_mail' => 'Allow EMail on PM?',
	'cfg_pm_for_guests' => 'Allow Guest PM?',
	'cfg_pm_welcome' => 'Send a welcome PM?',
	'cfg_pm_limit' => 'Maximum PM within the Timeout Limit',
	'cfg_pm_maxfolders' => 'Maximum Folders Per User',
	'cfg_pm_msg_len' => 'Maximum Message Length',
	'cfg_pm_per_page' => 'PMs Per Page',
	'cfg_pm_sig_len' => 'Maximum Signature Length',
	'cfg_pm_title_len' => 'Maximum Title Length',
	'cfg_pm_bot_uid' => 'Welcome PM Sender ID',
	'cfg_pm_sent' => 'PM Send Counter',
	'cfg_pm_mail_sender' => 'EMail on PM Sender',
	'cfg_pm_re' => 'Prepend Title',
	'cfg_pm_limit_timeout' => 'PM limit timeout',
	'cfg_pm_fname_len' => 'Maximum Foldername Length',
	
	# v2.01
	'err_ignore_admin' => 'You can not put an Admin on your ignore list.',
	'btn_new_folder' => 'New Folder',
		
	# v2.02
	'msg_mail_sent' => 'An email has been sent to %s containing your original message.',
		
	# v2.03 SEO
	'pt_pm' => 'PM',
		
	# v2.04 fixes
	'ft_new_folder' => 'Create a new folder',

	# v2.05 (prev+next)
	'btn_prev' => 'Previous message',
	'btn_next' => 'Next message',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'The other user deleted this pm.',
	'gwf_pm_read' => 'The other user has read your pm.',
	'gwf_pm_unread' => 'The other user has not read your pm yet.',
	'gwf_pm_old' => 'This pm is old for you.',
	'gwf_pm_new' => 'New pm for you.',
	'err_bot' => 'Bots are not allowed to send messages.',

	# v2.07 (fixes)
	'err_ignore_self' => 'You can not ignore yourself.',
	'err_folder_perm' => 'This folder is not yours.',
	'msg_folder_deleted' => 'The Folder %s and %s message(s) got moved into the trashcan.',
	'cfg_pm_delete' => 'Allow to delete PM?',
	'ft_empty' => 'Empty your Trashcan',
	'msg_empty' => 'Your trashcan (%s messages) has been cleaned up.<br/>%s messages has/have been deleted from the database.<br/>%s messages are still in use by the other user and have not been deleted.',
		
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
		
	# monnino fixes
	'cfg_pm_limit_per_level' => 'PM limit per level',
	'cfg_pm_own_bot' => 'PM own bot',
	'th_reason' => 'Reason',
		
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);

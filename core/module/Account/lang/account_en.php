<?php

$lang = array(

	# Titles
	'form_title' => 'Account settings',
	'chmail_title' => 'Enter your new email',

	# Headers
	'th_username' => 'Your Username',
	'th_email' => 'Contact Email',
	'th_demo' => 'Demographic Options - You can change these only once within %s.',
	'th_countryid' => 'Country',	
	'th_langid' => 'Primary Language',	
	'th_langid2' => 'Secondary Language',
	'th_birthdate' => 'Your Birthdate',
	'th_gender' => 'Your Gender',
	'th_flags' => 'Options - You can toggle these on the fly',
	'th_adult' => 'Do you want to see adult content?',
	'th_online' => 'Hide your online status?',
	'th_show_email' => 'Show your EMail to the public?',
	'th_avatar' => 'Your Avatar',
	'th_approvemail' => '<b>Your EMail is<br/>not Approved</b>',
	'th_email_new' => 'Your new Email',
	'th_email_re' => 'Re-Type Email',

	# Buttons
	'btn_submit' => 'Save Changes',
	'btn_approvemail' => 'Approve EMail',
	'btn_changemail' => 'Set New Email',
	'btn_drop_avatar' => 'Delete Avatar',

	# Errors
	'err_token' => 'Invalid token.',
	'err_email_retype' => 'You have to re-type your email correctly.',
	'err_delete_avatar' => 'An error occured while deleting your Avatar.',
	'err_no_mail_to_approve' => 'You don`t have an email set to approve.',
	'err_already_approved' => 'Your email is already approved.',
	'err_no_image' => 'Your uploaded file is not an image, or too small.',
	'err_demo_wait' => 'You changed your demographic options recently. Please wait %s.',
	'err_birthdate' => 'Your birthdate seems invalid.',

	# Messages
	'msg_mail_changed' => 'Your contact email has been changed to <b>%s</b>.',
	'msg_deleted_avatar' => 'Your avatar image has been deleted.',
	'msg_avatar_saved' => 'Your new Avatar image has been saved.',
	'msg_demo_changed' => 'Your demographic options have been changed.',
	'msg_mail_sent' => 'We have sent you an email to perform the changes. Please follow the instructions in it.',
	'msg_show_email_on' => 'Your EMail is now shown to the public.',
	'msg_show_email_off' => 'Your EMail is now hidden from the public.',
	'msg_adult_on' => 'Your account can now see adult content.',
	'msg_adult_off' => 'Adult content is now hidden for you.',
	'msg_online_on' => 'Your online status is now hidden.',
	'msg_online_off' => 'Your online status is now visible.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatar Maximum Width',
	'cfg_avatar_max_y' => 'Avatar Maximum Height',
	'cfg_avatar_min_x' => 'Avatar Minimum Width',
	'cfg_avatar_min_y' => 'Avatar Minimum Height',
	'cfg_adult_age' => 'Minimum Age for Adult Content',
	'cfg_demo_changetime' => 'Demographic Change Timeout',
	'cfg_mail_sender' => 'Account Change EMail Sender',
	'cfg_show_adult' => 'Site has adult content?',
	'cfg_show_gender' => 'Show Gender Select?',
	'cfg_use_email' => 'Require EMail to do Account changes?',
	'cfg_show_avatar' => 'Show Avatar Upload?',
	'cfg_show_checkboxes' =>'Show checkboxes',
############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Change your EMail',
	'chmaila_body' => 
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'You requested to change your email on '.GWF_SITENAME.'.'.PHP_EOL.
		'To do so, you have to visit the URL below.'.PHP_EOL.
		'In case you did not request to change your email, you can ignore this mail or alert us about it.'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Confirm your EMail',
	'chmailb_body' => 
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'To use this email address as your main contact address you have to confirm it by visiting the URL below:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Change Demographic Settings',
	'chdemo_body' =>
		'Dear %s'.PHP_EOL.
		PHP_EOL.
		'You have requested to setup or change your demographic settings.'.PHP_EOL.
		'You can do this only once within %s, so please make sure the information is correct before you continue.'.PHP_EOL.
		PHP_EOL.
		'Gender: %s'.PHP_EOL.
		'Country: %s'.PHP_EOL.
		'Primary Language: %s'.PHP_EOL.
		'Secondary Language: %s'.PHP_EOL.
		'Day of Birth: %s'.PHP_EOL.
		PHP_EOL.
		'If you want to keep these settings, please use the link below:'.PHP_EOL.
		'%s'.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',

	# New Flags 
	'th_allow_email' => 'Allow people to EMail you',
	'msg_allow_email_on' => 'People can now send you email without spoiling your email address.',
	'msg_allow_email_off' => 'EMail contact turned off.',
		
	'th_show_bday' => 'Show your birthday',
	'msg_show_bday_on' => 'Your birthday is now announced to members who like that feature.',
	'msg_show_bday_off' => 'Your birthday is not announced anymore.',
		
	'th_show_obday' => 'Show other birthdays',
	'msg_show_obday_on' => 'You will now see other peoples birthdays.',
	'msg_show_obday_off' => 'You ignore birthday announces now.',
		
	# v2.02 Account Deletion
	'pt_accrm' => 'Delete your Account',
	'mt_accrm' => 'Delete your account on '.GWF_SITENAME,
	'pi_accrm' =>
		'It seems like you want to delete your account on '.GWF_SITENAME.'.<br/>'.
		'We are sad to hear that, also your account will not be deleted, just disabled.<br/>'.
		'All links to this username, profiles, etc, will become unusable or renamed to guest. This is irreversible.<br/>'.
		'Before you continue to disable your account, you may leave us a note with the reason(s) for your deletion.<br/>',
	'th_accrm_note' => 'Note',
	'btn_accrm' => 'Delete Account',
	'msg_accrm' => 'Your account got marked as deleted and all references should have been deleted.<br/>You got logged out.',
	'ms_accrm' => GWF_SITENAME.': %s account deletion',
	'mb_accrm' =>
		'Dear Staff'.PHP_EOL.
		''.PHP_EOL.
		'The user %s has just deleted his account and left this note (may_be_empty):'.PHP_EOL.PHP_EOL.
		'%s',
		
	# v2.03 Email Options
	'th_email_fmt' => 'Preferred EMail Format',
	'email_fmt_text' => 'Plain Text',
	'email_fmt_html' => 'Simple HTML',
	'err_email_fmt' => 'Please select a valid EMail Format.',
	'msg_email_fmt_0' => 'You will now receive emails in simple html format.',
	'msg_email_fmt_4096' => 'You will now receive emails in plain text format.',
	'ft_gpg' => 'Setup PGP/GPG Encryption',
	'th_gpg_key' => 'Upload your public key',
	'th_gpg_key2' => 'Or paste it here',
	'tt_gpg_key' => 'When you have set a pgp key all the emails sent to you by the scripts are encrypted with your public key',
	'tt_gpg_key2' => 'Either paste your public key here, or upload your public key file.',
	'btn_setup_gpg' => 'Upload Key',
	'btn_remove_gpg' => 'Remove Key',
	'err_gpg_setup' => 'Either upload a file which contains your public key or paste your public key in the text area.',
	'err_gpg_key' => 'Your public key seems invalid.',
	'err_gpg_token' => 'Your gpg fingerprint token does not match our records.',
	'err_no_gpg_key' => 'The user %s did not submit a public key yet.',
	'err_no_mail' => 'You don`t have an approved main contact email address.',
	'err_gpg_del' => 'You don`t have a validated GPG key to delete.',
	'err_gpg_fine' => 'You already have a GPG key. Please delete it first.',
	'msg_gpg_del' => 'Your GPG key has been deleted successfully.',
	'msg_setup_gpg' => 'Your GPG has been stored and is in use now.',
	'mails_gpg' => GWF_SITENAME.': Setup GPG Encryption',
	'mailb_gpg' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'You have decided to turn on gpg encryption for emails sent by this robot.'.PHP_EOL.
		'To do so, follow the link below:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',
		
	# v2.04 Change Password
	'th_change_pw' => '<a href="%s">Change your password</a>',
	'err_gpg_raw' => GWF_SITENAME.' does only support ascii armor format for your public GPG key.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',
	# v3.00 (fixes3)
	'err_email_taken' => 'This email address is already in use.',
		
	# v3.01 (record IPs)
	'btn_record_enable' => 'IP Recording',
	'mail_signature' => GWF_SITENAME.' Security Robot',
	'mails_record_disabled' => GWF_SITENAME.': IP Recording',
	'mailv_record_disabled' => 'IP recording has been disabled for your account.',
	'mails_record_alert' => GWF_SITENAME.': Security Alert',
	'mailv_record_alert' => 'There has been access to your account via an unknown UserAgent or an unknown/suspicious IP.',
	'mailb_record_alert' =>
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'UserAgent: %s'.PHP_EOL.
		'IP address: %s'.PHP_EOL.
		'Hostname: %s'.PHP_EOL.
		PHP_EOL.
		'You can ignore this Email safely or maybe you like to review all IPs:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The %s'.PHP_EOL,
	# 4 Checkboxes
	'th_record_ips' => 'Monitor <a href="%s">IP access</a>',
	'tt_record_ips' => 'Record access to your account by IP so you can review it. Entries cannot be deleted!',
	'msg_record_ips_on' => 'All unique IP Addresses using your account are now lieftime recorded. This is your last change to quit. You can of course pause recording anytime.',
	'msg_record_ips_off' => 'You have disabled IP recording for your account.',
	#
	'th_alert_uas' => 'Alert on UA change',
	'tt_alert_uas' => 'Sends you an email when your UserAgent changes. (recommended)',
	'msg_alert_uas_on' => 'Security Alert Email will be sent when your User Agent changes. Recording needs to be enabled.',
	'msg_alert_uas_off' => 'User Agent changes are now ignored.',
	#
	'th_alert_ips' => 'Alert on IP change',
	'tt_alert_ips' => 'Sends you an email when ´your´ IP changes. (recommended)',
	'msg_alert_ips_on' => 'Security Alert Email will be sent when your IP changes. Recording needs to be enabled.',
	'msg_alert_ips_off' => 'IP changes are now ignored.',
	#	
	'th_alert_isps' => 'Alert on ISP change',
	'tt_alert_isps' => 'Sends you an email when your ISP / hostname changes. (not recommended)',
	'msg_alert_isps_on' => 'Security Alert Email will be sent when your hostname changes significantly. Recording needs to be enabled.',
	'msg_alert_isps_off' => 'ISP/hostname changes are now ignored.',
		
	'th_date' => 'Date',
	'th_ua' => 'UserAgent',
	'th_ip' => 'IP Address',
	'th_ips' => 'Hostname',
);

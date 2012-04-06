<?php
$lang = array(
	# Page Titles
	'pt_list' => 'Download Section',
	'mt_list' => 'Download Section, Downloads, Exclusive downloads, '.GWF_SITENAME,
	'md_list' => 'Exclusive downloads on '.GWF_SITENAME.'.',

	# Page Info
	'pi_add' => 'For best user experience upload your file first, it will get stored into your session. Afterwards alter the options.<br/>The maximum upload size is set to %s.',

	# Form Titles
	'ft_add' => 'Upload a file',
	'ft_edit' => 'Edit Download',
	'ft_token' => 'Enter your download token',

	# Errors
	'err_file' => 'You have to upload a file.',
	'err_filename' => 'Your specified filename is invalid. Max length is %s. Try to use basic ascii chars.',
	'err_level' => 'The user level has to be >= 0.',
	'err_descr' => 'The description has to be 0-%s chars long.',
	'err_price' => 'The price has to be between %s and %s.',
	'err_dlid' => 'The download could not be found.',
	'err_token' => 'Your download token is invalid.',

	# Messages
	'prompt_download' => 'Press OK to download the file',
	'msg_uploaded' => 'Your file got uploaded successfully.',
	'msg_edited' => 'The download has been edited successfully.',
	'msg_deleted' => 'The download has been deleted successfully.',

	# Table Headers
	'th_dl_filename' => 'Filename',
	'th_file' => 'File',
	'th_dl_id' => 'ID',
	'th_dl_gid' => 'Needed Group',
	'th_dl_level' => 'Needed Level',
	'th_dl_descr' => 'Description',
	'th_dl_price' => 'Price',
	'th_dl_count' => 'Downloads',
	'th_dl_size' => 'Filesize',
	'th_user_name' => 'Uploader',
	'th_adult' => 'Adult content?',
	'th_huname' => 'Hide Username?',
	'th_vs_avg' => 'Vote',
	'th_dl_expires' => 'Expires',
	'th_dl_expiretime' => 'Download valid for',
	'th_paid_download' => 'A payment is needed to download this file',
	'th_token' => 'Download Token',

	# Buttons
	'btn_add' => 'Add',
	'btn_edit' => 'Edit',
	'btn_delete' => 'Delete',
	'btn_upload' => 'Upload',
	'btn_download' => 'Download',
	'btn_remove' => 'Remove',

	# Admin config
	'cfg_anon_downld' => 'Allow guest downloads',
	'cfg_anon_upload' => 'Allow guest uploads',
	'cfg_user_upload' => 'Allow user uploads',
	'cfg_dl_gvotes' => 'Allow guest votes',	
	'cfg_dl_gcaptcha' => 'Guest Upload Captcha',	
	'cfg_dl_descr_max' => 'Max. description length',
	'cfg_dl_descr_min' => 'Min. description length',
	'cfg_dl_ipp' => 'Items per page',
	'cfg_dl_maxvote' => 'Max. votescore',
	'cfg_dl_minvote' => 'Min. votescore',

	# Order
	'order_title' => 'Download token for %s (Token: %s)',
	'order_descr' => 'Purchased download token for %s. Valid for %s. Token: %s',
	'msg_purchased' => 'Your payment has been received and a download token has been inserted.<br/>Your token is \'%s\' and it is valid for %s.<br/><b>Write the token down if you have no account at '.GWF_SITENAME.'!</b><br/>Else simply <a href="%s">follow this link</a>.',

	# v2.01 (+col)
	'th_purchases' => 'Purchases',

	# v2.02 Expire + finsih
	'err_dl_expire' => 'The expire time has to be between 0 seconds and 5 years.',
	'th_dl_expire' => 'Download expires after',
	'tt_dl_expire' => 'Duration expression like 5 seconds or 1 month 3 days.',
	'th_dl_guest_view' => 'Guest Visible?',
	'tt_dl_guest_view' => 'May guests see this download?',
	'th_dl_guest_down' => 'Guest Downloadable?',
	'tt_dl_guest_down' => 'May guests download this file?',
	'ft_reup' => 'Re-Upload File',
	'order_descr2' => 'Purchased download token for %s. Token: %s.',
	'msg_purchased2' => 'Your payment has been received and a download token has been inserted.<br/>Your token is \'%s\'.<br/><b>Write the token down if you have no account at '.GWF_SITENAME.'!</b><br/>Else simply <a href="%s">follow this link</a>.',
	'err_group' => 'You need to be in the %s usergroup to download this file.',
	'err_level' => 'You need a userlevel of %s to download this file.',
	'err_guest' => 'Guests are not allowed to download this file.',
	'err_adult' => 'This is adult content.',

	'th_dl_date' => 'Date',

	# GWF3v1.1
	'cfg_dl_min_level' => 'Minimum userlevel for an upload',
	'cfg_dl_moderated' => 'Require moderators to unlock uploads?',
	'cfg_dl_moderators' => 'Usergroup for upload moderators.',
	'th_enabled' => 'Enabled?',
	'err_disabled' => 'This download isn\'t enabled yet.',
	'msg_enabled' => 'The download has been enabled.',
	'msg_uploaded_mod' => 'Your file has been uploaded successfully, but has to be reviewed before it is released.',

	'mod_mail_subj' => GWF_SITENAME.': Upload Moderation',
	'mod_mail_body' =>
		'Dear %s'.PHP_EOL.
		PHP_EOL.
		'There has been a new file uploaded to '.GWF_SITENAME.' which requires moderation.'.PHP_EOL.
		PHP_EOL.
		'From: %s'.PHP_EOL.
		'File: %s (%s)'.PHP_EOL.
		'Mime: %s'.PHP_EOL.
		'Size: %s'.PHP_EOL.
		'Desc: %s'.PHP_EOL.
		PHP_EOL.
		'You can download the file here:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'You can allow the download here:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'You can delete the download here:'.PHP_EOL.
		'%10$s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' script!',
);
?>

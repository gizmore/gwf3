<?php

$lang = array(
	# Page Titles
	'pt_profile' => '%s`s Profile',
	'pt_settings' => 'Profile settings',

	# Meta Tags
	'mt_profile' => '%s`s profile, '.GWF_SITENAME.', %s, Profile',
	'mt_settings' => GWF_SITENAME.', Profile, Settings, Edit, Contact, Data',

	# Meta Description
	'md_profile' => '%s`s profile on '.GWF_SITENAME.'.',
	'md_settings' => 'Your profile settings on '.GWF_SITENAME.'.',

	# Info
	'pi_help' =>
		'To upload an avatar, use the main account settings.<br/>'.
		'To add a Signature to Forum Posts, use the forum settings.<br/>'.
		'Also PM and other modules have their own, separate setting pages.<br/>'.
		'<b>All profile settings here are publicy visible, so do not give too much away of yourself</b>.<br/>'.
		'If you hide your email, double check your account settings, as there is a global EMail flag too.<br/>'.
		'It is possible to hide your profile from guests or search engines.',

	# Errors
	'err_hidden' => 'The User`s Profile is hidden.',
	'err_firstname' => 'Your First-Name is invalid. Maximum length: %s chars.',
	'err_lastname' => 'Your Last-Name is invalid. Maximum length: %s chars.',
	'err_street' => 'Your Street is invalid. Maximum length: %s chars.',
	'err_zip' => 'Your ZIP-Code is invalid. Maximum length: %s chars.',
	'err_city' => 'Your City is invalid. Maximum length: %s chars.',
	'err_tel' => 'Your Telephone Number is invalid. Maximum length: 24 digits or spaces.',
	'err_mobile' => 'Your Mobile Phone Number is invalid.',
	'err_icq' => 'Your ICQ-UIN is invalid. Maximum length: 16 digits.',
	'err_msn' => 'Your MSN is invalid.',
	'err_jabber' => 'Your Jabber is invalid.',
	'err_skype' => 'Your Skype Name is invalid. Maximum length: %s chars.',
	'err_yahoo' => 'Your Yahoo! is invalid. Maximum length: %s chars.',
	'err_aim' => 'Your AIM is invalid. Maximum length: %s chars.',
	'err_about_me' => 'Your &quot;About Me&quot; is invalid. Maximum length: %s chars.',
	'err_website' => 'Your website is unreachable or does not exist.',

	# Messages
	'msg_edited' => 'Your Profile has been edited.',

	# Headers
	'th_user_name' => 'Username',
	'th_user_level' => 'Level',
	'th_user_avatar' => 'Avatar',
	'th_gender' => 'Gender',
	'th_firstname' => 'Firstname',
	'th_lastname' => 'Lastname',
	'th_street' => 'Street',
	'th_zip' => 'ZIP',
	'th_city' => 'City',
	'th_website' => 'Website',
	'th_tel' => 'Telephone',
	'th_mobile' => 'Mobile',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo!',
	'th_aim' => 'AIM',
	'th_about_me' => 'About yourself',
	'th_hidemail' => 'Hide EMail in Profile?',
	'th_hidden' => 'Hide Profile from Guests?',
	'th_level_all' => 'Min Level All',
	'th_level_contact' => 'Min Level Contact',
	'th_hidecountry' => 'Hide your country?',
	'th_registered' => 'Register Date',
	'th_last_active' => 'Last Activity',
	'th_views' => 'Profile Views',

	# Form Titles
	'ft_settings' => 'Edit your Profile',

	# Tooltips
	'tt_level_all' => 'Minimum User Level to see your profile',
	'tt_level_contact' => 'Minimum User Level to see your contact data',

	# Buttons
	'btn_edit' => 'Save Profile',

	# Admin Config
	'cfg_prof_hide' => 'Allow Hiding Profiles?',
	'cfg_prof_max_about' => 'Max Length for &quot;About Me&quot;',

	# V2.01 (Hide Guests)
	'th_hideguest' => 'Hide from guests?',

	# v2.02 (fixes)
	'err_level_all' => 'Your minimum user level to see your profile is invalid.',
	'err_level_contact' => 'Your minimum user level to see your contact data is invalid.',

	# v2.03 (fixes2)
	'title_about_me' => 'About %s',

	# v2.04 (ext. profile)
	'th_user_country' => 'Country',
	'btn_pm' => 'PM',

	# v2.05 (more fixes)
	'at_mailto' => 'Send a mail to %s',
	'th_email' => 'EMail',

	# v2.06 (birthday)
	'th_age' => 'Age',
	'th_birthdate' => 'Birthdate',

	# v2.07 (IRC+Robots)
	'th_irc' => 'IRC',
	'th_hiderobot' => 'Hide from web crawlers?',
	'tt_hiderobot' => 'Checkmark this if you don\'t want your profile get indexed by search engines.',
	'err_no_spiders' => 'This profile can not be watched by web crawlers.',
	
	# monnino fixes
	'cfg_prof_level_gb' => 'Minimum level to create a guestbook in the profile',

	# v2.08 (POI)
	'ph_places' => 'Points of Interest',
	'msg_white_added' => 'Successfully added %s to your POI whitelist.',
	'msg_white_removed' => 'Successfully removed %s user(s) from your POI whitelist.',
	'msg_pois_cleared' => 'All your Point of Interest data has been cleared.',
	'msg_white_cleared' => 'Your whitelist has been wiped.',
	'err_poi_read_perm' => 'You are not allowed to see POI.',
	'err_poi_exceed' => 'You cannot add more POI yet.',
	'err_self_whitelist' => 'You cannot whitelist yourself.',
	'prompt_rename' => 'Please enter a description.',
	'prompt_delete' => 'Do you want to remove this Point of Interest?',
	'th_poi_score' => 'Minimum user level to see your POI',
	'tt_poi_score' => 'You can hide your Points of Interest from users whose user level is too low.',
	'th_poi_white' => 'Use <a href="%s">whitelist</a> for POI',
	'tt_poi_white' => 'Instead of level based restrictions use your own POI whitelist.',
	'ft_add_whitelist' => 'Add a user to your whitelist',
	'ft_clear_pois' => 'Remove all POI you have created or clear the whitelist.',
	'th_date_added' => 'added on',
	'btn_clear_pois' => 'Clear POI data',
	'btn_clear_white' => 'Clear whitelist',
	'btn_add_whitelist' => 'Add user',
	'btn_rem_whitelist' => 'Remove user',
	'poi_info' => 'This page shows POI submitted by users.<br/>You are allowed to add %s/%s Points Of Interest.<br/>You can protect your POI by either <a href="%s">requirering a minimum userlevel</a>, or by using a <a href="%s">personal whitelist</a>.<br/>By default your POI are public.',
	'poi_usage' => 'Usage',
	'poi_usage_data' => array(
		'Click on an umarked location to add a new POI.',
		'A double click on your own POI deletes them.',
		'A click on your own POI allows to rename it.',
		'Adding sensitive information about others is not acceptable.',
	),
	'poi_helper' => 'Places Application',
	'btn_poi_init' => 'Start Places',
	'btn_poi_init_sensor' => 'Start Places with my current location',
	'ph_poi_jump' => 'Jump to an address',
	'err_poi_jump' => 'The address could not been found.',
	'poi_privacy_t' => 'Privacy gotchas',
	'poi_privacy' => 'I bet some are worried about privacy and refuse to use this page.<br/>Your requested map sections currently occur in Apache and GWF log files.<br/>Google probably records your requests as well.<br/>This server does not intentionally store any information on your personal location.<br/>GWF log files are removed from the server regularly and the Apache logs could connect IPs with your requests.<br/>The POI database only stores the POI submitted by users.',
	'poi_stats_t' => 'POI Statistics',
	'poi_stats' => 'There are a total of %s POI in the database of which %s are visible to you.',
);

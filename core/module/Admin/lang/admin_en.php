<?php
$lang = array(
	# Admin Config
	'cfg_users_per_page' => 'Users Per Page',	
	'cfg_super_hash' => 'Extra Password for Admin Module',
	'cfg_super_time' => 'Time an Extra Password stays valid',

	# Info
	'install_info' => 'Some modules need update, you can <a href="%s">Update and Install all Modules</a> too.',
	'info_methods' => 'Checking %s Methods in the Module...',
	
	# Select
	'sel_group' => 'Select Usergroup',
	
	# Titles
	'form_title' => 'Configure %s',
	'ft_setup' => 'Set an additional Superuser Password',
	'ft_prompt' => 'Please enter the Superuser Password',
	'ft_login_as' => 'Login as another User',
	'ft_useredit' => 'Edit the User %s',
	'ft_search' => 'Search in the user table.',
	'ft_edit_group' => 'Edit Group %s',
	'ft_add_to_group' => 'Add a user to this group',
	'ft_add_group' => 'Create a new group',

	# Errors
	'err_mod_not_installed' => 'This Module is not installed.',
	'err_not_installed' => 'Module %s is not installed yet.',
	'err_arg_script' => 'You can not change the value for &quot;%s&quot; by hand.',
	'err_arg_type' => 'Wrong arguments for &quot;%s&quot;.',
	'err_arg_range' => 'The value for &quot;%s&quot; has to be between %s and %s.',
	'err_arg_key' => 'Unknown variable &quot;%s&quot;.',
	'err_update' => 'Error on Update',
	'err_install' => 'Errors occurred during the install.',
	'err_check_pass' => 'The superuser password is wrong.',
	'err_username_taken' => 'The Username is already taken.',
	'err_username' => 'The Username is invalid.',
	'err_email' => 'The EMail is invalid.',
	'err_gender' => 'The Gender is invalid.',
	'err_group' => 'Unknown Group ID.',
	'err_group_view' => 'The Group Visibility is invalid.',
	'err_group_join' => 'The Group Invitation is invalid.',
	'err_in_group' => 'The User is already in that group.',
	'err_disable_core_module' => 'You cannot disable this module, because it is part of the core.',

	# Messages
	'msg_update_var' => 'The value for &quot;%s&quot; has been set to %s.',
	'msg_update' => 'Module Configured',
	'msg_install' => 'The %s module has been re-installed. Triggering Database Updates..',
	'msg_wipe_confirm' => 'Do you really want to erase all databases used by the %s Module?',
	'msg_wipe' => 'The %s module has been wiped from disk. All data is lost and the DB is fresh.',
	'msg_installed' => 'You can now continue with the <a href="%s">%s Configuration</a>.',
	'msg_install_all' => 'All modules have been triggered with install / update request.<br/><a href="%s">Click here to return to the module overview</a>.',
	'msg_enabled' => 'The module has been enabled.',
	'msg_disabled' => 'The module has been disabled.',
	'msg_pass_cleared' => 'The superuser password is now empty.',
	'msg_pass_set' => 'The superuser password is now &quot;%s&quot; Do not forget it, since it can not get recovered or changed easily.',
	'msg_login_as' => 'You are now logged in as %s.',
	'msg_userpass_changed' => 'The Password for %s is now &quot;%s&quot;.',
	'msg_username_changed' => 'The User %s is now known as %s.',
	'msg_user_edited' => 'The User has been edited successfully.',
	'msg_deleted' => 'The User has been marked as deleted.',
	'msg_undeleted' => 'The User has been marked as activated.',
	'msg_bot_0' => 'The User is no longer marked as Bot.',
	'msg_bot_1' => 'The User has been marked as Bot.',
	'msg_showemail_0' => 'The User`s email is not shown anymore.',
	'msg_showemail_1' => 'The User`s email is now shown to the public.',
	'msg_adult_0' => 'The User can not see adult content anymore.',
	'msg_adult_1' => 'The User can now see adult content.',
	'msg_online_0' => 'The User`s online status is now visible.',
	'msg_online_1' => 'The User`s online status is now hidden.',
	'msg_approved_0' => 'The User`s email became disapproved.',
	'msg_approved_1' => 'The User`s email is now approved.',
	'msg_module_enabled' => 'The %s Module has been enabled.',
	'msg_module_disabled' => 'The %s Module has been disabled.',
	'msg_new_path' => 'The Module-Path has been successfully changed.',
	'msg_new_name' => 'The Module has been renamed to %s. <b>Warning</b>: This will surely break all URLs!',
	'msg_defaults' => 'The ModuleVars have been reset to the default values.',
	'msg_removed_from_grp' => 'Removed User %s from Group %s.',
	'msg_added_to_grp' => 'Added User %s to Group %s.',

	# Table Headers
	'th_modulename' => 'Module',
	'th_path' => 'Path',
	'th_version_db' => 'Version',
	'th_version_hd' => 'Available',
	'th_priority' => 'Priority',
	'th_move' => 'Move',
	'th_name' => 'Module Name',
	'th_install' => 'Install',
	'th_basic' => 'Configure',
	'th_adv' => 'Admin Section',
	'th_enabled' => 'The Module is enabled',
	'th_disabled' => 'The Module is disabled',
	'th_new_pass' => 'New Password',
	'th_check_pass' => 'Password',
	'th_userid' => 'ID',
	'th_user_name' => 'Username',
	'th_email' => 'Email',
	'th_lastactivity' => 'Last Activity',
	'th_regip' => 'Register IP',
	'th_regdate' => 'Register Date',
	'th_gender' => 'Gender',
	'th_country' => 'Country',
	'th_lang_1' => 'Primary Language',
	'th_lang_2' => 'Secondary Language',
	'th_is_approved' => 'Has Approved EMail?',
	'th_is_bot' => 'Is a robot?',
	'th_hide_online' => 'Hide Online Status?',
	'th_show_email' => 'Show EMail to Public?',
	'th_want_adult' => 'Want Adult Content?',
	'th_deleted' => 'Is marked as Deleted?',
	'th_birthdate' => 'Birthdate',
	'th_cfg_div' => '%s Config Vars',
	'th_group_name' => 'GroupName',
	'th_group_sel_view' => 'Visibility',
	'th_group_sel_join' => 'Invitation',
	'th_group_lang' => 'Language',
	'th_group_country' => 'Country',
	'th_group_founder' => 'Founder',
	'th_group_options&1' => 'Full',
	'th_group_options&2' => 'By Invitation',
	'th_group_options&4' => 'Moderated List',
	'th_group_options&8' => 'Click&Join',
	'th_group_options&16' => '[script] Full',
	'th_group_options&'.(0x100) => 'Public Visible',
	'th_group_options&'.(0x200) => 'Member Visible',
	'th_group_options&'.(0x400) => 'Group Member Only',
	'th_group_options&'.(0x800) => '[script] Group only',
	'th_group_id' => 'ID',
	'th_group_memberc' => '#',
	'th_group_join' => 'Join Option',
	'th_group_view' => 'View Option',
	
	# Buttons
	'btn_install' => 'Install',
	'btn_reinstall' => 'Wipe DB',
	'btn_update' => 'Update',
	'btn_edit' => 'Edit',
	'btn_config' => 'Configure',
	'btn_admin_section' => 'Admin Section',
	'btn_enable' => 'Enable Module',
	'btn_disable' => 'Disable Module',
	'btn_modules' => 'Modules',
	'btn_superuser' => 'Superuser',
	'btn_users' => 'Users',
	'btn_groups' => 'Groups',
	'btn_login_as' => 'Login As',
	'btn_login_as2' => 'Login As %s',
	'btn_setup' => 'Set New Password',
	'btn_login' => 'Enter',
	'btn_edit_user' => 'Edit User',
	'btn_cronjob' => 'Cronjob',
	'btn_defaults' => 'Reset',
	'btn_add_to_group' => 'Add To Group',
	'btn_rem_from_group' => 'Remove From Group',
	'btn_user_groups' => 'Edit %s`s groups',
	'btn_add_to_grp' => 'Add to group',
	'btn_add_group' => 'Add group',

	# Tooltips
	'tt_int' => 'Integer value between %s and %s.',
	'tt_text' => 'Text String with length %s to %s.',
	'tt_bool' => 'Boolean value.',
	'tt_script' => 'Script Value which is controlled by the Module itself.',
	'tt_time' => 'Duration between %s and %s.',
	'tt_float' => 'Floating Point Number between %s and %s.',

	#v2.01 (Add Group)
	'ft_add_group' => 'Add a group',
	'btn_add_group' => 'Add Group',
	'msg_group_added' => 'Group has been added.',
	'err_groupname' => 'The groupname is invalid. It has to be %s to %s characters long.',

	#v2.02 (refinish)
	'ft_install' => 'Install the %s module',
	'th_reinstall' => 'Drop Tables & ReInstall',
	'err_no_admin_sect' => 'This module has no admin section.',
	'err_module' => 'The module %s is unknown.',
	'pi_install' => 'The module %s has %s database tables:<br/>%s',
	
	#v2.03 (creds+level)
	'th_user_credits' => '$',
	'th_user_level' => 'Level',

	#v2.04 (drop wrapper)
	'ft_reinstall' => 'Reinstall module %s',
	'th_reset' => 'Reset module vars',

	#v2.05 (finish2)
	'btn_install_all' => 'Install all modules',

	#v2.06 (GPG)
	'err_gpg_key' => 'Your GPG Signature looks invalid.',
	'msg_gpg_key' => 'Please use this as your fingerprint in config.php: %s',

	#v2.07 (fix)
	'msg_edit_group' => 'The group has been edited.',
	'msg_mod_del' => 'The module has been deleted from the database.',
	'btn_delete' => 'Delete',
		
	#monnino fixes
	'cfg_hide_web_spiders' => 'Hide Webspider',
	'cfg_install_webspiders' => 'Install Webspider',
	'btn_add' => 'Add group',
	
	#v2.09 (impersonation_alert)
	'mailt_impersonation' => GWF_SITENAME.': %s logged in as %s',
	'mailb_impersonation' =>
		"Dear %s,\n".
		"\n".
		"The admin user %s just used ´LoginAs´ to authenticate as %s.\n".
		"\n".
		"If you are this user you probably do not have to worry,\n".
		"especially if you recently reported a problem within ".GWF_SITENAME."\n".
		"If this is not the case and you are worried, please contact us!\n".
		"\n".
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' Robot'.PHP_EOL,
);

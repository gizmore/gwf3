<?php
$lang = array(

	'alt_flag' => '%s',

	# Page Info
	'pi_invited' => 'You got invited to <a href="%s">join %ss usergroup &quot;%s&quot;</a>.<br/><br/><br/>Or <a href="%s">click here to refuse the request</a>.',

	# Avatar Gallery
	'pt_avatars' => 'Avatar Gallery.',
	'pi_avatars' => 'The '.GWF_SITENAME.' avatar gallery.',
	'mt_avatars' => GWF_SITENAME.', Avatar, Gallery',
	'md_avatars' => 'The user avatar gallery on '.GWF_SITENAME,

	# Table Headers 
	'th_name' => 'Groupname',
	'th_join' => 'How to Join',
	'th_view' => 'Visibility',
	'th_user_name' => 'Username',
	'th_user_level' => 'Level',
	'th_user_email' => 'EMail',
	'th_user_regdate' => 'Register-Date',
	'th_user_birthdate' => 'Birthdate',
	'th_user_lastactivity' => 'Last activity',
	'th_group_name' => 'Groupname',
	'th_group_memberc' => 'Members',
	'th_group_founder' => 'Founder',

	# Form Titles
	'ft_edit' => 'Edit your usergroup',
	'ft_create' => 'Create a new usergroup',
	'ft_invite' => 'Invite someone to your group',

	# Buttons
	'btn_kick' => 'Kick User',
	'btn_edit' => 'Edit Group',
	'btn_delete' => 'Remove Group',
	'btn_create' => 'Create Group',
	'btn_invite' => 'Invite User',
	'btn_accept' => 'Accept as Member',
	'btn_gallery' => 'Avatar Gallery',
	'btn_search' => 'Search User',
	'btn_part' => 'Part',
	'btn_add_group' => 'Create Group',

	# Errors
	'err_perm' => 'You do not have permission to create a group.',
	'err_join' => 'The Join Option is invalid.',
	'err_view' => 'The View Option is invalid.',
	'err_name' => 'The Group Name is invalid. It has to be %s to %s characters long and has to start with a letter.',
	'err_group_exists' => 'You already have a usergroup.',
	'err_group' => 'You do not have a usergroup.',
	'err_kick_leader' => 'You can not kick the group founder.',
	'err_kick' => 'The user %s is not in the group.',
	'err_unk_group' => 'The group is unknown.',
	'err_no_join' => 'You can not join this group by yourself.',
	'err_join_twice' => 'You are already in this group.',
	'err_request_twice' => 'You already sent a join request to this group.',
	'err_not_invited' => 'You have not been invited to this group.',

	# Messages
	'msg_created' => 'Your Usergroup has been created.',
	'msg_edited' => 'Your Usergroup has been edited.',
	'msg_kicked' => '%s got kicked off your group.',
	'msg_joined' => 'You joined the group &quot;%s&quot;.',
	'msg_requested' => 'You requested to join &quot;%s&quot;.',
	'msg_accepted' => 'The user %s is now member of the group &quot;%s&quot;.',
	'msg_invited' => 'You invited %s to join your group.',
	'msg_refused' => 'You refused to join the group &quot;%s&quot;.',

	# Selects
	'sel_join_type' => 'How can users join your group?',
	'sel_join_1' => 'Group is full',
	'sel_join_2' => 'By Invitation',
	'sel_join_4' => 'Moderated List',
	'sel_join_8' => 'Click and Join',
	'sel_join_16' => 'By Script',
	'sel_view_type' => 'Select the visibility for your group',
	'sel_view_'.(0x100) => 'Public Forums',
	'sel_view_'.(0x200) => 'Only '.GWF_SITENAME.' Members',
	'sel_view_'.(0x400) => 'Only members of this Group',
	'sel_view_'.(0x800) => 'By Script',

	# Admin
	'cfg_ug_level' => 'User Level needed to create a group',
	'cfg_ug_maxlen' => 'Max-Length of Groupname',
	'cfg_ug_minlen' => 'Min-Length of Groupname',
//	'cfg_ug_bid' => 'Parent Board for Usergroup',

	# EMails
	'mail_subj_req' => GWF_SITENAME.': %s wants to join the group %s',
	'mail_body_req' =>
		'Dear %s,'.PHP_EOL.
		PHP_EOL.
		'%s likes to join the usergroup &quot;%s&quot;.'.PHP_EOL.
		'To accept this request you can visit the link below:'.PHP_EOL.
		PHP_EOL.
		'%s',
		
		
	# V2.01 finish + your groups
	'cfg_ug_menu' => 'Show in menu',
	'cfg_ug_submenu' => 'Show in submenu',
	'cfg_ug_ax' => 'Num avatars on x-axis',	
	'cfg_ug_ay' => 'Num avatars on y-axis',	
	'cfg_ug_grp_per_usr' => 'Max groups per user',	
	'cfg_ug_ipp' => 'Items per page',	
	'cfg_ug_lvl_per_grp' => 'Level per group',
	'cfg_ug_submenugroup' => 'Name of submenu',

	# V2.02 finish2
	'btn_groups' => 'Usergroups',
		
	# V2.03 finish3
	'btn_users' => 'Users',
		
	# v2.04
	'invite_title' => 'Invitation to %s',
	'invite_message' =>
		'Hello %s,'.PHP_EOL.
		PHP_EOL.
		'%s just invited you to join his usergroup \'%s\'.'.PHP_EOL.
		'To join his group, you can visit this page: %s'.PHP_EOL.
		PHP_EOL.
		'If you don`t want to join the group, you can ignore this PM, or deny the request by visiting this page: %s',
		
	# v2.05 (Jinx Edition)
	'err_not_in_group' => 'The user %s is not in this group.',
	'btn_unco' => 'Co-Leader',
	'btn_co' => 'No Co-Leader',
	'btn_unhide' => 'Hide',
	'btn_hide' => 'Show',
	'btn_unmod' => 'Moderator',
	'btn_mod' => 'No Moderator',
	'msg_ugf_2_0' => 'The user %s is not Co-Leader anymore.',
	'msg_ugf_2_1' => 'The user %s is now Co-Leader.',
	'msg_ugf_4_0' => 'The user %s is not Moderator anymore.',
	'msg_ugf_4_1' => 'The user %s is now Moderator.',
	'msg_ugf_8_0' => 'The user %s is now visible in the member list.',
	'msg_ugf_8_1' => 'The user %s is now hidden in the member list.',
	'th_vis_grp' => 'Always list group',
	'th_vis_mem' => 'Always list members',
	'tt_vis_grp' => 'If this option is enabled, the group is always visible in the group list.',
	'tt_vis_mem' => 'If this option is enabled, the memberlist is always accessible. Note that you can hide users separately.',
		
	# v2.06 (delete usergroup BAAL)
	'ft_del_group' => 'Do you really want to delete the usergroup %s?',
	'th_del_groupname' => 'Retype groupname',
	'tt_del_groupname' => 'Please type the name of the group to confirm.',
	'btn_del_group' => 'Yes, I want to delete the usergroup %s!',
	'msg_del_group' => 'The usergroup %s has been deleted. %s permissions have been revoked.',
		
	# v2.07 (Adv Search)
	'btn_adv_search' => 'Advanced Search',
	'ft_search_adv' => 'Advanced Usersearch',
	'th_country' => 'Country',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo',
	'th_aim' => 'AIM',
	'th_language' => 'Language',			
	'th_hasmail' => 'EMail',
	'th_haswww' => 'Website',
	'th_gender' => 'Gender',
	'err_minlevel' => 'Your specified minimum level is invalid.',
);
?>
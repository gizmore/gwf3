<?php

$lang = array(
	# Admin Config
	'cfg_link_guests' => 'Allow Guests to add Links?',
	'cfg_link_guests_captcha' => 'Show Captcha for Guests?',
	'cfg_link_guests_mod' => 'Moderate Guest Links?',
	'cfg_link_guests_votes' => 'Allow Guests to Vote?',
	'cfg_link_long_descr' => 'Use a 2nd / Long Description?',
	'cfg_link_cost' => 'Score per Link',
	'cfg_link_max_descr2_len' => 'Max length Long Descr.',
	'cfg_link_max_descr_len' => 'Max length Small Desc.',
	'cfg_link_max_tag_len' => 'Max Tag length',
	'cfg_link_max_url_len' => 'Max URL length',
	'cfg_link_min_descr2_len' => 'Min Long Descr. length',
	'cfg_link_min_descr_len' => 'Min Short Descr. length',
	'cfg_link_min_level' => 'Minimum Level to add Link',
	'cfg_link_per_page' => 'Links per page',
	'cfg_link_tag_min_level' => 'Min Level to add Tag',
	'cfg_link_vote_max' => 'Votescore max',
	'cfg_link_vote_min' => 'Votescore min',
	'cfg_link_guests_unread' => 'Duration a link appears new for Guests',
	
	# Info`s
//	'pi_links' => '',
	'info_tag' => 'Specify at least one Tag. Separate Tags by comma. Try use existing tags:',
	'info_newlinks' => 'There are %s new Links for you.',
	'info_search_exceed' => 'Your search exceeded the result limit of %s.',

	# Titles
	'ft_add' => 'Add a Link',
	'ft_edit' => 'Edit Link',
	'ft_search' => 'Search the links',
	'pt_links' => 'All Links',
	'pt_linksec' => '%s Links',
	'pt_new_links' => 'New Links',
	'mt_links' => GWF_SITENAME.', Link, List, All Links',
	'md_links' => 'All links on '.GWF_SITENAME.'.',
	'mt_linksec' => GWF_SITENAME.', Link, List, Links about %s',
	'md_linksec' => '%s links on '.GWF_SITENAME.'.',

	# Errors
	'err_gid' => 'The UserGroup is invalid.',
	'err_score' => 'Invalid value for score.',
	'err_no_tag' => 'Please Specify at least one tag.',
	'err_tag' => 'The Tag %s is invalid and got removed. The tag has to be %s - %s bytes.',
	'err_url' => 'The URL looks invalid.',
	'err_url_dup' => 'The URL is alrady listed here.',
	'err_url_down' => 'The URL is not reachable.',
	'err_url_long' => 'Your URL is too long. Max %s bytes.',
	'err_descr1_short' => 'Your description is too short. Min %s bytes.',
	'err_descr1_long' => 'Your description is too long. Max %s bytes.',
	'err_descr2_short' => 'Your detailed description is too short. Min %s bytes.',
	'err_descr2_long' => 'Your detailed description is too long. Max %s bytes.',
	'err_link' => 'Link not found.',
	'err_add_perm' => 'You are not allowed to add a link.',
	'err_edit_perm' => 'You are not allowed to edit this link.',
	'err_view_perm' => 'You are not allowed to view this link.',
	'err_add_tags' => 'You are not allowed to add new tags.',
	'err_score_tag' => 'Your userlevel(%s) is not high enough to add another tag. Needed Level: %s.',
	'err_score_link' => 'Your userlevel(%s) is not high enough to add another link. Needed Level: %s.',
	'err_approved' => 'The link was already approved. Please use the staff section to take actions.',
	'err_token' => 'The token is invalid.',

	# Messages
//	'msg_redirecting' => 'Redirecting you to %s.',
	'msg_added' => 'Your link has been added to the database.',
	'msg_added_mod' => 'Your link has been added to the database, but a Moderator has to check it out first.',
	'msg_edited' => 'The link has been edited.',
	'msg_approved' => 'The link has been approved and is shown now.',
	'msg_deleted' => 'The link has been deleted.',
	'msg_counted_visit' => 'Your click has been counted.',
	'msg_marked_all_read' => 'Marked all the new links as read.',
	'msg_fav_no' => 'The link has been removed from your favorite list.',
	'msg_fav_yes' => 'The link has been put in your favorite list.',

	# Table Headers
	'th_link_score' => 'Score',
	'th_link_gid' => 'Group',
	'th_link_tags' => 'Tags',
	'th_link_href' => 'HREF',
	'th_link_descr' => 'Description',
	'th_link_descr2' => 'Detailed Description',
	'th_link_options&1' => 'Sticky?',
	'th_link_options&2' => 'In Moderation?',
	'th_link_options&4' => 'Don`t show username?',
	'th_link_options&8' => 'Show only to members?',
	'th_link_options&16' => 'Is this link Private?',
	'th_link_id' => 'ID',
	'th_showtext' => 'Link',
	'th_favs' => 'Favcount',
	'th_link_clicks' => 'Visits',
	'th_vs_avg' => 'Avg',
	'th_vs_sum' => 'Sum',
	'th_vs_count' => 'Votes',
	'th_vote' => 'Vote',
	'th_link_date' => 'Insert Date',
	'th_user_name' => 'Username',

	# Tooltips
	'tt_link_gid' => 'Restrict Link to a usergroup (or leave blank)',
	'tt_link_score' => 'Specify a minimum User Level (0-NNNN)',
	'tt_link_href' => 'Submit the full URL, with starting http://',

	# Buttons
	'btn_add' => 'Add Link',
	'btn_delete' => 'Delete Link',
	'btn_edit' => 'Edit Link',
	'btn_search' => 'Search',
	'btn_preview' => 'Preview',
	'btn_new_links' => 'New Links',
	'btn_mark_read' => 'Mark all as read',
	'btn_favorite' => 'Mark as a favorite Link',
	'btn_un_favorite' => 'UnMark favorite Link',
	'btn_search_adv' => 'Advanced Search',

	# Staff EMail
	'mail_subj' => GWF_SITENAME.': New Link',
	'mail_body' =>
		'Dear Staff,'.PHP_EOL.
		PHP_EOL.
		'There has been posted a new Link from a guest that needs moderation:'.PHP_EOL.
		PHP_EOL.
		'Description: %s'.PHP_EOL.
		'Detailed D.: %s'.PHP_EOL.
		'HREF / URL : %s'.PHP_EOL.
		PHP_EOL.
		'You can either: '.PHP_EOL.
		'1) Approve this link by visiting %s'.PHP_EOL.
		'Or:'.PHP_EOL.
		'2) Delete this link by visiting %s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' Script'.PHP_EOL,
		
	# v2.01 (SEO)
	'pt_search' => 'Search links',
	'md_search' => 'Search links on the '.GWF_SITENAME.' website.',
	'mt_search' => 'Search,'.GWF_SITENAME.',Links',
		
	# v2.02 (permitted)
	'permtext_in_mod' => 'This link is in moderation',
	'permtext_score' => 'You need a userlevel of %s to see this link',
	'permtext_member' => 'This link is only for members',
	'permtext_group' => 'You need to be in the %s group to see this link',
	'cfg_show_permitted' => 'Show forbidden links reason?',
		
	# v3.00 (fixes)
	'cfg_link_check_amt' => 'UpDownChecker Amount',
	'cfg_link_check_int' => 'UpDownChecker Interval',
		
);

?>
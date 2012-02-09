<?php

$lang = array(
## SCOREVOTE ##

	# votebuttons.php
	'alt_button' => 'Vote %s',
	'title_button' => 'Vote %s',

	# Errors
	'err_votescore' => 'Vote table not found for that item.',
	'err_score' => 'Your voted score is not valid.',
	'err_expired' => 'The votes for that item have been expired.',
	'err_disabled' => 'The votes for that item are currently disabled.',
	'err_vote_ip' => 'This item has been voted by your IP already.',
	'err_no_guest' => 'Guests are not allowed to vote this item.',
	'err_title' => 'Your title has to be between %s and %s chars long.',
	'err_options' => 'Your Poll Option(s) %s is/are errorneous and probably not within the limits of %s to %s chars.',
	'err_no_options' => 'You did not specify any options.',

	# Messages
	'msg_voted' => 'Vote registered. <a href="%s">Click here</a> to return to your last location.',

	## POLLS ##

	'poll_votes' => '%s Votes',
	'votes' => 'votes',
	'voted' => 'voted',
	'vmview_never' => 'Never',
	'vmview_voted' => 'After vote',
	'vmview_allways' => 'Always',

	'th_date' => 'Date',
	'th_votes' => 'Votes',
	'th_title' => 'Title',
	'th_multi' => 'Allow multiple choices?',
	'th_option' => 'Option %s',
	'th_guests' => 'Allow guest votes?',
	'th_mvview' => 'Show result',
	'th_vm_public' => 'Show in Sidebar?',
	'th_enabled' => 'Enabled?',
	'th_top_answ' => 'Top Answer(s)',

	'th_vm_gid' => 'Restrict to group',		
	'th_vm_level' => 'Restrict by level',

	'ft_edit' => 'Edit your poll',
	'ft_add_poll' => 'Assign one of your polls',
	'ft_create' => 'Create a new poll',

	'btn_edit' => 'Edit',
	'btn_vote' => 'Vote',
	'btn_add_opt' => 'Add Option',
	'btn_rem_opts' => 'Remove All Options',
	'btn_create' => 'Create Poll',

	'err_multiview' => 'The view-flag for this Poll is invalid.',
	'err_poll' => 'The Poll is unknown.',
	'err_global_poll' => 'You are not allowed to add a global poll.',
	'err_option_empty' => 'Option %s is empty.',
	'err_option_twice' => 'Option %s appears multiple times.',
	'err_no_options' => 'You forgot to specify an option for your poll.',
	'err_no_multi' => 'You may only choose one option.',
	'err_poll_off' => 'This poll is currently disabled.',
	
	'msg_poll_edit' => 'Your poll has been edited successfully.',
	'msg_mvote_added' => 'Your poll has been added succesfully.',

	# v2.01 Staff
	'th_vs_id' => 'ID',
	'th_vs_name' => 'Name',
	'th_vs_expire_date' => 'Expires',
	'th_vs_min' => 'Min',
	'th_vs_max' => 'Max',
	'th_vs_avg' => 'Avg',
	'th_vs_sum' => 'Sum',
	'th_vs_count' => 'Count',

	# v2.02
	'th_reverse' => 'Reversible?',
	'err_irreversible' => 'You have already voted this item and the votes for this item are not reversible.',
	'err_pollname_taken' => 'This pollname is already taken.',

	# v3.00 (fixes)
	'err_gid' => 'Please select a valid usergroup.',
	'msg_voted_ajax' => 'Thank you for your vote.',

	#monnino fixes
	'cfg_vote_guests' => 'Allow vote to guests',
	'cfg_vote_iconlimit' => 'Icon limit',
	'cfg_vote_option_max' => 'Max option number',
	'cfg_vote_option_min' => 'Min option number',
	'cfg_vote_poll_level' => 'Poll required level',
	'cfg_vote_title_max' => 'Max title length',
	'cfg_vote_title_min' => 'Min title length',
	'cfg_vote_poll_group' => 'Poll required group',
	'cfg_vote_guests_timeout' => 'Guests timeout',
	'ft_edit_vs' => 'Edit votescore',
);

?>

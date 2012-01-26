<?php
 
$lang = array(

	# Errors
	'err_board' => 'The board is unknown, or you have no permission to access it.',
	'err_thread' => 'The thread is unknown, or you have no permission to access it.',
	'err_post' => 'The post is unknown.',
	'err_parentid' => 'The parent board is unknown.',
	'err_groupid' => 'The group is unknown.',
	'err_board_perm' => 'You are not allowed to access this board.',
	'err_thread_perm' => 'You are not allowed to access this thread.',
	'err_post_perm' => 'You are not allowed to read this post.',
	'err_reply_perm' => 'You are not allowed to reply to this thread. <a href="%s">Click here to return to the thread</a>.',
	'err_no_thread_allowed' => 'There are no threads allowed in this board.',
	'err_no_guest_post' => 'Guests are not allowed to post to this forum.',
	'err_msg_long' => 'Your message is too long. Max %s chars allowed.',
	'err_msg_short' => 'You forgot your message.',
	'err_descr_long' => 'Your description is too long. Max %s chars allowed.',
	'err_descr_short' => 'You forgot your description.',
	'err_title_long' => 'Your title is too long. Max %s chars allowed.',
	'err_title_short' => 'You forgot the title.',
	'err_sig_long' => 'Your signature is too long. Max %s chars allowed.',
	'err_subscr_mode' => 'Unknown subscription mode.',
	'err_no_valid_mail' => 'You don`t have an approved email to subscribe to the forums.',
	'err_token' => 'The token is invalid.',
	'err_in_mod' => 'This thread is currently in moderation.',
	'err_board_locked' => 'The board is temporarily locked.',
	'err_no_subscr' => 'You can not subscribe manually to this thread. <a href="%s">Click here to return to the thread</a>.',
	'err_subscr' => 'An error occured. <a href="%s">Click here to return to the thread</a>.',
	'err_no_unsubscr' => 'You can not unsubscribe from this thread. <a href="%s">Click here to return to the thread</a>.',
	'err_unsubscr' => 'An error occured. <a href="%s">Click here to return to the thread</a>.',
	'err_sub_by_global' => 'You did not subscribe to the thread manually, but by global option flags.<br/><a href="/forum/options">Use the ForumOptions</a> to change your flags.',
	'err_thank_twice' => 'You already have thanked for this post.',
	'err_thanks_off' => 'It is currently not possible to thank people for posts.',
	'err_votes_off' => 'Forum Post Voting is currently disabled.',
	'err_better_edit' => 'Please edit your post and do not double post. You can toggle a &quot;Mark-Unread&quot; Flag in case you do significant changes.<br/><a href="%s">Click here to return to the thread</a>.',

	# Messages
	'msg_posted' => 'Your message has been posted.<br/><a href="%s">Click here to see your message</a>.',
	'msg_posted_mod' => 'Your message has been posted, but will get reviewed before it is shown.<br/><a href="%s">Click here to return to the board</a>.',
	'msg_post_edited' => 'Your Post has been edited.<br/><a href="%s">Click here to return to your post</a>.',
	'msg_edited_board' => 'The board has been edited.<br/><a href="%s">Click here to return to the board</a>.',
	'msg_board_added' => 'The new board has been added successfully. <a href="%s">Click here to go to the board</a>.',
	'msg_edited_thread' => 'The Thread has been edited successfully.',
	'msg_options_changed' => 'Your options have been changed.',
	'msg_thread_shown' => 'The thread has been approved and is now shown.',
	'msg_post_shown' => 'The post has been approved and is now shown.',
	'msg_thread_deleted' => 'The thread has been deleted.',
	'msg_post_deleted' => 'The post has been deleted.',
	'msg_board_deleted' => 'The whole board has been deleted!',
	'msg_subscribed' => 'You subscribed manually to the thread and receive mail on new posts.<br/><a href="%s">Click here to return to the thread</a>.',
	'msg_unsubscribed' => 'You unsubscribed from the thread and will not receive emails any more.<br/><a href="%s">Click here to return to the thread</a>.',
	'msg_unsub_all' => 'You have unsubscribed your email from all threads.',
	'msg_thanked_ajax' => 'Your thanks have been recorded.',
	'msg_thanked' => 'Your thanks have been recorded.<br/><a href="%s">Click here to return to the post</a>.',
	'msg_thread_moved' => 'The Thread %s has been moved to %s.',
	'msg_voted' => 'Thank you for your vote.',
	'msg_marked_read' => 'Successfully marked %s threads as read.',

	# Titles
	'forum_title' => GWF_SITENAME.' Forums',
	'ft_add_board' => 'Add a new Board',
	'ft_add_thread' => 'Add a new Thread',
	'ft_edit_board' => 'Edit existing Board',
	'ft_edit_thread' => 'Edit Thread',
	'ft_options' => 'Setup your Forum options',
	'pt_thread' => '%2$s ['.GWF_SITENAME.']->%1$s',
	'ft_reply' => 'Reply to the Thread',
	'pt_board' => '%s',
//	'pt_board' => '%s ['.GWF_SITENAME.']',
	'ft_search_quick' => 'Quick-Search',
	'ft_edit_post' => 'Edit your post',
	'at_mailto' => 'Send EMail to %s',
	'last_edit_by' => 'Last edited by %s - %s',

	# Page Info
	'pi_unread' => 'Unread Threads for you',

	# Table Headers
	'th_board' => 'Board',
	'th_threadcount' => 'Threads',
	'th_postcount' => 'Posts',
	'th_title' => 'Title',
	'th_message' => 'Message',
	'th_descr' => 'Description',	
	'th_thread_allowed' => 'Threads allowed',	
	'th_locked' => 'Locked',
	'th_smileys' => 'Disable Smileys',
	'th_bbcode' => 'Disable BBCode',
	'th_groupid' => 'Restrict to Group',
	'th_board_title' => 'Board Title',
	'th_board_descr' => 'Board Description',
	'th_subscr' => 'Email Subscription',
	'th_sig' => 'Your Forum Signature',
	'th_guests' => 'Allow Guest Posts',
	'th_google' => 'Don`t include Google/Translate Javascript',
	'th_firstposter' => 'Creator',
	'th_lastposter' => 'Reply From',
	'th_firstdate' => 'First Post',
	'th_lastdate' => 'Last Post',
	'th_post_date' => 'Post Date',
	'th_user_name' => 'Username',
	'th_user_regdate' => 'Registered',
//	'th_unread_again' => '',
	'th_sticky' => 'Sticky',
	'th_closed' => 'Closed',
	'th_merge' => 'Merge Thread',
	'th_move_board' => 'Move Board',
	'th_thread_thanks' => 'Thanks',
	'th_thread_votes_up' => 'UpVotes',
	'th_thanks' => 'Thx',
	'th_votes_up' => 'VoteUp',

	# Buttons
	'btn_add_board' => 'Create new Board',
	'btn_rem_board' => 'Delete Board',
	'btn_edit_board' => 'Edit current Board',
	'btn_add_thread' => 'Add Thread',
	'btn_preview' => 'Preview',
	'btn_options' => 'Edit your Forum Settings',
	'btn_change' => 'Change',
	'btn_quote' => 'Quote',
	'btn_reply' => 'Reply',
	'btn_edit' => 'Edit',
	'btn_subscribe' => 'Subscribe',
	'btn_unsubscribe' => 'Un-Subscribe',
	'btn_search' => 'Search',
	'btn_vote_up' => 'Good Post!',
	'btn_vote_down' => 'Bad Post!',
	'btn_thanks' => 'Thank You!',
	'btn_translate' => 'Google/translate',

	# Selects
	'sel_group' => 'Select a Usergroup',
	'subscr_none' => 'Nothing',
	'subscr_own' => 'Where I\'ve Posted',
	'subscr_all' => 'All Threads',

	# Config
	'cfg_guest_posts' => 'Allow Guest Posts',	
	'cfg_max_descr_len' => 'Max Description Length',	
	'cfg_max_message_len' => 'Max Message Length',
	'cfg_max_sig_len' => 'Max Signature Length',
	'cfg_max_title_len' => 'Max Title Length',
	'cfg_mod_guest_time' => 'Auto Moderation Time',
	'cfg_num_latest_threads' => 'Num Latest Threads',
	'cfg_num_latest_threads_pp' => 'Threads Per History Page',
	'cfg_posts_per_thread' => 'Num Posts per Thread',
	'cfg_search' => 'Search allowed',
	'cfg_threads_per_page' => 'Threads per Board',
	'cfg_last_posts_reply' => 'Number of Shown posts on reply',
	'cfg_mod_sender' => 'Moderation EMail Sender',
	'cfg_mod_receiver' => 'Moderation EMail Receiver',
	'cfg_unread' => 'Enable Unread Threads',
	'cfg_gtranslate' => 'Enable Google Translate',	
	'cfg_thanks' => 'Enable Thanks',
	'cfg_uploads' => 'Enable Uploads',
	'cfg_votes' => 'Enable Voting',
	'cfg_mail_microsleep' => 'EMail Microsleep :/ .. ???',	
	'cfg_subscr_sender' => 'EMail Subscription Sender',

	# show_thread.php
	'posts' => 'Posts',
	'online' => 'The User is Online',
	'offline' => 'The User is Offline',
	'registered' => 'Registered at',
	'watchers' => '%s people are watching the thread at the moment.',
	'views' => 'This thread has been viewed %s times.',

	# forum.php
	'latest_threads' => 'Latest Activities',

	# Moderation EMail
	'modmail_subj' => GWF_SITENAME.': Moderate Post',
	'modmail_body' =>
		'Dear Staff'.PHP_EOL.
		PHP_EOL.
		'There is a new Post or Thread in the '.GWF_SITENAME.' Forums that needs moderation.'.PHP_EOL.
		PHP_EOL.
		'Board: %s'.PHP_EOL.
		'Thread: %s'.PHP_EOL.
		'From: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'To delete the post use this link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'To allow this post use this link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'The post will get automatically shown after %s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' Team'.PHP_EOL,

	# New Post EMail
	'submail_subj' => GWF_SITENAME.': New Post',
	'submail_body' => 
		'Dear %s'.PHP_EOL.
		PHP_EOL.
		'There are %s new Post(s) in the '.GWF_SITENAME.' Forums'.PHP_EOL.
		PHP_EOL.
		'Board: %s'.PHP_EOL.
		'Thread: %s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL. # Multiple msgs possible
		PHP_EOL.
		PHP_EOL.
		'To view the thread please visit this page:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'To unsubscribe from this thread follow the link below:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'To unsubscribe from the whole board, you can follow this link:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' Team'.PHP_EOL,
		
	'submail_body_part' =>  # that`s the %s above
		'From: %s'.PHP_EOL.
		'Title: %s'.PHP_EOL.
		'Message:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'<hr/>'.PHP_EOL.
		PHP_EOL,
		
	# v2.01 (last seen)
	'last_seen' => 'Last Seen: %s',

	# v2.02 (Mark all read)
	'btn_mark_read' => 'Mark all read',
	'msg_mark_aread' => 'Marked %s threads as read.',

	# v2.03 (Merge)
	'msg_merged' => 'The threads have been merged.',
	'th_viewcount' => 'Views',

	# v2.04 (Polls)
	'ft_add_poll' => 'Assign one of your polls',
	'btn_assign' => 'Assign',
	'btn_polls' => 'Polls',
	'btn_add_poll' => 'Add Poll',
	'msg_poll_assigned' => 'Your poll got successfully assigned.',
	'err_poll' => 'The poll is unknown.',
	'th_thread_pollid' => 'Your Poll',
	'pi_poll_add' => 'Here you can assign a poll to your thread, or create a new one.<br/>After creation you need to assign your poll to your thread here again.',
	'sel_poll' => 'Select one poll',
		
	# v2.05 (refinish)
	'th_hidden' => 'Is Hidden?',
	'th_thread_viewcount' => 'Views',
	'th_unread_again' => 'Mark as Unread again?',
	'cfg_doublepost' => 'Allow bumps / double posts?',
	'cfg_watch_timeout' => 'Mark thread watching for N seconds',
	'th_guest_view' => 'Guest Viewable?',
	'pt_history' => 'Forum history - Page %s / %s',
	'btn_unread' => 'New Threads',
		
	# v2.06 (Admin Area)
	'th_approve' => 'Approve',
	'th_delete' => 'Delete',
		
	# v2.07 rerefinish
	'btn_pm' => 'PM',
	'permalink' => 'link',
		
	# v2.08 (attachment)
	'cfg_postcount' => 'Postcount',
	'msg_attach_added' => 'Your attachment has been uploaded. <a href="%s">Click here to return to your post.</a>',
	'msg_attach_deleted' => 'Your attachment has been deleted. <a href="%s">Click here to return to your post.</a>',
	'msg_attach_edited' => 'Your attachment has been edited. <a href="%s">Click here to return to your post.</a>',
	'msg_reupload' => 'Your attachment has been replaced.',
	'btn_add_attach' => 'Add Attachment',
	'btn_del_attach' => 'Delete Attachment',
	'btn_edit_attach' => 'Edit Attachment',
	'ft_add_attach' => 'Add Attachment',
	'ft_edit_attach' => 'Edit Attachment',
	'th_attach_file' => 'File',
	'th_guest_down' => 'Guest downloadable?',
	'err_attach' => 'Unknown attachment.',
	'th_file_name' => 'File',
	'th_file_size' => 'Size',
	'th_downloads' => 'Hits',

	# v2.09 Lang Boards
	'cfg_lang_boards' => 'Create language boards',
	'lang_board_title' => '%s Board',
	'lang_board_descr' => 'For %s language',
	'lang_root_title' => 'Foreign language',
	'lang_root_descr' => 'Non english boards',
	'md_board' => GWF_SITENAME.' Forums. %s',
	'mt_board' => GWF_SITENAME.', Forum, Guest Posts, Alternate, Forum, Software',
		
	# v2.10 subscribers
	'subscribers' => '%s have subscribed to this thread and receive emails on new posts.',
	'th_hide_subscr' => 'Hide your subscriptions?',

	# v2.11 fixes11
	'txt_lastpost' => 'Goto last post',
	'err_thank_self' => 'You cannot thank yourself for a post.',
	'err_vote_self' => 'You cannot vote your own posts.',
		
	# v3.00 fixes 12
	'info_hidden_attach_guest' => 'You need to login to see an attachment.',
	'msg_cleanup' => 'I have deleted %s threads and %s posts that have been in moderation.',
		
	# v1.05 (subscriptions)
	'submode' => 'Your global subscription mode is set to: &quot;%s&quot;.',
	'submode_all' => 'The whole board',
	'submode_own' => 'Where you posted',
	'submode_none' => 'Manually',
	'subscr_boards' => 'Your have manually subscribed to %s boards.',
	'subscr_threads' => 'You have manually subscribed to %s threads.',
	'btn_subscriptions' => 'Manage Subscriptions',
	'msg_subscrboard' => 'You have manually subscribed to this board and receive email on new posts.<br/>Click <a href="%s">here to return to the board</a>.',
	'msg_unsubscrboard' => 'You have unsubscribed from this board and do not receive emails for it anymore.<br/>Click <a href="%s">here to return to your subscription overview</a>.',
		
	# v1.06 (Post limits)
	'err_post_timeout' => 'You have just recently posted. Please wait %s.',
	'err_post_level' => 'You need a minimum userlevel of %s to post.',
	'cfg_post_timeout' => 'Minimum time between two posts',
	'cfg_post_min_level' => 'Minimum level to post',
		
	# monnino fixes
	'btn_cleanup' => 'Clean up',
	'cfg_guest_captcha' => 'Guest Captcha?',
	'cfg_gwf2_rewrites' => 'Use old gwf2 forum rewrite rules',
		
);

?>
<?php
$lang = array(
	# You need to branch these in a new langfile for adding default titles!
	'titles' => array(
		'0' => 'Please select a title',
		'website' => 'I have problems using the website',
		'order' => 'I have paid for an order, but did not receive the item',
		'trans' => 'I have spotted errors in a translation',
		'error' => 'I encountered an error on the website',
		'other' => 'Other problem:',
	),

	'pt_helpdesk' => 'Helpdesk',
	'pi_helpdesk' => 'Welcome to the helpdesk. Feel free to create new tickets and get them resolved.',
	
	'pt_new_ticket' => 'Helpdesk - Create a new ticket',
	'pi_new_ticket' => 'Please try to support us with as much relevant data as possible. What was the expected result? What did you try?', 

	'pt_faq' => 'Frequently asked questions',
	'pi_faq' => 'Browse frequently asked questions that have been generated from the helpdesk tickets.',
	
	'ft_new_ticket' => 'Create a new ticket',
	'ft_reply' => 'Reply to the ticket',
	'ft_add_faq' => 'Add an FAQ entry',
	'ft_edit_faq' => 'Edit an FAQ entry',
	
	'btn_reply' => 'Reply',
	'btn_new_ticket' => 'New Ticket',
	'btn_my_tickets' => 'My Tickets',
	'btn_staffdesk' => 'Staff Area',
	'btn_work' => 'Claim Ticket', 
	'btn_faq' => 'Allow',
	'btn_nofaq' => 'Disallow',
	'btn_close' => 'Close ticket as solved',
	'btn_unsolve' => 'Close ticket as unsolveable',
	'btn_infaq' => 'List in FAQ',
	'btn_noinfaq' => 'Hide from FAQ',
	'btn_show_open' => 'Open',
	'btn_show_work' => 'Claimed',
	'btn_show_closed' => 'Closed',
	'btn_show_unsolved' => 'Unsolved',
	'btn_show_own' => 'Own',
	'btn_show_all' => 'All',
	'btn_show_faq' => 'FAQ',
	'btn_add_faq' => 'Add FAQ',
	'btn_edit_faq' => 'Edit FAQ',
	'btn_rem_faq' => 'Remove FAQ',
	'btn_gen_faq' => 'Generate FAQ',
	
	'err_token' => 'The token does not match.',
	'err_not_open' => 'This ticket is not open.',
	'err_ticket' => 'This ticket is unknown.',
	'err_message' => 'Your message has to be between %s and %s chars long.',
	'err_no_other' => 'Please specify an own title when selecting other title.',
	'err_other_len' => 'Your title is too long. Max %s chars are allowed.',
	'err_title' => 'Please select a valid title or select Other problem: and specify your own.',
	'err_priority' => 'The priority has to be between %s and %s.',
	'err_tmsg' => 'The message for this ticket could not been found.',
	'err_two_workers' => 'This ticket already has a worker assigned.',
	'err_no_faq' => 'The user does not want the item beeing listed in the faq.',
	'err_question' => 'The question has to be between %s and %s chars long.',
	'err_answer' => 'The answer has to be between %s and %s chars long.',
	'err_faq' => 'The FAQ entry could not been found.',
	'err_confirm_delete' => 'Please checkmark the deletion box to confirm the deletion.',
	
	'msg_created' => 'Your ticket has been created.',
	'msg_assigned' => 'Ticket #%s is now assigned to %s.',
	'msg_raised' => 'The priority has been raised by %s.',
	'msg_lowered' => 'The priority has been lowered by %s.',
	'msg_replied' => 'You have replied to the ticket.',
	'msg_read' => 'The message has been marked as read.',
	'msg_faq' => 'The ticket is now allowed to be listed in the faq.',
	'msg_nofaq' => 'The ticket may not be listed in the faq.',
	'msg_infaq' => 'The ticket is now visible in the faq.',
	'msg_noinfaq' => 'The ticket is not visible in the faq.',
	'msg_solve_solved' => 'The ticket is now marked as closed.',
	'msg_solve_unsolved' => 'The ticket is now closed and marked as unsolveable.',
	'msg_mfaq_0' => 'The message is not part of the faq anymore.',
	'msg_mfaq_1' => 'The message is now part of the faq.',
	'msg_new_faq' => 'A ticket has been added to the faq.',
	'msg_rem_faq' => 'A ticket has been removed from the faq.',
	'msg_faq_add' => 'A new FAQ entry has been added.',
	'msg_faq_del' => 'The FAQ entry has been deleted.',
	'msg_faq_edit' => 'The FAQ entry has been edited.',
	
	'th_tid' => '#',
	'th_prio' => 'Pri',
	'th_creator' => 'Created by',
	'th_worker' => 'Assigned to',
	'th_status' => 'Status',
	'th_title' => 'Title',
	'th_other' => 'Custom Title',
	'th_email_me' => 'Send me email on ticket updates',
	'th_allow_faq' => 'Allow my ticket in Faq',
	'tt_allow_faq' => 'If checked, you allow us to use your question and messages in the faq pages. You may enable this later.',
	'th_message' => 'Your message',
	'th_priority' => 'Priority',
	'th_unread' => 'New message',
	'th_lang' => 'Language',
	'tt_lang' => 'Leave blank for all languages.',
	'th_question' => 'Question',
	'th_answer' => 'Answer',
	'th_confirm_del' => 'Delete',
	
	'info_ticket_faq' => 'The user allows this ticket in the faq.',
	'info_ticket_nofaq' => 'The user does not allow this ticket in the faq.',
	'info_ticket_infaq' => 'The ticket is listed in the faq.',
	'info_ticket_noinfaq' => 'The ticket is not listed in the faq.',
	'info_msg_faq' => 'This message is shown in the faq.',
	'info_msg_nofaq' => 'This message is not shown in the faq.',
	
	'status_open' => 'Open',
	'status_working' => 'Processing',
	'status_solved' => 'Closed',
	'status_unsolved' => 'Unsolveable',
	
	### EMails ###
	'subj_nt' => 'New '.GWF_SITENAME.' Ticket #%s',
	'body_nt' =>
		'Dear %s, '.PHP_EOL.
		PHP_EOL.
		'A new helpdesk ticket has been created on '.GWF_SITENAME.'.'.PHP_EOL.
		'From: %s'.PHP_EOL.
		'Title: %s'.PHP_EOL.
		'Message:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'You can immediately claim to work on this ticket by visiting this page:'.PHP_EOL.
		'%s'.PHP_EOL,
		
	'subj_nmu' => GWF_SITENAME.' Ticket #%s',
	'body_nmu' =>
		'Dear %s, '.PHP_EOL.
		PHP_EOL.
		'There has been a reply to your helpdesk ticket.'.PHP_EOL.
		PHP_EOL.
		'From: %s'.PHP_EOL.
		'Message:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'If your are happy with the answer and the problem is solved, please close the ticket by visiting:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Else, please mark the message as read by visiting this page:'.PHP_EOL.
		'%s'.PHP_EOL,

	'subj_nms' => GWF_SITENAME.' Ticket #%s',
	'body_nms' =>
		'Hello %s, '.PHP_EOL.
		PHP_EOL.
		'There is a new reply to a Helpdesk ticket.'.PHP_EOL.
		'From: %s'.PHP_EOL.
		'Message:'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Please mark the message as read by visiting this page:'.PHP_EOL.
		'%s'.PHP_EOL,
	
	# monnino fixes
	'cfg_maxlen_message' => 'Message max length',
	'cfg_maxlen_title' => 'Title max length',
);
?>
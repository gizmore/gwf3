<?php
$lang = array(
	'help_+board' => 'Usage: %CMD% <url> <title>. Add a new forum script, that behaves like specified in https://www.wechall.net/index.php?mo=WeChall&me=JoinUs&section=optional#join_7',
	'help_-board' => 'Usage: %CMD% <url|id>. Mark a forum as deleted.',
	'help_linkboard' => 'Usage: %CMD% <url|id> [<boardids=0,1,2>] [<notboardids=1,2,3>]. Announce the activity of a forum in this channel. Boardid 0 means all boards from this url. Use notboardids to exclude certain boards from this forum.',
	'help_unlinkboard' => 'Usage: %CMD% <url|id>. Stop announcing a forum in this channel.',

	'err_known' => '%s is already in the database. The board has been re-enabled.',
	'err_board' => 'This board is not in the database.',
	'err_response' => 'The board %s does respond invalid.',
	'err_not_linked' => 'The board %s is not even linked here?!',
	'err_already_linked' => 'The board %s was already linked.',
		
	'msg_added' => 'I have added %s to the available forums.',
	'msg_disabled' => '%s has been disabled network wide.',
	'msg_linked' => '%s activities will be announcend here.',
	'msg_unlinked' => 'No more %s activities here.',
	
	'msg_entry' => '[%s] - %s has posted in "%s": %s',
);

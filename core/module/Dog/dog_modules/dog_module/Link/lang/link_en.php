<?php
$lang = array(
	'help_link' => 'Usage: %CMD% [id|search terms]. Display or search for a link. When no argument is given, a random link is displayed.',
	'help_links' => 'Usage: %CMD%. Display statistics for the links module.',
	'help_link++' => 'Usage: %CMD% <id>. Vote a link up.',
	'help_link--' => 'Usage: %CMD% <id>. Vote a link down.',
	'help_-link' => 'Usage: %CMD% <id>. Remove a link from the database.',
		
	'conf_collect_chan' => 'Collect links in this channe; 0=ForceOff, 1=ForceOn, 2=ServerSettings.',
	'conf_collect_serv' => 'Collect links on this server; 0=ForceOff, 1=ForceOn, 2=ServerSettings.',
	'conf_collect_user' => 'Collect links from this user; 0=ForceOff, 1=ForceOn, 2=ServerSettings.',
	'conf_collect_glob' => 'Global setting if %BOT% should collect links; 0=ForceOff, 1=ForceOn, 2=ServerSettings.',
		
	'show_link' => 'Link %d: %s - %s - Rated: %s.',
		
	'err_link_id' => 'The link with ID %d is unknown.',
	'err_no_match' => 'There was no link with your search term found. Maybe try ".link porn"!',

	'stats' => 'I have %d links in the database which have been voted %d times. The last ID is %d.',
	'matches' => '%d matches: %s.',
	'match_more' => '%d matches: %s, and %d more.',
	'voted' => 'Your vote has been registered.',
	'deleted' => 'Link with ID(%d) has been deleted.',
);
?>

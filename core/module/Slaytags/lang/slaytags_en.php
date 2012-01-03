<?php
$lang = array(
	'tag' => '%1$s (%2$s%%)',
	'now_playing' => 'Now playing',
	'previously_played' => 'Previously played',
	'tag_this_song' => 'Tag this song',
	'add_lyrics_to_song' => 'Add lyrics to this song',
	'you_not_tagged' => 'You did not tag this song yet.',
	'you_tagged' => 'You have tagged this song already, but you can change your submission.',
	'not_on_rko' => 'This song is not on RKO.',
	'dl_from_rko' => 'Download from remix.kwed.org',
	'show_lyrics' => 'Show lyrics',
	'info_quicksearch' => 'Use the quicksearch to search the whole slaytag database for keywords.<br/>The search should also crawl the lyrics, which you hopefully will provide.',

	'pt_lyrics' => '%2$s by %1$s [Lyrics]',

	'ft_tag' => 'Slaytagger',
	'ft_add_tag' => 'Add a new tag',
	'ft_add_lyrics' => 'Add all the lyrics!',
	'ft_search' => 'Quicksearch',
	'ft_edit_song' => 'Edit the song',

	'th_tag' => 'Tagname',
	'th_tags' => 'Tagged as',
	'th_date' => 'Date',
	'th_artist' => 'Artist', 
	'th_title' => 'Title',
	'th_composer' => 'SID Composer',
	'th_played' => 'Played',
	'th_duration' => 'Duration',
	'th_taggers' => 'Taggers',
	'th_lyrics' => 'Lyrics',
	'th_rko_download' => 'Download on RKO',
	'th_searchtag' => 'Searchtag',
	'th_searchterm' => 'Searchterm',
	'th_enabled' => 'Enabled?',

	'btn_tag' => 'Tag!',
	'btn_add' => 'Add',
	'btn_edit' => 'Edit',
	'btn_add_tag' => 'Add a new tag',
	'btn_add_lyrics' => 'Add Lyrics',
	'btn_download' => 'Download',
	'btn_search' => 'Search',
	'btn_flush_tags' => 'Delete all tags',

	'err_tag_uk' => 'The server received an invalid tag.',
	'err_tag' => 'Your tag is invalid. It has to be between %1$s and %2$s chars in length.',
	'err_lyrics' => 'Lyrics have to be between %1$s and %2$s chars in length.',
	'err_lyrics_unk' => 'Lyrics entry could not been found.',
	'err_song' => 'Song could not been found.',
	'err_add_tag' => 'You already have added a tag. Until the staff decides to be accepted you cannot add another tag.',
	'err_dup_tag' => 'This tag already exists.',
	'err_searchterm' => 'Your search term is invalid. It has to be between %1$s and %2$s letters long.',
	'err_searchtag' => 'Your provided tag is invalid.',
	'err_no_match' => 'Your search did not match any entry in the database.',
	'err_cross_login' => 'Your cross-login token is invalid.',

	'msg_tagged' => 'Thank you for tagging this song.',
	'msg_tag_added' => 'Thank you. A new tag has been added to the database.<br/><a href="%1$s">Return to the song to tag it!</a>',
	'msg_added_lyrics' => 'Thank you. Another lyrics entry has been made!',
	'msg_cross_login' => 'Your cross-site login token has logged you in with a username of %1$s.<br/>This is a very convinient way to start tagging right away.',
	'msg_song_edit' => 'The song has been edited.',
	'msg_tags_flushed' => 'The song got all it\'s tags removed.',

	###################
	### Lyrics Mail ###
	###################
	'mail_subj_lyri' => GWF_SITENAME.': Lyrics added',
	'mail_body_lyri' =>
		'Hello %1$s'.PHP_EOL.
		PHP_EOL.
		'The user %2$s has just added lyrics to %3$s - %4$s'.PHP_EOL.
		PHP_EOL.
		'%5$s'.PHP_EOL.
		PHP_EOL.
		'You can delete it here:'.PHP_EOL.
		'%6$s'.PHP_EOL.
		PHP_EOL.
		'Sincerly'.PHP_EOL.
		'The Slaytagginsite',
);
?>
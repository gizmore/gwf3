<?php
$lang = array(
	'ft_add' => 'Add new page',
	'ft_edit' => 'Edit this page',
	'ft_translate' => 'Translate this page',

	'lang_all' => 'All',

	'th_id' => 'ID',
	'th_otherid' => 'PID',
	'th_type' => 'Type',
	'th_cat' => 'Category',
	'th_url' => 'URL',
	'th_groups' => 'Allowed groups',
	'th_title' => 'Title',
	'th_descr' => 'Description',
	'th_tags' => 'Tags',
	'th_content' => 'Content',
	'th_inline_css' => 'Embedded CSS-Code',
	'th_noguests' => 'Login Required',
	'th_lang' => 'Language',
	'th_enabled' => 'Enabled',
	'th_file' => 'File',
	'th_show_author' => 'Show Author',
	'th_show_similar' => 'Show Similar Pages',
	'th_show_modified' => 'Show Modified Date',
	'th_show_trans' => 'Show Available Translations',
	'th_show_comments' => 'Allow comments',
	'th_home_page' => 'Set this page as GWF HomePage',
	'th_index' => 'Allow indexing',
	'th_follow' => 'Allow following',
	'th_in_sitemap' => 'List in sitemap',

	'sel_type' => 'Select a type',
	'type_html' => 'HTML',
	'type_bbcode' => 'BBCode',
	'type_smarty' => 'Smarty',

	'btn_add_page' => 'Add Page',
	'btn_add_link' => 'Add Link',
	'btn_add' => 'Add Page', // @deprecated
	'btn_edit' => 'Edit',
	'btn_translate' => 'Translate',
	'btn_upload' => 'Upload',

	'err_page' => 'Unknown page.',
	'err_404' => 'The page you are looking for does not exist.',
	'err_url' => 'Your url looks invalid or exceeds 255 characters. It may not begin with /.',
	'err_groups' => 'Your selected groups are invalid.',
	'err_title' => 'Your page title is invalid. It has to be between %s and %s chars long.',
	'err_descr' => 'Your meta description is invalid. It has to be between %s and %s chars long.',
	'err_tags' => 'Your tags are invalid. In total they have to be between %s and %s chars long.',
	'err_content' => 'Your page content is invalid. It has to be between %s and %s chars long.',
	'err_inline_css' => 'Your CSS code is invalid. It does not need CSS-style tag/HTML comment.',
	'err_dup_lid' => 'A translated page with this language already exists.',
	'err_file_ext' => 'Your uploaded file extension is not allowed. Appended &quot;.html&quot; to it.',
	'err_upload_exists' => 'A file with that name already exists.',
	'err_type' => 'Your page type is invalid. It has to be either html, bbcode or smarty.',

	'msg_added' => 'The <a href="%s" title="%s">page</a> has been added successfully.',
	'msg_edited' => 'The <a href="%s" title="%s">page</a> has been edited successfully.',
	'msg_trans' => 'A new page has been created, serving a translation for the current page.',
	'msg_file_upped' => 'The file has been uploaded to %s.',
	'msg_no_trans' => 'There are no available translations. If you like to, you can translate this page.',

	'info_author' => 'Author: %s',
	'info_modified' => 'Page created on %s. Last Modified on %s, %s.',
	'info_trans' => 'This page is also available in %s.',
	'info_similar' => 'You might be interested in similar pages: %s.',
	'info_pageviews' => 'The page has been served %s times.',

	'author' => 'Author',
	'created_on' => 'Created on',
	'modified_on' => 'Modified on',
	'translations' => 'Available translations',
	'similar_pages' => 'Similiar pages',
	'page_views' => 'Views',

	'cfg_home_page' => 'PageID of the GWF HomePage or 0 for None',
//	'cfg_ipp' => '',

	# monnino fixes 
	'btn_show_published' => 'Show Published', 
	'btn_show_revisions' => 'Show Revisions',
	'btn_show_disableds' => 'Show Disableds',
	'btn_show_locked' => 'Show Unmoderated',

	#v1.05 Searching, Locked pages and Overview
	'overview_title' => 'Page Overview on '.GWF_SITENAME,
	'mt_overview' => 'Pages,Papers,Tutorials,'.GWF_SITENAME,
	'md_overview' => 'An overview of pages, papers and tutorials on '.GWF_SITENAME,
	'overview_info' =>
		'BLA SEARCH.'.PHP_EOL.
		'BLA ADD',
	'translate_to' => 'Translate to %s',
	'ft_search' => 'Quicksearch',
	'th_term' => 'Searchterm',
	'btn_search' => 'Search',
	'btn_unlock' => 'Unlock',
	'btn_delete' => 'Delete',
	'msg_added_locked' => 'Your page has been created but will be reviewed before it gets published.',
	'msg_del_confirm' => 'To delete the page click here: <a href="%s">Delete Page</a>.',
	'msg_unlock_confirm' => 'To publish the page click here: <a href="%s">Publish Page</a>.',
	'err_dup_url' => 'The URL is already in use. Please change it.',
	'err_locked' => 'This page is still waiting to be reviewed and published.',
	'cfg_locked_posting' => 'Allow moderated guest posts?',
	'cfg_author_level' => 'Minimum level to add a page',
	'cfg_ipp' => 'Items per Page',
	'cfg_authors' => 'Author Usergroups',
	'tt_cfg_locked_posting' => 'Toggle if unpriviledged users may create pages that end up in the moderation queue.',
	'tt_cfg_authors' => 'Comma separated list of usergroup-names.',
	'btn_preview' => 'Preview',
	'msg_enabled' => 'The page is now <a href="%s">visible here</a>.',
	'msg_edit_locked' => 'Your page has been edited but will be reviewed before it gets published.',
	'err_token' => 'The token is invalid because the page has been moderated already.',
	'subj_mod' => GWF_SITENAME.': Page Moderation',
	'body_mod' =>
		'Hello %s'.PHP_EOL.
		PHP_EOL.
		'The user %s has just created or edited a page or translation on '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'URL: %s'.PHP_EOL.
		'Title: %s'.PHP_EOL.
		'Meta-Tags: %s'.PHP_EOL.
		'Description: %s'.PHP_EOL.
		'Inline-CSS:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Content:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'You can use these URLs for quick moderation:'.PHP_EOL.
		'ENABLE: %s'.PHP_EOL.
		PHP_EOL.
		'or'.PHP_EOL.
		PHP_EOL.
		'DELETE: %s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' Script'.PHP_EOL,
);
?>

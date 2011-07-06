<?php
function Upgrade_News_1_01(Module_News $module)
{
	if (false === gdo_db()->query('ALTER TABLE '.GWF_TABLE_PREFIX.'newstrans'.' ADD COLUMN newst_threadid INT(11) UNSIGNED NOT NULL DEFAULT 0')) {
		return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
	}
	$msg = GWF_HTML::message('News', 'It is now possible to have news in forums.');
	if (GWF_OUTPUT_BUFFERING) { echo $msg; } else { GWF_Website::addDefaultOutput($msg); }
	return '';
}
?>

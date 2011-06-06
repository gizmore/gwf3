<?php # Usage: %CMD% <page>. Search wikipedia.
$bot = Lamb::instance();

return;
if ($message === '') {
	return;
}



if (false === ($result = GWF_HTTP::getFromURL($url))) {
	return $bot->reply('Unknown page: '.$message);
}

?>
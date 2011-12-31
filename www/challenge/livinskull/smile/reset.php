<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Smile');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/livinskull/smile/index.php', false);
}
$chall->showHeader();

# Table and Helper :)
require_once 'challenge/livinskull/smile/LIVIN_Smile.php';

LVSM_refresh();

function LVSM_refresh()
{
	GDO::table('LIVIN_Smile')->truncate();
	
	if (false === ($dir = scandir('challenge/livinskull/smile/smiles')))
	{
		echo GWF_HTML::err(ERR_FILE_NOT_FOUND, 'smileys');
		return false;
	}
	
	foreach ($dir as $file)
	{
		if (1 === preg_match('/(.*)\.(?:gif|jpg|png|jpeg)$/', $file, $matches))
		{
			$rule = '/:'.preg_quote($matches[1]).':/';
			$path = '/challenge/livinskull/smile/smiles/'.$file;
			$path = sprintf('<img src="%s" />', htmlspecialchars($path)); 
			LIVIN_Smile::onAddSmiley($rule, $path);
		}
	}
	
	return true;
}

require_once('challenge/html_foot.php');
?>
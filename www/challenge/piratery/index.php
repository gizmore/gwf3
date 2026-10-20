<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Piratery');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/piratery/index.php');
}
$chall->showHeader();

$map = sprintf('<link rel="stylesheet" type="text/css" href="piratery.css" /><p><img src="piratery.png" alt="%s" class="piratery_img" /></p>', $chall->lang('title'));
echo GWF_Box::box('<div class="piratery_scroll">'.$chall->lang('info').$map.'</div>', $chall->lang('title'));

# The first answer is checked on rhum.php
GWF_Javascript::focusElementByID('answer');
$form = formSolutionboxForm($chall);
echo '<div id="wc_solutionbox">'.PHP_EOL.
	$form->templateX(WC_HTML::lang('ft_solution', array($chall->display('chall_title'))), 'rhum.php').
	'</div>'.PHP_EOL;

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');

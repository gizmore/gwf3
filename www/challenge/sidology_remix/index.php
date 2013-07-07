<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Sidology Remix');
require_once("challenge/html_head.php");
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/sidology_remix/index.php');
}
$chall->showHeader();
if ('' !== ($answer = Common::getPostString('answer')))
{
	sidologyRemixCheckAnswer($chall, $answer);
}
$args = array(
	'/challenge/sidology_remix/kweded.mp3',
	'<a href="http://remix.kwed.org" title="RKO">remix.kwed.org</a>',
	'<a href="http://slayradio.org" title="Slayradio">slayradio.org</a>',
	'<a href="http://hvsc.c64.org" title="High Voltage SID Collection">HVSC</a>',
	'http://remix.kwed.org/download.php/2886/Nada%20-%20Gremlins%20II%20%28The%20New%20Batch%29.mp3,837967736576,6978717378696982',
);
echo GWF_Box::box($chall->lang('info', $args), $chall->lang('title'));

formSolutionbox($chall);

echo $chall->copyrightFooter();
?>

<?php
function sidologyRemixCheckAnswer(WC_Challenge $chall, $answer)
{
	if (false !== ($error = $chall->isAnswerBlocked(GWF_User::getStaticOrGuest())))
	{
		echo $error;
		return;
	}
	
	$solution = '726f3a30c8ae485b4f34d5ff0fed05552d3da60b'; # :) HappyCracking!
	$hash = $answer;
	for ($i = 0; $i < 100000; $i++)
	{
		$hash = sha1($hash);
	}
// 	echo "$hash<br/>\n";
	
	if ($hash === $solution)
	{
		$chall->onChallengeSolved();
	}
	else
	{
		echo WC_HTML::error('err_wrong');
	}
}

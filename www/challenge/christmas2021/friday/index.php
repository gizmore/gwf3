<?php
require 'form.php';
chdir('../../../');
define('GWF_PAGE_TITLE', '2021 Christmas Friday');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 3, 'challenge/christmas2021/friday/index.php', false);
}
$chall->showHeader();

$accepted = 'HTTP/1.1 202 BunnyAccepted';

echo "<!-- BEGIN OF CHALLENGE -->\n";
echo GWF_Box::box($chall->lang('info', [$accepted]), $chall->lang('title'));
echo "<!-- END OF CHALLENGE -->\n";

$form = new Black_Friday_Form();

if (isset($_POST['satisfy']))
{
	$url = Common::getPostString('url');
	if ($form->execute($url, $accepted))
	{
		$chall->onChallengeSolved();
	}
	else
	{
		echo GWF_HTML::error('Friday', $chall->lang('err_friday'));
	}
}

echo GWF_Website::getDefaultOutput();

echo $form->form()->templateY('Black Friday');

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');

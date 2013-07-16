<?php
if (!defined('GWF_CORE_VERSION'))
{
	die('You are not allowed to execute this script directly. Please include it using the LFI vuln in php0817/index.php.');
}
echo GWF_HTML::message('PHP 0817', $chall->lang('msg_solved'));
$chall->onChallengeSolved(GWF_Session::getUserID());

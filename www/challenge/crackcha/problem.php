<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Crackcha');
require_once 'challenge/gwf_include.php';
GWF_Website::init(getcwd());
$wechall = GWF_Module::loadModuleDB('WeChall', true);
require_once 'challenge/crackcha/crackcha.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 8, 'challenge/crackcha/index.php', false);
}
crackcha_next($chall);
//GWF_Session::commit();
?>
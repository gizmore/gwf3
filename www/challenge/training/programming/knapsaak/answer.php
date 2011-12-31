<?php
header('Content-Type: text/plain');
chdir('../../../../');
define('GWF_PAGE_TITLE', 'The Travelling Customer');
require_once 'challenge/gwf_include.php';
GWF_Website::init(getcwd());

require_once 'challenge/training/programming/knapsaak/salesman.php';
$wechall = GWF_Module::loadModuleDB('WeChall');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/training/programming/knapsaak/index.php');
}

echo salesman_on_submit_answer($chall);

//GWF_Session::commit();
?>
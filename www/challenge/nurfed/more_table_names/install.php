<?php
$secret = require('secret.php');
chdir("../../../");
require_once("challenge/html_head.php");
//html_head("Install Addslashes");
if (!GWF_User::isAdminS()) {
	echo GWF_HTML::err('ERR_NO_PERMISSION');
	return;
}

$title = "Table Names II";
$solution = $secret['flag'];
$score = 6;
$url = "challenge/nurfed/more_table_names/index.php";
$creators = "nurfed";
$tags = 'MySQL,Exploit';

# See secret.php for more install!!!!

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags);

require_once("challenge/html_foot.php");
?>

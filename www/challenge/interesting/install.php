<?php
$solutions = require('solution.php');
chdir('../../');
require_once('challenge/html_head.php');
define('GWF_PAGE_TITLE', 'Interesting');
$title = GWF_PAGE_TITLE;
html_head('Install: '.$title);
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin('Better be admin !');
}
$solution = implode('', array_keys($solutions));
$score = 2;
$url = 'challenge/interesting/index.php';
$creators = 'Gizmore';
$tags = 'Fun,Exploit';

if (false === ($bunny = GWF_User::getByName('Easterbunny')))
{
	die('Easterbunny not found!');
}
$bunny_id = $bunny->getID();


require_once GWF_CORE_PATH.'module/Profile/GWF_ProfilePOI.php';
$table = GDO::table('GWF_ProfilePOI');

foreach ($solutions as $word => $latlon)
{
	if (!$table->insertAssoc(array(
		'pp_id' => '0',
		'pp_uid' => $bunny_id,
		'pp_lat' => $latlon[0],
		'pp_lon' => $latlon[1],
		'pp_descr' => $word,
	)))
	{
		die('DB ERROR!!!!');
	}	
}

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true);

require_once('challenge/html_foot.php');

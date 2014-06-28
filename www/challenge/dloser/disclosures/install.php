<?php
$secret_user = require 'secrets.php';
chdir("../../../");
require_once("challenge/html_head.php");
$title = 'Disclosures';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}

### Create challenge table and stuff
require 'www/user.php';
require 'www/db.php';
$users = array(
	'aaaaaron' => array('Aaronson', 'Aaron A.', 'aaa@aol.com', 'Sonnenblume2014'),
	'administrator' => $secret_user,
	'dloser' => array('Winner', 'BigRichardDick', 'zerodays@wechall.net', 'pwnedgizagain'),
	'benja' => array('Barneby-Smith', 'Benjamin', 'benja@gmail.com', 'Wizard1234'),
	'casi' => array('Casi', 'Casi', 'casi@gmx.de', 'casiisaccasiisac'),
	'jannn' => array('L', 'Jan', 'janl@kunden.telekom.de', 'essenlol123'),
	'ulla' => array('Kalele', 'Ulla', 'eigthies_rule@gmx.de', 'Hannover!!'),
	'test' => array('test', 'test', 'test@test.net', '11111111'),
	'admin' => array('test', 'test', 'test@test.com', '11111111'),
	'desiree' => array('Reelity', 'Daisy', 'daisy96@facebook.com', '.SOLAME.'),
	'strider' => array('', '', 'strider@gmail.com', 'hahackah'),
	'wildgoat' => array('', '', 'wildgoat@msn.com', 'iliketrains'),
	'synergy' => array('', '', 'syn@wechall.net', 'syn.synack.ack'),
	'fastfloats' => array('', '', 'fflol@gmail.com', 'GMPDEV111'),
	'teeest' => array('', '', 'teeest@wechall.net', 'test'),
	'lostchall' => array('', '', 'admin@lostchalls.com', 'PassWordPass!"§'),
	'Weezer' => array('', '', 'wheeeezer@hushmail.com', 'Weeeeeeeee'),
	'olga' => array('Olga', 'Olga', 'kermit1974@msn.com', 'Pass123'),
	'Karamalz' => array('', '', 'kara2048@aol.de', 'KaRaMaLz'),
	'SinBad' => array('Bad', 'Sin', 'sin.bad.69@gmx.de', 'foobar1000'),
);
$i = 0;
$seconds = 2;
GDO::table('DLDC_User')->createTable(true);
foreach ($users as $username => $data)
{
	list($lastname, $firstname, $email, $password) = $data;
	$user = DLDC_User::instance($username, $password, $email, $firstname, $lastname);
	$minscore = $username === 'dloser' ? 90 : 0;
	$user->setVar('wechall_userid', --$i);
	$user->setVar('level', rand($minscore, 100));
	$user->setVar('regdate', time()-$seconds);
	$user->insert();
	$seconds += rand(2, 4);
}


### WC continues
GDO::setCurrentDB($db1);

$score = 5;
$url = "challenge/dloser/disclosures/index.php";
$creators = "gizmore,dloser";
$tags = 'Exploit';

WC_Challenge::installChallenge($title, DLDC_SOLUTION, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_S);

require_once("challenge/html_foot.php");

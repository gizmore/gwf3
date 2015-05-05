<?php
ob_start();
require('key1.key');
$key1 = ob_get_contents();
ob_end_clean();
ob_start();
require('key2.key');
$key2 = ob_get_contents();
ob_end_clean();
chdir("../../../");
require_once("challenge/html_head.php");
$title = '2013 New Years Special';
html_head("Install: $title");
if (!GWF_User::isAdminS())
{
	return htmlSendToLogin("Better be admin !");
}
$solution = false;
$score = 4;
$url = "challenge/quangntenemy/2013NYS/index.php";
$creators = "quangntenemy";
$tags = 'Special,Crypto';

WC_Challenge::installChallenge($title, $solution, $score, $url, $creators, $tags, true, WC_Challenge::CHALL_CASE_I);

if (!($user = GWF_User::getByName('Rudolph2013')))
{
	$user = new GWF_User(array(
		'user_id' => '0',
		'user_options' => GWF_User::BOT|GWF_User::MAIL_APPROVED|GWF_User::EMAIL_GPG,
		'user_name' => 'Rudolph2013',
		'user_password' => GWF_Password::hashPasswordS('quangster'),
		'user_regdate' => GWF_Time::getDate(),
		'user_email' => 'rudolph2013@gizmore.org',
	));
	$user->insert();
}
else
{
	$user->saveOption(GWF_User::EMAIL_GPG, true);
}
GWF_PublicKey::updateKey($user->getID(), $key1);


if (!($user = GWF_User::getByName('Silvester2013')))
{
	$user = new GWF_User(array(
			'user_id' => '0',
			'user_options' => GWF_User::BOT|GWF_User::MAIL_APPROVED|GWF_User::EMAIL_GPG,
			'user_name' => 'Silvester2013',
			'user_password' => GWF_Password::hashPasswordS('quangster'),
			'user_regdate' => GWF_Time::getDate(),
			'user_email' => 'silvester2013@gizmore.org',
	));
	$user->insert();
}
else
{
	$user->saveOption(GWF_User::EMAIL_GPG, true);
}
GWF_PublicKey::updateKey($user->getID(), $key2);


require_once("challenge/html_foot.php");

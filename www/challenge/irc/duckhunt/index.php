<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'IRC: Duckhunt');
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/irc/duckhunt/index.php', $solution);
}
$chall->showHeader();

function checkChallenge(WC_Challenge $chall)
{
	$user = GWF_User::getStaticOrGuest();
	$url = "https://irc.wechall.net/duck_hunt/level.php?username=" . $user->displayUsername();
	$response = GWF_HTTP::getFromURL($url);
	$json = json_decode($response, true);
	if ($json['level'] >= 5)
	{
		echo $chall->onChallengeSolved($user->getID());
	}
	else
	{
		printf("<div class=gwf_box><pre>API Result From %s:\n%s</pre></div>\n", htmlspecialchars($url), htmlspecialchars($response));
	}
}


if (count($_POST))
{
	checkChallenge($chall);
// 	$chall->onCheckSolution();
}


$hrefIRC = "https://en.wikipedia.org/wiki/Wikipedia:IRC";
$hrefDuckHunt = "ircs://irc.wechall.net:6697/#duckhunt";
echo GWF_Box::box($chall->lang('info', [$hrefIRC, $hrefDuckHunt]), $chall->lang('title'));

?>
<div>
  <form method="post">
    <div>
      <input type="submit" name="CheckAPI" value="CheckApi" />
    </div>
  </form>
</div>
<?php

echo $chall->copyrightFooter();

require_once('challenge/html_foot.php');

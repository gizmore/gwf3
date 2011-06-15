<?php
$player = $tVars['player']; $player instanceof SR_Player;
$party = $player->getParty();

echo sprintf('<p>Party <span>%s</span></p>', $party->displayAction());

$i = 1;
foreach ($party->getMembers() as $member)
{
	$name = $member->getName();
	echo sprintf('<img src="%stpl/lamb/slimg/char/%s.png" width="32" height="32" alt="%s" title="%s" onclick="return sl4ClickFriend(%s)" />', 
		GWF_WEB_ROOT, get_class($member), $name, $name, $i++);
}

if (false !== ($ep = $party->getEnemyParty()))
{
	echo '<p>Enemy Party</p>'.PHP_EOL;
	$i = 1;
	foreach ($ep->getMembers() as $member)
	{
		$name = $member->getName();
		echo sprintf('<img src="%stpl/lamb/slimg/char/%s.png" width="32" height="32" alt="%s" title="%s" onclick="return sl4ClickEnemy(%s)" />', 
			GWF_WEB_ROOT, get_class($member), $name, $name, $i++);
	}
}
?>
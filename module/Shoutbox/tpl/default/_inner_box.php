<?php
echo sprintf('<h1><a href="%s">%s</a></h1>', $tVars['href_history'], $tLang->lang('box_title')).PHP_EOL;

echo '<table id="gwf_shout_table">'.PHP_EOL;
foreach ($tVars['msgs'] as $msg)
{
	$msg instanceof GWF_Shoutbox;
	$user = $msg->getUser();
	$style = wcStyleForUser($user);
//	$style = 'background: #'.$color.'!important;';
	
	echo GWF_Table::rowStart(false, '', '', $style);
	echo sprintf('<td>%s</td>', $msg->displayUsername()).PHP_EOL;
	echo sprintf('<td>%s</td>', $msg->displayMessage()).PHP_EOL;
	echo GWF_Table::rowEnd();
}
echo '</table>'.PHP_EOL;

require_once '_shout.php';


function wcStyleForUser($user)
{
	static $swap = 1;
	$swap = 1 - $swap;

	if ($user === false || $user->getID() == 0) {
		$color = $swap ? 'eee' : 'fff';
		return "background: #$color!important; color #000";
	}
	
	$user instanceof GWF_User;

//	var_dump($user);
	
	$user->loadGroups();
	
	if ($user->isAdmin()) {
		$color = $swap ? 'FF8' : 'EE7';
		return "background-color: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('siteadmin')) {
		$color = $swap ? '8F8' : '6D6';
		return "background: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('moderator')) {
		$color = $swap ? 'F88' : 'F77';
		return "background: #$color!important; font-weight: bold;";
	}
	
	if ($user->isInGroupName('betatester')) {
		$color = $swap ? '77F' : '66F';
		return "background: #$color!important; font-weight: bold; color: #FFF;";
	}
	
	
	$color = $swap ? 'AAF' : 'CCF';
	return "background: #$color!important;";
}
?>
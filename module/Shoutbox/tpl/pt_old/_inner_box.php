<?php
echo sprintf('<h1><a href="%s">%s</a></h1>', $tVars['href_history'], $tLang->lang('box_title')).PHP_EOL;

echo '<table id="gwf_shout_table">'.PHP_EOL;
foreach ($tVars['msgs'] as $msg)
{
	$msg instanceof GWF_Shoutbox;
	$user = $msg->getUser();
	$color = wcShoutColorForUser($user);
	$style = 'background: #'.$color.';';
	
	echo GWF_Table::rowStart($style);
	echo sprintf('<td>%s</td>', $msg->displayUsername()).PHP_EOL;
	echo sprintf('<td>%s</td>', $msg->displayMessage()).PHP_EOL;
	echo GWF_Table::rowEnd();
}
echo '</table>'.PHP_EOL;

require_once '_shout.php';
?>


<?php
function wcShoutColorForUser($user)
{
	if ($user === false) {
		return '#fff';
	}

	$user->loadGroups();
	
	if ($user->isAdmin()) {
		return 'ff8';
	}
	
	if ($user->isInGroup('moderator')) {
		return 'f88';
	}
	
	return 'fcc';
}
?>
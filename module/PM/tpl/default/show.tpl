<!-- 
<?php # Vars?
//$pm = $tVars['pm'];
//$pm instanceof GWF_PM;
//$a = $tVars['actions'];
//$u = GWF_User::getStaticOrGuest();
//$s = $pm->getFromID() === $u->getID();
//
//
//$box = '';
//foreach ($tVars['unread'] as $unread)
//{
//	$box .= '<div>'.GWF_HTML::anchor($unread->getDisplayHREF(), $unread->getVar('pm_title')).'</div>'.PHP_EOL;
//}
//if ($box !== '') {
//	echo '<div class="fl">';
//	echo GWF_Box::box($box);
//	echo '</div>'.PHP_EOL;
//}
?>
 -->
<div class="gwf_pm oa">
	<div class="gwf_pm_head">
		<h3>{$title}</h3>
		<div class="gwf_pm_date gwf_date">{$pm->displayDate()}</div>
{*
		<div class="gwf_pm_sender">{$sender}</div>
		<div class="gwf_pm_sender">{$receiver}</div>
*}
		<div class="gwf_pm_sender">{$sendrec}</div>
	</div>
	<div class="gwf_pm_body">
		<div class="gwf_pm_msg" id="{$transid}">{$translated}</div>
		<div class="gwf_pm_sig">{$pm->displaySignature()}</div>
	</div>
	<div class="gwf_pm_foot">
		{$buttons}
	</div>
</div>
<div class="cl"></div>


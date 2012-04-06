<?php
$p = $tVars['poll']; $p instanceof GWF_VoteMulti;
$pid = $p->getVar('vm_id');
$o = $p->getChoices();
$total = $p->getVotecount();
$user = GWF_Session::getUser();
$has_voted = $p->hasVoted($user);
$may_vote = $p->mayVote($user);
$may_edit = $p->mayEdit($user);
$reveal = $p->canSeeOutcome($user);
$voterow = $user === false ? GWF_VoteMultiRow::getVoteRowGuest($pid, GWF_IP6::getIP(GWF_IP_QUICK)) : GWF_VoteMultiRow::getVoteRowUser($pid, $user->getID());
?>
<form method="post" action="<?php echo htmlspecialchars($tVars['form_action']); ?>">
<table>
<thead><tr><th colspan="4"><?php echo $p->display('vm_title'); ?></th></tr></thead>
<tr><td colspan="4"><span id="vm_<?php echo $pid; ?>"><?php echo $reveal ? $total : '????'; ?></span>&nbsp;<?php echo $tLang->lang('votes'); ?></td></tr>
<tr><td colspan="4"><input type="hidden" name="vmid" value="<?php echo $pid; ?>" /></td></tr>
<?php
$i = 1;
$lang_votes = '&nbsp;'.$tLang->lang('voted');
foreach($o as $i => $opt)
{
	if ($reveal) {
		$count = $p->displayVotecount($user, $i);
		$format = '%.02f';
	}
	else {
		$count = '???';
		$format = '%s';
	}
	
	if ($total == 0) {
		$percent2 = 0;
	}
	else {
		$percent2 = round($count/$total*100);
	}
	$percent = ($count === '?' || $count == 0)  ? 0 : round($count/$total*$tVars['pixels']);
	$color = GWF_Color::interpolatBound(0, $tVars['pixels'], $percent, 0xff0000, 0x00ff00);
	$onclick = "return gwfVoteMulti($pid);";
	$checked = ($voterow !== false && $voterow->hasVotedOption($i)) ? ' checked="checked"' : '';
	echo GWF_Table::rowStart();
	echo sprintf('<td><span id="vm_%s_%s">%s</span>%s</td>', $pid, $i, $count, $lang_votes);
	echo sprintf('<td>%s</td>', GWF_HTML::display($opt['vmo_text']));
	if (!$reveal) {
		$percent2 = '???.??';
	}
	echo sprintf('<td style="width: %dpx; white-space: nowrap;"><div style="width: %dpx; background: #%s; margin-top:1px;">'.$format.'%%</div></td>', $tVars['pixels'], $percent, $color, $percent2);
	if ($may_vote) {
		echo sprintf('<td><input type="checkbox"%s onclick="%s" name="opt[%d]" /></td>', $checked, $onclick, $i);
	} else {
		echo sprintf('<td></td>');
	}
	echo GWF_Table::rowEnd();
	$i++;
}
?>
<tr><td colspan="4">
	<?php if ($may_edit) { echo GWF_Button::generic($tLang->lang('btn_edit'), $tVars['href_edit']); } ?>
	<?php if ($may_vote) { ?>
		<input type="submit" name="vote" value="<?php echo $tLang->lang('btn_vote'); ?>" />
	<?php } ?>
</td></tr>
</table>
</form>

<?php
$chall = $tVars['chall'];
$chall instanceof WC_Challenge;

$chall->showHeader(true);

$dif = wcChallVotes($chall, 'dif');
$edu = wcChallVotes($chall, 'edu');
$fun = wcChallVotes($chall, 'fun');
function wcChallVotes(WC_Challenge $chall, $section)
{
	$db = gdo_db();
	
	# Init back;
	$back = array();
	for ($i = 0; $i <= 10; $i++) { $back[$i] = array(0, 0); }
	$back[11] = array(0, 0.0);
	
	$total = 0;
	$count = 0;
	$vsr = GWF_TABLE_PREFIX.'vote_score_row';
	$vsid = $chall->getVar('chall_vote_'.$section);

	$query = "SELECT vsr_score, COUNT(vsr_uid) FROM $vsr WHERE vsr_vsid=$vsid GROUP BY(vsr_score) ORDER BY vsr_score ASC";
//	var_dump($query);
	
	if (false === ($result = $db->queryRead($query))) {
		return $back;
	}
	
	while (false !== ($row = $db->fetchRow($result)))
	{
		$cnt = (int) $row[1];  # 15 people 
		$score = (int) $row[0]; # voted N

		$back[$score] = array($cnt, $score * $cnt);
		$total += $score * $cnt;
		$count += $cnt;
	}
	
	$db->free($result);

	if ($count === 0) {
		$count = 0.00000001;
	}
	for ($i = 0; $i <= 10; $i++) {
//		$back[$i] = array($back[$i][0], $back[$i][1] / $total * 100);
		$back[$i] = array($back[$i][0], round($back[$i][0] / $count * 100, 2));
	}
	
	if ($count > 0) {
		$back[11] = array($count, round($total / $count * 10, 2));
	}
	
//	var_dump($back);
	
	return $back;
}

?>
<div class="wc_chall_votes">
<table>
	<tr>
		<th></th>
		<th class="le"><?php echo $tLang->lang('th_dif')?></th>
		<th class="le"><?php echo $tLang->lang('th_edu')?></th>
		<th class="le"><?php echo $tLang->lang('th_fun')?></th>
	</tr>
<?php for($i=0; $i<=11; $i++) { ?>
	<?php echo GWF_Table::rowStart(); ?>
		<?php echo sprintf('<th>%s</th>', $i === 11 ? $tLang->lang('th_avg') : $i); ?>
		<?php echo sprintf('<td><div style="width: %s%%; background-color: #%s;">%s%% (%d votes)</div></td>', round($dif[$i][1]), WC_HTML::getColorForPercent($dif[$i][1]), $dif[$i][1], $dif[$i][0]); ?>
		<?php echo sprintf('<td><div style="width: %s%%; background-color: #%s;">%s%% (%d votes)</div></td>', round($edu[$i][1]), WC_HTML::getColorForPercent($edu[$i][1]), $edu[$i][1], $edu[$i][0]); ?>
		<?php echo sprintf('<td><div style="width: %s%%; background-color: #%s;">%s%% (%d votes)</div></td>', round($fun[$i][1]), WC_HTML::getColorForPercent($fun[$i][1]), $fun[$i][1], $fun[$i][0]); ?>
	<?php echo GWF_Table::rowEnd(); ?>
<?php } ?>
</table>
</div>

<?php if ($tVars['has_solved']) echo $tVars['form_vote']; ?>

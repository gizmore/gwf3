<?php
$headers = array(
	array($tLang->lang('th_chall_score'), 'chall_score'),
	array($tLang->lang('th_chall_title'), 'chall_title'),
	array($tLang->lang('th_chall_creator_name'), 'chall_creator_name'),
	array($tLang->lang('th_chall_solvecount'), 'chall_solvecount'),
	array($tLang->lang('th_chall_date'), 'chall_date'),
//	array($tLang->lang('th_chall_votecount'), 'chall_votecount'),
	array($tLang->lang('th_dif'), 'chall_dif'),
	array($tLang->lang('th_edu'), 'chall_edu'),
	array($tLang->lang('th_fun'), 'chall_fun'),
	array($tLang->lang('th_csolve_date'), 'csolve_date'),
	array($tLang->lang('th_forum')),
);
$is_admin = GWF_User::isStaffS();
if ($is_admin) {
	$headers[] = array($tLang->lang('th_csolve_time_taken'), 'csolve_time_taken');
}
echo '<table class="wc_chall_table" id="wc_profile_challenges">'.PHP_EOL;
$raw = '<tr><th colspan="'.count($headers).'">'.$tVars['table_title'].'</th></tr>';
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url'], '', '', 'pcby', 'pcdir', $raw);

$chall = new WC_Challenge(false);

foreach ($tVars['data'] as $row)
{
	$chall->setGDOData($row);
	$solved = $row['csolve_date'] !== '' && $row['csolve_date'] !== NULL;
	$href_votes = $chall->hrefVotes();
	
	echo GWF_Table::rowStart();
	
	echo '<td class="gwf_num">'.$row['chall_score'].'</td>'.PHP_EOL;
	echo '<td class="nowrap" colspan="2">'.$chall->displayLink($solved).'</td>'.PHP_EOL;
	echo '<td class="gwf_num"><a href="'.$chall->getSolverHREF().'">'.$row['chall_solvecount'].'</a></td>'.PHP_EOL;
	echo '<td class="gwf_date">'.$chall->displayAge().'</td>'.PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayDif()).'</td>'.PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayEdu()).'</td>'.PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayFun()).'</td>'.PHP_EOL;
	if ($solved) {
		echo '<td class="gwf_date">'.GWF_Time::displayDate($row['csolve_date']).'</td>'.PHP_EOL;
	} else {
		echo '<td></td>'.PHP_EOL;
	}
	echo '<td>'.$chall->displayBoardLinks(true, $solved).'</td>'.PHP_EOL;
	if ($is_admin) {
		if ($solved) {
			$seconds = $row['csolve_time_taken'];
			if ($seconds === '0') {
				echo '<td class="gwf_date">???</td>'.PHP_EOL;
			} else {
				echo '<td class="gwf_date">'.GWF_Time::humanDuration($seconds).'</td>'.PHP_EOL;
			}
		} else {
			echo '<td></td>'.PHP_EOL;
		}
	}
	
	echo GWF_Table::rowEnd();
//	var_dump($row);
}

echo '</table>'.PHP_EOL;
?>
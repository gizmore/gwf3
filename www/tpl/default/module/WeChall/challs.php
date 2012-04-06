<?php
GWF_Module::loadModuleDB('Forum', true);
GWF_ForumBoard::init(true);
$by = $tVars['by'];
$dir = $tVars['dir'];
$cloud = '';
if (is_array($tVars['tags']))
{
	$cloud .= '<div class="gwf_tags_outer">'.PHP_EOL;
	$cloud .= '<div class="gwf_tags">'.PHP_EOL;
	$cloud_tags = '';
	foreach ($tVars['tags'] as $tag => $count)
	{
		$href = GWF_WEB_ROOT.'challs/'.$tag.'/by/'.urlencode($by).'/'.urlencode($dir).'/page-1';
		$text = $tag.'('.$count.')';
		$cloud_tags .= ', '.GWF_HTML::anchor($href, $text);
	}
	$cloud .= substr($cloud_tags, 2);
	$cloud .= '</div>'.PHP_EOL;
	$cloud .= '</div>'.PHP_EOL;
}
echo $cloud.PHP_EOL;

$headers = array(
	array($tLang->lang('th_chall_score'), 'chall_score'),
	array($tLang->lang('th_chall_title'), 'chall_title'),
	array($tLang->lang('th_chall_creator_name'), 'chall_creator_name'),
	array($tLang->lang('th_chall_solvecount'), 'chall_solvecount'),
	array($tLang->lang('th_chall_date'), 'chall_date'),
	array($tLang->lang('th_chall_votecount'), 'chall_votecount'),
	array($tLang->lang('th_dif'), 'chall_dif'),
	array($tLang->lang('th_edu'), 'chall_edu'),
	array($tLang->lang('th_fun'), 'chall_fun'),
	array($tLang->lang('th_forum')),
);
echo '<table class="wc_chall_table">';
$raw = '<tr><th colspan="10">'.$tVars['table_title'].'</th></tr>';
echo GWF_Table::displayHeaders2($headers, $tVars['sort_url'], '', '', 'by', 'dir', $raw);
$is_admin = GWF_User::isAdminS();

$icon_vote = GWF_WEB_ROOT.'tpl/wc4/ico/vote.gif';
$icon_voted = GWF_WEB_ROOT.'tpl/wc4/ico/voted.gif';
$icon_novote = GWF_WEB_ROOT.'tpl/wc4/ico/show_votes.gif';

$solved_bits = $tVars['solved_bits'];
$alt = $tLang->lang('alt_challvotes');
$txt_edit = WC_HTML::lang('btn_edit_chall');
foreach ($tVars['challs'] as $chall)
{
	$chall instanceof WC_Challenge;
	
	$edit = $is_admin ? GWF_Button::edit($chall->getEditHREF(), $txt_edit) : '';
	$cid = $chall->getID();
	$solved = isset($solved_bits[$cid]);
	
	if ($solved) {
		$icon = $solved_bits[$cid]['csolve_options']&1 ? $icon_voted : $icon_vote;
	} else {
		$icon = $icon_novote;
	}
	
	$href_votes = $chall->hrefVotes();
	
	echo GWF_Table::rowStart();
	echo '<td class="gwf_num">'.$chall->getVar('chall_score').'</td>'.PHP_EOL;
	echo '<td class="nowrap" colspan="2">'.$edit.$chall->displayLink($solved).'</td>'.PHP_EOL;
	echo '<td class="gwf_num"><a href="'.$chall->getSolverHREF().'">'.$chall->getVar('chall_solvecount').'</a></td>'.PHP_EOL;
	echo '<td class="gwf_date">'.$chall->displayAge().'</td>'.PHP_EOL;
	echo sprintf('<td class="gwf_num"><a href="%s">%s<img src="%s" title="%s" alt="%s" /></a></td>', $href_votes, $chall->getVar('chall_votecount'), $icon, $alt, $alt).PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayDif()).'</td>'.PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayEdu()).'</td>'.PHP_EOL;
	echo '<td class="gwf_num">'.sprintf('<a href="%s">%s</a>', $href_votes, $chall->displayFun()).'</td>'.PHP_EOL;
	echo '<td>'.$chall->displayBoardLinks(true, $solved).'</td>'.PHP_EOL;
	echo GWF_Table::rowEnd();
}
echo '</table>';
?>

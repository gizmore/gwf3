<?php
GWF_Module::loadModuleDB('Forum', true);
GWF_ForumBoard::init(true);

$show_tags_and_filters = is_array($tVars['tags']);

$solved_bits = $tVars['solved_bits'];
$challs = array();
foreach ($tVars['challs'] as $chall)
{
	if (isset($solved_bits[$chall->getID()]))
	{
		if (!$tVars['sel_unsolved'])
		{
			$challs[] = $chall;
		}
	} else {
		if (!$tVars['sel_solved'])
		{
			$challs[] = $chall;
		}
	}
}

$by = $tVars['by'];
$dir = $tVars['dir'];
if ($show_tags_and_filters)
{
	$cloud = '';
	$cloud .= '<div class="gwf_tags_outer">'.PHP_EOL;
	$cloud .= '<div class="gwf_tags">'.PHP_EOL;
	$cloud_tags = '';
	foreach ($tVars['tags'] as $tag => $count)
	{
		$count = 0;
		foreach ($challs as $chall)
		{
			$chall instanceof WC_Challenge;
			if ($chall->hasTag($tag))
			{
				$count++;
			}
		}
		if ($count || $tag === $tVars['tag']) {
			$href = GWF_WEB_ROOT.$tVars['filter_prefix'].'challs/'.$tag.'/by/'.urlencode($by).'/'.urlencode($dir).'/page-1';
			$text = $tag.'('.$count.')';
			$cloud_tags .= ', '.GWF_HTML::anchor($href, $text);
		}
	}
	$href = GWF_WEB_ROOT.$tVars['filter_prefix'].'challs/by/'.urlencode($by).'/'.urlencode($dir).'/page-1';
	$text = 'All('.count($challs).')';
	$cloud .= GWF_HTML::anchor($href, $text).$cloud_tags;
	$cloud .= '</div>'.PHP_EOL;
	$cloud .= '</div>'.PHP_EOL;
	echo $cloud.PHP_EOL;
}

if ($show_tags_and_filters and GWF_Session::isLoggedIn())
{
	echo GWF_Button::wrapStart();
	echo GWF_Button::generic($tLang->lang('btn_all'), $tVars['href_all'], 'generic', '', $tVars['sel_all']);
	echo GWF_Button::generic($tLang->lang('th_regat_solved'), $tVars['href_solved'], 'generic', '', $tVars['sel_solved']);
	echo GWF_Button::generic($tLang->lang('btn_open'), $tVars['href_unsolved'], 'generic', '', $tVars['sel_unsolved']);
	echo GWF_Button::wrapEnd();
}

$headers = array(
	array($tLang->lang('th_chall_score'), 'chall_score', 'ASC'),
	array($tLang->lang('th_chall_title'), 'chall_title', 'ASC'),
	array($tLang->lang('th_chall_creator_name'), 'chall_creator_name', 'ASC'),
	array($tLang->lang('th_chall_solvecount'), 'chall_solvecount', 'DESC'),
	array($tLang->lang('th_chall_date'), 'chall_date', 'DESC'),
	array($tLang->lang('th_chall_votecount'), 'chall_votecount', 'DESC'),
	array($tLang->lang('th_dif'), 'chall_dif', 'DESC'),
	array($tLang->lang('th_edu'), 'chall_edu', 'DESC'),
	array($tLang->lang('th_fun'), 'chall_fun', 'DESC'),
	array($tLang->lang('th_forum')),
);
if (!$show_tags_and_filters)
{
  foreach ($headers as &$header)
  {
    array_splice($header,1);
  }
}
echo '<table class="wc_chall_table">';
$raw = '<tr><th colspan="10">'.$tVars['table_title'].'</th></tr>';
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url'], 'chall_date', 'DESC', 'by', 'dir', $raw);
$is_admin = GWF_User::isAdminS();

$icon_vote = GWF_WEB_ROOT.'tpl/wc4/ico/vote.gif';
$icon_voted = GWF_WEB_ROOT.'tpl/wc4/ico/voted.gif';
$icon_novote = GWF_WEB_ROOT.'tpl/wc4/ico/show_votes.gif';

$alt = $tLang->lang('alt_challvotes');
$txt_edit = WC_HTML::lang('btn_edit_chall');
foreach ($challs as $chall)
{
	$chall instanceof WC_Challenge;

	if ($tVars['tag'] !== '' and !$chall->hasTag($tVars['tag']))
	{
		continue;
	}
	
	$cid = $chall->getID();
	$solved = isset($solved_bits[$cid]);
	
	if ($solved)
	{
		$icon = $solved_bits[$cid]['csolve_options']&1 ? $icon_voted : $icon_vote;
	}
	else
	{
		$icon = $icon_novote;
	}
	
	$edit = $is_admin ? GWF_Button::edit($chall->getEditHREF(), $txt_edit) : '';
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

<?php
$module = $tVars['module'];
$permitted = $module->cfgShowPermitted();
$user = GWF_Session::getUser();
$staff = GWF_User::isStaffS();

#################
# Table Headers #
#################
$headers = array();
$headers['id'] = array($tLang->lang('th_link_id'), 'link_id');
$headers['text'] = array($tLang->lang('th_link_descr'), 'link_descr');
$headers['url'] = array($tLang->lang('th_link_href'));
$headers['favs'] = array($tLang->lang('th_favs'), 'link_favcount', 'DESC');
$headers['clicks'] = array($tLang->lang('th_link_clicks'), 'link_clicks', 'DESC');
$wv = $tVars['with_votes'];
$headers['vs_count'] = array($tLang->lang('th_vs_count'), 'vs_count', 'DESC');
$headers['vs_avg'] = array($tLang->lang('th_vs_avg'), 'vs_avg', 'DESC');
if ($wv) { 
	$headers['vote'] = array($tLang->lang('th_vote') );
}
if ($user !== false && $wv) {
	$headers['fav'] = array();
	$headers['unfav'] = array();
}
echo GWF_Table::start('wc_links_table');
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);

$votes = $tVars['with_votes'];
$t_edit = $tLang->lang('btn_edit');
$t_fav = $tLang->lang('btn_favorite');
$t_unfav = $tLang->lang('btn_un_favorite');

foreach ($tVars['links'] as $link)
{
	$link instanceof GWF_Links;
	$linkid = $link->getVar('link_id');
	$style = $link->isInModeration() ? 'background:#fbb;' : '';
	
//	if ($wv)
//	{
		$vote = $link->getVote();
		if (is_object($vote)) {
			$vsid = $vote->getVar('vs_id');
			$votecount = $vote->getVar('vs_count');
			$voteperc = $vote->getAvgPercent();
			$ida = ' id="gwf_vsba_'.$vsid.'"';
			$idc = ' id="gwf_vsbc_'.$vsid.'"';
		} else {
			$vsid = 0;
			$votecount = 0;
			$voteperc = 50;
			$ida = $idc = '';
		}
//	}
	
	echo GWF_Table::rowStart(true, '', '', $style);
	
	if ($permitted && ('' !== ($perm_text = $link->getPermissionText($module, $user))))
	{
		$mayEdit = $wv ? $link->mayEdit($user, $staff) : false;
		echo '<td class="gwf_num">'.($mayEdit?GWF_Button::edit($link->hrefEdit(), $t_edit):$linkid).'</td>';
// 		echo '<td class="gwf_num">'.$linkid.'</td>';
		echo '<td colspan="2" class="ri"><em>['.$perm_text.']</em></td>';
		echo '<td class="gwf_num">'.$link->getVar('link_favcount').'</td>';
		echo '<td class="gwf_num">'.$link->getVar('link_clicks').'</td>';
		echo sprintf('<td class="gwf_num"><span%s>%s</span></td>', $idc, $votecount);
		echo sprintf('<td class="gwf_num"><span%s>%.02f%%</span></td>', $ida, $voteperc);
		if ($wv)
		{
			echo '<td></td>';
		}
		if ( ($wv) && ($user !== false) )
		{
			echo '<td></td><td></td>';
		}
	}
	else
	{
		$updown = $link->isDown() ? 'down' : 'up';
		$mayEdit = $wv ? $link->mayEdit($user, $staff) : false;
		echo '<td class="gwf_num">'.($mayEdit?GWF_Button::edit($link->hrefEdit(), $t_edit):$linkid).'</td>';
		echo '<td colspan="2" class="ri">'.$link->displayText($updown).'</td>';
	//	echo '<td colspan="2">'.sprintf($link->isInModeration()?'<span style="color:#ff0000">%s</span>':'%s', $link->displayText()).'</td>';
		echo '<td class="gwf_num">'.$link->displayFavCount().'</td>';
		echo '<td class="gwf_num">'.$link->displayClickCount().'</td>';
		
		if ($wv)
		{
			echo sprintf('<td class="gwf_num"><span%s>%s</span></td>', $idc, $votecount);
			echo sprintf('<td class="gwf_num"><span%s>%.02f%%</span></td>', $ida, $voteperc);
			echo '<td class="nowrap gwf_votebuttons">'.$vote->displayButtons().'</td>';
		}
		else
		{
			echo sprintf('<td class="gwf_num"><span%s>%s</span></td>', $idc, $votecount);
			echo sprintf('<td class="gwf_num"><span%s>%.02f%%</span></td>', $ida, $voteperc);
//			echo '<td class="gwf_num">0</td>';
//			echo '<td class="gwf_num">50.00%</td>';
		}
		
		if ($user !== false && $wv)
		{
			echo sprintf('<td class="gwf_tablebutton">%s</td>', $link->displayFavButton($t_fav));
			echo sprintf('<td class="gwf_tablebutton">%s</td>', $link->displayUnFavButton($t_unfav));
		}
		else
		{
// 			echo '<td></td><td></td>';
		}
	}
		
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
?>

<?php
echo GWF_Box::box($tLang->lang('pi_langrank', array($tVars['langname'])), $tLang->lang('pit_langrank', array($tVars['langname'])));

WC_HTML::rankingPageButtons();

# Quickjump
$langs = WC_Site::getLanguages();
echo sprintf('<form method="post" action="%s">', htmlspecialchars($tVars['form_action'])).PHP_EOL;
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
$data = array();
foreach ($langs as $lang)
{
	$data[] = array($lang->getISO(), $lang->displayName());
}
echo '<span class="ib">'.GWF_Select::display('iso', $data, $tVars['iso'], "window.location=GWF_WEB_ROOT+'lang_ranking/'+this.value;").'</span>'.PHP_EOL;
echo sprintf('<input type="submit" name="cmd" value="%s" />', $tLang->lang('btn_quickjump')).PHP_EOL;
echo '</div></div>'.PHP_EOL;
echo '</form>'.PHP_EOL;

$headers = array(
	array($tLang->lang('th_rank')),
	array(), # country
	array($tLang->lang('th_user_name')),
	array($tLang->lang('th_score')),
	array($tLang->lang('th_progress')),
);

echo $tVars['page_menu'].PHP_EOL;

echo GWF_Table::start();
$hl_rank = $tVars['hlrank'];
$rank = $tVars['rank'];
echo GWF_Table::displayHeaders2($headers).PHP_EOL;
$solvetext = ' solved ';
$ontxt = ' on ';
foreach ($tVars['users'] as $user)
{
	$user instanceof GWF_User;
	$username = $user->displayUsername();
	$style = $rank === $hl_rank ? WC_HTML::styleSelected() : '';
	echo GWF_Table::rowStart(true, '', '', $style);
	echo sprintf('<td class="gwf_num">%s</td>', $rank);
	echo sprintf('<td>%s</td>', $user->displayCountryFlag());
	echo sprintf('<td><a href="%s" title="%s">%s</a></td>', $user->getProfileHREF(), $tLang->lang('a_title', array($user->getVar('user_level'), $username)), $user->displayUsername());
	echo sprintf('<td class="gwf_num">%s</td>', $user->getVar('sum'));
	
	echo '<td>';
	foreach ($tVars['sites'] as $site)
	{
		$site instanceof WC_Site;
//		echo $site->displayName();
		$sid = $site->getVar('site_id');
		$var = 'ss_'.$sid;
		if ($user->hasVar($var)) {
			$solved = $user->getVar($var);
			$percent = round($solved*100,2);
			$txt = $username.$solvetext.$percent.'%'.$ontxt.$site->display('site_name');
			echo $site->displayLogo(round(30*$solved+2), $txt, $solved>=1, 32, $username);
		}
		else {
			echo '<span class="stublogo"></span>';
		}
//		echo $site->displayLogoUN($username, $solved, 2, 32, true);
	}
	echo '</td>';
	
	echo GWF_Table::rowEnd();
	$rank++;
}
echo GWF_Table::end();
?>
<?php echo $tVars['page_menu'].PHP_EOL; ?>
<?php echo GWF_Box::box($tLang->lang('scorefaq_box', array(GWF_WEB_ROOT.'scoring_faq'))); ?>

<div id="wcrl_slide"></div>

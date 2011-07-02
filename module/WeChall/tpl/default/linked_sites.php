<?php
echo WC_HTML::accountButtons();

if ($tVars['can_link']) {
	echo $tVars['form_link'];
}

if (count($tVars['linked']) > 0)
{
	$headers = array(
		array(),
		array($tLang->lang('th_site_name'), 'site_name', 'ASC'),
		array($tLang->lang('th_regat_solved'), 'regat_challsolved', 'DESC'),
		array($tLang->lang('th_site_challcount'), 'site_challcount', 'DESC'),
		array($tLang->lang('th_auto_update')),
		array(),
		array($tLang->lang('th_site_score'), 'regat_score', 'DESC'),
		array($tLang->lang('th_regat_solved'), 'regat_solved', 'DESC'),
		array($tLang->lang('th_regat_lastdate'), 'regat_lastdate', 'DESC'),
		array($tLang->lang('th_regat_onsitename'), 'regat_onsitename', 'ASC'),
		array(),
		array(),
//		array(),
	);
	echo sprintf('<form method="post" action="%s">', $tVars['action']).PHP_EOL;
	echo sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('0')).PHP_EOL;
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
	$userid = GWF_Session::getUserID();
	$txtshow = $tLang->lang('btn_show');
	$txthide = $tLang->lang('btn_hide');
	$txtscored = $tLang->lang('btn_scored');
	$txtunscore = $tLang->lang('btn_unscored');
	$site = new WC_Site(array());
	$regat = new WC_RegAt(array());
	foreach ($tVars['linked'] as $data)
	{
		$site instanceof WC_Site;
		$site->setVars($data);
		$regat->setVars($data);
		$siteid = $site->getVar('site_id');
//		$regat = WC_RegAt::getRegatRow($userid, $siteid);
		$btn_update = sprintf('<input type="submit" name="update[%s]" value="%s" />', $siteid, $tLang->lang('btn_update'));
		echo GWF_Table::rowStart();
		echo GWF_Table::column($site->displayStatus());
		echo GWF_Table::column($site->displayIcon(1.0).'&nbsp;'.$site->displayLink());
		echo GWF_Table::column($regat->getVar('regat_challsolved'), 'gwf_num');
		echo GWF_Table::column($site->getVar('site_challcount'), 'gwf_num');
		echo GWF_Table::column($site->displayAutoUpdate());
		echo GWF_Table::column($btn_update);
		echo GWF_Table::column($regat->getVar('regat_score'), 'gwf_num');
		$perc = $regat->getPercent($site->getOnsiteScore());
		$color = WC_HTML::getColorForPercent($perc);
		echo GWF_Table::column(sprintf('<span style="color: #%s">%.02f%%</span>', $color, $perc), 'gwf_num');
		echo GWF_Table::column($regat->displayLastDate(), 'gwf_date');
		echo GWF_Table::column($regat->displayOnsiteName());
		if ($regat->isOnsitenameHidden()) {
			echo GWF_Table::column(sprintf('<input type="submit" name="showname[%s]" value="%s" />', $siteid, $txtshow));
		} else {
			echo GWF_Table::column(sprintf('<input type="submit" name="hidename[%s]" value="%s" />', $siteid, $txthide));
		}
		
//		if ($regat->isScored()) {
//			echo GWF_Table::column(sprintf('<input type="submit" name="scored[%s]" value="%s" />', $siteid, $txtscore));
//		} else {
//			echo GWF_Table::column(sprintf('<input type="submit" name="unscored[%s]" value="%s" />', $siteid, $txtunscore));
//		}
		
		echo sprintf('<td><input type="submit" name="unlink[%s]" value="%s" /></td>', $siteid, $tLang->lang('btn_unlink'));
		
		echo GWF_Table::rowEnd();
	}
	echo GWF_Table::end();
	echo '</form>'.PHP_EOL;
}

echo $tVars['form_update_all'];
?>

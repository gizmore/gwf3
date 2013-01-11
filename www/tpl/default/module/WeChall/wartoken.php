<?php
echo WC_HTML::accountButtons();

$epoch = $tVars['epoch']->displayProfileLink();

echo GWF_Box::box($tLang->lang('info_wartoken', array($epoch, '___RTB_LINK___')), $tLang->lang('title_wartoken'));

echo GWF_Box::box($tVars['token'], $tLang->lang('title_your_wartoken'));


$boxes_out = '';
if (count($tVars['warboxes']) > 0)
{
	$boxes_out .= GWF_Table::start();
	$boxes_out .= GWF_Table::displayHeaders1(array(array(''), array(''), array('C'), array('U'), array('D')));
	foreach ($tVars['warboxes'] as $site)
	{
		$site instanceof WC_Site;
		$boxes_out .= GWF_Table::rowStart();
		$boxes_out .= GWF_Table::column($site->displayLogo());
		$boxes_out .= GWF_Table::column($site->displayLink());
		$boxes_out .= GWF_Table::column($site->getChallcount(), 'gwf_num');
		$boxes_out .= GWF_Table::column($site->getUsercount(), 'gwf_num');
		$boxes_out .= GWF_Table::column($site->getAverage().'%', 'gwf_num');
		$boxes_out .= GWF_Table::rowEnd();
	}
	$boxes_out .= GWF_Table::end();
}
echo GWF_Box::box($boxes_out.$tLang->lang('info_warboxes', array($tVars['port'], $tVars['netcat_cmd'], GWF_WEB_ROOT.'linked_sites', GWF_WEB_ROOT.'index.php?mo=WeChall&me=JoinUs&section=warbox')), $tLang->lang('title_warboxes'));


echo GWF_Box::box($tLang->lang('info_warcredits', array($epoch)), $tLang->lang('title_warcredits'));
?>

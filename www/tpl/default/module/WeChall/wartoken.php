<?php
echo WC_HTML::accountButtons();

$epoch = $tVars['epoch'] === false ? '<i><b>epoch</b></i>' : $tVars['epoch']->displayProfileLink();

echo GWF_Box::box($tLang->lang('info_wartoken', array($epoch, '___RTB_LINK___')), $tLang->lang('title_wartoken'));

echo GWF_Box::box($tVars['token'], $tLang->lang('title_your_wartoken'));


$boxes_out = '';
if (count($tVars['warboxes']) > 0)
{
	$boxes_out .= GWF_Table::start();
	$old_id = '0';
	foreach ($tVars['warboxes'] as $box)
	{
		$box instanceof WC_Warbox;
		$site = $box->getSite();
		
		if ($old_id !== $site->getID())
		{
			$old_id = $site->getID();
			$headers = array(
				array($site->displayLogo(16)),
				array($site->displayLink()),
				array('IP'),
				array('Login'),
				array('Password'),
				array('Levels'),
				array('Status'),
				array('Flags'),
				array('Update'),
			);
			
			$boxes_out .= GWF_Table::displayHeaders1($headers);
		}
		
		$boxes_out .= GWF_Table::rowStart();
		$boxes_out .= GWF_Table::column($box->getID());
		$boxes_out .= GWF_Table::column($box->displayLink());
		$boxes_out .= GWF_Table::column($box->getVar('wb_ip'), 'gwf_num');
		$boxes_out .= GWF_Table::column($box->display('wb_user'));
		$boxes_out .= GWF_Table::column($box->display('wb_pass'));
		$boxes_out .= GWF_Table::column($box->displayLevels(), 'gwf_num');
		$boxes_out .= GWF_Table::column(WC_HTML::lang('wb_'.$box->getVar('wb_status')), 'gwf_num');
		$boxes_out .= GWF_Table::column(GWF_Button::forward($box->hrefFlags()));
		
		if ($box->hasWarFlags())
		{
			$boxes_out .= GWF_Table::column(GWF_Button::forward($box->hrefFlags()));
		}
		else
		{
			$boxes_out .= GWF_Table::column(WC_HTML::lang('info_see_below'));
		}
		
		$boxes_out .= GWF_Table::rowEnd();
	}
	$boxes_out .= GWF_Table::end();
}
echo GWF_Box::box($boxes_out.$tLang->lang('info_warboxes', array($tVars['otw_cmd'], $tVars['v1_cmd'], $tVars['v2_cmd'], GWF_WEB_ROOT.'linked_sites', GWF_WEB_ROOT.'index.php?mo=WeChall&amp;me=JoinUs&amp;section=warbox')), $tLang->lang('title_warboxes'));


echo GWF_Box::box($tLang->lang('info_warcredits', array($epoch)), $tLang->lang('title_warcredits'));
?>

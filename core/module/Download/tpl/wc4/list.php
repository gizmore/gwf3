<?php
$user = GWF_Session::getUser();

$df = GWF_HTML::lang('df8');

$headers = array();
$headers[] = array($tLang->lang('th_dl_id'), 'dl_id');
$headers[] = array($tLang->lang('th_dl_filename'), 'dl_filename');
$headers[] = array($tLang->lang('th_dl_descr'), 'dl_descrs');
$headers[] = array($tLang->lang('th_dl_date'), 'dl_date');
$headers[] = array($tLang->lang('th_dl_count'), 'dl_count');
$headers[] = array($tLang->lang('th_user_name'), 'user_name');
$headers[] = array($tLang->lang('th_vs_avg'), 'vs_avg');
$headers[] = array();

echo $tVars['page_menu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['downloads'] as $dl)
{
	$dl instanceof GWF_Download;
	$may_edit = $dl->mayEdit($user);
	$href = $dl->hrefDownload();
	$u = $dl->getUser();
	$v = $dl->getVotes();
	$onclick = sprintf("return confirm('%s')", $tLang->lang('prompt_download'));
	echo GWF_Table::rowStart();
	if ($may_edit)
	{
		$editbtn = GWF_Button::edit($dl->hrefEdit(), $tLang->lang('btn_edit'));
		printf('<td>%s%s</td>', $editbtn, $dl->getVar('dl_id'));
	}
	else
	{
		printf('<td>%s</td>', $dl->getVar('dl_id'));
	}
	printf('<td><a href="%s" onclick="%s">%s</a></td>', $href, $onclick, $dl->display('dl_filename'));
	printf('<td><a href="%s" onclick="%s" title="%s">%s</a></td>', $href, $onclick, $dl->display('dl_descr'), GWF_HTML::display(Common::stripMessage($dl->getVar('dl_descr'), 50)));
	printf('<td class="gwf_date">%s</td>', GWF_Time::displayDateFormat($dl->getVar('dl_date'), $df));
	printf('<td class="gwf_num ce"><a href="%s" onclick="%s">%s</a></td>', $href, $onclick, $dl->getVar('dl_count'));
	echo $dl->isUsernameHidden() ? '<td></td>' : sprintf('<td><a href="%s">%s</a></td>', GWF_WEB_ROOT.'profile/'.$u->urlencode('user_name'), $u->display('user_name'));
	echo sprintf('<td class="gwf_num"><a id="gwf_vsba_%d" href="%s" onclick="%s">%.02f%%</a></td>', $v->getID(), $href, $onclick, $v->getAvgPercent());
	echo sprintf('<td class="nowrap">%s</td>', $v->displayButtons());
	
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo $tVars['page_menu'];

if ($tVars['may_upload'])
{
	echo GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']);
}
?>

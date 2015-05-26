<?php
$headers = array(
	array($tLang->lang('th_date'), 'vm_date', 'DESC', 6),
	array($tLang->lang('th_title'), 'vm_title', 'ASC', 1),
	array($tLang->lang('th_votes'), 'vm_votes', 'DESC', 3),
	array($tLang->lang('th_top_answ'), null, null, 2),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['polls'] as $poll)
{
	$poll instanceof GWF_VoteMulti;
	$href = $poll->hrefShow();
	echo GWF_Table::rowStart();
	echo sprintf('<td class="gwf_date"><a href="%s">%s</a></td>', $href, GWF_Time::displayDate($poll->getVar('vm_date')));
	echo sprintf('<td><a href="%s">%s</a></td>', $href, $poll->display('vm_title'));
	echo sprintf('<td class="gwf_num"><a href="%s">%s</a></td>', $href, $poll->getVar('vm_votes'));
	echo sprintf('<td><a href="%s">%s</a></td>', $href, $poll->displayTopAnswers());
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

if ($tVars['may_add_poll'])
{
	echo GWF_Button::wrapStart();
	echo GWF_Button::add($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
	echo GWF_Button::wrapEnd();
}

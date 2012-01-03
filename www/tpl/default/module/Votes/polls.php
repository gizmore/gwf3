<?php
$headers = array(
	array($tLang->lang('th_date'), 'vm_date'),
	array($tLang->lang('th_title'), 'vm_title'),
	array($tLang->lang('th_votes'), 'vm_votes'),
	array($tLang->lang('th_top_answ')),
);
?>
<table>
<?php
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
?>
</table>

<?php if ($tVars['may_add_poll']) { echo GWF_Button::add($tLang->lang('btn_add_poll'), $tVars['href_add_poll']); } ?>

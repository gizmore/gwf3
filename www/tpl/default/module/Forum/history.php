
<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>

<?php
$headers = array(
	array($tLang->lang('th_title'), 'thread_title'),
	array($tLang->lang('th_firstposter'), 'thread_firstposter'),
	array($tLang->lang('th_postcount'), 'thread_postcount'),
	array($tLang->lang('th_lastposter'), 'thread_lastposter'),
	array($tLang->lang('th_lastdate'), 'thread_lastdate'),
	array($tLang->lang('th_thread_thanks'), 'thread_thanks'),
	array($tLang->lang('th_thread_votes_up'), 'thread_votes_up'),
	array($tLang->lang('th_thread_viewcount'), 'thread_viewcount'),
);

echo $tVars['pagemenu'];
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['threads'] as $t)
{
	$t instanceof GWF_ForumThread;
	echo GWF_Table::rowStart();
	echo GWF_Table::column(sprintf('<a href="%s">%s<br/>%s</a>', $t->getPageHREF(1), $t->displayBoardTitle(), $t->display('thread_title')));
	echo GWF_Table::column($t->getFirstPosterLink());
	echo GWF_Table::column($t->getPostCount(), 'gwf_num');
	echo GWF_Table::column($t->getLastPosterLink());
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $t->getLastPageHREF(), $t->displayLastDate()), 'gwf_date');
	echo GWF_Table::column($t->getVar('thread_thanks'), 'gwf_num');
	echo GWF_Table::column($t->getVar('thread_votes_up'), 'gwf_num');
	echo GWF_Table::column($t->getVar('thread_viewcount'), 'gwf_num');
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo $tVars['pagemenu'];
?>

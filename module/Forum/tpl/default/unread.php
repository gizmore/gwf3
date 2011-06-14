<!-- Nav Tree -->
<?php $b = $tVars['board']; $b instanceof GWF_ForumBoard; ?>
<?php if (!$b->isRoot()) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>

<h2><?php echo $tLang->lang('pi_unread'); ?></h2>
<h3><?php echo GWF_Button::generic($tLang->lang('btn_mark_read'), GWF_WEB_ROOT.'index.php?mo=Forum&me=MarkRead'); ?></h3>

<?php
echo $tVars['pagemenu'];

$headers = array(
	array($tLang->lang('th_title'), 'thread_title', 'ASC'),
	array($tLang->lang('th_firstposter'), 'thread_firstposter', 'ASC'),
	array($tLang->lang('th_postcount'), 'thread_postcount', 'ASC'),
	array($tLang->lang('th_lastposter'), 'thread_lastposter', 'ASC'),
	array($tLang->lang('th_lastdate'), 'thread_lastdate', 'ASC'),
	array($tLang->lang('th_thread_thanks'), 'thread_thanks', 'DESC'),
	array($tLang->lang('th_thread_votes_up'), 'thread_votes_up', 'DESC'),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['threads'] as $t)
{
	$t instanceof GWF_ForumThread;
	$b = $t->getBoard();
	echo GWF_Table::rowStart();
	$boardlink = GWF_HTML::anchor($b->getShowBoardHREF(), $b->getVar('board_title'));
	$threadlink = GWF_HTML::anchor($t->getPageHREF(1), $t->getVar('thread_title'));
	echo GWF_Table::column("{$boardlink}<br/>{$threadlink}");
	echo GWF_Table::column($t->getFirstPosterLink());
	echo GWF_Table::column($t->getPostCount(), 'gwf_num');
	echo GWF_Table::column($t->getLastPosterLink());
	echo GWF_Table::column(GWF_HTML::anchor($t->getLastPageHREF(), $t->displayLastDate()));
	echo GWF_Table::column($t->getVar('thread_thanks'), 'gwf_num');
	echo GWF_Table::column($t->getVar('thread_votes_up'), 'gwf_num');
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo $tVars['pagemenu'];
?>
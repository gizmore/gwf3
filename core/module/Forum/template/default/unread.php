<!-- Banner Ads -->
<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
<!-- Nav Tree -->
<?php $b = $tVars['board']; $b instanceof GWF_ForumBoard; ?>
<?php if (!$b->isRoot()) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>

<h2><?php echo $tLang->lang('pi_unread'); ?></h2>
<h3><?php echo GWF_Button::generic($tLang->lang('btn_mark_read'), GWF_WEB_ROOT.'index.php?mo=Forum&me=MarkRead'); ?></h3>

<?php echo $tVars['pagemenu']; ?>

<?php 
$headers = array(
	array($tLang->lang('th_title'), 'thread_title', 'ASC'),
	array($tLang->lang('th_firstposter'), 'thread_firstposter', 'ASC'),
	array($tLang->lang('th_postcount'), 'thread_postcount', 'ASC'),
	array($tLang->lang('th_lastposter'), 'thread_lastposter', 'ASC'),
	array($tLang->lang('th_lastdate'), 'thread_lastdate', 'ASC'),
	array($tLang->lang('th_thread_thanks'), 'thread_thanks', 'DESC'),
	array($tLang->lang('th_thread_votes_up'), 'thread_votes_up', 'DESC'),
);

$data = array();
foreach ($tVars['threads'] as $t)
{
	$t instanceof GWF_ForumThread;
	$data[] = array(
		GWF_HTML::anchor($t->getPageHREF(1), $t->getVar('thread_title')),
		$t->getFirstPosterLink(),
		$t->getPostCount(),
		$t->getLastPosterLink(),
		GWF_HTML::anchor($t->getLastPageHREF(), $t->displayLastDate()),
		$t->getVar('thread_thanks'),
		$t->getVar('thread_votes_up'),
	);
}

$headers = GWF_Table::getHeaders2($headers, $tVars['sort_url']);
echo GWF_Table::display2($headers, $data, $tVars['sort_url']);
?>
<?php $b = $tVars['board']; $b instanceof GWF_ForumBoard; ?>
<?php $user = GWF_Session::getUser(); ?>
<?php $is_mod = GWF_User::isInGroupS('moderator'); ?>

<!-- Title -->
<?php $options = $user !== false ? GWF_Button::options($tVars['href_options'], $tLang->lang('btn_options')) : ''; ?>
<?php $newthreads = $tVars['unread_threads'] > 0 ? (GWF_Button::bell($tVars['href_unread'], $tLang->lang('btn_unread')).'['.$tVars['unread_threads'].']') : ''; ?>
<?php $search = $tVars['module']->isSearchAllowed() ? GWF_Button::search($tVars['href_search'], $tLang->lang('btn_search')) : ''; ?>
<?php $pollsbtn = GWF_Button::generic($tLang->lang('btn_polls'), $tVars['href_polls']); ?>

<h1><?php echo $options.$search.$newthreads.$tLang->lang('forum_title').$pollsbtn; ?></h1>


<!-- Nav Tree -->
<?php if (!$b->isRoot()) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>



<!-- Latest Threads -->
<?php
$lastposttxt = $tLang->lang('txt_lastpost');
if ($b->isRoot() && count($tVars['latest_threads']) > 0)
{
	echo GWF_Table::start();
?>
	<thead>
		<tr>
			<th colspan="9"><a href="<?php echo GWF_WEB_ROOT; ?>forum/history"><?php echo $tLang->lang('latest_threads'); ?></a></th>
		</tr>
		<tr>
			<th><?php echo $tLang->lang('th_title'); ?></th>
			<th></th>
			<th><?php echo $tLang->lang('th_firstposter'); ?></th>
			<th><?php echo $tLang->lang('th_postcount'); ?></th>
			<th><?php echo $tLang->lang('th_lastposter'); ?></th>
			<th><?php echo $tLang->lang('th_lastdate'); ?></th>
			<th><?php echo $tLang->lang('th_thanks'); ?></th>
			<th><?php echo $tLang->lang('th_votes_up'); ?></th>
			<th><?php echo $tLang->lang('th_thread_viewcount'); ?></th>
		</tr>
	</thead>
<?php
	foreach ($tVars['latest_threads'] as $t)
	{
		$t instanceof GWF_ForumThread;
		$edit = $t->hasEditPermission() ? GWF_Button::edit($t->getEditHREF(), $tLang->lang('btn_edit')) : '';
		$unread = $t->hasRead($user) ? '' : GWF_Button::bell($tVars['href_unread']);
		$hrefLastPage = $t->getLastPageHREF();
		$lastdate = $t->displayLastDate();
		$b2 = $t->getBoard();
		$anchor_board = GWF_HTML::anchor($b2->getShowBoardHREF(), $b2->getVar('board_title'));
		$anchor_thread = GWF_HTML::anchor($t->getPageHREF(1), $t->getVar('thread_title'));
		echo GWF_Table::rowStart();
		echo GWF_Table::column($anchor_board.'<br/>'.$anchor_thread);
//		 GWF_HTML::anchor($t->getPageHREF(1), $t->displayBoardTitle().'<br/>'.$t->display('thread_title'), '', '', false));
		echo GWF_Table::column($edit.$unread);
		echo GWF_Table::column($t->getFirstPosterLink());
		echo GWF_Table::column($t->getVar('thread_postcount'), 'gwf_num');
		echo GWF_Table::column($t->getLastPosterLink());
		$btn_next = GWF_Button::next($hrefLastPage, $lastposttxt);
		echo GWF_Table::column(GWF_HTML::anchor($hrefLastPage, $lastdate, '', '', false).$btn_next, 'gwf_date');
		echo GWF_Table::column(GWF_HTML::anchor($hrefLastPage, $t->getVar('thread_thanks')), 'gwf_num');
		echo GWF_Table::column(GWF_HTML::anchor($hrefLastPage, $t->getVar('thread_votes_up')), 'gwf_num');
		echo GWF_Table::column(GWF_HTML::anchor($hrefLastPage, $t->getVar('thread_viewcount')), 'gwf_num');
		echo GWF_Table::rowEnd();
	}
	echo GWF_table::end();
}
?>
<!-- End Of Latest Threads -->

<!-- Boards -->
<?php echo $tVars['pagemenu_boards']; ?>

<?php $childs = $tVars['boards']; ?>
<?php if (count($childs) > 0) { ?>
<?php
$board_headers = array(
	array($tLang->lang('th_board'), 'board_title'),
	array(), # 2 btns
	array(),
	array($tLang->lang('th_threadcount'), 'board_threadcount'), # 2 btns
	array($tLang->lang('th_postcount'), 'board_postcount'), # 2 btns
	
);
echo GWF_Table::start('fl ri');
$raw = '<tr><th class="ri" colspan="5">'.$b->display('board_descr').'</th></tr>';
echo GWF_Table::displayHeaders1($board_headers, $tVars['board_sort_url'], 'board_pos', 'ASC', 'bby', 'bdir');
foreach ($childs as $i => $c) { $c instanceof GWF_ForumBoard; echo GWF_Table::rowStart(); ?>
		<td>
			<div><a href="<?php echo $c->getShowBoardHREF(); ?>">
				<span class="gwf_board_title"><?php echo $c->display('board_title'); ?></span>
				<span class="gwf_board_descr"><?php echo $c->display('board_descr'); ?></span>
			</a></div>
		</td>
		<td>
			<?php if ($is_mod) { ?>
			<div class="nowrap"><?php echo GWF_Button::up($c->getMoveUpHREF()); ?></div>
			<div class="nowrap"><?php echo GWF_Button::down($c->getMoveDownHREF()); ?></div>
			<?php } ?>
		</td>
		<td>
			<?php if ($is_mod) { echo GWF_Button::edit($c->getEditBoardHREF(), $tLang->lang('btn_edit')); } ?>
		</td>
		<td class="gwf_num"><?php echo $c->getVar('board_threadcount'); ?></td>
		<td class="gwf_num"><?php echo $c->getVar('board_postcount'); ?></td>
<?php echo GWF_Table::rowEnd(); } ?>
<?php echo GWF_Table::end(); ?>
<?php } ?>

<?php # SHOUTBOX
if ($b->isRoot())
{
	if (false !== ($mod_shout = GWF_Module::loadModuleDB('Shoutbox'))) {
		echo GWF_HTML::div(Module_Shoutbox::templateBoxS(), 'gwf_forum_shoutbox fl');
	}
} ?>

<div class="cl"></div>

<?php echo $tVars['pagemenu_boards']; ?>

<!-- Threads -->
<?php if (count($tVars['threads']) > 0) { ?>
<?php
$t_headers = array(
	array($tLang->lang('th_title'), 'thread_title'),
	array(''),
	array($tLang->lang('th_firstposter'), 'thread_firstposter'),
	array($tLang->lang('th_postcount'), 'thread_postcount'),
	array($tLang->lang('th_lastposter'), 'thread_lastposter'),
	array($tLang->lang('th_lastdate'), 'thread_lastdate'),
	array($tLang->lang('th_thanks'), 'thread_thanks'),
	array($tLang->lang('th_votes_up'), 'thread_votes_up'),
	array($tLang->lang('th_thread_viewcount'), 'thread_viewcount'),
);
?>

<?php
echo $tVars['pagemenu_threads'];
echo GWF_Table::start('ri');
echo GWF_Table::displayHeaders1($t_headers, $tVars['thread_sort_url'], '', 'ASC', 'tby', 'tdir');

foreach ($tVars['threads'] as $t) { $t instanceof GWF_ForumThread;
	$edit = $t->hasEditPermission() ? GWF_Button::edit($t->getEditHREF(), $tLang->lang('btn_edit')) : '';
	$unread = $t->hasRead($user) ? '' : GWF_Button::bell($tVars['href_unread']);
	echo GWF_Table::rowStart();
	$href_lp = $t->getLastPageHREF();
?>
		<td><a href="<?php echo $t->getPageHREF(1); ?>"><?php echo $t->display('thread_title'); ?></a></td>
		<td><?php echo $edit.$unread; ?></td>
		<td><?php echo $t->getFirstPosterLink(); ?></td>
		<td class="gwf_num"><?php echo $t->getVar('thread_postcount'); ?></td>
		<td><?php echo $t->getLastPosterLink(); ?></td>
		<td><a href="<?php echo $href_lp; ?>"><?php echo $t->displayLastDate(); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_thanks'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_votes_up'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_viewcount'); ?></a></td>
<?php echo GWF_Table::rowEnd(); } ?>
<?php 
echo GWF_Table::end();
echo $tVars['pagemenu_threads'];
}
?>

<!-- Board Actions -->
<?php
echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.PHP_EOL;
if ($tVars['new_thread_allowed'])
{
	echo GWF_Button::generic($tLang->lang('btn_add_thread'), $b->getAddThreadHREF());
}
if (!$b->isRoot())
{
	if ($b->canSubscribe())
	{
		echo GWF_Button::generic($tLang->lang('btn_subscribe'), $b->getSubscribeHREF());
	}
	if ($b->canUnSubscribe())
	{
		echo GWF_Button::generic($tLang->lang('btn_unsubscribe'), $b->getUnSubscribeHREF());
	}
}
echo '</div></div>'.PHP_EOL;
?>

<!-- Admin Control -->
<?php if (GWF_User::isAdminS()) { ?>
	<div class="gwf_buttons_outer">
	<div class="gwf_buttons">
<?php
		echo GWF_Button::generic($tLang->lang('btn_edit_board'), $b->getEditBoardHREF());
		echo GWF_Button::generic($tLang->lang('btn_add_board'), $b->getAddBoardHREF());
?>
	</div>
	</div>
<?php } ?>

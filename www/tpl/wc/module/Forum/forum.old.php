<?php $b = $tVars['board']; $b instanceof GWF_ForumBoard; ?>
<?php $user = GWF_Session::getUser(); ?>
<?php $is_mod = GWF_User::isInGroupS('moderator'); ?>


<!-- Banner Ads -->
<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
<hr/>


<!-- Title -->
<?php $options = GWF_User::isLoggedIn() ? GWF_Button::options($tVars['href_options'], $tLang->lang('btn_options')) : ''; ?>
<?php $bell = GWF_Button::bell($tVars['href_unread'], $tLang->lang('btn_unread')); ?>
<?php $newthreads = $tVars['unread_threads'] > 0 ? sprintf('[%s]', $tVars['unread_threads']).$bell : ''; ?>
<?php $search = GWF_Button::search($tVars['href_search'], $tLang->lang('btn_search')); ?>
<?php $pollsbtn = GWF_Button::generic($tLang->lang('btn_polls'), $tVars['href_polls']); ?>

<h1><?php echo $options.$tLang->lang('forum_title').$search.$newthreads.$pollsbtn; ?></h1>

<hr/>


<!-- Nav Tree -->
<?php if (!$b->isRoot()) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>
<hr/>


<!-- Current Board -->
<h2>
	<span><?php echo $b->display('board_title'); ?></span>
	<span><?php echo $b->display('board_descr'); ?></span>
	<span><?php echo $newthreads; ?></span>
</h2>
<hr/>

<div class="fl">

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
$board_headers = GWF_Table::getHeaders2($board_headers, $tVars['board_sort_url'], 'bby', 'bdir');
?>
<table class="ri">
	<?php echo GWF_Table::displayHeaders($board_headers); ?>
<?php foreach ($childs as $i => $c) { echo GWF_Table::rowStart(); ?>
		<td>
			<div><a href="<?php echo $c->getShowBoardHREF(); ?>"><?php echo $c->display('board_title').'&nbsp;-&nbsp;'.$c->display('board_descr'); ?></a></div>
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
		<td class="gwf_num"><?php echo $c->getThreadCount(); ?></td>
		<td class="gwf_num"><?php echo $c->getPostCount(); ?></td>
<?php echo GWF_Table::rowEnd(); } ?>
</table>
<?php } ?>

<?php echo $tVars['pagemenu_boards']; ?>
</div>

<div class="cl"></div>

<hr/>


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
$t_headers = GWF_Table::getHeaders2($t_headers, $tVars['thread_sort_url'], 'tby', 'tdir');
?>

<?php echo $tVars['pagemenu_threads']; ?>
<table class="ri">
	<?php echo GWF_Table::displayHeaders($t_headers); ?>
<?php foreach ($tVars['threads'] as $t) { $t instanceof GWF_ForumThread;
	$edit = $t->hasEditPermission() ? GWF_Button::edit($t->getEditHREF(), $tLang->lang('btn_edit')) : '';
	$unread = $t->hasRead($user) ? '' : GWF_Button::bell($tVars['href_unread']);
	echo GWF_Table::rowStart();
	$href_lp = $t->getLastPageHREF();
?>
		<td><a href="<?php echo $t->getPageHREF(1); ?>"><?php echo $t->display('thread_title'); ?></a></td>
		<td><?php echo $edit.$unread; ?></td>
		<td><?php echo $t->getFirstPosterLink(); ?></td>
		<td class="gwf_num"><?php echo $t->getPostCount(); ?></td>
		<td><?php echo $t->getLastPosterLink(); ?></td>
		<td><a href="<?php echo $href_lp; ?>"><?php echo $t->displayLastDate(); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_thanks'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_votes_up'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $href_lp; ?>"><?php echo $t->getVar('thread_viewcount'); ?></a></td>
	</tr>
<?php echo GWF_Table::rowEnd(); } ?>
</table>
<?php } ?>
<hr/>


<!-- Board Actions -->
<?php if ($tVars['new_thread_allowed']) {
	echo GWF_Button::add($tLang->lang('btn_add_thread'), $b->getAddThreadHREF());
}
?>
<hr/>


<!-- Latest Threads -->
<?php
if ($b->isRoot() && count($tVars['latest_threads']) > 0)
{
?>
<table class="ri">
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
<?php
	foreach ($tVars['latest_threads'] as $t)
	{ $t instanceof GWF_ForumThread;
	$edit = $t->hasEditPermission() ? GWF_Button::edit($t->getEditHREF(), $tLang->lang('btn_edit')) : '';
	$unread = $t->hasRead($user) ? '' : GWF_Button::bell($tVars['href_unread']);
	$hrefLastPage = $t->getLastPageHREF();
	echo GWF_Table::rowStart();
?>
		<td><a href="<?php echo $t->getPageHREF(1); ?>"><?php echo $t->display('thread_title'); ?></a></td>
		<td><?php echo $edit.$unread; ?></td>
		<td><?php echo $t->getFirstPosterLink(); ?></td>
		<td class="gwf_num"><?php echo $t->getPostCount(); ?></td>
		<td><?php echo $t->getLastPosterLink(); ?></td>
		<td><a href="<?php echo $t->getLastPageHREF(); ?>"><?php echo $t->displayLastDate(); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $hrefLastPage; ?>"><?php echo $t->getVar('thread_thanks'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $hrefLastPage; ?>"><?php echo $t->getVar('thread_votes_up'); ?></a></td>
		<td class="gwf_num"><a href="<?php echo $hrefLastPage; ?>"><?php echo $t->getVar('thread_viewcount'); ?></a></td>
<?php 	
	echo GWF_Table::rowEnd();
	}
?>
</table>
<?php
}
?>
<hr/>


<!-- Admin Control -->
<?php if (GWF_User::isAdminS()) { ?>
	<div class="gwf_buttons_outer">
	<div class="gwf_buttons">
		<a href="<?php echo $b->getEditBoardHREF(); ?>"><?php echo $tLang->lang('btn_edit_board'); ?></a>
		<a href="<?php echo $b->getAddBoardHREF(); ?>"><?php echo $tLang->lang('btn_add_board'); ?></a>
	</div>
	</div>
<?php } ?>
<hr/>

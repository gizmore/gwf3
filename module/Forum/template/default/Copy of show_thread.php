<!-- Banner Ads -->
<?php if ($tVars['nav']) { ?>
	<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
<?php } ?>
	
<hr/>

<?php $t = $tVars['thread']; $t instanceof GWF_ForumThread; $actions = $tVars['actions']; $title = $tVars['title']; ?>
<?php $pc = $tLang->lang('posts');  ?>

<?php if ($tVars['nav']) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>


<?php # Highlighter
	if (GWF_Browser::isReferredBySearchEngine())
	{
		$tVars['term'] = GWF_Browser::getSearchEngineTerm();
	}
?>

<?php if ($title) { ?>
	<h1><?php echo $t->display('thread_title'); ?></h1>
<?php } ?>

<?php
if ($actions)
{
	if ($t->hasPoll()) {
		if ($tVars['page'] === 1) {
			echo $t->getPoll()->showResults();
		}
	}
	elseif ($t->mayAddPoll(GWF_Session::getUser())) {
		echo GWF_Button::generic($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
	}
}

echo $tVars['pagemenu'];

echo GWF_Table::start('gwf_forum_thread');

foreach ($tVars['posts'] as $post)
{
	$tVars['post'] = $post;
	include 'show_post.php';
}
?>
<tr>
<td colspan="3">
<?php if ($actions) { ?>
	<div class="gwf_buttons_outer">
	<div class="gwf_buttons">
	<?php if ($tVars['reply']) { ?>
		<a href="<?php echo $t->getReplyHREF(); ?>"><?php echo $tLang->lang('btn_reply'); ?></a>
	<?php } ?>
	<?php if ($t->canSubscribe()) { ?>
		<a href="<?php echo $t->getSubscribeHREF(); ?>"><?php echo $tLang->lang('btn_subscribe'); ?></a>
	<?php } ?>
	<?php if ($t->canUnSubscribe()) { ?>
		<a href="<?php echo $t->getUnSubscribeHREF(); ?>"><?php echo $tLang->lang('btn_unsubscribe'); ?></a>
	<?php } ?>
	</div>
	</div>
<?php } ?>
</td>
</tr>
<?php echo GWF_Table::end(); ?>
<p>
	<?php echo $tLang->lang('watchers', $t->getVar('thread_watchers')); ?><br/>
	<?php echo $tLang->lang('views', $t->getVar('thread_viewcount')); ?>
</p>
<?php echo $tVars['pagemenu']; ?>

<!-- Banner Ads -->
<?php if ($tVars['nav']) { ?>
	<?php echo GWF_Website::getBanners('forum', 'forum'); ?>
<?php } ?>

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

<div class="gwf_thread">

<?php
if ($title)
{
	# WC4
	$append = '';
	if (false !== ($site = GDO::table('WC_Site')->getBy('site_threadid', $t->getID()))) {
		$append = GWF_Button::forward($site->hrefDetail(), '', '', '');
	}
	elseif (false !== ($chall = GDO::table('WC_Challenge')->getBy('chall_board', $t->getVar('thread_bid')))) {
		$append = GWF_Button::forward($chall->getHREF(), '', '', '');
	}
	elseif (false !== ($chall = GDO::table('WC_Challenge')->getBy('chall_sboard', $t->getVar('thread_bid')))) {
		$append = GWF_Button::forward($chall->getHREF(), '', '', '');
	}
	# END OF WC4
	
	echo sprintf('<h1>%s%s</h1>', $t->display('thread_title'), $append).PHP_EOL;
}
?>

<?php
if ($actions)
{
	$buttons = '';
		
	if (false !== ($prev = $t->getPrevThread())) {
		$href = $prev->getPageHREF(1);
		$buttons .= GWF_Button::prev($href, $prev->getVar('thread_title'));
	}
	
	if ($tVars['page'] === 1) {
		if ($t->hasPoll()) {
			if (false !== ($mod_votes = GWF_Module::getModule('Votes'))) {
				$mod_votes->onInclude();
				$buttons .= $t->getPoll()->showResults();	
			}			
		}
	}
	elseif ($t->mayAddPoll(GWF_Session::getUser())) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
	}

	if (false !== ($next = $t->getNextThread())) {
		$href = $next->getPageHREF(1);
		$buttons .= GWF_Button::next($href, $next->getVar('thread_title'));
	}
		
	if ($buttons !== '')
	{
		echo '<div class="gwf_buttons_outer">'.PHP_EOL.
			'<div class="gwf_buttons">'.PHP_EOL.
			$buttons.
			'</div></div>';
	}
}

echo $tVars['pagemenu'];

require_once 'core/module/WeChall/WC_RegAt.php';

echo '<div class="gwf_posts">'.PHP_EOL;
$tVars['thread'] = $t;
foreach ($tVars['posts'] as $post)
{
	$tVars['post'] = $post;
	include 'show_post.php';
}
echo '</div>'.PHP_EOL;


if ($actions)
{
	$buttons = '';
	
	if ($tVars['reply']) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_reply'), $t->getReplyHREF());
	}
	if ($t->canSubscribe()) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_subscribe'), $t->getSubscribeHREF());
	}
	if ($t->hasEditPermission(GWF_Session::getUser())) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_edit'), $tVars['href_edit']);
	}
	if ($buttons !== '') {
		echo sprintf('<div class="gwf_buttons_outer"><div class="gwf_buttons">%s</div></div>', $buttons);
	}
}
?>

<?php echo $tVars['pagemenu']; ?>

</div>



<?php if ($tVars['nav'] === true) { ?>
<div class="box box_c">
<?php
	$subs = GWF_ForumSubscription::getSubscriptions($t, false);
//	var_dump($subs);
	$back = '';
	if (count($subs) > 0) {
		foreach ($subs as $sub) {
			$back .= ', '.$sub->displayProfileLink();
		}
		echo $tLang->lang('subscribers', substr($back, 2)).'<br/>'.PHP_EOL;
	}
	echo $tLang->lang('watchers', $t->getVar('thread_watchers')).PHP_EOL;
	echo '<br/>'.PHP_EOL;
	echo $tLang->lang('views', $t->getVar('thread_viewcount')).PHP_EOL;
?>
</div>
<?php } ?>


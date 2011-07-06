<?php $t = $tVars['thread']; $t instanceof GWF_ForumThread; $actions = $tVars['actions']; $title = $tVars['title']; ?>
<?php $pc = $tLang->lang('posts');  ?>

<?php if ($tVars['nav']) { ?>
	<div class="gwf_board_quicktree"><?php echo Module_Forum::getNavTree(); ?></div>
<?php } ?>


<?php # Highlighter
//	if (GWF_Browser::isReferredBySearchEngine())
//	{
//		$tVars['term'] = GWF_Browser::getSearchEngineTerm();
//	}
?>

<div class="gwf_thread">

<?php if ($title) { ?>
	<h1><?php echo $t->display('thread_title'); ?></h1>
<?php } ?>

<?php
if ($actions)
{
	$buttons = '';
		
	if (false !== ($prev = $t->getPrevThread())) {
		$href = $prev->getPageHREF(1);
		$buttons .= GWF_Button::prev($href, $prev->getVar('thread_title'));
	}
	
//	if ($tVars['page'] === 1) {
		if ($t->hasPoll()) {
			if (false !== ($mod_votes = GWF_Module::loadModuleDB('Votes'))) {
				$mod_votes->onInclude();
				$buttons .= $t->getPoll()->showResults();	
			}			
		}
//	}
	
//	else
	if ($t->mayAddPoll(GWF_Session::getUser())) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_add_poll'), $tVars['href_add_poll']);
	}

	if (false !== ($next = $t->getNextThread())) {
		$href = $next->getPageHREF(1);
		$buttons .= GWF_Button::next($href, $next->getVar('thread_title'));
	}
		
	if ($buttons !== '')
	{
		echo GWF_Button::wrap($buttons);
	}
}

echo $tVars['pagemenu'];

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
	if ($t->canUnSubscribe()) {
		$buttons .= GWF_Button::generic($tLang->lang('btn_unsubscribe'), $t->getUnSubscribeHREF());
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

<?php if ($tVars['nav'] === true) { ?>
<div class="box box_c">
<?php
if ($tVars['actions'])
{
	$subs = GWF_ForumSubscription::getSubscriptions($t, false);
//	var_dump($subs);
	$back = '';
	if (count($subs) > 0) {
		foreach ($subs as $sub) {
			$back .= ', '.$sub->displayProfileLink();
		}
		echo $tLang->lang('subscribers', array(substr($back, 2))).'<br/>'.PHP_EOL;
	}
	echo $tLang->lang('watchers', array($t->getVar('thread_watchers'))).PHP_EOL;
	echo '<br/>'.PHP_EOL;
	echo $tLang->lang('views', array($t->getVar('thread_viewcount'))).PHP_EOL;
}
?>
</div>
<?php } ?>
</div>

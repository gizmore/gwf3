<?php
	$post = $tVars['post'];
	$thread = $tVars['thread'];
	$actions = $tVars['actions'];
	$can_edit = $post->hasEditPermission();
	$post instanceof GWF_ForumPost;
	$user = $post->getUser();
//	var_dump($user);
	$opts = $post->getUserOptions(true);
	$pid = (string)$post->getID();
	
	$trd = isset($trd) ? 1-$trd : 1;
	$term = '';
	
	if (!is_array($tVars['term'])) {
		$tVars['term'] = $tVars['term'] === '' ? array() : explode('+', $tVars['term']);
	}

	$class = 'gwf_' . $user->isAdmin() ? 'admin' : ($user->isStaff() ? 'staff' : ($user->isGuest() ? 'guest' : ($user->isBot() ? 'bot' : ($user->isWebspider() ? 'webspider' : 'user'))));
	
#echo GWF_Table::rowStartB();
?>
<div class="gwf_post">
	<a name="post<?php echo $post->getID(); ?>"></a>

	<div class="gwf_post_uinfo gwf_<?php echo $trd?'odd':'even'; ?>">
		<?php echo GWF_HTML::div('<span>'.$user->displayCountryFlag().$user->displayProfileLink().'</span>'); ?>
		<?php echo GWF_HTML::div($user->displayTitle(), $class); /* do not htmlspecialchar */ ?>
		<?php echo GWF_HTML::div($tLang->lang('th_postcount').':&nbsp;'. $opts->getPostcount()); ?>
		<?php #echo GWF_HTML::div($tLang->lang('th_user_regdate').':&nbsp;'. $user->displayRegdate()); ?>
		<?php echo GWF_HTML::div($tLang->lang('th_user_regdate').':&nbsp;'. GWF_Time::displayAge($user->getVar('user_regdate'))); ?>
		<?php echo GWF_HTML::div($user->displayAvatar()); ?>
		<?php echo GWF_HTML::div($user->isOptionEnabled(GWF_User::HIDE_ONLINE) ? '' : sprintf('<div>%s</div>', $tLang->lang('last_seen', array(GWF_Time::displayAgeTS($user->getVar('user_lastactivity')))))); ?>
		<?php echo GWF_HTML::div($user->isOnline() ? $tLang->lang('online') : $tLang->lang('offline')); ?>
<?php
		$buttons = '';
		if ('' !== ($email = $user->getValidMail())) {
			$txt = $tLang->lang('at_mailto', array($user->displayUsername()));
			if ($user->isOptionEnabled(GWF_User::SHOW_EMAIL)) {
				$buttons .= GWF_Button::mail('mailto:'.$email, $txt);
			}
			elseif ($user->isOptionEnabled(GWF_User::ALLOW_EMAIL)) {
				$buttons .= GWF_Button::mail(GWF_WEB_ROOT.'send/email/to/'.$user->urlencode('user_name'));
			}
		}
		if (GWF_Session::isLoggedIn()) {
			$buttons .= GWF_Button::generic($tLang->lang('btn_pm'), $user->getPMHref());
		}
		if ($buttons !== '') {
			echo sprintf('<div class="gwf_buttons_outer"><div class="gwf_buttons">%s</div></div>', $buttons);
		}
?>
	</div>
<?php 
//echo GWF_Table::rowEnd();
//echo GWF_Table::rowStartB(false);

$toolbar = '';
if ($actions) {
	$toolbar .= GWF_Button::translate($post->getTranslateHREF(), $tLang->lang('btn_translate'), '', $post->getTranslateOnClick());
//	if (GWF_Session::isLoggedIn())
//	{
		$toolbar .= sprintf('<span id="gwf_post_thx_%s">%s</span>', $pid, $post->getVar('post_thanks')).GWF_Button::thankYou($post->getThanksHREF(), $tLang->lang('btn_thanks'), '', $post->getThanksOnClick());
		$toolbar .= sprintf('<span id="gwf_post_up_%s">%s</span>', $pid, $post->getVar('post_votes_up')).GWF_Button::thumbsUp($post->getVoteUpHREF(), $tLang->lang('btn_vote_up'), '', $post->getVoteUpOnClick());
		$toolbar .= sprintf('<span id="gwf_post_down_%s">%s</span>', $pid, $post->getVar('post_votes_down')).GWF_Button::thumbsDown($post->getVoteDownHREF(), $tLang->lang('btn_vote_down'), '', $post->getVoteDownOnClick());
//	}
}
?>
	<div class="gwf_post_body gwf_<?php echo $trd?'odd':'even'; ?>">
		<div class="gwf_post_head">
			<div>
				<span class="ib">
					<span class="gwf_post_title"><?php echo $post->displayTitle(); ?></span>
					<br/>
					<span class="gwf_date gwf_post_date"><?php echo $post->displayPostDate().' ('.GWF_Time::displayAge($post->getVar('post_date')).')'; ?></span>
				</span>
				<?php if ($toolbar !== '') { ?>
				<span class="gwf_post_toolbar">
					<span class="gwf_post_apps gwf_buttons"><?php echo $toolbar; ?></span>
					<span class="gwf_post_perma"><?php echo GWF_HTML::anchor($post->getShowHREFThread($term, $thread), $tLang->lang('permalink'))?></span>
				</span>
				<?php } ?>
				<div class="cb"></div>
			</div>
		</div>
		
		<?php
		$attach = '';
		if ($post->hasAttachments())
		{
			$attach .= '<div class="gwf_attachments">'.PHP_EOL;
			$attachments = $post->getAttachments();
			foreach ($attachments as $a)
			{
				$a instanceof GWF_ForumAttachment;
				if (!$a->canSee(GWF_Session::getUser())) {
					$attach .= '<p>'.$tLang->lang('info_hidden_attach_guest');
					continue;
				}
				$edit = GWF_Button::edit($a->hrefEdit(), $tLang->lang('btn_edit_attach'));
				$att_name = $a->display('fatt_filename');
				if ($a->isImage()) {
					$attach .= sprintf('<div><img src="%s" title="%s" alt="%s" /></div>', $a->hrefDownload(), $att_name, $att_name);
					if ($can_edit) {
						$attach .= sprintf('<div>%s</div>', $edit);
					}
				}
				else {
					$attach .= '<div class="gwf_attachment">'.PHP_EOL;
					$attach .= sprintf('<div>%s: <a href="%s">%s</a></div>', $tLang->lang('th_file_name'), $a->hrefDownload(), $att_name);
					$attach .= sprintf('<div>%s: %s</div>', $tLang->lang('th_file_size'), GWF_Upload::humanFilesize($a->getVar('fatt_size')));
					$attach .= sprintf('<div>%s: %s</div>', $tLang->lang('th_downloads'), $a->getVar('fatt_downloads'));
					if ($can_edit) {
						$attach .= sprintf('<div>%s</div>', $edit);
					}
					$attach .= '</div>'.PHP_EOL;
				}
			}
			$attach .= '</div>'.PHP_EOL;
		}
		?>

		<div class="gwf_post_msg">
			<?php
				echo '<div id="gwf_forum_post_'.$post->getVar('post_pid').'">'.$post->displayMessage($tVars['term']).'</div>';
				echo $attach;
				$sig = $opts->hasSignature() ? GWF_HTML::div($opts->displaySignature(), 'gwf_forum_sig') : '';
				echo $sig;
			?>
		</div>

		<?php $edit_by = GWF_HTML::div($post->displayEditBy($tVars['module']), 'gwf_post_edited'); ?>
		<?php
		$action_div = ''; 
		if ($actions) {
			$buttons = '';
			if ($tVars['reply']) {
				$buttons .= GWF_Button::reply($post->getReplyHREF(), $tLang->lang('btn_reply'));
				$buttons .= GWF_Button::quote($post->getQuoteHREF(), $tLang->lang('btn_quote'));
			}
			if ($can_edit) {
				$buttons .= GWF_Button::edit($post->getEditHREF(), $tLang->lang('btn_edit'));
				$buttons .= GWF_Button::generic($tLang->lang('btn_add_attach'), $post->hrefAddAttach());
			}
			$action_div = GWF_HTML::div($buttons, 'gwf_buttons');
		} 
		
		echo GWF_HTML::div($edit_by.$action_div, 'gwf_post_foot');
		?>
<?php # echo GWF_Table::rowEnd(); ?>
	</div>
</div>

<div class="cl"></div>

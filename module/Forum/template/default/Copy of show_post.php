<?php
	$post = $tVars['post'];
	$actions = $tVars['actions'];
	$can_edit = $post->hasEditPermission();
	$post instanceof GWF_ForumPost;
	$user = $post->getUser();
	$opts = $post->getUserOptions(true);
	$pid = (string)$post->getID();
	
//	if (!is_array($tVars['term'])) {
//		$tVars['term'] = $tVars['term'] === '' ? array() : explode() array($tVars['term']);
//	}
	
echo GWF_Table::rowStartB();
?>
	<td rowspan="1" style="vertical-align: top;">
		<?php echo $user->displayCountryFlag().$user->displayProfileLink(); ?><br/>
		<?php echo $tLang->lang('th_postcount').':&nbsp;'. $opts->getPostcount(); ?><br/>
		<?php echo $tLang->lang('th_user_regdate').'<br/>'. $user->displayRegdate(); ?><br/>
		<?php echo $user->displayAvatar(); ?><br/>
		<?php echo $user->displayTitle(); ?><br/>
		<?php echo ($user->isOnlineHidden()) ? '' : sprintf('<div>%s</div>', $tLang->lang('last_seen', GWF_Time::displayAgeTS($user->getLastActivity()))); ?>
		<?php echo $user->isOnline() ? $tLang->lang('online') : $tLang->lang('offline'); ?><br/>
	</td>
<?php 
//echo GWF_Table::rowEnd();
//echo GWF_Table::rowStartB(false);

$toolbar = '';
if ($actions) {
	$toolbar .= GWF_Button::translate($post->getTranslateHREF(), $tLang->lang('btn_translate'), '', $post->getTranslateOnClick());
	$toolbar .= sprintf('<span id="gwf_post_thx_%s">%s</span>', $pid, $post->getVar('post_thanks')).GWF_Button::thankYou($post->getThanksHREF(), $tLang->lang('btn_thanks'), '', $post->getThanksOnClick());
	$toolbar .= sprintf('<span id="gwf_post_up_%s">%s</span>', $pid, $post->getVar('post_votes_up')).GWF_Button::thumbsUp($post->getVoteUpHREF(), $tLang->lang('btn_vote_up'), '', $post->getVoteUpOnClick());
	$toolbar .= sprintf('<span id="gwf_post_down_%s">%s</span>', $pid, $post->getVar('post_votes_down')).GWF_Button::thumbsDown($post->getVoteDownHREF(), $tLang->lang('btn_vote_down'), '', $post->getVoteDownOnClick());
}
?>
	<td style="vertical-align: top; height: 100%;">
		<div class="gwf_post_head">
			<div>
				<span class="ib">
					<span class="gwf_date gwf_post_date"><?php echo $post->displayPostDate(); ?></span>
					<br/>
					<span class="gwf_post_title"><?php echo $post->displayTitle(); ?></span>
				</span>
				<span class="fr ib">
				<?php if ($toolbar !== '') { ?>
					<span class="gwf_post_apps"><?php echo $toolbar; ?></span>
				<?php } ?>
					<span class="gwf_post_perma"><?php echo GWF_HTML::anchor($post->getShowHREF(), $tLang->lang('permalink'))?></span>
				</span>
			</div>
			<div>
				<?php echo GWF_HTML::div($post->displayEditBy($tVars['module'])); ?>
			</div>
		</div>
		<div id="gwf_forum_post_<?php echo $post->getID(); ?>" class="gwf_post_body">
			<?php echo $post->displayMessage($tVars['term']); ?>
		</div>
		<?php
		if ($post->hasAttachments())
		{
			echo '<div class="gwf_attachments">'.PHP_EOL;
			$attachments = $post->getAttachments();
			foreach ($attachments as $a)
			{
				$a instanceof GWF_ForumAttachment;
				$edit = GWF_Button::edit($a->hrefEdit(), $tLang->lang('btn_edit_attach'));
				$att_name = $a->display('fatt_filename');
				if ($a->isImage()) {
					echo sprintf('<div><img src="%s" title="%s" alt="%s" /></div>', $a->hrefDownload(), $att_name, $att_name);
					if ($can_edit) {
						echo sprintf('<div>%s</div>', $edit);
					}
				}
				else {
					echo '<div class="gwf_attachment">'.PHP_EOL;
					echo sprintf('<div>%s: <a href="%s">%s</a></div>', $tLang->lang('th_file_name'), $a->hrefDownload(), $att_name);
					echo sprintf('<div>%s: %s</div>', $tLang->lang('th_file_size'), GWF_Upload::humanFilesize($a->getVar('fatt_size')));
					echo sprintf('<div>%s: %s</div>', $tLang->lang('th_downloads'), $a->getVar('fatt_downloads'));
					if ($can_edit) {
						echo sprintf('<div>%s</div>', $edit);
					}
					echo '</div>'.PHP_EOL;
				}
			}
			echo '</div>'.PHP_EOL;
		}
		?>
		<?php if ($opts->hasSignature()) { ?>
		<div class="gwf_forum_sig">
			<?php echo $opts->displaySignature(); ?>
		</div>
		<?php } ?>
	</td>
<?php 
echo GWF_Table::rowEnd();

echo GWF_Table::rowStartB(false);
?>
	<td>
		<?php 
			$buttons = '';
			if ($user->hasValidMail() && $user->isEmailPublic()) {
				$buttons .= GWF_Button::mail('mailto:'.$user->getValidMail(), $tLang->lang('at_mailto', $user->displayUsername()));
			}
			if (GWF_Session::isLoggedIn()) {
				$buttons .= GWF_Button::generic($tLang->lang('btn_pm'), $user->getPMHref());
			}
			echo GWF_HTML::div($buttons, 'gwf_buttons');
		?>
	</td>
	<td style="display: table-cell; height: 32px; vertical-align: text-bottom;">
		<?php if ($actions) {
			$buttons = '';
			if ($tVars['reply']) {
				$buttons .= GWF_Button::reply($post->getReplyHREF(), $tLang->lang('btn_reply'));
				$buttons .= GWF_Button::quote($post->getQuoteHREF(), $tLang->lang('btn_quote'));
			}
			if ($can_edit) {
				$buttons .= GWF_Button::edit($post->getEditHREF(), $tLang->lang('btn_edit'));
				$buttons .= GWF_Button::generic($tLang->lang('btn_add_attach'), $post->hrefAddAttach());
			}
			echo GWF_HTML::div($buttons, 'gwf_buttons');
		} ?>
	</td>
<?php echo GWF_Table::rowEnd(); ?>

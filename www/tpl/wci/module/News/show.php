<?php
$is_staff = $tVars['may_add'];
?>
<?php $id = 1; ?>
<div class="gwf_newsbox">

<?php
if ($tVars['can_sign']) {
	echo GWF_Button::wrap(GWF_Button::generic($tLang->lang('btn_sign'), $tVars['href_sign_news']));
}

echo $tVars['page_menu'];

echo '<div class="cb"></div>'.PHP_EOL;

if ($tVars['page'] === 1) {
	$wc = Module_WeChall::instance();
	echo $wc->showBirthdayNews();
	echo $wc->showChallengeNews();
	echo $wc->showSiteMasterNews();
	echo $wc->showAccountLinkNews();
}

foreach ($tVars['news'] as $news)
{
?>
<div class="gwf_newsbox_item" id="newsid_<?php echo $news['news_id']; ?>">
	<div class="gwf_newsbox_title">
		<div class="fr">
			<div class="gwf_newsbox_date"><?php echo GWF_Time::displayDate($news['news_date']); ?></div>
			<div class="gwf_newsbox_author"><?php echo GWF_HTML::anchor(GWF_WEB_ROOT.'profile/'.$news['user_name'], $news['user_name']); ?></div>
		</div>
		<h3><?php echo htmlspecialchars($news['newst_title']); ?></h3>
		<div class="cb"></div>
	</div>

	<?php #if ($is_staff) { echo '<div class="gwf_newsbox_translate">'.$news->getTranslateSelect().'</div>'; } ?>
	<?php
	$more = '';
	if (false !== ($comments = GWF_Module::loadModuleDB('Comments', true, true)))
	{
		$comments instanceof Module_Comments;
		$gid = GWF_Group::getByName(GWF_Group::MODERATOR)->getID();
		if (false !== ($c = GWF_Comments::getOrCreateComments('_NEWS_ID_'.$news['news_id'], 0, $gid)));
		{
			$c instanceof GWF_Comments;
//			$more .= '<br/>'.$c->displayMore($tVars['href_comments_more']);
//			$more .= '<br/>'.$c->displayTopComments();
//			$more .= '<br/>'.$c->displayReplyForm($tVars['href_comments_reply']);
			$more .= '<br/>'.$c->displayMore(GWF_WEB_ROOT.'news-comments-'.$news['news_id'].'-'.Common::urlencodeSEO($news['newst_title']).'-page-1.html');
//			$more .= '<br/>'.$c->displayTopComments();
//			$more .= '<br/>'.$c->displayReplyForm();
		}
	} 
	?>

	<article class="gwf_newsbox_message"><?php echo GWF_Message::display($news['newst_message']).$more; ?></article>
	
	<?php
//	$tid = intval($t['newst_threadid']);
//	if ($tVars['with_forum'] && $tid > 0)
//	{
//		$button_show_forum = GWF_Button::generic($tLang->lang('btn_forum'), $news->hrefThread($tid));
//		$buttons = $button_show_forum;
//		echo GWF_HTML::div($buttons, 'gwf_buttons');
//	}
	?>
	
</div>
<?php } ?>	
<?php echo $tVars['page_menu']; ?>
</div>

<div class="cb"></div>

<?php # Categories
if (count($tVars['cats'])) { ?>
<div>
<?php foreach ($tVars['cats'] as $id => $cat) { # CATEGORIES ?>
	<div><?php echo $cat; ?></div>
<?php } ?>
</div>
<?php } ?>

<div class="cb"></div>
<?php
if ($is_staff)
{
	$buttons = '';
	$buttons .= GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']);
	$buttons .= GWF_Button::generic($tLang->lang('btn_admin_section'), $tVars['module']->getAdminSectionUrl());
	echo GWF_Button::wrap($buttons);
}
?>

<?php
$is_staff = $tVars['may_add'];
?>
<?php
if ($tVars['can_sign']) {
	echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.GWF_Button::generic($tLang->lang('btn_sign'), $tVars['href_sign_news']).'</div></div>';
}
?>

<?php $id = 1; ?>
<div class="gwf_newsbox">
<?php

echo $tVars['page_menu'];

if ($tVars['page'] === 1) {
	$wc = GWF_Module::getModule('WeChall');
	echo $wc->showBirthdayNews();
	echo $wc->showChallengeNews();
	echo $wc->showSiteMasterNews();
	echo $wc->showAccountLinkNews();
}

?>

<?php foreach ($tVars['news'] as $news) { /*$news instanceof GWF_News; $t = $news->getTranslation();*/ ?>
<div class="gwf_newsbox_item gwf_tr_<?php $id=1-$id; echo $id; ?>">
	<div><a name="newsid<?php echo $news['news_id']; ?>"></a></div>
	
	<div class="gwf_newsbox_title">
		<div class="fr">
			<div class="gwf_newsbox_date gwf_date"><?php echo GWF_Time::displayDate($news['news_date']); ?></div>
			<div class="gwf_newsbox_author"><?php echo GWF_HTML::display($news['user_name']); ?></div>
		</div>
		<h3><?php echo GWF_HTML::display($news['newst_title']); ?></h3>
		<div class="cb"></div>
	</div>

	<?php #if ($is_staff) { echo '<div class="gwf_newsbox_translate">'.$news->getTranslateSelect().'</div>'; } ?>

	<div class="gwf_newsbox_message"><?php echo GWF_Message::display($news['newst_message']); ?></div>
	
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
	echo GWF_HTML::div($buttons, 'gwf_buttons');
}
?>

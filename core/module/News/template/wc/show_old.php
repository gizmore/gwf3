<?php
$is_admin = GWF_User::isAdminS(); 
$wc = Module_WeChall::instance();

echo $tVars['page_menu'];

if ($tVars['page'] === 1) {
	echo $wc->showBirthdayNews();
	echo $wc->showChallengeNews();
	echo $wc->showSiteMasterNews();
	echo $wc->showAccountLinkNews();
}
?>

<div class="gwf_newsbox">
<?php foreach ($tVars['news'] as $newsid => $news) { $t = $news->getTranslation(); $news instanceof GWF_News; $newsid=$news->getID(); ?>
<div class="gwf_newsbox_item">
	<div class="gwf_newsbox_head">
		<span class="gwf_newsbox_title"><?php echo $news->displayTitle(); ?></span>
		<span class="gwf_newsbox_date"><?php echo $news->displayDate(); ?></span>
		<span class="gwf_newsbox_author"><?php echo $news->displayAuthor(); ?></span>
	</div>
	<div id="news_msg_<?php echo $newsid; ?>">
<?php if ($is_admin) { ?>
		<div class="gwf_newsbox_translate"><?php echo $news->getTranslateSelect(); ?></div>
<?php } ?>
		<div class="gwf_newsbox_message"><?php echo $news->displayMessage(); ?></div>
	</div>
</div>
<?php } ?>	
</div>

<?php echo $tVars['page_menu']; ?>

<?php if ($tVars['may_add']) { echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']).'</div></div>'; } ?>

<?php
if ($tVars['can_sign']) {
	echo '<div class="gwf_buttons_outer"><div class="gwf_buttons">'.GWF_Button::generic($tLang->lang('btn_sign'), $tVars['href_sign_news']).'</div></div>';
}
?>
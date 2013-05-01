<div class="gwf_newsbox">
<?php
$module = $tVars['module']; $module instanceof Module_News;
$is_staff = $tVars['may_add'];
$id = 1;

if ($tVars['can_sign'])
{
	echo GWF_Button::wrap(GWF_Button::generic($tLang->lang('btn_sign'), $tVars['href_sign_news']));
}

echo $tVars['page_menu'];

echo '<div class="cb"></div>'.PHP_EOL;

foreach ($tVars['news'] as $news)
if($news['newst_message'] !== NULL)
{
?>
<div class="gwf_newsbox_item" id="newsid_<?php echo $news['news_id']; ?>">
	<div class="gwf_newsbox_title">
		<div class="fr">
			<div class="gwf_newsbox_date gwf_date"><?php echo GWF_Time::displayDate($news['news_date']); ?></div>
			<div class="gwf_newsbox_author"><?php echo GWF_HTML::display($news['user_name']); ?></div>
		</div>
		<h3><?php echo GWF_HTML::display($news['newst_title']); ?></h3>
		<div class="cb"></div>
	</div>
	<?php #if ($is_staff) { echo '<div class="gwf_newsbox_translate">'.$news->getTranslateSelect().'</div>'; } ?>
	<?php
	$more = '';
	if ($module->cfgAllowComments())
	{
		if (false !== ($comments = GWF_Module::loadModuleDB('Comments', true, true, true)))
		{
			$comments instanceof Module_Comments;
			$gid = GWF_Group::getByName(GWF_Group::MODERATOR)->getID();
			if (false !== ($c = GWF_Comments::getOrCreateComments('_NEWS_ID_'.$news['news_id'], 0, $gid)));
			{
				$c instanceof GWF_Comments;
	//			$more .= '<br/>'.$c->displayMore($tVars['href_comments_more']);
	//			$more .= '<br/>'.$c->displayTopComments();
	//			$more .= '<br/>'.$c->displayReplyForm($tVars['href_comments_reply']);
				$more .= '<br/>'.$c->displayMore();
				$more .= '<br/>'.$c->displayTopComments();
				$more .= '<br/>'.$c->displayReplyForm();
			}
		}
	} 
	?>

	<article class="gwf_newsbox_message"><?php echo GWF_Message::display($news['newst_message']) . $more; ?></article>
	
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
<hr>
<?php
}
echo $tVars['page_menu']; ?>
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
	$buttons = GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']);
	$buttons .= GWF_Button::generic($tLang->lang('btn_admin_section'), $tVars['module']->getAdminSectionUrl());
	echo GWF_Button::wrap($buttons);
}
?>

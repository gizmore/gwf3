<?php
$is_staff = $tVars['may_add'];
?>
<?php $id = 1; ?>
<div class="gwf_newsbox">

<?php
if ($tVars['can_sign'])
{
	echo '<div class="gwf_buttons_outer fr">'.PHP_EOL;
	echo GWF_Button::wrap(GWF_Button::generic($tLang->lang('btn_sign'), $tVars['href_sign_news']));
	echo '</div>'.PHP_EOL;
	echo '<div class="cb"></div>'.PHP_EOL;
}

echo $tVars['page_menu'];

echo '<div class="gwf_news_titles oa">'.PHP_EOL;
$headers = array(
	array($tLang->lang('th_title')),
);
$data = array();
$iso = GWF_Language::getCurrentISO();
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['titles'] as $d)
{
	echo GWF_Table::rowStart();
	$newsid = $d[0];
	$title = $d[1];
	$catid = 0;
	$cat = 'FOO';
//	$catid = (int) $d[1];
//	$cat = $catid === 0 ? GWF_HTML::lang('no_category') : $d[2];
//	$cat = Common::urlencodeSEO($cat);
	$url = sprintf(GWF_WEB_ROOT.'news/%s/%d/%s/%s/%s#newsid%s', $iso, $catid, urlencode($cat), $newsid, Common::urlencodeSEO($title), $newsid);
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', htmlspecialchars($url), htmlspecialchars($title)));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo '</div>'.PHP_EOL;

echo '<div class="gwf_news_items fr oa">'.PHP_EOL;
foreach ($tVars['news'] as $news)
{
?>
<div class="gwf_newsbox_item">
	<div><a name="newsid_<?php echo $news['news_id']; ?>"></a></div>
	
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
	?>

	<div class="gwf_newsbox_message"><?php echo GWF_Message::display($news['newst_message']) . $more; ?></div>
	
	
	
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
<?php
}
echo '</div>'.PHP_EOL;
echo '<div class="cb"></div>'.PHP_EOL;
echo $tVars['page_menu'];
?>
</div>



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

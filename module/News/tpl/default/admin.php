<?php
echo $tVars['module']->templatePHP('_admin_nav.php', $tVars);

$headers = array(
	array($tLang->lang('th_date'), 'news_date', 'ASC'),
	array($tLang->lang('th_userid'), 'user_name', 'ASC'),
	array($tLang->lang('th_catid'), 'news_catid', 'ASC'),
	array($tLang->lang('th_langid')),
	array($tLang->lang('th_title')),
	array($tLang->lang('th_hidden'), 'news_options&'.GWF_News::HIDDEN, 'DESC'),
);

echo $tVars['page_menu'];

$icon_hidden = GWF_Button::sub($tLang->lang('th_hidden'));
$icon_visible = GWF_Button::add(true, $tLang->lang('th_visible'));
echo GWF_Table::start();
foreach ($tVars['news'] as $item)
{
	$item instanceof GWF_News;
	
	$newsid = $item->getID();
	$trans = $item->getTranslations();
	$author = $item->displayAuthor();
	$cat = $item->displayCategory();
	$date = $item->displayDate();
	
	foreach ($trans as $langid => $t)
	{
		echo GWF_Table::rowStart();
		echo GWF_Table::column($date, 'gwf_date');
		echo GWF_Table::column($author);
		echo GWF_Table::column($cat);
		echo GWF_Table::column(GWF_Language::getByID($langid)->display('lang_nativename'));
		$title = $t['newst_title'];
		$href = GWF_WEB_ROOT.sprintf('news/edit/%d-%s/langid-%d', $newsid, Common::urlencodeSEO($title), $langid);
		echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, htmlspecialchars($title)));
		echo GWF_Table::column($item->isHidden() ? $icon_hidden : $icon_visible);
		echo GWF_Table::rowEnd();
	}
}
echo GWF_Table::end();

echo $tVars['page_menu'];

$buttons = GWF_Button::add($tLang->lang('btn_add'), GWF_WEB_ROOT.'news/add');
echo GWF_Button::wrap($buttons);
?>

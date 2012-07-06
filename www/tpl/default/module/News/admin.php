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

$lang_visible = $tLang->lang('th_visible');
$lang_hidden = $tLang->lang('th_hidden');

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
		if ($item->isHidden())
		{
			$icon = GWF_Button::sub($lang_hidden, $item->hrefEnable());
		}
		else
		{
			$icon = GWF_Button::add($lang_visible, $item->hrefDisable());
		}
		
		echo GWF_Table::rowStart();
		echo GWF_Table::column($date, 'gwf_date');
		echo GWF_Table::column($author);
		echo GWF_Table::column($cat);
		echo GWF_Table::column(GWF_Language::getByID($langid)->display('lang_nativename'));
		$title = $t['newst_title'];
		$href = GWF_WEB_ROOT.sprintf('news/edit/%d-%s/langid-%d', $newsid, Common::urlencodeSEO($title), $langid);
		echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, htmlspecialchars($title)));
		echo GWF_Table::column($icon);
		echo GWF_Table::rowEnd();
	}
}
echo GWF_Table::end();

echo $tVars['page_menu'];

$buttons = GWF_Button::add($tLang->lang('btn_add'), GWF_WEB_ROOT.'news/add');
echo GWF_Button::wrap($buttons);
?>

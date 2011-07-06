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

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
$icon_hidden = GWF_Button::sub($tLang->lang('th_hidden'));
$icon_visible = GWF_Button::add(true, $tLang->lang('th_visible'));
foreach ($tVars['news'] as $item)
{
	
	$item instanceof GWF_News;
	
	$newsid = $item->getID();
	$trans = $item->getTranslations();
	$date = $item->displayDate();
	$author = $item->displayAuthor();
	$cat = $item->displayCategory();
	
	foreach ($trans as $langid => $t)
	{
		var_dump($langid, $t);
		echo GWF_Table::rowStart();
		$title = $t['newst_title'];
		$data[] = array(
			$date,
			$author,
			$cat,
			GWF_Language::getByID($langid)->display('lang_nativename'),
			sprintf('<a href="%snews/edit/%d-%s/langid-%d">%s</a>', GWF_WEB_ROOT, $newsid, Common::urlencodeSEO($title), $langid, $title),
			$item->isHidden() ? $icon_hidden : $icon_visible, 
		);
		echo GWF_Table::rowEnd();
	}
	
}
echo GWF_Table::end();

echo $tVars['page_menu'];

echo GWF_Button::wrap(GWF_Button::add($tLang->lang('btn_add'), GWF_WEB_ROOT.'news/add'));
?>

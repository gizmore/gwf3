<?php
echo $tVars['form'];

$cat = $tVars['cat']; $cat instanceof GWF_Category;

$trans = $cat->getTranslations();

$headers = array(
	array($tLang->lang('th_language')),
	array($tLang->lang('th_translation')),
);
echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($trans as $langid => $data)
{
	$text = $data['cl_translation'];
	echo GWF_Table::rowStart();
	echo GWF_Table::column(GWF_Language::getByID($langid)->display('lang_name'));
	echo GWF_Table::column(htmlspecialchars($text, ENT_QUOTES));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
?>

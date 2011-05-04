<?php
echo $tVars['form'];

$cat = $tVars['cat']; $cat instanceof GWF_Category;

$trans = $cat->getTranslations();

$headers = array(
	array('th_language'),
	array('th_translation'),
	
);
//$headers = GWF_Table::getHeaders2($headers);

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers);
foreach ($trans as $langid => $data)
{
	$text = $data['translation'];
	echo GWF_Table::rowStart();
	echo GWF_Table::column(GWF_Language::getByID($langid)->getName());
	echo GWF_Table::column(htmlspecialchars($text, ENT_QUOTES));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
?>

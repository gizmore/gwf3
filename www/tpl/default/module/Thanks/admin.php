<?php

echo $tVars['page_menu'];

$headers = array(
	array($tLang->lang('th_thx_pos'), 'thx_pos', 'ASC'),
	array($tLang->lang('th_thx_cat'), 'thx_cat', 'ASC'),
	array($tLang->lang('th_thx_businame'), 'thx_businame', 'ASC'),
	array($tLang->lang('th_thx_busicity'), 'thx_busicity', 'ASC'),
	array($tLang->lang('th_thx_position'), 'thx_position', 'ASC'),
	array($tLang->lang('th_thx_nametitle'), 'thx_nametitle', 'ASC'),
	array($tLang->lang('th_thx_firstname'), 'thx_firstname', 'ASC'),
	array($tLang->lang('th_thx_lastname'), 'thx_lastname', 'ASC'),
);

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['thanks'] as $thx)
{
	$thx instanceof GWF_Thanks;
	$href = $thx->getEditHREF();
	
	echo GWF_Table::rowStart();
	echo GWF_Table::column($thx->getPosition());
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->displayCat()));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->display('thx_businame')));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->display('thx_busicity')));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->displayPosition()));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->displayNametitle()));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->display('thx_firstname')));
	echo GWF_Table::column(sprintf('<a href="%s">%s</a>', $href, $thx->display('thx_lastname')));
	echo GWF_Table::rowEnd();
	
}
echo GWF_Table::end();

echo $tVars['page_menu'];

?>
<div><a href="<?php echo $tVars['href_add']; ?>"><?php echo $tLang->lang('btn_add'); ?></a></div>

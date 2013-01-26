<?php
echo GWF_Button::wrapStart();
echo GWF_Button::generic($tLang->lang('menu_sites'), $tVars['href_site']);
echo GWF_Button::generic($tLang->lang('btn_edit_site_descr'), $tVars['href_descr']);
echo GWF_Button::wrapEnd();

echo GWF_Table::start();
$headers = array(
	array('EDIT'),
	array('ID'),
	array('NAME'),
	array('HOST'),
	array('IP'),
	array('STATUS'),
);
echo GWF_Table::displayHeaders1($headers);
foreach ($tVars['boxes'] as $box)
{
	$box instanceof WC_Warbox;
	echo GWF_Table::rowStart();
	echo GWF_Table::column(GWF_Button::edit($box->hrefEdit()));
	echo GWF_Table::column($box->getID());
	echo GWF_Table::column($box->display('wb_name'));
	echo GWF_Table::column($box->displayLink());
	echo GWF_Table::column($box->getVar('wb_ip'));
	echo GWF_Table::column(WC_HTML::lang('wb_'.$box->getVar('wb_status')));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo GWF_Button::wrapStart();
echo GWF_Button::add('Add a new warbox', $tVars['href_add']);
echo GWF_Button::wrapEnd();
?>

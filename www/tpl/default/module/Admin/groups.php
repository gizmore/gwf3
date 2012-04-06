<?php
$headers = array(
	array($tLang->lang('th_group_id'), 'group_id', 'ASC'),
	array($tLang->lang('th_group_memberc'), 'group_memberc', 'ASC'),
	array($tLang->lang('th_group_name'), 'group_name', 'ASC'),
	array($tLang->lang('th_group_join'), 'group_options&255', 'ASC'),
	array($tLang->lang('th_group_view'), 'group_options&0xf00', 'ASC'),
	array($tLang->lang('th_group_founder'), 'group_founder', 'ASC'),
	array($tLang->lang('th_group_lang'), 'group_lang', 'ASC'),
	array($tLang->lang('th_group_country'), 'group_country', 'ASC'),
);

echo $tVars['pagemenu'];

echo GWF_Table::start();
echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
foreach ($tVars['groups'] as $g)
{
	echo GWF_Table::rowStart();
	
	$g instanceof GWF_Group;
	$gid = $g->getID();
	$href_edit = GWF_WEB_ROOT.'index.php?mo=Admin&me=GroupEdit&gid='.$gid;
	echo GWF_Table::column(GWF_HTML::anchor($href_edit, $gid));
	echo GWF_Table::column($g->getVar('group_memberc'));
	echo GWF_Table::column(GWF_HTML::anchor($href_edit, $g->getVar('group_name')));
	echo GWF_Table::column($g->displayJoinType($tVars['module']));
	echo GWF_Table::column($g->displayViewType($tVars['module']));
	echo GWF_Table::column($g->getFounder()->displayUsername());
	echo GWF_Table::column(GWF_Language::getByIDOrUnknown($g->getVar('group_lang'))->display('lang_nativename'));
	echo GWF_Table::column(GWF_Country::getByIDOrUnknown($g->getVar('group_country'))->displayName());
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();

echo $tVars['pagemenu'];

$buttons= GWF_Button::add($tLang->lang('btn_add'), $tVars['href_add']);
echo GWF_Button::wrap($buttons);
?>

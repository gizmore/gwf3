<?php
echo "New Sessions...<br/>\n";
GDO::table('GWF_Session')->createTable(true);

echo "Faster ModuleVars...<br/>\n";
$mv = GDO::table('GWF_ModuleVar');
if (false === GWF_ModuleLoader::renameColumn($mv, 'mv_moduleid', 'mv_mid')) {
	die('CANNOT RENAME COLUMN');
}
if (false === GWF_ModuleLoader::changeColumn($mv, 'mv_min', 'mv_min')) {
	die('CANNOT CHANGE COLUMN mv_min');
}
if (false === GWF_ModuleLoader::changeColumn($mv, 'mv_max', 'mv_max')) {
	die('CANNOT CHANGE COLUMN mv_max');
}

if (false === (GWF_ModuleLoader::addColumn($mv, 'mv_val'))) {
	die('SHOULD NOT HAPPEN 1');
}

if (false === ($result = $mv->select())) {
	die('SHOULD NOT HAPPEN 4');
}
while (false !== ($row = $mv->fetch($result, GDO::ARRAY_O)))
{
	$row->saveVar('mv_val', GWF_ModuleLoader::getVarValueMV($row->getVar('mv_value'), $row));
}
$mv->free($result);

echo "Naming sheme cleanup...<br/>\n";
GWF_ModuleLoader::loadModuleFS('Login')->onInclude();
$lf = GDO::table('GWF_LoginFailure');
GWF_ModuleLoader::renameColumn($lf, 'ip', 'logfail_ip');
GWF_ModuleLoader::renameColumn($lf, 'userid', 'logfail_uid');
GWF_ModuleLoader::renameColumn($lf, 'timestamp', 'logfail_time');
$lm = GDO::table('GWF_LangMap');
GWF_ModuleLoader::renameColumn($lm, 'countryid', 'langmap_cid');
GWF_ModuleLoader::renameColumn($lm, 'langid', 'langmap_lid');

#
echo "Module_PM changed a lot ... <br/>\n";
if (false !== ($mod_pm = GWF_ModuleLoader::loadModuleFS('PM')))
{
	$mod_pm->onInclude();
	require_once 'install23pm.php';
}

echo "Module_Category changed a lot, but was unused.... reinstall wipe<br/>\n";
if (false !== ($mod_cat = GWF_ModuleLoader::loadModuleFS('Category')))
{
	GWF_ModuleLoader::installModule($mod_cat, true);
}

echo "Module Flags have changed<br/>\n";
GDO::table('GWF_Module')->update('module_options=module_options|2', 'module_options&4');
GDO::table('GWF_Module')->update('module_options=module_options-4', 'module_options&4');

echo "Register tokens<br/>\n";
GWF_Module::loadModuleDB('Register')->onInclude();
GDO::table('GWF_UserActivation')->createTable(true);

echo "CORE: Counter<br/>\n";
$counter = GDO::table('GWF_Counter');
GWF_ModuleLoader::changeColumn($counter, 'key', 'count_key');
GWF_ModuleLoader::changeColumn($counter, 'value', 'count_value');


echo "Installing all modules... some might be gone.<br/>\n";
GWF_InstallFunctions::all_modules();

echo "WHOHO!<br/>\n";
?>
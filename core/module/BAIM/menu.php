<?php
function module_BAIM_menu()
{
//	require_once 'BAIM.php';
	if (false !== ($baim = GWF_Module::loadModuleDB('BAIM')))
	{
		$baim->onLoadLanguage();
		echo BAIM::displayMenu();
	}
}
?>
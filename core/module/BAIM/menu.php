<?php
function module_BAIM_menu()
{
//	require_once 'BAIM.php';
	if (false !== ($baim = GWF_Module::loadModuleDB('BAIM', true, true)))
	{
		$baim->onLoadLanguage();
		echo BAIM::displayMenu();
	}
}
?>
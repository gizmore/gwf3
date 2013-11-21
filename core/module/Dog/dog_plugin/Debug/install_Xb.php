<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <module> [<flush>]. Will (re)install and init a module.',
		'install' => 'Triggering install for %s.',
		'install_flush' => 'Dropping all tables and triggering install for %s.',
	),
	'de' => array(
		'help' => 'Nutze: %CMD% <Modul> [<flush>]. (Re)-Installiert und Initialisiert ein Modul.',
		'install' => 'Führe die Installationsroutinen für %s aus.',
		'install_flush' => 'Lösche und initialisiere Modul %s.',
	),
);

$plugin = Dog::getPlugin();
$argv = $plugin->argv();
$argc = count($argv);

$flush = false;
if ($argc === 2)
{
	$flush = ($argv[1] === 'flush') && (Dog::getUser()->getName() === 'gizmore');
	$argc = 1;
}

if ($flush)
{
	Dog::reply('FLUSH!');
}
else
{
	Dog::reply('NOFLUSH!');
}

return;

if ($argc !== 1)
{
	return $plugin->showHelp();
}

if (false === ($module = Dog_Module::getModule($argv[0])))
{
	return Dog::rply('err_module');
}

$plugin->rply($flush ? 'install_flush' : 'install', array($module->displayName()));

Dog_Init::installModule($module, $flush);
?>

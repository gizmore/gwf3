<?php # Usage: %CMD%. Flush all the bots lang files to trigger a reload.
$plugin = Dog::getPlugin();

$bot->onLoadLanguage();

foreach ($bot->getModules() as $module)
{
	$module instanceof Lamb_Module;
	$module->onLoadLanguage();
}

Dog::reply('Languge files have been flushed!');

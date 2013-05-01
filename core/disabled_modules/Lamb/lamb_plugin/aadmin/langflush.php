<?php # Usage: %CMD%. Flush all the bots lang files to trigger a reload.
$bot = Lamb::instance();

$bot->onLoadLanguage();

foreach ($bot->getModules() as $module)
{
	$module instanceof Lamb_Module;
	$module->onLoadLanguage();
}

$bot->reply('Languge files have been flushed!');
?>
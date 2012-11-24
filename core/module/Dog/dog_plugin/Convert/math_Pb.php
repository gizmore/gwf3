<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD% <expression>. Evaluate a mathematical expression and print results. Use _ and $ to referr to the last result.',
		'00' => '1 ... No ... 0 ... No ... UNDEFINED!',
		'err_in' => 'Error in expression.',
		'err_lib' => 'The "EvalMath" class by Miles Kaufmann is missing.',
	),
);

$plugin = Dog::getPlugin();

if ('' === ($message = $plugin->msg()))
{
	return $plugin->showHelp();
}

if (false !== ($last = Dog_Conf_Plug_User::getConf($plugin->getName(), Dog::getUID(), 'last', false)))
{
	$message = str_replace(array('_', '$'), $last, $message);
}

if ($message === '0^0')
{
	return $plugin->rply('00');
}

$path = GWF_PATH.'core/inc/3p/EvalMath.php';
if (!Common::isFile($path))
{
	return $plugin->rply('err_lib');
}
require_once $path;
$eval = new EvalMath();

if (false === ($result = $eval->e($message)))
{
	return $plugin->rply('err_in');
}

$result = sprintf('%.09f', $result);
if (strpos($result, '.') !== false )
{
	$result = rtrim($result, '0');
	$result = rtrim($result, '.');
}

Dog_Conf_Plug_User::setConf($plugin->getName(), Dog::getUID(), 'last', $result);

Dog::reply($result);
?>

<?php # Usage: %CMD% <expression>. Evaluate a math expression and print results.
$bot instanceof Lamb;
global $__p_math_old_result;
if (!isset($__p_math_old_result)) { $__p_math_old_result = 0; }
$message = str_replace(array('_', '$'), $__p_math_old_result, $message);

if ($message === '0^0')
{
	return $bot->reply('1 ... No ... 0 ... No ... UNDEFINED!');
}

$path = 'core/inc/3p/EvalMath.php';
if (!Common::isFile($path))
{
	return $bot->reply('EvalMath lib by Miles Kaufmann is missing.');
}

require_once $path;
$eval = new EvalMath();

if (false === ($result = $eval->e($message)))
{
	return $bot->reply('Error in expression.');
}

$result = sprintf('%.09f', $result);
if (strpos($result, '.') !== false )
{
	$result = rtrim($result, '0');
	$result = rtrim($result, '.');
}

$__p_math_old_result = $result;

$bot->reply($result);
?>

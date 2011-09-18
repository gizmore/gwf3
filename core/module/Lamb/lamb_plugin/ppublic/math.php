<?php # Usage: %CMD% <expression>. Evaluate a math expression and print results.
$bot instanceof Lamb;

if ($message === '0^0')
{
	return $bot->reply('1 ... no ... 0 ... no ... UNDEFINED!');
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
$bot->reply($result);
?>

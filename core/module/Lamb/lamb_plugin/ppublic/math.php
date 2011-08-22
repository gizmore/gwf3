<?php # Usage: %CMD% <expression>. Evaluate a math expression and print results.
$bot instanceof Lamb;
$path = 'core/inc/3p/EvalMath.php';
if (!Common::isFile($path)) {
	$bot->reply('EvalMath lib by Miles Kaufmann is missing.');
	return;
}
require_once $path;
$eval = new EvalMath();
if (false === ($result = $eval->e($message))) {
	$bot->reply('Error in expression.');
}
else {
	$result = sprintf('%.09f', $result);
	if (strpos($result, '.') !== false ) {
		$result = rtrim($result, '0');
		$result = rtrim($result, '.');
	}
	$bot->reply($result);
}
?>

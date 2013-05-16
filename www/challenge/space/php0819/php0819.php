<?php
// closure, because of namespace!
$challenge = function()
{
	$f = Common::getGetString('eval');
	$f = str_replace(array('`', '$', '*', '#', ':', '\\', '"', "'", '(', ')', '.', '>'), '', $f);

	if((strlen($f) > 13) || (false !== stripos($f, 'return')))
	{
		die('sorry, not allowed!');
	}

	try
	{
		eval("\$spaceone = $f");
	}
	catch (Exception $e)
	{
		return false;
	}

	return ($spaceone === '1337');
};
?>

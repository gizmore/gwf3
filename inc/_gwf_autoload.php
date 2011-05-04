<?php
function gwf3_autoload($classname)
{
	if (substr($classname, 0, 4) === 'GWF_')
	{
		require_once 'inc/util/'.$classname.'.php';
	}
} spl_autoload_register('gwf3_autoload');
?>
<?php
if (isset($_POST['filename']))
{
	if (is_string($_POST['filename']))
	{
		if (strpos($_POST['filename'], '`') !== false)
		{
			die('You may not use the ` char!');
		}
		if (strpos($_POST['filename'], '(') !== false)
		{
			die('You may not use the ( char!');
		}
	}
}
?>
<?php
function LVS_Secure($s)
{
	if (strpos($s, '$') !== false)
	{
		die('Jander says: Using the $ character is forbidden!');
	}
	if (strpos($s, '\\') !== false)
	{
		die('dloser says: Using the \\ character is forbidden!');
	}
	if (stripos($s, 'GWF') !== false)
	{
		die('dloser says: accessing GWF constants is forbidden!');
	}
	if (strpos($s, ':') !== false)
	{
		die('dloser says: The colon is a forbidden char.');
	}
	if (stripos($s, 'Common') !== false)
	{
		die('dloser says: Accessing the Common class is forbidden.');
	}
	if (stripos($s, 'include') !== false)
	{
		die('You may not use the include keyword!');
	}
	if (stripos($s, 'require') !== false)
	{
		die('You may not use the require keyword!');
	}
	if (stripos($s, 'eval') !== false)
	{
		die('You may not use the eval keyword!');
	}
	if (strpos($s, '`') !== false)
	{
		die('You may not use the ` char!');
	}
	if (strpos($s, '(') !== false)
	{
		die('You may not use the ( char!');
	}
	
}

if (isset($_POST['filename']))
{
	if (is_string($_POST['filename']))
	{
		LVS_Secure($_POST['filename']);
	}
}
?>
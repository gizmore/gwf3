<?php
require_once '../bootstrap.php';

function setup_chall($entry, $fullpath, $username)
{
	if ($entry === 'install_user.php')
	{
		$home = '/home/user/'.$username;
		require_once $fullpath;
	}
}

$username = $argv[1];

GWF_File::filewalker(GWF_CORE_PATH.'module/Audit/challs', 'setup_chall', true, true, $username);

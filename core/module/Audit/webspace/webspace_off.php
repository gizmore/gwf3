<?php
$username = $argv[1];
if (!unlink("/etc/apache2/vhosts.d/users/$username.conf"))
{
	die('cannot unlink your config!');
}
echo "Reloading apache2 config...\n";
system("/etc/init.d/apache2 reload");

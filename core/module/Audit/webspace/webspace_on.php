<?php
$username = $argv[1];

$content = <<< EOF
<VirtualHost *:80>
	ServerName %USERNAME%.users.warchall.net
	ServerAlias *.%USERNAME%.users.warchall.net
	AssignUserId %USERNAME% %USERNAME%
	LogLevel warn
	ErrorLog  /home/user/%USERNAME%/www_error.log
	CustomLog /home/user/%USERNAME%/www_access.log combined
	DocumentRoot /home/user/%USERNAME%/www
	<Directory "/home/user/%USERNAME%/www">
		Options FollowSymLinks Indexes
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>
EOF;

$dir = "/home/user/$username/www";
if (is_link($dir))
{
	die('Symlink attack anyone?');
}
if (is_file($dir))
{
	die('It´s a trap...err a file!');
}
if (!is_dir($dir))
{
	if (!mkdir($dir))
	{
		die('mkdir failed!');
	}
	if (!chmod($dir, 0700))
	{
		die('chmod failed!');
	}
	if (!chgrp($dir, $username))
	{
		die('chgrp failed!');
	}
	if (!chown($dir, $username))
	{
		die('chown failed!');
	}
}

$skeldir = dirname(__FILE__).'/skel';
foreach (scandir($skeldir) as $skel)
{
	if ($skel !== '.' && $skel !== '..')
	{
		$src = "$skeldir/$skel";
		$dest = "$dir/$skel";
		if (!is_file($dest))
		{
			chown($src, $username);
			chgrp($src, $username);
			chmod($src, 0700);
			rename($src, $dest);
			copy($dest, $src);
			file_put_contents($dest, str_replace(array('%USERNAME%'), array($username), file_get_contents($dest)));
		}
	}
}


$content = str_replace('%USERNAME%', $username, $content);

$filename2 = tempnam("/root", "wson$username");
if(!file_put_contents($filename2, $content)) { die('Cannot create .conf!'); }
if(!chmod($filename2, 0700)) { die('Cannot chmod temp.conf'); }
if(!chown($filename2, 'root')) { die('Cannot chown temp.conf'); }
if(!chgrp($filename2, 'root')) { die('Cannot chgrp temp.conf'); }

$filename = "/etc/apache2/vhosts.d/users/$username.conf";
if(!rename($filename2, $filename)) { die('Cannot move conf!'); }

echo "Reloading apache2 config...\n";
system("/etc/init.d/apache2 reload");
echo "Webserver should be available at $username.users.warchall.net!\n";
echo "It can take a moment for the changes to take effect :)\n";

<?php
$username = $argv[1];
unlink("/etc/apache2/vhosts.d/users/$username.conf");
system("/etc/init.d/apache2 reload");

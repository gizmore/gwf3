<?php
# Create a file OWNER.php to get super-duper-cow-powers with Dog.
# Default is your linux user.
$processUser = posix_getpwuid(posix_geteuid());
$whoami = $processUser['name'];
return array(
	$wohami.'{1}',
);

<?php
chdir(dirname(__FILE__));
$argv = array(
	'dogdev.php',
	'config_dog_dev.php', 'install', 'noflush', 'noimport', 'dev', 'gizmore'
);
require 'dog.php';

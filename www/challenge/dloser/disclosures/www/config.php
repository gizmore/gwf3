<?php
require '../secrets.php';
# GWF3
chdir('../../../../');
require 'protected/config.php';
require '../gwf3.class.php';
$gwf = new GWF3();

# DLDC
$dldc = 'challenge/dloser/disclosures/www/';
require $dldc.'lib.php';
require $dldc.'user.php';
require $dldc.'db.php';

register_shutdown_function('dldc_restore_db');

require $dldc.'challenge_quirks.php';

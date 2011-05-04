<?php
chdir('../../../');
require_once 'inc/util/GWF_Log.php';

GWF_Log::init('Guest', true, dirname(__FILE__).'/testlog');
GWF_Log::log('baim', 'THIS MC IS HACKED!');
?>
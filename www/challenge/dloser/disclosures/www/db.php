<?php
# WeChall DB
global $db1, $db2;

$db1 = GDO::getCurrentDB();
# Challenge DB
$db2 = gdo_db_instance(DLDC_DB_HOST, DLDC_DB_USER, DLDC_DB_PASS, DLDC_DB_NAME);
# Set to challenge db
GDO::setCurrentDB($db2);

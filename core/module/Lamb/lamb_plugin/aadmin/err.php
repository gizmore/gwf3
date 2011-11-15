<?php # Cause a PHP warning and a DB error to test logging.
# WARN
echo $foo;
# DB
$result = gdo_db()->queryFirst('ABLAB');
echo $result;
# FATAL
?>

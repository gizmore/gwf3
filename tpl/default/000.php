<?php
header($_SERVER['SERVER_PROTOCOL']." 404 Not Found"); 
echo GWF_HTML::err(GWF_HTML::lang('ERR_FILE_NOT_FOUND', array($tVars['file'])));
?>

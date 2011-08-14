<?php
header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
echo GWF_HTML::err(GWF_HTML::lang('ERR_FILE_NOT_FOUND', array($tVars['file'])));
?>

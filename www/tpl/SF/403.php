<?php
header($_SERVER['SERVER_PROTOCOL']." 403 Forbidden"); 
echo GWF_HTML::err(GWF_HTML::lang('ERR_FILE_NOT_FOUND', array($tVars['file'])));
?>
<h1>ERROR 403</h1>
<p>You don't have permission to view <?php echo htmlspecialchars($_SERVER["SERVER_NAME"] . $_SERVER['REDIRECT_URL']);?></p>
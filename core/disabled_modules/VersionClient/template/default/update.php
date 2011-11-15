<p><?php echo $tLang->lang('info_update', array( GWF_Time::displayDate($tVars['up_datestamp']), $tVars['up_token'], GWF_HTML::display($tVars['up_server']))); ?>

<?php
echo $tVars['form'];
?>
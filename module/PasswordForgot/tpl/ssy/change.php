<?php SSYHTML::$menuID = SSY_MENU_LOGIN; ?>
<?php echo SSYHTML::getBoxTitled($tLang->lang('pt_change'), $tLang->lang('info_change', array( $tVars['username']))); ?>
<?php echo $tVars['form']; ?>
<?php SSYHTML::$menuID = SSY_MENU_MAIN; ?>
<?php echo SSYHTML::getBoxTitled($tLang->lang('contact_title'), $tLang->lang('contact_info', array( $tVars['email']).$tVars['skype'])); ?>
<?php echo $tVars['form']; ?>
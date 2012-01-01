<?php SSYHTML::$menuID = SSY_MENU_LOGIN; ?>
<?php if (!$tVars['have_cookies']) { ?>
	<div><?php echo $tLang->lang('info_no_cookie'); ?></div>
<?php } ?>
<?php echo $tVars['form']; ?>

<?php echo GWF_Website::getBanners('login', 'all'); ?>
<?php if (!$tVars['have_cookies']) { ?>
	<div><?php echo $tLang->lang('info_no_cookie'); ?></div>
<?php } ?>
<?php echo $tVars['form']; ?>

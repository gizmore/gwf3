<?php if (!$tVars['have_cookies']) {
	echo GWF_Box::box($tLang->lang('info_no_cookie'));
}?>
<?php echo $tVars['form']; ?>

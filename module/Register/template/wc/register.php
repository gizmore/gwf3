<?php if (!$tVars['have_cookies']) { ?>
	<div class="box"><?php echo $tLang->lang('info_no_cookie'); ?></div>
<?php } ?>

<?php #echo GWF_Box::box('Just register with fake email. All emails that would have been sent are printed to the screen.<br/>If you get prompted for account data, use 1111222233334444 as Steuernummer, rest can be garbage.<br/>Missing:<br/>- Stats', 'ALPHA NOTE'); ?>


<div class="box">
<?php echo WC_HTML::lang('register_tos', GWF_WEB_ROOT.'wechall_license'); ?>
</div>

<?php echo $tVars['form'] ?>

<div class="box">
<?php echo WC_HTML::lang('register_forgot', GWF_WEB_ROOT.'recovery'); ?>
</div>

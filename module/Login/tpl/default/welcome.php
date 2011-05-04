<div class="box">
<div class="box_c">
<p>
	<?php if ($tVars['first_time']) { ?>
	<?php echo $tLang->lang('welcome', array( $tVars['username'])); ?>
	<?php } else { ?>
	<?php echo $tLang->lang('welcome_back', array( $tVars['username'])); ?>
	<?php } ?>
</p>

<?php
if (false !== ($ll = $tVars['last_login']))
{
	$ll instanceof GWF_LoginHistory;
	echo '<br/><p>'.$tLang->lang('msg_last_login', array( $ll->displayDate(), $ll->displayIP(), $ll->displayHostname(), $tVars['href_history'])).'</p>'.PHP_EOL;
}

if ($tVars['fails'] > 0)
{
	echo '<br/><b style="font-weight:bolder; color:#E00;"><p>'.$tVars['module']->error('err_failures', $tVars['fails']).'</b></p>'.PHP_EOL;
}
?>
</div>
</div>

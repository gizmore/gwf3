<p><?php echo $tVars['lang']->lang('pay_info'); ?></p>
<?php if ($tVars['user']->isAdmin()) { ?>
	<p><?php echo $tVars['lang']->lang('pay_info_a'); ?></p>
<?php }?>
<?php
echo $tVars['order'];
?>
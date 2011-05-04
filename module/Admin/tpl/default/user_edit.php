<?php echo $tVars['form']; ?>
<div class="gwf_buttons_outer">
<div class="gwf_buttons">
	<a href="<?php echo $tVars['href_login_as']; ?>"><?php echo $tLang->lang('btn_login_as2', array( $tVars['user']->displayUsername())); ?></a>
	<a href="<?php echo $tVars['href_user_groups']; ?>"><?php echo $tLang->lang('btn_user_groups', array( $tVars['user']->displayUsername())); ?></a>
</div>
</div>

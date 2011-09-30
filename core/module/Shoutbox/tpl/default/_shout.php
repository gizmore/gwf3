<?php GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/Shoutbox/gwf_shoutbox.js'); ?>
<div>
	<form action="<?php echo $tVars['form_action']; ?>" method="post">
		<?php echo GWF_CSRF::hiddenForm('SHOUTBOX'); ?>
		<?php if ($tVars['captcha']) { ?>
		<div><?php echo $tVars['captcha']; ?><input type="text" name="captcha" id="captcha" size="5" value="" /></div>
		<?php } ?>
		<div>
			<input type="text" name="message" size="32" id="gwf_shoutmsg" />
			<input type="submit" name="shout" value="<?php echo $tLang->lang('btn_shout'); ?>" onclick="gwfShout(); return false;" />
		</div>
	</form>
</div>

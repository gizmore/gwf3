<?php GWF_Website::addJavascript($tVars['module']->getJSPath('gwf_shoutbox.js')); ?>
<div>
	<form action="<?php echo $tVars['form_action']; ?>" method="post">
		<div>
			<input type="text" name="message" size="32" id="gwf_shoutmsg" />
			<input type="submit" name="shout" value="<?php echo $tLang->lang('btn_shout'); ?>" onclick="gwfShout(); return false;" />
		</div>
	</form>
</div>

<?php if (!$tVars['have_cookies']) { ?>
	<div><?php echo GWF_HTML::error('Register', $tLang->lang('info_no_cookie'), false); ?></div>
<?php } ?>


<div  class="fl">
	<div><?php echo $tVars['form'] ?></div>
	<div class="gwf_buttons ce"><div>
		<div class="ib">
			<div class="ib"><?php echo GWF_Button::generic($tLang->lang('btn_login'), GWF_WEB_ROOT.'login'); ?></div>
			<div class="ib"><?php echo GWF_Button::generic($tLang->lang('btn_recovery'), GWF_WEB_ROOT.'recovery'); ?></div>
		</div>
		<div class="cb"></div>
	</div></div>
</div>


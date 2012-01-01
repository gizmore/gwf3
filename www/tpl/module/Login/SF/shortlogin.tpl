<form action="/login" method="post" enctype="application/x-www-form-urlencoded" class="gwf_shortform">
	<fieldset>
	<label for="lf_username">{$lang->lang('th_username')}</label><input size="10" id="lf_username" type="text" name="username" value="">
	<label for="lf_password">{$lang->lang('th_password')}</label><input size="10" id="lf_password" type="password" name="password" value="">
	<label for="lf_bind_ip">{$lang->lang('th_bind_ip')}<img class="gwf_tooltip" src="/img/default/lightbulb.png" alt="ToolTip" title="{$lang->lang('tt_bind_ip')}" onclick="alert('{$lang->lang('tt_bind_ip')}');" /></label><input id="lf_bind_ip" type="checkbox" name="bind_ip" checked="checked"value="">
	<input type="submit" name="login" value="{$lang->lang('btn_login')}">
	<input type="hidden" name="gwfcsrf" value="{$token}">
	</fieldset>
</form>
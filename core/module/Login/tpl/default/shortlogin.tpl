<form action="/login" method="post" enctype="application/x-www-form-urlencoded" class="gwf_shortform">
	<fieldset>
		<ul>
			<li><label for="lf_username">{$lang->lang('th_username')}</label><input id="lf_username" type="text" name="username" value=""></li>
			<li><label for="lf_password">{$lang->lang('th_password')}</label><input id="lf_password" type="password" name="password" value=""></li>
			<li><label for="lf_bind_ip">{$lang->lang('th_bind_ip')}<img class="gwf_tooltip" src="/img/default/lightbulb.png" alt="ToolTip" title="{$lang->lang('tt_bind_ip')}" onclick="alert('{$lang->lang('tt_bind_ip')}');" /></label><input id="lf_bind_ip" type="checkbox" name="bind_ip" checked="checked"value=""></li>
			<li><input type="submit" name="login" value="{$lang->lang('btn_login')}"></li>
			<li style="display: none;"><input type="hidden" name="gwfcsrf" value="{$token}"></li>
		</ul>
	</fieldset>
</form>
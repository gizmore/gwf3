<div id="gwf_login_form">
{$form}
</div>
{if $register || $recovery}
<div class="gwf_buttons_outer">
	{if $register}{button type='generic' url="{$root}register" text=$lang->lang('btn_register')}{/if}
	{if $recovery}{button type='generic' url="{$root}recovery" text=$lang->lang('btn_recovery')}{/if}
</div>
{/if}

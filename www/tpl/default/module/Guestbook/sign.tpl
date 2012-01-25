{if isset($in_reply)}
<div class="gwf_gb_entry">
	<div>
		<div class="gwf_date">{$in_reply->displayDate()}</div>
		<div>{$in_reply->displayUsername()}</div>
		{if $module->cfgAllowEmail()}<div>{$in_reply->displayEMail($can_mod)}</div>{/if}
		{if $module->cfgAllowURL()}<div>{$in_reply->displayURL()}</div>{/if}
	</div>
	<hr/>
	<div>{$in_reply->displayMessage()}</div>
</div>
{/if}
{$form}

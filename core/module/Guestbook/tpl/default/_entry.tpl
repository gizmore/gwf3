<div class="gwf_gb_entry">
	<div class="gwf_gbe_head">
		<div class="gwf_date">{$e->displayDate()}</div>
		<div>{$e->displayUsernameLink()}</div>
		{if $allow_email}<div>{$e->displayEMail($can_moderate)}</div>{/if}
		{if $allow_url}<div>{$e->displayURL()}</div>{/if}
	</div>
	<div class="gwf_gbe_msg">{$e->displayMessage()}</div>
{if $can_moderate}
	<div class="gwf_gbe_foot">
		<div class="gwf_buttons_outer"><div class="gwf_buttons">
		{$e->getToggleModButton($module)}
		{$e->getTogglePublicButton($module)}
		{$e->getEditButton($module)}
		</div></div>
	</div>
{/if}
</div>{*gb_entry*}

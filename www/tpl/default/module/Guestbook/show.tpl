<h1>{$btn_edit}{$gb->displayTitle()}</h1>
<h2>{$gb->displayDescr()}</h2>

{$page_menu}

{foreach $entries as $e}
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
{/foreach}

{$page_menu}

{if $can_sign}
<div class="gwf_buttons_outer gwf_buttons">
{GWF_Button::reply($href_sign, $lang->lang('btn_sign', array( $gb->displayTitle())))}
</div>
{/if}
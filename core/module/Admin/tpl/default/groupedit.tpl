{$form}

{$form_add}

{$pagemenu}

<div class="gwf_table"><table>
{$headers}

{foreach $userids as $userid}
	{if false === GWF_User::getByID($userid)}
		{assign var="u" value="{GWF_Guest::getGuest()}"}
	{else}
		{assign var="u" value="{GWF_User::getByID($userid)}"}
	{/if}
	<tr>
	{GWF_Table::column($u->displayProfileLink())}
	{GWF_Table::column(GWF_Button::delete( $module->getMethodURL('GroupEdit', "&rem={$userid}&gid={$gid}"), $lang->lang('btn_rem_from_group') ))}
	</tr>
{/foreach}
</table></div>

{$pagemenu}

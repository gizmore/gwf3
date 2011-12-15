{$form}

{$form_add}

{$pagemenu}

<div class="gwf_table"><table>
{$headers}

	{assign var="gid" value={$group->getID()}}
{foreach $userids as $userid}
	<tr>
	{if false === GWF_User::getByID($userid)}
		{GWF_Table::column(GWF_Guest::getGuest()->displayProfileLink())}
	{else}
		{GWF_Table::column(GWF_User::getByID($userid)->displayProfileLink())}
	{/if}
	{GWF_Table::column(GWF_Button::delete( $module->getMethodURL('GroupEdit', "&rem={$userid}&gid={$gid}"), $lang->lang('btn_rem_from_group') ))}
	</tr>
{/foreach}
</table></div>

{$pagemenu}

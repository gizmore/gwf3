<table class="gwf_table">
	<tr>
		<th>{$lang->lang('th_id')}</th>
		<th>{$lang->lang('th_name')}</th>
		<th>{$lang->lang('th_count')}</th>
		{*<th>{$lang->lang('th_groups')}</th>*}
		<th>{$lang->lang('th_edit')}</th>
		<th>{$lang->lang('th_delete')}</th>
		<th>{$lang->lang('th_multiaction')}</th>
	</tr>
{foreach $navigations as $n}
	{GWF_Table::rowStart()}
		<td>{$n->getID()}</td>
		<td>{$n->displayName()}</td>
		<td>{$n->getCount()}</td>
		{*<td>{$n->displayGroups()}</td>*}
		<td>{button type="edit" url=$n->hrefEdit() title=$lang->lang('btn_edit')}</td>
		<td>{button type="delete" url=$n->hrefDelete() title=$lang->lang('btn_delete')}</td>
		<td><input type="checkbox" name="navis_id[]" value="{$n->displayName()}"></td>
	</tr>
{/foreach}
</table>

<div class="gwf_buttons gwf_buttons_outer">
{button type="add" url="{$root}navigation/admin/add" text=$lang->lang('btn_add') title=$lang->lang('btn_add')}
</div>

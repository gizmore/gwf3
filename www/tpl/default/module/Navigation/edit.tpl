<div class="gwf_table">
<table>
	<tr>
		<td>{$lang->lang('th_id')}</td>
		<td>{$lang->lang('th_name')}</td>
		<td>{$lang->lang('th_count')}</td>
		{*<td>{$lang->lang('th_groups')}</td>*}
	</tr>
	<tr>
		<td class="gwf_num">{$navigations->getID()}</td>
		<td class="gwf_num">{$navigations->displayName()}</td>
		<td>{$navigations->getCount()}</td>
		{*<td>{$navigations->displayGroups()}</td>*}
	</tr>
</table>

<br><br><br>
<!-- TODO: margin -->
</div>
{* TODO: displayed in Sitenav, language*}
<div class="gwf_table">
<table>
{GWF_Table::displayHeaders1(array(
	array($lang->lang('th_id'), 'page_id', 'DESC'),
	array($lang->lang('th_position'), 'navi_position', 'ASC'),
	array($lang->lang('th_change_position')),
	array($lang->lang('th_title'), 'page_title', 'ASC'),
	array($lang->lang('th_url'), 'page_url', 'ASC'),
	array($lang->lang('th_hide_show')),
	array($lang->lang('th_delete')),
	array($lang->lang('btn_edit')),
	array($lang->lang('th_multiaction'))
), $sort_url)}

{foreach $navigation as $n}
	{GWF_Table::rowStart()}
		<td class="gwf_num">{$n->getID()}</td>
		<td class="gwf_num"><input type="text" size="1" name="position" value="{$n->getPosition()}"></td>
		<td>{button type="up" url=$n->hrefUp($navigations->getID()) title=$lang->lang('btn_up')}{button type="down" url=$n->hrefDown($navigations->getID()) title=$lang->lang('btn_down')}</td>
		<td>{$n->displayTitle()}</td>
		<td>{$n->displayURL()}</td>
{if $n->isVisible()}
		<td>{button type="delete" url=$n->hrefHide({$navigations->getID()}) title=$lang->lang('btn_hide')}</td>
{else}
		<td>{button type="add" url=$n->hrefShow({$navigations->getID()}) title=$lang->lang('btn_show')}</td>
{/if}
		<td>{button type="delete" url=$n->hrefDelete() title=$lang->lang('btn_delete')}</td>
		<td>{button type='edit' url=$n->hrefPageEdit() title=$lang->lang('btn_edit')}</td>
		<td><input type="checkbox" name="navi_id[]" value="{$n->getID()}"></td>
	</tr>
{/foreach}
</table>
</div>
<br><br><br>
<div class="gwf_table">
<table>
{GWF_Table::displayHeaders1(array(
	array($lang->lang('th_id'), 'page_id', 'DESC'),
	array($lang->lang('th_otherid'), 'page_otherid', 'ASC'),
	array($lang->lang('th_lang'), 'page_lang', 'ASC'),
	array($lang->lang('th_title'), 'page_title', 'ASC'),
	array($lang->lang('th_multiaction')),
	array($lang->lang('btn_edit'))
), $sort_url)}
{foreach $pages as $page}
{* TODO: if not in navi *}
	{GWF_Table::rowStart()}
		<td class="gwf_num">{$page->getID()}</td>
		<td class="gwf_num">{$page->getOtherID()}</td>
		<td>{$page->displayLang()}</td>
		<td>{button url=$page->hrefShow() title=$page->display('page_title') text=$page->display('page_title')}</td>
		<td><input name="page_id[]" type="checkbox" value="$page->getID()"></td>
		<td>{button type='edit' url=$page->hrefEdit() title=$lang->lang('btn_edit')}</td>
	</tr>
{/foreach}
</table>
</div>

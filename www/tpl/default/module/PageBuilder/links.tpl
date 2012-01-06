<table class="gwf_table">
	<tr>
		<th>URL</th>
		<th>HREF</th>
		<th>DELETE</th>
	</tr>
{foreach $links as $link}
	<tr>
		<td>{$link['link_url']}</td>
		<td>{$link['link_href']}</td>
		<td><a href="{$root}PageBuilder/Links/delete/{$link['link_url']}">{$lang->lang('delete')}</a></td>
	</tr>
{/foreach}
</table>

{$form->templateY($lang->lang('btn_add_link'), "{$root}PageBuilder/Links")}
